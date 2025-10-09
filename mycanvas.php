<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  ini_set('max_input_vars', '5000'); //add by ample 20-04-20
  include('classes/config.php');
  $page_id = '6';
  $obj = new frontclass();
  $obj2 = new frontclass2();
  $page_data = $obj->getPageDetails($page_id);
  $ref = base64_encode($page_data['menu_link']);
  if(!$obj->isLoggedIn())
  {
  $obj->doUpdateOnline($_SESSION['user_id']);
  //echo "<script>window.location.href='user_dashboard.php'</script>";
  header("Location: login.php?ref=".$ref);
  exit();
  }
  else {
  $user_id = $_SESSION['user_id'];
  $obj->doUpdateOnline($_SESSION['user_id']);
  }  
  $user_my_day_today_data = $obj->getMyDayTodayData($user_id,date("Y-m-d",strtotime($_GET['mdt_date'])),$_GET['sequence']); 
  $header_data = $obj->GetHeaderDatabyPage(6);
  $now = time();
  $today_year = date("Y",$now);
  $today_month = date("m",$now);
  $today_day = date("d",$now); 
  $year = $today_year;
  $month = $today_month;
  $day = $today_day;
  $day_month_year = date("Y-m-d");
  // echo '<pre>';
  // print_r($user_my_day_today_data);
  // echo "--header---";
  // print_r($header_data);
  // echo '</pre>';
  // die();

  $data_dropdown=$obj->get_data_dropdown_by_id('86');
  $final_dropdown=$obj->get_text_from_data_dropdown($data_dropdown);

  // echo "<pre>";
  // print_r($data_dropdown);
  // echo "<pre>";
  // print_r($final_dropdown);
  // die('---');
  
  if(isset($_POST['submit']))
  { 
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    //  die('terst-scr');
    $success=false;
    $preview_id=$obj->saveMycanvasPreviewData($user_id,$_GET['sequence'],$_GET['mdt_date'],$_POST['preview_data']);
    $mdt_date = $_GET['mdt_date'];
    $sequence = $_GET['sequence'];
    
//new code write by ample 06-05-20
    if(!empty($_POST['data']))
    {
      foreach ($_POST['data'] as $key1 => $value1) {
          if(!empty($value1['subdata']))
          {
            foreach ($value1['subdata'] as $key2 => $value2) {



                  $maintab=$value1['heading'];
                  $subtab=$value2['heading'];

                  $level_title = $value2['level_title'];
                  $level_icon = $value2['level_icon'];
                  $level_icon_type = $value2['level_icon_type'];
                  if(is_array($value2['activity_text']))
                  { 
                  for($i=0 ;$i<=count($value2['activity_text']);$i++)
                  {
                      $sub_cat=$value2['sub_cat'][$i];
                      $prof_cat=$value2['prof_cat'][$i];
                      $canv_show_fetch=$value2['canv_show_fetch'][$i];
                      $canv_sub_cat_link = $value2['canv_sub_cat_link'][$i];
                      $activity_text =$value2['activity_text'][$i];
                      $activity_id =$value2['activity_id'][$i] ?? 0;
                     
                      $comment=isset($value2['comment'][$i]) && $value2['comment'][$i]!='' ? trim($value2['comment'][$i]) : '';
                      $location=isset($value2['location'][$i]) && $value2['location'][$i]!='' ? $value2['location'][$i] : '';
                      $User_view=isset($value2['User_view'][$i]) && $value2['User_view'][$i]!='' ? $value2['User_view'][$i] : '';
                      $User_Interaction=isset($value2['User_Interaction'][$i]) && $value2['User_Interaction'][$i]!='' ? $value2['User_Interaction'][$i] : '';
                      $alert=isset($value2['alert'][$i]) && $value2['alert'][$i]!='' ? $value2['alert'][$i] : '';  

                        if(!empty($location) || !empty($User_view) || !empty($User_Interaction) || !empty($alert) || !empty($comment) )
                        {   
                             //update by ample 19-02-20
                           $res=$obj->AddmyCanvas($comment,$location,$User_view,$User_Interaction,$alert,$activity_text,$activity_id,$canv_sub_cat_link,$canv_show_fetch,$prof_cat,$sub_cat,$maintab,$subtab,$mdt_date,$sequence,$user_id,$level_title,$level_icon,$level_icon_type,$preview_id);
                        
                           if($res==true)
                           {
                              $success=true;
                           }
                        } 

                  }
                }
                
            }
          }
      }
    }
//comment by ample 06-05-20
  // for($i=0 ;$i<count($_POST['comment']);$i++)
  // {
  // $comment=isset($_POST['comment'][$i]) && $_POST['comment'][$i]!='' ? trim($_POST['comment'][$i]) : '';
  // $location=isset($_POST['location'][$i]) && $_POST['location'][$i]!='' ? $_POST['location'][$i] : '';
  // $User_view=isset($_POST['User_view'][$i]) && $_POST['User_view'][$i]!='' ? $_POST['User_view'][$i] : '';
  // $User_Interaction=isset($_POST['User_Interaction'][$i]) && $_POST['User_Interaction'][$i]!='' ? $_POST['User_Interaction'][$i] : '';
  // $alert=isset($_POST['alert'][$i]) && $_POST['alert'][$i]!='' ? $_POST['alert'][$i] : '';   
  // $activity_text = isset($_POST['activity_text'][$i]) && $_POST['activity_text'][$i]!='' ? $_POST['activity_text'][$i] : '';
  // $activity_id = isset($_POST['activity_id'][$i]) && $_POST['activity_id'][$i]!='' ? $_POST['activity_id'][$i] : '';
  // $canv_sub_cat_link = isset($_POST['canv_sub_cat_link'][$i]) && $_POST['canv_sub_cat_link'][$i]!='' ? $_POST['canv_sub_cat_link'][$i] : '';
  // $canv_show_fetch=isset($_POST['canv_show_fetch'][$i]) && $_POST['canv_show_fetch'][$i]!='' ? $_POST['canv_show_fetch'][$i] : '';
  // $prof_cat=isset($_POST['prof_cat'][$i]) && $_POST['prof_cat'][$i]!='' ? $_POST['prof_cat'][$i] : '';  
  // $sub_cat=isset($_POST['sub_cat'][$i]) && $_POST['sub_cat'][$i]!='' ? $_POST['sub_cat'][$i] : '';
  // $maintab=isset($_POST['maintab'][$i]) && $_POST['maintab'][$i]!='' ? $_POST['maintab'][$i] : '';
  // $subtab=isset($_POST['subtab'][$i]) && $_POST['subtab'][$i]!='' ? $_POST['subtab'][$i] : '';
  // $level_title = isset($_POST['level_title'][$i] ) && $_POST['level_title'][$i]!='' ? $_POST['level_title'][$i] : '';
  // $level_icon = isset($_POST['level_icon'][$i] ) && $_POST['level_icon'][$i]!='' ? $_POST['level_icon'][$i] : '';
  // $level_icon_type = isset($_POST['level_icon_type'][$i] ) && $_POST['level_icon_type'][$i]!='' ? $_POST['level_icon_type'][$i] : '';
  // //update by ample 18-02-20
  // if(!empty($location) || !empty($User_view) || !empty($User_Interaction) || !empty($alert) || !empty($comment) )
  // {   
  //   //update by ample 19-02-20
  //    $res=$obj->AddmyCanvas($comment,$location,$User_view,$User_Interaction,$alert,$activity_text,$activity_id,$canv_sub_cat_link,$canv_show_fetch,$prof_cat,$sub_cat,$maintab,$subtab,$mdt_date,$sequence,$user_id,$level_title,$level_icon,$level_icon_type,$preview_id);
  //    if($res==true)
  //    {
  //       $success=true;
  //    }
  //    //die('submit');
  // }
  // }
   if($success)
   {
      $response_msg='<div class="alert alert-success">
                      <strong>Success!</strong> Data Save Successfully.
                    </div>';
  
      $_SESSION["preview_id"] = $preview_id;

          //change by 06-05-20
          header("Location:mycanvas-result.php");
          exit();
  
      // echo "<script>
      //      setTimeout(function(){
      //         window.location.href = 'mycanvas-result.php';
      //      }, 500);
      //   </script>";
   }
   else
   {
  
    $obj->deleteMycanvasPreviewData($preview_id);
    $response_msg='<div class="alert alert-danger">
                      <strong>Error!</strong> choose right options.
                    </div>';
    unset($_SESSION['preview_id']);
   }
  
   // print_r($res);
   //   die('sgfjh');
  // return $res;
  // $response = array("status"=>'success',"error_code"=>'1');
  // echo json_encode($response) ;
  // exit(0);
  //echo $success;
  }
  
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('head.php');?>
    <!-- <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css"> -->
    <!-- <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script> -->
    <!-- <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script> -->
    <style>
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
      -webkit-transition: all .2s cubic-bezierr(.15,.69,.83,.67);
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
      /*  bhoechie tab */
      div.bhoechie-tab-container{
      z-index: 10;
      background-color: #ffffff;
      padding: 0 !important;
      border-radius: 4px;
      -moz-border-radius: 4px;
      border:1px solid #ddd;
      margin-top: 20px;
      -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
      box-shadow: 0 6px 12px rgba(0,0,0,.175);
      -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
      background-clip: padding-box;
      opacity: 0.97;
      filter: alpha(opacity=97);
      }
      div.bhoechie-tab-menu{
      padding-right: 0;
      padding-left: 0;
      padding-bottom: 0;
      }
      div.bhoechie-tab-menu div.list-group{
      margin-bottom: 0;
      }
      div.bhoechie-tab-menu div.list-group>a{
      margin-bottom: 0;
      }
      div.bhoechie-tab-menu div.list-group>a .glyphicon,
      div.bhoechie-tab-menu div.list-group>a .fa {
      color: #5A55A3;
      }
      div.bhoechie-tab-menu div.list-group>a:first-child{
      border-top-right-radius: 0;
      -moz-border-top-right-radius: 0;
      }
      div.bhoechie-tab-menu div.list-group>a:last-child{
      border-bottom-right-radius: 0;
      -moz-border-bottom-right-radius: 0;
      }
      div.bhoechie-tab-menu div.list-group>a.active,
      div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
      div.bhoechie-tab-menu div.list-group>a.active .fa{
      background-color: #5A55A3;
      background-image: #5A55A3;
      color: #ffffff;
      }
      div.bhoechie-tab-menu div.list-group>a.active:after{
      content: '';
      position: absolute;
      left: 100%;
      top: 50%;
      margin-top: -13px;
      border-left: 0;
      border-bottom: 13px solid transparent;
      border-top: 13px solid transparent;
      border-left: 10px solid #5A55A3;
      }
      div.bhoechie-tab-content{
      background-color: #ffffff;
      /*padding-left: 20px;*/
      padding-top: 10px;
      }
      div.bhoechie-tab div.bhoechie-tab-content:not(.active){
      display: none;
      }
      .tabbable{
      font-size: 14px !important;
      line-height: 1.9;
      }
      .input-text-box{
      height: 35px;
      font-size: 12px !important;
      }
    </style>
    <!--add by ample 16-12-19-->
    <style type="text/css">
      .page-title-1
      {
      font-size: 20px;
      margin:15px 0;
      background: #c6d286;
      padding: 10px 5px;
      }
      .page-title-2
      {
      font-size: 17px;
      margin:7.5px 0;
      padding: 7.5px 2.5px;
      background: #fbd49a;
      }
      .page-title-3
      {
      font-size: 13px;
      margin:5px 0;
      }
      /* write by ample 05-05-20*/
      .scrollable-section
      {
      padding: 5px;
      overflow-y: auto;
      max-height: 325px;
      }
    </style>
  </head>
  <body>
    <?php //include_once('analyticstracking.php'); ?>
    <?php //include_once('analyticstracking_ci.php'); ?>
    <?php // include_once('analyticstracking_y.php'); ?>
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
          <span id="response_msg"><?=$response_msg;?></span>
          <span id="error_msg"></span>
          <div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">
            <div class="row">
              <div class="col-md-9">
                <div class="col-md-12" id="testdata">
                  <?php if($page_data['page_icon']!='') { ?>
                  <img src="uploads/<?php echo $page_data['page_icon']; ?>" style="width:128px; height: 128px;">
                  <?php } ?>
                  <!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);?></span></h2>-->
                  <?php echo $obj->getPageContents($page_id);?>
                </div>
              </div>
              <div class="col-md-3">
                <div class='' style="margin-bottom:25px;margin-top: 50px">
                  <br><br><br>
                  <div id='change_avatar' class="text-center"></div>
                  <br style="clear: both;">
                  <?php 
                    // add by ample 16-12-19  
                    
                    foreach ($header_data as $key => $value) {
                    
                      if($value['level']==0)
                      {
                        $value['level']="";
                      }
                    
                    ?>
                  <br>
                  <div class="pull-right col-md-12">
                    <p>
                      <?=($value['level_heading'])? $value['level_heading'].'-'.$value['level'] : '' ;?>  
                    </p>
                    <p>
                      <?=($value['level_title_heading'])? $value['level_title_heading'].'-'.$value['level_title'] : '' ;?> 
                    </p>
                    <?php if($value['level_icon']!='') { 
                      if($value['level_icon_type']=='Image')
                      {   
                      
                          $imgData=$obj->getImgData($value['level_icon']);
                          if(!empty($imgData['image']))
                          {   
                              ?>
                    <div class="text-center">
                      <img src="uploads/<?php echo $imgData['image']; ?>" style="width:35px; height: 35px;" title="<?=$value['level_icon_heading'];?>">
                    </div>
                    <?php
                      }
                      }
                      else
                      {   
                      $fileData=$obj->getFileData($value['level_icon']);
                      ?>
                    <a href="<?php echo SITE_URL.'/uploads/'. $fileData['banner'];?>" target="_blank"><?php echo $fileData['banner'];?></a> 
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
            <div class="row">
              <div class="col-md-9">
                <!-- add by 07-07-20-->
                <div class="col-md-6">
                    <p>
                      <?=($data_dropdown['level_title'])? $data_dropdown['level_title'] : '' ;?>  
                   
                    <?php if($data_dropdown['level_icon']) 
                    { 
                      if($data_dropdown['level_icon_type']=='Image')
                      {   
                      
                          $imgData=$obj->getImgData($data_dropdown['level_icon']);
                          if(!empty($imgData['image']))
                          {   
                              ?>
                           
                              <img src="uploads/<?php echo $imgData['image']; ?>" style="width:55px; height: 55px;" title="<?=$data_dropdown['prof_cat1_heading'];?>" data-toggle="modal" data-target="#boxModal">
                            
                            <?php
                           }
                      }
                      else
                      {   
                        $fileData=$obj->getFileData($data_dropdown['level_icon']);
                        ?>
                        <a href="<?php echo SITE_URL.'/uploads/'. $fileData['banner'];?>" target="_blank"><?php echo $fileData['banner'];?></a> 
                      <?php
                      }
                      ?>
                    <?php 
                  }
                    else
                    {
                      ?>
                      <button class="btn btn-default" data-toggle="modal" data-target="#boxModal" title="<?=$data_dropdown['prof_cat1_heading'];?>">?</button>
                      <?php
                    }
                    ?>
                     </p>
                    <br>
                  </div>

                  <div class="col-md-6" style="text-align: right;margin-top: 25px;">
                    <a href="reset_mood.php?page_id=<?=$page_id;?>" target="_blank" ><button type="button" class="btn btn-danger btn-sm" style="border-radius: 0;">Reset Mood</button></a>
                      <?php //echo base64_encode()?>
                  </div>
                  
                  <div class="clearfix" style="clear: both;"></div>

                <form name="frm" id="frm" method="post">
                  <?php 
                  $data=array();
                    for($k=0;$k<count($user_my_day_today_data);$k++) { ?>
                  <h3 class="page-title-1"> <?php echo $user_my_day_today_data[$k]['bms_name']; ?></h3>
                  <!--add by ample 06-05-20 -->
                  <input type="hidden" name="data[<?=$k;?>][heading]"  value="<?php echo $user_my_day_today_data[$k]['bms_name']; ?>">
                  <!--comment by ample 12-05-20 -->
                  <!-- <?php 
                    // add by ample 20-01-20
                    //$bms_keywords=$obj->find_keyword_by_bms_name($user_my_day_today_data[$k]['bms_name']);
                    
                      if($bms_keywords)
                      {
                        //echo '<b>Keywords : </b>' .$bms_keywords;
                      }
                     ?> -->
                  <?php for($j=0;$j<count($header_data);$j++) { ?>
                  <h4 class="page-title-2"><i class="fa fa-hand-o-right"></i>  <?php echo $header_data[$j]['heading']; ?></h4>
                   <!--add by ample 06-05-20 -->
                  <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][heading]"  value="<?php echo $header_data[$j]['heading']; ?>">
                  <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][level_title]"  value="<?php echo $header_data[$j]['level_title'];?>">
                  <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][level_icon]"  value="<?php echo $header_data[$j]['level_icon'];?>">
                  <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][level_icon_type]"  value="<?php echo $header_data[$j]['level_icon_type'];?>">

                  <?php 
                    //echo $header_data[$j]['heading'];
                    
                    
                    $keyworddata_implode_data = array();
                    
                    $keyword = $user_my_day_today_data[$k]['bms_name'];


                    $keyword_filter=preg_replace("/^'|[^A-Za-z0-9\'-]|'$/", ' ', $keyword); //add by ample 11-05-20
                    
                     $keyworddata_explode = explode(' ',$keyword_filter);
                    
                     $exclusion_name = $obj->getExclusionAllName('Page','6'); //update by ample 11-05-20

                    
                     $have_data=0;
                    
                     if($header_data[$j]['location_show']!=0)
                    
                        {
                    
                           $location_show_icon = $obj->getMyDayTodayIcon('location_show'); 
                    
                        }
                    
                        else {
                    
                            $location_show_icon = '';
                    
                        }
                    
                    
                    
                         if($header_data[$j]['User_view']!=0)
                    
                        {
                    
                           $User_view_icon = $obj->getMyDayTodayIcon('User_view'); 
                    
                        }
                    
                        else {
                    
                            $User_view_icon = '';
                    
                        }
                    
                    
                    
                         if($header_data[$j]['User_Interaction']!=0)
                    
                        {
                    
                           $User_Interaction_icon = $obj->getMyDayTodayIcon('User_Interaction'); 
                    
                        }
                    
                        else {
                    
                            $User_Interaction_icon = '';
                    
                        }
                    
                    
                    
                        if($header_data[$j]['alert_show']!=0)
                    
                        {
                    
                           $alert_show_icon = $obj->getMyDayTodayIcon('alert_show'); 
                    
                        }
                    
                        else {
                    
                            $alert_show_icon = '';
                    
                        }
                    
                    
                    
                        if($header_data[$j]['comment_show']!=0)
                    
                        {
                    
                           $comment_show_icon = $obj->getMyDayTodayIcon('comments_show'); 
                    
                        }
                    
                        else {
                    
                            $comment_show_icon = '';
                    
                        }
                    
                    
                    
                      $keyworddata_filter = array_filter($keyworddata_explode);
                    
                    
                      for($i=0;$i<count($keyworddata_filter);$i++)
                    
                           {  


                    
                             if(!in_array(strtolower($keyworddata_filter[$i]),$exclusion_name)) 
                    
                               {
                    
                                $keyworddata_implode_data[]= $keyworddata_filter[$i];
                    
                               }
                    
                           }


                           $keyworddata_implode_data = array_filter($keyworddata_implode_data); //add by ample 28-08-20
                           $keyworddata_implode_data = array_values($keyworddata_implode_data); //add by ample 28-08-20
                    
                                          
                          if($header_data[$j]['sub_cat1'] !='') 
                    
                          {
                    
                    
                    
                              $fetch_show = $header_data[$j]['canv_sub_cat1_show_fetch'];
                    
                             
                    
                              if($fetch_show == 2)
                    
                              {
                    
                    
                    
                                //$fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat1_link'],$header_data[$j]['sub_cat1']);
                    
                                // code by ample 18-12-19
                                $sub_cat = explode(',', $header_data[$j]['sub_cat1']);
                                $prof_cat_tbl=$header_data[$j]['canv_sub_cat1_link'];
                                $prof_cat_col=$header_data[$j]['prof_cat1_ref_code'];
                                $cat_uid=$header_data[$j]['prof_cat1_uid'];
                                //$cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                                //new condition add by ample 19-05-20
                                // if($header_data[$j]['special_key1']==1)
                                // {
                                //   $fetch_data=$cat_data;
                                // }
                                // else
                                // {
                                //   $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);
                                // }
                                 //new condition add by ample 21-05-20
                                if($header_data[$j]['special_key1']==1)
                                {
                                  $special_refer=$header_data[$j]['special_ref_code1'];
                                  $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid,$special_refer,$keyword);
                                  $fetch_data=$cat_data;
                                }
                                else
                                {
                                  $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                                  $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);
                                }

                    
                                  //add by ample 05-05-20
                                    $fetch_data = array_diff($fetch_data, array($keyword));
                                    $fetch_data = array_values( $fetch_data );



                    
                                if(!empty($fetch_data)){
                    
                                         $have_data=1;                                              
                    
                                        echo '<div class="scrollable-section">';
                    
                                        $loop=0;
                    
                                        foreach($fetch_data  as $value)
                    
                                        {
                    
                                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat1_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat1_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                                                // echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
                                                //update by ample
                                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat1_'.$k.'_'.$j.'_'.$loop.'">'.$value.'</p>';
                                              
                                                
                                            if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<br/><img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" id="comment_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '';
                    
                    
                    
                    ?>
                  <div class="md-col-12 loop_id" data-id="<?php echo 'sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat1']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat1']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat1_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat1_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                    <!--comment by ample 18-01-20-->
                    <!-- <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> -->
                    <!--add by ample 18-01-20 & update 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                     }
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat1']);
                    
                                                            // echo '<pre>';
                    
                                                            //  echo "----fetch_data--";
                    
                                                            // print_r($show_data);
                    
                                                            // echo '</pre>';
                    
                    if(!empty($show_data)){
                    $have_data=1;
                    
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat1_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat1_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat1_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                            
                    
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat1']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat1']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat1_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat1_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                    <!--update by ample 06-05-20 -->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    }
                    
                    echo '</div>';
                    
                    }
                    
                    } 
                    
                    }
                    
                    
                    
                    if($header_data[$j]['sub_cat2'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat2_show_fetch'];
                    
                    
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    //$fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat2_link'],$header_data[$j]['sub_cat2']);                
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat2']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat2_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat2_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat2_uid'];
                    // $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    // $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data); 
                    //new condition 21-05-20
                     if($header_data[$j]['special_key2']==1)
                      {
                        $special_refer=$header_data[$j]['special_ref_code2'];
                        $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid,$special_refer,$keyword);
                        $fetch_data=$cat_data;
                      }
                      else
                      {
                        $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                        $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);
                      }
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );
                            
                    
                    if(!empty($fetch_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat2_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat2_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat2_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" id="comment_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat2']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat2']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat2_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat2_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat2']);
                    
                    
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat2_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat2_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat2_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" id="comment_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat2']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat2']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat2_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat2_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                   <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    
                    
                    
                    
                    }
                    
                    
                    
                    
                    if($header_data[$j]['sub_cat3'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat3_show_fetch'];
                    
                    //echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    //$fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat3_link'],$header_data[$j]['sub_cat3']);                  
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat3']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat3_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat3_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat3_uid'];
                    // $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    // $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);  
                    //new condition 21-05-20
                     if($header_data[$j]['special_key3']==1)
                      {
                        $special_refer=$header_data[$j]['special_ref_code3'];
                        $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid,$special_refer,$keyword);
                        $fetch_data=$cat_data;
                      }
                      else
                      {
                        $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                        $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);
                      } 
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );                                                     
                    
                    if(!empty($fetch_data))
                    
                    {
                    
                    $have_data=1;
                    
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat3_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat3_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat3_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat3']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat3']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat3_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat3_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                   
                   <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat3']);
                    
                    
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat3_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat3_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat3_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat3']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat3']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat3_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat3_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_text']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    //echo '</div>';
                    
                    
                    
                    }
                    
                    
                    
                    if($header_data[$j]['sub_cat4'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat4_show_fetch'];
                    
                    //echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    //$fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat4_link'],$header_data[$j]['sub_cat4']);            
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat4']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat4_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat4_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat4_uid'];
                    $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);   
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );                                                         
                    
                    if(!empty($fetch_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat4_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat4_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat4_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat4']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat4']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat4_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat4_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">

                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat4']);
                    
                    
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat4_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat4_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat4_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat4']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat4']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat4_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat4_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_text']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_name']; ?>">

                   <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    //echo '</div>';
                    
                    
                    
                    }
                    
                    
                    
                    if($header_data[$j]['sub_cat5'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat5_show_fetch'];
                    
                    //echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    //$fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat5_link'],$header_data[$j]['sub_cat5']);             
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat5']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat5_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat5_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat5_uid'];
                    $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);     
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );                                                      
                    
                    if(!empty($fetch_data))
                    
                    {
                    
                    $have_data=1;
                    
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat5_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat5_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat5_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat5']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat5']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat5_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat5_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                    
                     <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat5']);
                    
                    
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat5_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat5_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat5_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>">
                   <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat5']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat5']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat5_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat5_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                     <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    //echo '</div>';
                    
                    
                    
                    }
                    
                    
                    
                    if($header_data[$j]['sub_cat6'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat6_show_fetch'];
                    
                    //echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    // $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat6_link'],$header_data[$j]['sub_cat6']);                                                                        
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat6']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat6_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat6_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat6_uid'];
                    $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );
                    
                    if(!empty($fetch_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat6_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat6_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat6_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat6']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat6']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat6_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat6_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                    
                     <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat6']);
                    
                    
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat6_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat6_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat6_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>">
                   <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat6']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat6']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat6_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat6_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                     <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    //echo '</div>';
                    
                    
                    
                    }
                    
                    
                    
                    if($header_data[$j]['sub_cat7'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat7_show_fetch'];
                    
                    //echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    // $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat7_link'],$header_data[$j]['sub_cat7']);     
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat7']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat7_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat7_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat7_uid'];
                    $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);   
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );                                                         
                    
                    if(!empty($fetch_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat7_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat7_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat7_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat7']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat7']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat7_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat7_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                    
                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat7']);
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat7_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat7_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat7_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat7']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat7']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat7_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat7_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    //echo '</div>';
                    
                    
                    
                    }
                    
                    
                    
                    if($header_data[$j]['sub_cat8'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat8_show_fetch'];
                    
                    // echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    // $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat8_link'],$header_data[$j]['sub_cat8']);   
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat8']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat8_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat8_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat8_uid'];
                    $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);  
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );                                                       
                    
                    if(!empty($fetch_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat8_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat8_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat8_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat8']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat8']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat8_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat8_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                    
                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat8']);
                    
                    
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat8_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat8_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat8_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>">
                   <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat8']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat8']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat8_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat8_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                     <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    // echo '</div>';
                    
                    
                    
                    }
                    
                    
                    
                    if($header_data[$j]['sub_cat9'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat9_show_fetch'];
                    
                    //echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    //$fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat9_link'],$header_data[$j]['sub_cat9']);               
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat9']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat9_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat9_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat9_uid'];
                    $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);     
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );                                                    
                    
                    if(!empty($fetch_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat9_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat9_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat9_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat9']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat9']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat9_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat9_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                    
                     <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat9']);
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat9_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat9_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat9_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat9']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat9']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat9_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat9_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">

                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    //echo '</div>';
                    
                    
                    
                    }
                    
                    
                    
                    
                    if($header_data[$j]['sub_cat10'] !='') 
                    
                    {
                    
                    $fetch_show = $header_data[$j]['canv_sub_cat10_show_fetch'];
                    
                    //echo '<div style="border:1px solid #ccc; padding:5px;">';
                    
                    if($fetch_show == 2)
                    
                    {
                    
                    //$fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat10_link'],$header_data[$j]['sub_cat10']);                 
                    
                    // code by ample 18-12-19
                    $sub_cat = explode(',', $header_data[$j]['sub_cat10']);
                    $prof_cat_tbl=$header_data[$j]['canv_sub_cat10_link'];
                    $prof_cat_col=$header_data[$j]['prof_cat10_ref_code'];
                    $cat_uid=$header_data[$j]['prof_cat10_uid'];
                    $cat_data=$obj->getDataFromReportCustomized($sub_cat,$prof_cat_tbl,$prof_cat_col,$cat_uid);
                    $fetch_data=$obj->filter_data_by_keywords($cat_data,$keyworddata_implode_data);     
                    
                    //add by ample 05-05-20
                    $fetch_data = array_diff($fetch_data, array($keyword));
                    $fetch_data = array_values( $fetch_data );                                                  
                    
                    if(!empty($fetch_data))
                    
                    {
                    
                    $have_data=1;
                    
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($fetch_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat10_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat10_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat10_'.$k.'_'.$j.'_'.$loop.'">'.$value;
                    
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat10']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat10']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat10_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat10_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="">
                   
                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    }
                    
                    if($fetch_show == 1)
                    
                    {
                    
                    $show_data =  $obj->getcategorynamebyid($header_data[$j]['sub_cat10']);
                    
                    
                    
                    if(!empty($show_data))
                    
                    {
                    $have_data=1;
                    echo '<div class="scrollable-section">';
                    
                    $loop=0;
                    
                    foreach($show_data as $value)
                    
                    {
                    
                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat10_'.$k.'_'.$j.'_'.$loop.'\',\''.$comment_show_icon.'\',\''.$location_show_icon.'\',\''.$User_view_icon.'\',\''.$User_Interaction_icon.'\',\''.$alert_show_icon.'\');" id=icon_sub_cat10_'.$k.'_'.$j.'_'.$loop.'></i></span>';
                    
                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN" id="sub_cat10_'.$k.'_'.$j.'_'.$loop.'">'.$value['activity_name'];
                    
                    if($comment_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop; ?>" id="comment_show_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($location_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop; ?>" id="location_show_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_view_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop; ?>" id="User_view_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($User_Interaction_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop; ?>" id="User_Interaction_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } ?>
                  <?php if($alert_show_icon!='') { ?>
                  &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop; ?>" id="alert_show_icon_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>');">
                  <?php } 
                    echo '</p>';
                    
                    
                    
                    ?>
                  <div class="md-col-12" data-id="<?php echo 'sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>">
                    <!--add by ample 06-05-20 -->
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][sub_cat][]"  value="<?php echo $header_data[$j]['sub_cat10']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][prof_cat][]"  value="<?php echo $header_data[$j]['prof_cat10']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_show_fetch][]"  value="<?php echo $header_data[$j]['canv_sub_cat10_show_fetch']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][canv_sub_cat_link][]"  value="<?php echo $header_data[$j]['canv_sub_cat10_link']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_text][]"  value="<?php echo $value['activity_name']; ?>">
                    <input type="hidden" name="data[<?=$k;?>][subdata][<?=$j;?>][activity_id][]"  value="<?php echo $value['activity_id']; ?>">


                    <!-- update by ample 06-05-20-->
                    <?php 
                    if($comment_show_icon!='') { ?>
                    <textarea name="data[<?=$k;?>][subdata][<?=$j;?>][comment][]" id="comment_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> </textarea>
                    <?php } ?>
                    <?php 
                    if($location_show_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width location-box" name="data[<?=$k;?>][subdata][<?=$j;?>][location][]" id="location_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($User_view_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_view" name="data[<?=$k;?>][subdata][<?=$j;?>][User_view][]" id="User_view_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                     <?php 
                    if($User_Interaction_icon!='') { ?>
                    <select  class="input-text-box input-quarter-width user_interaction" name="data[<?=$k;?>][subdata][<?=$j;?>][User_Interaction][]" id="User_Interaction_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                      <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                    <?php 
                    if($alert_show_icon!='') { ?>
                    <select class="input-text-box input-quarter-width alert-box" name="data[<?=$k;?>][subdata][<?=$j;?>][alert][]" id="alert_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" data-id="<?php echo 'sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>">
                      <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                      <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                    </select>
                    <?php } ?>
                  </div>
                  <?php
                    $loop++;
                    
                    } 
                    
                    echo '</div>';
                    
                    }
                    
                    
                    }
                    
                    //echo '</div>';
                    
                    }
                    
                    if($have_data==0)
                    {
                    echo "Sorry, No data available now!";
                    }
                    
                    ?>
                  <!-- </form> -->
                  <!--                                                <div class="tab-pane fade" id="sub12">
                    <p>Tab 1.2</p>
                    
                    </div>-->
                  <!-- <input type="submit" name="submit" value="submit" style="display: none;">  -->
                  <!--  </form> -->
                  <?php } ?>
                  <?php } ?>
                  <textarea name="preview_data" id="preview_data" style="display: none;"></textarea>
                  <input type="submit" id="" name="submit" style="margin: 10px 5px;"  class="btn-red" onclick="sendFormData();" value="ACT NOW">
                </form>
                <!-- Proceed to design my life -->
                <!-- <input type="button" class="btn-light-green" value="Evaluate more TAB options" name="moreoptions" id="moreoptions_<?php echo $k.'_'.$j; ?>" onclick="moreoptionstab('<?php echo $k.'_'.$j; ?>');" style="display:none;"> -->
              </div>
              <div class="col-md-3">
                <hr>
                <h3>To do list</h3>
                <hr>
                <div class="show_data" id="show_data1">
                </div>
                <div class="show_data" id="show_data2">
                </div>
                <div class="show_data" id="show_data3">
                </div>
                <div class="show_data" id="show_data4">
                </div>
                <div class="show_data" id="show_data5">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <?php include_once('right_sidebar.php'); ?>
          </div>
        </div>
      </div>
    </section>
    <div id="confirm" class="modal hide fade">
      <div class="modal-body">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>


    <!-- Modal -->
<div id="boxModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=$data_dropdown['prof_cat1_heading'];?></h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th><?=$data_dropdown['prof_cat1_heading'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if($final_dropdown)
              {
                foreach ($final_dropdown as $key => $value) {
                   ?>
                   <tr>
                     <td><?=$value;?></td>
                   </tr>
                   <?php
                }
              }
              else
              {
                ?>
                <tr>
                     <td>No example found</td>
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




    <?php include_once('footer.php');?> 
    <script>
      $(document).ready(function() {
      
      $("ul.nav-tabs a").click(function (e) {
      
      e.preventDefault();  
      
      $(this).tab('show');
      
      });
      
      
      
      
      
      
      });
      
    </script>
    <script>
      function submitAllform()
      {
        // alert('test');
        // $('.commonForm').submit();
        // $('form').each(function() {
        //   var that = $(this);
        //   $.post(that.attr('action'), that.serialize());
        // });
      }
      
      
      
      function sendFormData()
      
      {
      
            var html1=$('#show_data1').html();
            var html2=$('#show_data2').html();
            var html3=$('#show_data3').html();
            var html4=$('#show_data4').html();
            var html5=$('#show_data5').html();
            var html = html1 + html2 + html3 + html4 + html5;
      
            $('#preview_data').val(html);
      
            var formData = new FormData($('#frm')[0]); 
      
            jQuery.ajax({
      
            url:'mycanvas.php',
      
            type: "POST",
      
            data: formData,
      
            processData: false,
      
            contentType: false,
      
            success: function(result)
      
            {  
       
                if(result)
                          {
                            $('#response_msg').html('<div class="alert alert-success"><strong>Success!</strong></div>');
                          }
                          else
                          {
                            $('#response_msg').html('<div class="alert alert-danger"><strong>Error!</strong></div>');
                          }
                          $('html, body').animate({
                          scrollTop: $("#response_msg").offset().top
                          }, 1000);
                          setTimeout(function(){
                              location.reload();
                          }, 2500);  
            },
            error: function(xhr){
                console.log(xhr)
                alert('try later');
            }
      
            });
      
      }
      
      
      
      function proceeddmlpage(id)
      
      {
      
      window.location.href="design-my-life.php";  
      
      }
      
      
      
      function moreoptionstab(id)
      
      {
      
      $("#proceeddml_"+id).hide();
      
      $("#moreoptions_"+id).hide(); 
      
      }
      

      
      function ShowTime(id)
      
      {
      
      //alert(id);
      
      $('#bes_time_'+id).show();  
      
      }
      
      
      
      function ShowDuration(id)
      
      {
      
      //alert("hiiii");
      
      $('#duration_'+id).show();  
      
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
        $('#alert_'+id).trigger("change"); 
      
      }
      
      
      
      function ShowUserInteraction(id)
      
      {
      
      //alert("hiiii");
      
      $('#User_Interaction_'+id).show();  
      $('#User_Interaction_'+id).trigger("change"); 
      
      }
      
      
      
      function ShowUserview(id)
      
      {
      
      //alert("hiiii");
      
      $('#User_view_'+id).show();  
      $('#User_view_'+id).trigger("change");
      }
      
      
      
      function ShowComment(id)
      
      {
      
      //alert("hiiii");
      
      $('#comment_'+id).show();  
      
      }
      
      
      
      function icon_show(id)
      
      {
      
      var bes_name = $("#bes_id_"+id).val();
      
      $('.dlist').show();  
      
      $('#icon_show_'+id).show(); 
      
      var dataString ='bes_name='+bes_name +'&action=getbescomment';
      
      $.ajax({
      
      type: "POST",
      
      url: 'my_day_today.php', 
      
      data: dataString,
      
      cache: false,
      
      success: function(result)
      
      {
      
      //   alert(result);
      
      $('#comment_backend_'+id).html(result);
      
      }
      
      });
      
      }
      
      
      
      function viewpost()
      
      {
      
      //alert('hiiii'); 
      
      $('#sequence_show').show();  
      
      $('#sequence').hide();  
      
      }
      
      
      
      function changeClass(id)
      
      {
      
      //var tab1primary_id = 'tab1primary_'+id;
      
      // alert(tab1primary_id);
      
      // $("#"+tab1primary_id).closest('div').removeClass('tab-pane fade active in').addClass('tab-pane fade');
      
      //$("#tab1primary_0_1").removeClass('tab-pane fade');
      
      $("#tab1primary_0_1").addClass('tab-pane fade active in');
      
      }
      
      
      //update by ample 20-04-20
      //function Showloop(id)
      function Showloop(id,comment_show,location_show,User_view,User_Interaction,alert_show)
      {
          //comment by ample 20-04-20
          // $("#comment_show_icon_"+id).show(); 
          // $("#location_show_icon_"+id).show(); 
          // $("#User_view_icon_"+id).show(); 
          // $("#User_Interaction_icon_"+id).show(); 
          // $("#alert_show_icon_"+id).show(); 
      
          $('#icon'+id).css("color", "#38c536"); //add by ample 20-04-20
      
          //add by ample 20-04-20
          $("#comment_show_icon_"+id).hide(); 
          $("#location_show_icon_"+id).hide(); 
          $("#User_view_icon_"+id).hide(); 
          $("#User_Interaction_icon_"+id).hide(); 
          $("#alert_show_icon_"+id).hide(); 
      
          //add by ample 20-04-20
          if(alert_show)
          {
             $('#alert_'+id).show();  
             $('#alert_'+id).trigger("change");
          }
         
          if(location_show)
          {
            $('#location_'+id).show();  
            $('#location_'+id).trigger("change");
          }
          
          if(User_Interaction)
          {
            $('#User_Interaction_'+id).show();  
            $('#User_Interaction_'+id).trigger("change");
          }
          
          if(User_view)
          {
              $('#User_view_'+id).show();  
              $('#User_view_'+id).trigger("change"); 
          }
         
          if(comment_show)
          {
            $('#comment_'+id).show();  
          }
          
      
      
      }
      
      function ShowAlert(id)
      
      {
      
      //alert("hiiii");
        $('#alert_'+id).show();  
        $('#alert_'+id).trigger("change");
      
      }
      
      function ShowLocation(id)
      
      {
      
      //alert("hiiii");
      
      $('#location_'+id).show();  
      $('#location_'+id).trigger("change");
      
      }
      
      
      function ShowUserInteraction(id)
      
      {
      
      //alert("hiiii");
      
      $('#User_Interaction_'+id).show();  
      $('#User_Interaction_'+id).trigger("change");
      
      }
      
      
      
      function ShowUserview(id)
      
      {
      
      //alert("hiiii");
      
      $('#User_view_'+id).show();  
      $('#User_view_'+id).trigger("change"); 
      }
      
      
      
      function ShowComment(id)
      
      {
      
      //alert("hiiii");
      
      $('#comment_'+id).show();  
      
      
      }
      
      
      
      function isNumberKey(evt){  <!--Function to accept only numeric values-->
      
      //var e = evt || window.event;
      
      var charCode = (evt.which) ? evt.which : evt.keyCode
      
      if (charCode != 46 && charCode > 31 
      
      && (charCode < 48 || charCode > 57))
      
      return false;
      
      return true;
      
      }
      
      
      
      function change_tab(idval)
      
      {
      
      $(".list-group-item").removeClass("active");
      
      $("#list_group_tab_"+idval).addClass("active"); 
      
      
      
      $(".bhoechie-tab-content").removeClass("active");
      
      $("#sub_cat_"+idval).addClass("active");
      
      
      
      }
      
      
      
      function change_main_tab(idval)
      
      {
          
          $('.nav-tabs .active').removeClass('active');
          
          $('#nav_'+idval).addClass('active');
              
          $('.tab-content .active').removeClass('active in');
      
          $('#main_'+idval).addClass('active in');
          
          $('#main_'+idval+' .list-group').children(':first').addClass('active');
          
          $('#sub_cat_'+idval+'_0').addClass('active');
      }
      
      
        // RHS dynamically data showing code
        // alertList = [];
        // $('#alert__sub_cat1_0_0_0 option').each(function() {
        //     alertList.push($(this).text())
        // });
        var array = {};
      
          $(".alert-box").on("change", function(){ 
      
            var ID = $(this).parent().data('id');
            //var ID = $(this).attr('data-id');
      
            alertList = [];
          $('#alert__'+ID+' option').each(function() {
              alertList.push($(this).text())
          });
      
            var head = $('#alert__'+ID+" option:selected").text().trim();
            var sub = $('#'+ID).text().trim();
      
            var i;
            var change = false;
            var changeIndex = '';
            for (i = 0; i < alertList.length; i++) {
                var text=alertList[i];
                if ( typeof array[text] !== 'undefined' && array[text].length > 0 ) {
                  $.each(array[text], function( index, value ) {
                    if (value == sub) {
                      change = true;
                      changeIndex = text;
                    }
                  });
                }
            }
            if ( typeof array[head] !== 'undefined' ) {
              if (change) {
                array[changeIndex] = $.grep(array[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array[head].push(sub);
            } else {
              if (change) {
                array[changeIndex] = $.grep(array[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array[head] = new Array(sub);
            }
      
            var html = '';
            if ( typeof array !== 'undefined' && Object.keys(array).length > 0) {
              $.each(array, function( index, value ) {
                html += '<div>';
                  if (value.length > 0) {
                      html += '<p><strong>'+index+'</strong></p>';
                      html += '<ol>';
                    $.each(value, function( key, key_value ) {
                      html += '<li>'+key_value+'</li>';
                    });
                    html += '</ol>';
                  }
                html += '</div>';
      
                if (html !== '') {
                  $('#show_data1').html(html);;
                }
      
              });
            }
          });
      
         
        var array2 = {};
      
          $(".user_view").on("change", function(){ 
             var ID = $(this).parent().data('id');
      
            userList = [];
            $('#User_view__'+ID+' option').each(function() {
                userList.push($(this).text())
            });
      
            var head = $('#User_view__'+ID+" option:selected").text().trim();
            var sub = $('#'+ID).text().trim();
      
            var i;
            var change = false;
            var changeIndex = '';
            for (i = 0; i < userList.length; i++) {
                var text=userList[i];
                if ( typeof array2[text] !== 'undefined' && array2[text].length > 0 ) {
                  $.each(array2[text], function( index, value ) {
                    if (value == sub) {
                      change = true;
                      changeIndex = text;
                    }
                  });
                }
            }
      
            if ( typeof array2[head] !== 'undefined' ) {
              if (change) {
                array2[changeIndex] = $.grep(array2[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array2[head].push(sub);
            } else {
              if (change) {
                array2[changeIndex] = $.grep(array2[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array2[head] = new Array(sub);
            }
            
            var html = '';
            if ( typeof array2 !== 'undefined' && Object.keys(array2).length > 0) {
              $.each(array2, function( index, value ) {
                html += '<div>';
                  if (value.length > 0) {
                    html += '<p><strong>'+index+'</strong></p>';
                    html += '<ol>';
                    $.each(value, function( key, key_value ) {
                      html += '<li>'+key_value+'</li>';
                    });
                    html += '</ol>';
                  }
                html += '</div>';
      
                if (html !== '') {
                  $('#show_data2').html(html);;
                }
      
              });
            }
          });
      
         
        var array3 = {};
      
          $(".user_interaction").on("change", function(){ 
             var ID = $(this).parent().data('id');
      
              intersectList = [];
              $('#User_Interaction__'+ID+' option').each(function() {
                  intersectList.push($(this).text())
              });
      
            var head = $('#User_Interaction__'+ID+" option:selected").text().trim();
            var sub = $('#'+ID).text().trim();
      
            var i;
            var change = false;
            var changeIndex = '';
            for (i = 0; i < intersectList.length; i++) {
                var text=intersectList[i];
                if ( typeof array3[text] !== 'undefined' && array3[text].length > 0 ) {
                  $.each(array3[text], function( index, value ) {
                    if (value == sub) {
                      change = true;
                      changeIndex = text;
                    }
                  });
                }
            }
      
            if ( typeof array3[head] !== 'undefined' ) {
              if (change) {
                array3[changeIndex] = $.grep(array3[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array3[head].push(sub);
            } else {
              if (change) {
                array3[changeIndex] = $.grep(array3[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array3[head] = new Array(sub);
            }
            
            var html = '';
            if ( typeof array3 !== 'undefined' && Object.keys(array3).length > 0) {
              $.each(array3, function( index, value ) {
                html += '<div>';
                  if (value.length > 0) {
                      html += '<p><strong>'+index+'</strong></p>';
                      html += '<ol>';
                    $.each(value, function( key, key_value ) {
                      html += '<li>'+key_value+'</li>';
                    });
                    html += '</ol>';
                  }
                html += '</div>';
      
                if (html !== '') {
                  $('#show_data3').html(html);;
                }
      
              });
            }
          });
      
      
        
        var array4 = {};
      
          $(".location-box").on("change", function(){ 
            var ID = $(this).parent().data('id');
      
            locationList = [];
            $('#location__'+ID+' option').each(function() {
                locationList.push($(this).text())
            });
      
            var head = $('#location__'+ID+" option:selected").text().trim();
            var sub = $('#'+ID).text().trim();
      
            var i;
            var change = false;
            var changeIndex = '';
            for (i = 0; i < locationList.length; i++) {
                var text=locationList[i];
                if ( typeof array4[text] !== 'undefined' && array4[text].length > 0 ) {
                  $.each(array4[text], function( index, value ) {
                    if (value == sub) {
                      change = true;
                      changeIndex = text;
                    }
                  });
                }
            }
      
            if ( typeof array4[head] !== 'undefined' ) {
              if (change) {
                array4[changeIndex] = $.grep(array4[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array4[head].push(sub);
            } else {
              if (change) {
                array4[changeIndex] = $.grep(array4[changeIndex], function(value) {
                  return value != sub;
                });
              }
              array4[head] = new Array(sub);
            }
            
            var html = '';
            if ( typeof array4 !== 'undefined' && Object.keys(array4).length > 0) {
              $.each(array4, function( index, value ) {
                html += '<div>';
                  if (value.length > 0) {
                      html += '<p><strong>'+index+'</strong></p>';
                      html += '<ol>';
                    $.each(value, function( key, key_value ) {
                      html += '<li>'+key_value+'</li>';
                    });
                    html += '</ol>';
                  }
                html += '</div>';
      
                if (html !== '') {
                  $('#show_data4').html(html);;
                }
      
              });
            }
          });
      // add by ample 14-02-20
        // function savePreviewData()
        // {   
      
        //     var user_id='<?=$user_id?>';
        //     var mdt_date='<?=$_GET['mdt_date'];?>';
        //     var sequence='<?=$_GET['sequence'];?>';
      
        //     var html1=$('#show_data1').html();
        //     var html2=$('#show_data2').html();
        //     var html3=$('#show_data3').html();
        //     var html4=$('#show_data4').html();
        //     var html5=$('#show_data5').html();
      
        //     var html = html1 + html2 + html3 + html4 + html5;
      
        //     // console.log(html);
        //     // alert(html); return false;
      
        //     var dataString ='action=saveCanvasPreview&user_id='+user_id+'&mdt_date='+mdt_date+'&sequence='+sequence+'&html='+html;
        //       $.ajax({
        //           type: "POST",
        //           url: 'remote.php', 
        //           data: dataString,
        //           cache: false,
        //           success: function(result)
        //                {
        //                   if(result)
        //                   {
        //                     $('#response_msg').html('<div class="alert alert-success"><strong>Success!</strong></div>');
        //                   }
        //                   else
        //                   {
        //                     $('#response_msg').html('<div class="alert alert-danger"><strong>Error!</strong></div>');
        //                   }
        //                   $('html, body').animate({
        //                   scrollTop: $("#response_msg").offset().top
        //                   }, 1000);
        //                   setTimeout(function(){
        //                       location.reload();
        //                   }, 2500);  
        //               },
        //           errror: function()
        //           {
        //             alert('Try later');
        //           }
        //          });
      
        // }
      
    </script>
  </body>
</html>