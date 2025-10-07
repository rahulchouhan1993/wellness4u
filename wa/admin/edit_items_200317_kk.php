<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '14';
$edit_action_id = '37';

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
		header("Location: manage_items.php");
		exit(0);
	}
	elseif(count($arr_category_record) == 0)
	{
		header("Location: manage_items.php");
		exit(0);
	}
	
	
	$item_name = $arr_item_record['item_name'];
	$status = $arr_item_record['item_status'];
	
	$ingredient = array();
	$iig_id = array();
	$parent = array();
	$cat = array();
	$cat_show = array();
	$cat_id = array();
	
	foreach($arr_ingredient_record as $rec)
	{
		array_push($ingredient,$rec['ingredient_name']);
		array_push($iig_id,$rec['iig_id']);
	}
	
	foreach($arr_category_record as $rec)
	{
		array_push($parent,$rec['ic_cat_parent_id']);
		array_push($cat,$rec['ic_cat_id']);
		array_push($cat_show,$rec['ic_show']);
		array_push($cat_id,$rec['ic_id']);
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
						<input type="hidden" name="iig_id" id="iig_id" value="<?php echo $iig_id;?>" >
						<input type="hidden" name="ic_id" id="ic_id" value="<?php echo $cat_id;?>" >
						
						<div class="form-group"><label class="col-lg-2 control-label">Item Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="item_name" id="item_name" placeholder="Item Name" class="form-control" value="<?php echo $item_name; ?>">
							</div>
						</div>
						
						<?php for($i = 0; $i < count($arr_ingredient_record); $i++) { ?>
						<div id = "ingrd">
						<div class="form-group" ><label class="col-lg-2 control-label"><?php if ($i == 0) {?>Ingredients<span style="color:red">*</span><?php } ?></label>
							<div class="col-lg-4">
								<input type="text" name="ingredient_name" id="ingredient_name" placeholder="Ingredients" class="form-control" required value="<?php echo $ingredient[$i]; ?>">
							</div>
							<?php if ($i == 0) {?>
							<div class="col-lg-4">
								<a href="#" onclick="new_text();return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="fa fa-plus"></i></a>
							</div>
							<?php } ?>
							<?php if ($i == 1) {?>
							<div class="col-lg-4">
								<a href="#" onclick="delete_div();return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="fa fa-minus"></i></a>
							</div>
							<?php } ?>
						</div>
						</div>
						<?php  } ?>
						
						<?php for($i = 0; $i < count($arr_category_record); $i++) { ?>
						<div class="form-group"><label class="col-lg-2 control-label">Category <?php echo $i+1; ?><span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cat_id<?php echo $i+1; ?>" id = "cat_id<?php echo $i+1; ?>" class="form-control" onchange="getsubcat(<?php echo $i+1; ?>);">
									<?php echo $obj->GetCategories($parent[$i],'0'); ?>
								</select>
							</div>
							<div class="col-lg-4">
								<select name="sub_cat<?php echo $i+1; ?>" id = "sub_cat<?php echo $i+1; ?>" class="form-control">
									<?php echo $obj->GetCategories($cat[$i],$parent[$i]); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cat_show<?php echo $i+1; ?>" id = "cat_show<?php echo $i+1; ?>" class="form-control">
									<option>Select</option>
									<option value = '1' <?php if($cat_show[$i] == '1'){?> selected <?php } ?>>Show</option>
									<option value = '0' <?php if($cat_show[$i] == '0'){?> selected <?php } ?>> Don't Show</option>
								</select>
							</div>
						</div>
						<?php  } ?>
						
						
						
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
<script>
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