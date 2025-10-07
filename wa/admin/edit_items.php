<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '26';
$edit_action_id = '104';

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

if(isset($_GET['token']) && $_GET['token'] != '')
{
	//$adm_id = $_GET['id'];
	$item_id = base64_decode($_GET['token']);
	$arr_item_record = $obj->getItemDetails($item_id);
	$arr_ingredient_record = $obj->getingredientDetails($item_id);
	$arr_category_record = $obj->getcategoryDetails($item_id);
	if(count($arr_item_record) == 0)
	{
		header("Location: manage_items.php");
		exit(0);
	}
	elseif(count($arr_ingredient_record) == 0)
	{
		//header("Location: manage_items.php");
		//exit(0);
	}
	elseif(count($arr_category_record) == 0)
	{
		//header("Location: manage_items.php");
		//exit(0);
	}
	
	
	$item_name = stripslashes($arr_item_record['item_name']);
	$item_code = stripslashes($arr_item_record['item_code']);
	$status = $arr_item_record['item_status'];
	$item_disc1 = stripslashes($arr_item_record['item_disc1']);
	$item_disc2 = stripslashes($arr_item_record['item_disc2']);
	$item_disc_show1 = $arr_item_record['item_disc_show1'];
	$item_disc_show2 = $arr_item_record['item_disc_show2'];
	$ingredient_show = $arr_item_record['ingredient_show'];
	$ingredient_type_temp = $arr_item_record['ingredient_type'];
	
	if($ingredient_type_temp == '')
	{
		$ingredient_type = array();
	}
	else
	{
		$ingredient_type = explode(',',$ingredient_type_temp);
	}
	
	$ingredient_id = array();
	$parent = array();
	$cat = array();
	$cat_show = array();
	
	foreach($arr_ingredient_record as $rec)
	{
		array_push($ingredient_id,$rec['ingredient_id']);
	}
	
	foreach($arr_category_record as $rec)
	{
		array_push($parent,$rec['ic_cat_parent_id']);
		array_push($cat,$rec['ic_cat_id']);
		array_push($cat_show,$rec['ic_show']);
	}
	
	if(array_key_exists('1',$parent))
	{
		
	}
	else
	{
		$parent[1] = '';
	}
	
	if(array_key_exists('1',$cat))
	{
		
	}
	else
	{
		$cat[1] = '';
	}
	
	if(array_key_exists('1',$cat_show))
	{
		
	}
	else
	{
		$cat_show[1] = '';
	}
	
	if(array_key_exists('2',$parent))
	{
		
	}
	else
	{
		$parent[2] = '';
	}
	
	if(array_key_exists('2',$cat))
	{
		
	}
	else
	{
		$cat[2] = '';
	}
	
	if(array_key_exists('2',$cat_show))
	{
		
	}
	else
	{
		$cat_show[2] = '';
	}
	
	if(array_key_exists('3',$parent))
	{
		
	}
	else
	{
		$parent[3] = '';
	}
	
	if(array_key_exists('3',$cat))
	{
		
	}
	else
	{
		$cat[3] = '';
	}
	
	if(array_key_exists('3',$cat_show))
	{
		
	}
	else
	{
		$cat_show[3] = '';
	}
	
	if(array_key_exists('4',$parent))
	{
		
	}
	else
	{
		$parent[4] = '';
	}
	
	if(array_key_exists('4',$cat))
	{
		
	}
	else
	{
		$cat[4] = '';
	}
	
	if(array_key_exists('4',$cat_show))
	{
		
	}
	else
	{
		$cat_show[4] = '';
	}
}	
else
{
	header("Location: manage_area.php");
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
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="edit_items" name="edit_items" method="post"> 
						<input type="hidden" name="item_id" id="item_id" value="<?php echo $item_id;?>" >
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Item Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="item_name" id="item_name" placeholder="Item Name" class="form-control" value="<?php echo $item_name; ?>">
							</div>
							<label class="col-lg-2 control-label">Item Code</label>
							<div class="col-lg-4">
								<input type="text" name="item_code" id="item_code" placeholder="Item Code" class="form-control" value="<?php echo $item_code; ?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Item Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id1" id = "cat_id1" class="form-control" onchange="getsubcat(1);" required>
									<?php echo $obj->GetCategories($parent[0],0); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat1" id = "sub_cat1" class="form-control">
									<?php echo $obj->GetCategories($cat[0],$parent[0]); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show1" id = "cat_show1" class="form-control">
									<?php echo $obj->getShowHideOption($cat_show[0]); ?>
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
										<?php echo $obj->getShowHideOption($ingredient_show); ?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 1</label>
							<div class="col-lg-4">
								<select name="cat_id2" id = "cat_id2" class="form-control" onchange="getsubcat(2);" >
									<?php echo $obj->GetCategories($parent[1],0); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat2" id = "sub_cat2" class="form-control" >
									<?php echo $obj->GetCategories($cat[1],$parent[1]); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show2" id = "cat_show2" class="form-control">
									<?php echo $obj->getShowHideOption($cat_show[1]); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 2</label>
							<div class="col-lg-4">
								<select name="cat_id3" id = "cat_id3" class="form-control" onchange="getsubcat(3);">
									<?php echo $obj->GetCategories($parent[2],0); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat3" id = "sub_cat3" class="form-control">
									<?php echo $obj->GetCategories($cat[2],$parent[2]); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show3" id = "cat_show3" class="form-control">
									<?php echo $obj->getShowHideOption($cat_show[2]); ?>
								</select>
							</div>
						</div>
						
						
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 3</label>
							<div class="col-lg-4">
								<select name="cat_id4" id = "cat_id4" class="form-control" onchange="getsubcat(4);">
									<?php echo $obj->GetCategories($parent[3],0); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat4" id = "sub_cat4" class="form-control">
									<?php echo $obj->GetCategories($cat[3],$parent[3]); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show4" id = "cat_show4" class="form-control">
									<?php echo $obj->getShowHideOption($cat_show[3]); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Category 4</label>
							<div class="col-lg-4">
								<select name="cat_id5" id = "cat_id5" class="form-control" onchange="getsubcat(5);">
									<?php echo $obj->GetCategories($parent[4],0); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat5" id = "sub_cat5" class="form-control">
									<?php echo $obj->GetCategories($cat[4],$parent[4]); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show5" id = "cat_show5" class="form-control">
									<?php echo $obj->getShowHideOption($cat_show[4]); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Item Description 1</label>
							<div class="col-lg-8">
								<textarea id="item_disc_1" name="item_disc_1" class="form-control"><?php echo $item_disc1; ?></textarea>
							</div>
							<div class="col-lg-2">
								<select name="item_disc_show1" id = "item_disc_show1" class="form-control">
									<?php echo $obj->getShowHideOption($item_disc_show1); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Item Description 2</label>
							<div class="col-lg-8">
								<textarea id="item_disc_2" name="item_disc_2" class="form-control"><?php echo $item_disc2; ?></textarea>
							</div>
							<div class="col-lg-2">
								<select name="item_disc_show2" id = "item_disc_show2" class="form-control">
									<?php echo $obj->getShowHideOption($item_disc_show2); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="item_status" id="item_status" class="form-control">
									<option value="1" <?php if($status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>	
						
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
<!-- iCheck -->
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="admin-js/edit-items-validator.js" type="text/javascript"></script>
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