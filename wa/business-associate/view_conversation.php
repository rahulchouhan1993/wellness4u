<?php

require_once('../classes/config.php');
require_once('../classes/vendor.php');

$page_id="47";
$admin_main_menu_id = '31';
$view_action_id = '';
$add_action_id = '';
$edit_action_id = '';
$delete_action_id = '';

$obj = new Vendor();
if(!$obj->isVendorLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$adm_vendor_id = $_SESSION['adm_vendor_id'];
}

// if(!$obj->chkIfAccessOfMenu($adm_vendor_id,$admin_main_menu_id))
// {
// 	header("Location: invalid.php");
// 	exit(0);
// }

if(isset($_GET['msg']) && $_GET['msg'] != '')
{
	$msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.urldecode($_GET['msg']).'</strong></div>';
}
else
{
	$msg = '';
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

?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Business Associates</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-10">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>  

					<div class="row ">

						<div class="col-md-12">

							<center><div id="error_msg" style="color: red;"><?php if($error) { echo $err_msg; } ?></div></center>

                                        <?php echo $obj->getPageContents($page_id);  ?>
						</div>

					</div>  


               <div class="row">
                     <div class="col-md-12">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="">
                           <tr>
                              <td align="left" colspan="3"><strong>Subject: </strong><?php echo $feedback_page_name; ?></td>

                              <td height="30" align="right">

                                 <input type="button" id="btnback" name="btnback" value="Back" onclick="window.location.href = 'manage_sugg.php'" />

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

			</div>

		</div>

	</div>

   <div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>

</div>


<!-- Modal -->
<div id="formModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script type="text/javascript">

   function FeedBackFormReply(feedback_id="")
   {  

      var dataString ='action=feedback_form_reply&feedback_id='+feedback_id;

      $.ajax({

         type: "POST",

         url: "ajax/remote.php",

         data: dataString,

         cache: false,

         success: function(result)

         {  

            $('#formModal .modal-title').html('Feedback Reply Form');
            $('#formModal .modal-body').html(result);
            $('#formModal').modal('show');

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

            url: "ajax/remote.php",

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

         url: "ajax/remote.php",

         data: dataString,

         cache: false,

         success: function(result)

         {  

            $('#formModal .modal-title').html('Feedback Update Form');
            $('#formModal .modal-body').html(result);
            $('#formModal').modal('show');

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

            url: "ajax/remote.php",

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