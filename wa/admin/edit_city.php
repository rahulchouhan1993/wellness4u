<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '12';
$edit_action_id = '29';

$obj = new Admin();
$obj2 = new commonFunctions();
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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	header("Location: invalid.php");
	exit(0);
}

$error = false;
$err_msg = "";
$msg = '';
$arr_selected_am_id = array();
$arr_selected_aa_id = array();

if(isset($_GET['token']) && $_GET['token'] != '')
{
	//$adm_id = $_GET['id'];
	$city_id = base64_decode($_GET['token']);
	$arr_city_record = $obj->getCityDetails($city_id);
	if(count($arr_city_record) == 0)
	{
		header("Location: manage_cities.php");
		exit(0);
	}
	
	$country_id = $arr_city_record['country_id'];
	$state_id = $arr_city_record['state_id'];
	$city_name = $arr_city_record['city_name'];
	$status = $arr_city_record['city_status'];
	
}	
else
{
	header("Location: manage_cities.php");
	exit(0);
}	
$arr_am_records = $obj->getAllMenuAccess(); 
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Admin</title>
	<?php require_once 'head.php'; ?>
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
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="edit_city" name="edit_city" method="post"> 
						<input type="hidden" name="city_id" id="city_id" value="<?php echo $city_id;?>" >
						
						<div class="form-group"><label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="country_id" id = "country_id" class="form-control" onchange="getstate();">
									<option value="" >Select Country</option>
									<?php echo $obj->GetCountry($country_id); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">State<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="state_id" id = "state_id" class="form-control">
									<?php echo $obj->GetState($state_id,$country_id); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">City Name<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="city_name" id="city_name" placeholder="City Name" class="form-control" value="<?php echo $city_name;?>" required>
							</div>
						</div>							
						
						<div class="form-group"><label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="city_status" id="city_status" class="form-control">
									<option value="1" <?php if($status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>	
						
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_cities.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<!-- iCheck -->
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="admin-js/edit-city-validator.js" type="text/javascript"></script>
<script>
	function getstate()
	{
		var country = $('#country_id').val();
		var state = $('#state_id').val();
		
		var dataString ='country='+country+'&state='+state+'&action=getstate';
        $.ajax({
       type: "POST",
       url: "ajax/remote.php",
       data: dataString,
       cache: false,      
        success: function(result)
            {
               $("#state_id").html(result);
            }
         }); 
         
	}
</script>
</body>
</html>