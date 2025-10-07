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


$array_main=array();


   

    $report_data=$_SESSION['report_data'];

    if(empty($report_data))
    {
       header( "Location: my_canvas_report.php" );
    }

    //  echo "<pre>";

    // print_r($report_data);

    // die('-sdbsdg');


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

                        if(!empty($report_data))
                        {

                          foreach ($report_data as $dkey => $dvalue) {

                            if(!empty($dvalue['data']))
                            {
                               foreach ($dvalue['data'] as $pkey => $pvalue) {

                                 if(!empty($pvalue['preview_data']))
                                 {

                                   ?>
                                    <div class="row">
                                      <div class="col-md-12 text-center text-danger">
                                        <hr>
                                        <b>Entry Date: </b><?php 
                                        $entry_date=$pvalue['preview_data'][0]['finalData'][0]['data'][0]['mdt_entry_date'];
                                        echo date("d-M-Y", strtotime($entry_date) ); ?> &nbsp; &nbsp;
                                        <b>Sequence: </b><?php echo $pvalue['preview_data'][0]['finalData'][0]['data'][0]['sequence_show']; ?><br>
                                        <hr>
                                      </div>
                                    </div>
                                  <?php

                                   foreach ($pvalue['preview_data'] as $key => $value) {

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
                                                <form method="post" action="" class="formData" id="form-<?=$key1.$key2;?>">
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
                                                          <input type="hidden" name="redirect_id" value="<?=$value2['id']?>">
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
                              }

                            }

                          }

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