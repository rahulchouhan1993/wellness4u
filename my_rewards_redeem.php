<?php

// include('config.php');
include('classes/config.php');
$obj = new frontclass();
$obj2 = new frontclass2();

$page_id = '148';
$main_page_id = $page_id;
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = $obj->getPageDetails($page_id);
$ref = base64_encode('my_rewards_redeem.php');
if(!$obj->isLoggedIn())
{
//	header("Location: login.php?ref=".$ref);
  echo "<script>window.location.href='login.php?ref=$ref'</script>";
	exit(0);
}
else
{
	$user_id = $_SESSION['user_id'];
	$obj->doUpdateOnline($_SESSION['user_id']);
}

//add by ample 12-11-20
$obj->update_user_reward_points();
$module=$obj->get_active_reward_module();

if(isset($_GET['module_id']) && !empty($_GET['module_id']))
{
  $tab1='active';
  $tab2=' ';
}
else
{
  $tab1='';
  $tab2='active';
}


?><!DOCTYPE html>
<html lang="en">
<head>
 <?php include_once('head.php');?>
</head>


<body id="boxed">
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<div class="boxed-wrapper">
<!--header-->
<!-- <header> -->
 <?php //include 'topbar.php'; ?>
<?php include_once('header.php');?>
<!-- </header> -->

<!--header End --> 	
 <!--breadcrumb--> 

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
            </div>
<!--breadcrumb end --> 
<!--container-->              
<div class="container" >
<div class="row">	
<div class="col-md-10">	
      	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td align="left" valign="top"><span class="Header_brown"><?php echo $obj->getPageTitle($page_id);?></span><br /><br /><?php echo $obj->getPageContents($page_id);?></td>
                            </tr>
                        </table>
                    
                        <a href="my_encashed_rewards.php" class="btn btn-info btn-sm" target="_blank">Point History</a>
                        <br>    <br>

          <ul class="nav nav-tabs">
            <li class="<?=$tab1;?>"><a data-toggle="tab" href="#sinle-module">Single Module</a></li>
            <li class="<?=$tab2;?>"><a data-toggle="tab" href="#all-module">All Module</a></li>
          </ul>

          <div class="tab-content">
            <div id="sinle-module" class="tab-pane fade in <?=$tab1;?>">
              <br>
              <h3>Single Module wise redeem/price</h3>
              <br>
                 <div class="row">
                    <div class="col-md-6">
                      <form action="" id="point_redeem_form" method="post">
                          <div class="form-group">
                            <label>Select Module:</label>
                             <select class="form-control" id="reward_module_id" name="module_id" onchange="get_points(this)">
                                <option value="">-select-</option>
                                <?php 
                                  if(!empty($module))
                                  {
                                    foreach ($module as $key => $value) {
                                        $sel='';
                                        if(isset($_GET['module_id']) && !empty($_GET['module_id']))
                                        {
                                            if($_GET['module_id']==$value['reward_module_id'])
                                            {
                                              $sel='selected';
                                            }
                                        }
                                       ?>
                                       <option value="<?=$value['reward_module_id']?>" <?=$sel;?> ><?=$value['page_name'];?></option>
                                       <?php
                                    }
                                  }
                                ?>
                              </select>
                          </div>
                          <div class="form-group">
                          <label>Your Points:</label>
                          <input type="text" class="form-control" value="0" id="my_point" name="my_point" readonly>
                        </div>
                        <div class="form-group">
                          <label>Enter Points:</label>
                          <input type="text" class="form-control" id="redeem_point" name="redeem_point" value="0" onchange="get_reward_prize()">
                        </div>
                        <div id='prize-box'>

                        </div>
                         <input type="hidden" name="action" value="point_redeem_form_submit">
                         <button type="button" onclick="point_redeem_process()" class="btn btn-default">Redeem</button>
                        </form>
                    </div>
                  </div>
            </div>
            <div id="all-module" class="tab-pane fade <?=$tab2;?>">
              <br>
              <h3>All Module wise redeem/common price</h3>
              <br>
              <div class="row">
                    <div class="col-md-8">
                      <form action="" id="point_redeem_form_all_module" method="post">
                          <div class="form-group">
                           <table class="table table-condensed table-hover table-striped">
                              <thead>
                                <tr class="warning">
                                  <th>Select</th>
                                  <th>Module</th>
                                  <th>Balance Point</th>
                                  <th>Encash Point</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                  if(!empty($module))
                                  {
                                    $total_points=0;
                                    $module_points=0;
                                    foreach ($module as $key => $value) {
                                        $module_points=$obj->get_total_points($user_id,$value['reward_module_id']);
                                        $total_points+=$module_points;
                                      ?>
                                      <tr>
                                        <td>
                                          <div class="checkbox">
                                            <label><input type="checkbox" name="selected_reward_module_id[]" value="<?=$key;?>" class="check-module" id="select_module<?=$key;?>" onclick="set_total_points(<?=$key;?>)"></label>
                                          </div>
                                        </td>
                                        <td><?=$value['page_name'];?></td>
                                        <td><?=$module_points;?></td>
                                        <td>
                                            <input type="text" class="form-control" name="my_point[]" id='my_point<?=$key;?>' onchange='check_redeem_point(<?=$key;?>)' readonly>
                                            <input type="hidden" class="form-control" name="redeem_point[]" id='redeem_point<?=$key;?>' value="<?=$module_points;?>">
                                            <input type="hidden" class="form-control" name="module_id[]" id='module_id<?=$key;?>' value="<?=$value['reward_module_id'];?>">
                                        </td>
                                      </tr>
                                      <?php
                                    }
                                  }
                                ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th></th>
                                  <th>Total</th>
                                  <th><?=$total_points;?></th>
                                  <th><input type="text" class="form-control" name="total_encash" id='total_encash' readonly>
                                      <input type="hidden" class="form-control" name="max_total_encash" id='max_total_encash' value="<?=$total_points?>" readonly>
                                    </th>
                                </tr>
                              </tfoot>
                           </table>
                          </div>
                        <div id='prize-box-all'>

                        </div>
                         <input type="hidden" name="action" value="point_redeem_form_submit_all_module">
                         <button type="button" onclick="point_redeem_process_all_module()" class="btn btn-default">Redeem</button>
                        </form>
                    </div>
                  </div>
            </div>
          </div>
        </div>
                     
                        

     </div>
     <div class="col-md-2">	             
        <?php include_once('left_sidebar.php'); ?>
        <?php include_once('right_sidebar.php'); ?>
     </div>
     </div>
</div>

   <?php include_once('footer.php');?>            

</div>       		
<script type="text/javascript">
imagePreview();

<?php
if($_GET['module_id'])
{
  ?>
   $('#reward_module_id').trigger('change');
   <?php
}
?>

function get_points(ele) {
  var module_id=ele.value;
   $.ajax({
     url:'remote.php',
     method: 'post',
     data: {action: 'get_module_points',module_id:module_id},
     //dataType: 'json',
     success: function(response){
     
        $('#my_point').val(response);
        $('#redeem_point').val(response);
        get_reward_list_data(module_id,response);
     }
   });
}

function get_reward_list_data(module_id,points)
{

   $.ajax({
     url:'remote.php',
     method: 'post',
     data: {action: 'get_reward_list_data',module_id:module_id,points:points},
     //dataType: 'json',
     success: function(response){
        $('#prize-box').html(response);
     }
   });
}

function get_reward_prize()
{     
      var module_id=$('#reward_module_id').val();
      var my_point=parseInt($('#my_point').val());
      var redeem_point=parseInt($('#redeem_point').val());

      if(redeem_point>my_point || redeem_point==0)
      {
         alert('Point not available for redeem');
      }
      else
      {
         $.ajax({
         url:'remote.php',
         method: 'post',
         data: {action: 'get_reward_list_data',module_id:module_id,points:redeem_point},
         //dataType: 'json',
         success: function(response){
            $('#prize-box').html(response);
         }
       });
      }
}

function set_total_points(id)
{
   if($('#select_module'+id).is(':checked'))
    {
        $("#my_point"+id).attr("readonly", false);
        if($('#my_point'+id).val() == '')
        {
            $('#my_point'+id).val($('#redeem_point'+id).val());
        }       
    }   
    else
    {
         $("#my_point"+id).attr("readonly", true);
        $('#my_point'+id).val('');
    } 

  update_encash_points();  
  get_reward_prize_all_module();
    
}

function check_redeem_point(id)
{
   var total_point=$('#redeem_point'+id).val();
   var redeem_point=$('#my_point'+id).val();

   if(redeem_point>total_point)
   {
     alert('Point not available for redeem');
     $('#my_point'+id).val(total_point);
   }

  update_encash_points();
  get_reward_prize_all_module();
}

function update_encash_points()
{ 

     var cnt_seleceted_module = 0;

    var checkValues = $('input:checkbox[name="selected_reward_module_id[]"]').map(function() {   

                        if($(this).attr('checked'))

                        {

                            cnt_seleceted_module++;

                            return $(this).val();

                        }

                    }).get();

    var module_id = String(checkValues);

    var total_selected_encashed_point = 0;

    var arr_key = module_id.split(",");

     for(var i=0; i < cnt_seleceted_module; i++)
    {
        var temp_selected_encashed_point = Number($('#my_point'+arr_key[i]).val()) + 0;
        if(temp_selected_encashed_point == '' || temp_selected_encashed_point == '0')
        {
            temp_selected_encashed_point = 0;
        }
        else if(!IsNumeric(temp_selected_encashed_point))
        {
            temp_selected_encashed_point = 0;
        }
        total_selected_encashed_point = 0 + total_selected_encashed_point + temp_selected_encashed_point;
    }   
  
    $('#total_encash').val(total_selected_encashed_point);
}

function get_reward_prize_all_module()
{     
     
      var my_point=parseInt($('#max_total_encash').val());
      var redeem_point=parseInt($('#total_encash').val());

      if(redeem_point>my_point || redeem_point==0)
      {
         alert('Point not available for redeem');
      }
      else
      {
         $.ajax({
         url:'remote.php',
         method: 'post',
         data: {action: 'get_reward_list_data_all_module',points:redeem_point},
         //dataType: 'json',
         success: function(response){
            $('#prize-box-all').html(response);
         }
       });
      }
}

</script>
    
</body>
</html>