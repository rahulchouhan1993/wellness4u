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
$day_month_year_theams = date("Y-m-d");

if(isset($_POST['btnSubmit']))  

{
   $data = array();
   $data = $_POST;
//   echo '<pre>';
//   print_r($data);
//   echo '<pre>';
   //die();
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



if(isset($_REQUEST['action']) && $_REQUEST['action'] =='changtheammdt')
    {        
        $theam_id = stripslashes($_REQUEST['theam_id']);
        $_SESSION['mdttheam_id'] = $theam_id;
        $response = array();
        list($image,$color_code) = $obj->getTheamDetailsMDT($theam_id);
        $output = $image.'::'.$color_code;
        $response['image'] = $image;
        $response['color_code'] = $color_code;
        $response['error'] = 0;
        echo json_encode(array($response));
        exit(0);    
    }
else if(isset($_REQUEST['action']) && $_REQUEST['action'] =='ChangeTheMusic')
    {        
        $music_id1 = $_REQUEST['music_id1'];
       
        $music = $obj2->getMusicNameByid($music_id1);
       
       echo $option.='<audio autoplay loop>
        <source src="uploads/'.$music.'" /> 
        <source src="uploads/'.$music.'" /> 
        </audio>';
       exit(0);
    }
else if(isset($_REQUEST['action']) && $_REQUEST['action'] =='ChangeTheAvatar')
    {        
        $avat_id = $_REQUEST['avat_id'];
       
        $image = $obj2->getAvatarNameByid($avat_id);
       
       echo $option.='<img src="uploads/'.stripslashes($image).'" height="50px;" width="50px;" title="My Today\'s Mascot">';
       exit(0);
    }
else if(isset($_REQUEST['action']) && $_REQUEST['action'] =='getbescomment')
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
    
    $data_dropdown = $obj->GETDATADROPDOWNMYDAYTODAY('423','45');
    $arr_cert_cnt = array(0);
    $arr_cert_total_cnt = array(1);
    
//    echo '<pre>';
//    print_r($data_dropdown);
//    echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">
<head>    
    <?php include_once('head.php');?>
    <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">
    <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>
    <style>
        .ui-datepicker-header {
        display:none!important;
      }
    </style>
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
                    
                    <div class="col-md-8" id="bgimage" style="background-repeat:repeat; padding:5px;">
                       
                        <div class="col-md-12">
                        <!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);?></span></h2>-->
                        <?php echo $obj->getPageContents($page_id);?>
                        </div>
                        <form role="form" class="form-horizontal" id="frmdaily_meal" name="frmdaily_meal" enctype="multipart/form-data" method="post"> 
                            <?php if($error){ ?>
                                <span style="color:red;"><?php echo $err_msg; ?></span>
                            <?php } ?>
                            <div class='col-md-12' style="margin-bottom:20px;">
                            <div class="col-md-4">
                                <span style="font-size:15px;" class="Header_brown">Reset your Mood</span>
                                <select name="theam_id1" id="theam_id" onchange="ChangeTheamMDT()" class="form-control" title="Select Theme">
                                <option>Select Theme</option>
                                <?php echo $obj->getTheamOptions($theam_id,$day_month_year_theams); ?>
                            </select>
                            </div>
                            
                            <div class="col-md-4">
                                
                                <span style="font-size:15px; font-weight: bold;" class="Header_brown"><br></span>
                                <select name="music_id1" id="music_id" onchange="ChangeTheMusic()" class="form-control" title="Select Music">
                                <option>Select Music</option>
                                <?php echo $obj2->getAllmusic($music_id,$day); ?>
                            </select>
                            </div>
                            
                            <div class="col-md-4">
                                <span style="font-size:15px; font-weight: bold;" class="Header_brown"><br></span>
                                <select name="avat_id" id="avat_id" onchange="ChangeTheAvatar()" class="form-control" title="Select your today's mascot">
                                <option>Select your today's mascot</option>
                                <?php echo $obj2->getAllAvatar($avat_id,$day); ?>
                            </select>
                            </div>
                        </div>
                        
                        <div class='col-md-5' style="margin-bottom:20px;">
                            <span style="font-size:15px;" class="Header_brown">Build your path</span>
                            <input type="text" required="" name="day_month_year" id="day_month_year" placeholder="Select Date" class="form-control" autocomplete="off" onchange="GETSEQUENCE();">
                        </div>
                        <div class='col-md-5' style="margin-bottom:20px;">
                            <span style="font-size:15px; font-weight: bold; display:none;" id="sequence_label" class="Header_brown">Sequence</span>
                            <?php $sequence = ($_SESSION['sequence'] > 0 ? $_SESSION['sequence'] : 1); ?>
                            
                            <input type="text" name="sequence" id="sequence" class="form-control" style="width:50px; display:none;"  readonly="" value="<?php echo ($_SESSION['sequence'] > 0 ? $_SESSION['sequence'] : 1); ?>">                 
                            
<!--                            <select name="sequence_show" id="sequence_show" class="form-control" style="display:none;">
                                <option value="1" <?php //if($_SESSION['sequence'] == 1 ) { echo 'selected'; } ?>>1</option>
                                <option value="2" <?php //if($_SESSION['sequence'] == 2 ) { echo 'selected'; } ?>>2</option>
                                <option value="3" <?php //if($_SESSION['sequence'] == 3 ) { echo 'selected'; } ?>>3</option>
                                <option value="4" <?php //if($_SESSION['sequence'] == 4 ) { echo 'selected'; } ?>>4</option>
                                <option value="5" <?php //if($_SESSION['sequence'] == 5 ) { echo 'selected'; } ?>>5</option>
                                <option value="6" <?php //if($_SESSION['sequence'] == 6 ) { echo 'selected'; } ?>>6</option>
                                <option value="7" <?php //if($_SESSION['sequence'] == 7 ) { echo 'selected'; } ?>>7</option>
                                <option value="8" <?php //if($_SESSION['sequence'] == 8 ) { echo 'selected'; } ?>>8</option>
                                <option value="9" <?php //if($_SESSION['sequence'] == 9 ) { echo 'selected'; } ?>>9</option>
                                <option value="10" <?php //if($_SESSION['sequence'] == 10 ) { echo 'selected'; } ?>>10</option>
                            </select>-->
                            <?php echo base64_encode()?>
                        <a href="my_life_pattrns.php?t=<?php echo base64_encode('tblusersmdt');?>"><input class="btn-red"  type="button" name="viewpost" id="viewpost" value="My Challenges History"></a>

                        <!-- onclick="viewpost(); -->

                        </div>
                        <div class='col-md-12' style="margin-bottom:20px;">
                            
                            <div id='change_avatar' style="float: right;"></div>
                        </div>
                        <div class="col-md-12" style="border:1px solid #CBCFD4;background-color: #FFF7F5;">                     
                               <?php 
                                  $drop_down_css ='display:bock;';

                                
                                  for($i=0;$i<count($data_dropdown);$i++) {
                                   
                                    if($i == 0)
                                    {
                                      $drop_down_css = 'display:bock;'; 
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
                                       $drop_down_css1 = 'display:bock;'; 
                                    }
                                    
                               // echo "<pre>";print_r($data_dropdown[$i]['pag_cat_status']);echo "</pre>";
                                   //echo 'count=>'.count($data_dropdown).'<br>';
                                   $symtum_cat = '';
                                   
                                   if($data_dropdown[$i]['sub_cat1']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat1'].',';
                                   }
                                   
                                   if($data_dropdown[$i]['sub_cat2']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat2'].',';
                                   }
                                   
                                   if($data_dropdown[$i]['sub_cat3']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat3'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat4']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat4'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat5']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat5'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat6']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat6'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat7']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat7'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat8']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat8'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat9']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat9'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat10']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat10'].',';
                                   }
                                   
                                   $symtum_cat = explode(',', $symtum_cat);
                                   $symtum_cat = array_filter($symtum_cat);
                                   
//                                   echo '$symtum_cat<pre>';
//                                   print_r($symtum_cat);
//                                   echo '</pre>';
                                   //die();
                                   
                                   $final_array = $obj->getAllMainSymptomsRamakantFront($symtum_cat);
                                   
//                                   echo '$final_array<pre>';
//                                   print_r($final_array);
//                                   echo '</pre>';
                                   
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
                                       <!--<label class="col-lg-6 dlist" style="<?php //echo $drop_down_css; ?>"><?php //echo $data_dropdown[$i]['heading']; ?></label>-->
                                       <!--<label class="col-lg-6 dlist" style="display:none;">Positive suggestion</label><br>-->
                                       <input type="hidden" name="heading[]" value="<?php echo $data_dropdown[$i]['heading']; ?>"/>
                                   </div>



                                   <div class="col-md-10" style="margin-top:25px;<?php echo $drop_down_css1;?>">
                                       <input type="text" <?php echo $required; ?> title="<?php echo $data_dropdown[$i]['heading']; ?>" name="bes_id[]" id="bes_id_<?php echo $i;?>" placeholder="Select your <?php echo $data_dropdown[$i]['heading']; ?>" list="capitals<?php echo $i; ?>" class="input-text-box dlist" style="width:300px; <?php echo $drop_down_css; ?>" onchange="icon_show(<?php echo $i; ?>)" />
                                   <datalist id="capitals<?php echo $i; ?>" class="dlist" style="<?php echo $drop_down_css; ?>">
                                        <?php echo $obj->GetDatadropdownoption($final_array); ?>  
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
                                            
                                            
                                            <select  class="input-text-box input-quarter-width" name="bes_time[]" id="bes_time_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['time_heading']; ?>">
                                                <option value=""><?php echo $data_dropdown[$i]['time_heading']; ?></option>
                                                <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
                                            </select>
                                            <input type="text" name="duration[]" id="duration_<?php echo $i;?>" onKeyPress="return isNumberKey(event);" placeholder="<?php echo $data_dropdown[$i]['duration_heading']; ?>" title="<?php echo $data_dropdown[$i]['duration_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">
                                            
                                            <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['location_heading']; ?>">
                                                <option value=""><?php echo $data_dropdown[$i]['location_heading']; ?></option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['location_fav_cat'],''); ?>
                                            </select>
                                            
                                            <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['like_dislike_heading']; ?>">
                                                <option value=""><?php echo $data_dropdown[$i]['like_dislike_heading']; ?></option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['user_response_fav_cat'],''); ?>
                                            </select>
                                            
                                            <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['set_goals_heading']; ?>">
                                                <option value=""><?php echo $data_dropdown[$i]['set_goals_heading']; ?></option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['user_what_fav_cat'],''); ?>
                                            </select>
                                            
                                            <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['reminder_heading']; ?>">
                                                <option value=""><?php echo $data_dropdown[$i]['reminder_heading']; ?></option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['alerts_fav_cat'],''); ?>
                                            </select>
                                            <textarea name="comment[]" id="comment_<?php echo $i;?>" style="display:none;" class="input-text-box input-quarter-width" autocomplete="false" title="<?php echo $data_dropdown[$i]['comments_heading']; ?>" placeholder="<?php echo $data_dropdown[$i]['comments_heading']; ?>" ></textarea>


                                            <!--<input  type="text" name="comment[]" id="comment_<?php //echo $i;?>"  placeholder="<?php //echo $data_dropdown[$i]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">-->
                                            
                                        </div>
                              </div>
                               
                               <?php } ?>
                               <input class="btn-red" style="text-align: center; margin-left: 250px; margin-bottom: 20px;" type="submit" name="btnSubmit" id="btnSubmit" value="My Pause and Think Pad">
                           
                        </div>
                       
                        </form>
                        
                    </div>
    <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>
    <div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>
      
    </div>
  </div>
</section>
<?php include_once('footer.php');?>  
    <script>
        $(document).ready(function()
            {
                $('#day_month_year').attr('autocomplete', 'off');
                $('#day_month_year').datepicker(
                        {
                            dateFormat: 'dd-mm-yy',
                            minDate: '-1D',
                            maxDate: '+0D',
                        }        
                );
               
               $('.vloc_speciality_offered').tokenize();
                
            }
        );
        
function ChangeTheamMDT()
{
    var theam_id = $("#theam_id").val();
    var dataString ='theam_id='+theam_id +'&action=changtheammdt';
    $.ajax({
            type: "POST",
            url: 'my_day_today.php', 
            data: dataString,
            cache: false,
            success: function(result)
                 {
                  var JSONObject = JSON.parse(result);
                 //$('#bgimage').html(JSONObject[0]['image']);
                 $('#bgimage').css("background-image", "url("+JSONObject[0]['image']+")");
                 $('#color_code').css("background-color", JSONObject[0]['color_code']);
                }
           });
}

function ChangeTheAvatar()
{
    var avat_id = $("#avat_id").val();
    var dataString ='avat_id='+avat_id +'&action=ChangeTheAvatar';
    $.ajax({
            type: "POST",
            url: 'my_day_today.php', 
            data: dataString,
            cache: false,
            success: function(result)
                 {
                  //   alert(result);
                 $('#change_avatar').html(result);
                }
           });
}

function ChangeTheMusic()
{
    var music_id1 = $("#music_id").val();
    var dataString ='music_id1='+music_id1 +'&action=ChangeTheMusic';
    $.ajax({
            type: "POST",
            url: 'my_day_today.php', 
            data: dataString,
            cache: false,
            success: function(result)
                 {
                 $('#changemusic').html(result);
                }
           });
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
      // alert('id');
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
    
    function isNumberKey(evt){  <!--Function to accept only numeric values-->
    //var e = evt || window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode != 46 && charCode > 31 
  && (charCode < 48 || charCode > 57))
        return false;
        return true;
  }
</script>
</body>
</html>