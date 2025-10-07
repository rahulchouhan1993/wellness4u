<?php 
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

echo $option.='<img src="uploads/'.stripslashes($image).'" height="50px;" width="50px;">';
exit(0);
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
$day_month_year_theams = date("Y-m-d");
//echo '<pre>';
//print_r($header_data);
//echo '</pre>';
//die();

if(isset($_POST['submit']))
{

for($i=0 ;$i<count($_POST['comment']);$i++)
{


$comment=isset($_POST['comment'][$i]) && $_POST['comment'][$i]!='' ? $_POST['comment'][$i] : '';

$location=isset($_POST['location'][$i]) && $_POST['location'][$i]!='' ? $_POST['location'][$i] : '';

$User_view=isset($_POST['User_view'][$i]) && $_POST['User_view'][$i]!='' ? $_POST['User_view'][$i] : '';

$User_Interaction=isset($_POST['User_Interaction'][$i]) && $_POST['User_Interaction'][$i]!='' ? $_POST['User_Interaction'][$i] : '';

$alert=isset($_POST['alert'][$i]) && $_POST['alert'][$i]!='' ? $_POST['alert'][$i] : ''; 

$activity_text = isset($_POST['activity_text'][$i]) && $_POST['activity_text'][$i]!='' ? $_POST['activity_text'][$i] : '';

$activity_id = isset($_POST['activity_id'][$i]) && $_POST['activity_id'][$i]!='' ? $_POST['activity_id'][$i] : '';

$canv_sub_cat_link = isset($_POST['canv_sub_cat_link'][$i]) && $_POST['canv_sub_cat_link'][$i]!='' ? $_POST['canv_sub_cat_link'][$i] : '';

$canv_show_fetch=isset($_POST['canv_show_fetch'][$i]) && $_POST['canv_show_fetch'][$i]!='' ? $_POST['canv_show_fetch'][$i] : '';

$prof_cat=isset($_POST['prof_cat'][$i]) && $_POST['prof_cat'][$i]!='' ? $_POST['prof_cat'][$i] : '';

$sub_cat=isset($_POST['sub_cat'][$i]) && $_POST['sub_cat'][$i]!='' ? $_POST['sub_cat'][$i] : '';

$maintab=isset($_POST['maintab']) && $_POST['maintab']!='' ? $_POST['maintab'] : '';

$subtab=isset($_POST['subtab']) && $_POST['subtab']!='' ? $_POST['subtab'] : '';

$mdt_date = isset($_POST['mdt_date']) && $_POST['mdt_date']!='' ? $_POST['mdt_date'] : '';

$sequence = isset($_POST['sequence']) && $_POST['sequence']!='' ? $_POST['sequence'] : '';



if($comment!='' || $location!='' || $User_view!='' || $User_Interaction!='' || $alert!='' )
{

$obj->AddmyCanvas($comment,$location,$User_view,$User_Interaction,$alert,$activity_text,$activity_id,$canv_sub_cat_link,$canv_show_fetch,$prof_cat,$sub_cat,$maintab,$subtab,$mdt_date,$sequence,$_SESSION['user_id']);
}

}
$response = array("status"=>'success',"error_code"=>'1',"main_tab"=>$_POST['maintab'],"sub_tab"=>$_POST['subtab']);
echo json_encode($response) ;
exit(0);



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
</style>
<style>


/*  bhoechie tab */
div.bhoechie-tab-container{
z-index: 10;
background-color: #ffffff;
padding: 0 !important;
border-radius: 4px;
-moz-border-radius: 4px;
border:1px solid #ddd;
margin-top: 20px;
//margin-left: 50px;
-webkit-box-shadow: 0 6px 12px rgba(0,0,,0,.175);
box-shadow: 0 6px 12px rgba(0,0,0,.175);
-moz-box-shadow: 0 6px 12px rgba(0,0,0,..175);
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

</style>
</head>
<body>
<?php //include_once('analyticstracking.php'); ?>
<?php //include_once('analyticstracking_ci.php'); ?>
<?php// include_once('analyticstracking_y.php'); ?>
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
<span id="error_msg"></span>
<div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">
<div class="col-md-12" id="testdata">
<?php if($page_data['page_icon']!='') { ?>
<img src="uploads/<?php echo $page_data['page_icon']; ?>" style="width:128px; height: 128px;">
<?php } ?>
<!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);?></span></h2>-->
<?php echo $obj->getPageContents($page_id);?>
</div>
<div class='col-md-12' style="margin-bottom:20px;">
<div class="col-md-4">
<span style="font-size:15px; font-weight: bold;" class="Header_brown">Reset your Mood</span>
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
<option>Select Avatar</option>
<?php echo $obj2->getAllAvatar($avat_id,$day); ?>
</select>
</div>

<div class="col-md-12">
<span style="font-size:15px; font-weight: bold;" class="Header_brown"><br></span>
<a href="my_life_pattrns.php?t=<?php echo base64_encode('tbl_mycanvas');?>"><input type="button" class="btn-light-green" value="View My Canvas History" name="proceeddml" id="proceeddml" style="float: right;"></a>
</div>

</div>

<div class='col-md-12' style="margin-bottom:20px;">

<div id='change_avatar' style="float: right;"></div>
</div>


<div class="col-md-12" style="">

<div class="tabbable boxed parentTabs">
<ul class="nav nav-tabs">
<?php for($k=0;$k<count($user_my_day_today_data);$k++) { ?>
<li class="<?php if($k==0) { echo 'active'; } ?>"><a href="#main_<?php echo $k; ?>" onclick="change_main_tab('<?php echo $k; ?>')"> <h3><?php echo $user_my_day_today_data[$k]['bms_name']; ?></h3></a>
</li>
<!--                                <li><a href="#set2">Tab 2</a>
</li>-->
<?php } ?>
</ul>
<div class="tab-content">
<?php for($k=0;$k<count($user_my_day_today_data);$k++) { ?>
<!--<form name="mycanvas_data" id="mycanvas_data">-->

<div class="tab-pane fade<?php if($k==0) { echo ' active in'; } ?>" id="main_<?php echo $k; ?>">
<h3 style="margin-top:10px; text-align: right; color: #BC446C;">To explore more the below options, kindly click on the below eye symbol on RHS </h3>



<div class="tabbable">
<div class="col-lg-12 col-md-12 col-sm-8 col-xs-9 bhoechie-tab-container">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
<div class="list-group">
     <?php for($i=0;$i<count($header_data);$i++) { ?>
    <a href="javascript:void(0);" id="list_group_tab_<?php echo $k; ?>_<?php echo $i; ?>" onclick="change_tab('<?php echo $k; ?>_<?php echo $i; ?>')" class="list-group-item <?php if($i==0) { echo 'active'; } ?> text-center">
    <h4 class="glyphicon glyphicon-plane"></h4><br/><?php echo $header_data[$i]['heading']; ?>
  </a>  
     <?php } ?>
</div>
</div>

<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
<?php for($j=0;$j<count($header_data);$j++) { ?>
<div class="bhoechie-tab-content<?php if($j==0) { echo ' active in'; } ?>" id="sub_cat_<?php echo $k; ?>_<?php echo $j; ?>">
<form name="frm_<?php echo $k; ?>_<?php echo $j; ?>" id="frm_<?php echo $k; ?>_<?php echo $j; ?>" method="post">
    <input type="hidden" name="maintab" id="maintab" value="<?php echo $user_my_day_today_data[$k]['bms_name']; ?>">
    <input type="hidden" name="subtab" id="subtab" value="<?php echo $header_data[$j]['heading']; ?>">
    <input type="hidden" name="mdt_date" id="sequence" value="<?php echo $_GET['mdt_date']; ?>">
    <input type="hidden" name="sequence" id="sequence" value="<?php echo $_GET['sequence']; ?>">
<?php 
        //echo $header_data[$j]['heading'];
        
        $keyworddata_implode_data = array();
        $keyword = $user_my_day_today_data[$k]['bms_name'];
        //die();
       // $keyworddata_implode = implode(',',$keyword);
         $keyworddata_explode = explode(' ',$keyword);
//                                                            echo '<pre>';
//                                                            print_r($header_data[$j]);
//                                                            echo '</pre>';
        
         $exclusion_name = $obj->getExclusionAllName();
         
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
             
//                                                                   echo '<pre>';
//                                                                   print_r($exclusion_name);
//                                                                   echo '</pre>';
//                                                                   
//                                                                   echo '<pre>';
//                                                                   print_r($keyworddata_implode_data);
//                                                                   echo '</pre>';
//                                                                   die();
               
              if($header_data[$j]['sub_cat1'] !='') 
              {
//                                                                      echo '<pre>';
//                                                                      print_r($header_data);
//                                                                      echo '</pre>';
                  $fetch_show = $header_data[$j]['canv_sub_cat1_show_fetch'];
                 
                  if($fetch_show == 2)
                  {
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat1_link'],$header_data[$j]['sub_cat1']);                                                                        
                    if(!empty($fetch_data)){
//                                                                            echo '<pre>';
//                                                                            print_r($fetch_data);
//                                                                            echo '</pre>';
                            echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                            $loop=0;
                            foreach($fetch_data  as $value)
                            {
                                    echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat1_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                    echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
                                  
                                if($comment_show_icon!='') { ?>
                                &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" id="comment_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>');">
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
                                <div class="md-col-12">
                                        <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat1']; ?>">
                                        <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat1']; ?>">
                                        <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat1_show_fetch']; ?>">
                                        <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat1_link']; ?>">
                                        <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                        <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                        
                                        <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">
      
                                        <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                        </select>

                                        <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                        </select>

                                        <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                        </select>

                                        <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                        </select>
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
//                                                                         echo '<pre>';
//                                                                         print_r($show_data);
//                                                                         echo '</pre>';
                     if(!empty($show_data)){
                         echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                            $loop1=0;
                            foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat1_'.$k.'_'.$j.'_'.$loop1.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
                                        
                                if($comment_show_icon!='') { ?>
                                &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>"  name="comment_show_icon_<?php echo $loop1; ?>" id="comment_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['comments_heading']; ?>" onclick="ShowComment('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>');">
                                <?php } ?>

                                <?php if($location_show_icon!='') { ?>
                                &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>"  name="location_show_icon_<?php echo $loop1; ?>" id="location_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>" onclick="ShowLocation('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>');">
                                 <?php } ?>

                                 <?php if($User_view_icon!='') { ?>
                                &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>"  name="User_view_icon_<?php echo $loop1; ?>" id="User_view_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>" onclick="ShowUserview('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>');">
                                <?php } ?>

                                <?php if($User_Interaction_icon!='') { ?>
                                &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>"  name="User_Interaction_icon_<?php echo $loop1; ?>" id="User_Interaction_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>" onclick="ShowUserInteraction('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>');">
                                  <?php } ?>

                                 <?php if($alert_show_icon!='') { ?>
                                &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>"  name="alert_show_icon_<?php echo $loop1; ?>" id="alert_show_icon_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="width:25px; height: 25px; display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>" onclick="ShowAlert('<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>');">
                                <?php } 
                                echo '</p>';
                                ?>
                                <div class="md-col-12">
                                        <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat1'] ?>">
                                        <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat1']; ?>">
                                        <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat1_show_fetch']; ?>">
                                        <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat1_link']; ?>">
                                        <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                         <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                         <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">
      
                                         <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                        </select>

                                         <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                        </select>

                                         <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                        </select>

                                         <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat1_'.$k.'_'.$j.'_'.$loop1; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                        </select>
                                    </div>
                                <?php
                                  $loop1++;
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat2_link'],$header_data[$j]['sub_cat2']);                                                                        
                        if(!empty($fetch_data))
                        {
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                               echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat2_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                  <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat2'] ?>">
                                  <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat2']; ?>">
                                  <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat2_show_fetch']; ?>">
                                  <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat2_link']; ?>">
                                  <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                  <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                  <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat2_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                     <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat2'] ?>">
                                     <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat2']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat2_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat2_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat2_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat3_link'],$header_data[$j]['sub_cat3']);                                                                        
                    if(!empty($fetch_data))
                        {
                           
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                               echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat3_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                     <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat3'] ?>">
                                     <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat3']; ?>">
                                        <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat3_show_fetch']; ?>">
                                        <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat3_link']; ?>">
                                        <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                        <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                        <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                        <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                        <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                        <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                        <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat3_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                     <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat3'] ?>">
                                     <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat3']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat3_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat3_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat3_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat4_link'],$header_data[$j]['sub_cat4']);                                                                        
                    if(!empty($fetch_data))
                        {
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat4_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat4'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat4']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat4_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat4_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>"> 
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat4_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat4'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat4']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat4_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat4_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat5_link'],$header_data[$j]['sub_cat5']);                                                                        
                    if(!empty($fetch_data))
                        {
                           
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat5_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat5'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat5']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat5_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat5_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat5_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat5'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat5']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat5_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat5_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat5_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat6_link'],$header_data[$j]['sub_cat6']);                                                                        
                    if(!empty($fetch_data))
                        {
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat6_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat6'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat6']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat6_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat6_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat6_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat6'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat6']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat6_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat6_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat6_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat7_link'],$header_data[$j]['sub_cat7']);                                                                        
                    if(!empty($fetch_data))
                        {
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat7_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat7'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat7']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat7_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat7_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat7_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat7'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat7']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat7_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat7_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat7_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat8_link'],$header_data[$j]['sub_cat8']);                                                                        
                    if(!empty($fetch_data))
                        {
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat8_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat8'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat8']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat8_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat8_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat8_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat8'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat8']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat8_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat8_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat8_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat9_link'],$header_data[$j]['sub_cat9']);                                                                        
                    if(!empty($fetch_data))
                        {
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat9_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat9'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat9']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat9_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat9_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat4_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat9_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat9'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat9']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat9_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat9_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat9_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                    $fetch_data = $obj->GetFecthData($keyworddata_implode_data,$header_data[$j]['canv_sub_cat10_link'],$header_data[$j]['sub_cat10']);                                                                        
                    if(!empty($fetch_data))
                        {
                           
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($fetch_data as $value)
                            {
                               echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat10_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                     <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat10'] ?>">
                                     <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat10']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat10_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat10_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
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
                           echo '<div style="border:1px solid #ccc; padding:5px;overflow-y:scroll;height:250px;">';
                           $loop=0;
                           foreach($show_data as $value)
                            {
                                echo '<span style="float:left;"><i class="fa fa-eye" style="cursor: pointer;" title="Click here for user action" onclick="Showloop(\'_sub_cat10_'.$k.'_'.$j.'_'.$loop.'\');"></i></span>';
                                echo '&nbsp;&nbsp;<p style="text-align:left;" class="tooltipN">'.$value['activity_name'];
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
                                <div class="md-col-12">
                                    <input type="hidden" name="sub_cat[]"  value="<?php echo $header_data[$j]['sub_cat10'] ?>">
                                    <input type="hidden" name="prof_cat[]"  value="<?php echo $header_data[$j]['prof_cat10']; ?>">
                                    <input type="hidden" name="canv_show_fetch[]"  value="<?php echo $header_data[$j]['canv_sub_cat10_show_fetch']; ?>">
                                    <input type="hidden" name="canv_sub_cat_link[]"  value="<?php echo $header_data[$j]['canv_sub_cat10_link']; ?>">
                                    <input type="hidden" name="activity_text[]"  value="<?php echo $value['activity_name']; ?>">
                                    <input type="hidden" name="activity_id[]"  value="<?php echo $value['activity_id']; ?>">
                                    <input  type="text" name="comment[]" id="comment_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>"  placeholder="<?php echo $header_data[$j]['comments_heading']; ?>" title="<?php echo $header_data[$j]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">

                                    <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['location_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['location_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['like_dislike_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['like_dislike_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'],''); ?>
                                    </select>

                                    <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['set_goals_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['set_goals_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'],''); ?>
                                    </select>

                                    <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo '_sub_cat10_'.$k.'_'.$j.'_'.$loop; ?>" style="display:none;" title="<?php echo $header_data[$j]['reminder_heading']; ?>">
                                            <option value=""><?php echo $header_data[$j]['reminder_heading']; ?></option>
                                            <?php echo $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'],''); ?>
                                    </select>
                                    </div>
                                <?php
                                $loop++;
                                } 
                            echo '</div>';
                        }
                  }
                  //echo '</div>';
                  
              }
              
        ?>
        </form>
      <input type="button" class="btn-red" name="btnsubmit" value="btn_submit" onclick="getcurrentactivetab('<?php echo $k.'_'.$j; ?>');"> 
       <!-- Proceed to design my life -->

      <input type="button" class="btn-light-green" value="Evaluate more TAB options" name="moreoptions" id="moreoptions_<?php echo $k.'_'.$j; ?>" onclick="moreoptionstab('<?php echo $k.'_'.$j; ?>');" style="display:none;">
</div>
<!--                                                <div class="tab-pane fade" id="sub12">
<p>Tab 1.2</p>
</div>-->

<?php  } ?>
<!--<input type="button" class="btn-red" name="btnsubmit" value="submit" onclick="getcurrentactivetab();">-->
</div>

</div>
</div>
</div>

<!--  </form>-->
<?php } ?>

</div>
</div>
</div>

</div>
<div class="col-md-2"><?php// include_once('right_sidebar.php'); ?></div>

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


function getcurrentactivetab(id)
{
//alert('hhh');
var formData = new FormData($('#frm_'+id)[0]); 
formData.append("submit",'submit');
jQuery.ajax({
url:'mycanvas.php',
type: "POST",
data:formData,
processData: false,
contentType: false,
//beforeSend: function(){ $("#loader").show();$("#hidebtn").hide();},
success: function(result)
{
//alert(result);
var JSONObject = JSON.parse(result);
var rslt = JSONObject['error_code'];
if(rslt==1)
{
$("#proceeddml_"+id).show();
$("#moreoptions_"+id).show();
}

else
{
//$('#error_msg').html(JSONObject['er_msg']);  
}       
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

function Showloop(id)
{
//alert(id);
$("#comment_show_icon_"+id).show(); 
$("#location_show_icon_"+id).show(); 
$("#User_view_icon_"+id).show(); 
$("#User_Interaction_icon_"+id).show(); 
$("#alert_show_icon_"+id).show(); 
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
// alert(idval);

$(".list-group-item").removeClass("active");
$("#list_group_tab_"+idval+'_0').addClass("active");        
$(".bhoechie-tab-content").removeClass("active");
$("#sub_cat_"+idval+'_0').addClass("active");

}

</script>
<!--<script>
$(document).ready(function() {
$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
alert(e);
e.preventDefault();
//$(this).siblings('a.active').removeClass("active");
$(".list-group-item").removeClass("active");
$(this).addClass("active");
var index = $(this).index();
$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
});
});
</script>-->

</body>
</html>