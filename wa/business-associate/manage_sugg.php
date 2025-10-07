<?php

require_once('../classes/config.php');
require_once('../classes/vendor.php');

$page_id="46";
$admin_main_menu_id = '30';
$view_action_id = '118';
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

$data = $obj->GetFeedBackData();

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
                                       <?php echo $obj->getPageIcon($page_id);?>
                                        <?php echo $obj->getPageContents($page_id);  ?>
						</div>

					</div>            
                                

                   <div class="row">
                   	<div class="col-md-1"></div>
                     <div class="col-md-10">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                           <tr>
                              <td class="text-danger" style="font-size: : 11px;">(Click on below subject to view conversations)</td>
                           </tr>
                        </table>
                        <br>
                        <table width="100%" align="center" cellpadding="5" cellspacing="1" class="table table-bordered table-hover">
                        	<thead>
                        		<tr class="success">
	                              <td width="10%"  align="left" valign="middle"><strong>Sr No.</strong></td>
	                              <td width="25%"  align="left" valign="middle"><strong>Subject</strong></td>
	                              <td width="45%"  align="left" valign="middle"><strong>Feedback</strong></td>
	                              <td width="20%"  align="left" valign="middle"><strong>Date</strong></td>
                           		</tr>
                        	</thead>
                           <tbody>
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
                              <td  align="left" valign="top"><a title="click here to view conversations" class="footer_link" href="view_conversation.php?id=<?=$value['feedback_id'];?>"><?php echo $page_name;  ?></a></td>
                              <td  align="left" valign="top"><?php echo $value['feedback']; ?></td>
                              <td  align="left" valign="top"><?php echo $date; ?></td>
                           </tr>
                           <?php } ?>
                           </tbody>
                        </table>
                     </div>
                     <div class="col-md-1"></div>
                  </div>               


				</div>

			</div>

		</div>

      <div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>

	</div>

</div>


<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>