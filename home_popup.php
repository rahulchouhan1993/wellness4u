<?php 
include('classes/config.php');
// $page_id = '1';
$obj = new frontclass();
// $page_data = $obj->getPageDetails($page_id);
// $ref = base64_encode($page_data['menu_link']);
// $display_data=$obj->getAllIconsDisplayTypeDetailsVivek();

?>
            <div id="modal-content" class="my_first_pop">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" id="cboxClose" onclick="close_popup();">&times;</button>
                     <h4 class="modal-title">Modal Header</h4>
                 </div>
                <div class="modal-body body_part">

                  <div class="container">
                    <div class="row">
                     
                               <div class="tab">
                                  <?php
                                  $day_month_year = date("Y-m-d");
                                   $arr_function=$obj->gethomepagepopupdataKR($day_month_year);
                                   foreach($arr_function as $value)
                                   { 
                                   ?>
                                 <button class="tablinks" onclick="openCity(event,<?php echo $value['sol_item_id']?>)"><?php echo $value['get_sol_cat_name']?></button> 
                                  <?php
                                 }
                                 
                                  ?>
                                </div>
                                  <?php
                                  foreach($arr_function as $key=>$value)
                                   {
                                      if($key==0)
                                      {
                                        $style='style="display: block;"';
                                      }
                                      else
                                      {
                                        $style='style="display: none;"';
                                      }
                                        
                                      ?>
                                     <div id="<?php echo $value['sol_item_id']?>" class="tabcontent" <?php echo  $style;?>>
                                          <h3><?php echo $value['get_sol_cat_name']?></h3>

                                          <p><?php echo $value['narration']?></p>
                                       </div>
 
                                    <?php
                                  }
                             ?>
                      </div>
         
                  </div>
                 
                </div>
                <!-- <div class="modal-footer"> -->
                  <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                <!-- </div> -->
          </div>
