<?php

require_once('../classes/config.php');
require_once('../classes/vendor.php');

$page_id="";
$admin_main_menu_id = '';
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

$data=$obj->get_specifiq_data_DYL($_GET['DYL_id']);

// echo "<pre>";

// print_r($data);

// die('----');


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

                                        <?php echo $obj->getPageContents($page_id);  ?>
						</div>

					</div>            
                                

                   <div class="row">
                   	<div class="col-md-1"></div>
                     <div class="col-md-10">
                       <a href="manage_appt.php"><button class="btn btn-default">Back</button></a>
                       <div class="row">
                          <div class="col-md-3"></div>
                          <div class="col-md-6">
                            <?php if(!empty($data))
                              {
                                ?>
                                <form action="#">
                                <?php
                                foreach ($data as $key => $value) {
                                  ?>
                                  
                                    <div class="form-group">
                                      <label for="email">Specifiq Form Option:</label>
                                      <input type="text" class="form-control" readonly="" value="<?=$value['specifiq_text']?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Show on Form:</label>
                                      <select class="form-control">
                                        <option>Yes</option>
                                        <option>No</option>
                                      </select>
                                    </div>
                                  <?php
                                }
                                ?>
                                  <button type="submit" class="btn btn-default">Submit</button>
                                </form>
                                <?php
                              }
                              else
                              {
                                echo "No Extra form fields";
                              }
                            ?>
                          </div>
                          <div class="col-md-3"></div>
                       </div>
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


