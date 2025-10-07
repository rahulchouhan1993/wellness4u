<?php 
   include('classes/config.php');
   $obj = new frontclass();
   $page_id = '46';
   
   $page_data = $obj->getPageDetails($page_id);
   $ref = base64_encode($page_data['menu_link']);
   if($obj->isLoggedIn())
   
   {
   
    $user_id = $_SESSION['user_id'];
   
    $obj->doUpdateOnline($_SESSION['user_id']);
   
   }
   else
   {
      echo "<script>window.location.href='login.php?ref=$ref'</script>";

      exit(0);   
   }
   $data = $obj->GetFeedBackData();

   // echo '<pre>';

   // print_r($data);

   // die();

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>    
      <?php include_once('head.php');?>
   </head>
   <body>
      <?php include_once('analyticstracking.php'); ?>
      <?php include_once('analyticstracking_ci.php'); ?>
      <?php include_once('analyticstracking_y.php'); ?>
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
               <div class="col-md-8">

                  <div class="row">
                     <div class="col-md-12"> 
                         <?php  echo $obj->getPageContents($page_id); ?>
                         <br>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                           <tr>
                              <td class="text-danger" style="font-size: : 11px;">(Click on below subject to view conversations)</td>
                           </tr>
                        </table>
                        <br>
                        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table table-striped table-hover">
                           <tr class="success">
                              <td width="9%"  align="left" valign="middle"><strong>Sr No.</strong></td>
                              <td width="20%"  align="left" valign="middle"><strong>Subject</strong></td>
                              <td width="51%"  align="left" valign="middle"><strong>Feedback</strong></td>
                              <td width="20%"  align="left" valign="middle"><strong>Date</strong></td>
                           </tr>
                           <?php  
                              foreach ($data as $key => $value) 
                                 # code...
                                 { 
                              
                                 $time = strtotime($value['feedback_add_date']);
                                 $time = $time + 19800;
                                 $date = date('d-M-Y h:i A',$time);
                                 $page_name = $obj->get_PageName($value['page_id']);
                                 if($page_name == '')
                                 {
                                    $page_name = 'General';
                                 }
                                 else
                                 {
                                    $page_name = $page_name;
                                 }
                                 ?>
                           <tr>
                              <td  align="center" valign="top"><?php echo $key+1; ?></td>
                              <td  align="left" valign="top"><a title="click here to view conversations" class="footer_link" href="view_feedback.php?id=<?=$value['feedback_id'];?>"><?php echo $page_name;  ?></a></td>
                              <td  align="left" valign="top"><?php echo $value['feedback']; ?></td>
                              <td  align="left" valign="top"><?php echo $date; ?></td>
                           </tr>
                           <?php } ?>
                        </table>
                     </div>
                  </div>

               </div>
               <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>
               <div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>
            </div>
         </div>
         </div>
         </div>
         </div>
      </section>
      <?php include_once('footer.php');?>  
   </body>
</html>