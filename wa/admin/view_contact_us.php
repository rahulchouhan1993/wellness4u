<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '22';
$view_action_id = '65';

$obj = new Admin();
$obj_comm = new commonFunctions();
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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
{
	header("Location: invalid.php");
	exit(0);
}

$error = false;
$err_msg = "";
$msg = '';

if(isset($_GET['token']) && $_GET['token'] != '')
{
	$cu_id = base64_decode($_GET['token']);
	$record = $obj->getContactUsDetails($cu_id);
	if(count($record) == 0)
	{
		header("Location: manage_contact_us.php");
		exit(0);
	}
	
	$location = $obj->getTopLocationStr($record['contactus_city_id'],$record['contactus_area_id']);
			
	$contactus_parent_cat_id_str = $obj->getCategoryName($record['contactus_parent_cat_id']);
	if($record['contactus_parent_cat_id'] == '157')
	{
		$contactus_parent_cat_id_str .= ' - '.$record['contactus_parent_cat_other'];
	}
	
	$contactus_cat_id_str = $obj->getCategoryName($record['contactus_cat_id']);
	if($record['contactus_cat_id'] == '161' || $record['contactus_cat_id'] == '158' || $record['contactus_cat_id'] == '159')
	{
		$contactus_cat_id_str .= ' - '.$record['contactus_cat_other'];
	}
	
	$contactus_speciality_id_str = $obj->getCommaSepratedCategoryName($record['contactus_speciality_id']);
	$temp_arr = explode(',',$record['contactus_speciality_id']);
	if(is_array($temp_arr) && count($temp_arr) > 1)
	{
		if(in_array('999999999',$temp_arr))
		{
			$contactus_speciality_id_str .= ', Others - '.stripslashes($record['contactus_speciality_other']).' ';
		}
	}
	else
	{
		if($record['contactus_speciality_id']== '999999999')
		{
			$contactus_speciality_id_str = 'Others - '.stripslashes($record['contactus_speciality_other']).' ';
		}
	}
	
	$contactus_item_id_str = $obj->getCommaSepratedItemName($record['contactus_item_id']);
	$temp_arr2 = explode(',',$record['contactus_item_id']);
	if(is_array($temp_arr2) && count($temp_arr2) > 1)
	{
		if(in_array('999999999',$temp_arr2))
		{
			$contactus_item_id_str .= ', Others - '.stripslashes($record['contactus_item_other']).' ';
		}
	}
	else
	{
		if($record['contactus_item_id']== '999999999')
		{
			$contactus_item_id_str = 'Others - '.stripslashes($record['contactus_item_other']).' ';
		}
	}
}	
else
{
	header("Location: manage_contact_us.php");
	exit(0);
}	
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
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($view_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="edit_order" name="edit_order" method="post"> 
						<input type="hidden" name="hdncu_id" id="hdncu_id" value="<?php echo $cu_id;?>" >
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Name:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $record['contactus_name'];?></label>
							
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Email:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $record['contactus_email'];?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Contact No:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $record['contactus_contact_no'];?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Location:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $location;?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Query Type:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $contactus_parent_cat_id_str;?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Support/Query Sub Type:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $contactus_cat_id_str;?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Speciality:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $contactus_speciality_id_str;?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Items:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $contactus_item_id_str;?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>No of People:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $record['contactus_no_of_people'];?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Additional Information:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo $record['contactus_comments'];?></label>
						</div>	
						<div class="form-group">
							<label class="col-lg-3 control-label"><strong>Enquiry Date:</strong></label>
							<label class="col-lg-9 control-label" style="text-align:left;"><?php echo date('d-M-Y H:ia',strtotime($record['cu_add_date']));?></label>
						</div>	
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<a href="manage_contact_us.php"><button type="button" class="btn btn-danger rounded">Back</button></a>
								</div>
							</div>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php');?>
<!--Common plugins-->
<?php require_once('script.php'); ?>
</body>
</html>