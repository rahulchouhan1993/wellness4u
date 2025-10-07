<?php

require_once('../classes/config.php');
require_once('../classes/admin.php');

$page_id="215";
$admin_main_menu_id = '28';
$view_action_id = '110';
$add_action_id = '111';
$edit_action_id = '112';
$delete_action_id = '113';

$obj = new Admin();

if(!$obj->isAdminLoggedIn())

{

   header("Location: login.php");

   exit(0);

}

else

{

   $admin_id = $_SESSION['admin_id'];

}



if(!$obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))

{

   header("Location: invalid.php");

   exit(0);

}

if(isset($_GET['msg']) && $_GET['msg'] != '')
{
	$msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.urldecode($_GET['msg']).'</strong></div>';
}
else
{
	$msg = '';
}

$data = $obj->get_DLY_for_appointment('717');

?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Admin</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-12">

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
                        <table width="100%" align="center" cellpadding="5" cellspacing="1" class="table table-bordered table-hover">
                        	<thead>
                        		<tr class="info">
	                              <td width="5%" align="center" valign="middle"><strong>#</strong></td>
	                              <td width="15%" align="left" valign="middle"><strong>Reference Code</strong></td>
	                              <td width="15%" align="left" valign="middle"><strong>Group Code </strong></td>
                                 <td width="25%" align="left" valign="middle"><strong>Headers </strong></td>
	                              <td width="15%" align="left" valign="middle"><strong>Date</strong></td>
                                 <td width="25%" align="left" valign="middle"><strong>Action</strong></td>
                           		</tr>
                        	</thead>
                           <tbody>
                           <?php  
                              foreach ($data as $key => $value) 
                                 # code...
                                 { 
                                 ?>
                           <tr>
                              <td align="center" valign="top"><?php echo $key+1; ?></td>
                              <td align="left" valign="top"><?php echo $value['ref_code']; ?></td>
                              <td align="left" valign="top"><?php echo $obj->getFavCategoryNameVivek($value['group_code_id']); ?></td>
                              <td align="left" valign="top">
                                          <?php echo $value['level_heading']; ?> <br>
                                          <?php echo $value['level_title'];?>&nbsp;<?php echo $value['level_title_heading'];?>
                                          </td>
                              <td align="left" valign="top"><?php echo date('d-M-Y',strtotime($value['add_date'])); ?></td>
                              <td align="left" valign="top" >
                              		<a href="update-appt-specifiq.php?DYL_id=<?=$value['id'];?>" target="_blank"><button>Form Setting</button></a>
                              		<br> &nbsp; <br>
                              		<a href="<?=MAIN_URL;?>appointment-request.php?ref_code=<?=$value['ref_code'];?>&group_id=<?=$value['group_code_id'];?>&vendor_id=<?=$adm_vendor_id;?>" target="_blank"><button>Form Preview</button></a>
                              </td>
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


	</div>

</div>


<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>