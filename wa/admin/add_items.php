<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '26';
$add_action_id = '103';

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

$ingredient_id = array();
$ingredient_type = array();

$error = false;
$err_msg = "";
$msg = '';

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
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="add_items" name="add_items" method="post"> 
					
						<div class="form-group">
							<label class="col-lg-2 control-label">Item Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="item_name" id="item_name" placeholder="Item Name" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Item Code</label>
							<div class="col-lg-4">
								<input type="text" name="item_code" id="item_code" placeholder="Item Code" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Item Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id1" id = "cat_id1" class="form-control"  onchange="getsubcat(1);"  required>
									<?php echo $obj->GetCategories('14','0');?>
								<select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat1" id = "sub_cat1" class="form-control">
									<?php echo $obj->GetCategories($sub_cat1,'14'); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show1" id = "cat_show1" class="form-control">
									<?php echo $obj->getShowHideOption(''); ?>
								</select>
							</div>
						</div>
						
						<div id = "ingrd">
							<div class="form-group" >
								<label class="col-lg-2 control-label">Ingredient Type</label>
								<div class="col-lg-8">
									<select name="ingredient_type" id="ingredient_type" multiple="multiple" class="form-control" onchange="getIngredientsByIngrdientType()">
										<?php echo $obj->getMainCategoryOption('14',$ingredient_type,1,1); ?>
									</select>
								</div>
								
							</div>	
							<div class="form-group" >
								<label class="col-lg-2 control-label">Ingredients</label>
								<div class="col-lg-8">
									<select name="ingredient_id" id="ingredient_id" multiple="multiple" class="form-control" >
										<option>Select Ingredients</option>
										<?php echo $obj->getIngredientsByIngrdientType($ingredient_type,$ingredient_id); ?>
									</select>
								</div>
								
								<div class="col-lg-2">
									<select name="ingredient_show" id="ingredient_show" class="form-control" required>
										<?php echo $obj->getShowHideOption(''); ?>
									</select>
								</div>
							</div>
							
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 1</label>
							<div class="col-lg-4">
								<select name="cat_id2" id = "cat_id2" class="form-control" onchange="getsubcat(2);"  >
									<?php echo $obj->GetCategories('1','0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat2" id = "sub_cat2" class="form-control" >
									<?php echo $obj->GetCategories($sub_cat2,'1'); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show2" id = "cat_show2" class="form-control">
									<?php echo $obj->getShowHideOption(''); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 2</label>
							<div class="col-lg-4">
								<select name="cat_id3" id = "cat_id3" class="form-control" onchange="getsubcat(3);" >
									<?php echo $obj->GetCategories($cat_id3,'0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat3" id = "sub_cat3" class="form-control">
									<option value="">Select Category</option>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show3" id = "cat_show3" class="form-control">
									<?php echo $obj->getShowHideOption(''); ?>
								</select>
							</div>
						</div>
						
						
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 3</label>
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
									<?php echo $obj->getShowHideOption(''); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 4</label>
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
									<?php echo $obj->getShowHideOption(''); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Item Description 1</label>
							<div class="col-lg-8">
								<textarea id="item_disc_1" name="item_disc_1" class="form-control"></textarea>
							</div>
							<div class="col-lg-2">
								<select name="item_disc_show1" id = "item_disc_show1" class="form-control">
									<?php echo $obj->getShowHideOption(''); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Item Description 2</label>
							<div class="col-lg-8">
								<textarea id="item_disc_2" name="item_disc_2" class="form-control"></textarea>
							</div>
							<div class="col-lg-2">
								<select name="item_disc_show2" id = "item_disc_show2" class="form-control">
									<?php echo $obj->getShowHideOption(''); ?>
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
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="js/tokenize2.js"></script>
<script>
$(document).ready(function(){
	$('#ingredient_type').tokenize2({sortable: true});
	$('#ingredient_type').on('tokenize:tokens:add', getIngredientsByIngrdientType);
	$('#ingredient_type').on('tokenize:tokens:remove', getIngredientsByIngrdientType);
	$('#ingredient_id').tokenize2({sortable: true});
});	 
		function new_text()
		{
			 var new_row ='<div class ="form-group"><div class="col-lg-4 col-lg-offset-2">'+
							'<input type="text" name="ingredient_name" id="ingredient_name" placeholder="Ingredients" class="form-control">'+
						'</div>'+
						'<div class="col-lg-1">'+
							'<a href="#" onclick="delete_div();return false;"  class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="fa fa-minus"></i></a>'+
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
				//alert(result);
               $("#sub_cat"+id).html(result);
            }
         }); 
         
	}
</script>
</body>
</html>