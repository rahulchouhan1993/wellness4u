<?php

include('classes/config.php');

$obj = new frontclass();

$page_id = '110';

$main_page_id = $page_id;

$page_data = $obj->getPageDetails($page_id);

$ref = base64_encode($page_data['menu_link']);

if(!$obj->isLoggedIn())

{

	header("Location: login.php?ref=".$ref);

	exit(0);

}

else

{

	$user_id = $_SESSION['user_id'];

	$obj->doUpdateOnline($_SESSION['user_id']);


}


$plans=$obj->getUserSubcriptionPlans();

$page_dd=$obj->get_page_dropdown_data(21);

$plans = array_unique($plans, SORT_REGULAR);


?>

<!DOCTYPE html>

<html lang="en">

  <head>    
  <?php include_once('head.php');?>

   <style type="text/css">
     table tr th {
      text-align: center;
     }
   </style>
  </head>

  <body>
<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>
  <?php include_once('header.php');?>

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

  <div class="col-md-8">	

                <?php echo $obj->getPageIcon($page_id);?>
                <span class="Header_brown"><?php echo $page_data['page_title'];?></span><br /><br />
                <?php echo $obj->getPageContents($page_id);?>
              

               <!-- <?php //echo //viewUserPlans($user_id,''); ?> -->


            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                <?php 
                  if(!empty($plans))
                  {

                    ?>
                    <table class="table table-condensed table-hover text-center">
                        <thead>
                          <tr>
                            <th><h3><b>&nbsp;</h3></b></th>
                            <?php
                            for ($i=0; $i < count($plans); $i++) { 
                                  ?>  
                                      <th><h3><b><?=$plans[$i]['up_name'];?></h3>
                                        <br>
                                        <?php 
                                           $cat_name=$obj->getPlanCategory($plans[$i]['upct_id']);
                                                if(empty($cat_name))
                                                {
                                                  $cat_name='N/A';                                                
                                                }
                                                echo '('.$cat_name.')';
                                        ?>
                                      </b></th>
                                  <?php
                                }
                              ?>  
                            </tr>
                          </thead>
                          <tbody>
                                <tr>
                                  <td>Price</td>
                                  <?php
                                  for ($i=0; $i < count($plans); $i++) { 
                                        ?>
                                            <td><?=$plans[$i]['up_amount'];?> <?=$obj->getFavCode($plans[$i]['up_currency']);?></td>
                                        <?php
                                      }
                                    ?>
                                </tr>

                                <tr>
                                  <td>Duration</td>
                                  <?php
                                  for ($i=0; $i < count($plans); $i++) { 
                                        ?>
                                            <td><?=$plans[$i]['up_duration'];?> Days</td>
                                        <?php
                                      }
                                    ?>
                                </tr>

                                <tr>
                                  <td>Bonus Points</td>
                                  <?php
                                  for ($i=0; $i < count($plans); $i++) { 
                                        ?>
                                            <td><?=$plans[$i]['up_points'];?></td>
                                        <?php
                                      }
                                    ?>
                                </tr>

                                <tr>
                                   <td>Plan Gift</td>
                                  <?php
                                  for ($i=0; $i < count($plans); $i++) { 
                                        ?>
                                            <td><?=(empty($plans[$i]['prize_list']))? 'No' : 'Yes';?></td>
                                        <?php
                                      }
                                    ?>
                                </tr>

                                <!-- <tr>
                                   <td>Pages</td>
                                  <?php
                                  for ($i=0; $i < count($plans); $i++) { 
                                        ?>
                                            <td><?=$obj->get_access_page_of_plans($plans[$i]['up_id']);?></td>
                                        <?php
                                      }
                                    ?>
                                </tr> -->

                                <?php 

                                if(!empty($page_dd['page_id_str']))
                                {
                                   $page_ids=explode(',', $page_dd['page_id_str']);
                                   foreach ($page_ids as $key => $value) 
                                   {
                                    ?>
                                    <tr>
                                      <td><?=$obj->get_PageName($value)?></td>
                                      <?php
                                      for ($i=0; $i < count($plans); $i++) { 
                                            ?>
                                                <td><?=$obj->get_plan_feature_info($plans[$i]['up_id'],$value);?></td>
                                            <?php
                                          }
                                        ?>
                                    </tr>
                                    <?php
                                   }
                                }

                                ?>

                                <tr>
                                  <td></td>
                                  <?php
                                  for ($i=0; $i < count($plans); $i++) { 
                                        ?>
                                            <td><a class="btn btn-info" href="javascript:void(0)" onclick="confirm_plan(<?=$plans[$i]['up_id'];?>)"> Buy Now »</a></td>
                                        <?php
                                      }
                                    ?>
                                </tr>
                            </tbody>
                        </table>

                    </table>
                    <?php
                  }
                ?>
              </div>
              </div>
            </div>

    </div>

    <div class="col-md-2">  

               <?php include_once('left_sidebar.php'); ?>

              </div>

      <div class="col-md-2">  

               <?php include_once('right_sidebar.php'); ?>

              </div>

    </div>

</div>

<!--container-->    


<!--  Footer-->

<?php include_once('footer.php');?>    

<script type="text/javascript">

  function confirm_plan(plan_id)
  {
    if(plan_id=='')
    {
      alert('something is missing!');
      return false;
    }

    $.ajax({
     url:'remote.php',
     method: 'post',
     data: {action: 'confirm_user_subcription_plan_form',plan_id:plan_id},
     //dataType: 'json',
     success: function(response){
        //alert(response);  

        BootstrapDialog.show({

                            title: 'Confirm payment of plan',

                            message:response

                    }); 
     }
    }); 
  }
  function buy_plan(plan_id) 
  {
    
    var pay_mode=$('#up_payment_mode').val();
    var pay_info=$('#up_payment_details').val();
    var prize_id=$('input[name="prize_id"]:checked').val();

    if(plan_id=='' || pay_mode=='' || pay_info=='')
    {
      alert('Required field in empty!');
      return false;
    }

    $.ajax({
     url:'remote.php',
     method: 'post',
     data: {action: 'buy_user_subcription_plan',plan_id:plan_id,pay_mode:pay_mode,pay_info:pay_info,prize_id:prize_id},
     //dataType: 'json',
     success: function(response){
        //alert(response);  
        if(response==true)
        {
          alert('Your plan request submit successfully, after verifying payment it will be applicable your account');
        }
        else
        {
          alert('process failed, try Later!');
        }    
        location.reload();
     }
   });
  }
</script>    
       

</body>

</html>

