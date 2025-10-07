<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '14';
$add_action_id = '36';

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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	header("Location: invalid.php");
	exit(0);
}


$error = false;
$err_msg = "";
$msg = '';

$arr_selected_am_id = array();
$arr_selected_aa_id = array();
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
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="add_items" name="add_items" method="post"> 
					
						<div class="form-group"><label class="col-lg-2 control-label">Item Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="item_name" id="item_name" placeholder="Item Name" class="form-control">
							</div>
						</div>
						
						<div id = "ingrd">
						<div class="form-group" ><label class="col-lg-2 control-label">Ingredients<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="ingredient_name" id="ingredient_name" placeholder="Ingredients" class="form-control" required>
							</div>
							<div class="col-lg-4">
								<a href="#" onclick="new_text();return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="fa fa-plus"></i></a>
							</div>
						</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Category 1<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id1" id = "cat_id1" class="form-control" onchange="getsubcat(1);">
									<?php echo $obj->GetCategories('14','0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat1" id = "sub_cat1" class="form-control">
									<?php echo $obj->GetCategories($sub_cat1,'14'); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show1" id = "cat_show1" class="form-control">
									<option>Select</option>
									<option value = '1'>Show</option>
									<option value = '0'> Don't Show</option>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 2<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id2" id = "cat_id2" class="form-control" onchange="getsubcat(2);">
									<?php echo $obj->GetCategories('19','0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat2" id = "sub_cat2" class="form-control">
									<?php echo $obj->GetCategories($sub_cat2,'19'); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show2" id = "cat_show2" class="form-control">
									<option>Select</option>
									<option value = '1'>Show</option>
									<option value = '0'> Don't Show</option>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 3<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id3" id = "cat_id3" class="form-control" onchange="getsubcat(3);">
									<?php echo $obj->GetCategories($cat_id3,'0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat3" id = "sub_cat3" class="form-control" >
									<option value="">Select Category</option>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show3" id = "cat_show3" class="form-control">
									<option>Select</option>
									<option value = '1'>Show</option>
									<option value = '0'> Don't Show</option>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 4<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id4" id = "cat_id4" class="form-control" onchange="getsubcat(4);">
									<?php echo $obj->GetCategories($cat_id4,'0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat4" id = "sub_cat4" class="form-control">
									<option value="">Select Category</option>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show4" id = "cat_show4" class="form-control">
									<option>Select</option>
									<option value = '1'>Show</option>
									<option value = '0'> Don't Show</option>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 5<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id5" id = "cat_id5" class="form-control" onchange="getsubcat(5);">
									<?php echo $obj->GetCategories($cat_id5,'0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat5" id = "sub_cat5" class="form-control">
									<option value="">Select Category</option>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show5" id = "cat_show5" class="form-control">
									<option>Select</option>
									<option value = '1'>Show</option>
									<option value = '0'> Don't Show</option>
								</select>
							</div>
						</div>
						
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_items.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="admin-js/add-items-validator.js" type="text/javascript"></script>

<script>
$(document).ready(function () {
		 
	
	 });
	 
		function new_text()
		{
			 var new_row ='<div class ="form-group"><div class="col-lg-4 col-lg-offset-2">'+
							'<input type="text" name="ingredient_name" id="ingredient_name" placeholder="Ingredients" class="form-control">'+
						'</div>'+
						'<div class="col-lg-1">'+
							'<a href="#" onclick="delete_div();return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="fa fa-minus"></i></a>'+
						'</div></div>';
            
            $('#ingrd').append(new_row);
		}
		
		function delete_div()
		{
			$('#ingrd').children('div:last').remove();
		}
	
	
	
	function getsubcat(id)
	{
		var cat_id = $('#cat_id'+id).val();
		var sub_cat = $('#sub_cat'+id).val();
		
		var dataString ='cat_id='+cat_id+'&sub_cat='+sub_cat+'&action=getsubcat';
        $.ajax({
       type: "POST",
       url: "ajax/remote.php",
       data: dataString,
       cache: false,      
        success: function(result)
            {
               $("#sub_cat"+id).html(result);
            }
         }); 
         
	}
	
	
	
	
</script>
</body>
</html>