<?php 

include('classes/config.php');

$page_id = '34';

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

if(empty($_SESSION['preview_id']) && empty($_GET['preview_id']) )
{
    header("Location: my_day_today.php");

    exit();
}
//update by ample 30-09-20
if($_GET['preview_id'])
{
  $preview_id=$_GET['preview_id'];
}
else
{
  $preview_id=$_SESSION['preview_id'];
}
$preview_data=$obj->getLastSaveDataMycanvas($preview_id);

// $today=date('Y-m-d');
// $next_day=date('Y-m-d', strtotime('+1 day', strtotime($today)));
// $all_preview_data=$obj->getAllSaveDataMycanvas($today,$next_day);

// if(!empty($all_preview_data))
// {
//   foreach ($all_preview_data as $key => $value) {
//     $all_preview_data[$key]['data']=$obj->filterByData($value['data']);
//   }
// }

// echo "<pre>";
// print_r($all_preview_data);
// die('-jhs');
$array_main=array();
  foreach ($preview_data as $key => $value) 
  {
    $array_main[]['data']=$value;
  }
  foreach ($array_main as $key => $value) 
  {
    $array_main[$key]['data']['heading']=$value['data'][0]['main_tab'];
    $array_main[$key]['data']['newData']=$obj->group_by($value['data'],'sub_tab');
    $array_main[$key]['heading']=$array_main[$key]['data']['heading'];
    $array_main[$key]['filterData']=$array_main[$key]['data']['newData'];
    unset($array_main[$key]['data']);
  }
  foreach ($array_main as $key => $value) 
  {
    foreach ($value['filterData'] as $index => $row) 
    {
      $array_main[$key]['finalData'][]['data']=$row;
      unset($array_main[$key]['filterData']);
    }
  }
  // echo "<pre>";
  // print_r($array_main);
  // die('-fgfdfd');

}



?>

<!DOCTYPE html>

<html lang="en">

  <head>    
  <?php include_once('head.php');?>
<!-- <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css"> -->
<!-- <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script> -->
<!-- <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script> -->
  </head>


  <body>

  <?php //include_once('analyticstracking.php'); ?>

  <?php //include_once('analyticstracking_ci.php'); ?>

  <?php// include_once('analyticstracking_y.php'); ?>

  <?php include_once('header.php');?>


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
        <div class="">
          <span id="response_msg"></span>
          <span id="error_msg"></span>
          <div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">
            <div class="row">
              <div class="col-md-12" id="testdata">
                <?php if($page_data['page_icon']!='') { ?>
                <img src="uploads/<?php echo $page_data['page_icon']; ?>" style="width:128px; height: 128px;">
                <?php } ?>
                <?php echo $obj->getPageContents($page_id);?>
              </div>
            </div>
            <!--Add by ample -->
            <div class="row" style="padding-bottom: 5px; margin-bottom: 5px;">
                <div class="col-md-10">
                </div>
                <div class="col-md-2">
                      <a href="my_canvas_report.php" target="_blank"><button type="button" class="btn btn-danger" style="border-radius: 0;">MY COMPASS</button></a>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                        <?php 
                         if(!empty($array_main))
                         {  

                            ?>
                              <div class="row">
                                <div class="col-md-12 text-center text-danger">
                                  <hr>
                                  <b>Entry Date:</b><?php 
                                  $entry_date=$array_main[0]['finalData'][0]['data'][0]['mdt_entry_date'];
                                  echo date("d-M-Y", strtotime($entry_date) ); ?> &nbsp; &nbsp;
                                  <b>Sequence:</b><?php echo $array_main[0]['finalData'][0]['data'][0]['sequence_show']; ?><br>
                                  <hr>
                                </div>
                              </div>
                            <?php

                            foreach ($array_main as $key => $value) {
                              ?>
                              <div class="col-md-4">
                                <h4 class="text-center p-title-1"><?=$value['heading'];?></h4>
                              <?php
                              if(!empty($value['finalData']))
                              {
                                foreach ($value['finalData'] as $key1 => $value1) {
                                    if(!empty($value1['data']))
                                    {
                                      ?>
                                      <h5 class="text-center p-title-2"><?=$value1['data'][0]['sub_tab'];?></h5>
                                      <?php
                                      foreach ($value1['data'] as $key2 => $value2) {
                                        ?>
                                        <form method="post" action="" class="formData">
                                          <div class="text-center" style="margin: 5px 0px;">
                                            <div class="offer-box">
                                              <h6 class="title"><?=$value2['activity_text'];?></h6>
                                              <?=(trim($value2['comment']))? '<p><i class="fa fa-commenting"></i> '.$value2['comment'].'</p>' : '';?>
                                              <?=($value2['location'])? '<p><input type="radio" name="favCat" value="'.$value2["location"].'"> '.$obj->getFavCategoryName($value2['location']).'</p>' : '';?>
                                              <?=($value2['user_response'])? '<p><input type="radio" name="favCat" value="'.$value2["user_response"].'"> '.$obj->getFavCategoryName($value2['user_response']).'</p>' : '';?>
                                              <?=($value2['what_for_next'])? '<p><input type="radio" name="favCat" value="'.$value2["what_for_next"].'"> '.$obj->getFavCategoryName($value2['what_for_next']).'</p>' : '';?>
                                              <?=($value2['user_updates'])? '<p><input type="radio" name="favCat" value="'.$value2["user_updates"].'"> '.$obj->getFavCategoryName($value2['user_updates']).'</p>' : '';?>
                                              <hr>
                                              <p>
                                                  <!-- <button class="btn btn-success btn-xs">Yes</button>
                                                  <button class="btn btn-danger btn-xs">No</button> -->
                                                  <input type="hidden" name="activity" value="<?=$value2['activity_text'];?>">
                                                  <input type="hidden" name="action" value="canvas_linkup">
                                                  <input type="hidden" name="redirect_id" value="<?=$value2['id'];?>">
                                                  <input type="hidden" name="redirect_page" value="<?=$page_id;?>">
                                                  <input type="hidden" name="redirect" value="MyCanvas">
                                                  <button type="submit" class="btn btn-info btn-xs">Explore-Try</button>
                                              </p>
                                            </div>
                                          </div>
                                          </form>
                                        <?php
                                      }
                                    }
                                }
                              }
                            ?>
                            </div>
                            <?php
                            }
                         }
                         else
                        {
                          echo '<h3 class="text-center">No Data Found!</h3>';
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