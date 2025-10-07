<?php 
   include('classes/config.php');
   $obj = new frontclass();
   $page_id = '47';
   
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

   $id = $_GET['id'];



   $data = $obj->GetFeedBackDataByID($id);


   if(empty($data))
   {
      echo "<script>window.location.href='feedback.php'</script>";

      exit(0);  
   }
   else
   {

      $feedback_page_name = $obj->get_PageName($data['page_id']);
      if($feedback_page_name == '')
      {
         $feedback_page_name = 'General';
      }
      else
      {
         $feedback_page_name = $feedback_page_name;
      }  

      $list=$obj->GetAllConvarsationByID($id);
   }


   // echo '<pre>';

   // print_r($data);

   // print_r($list);

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
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="">
                           <tr>
                              <td align="left" colspan="3"><strong>Subject: </strong><?php echo $feedback_page_name; ?></td>

                              <td height="30" align="right">

                                 <input type="button" id="btnback" name="btnback" value="Back" onclick="window.location.href = 'feedback.php'" />

                              </td>
                           </tr>
                        </table>
                        <br>
                        <form action="#" name="frmviewfeedback" id="frmviewfeedback" method="post">
                           <input type="hidden" name="hdn_id" id="hdn_id" value="<?php echo $id; ?>" />
                           <table width="100%" cellpadding="5" cellspacing="1" class="table table-bordered table-hover">
                              <tr>
                                 <td colspan="6" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Conversation Thread</strong></td>
                              </tr>
                              <tr class="danger">
                                 <td width="7%" height="30"  align="center" valign="middle" ><strong>SNo.</strong></td>
                                 <td width="33%"  align="left" valign="middle" ><strong>Feedback</strong></td>
                                 <td width="15%"  align="left" valign="middle" ><strong>From</strong></td>
                                 <td width="15%"  align="left" valign="middle" ><strong>To</strong></td>
                                 <td width="20%"  align="left" valign="middle" ><strong>Date</strong></td>
                                 <td width="10%"  align="left" valign="middle" ><strong>Reply</strong></td>
                              </tr>
                              <tr>
                                 <td  height="30" align="center" valign="top" >#</td>
                                 <td  align="left" valign="top"><?php echo $data['feedback']; ?></td>
                                 <td  align="left" valign="top" >You</td>
                                 <td  align="left" valign="top" >Admin</td>
                                 <td  align="left" valign="top" ><?php echo date("d-M-Y h:i A", strtotime($data['feedback_add_date'])); ?></td>
                                 <td  align="center" valign="top"  >
                                    <?php if(empty($list)) { ?>

                                    <input type="button" id="btnback" name="btnback" value="Update" onclick="FeedBackFormUpdate('<?php echo $id; ?>')" />

                                    <?php  } ?>
                                 </td>
                              </tr>
                              <?php  
                              foreach ($list as $key => $value) 
                                 { 
                                                         
                                    $time= strtotime($value['feedback_add_date']);
                                    $time=$time+19800;
                                    $date = date('d-M-Y h:i A',$time);
                                    if($value['admin'] == '0')
                                    {
                                       $to = 'Admin';
                                    }else
                                    {
                                       $to = 'You';
                                 
                                    }
                                 
                                    if($value['admin'] == '1')
                                    {
                                 
                                        $from = 'Admin ('.$value["name"].')';
                                    }else
                                    {

                                       $from = 'You';
                                 
                                     }
                                 
                                 ?>
                              <tr <?=($value['admin']==1)? 'class="warning"' : 'class="active"' ?>>
                                 <td  height="30" align="center" valign="top" ><?php echo $key+1; ?></td>
                                 <td  align="left" valign="top"><?php echo $value['feedback']; ?></td>
                                 <td  align="left" valign="top" ><?php echo $from; ?></td>
                                 <td  align="left" valign="top" ><?php echo $to; ?></td>
                                 <td  align="left" valign="top" ><?php echo $date; ?></td>
                                 <td  align="center" valign="top"  >
                                    <?php if($value['admin'] == '1' && $key==0) { ?>
                                    <input style="width:45px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="FeedBackFormReply('<?php echo $value['feedback_id']; ?>')"/>
                                    <?php  } ?>
                                    <?php if($value['admin'] == '0' && $key==0) { ?>
                                    <input style="width:55px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Update" onclick="FeedBackFormUpdate('<?php echo $value['feedback_id']; ?>')"/>
                                    <?php  } ?>
                                 </td>
                              </tr>
                              <?php  } ?>
                           </table>
                        </form>
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


<script type="text/javascript">
   function FeedBackFormReply(feedback_id="")
   {  

      var dataString ='action=feedback_form_reply&feedback_id='+feedback_id;

      $.ajax({

         type: "POST",

         url: "remote.php",

         data: dataString,

         cache: false,

         success: function(result)

         {

        BootstrapDialog.show({

                   title: 'Feedback Reply Form',

                   message:result

               });

         }

      });

   }

   function feedback_reply()
   {
      var feedback=$('#feedback').val();
      var parent_id=$('#parent_id').val();
      var page_id=$('#page_id').val();
      if(feedback=='')
      {
          alert('Feedback reply is empty');
      }
      else
      {  

         var dataString ='action=feedback_reply_save&parent_id='+parent_id+'&page_id='+page_id+'&feedback='+feedback;

             $.ajax({

            type: "POST",

            url: "remote.php",

            data: dataString,

            cache: false,

            success: function(result)

            {

               if(result==true)
               {
                  alert('Reply Send to admin!');
               }
               else
               {
                  alert('try later!');
               }
               location.reload();
            }

         });
      }

     
   }

   function FeedBackFormUpdate(feedback_id="")
   {  

      var dataString ='action=feedback_form_update&feedback_id='+feedback_id;

      $.ajax({

         type: "POST",

         url: "remote.php",

         data: dataString,

         cache: false,

         success: function(result)

         {

        BootstrapDialog.show({

                   title: 'Feedback Update Form',

                   message:result

               });

         }

      });

   }

   function feedback_update()
   {
      var feedback_id=$('#feedback_id').val();
      var feedback_old=$('#feedback_old').val();
      var feedback_new=$('#feedback_new').val();
      if(feedback_new=='')
      {
          alert('Feedback update is empty');
      }
      else
      {  

         var dataString ='action=feedback_update_save&feedback_id='+feedback_id+'&feedback_old='+feedback_old+'&feedback_new='+feedback_new;

             $.ajax({

            type: "POST",

            url: "remote.php",

            data: dataString,

            cache: false,

            success: function(result)

            {

               if(result==true)
               {
                  alert('Reply updated!');
               }
               else
               {
                  alert('try later!');
               }
               location.reload();
            }

         });
      }

     
   }


</script>