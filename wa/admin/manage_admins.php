<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '2';
$view_action_id = '1';
$add_action_id = '2';
$edit_action_id = '3';
$delete_action_id = '4';

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

$txtsearch= '';
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
				<header class="panel-heading">
					<h2 class="panel-title"><?php echo $obj->getAdminMenuName($admin_main_menu_id);?></h2>
				</header>
				<div class="pull-right tooltip-show">
				<?php
				if($obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
				{ ?>
					<a href="<?php echo $obj->getAdminActionLink($add_action_id);?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $obj->getAdminActionName($add_action_id);?>" data-original-title=""><i class="fa fa-plus"></i></a>
				<?php
				} ?>	
				</div>
				<div class="space-30"></div>
				<?php
				if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
				{ ?>
				<div class="search-panel">
					<div class="row" >
						<div class="col-sm-4"><strong>Search:</strong>&nbsp;<br>
							<input type="text" id="txtsearch" name="txtsearch" value="<?php echo $txtsearch;?>" style="width:200px;" >
						</div>
						<div class="col-sm-4"><strong>Status:</strong>&nbsp;<br>
							<select name="status" id="status" class="form-control">
								<option value="" >All</option>
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>
						<div class="col-sm-4">
							<input type="button" id="btnsearch" name="btnsearch" value="Search" class="btn btn-primary btn-search" onclick="refineSearch();">
						</div>
					</div>
				</div>
				<?php
					} ?> 
				<div class="panel-body">
					<div class="se-pre-con"></div>
					<?php
					if($msg != '')
					{ ?>
						<?php echo $msg;?>
					<?php
					} ?>  
					
					<?php
					if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
					{ ?>
					<div id="subadmin"></div>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php');?>
<!--Common plugins-->
<?php require_once('script.php'); ?>
<script>
$(document).ready(function()
{ 
	<?php
	if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
	{ ?>
    var dataString ='action=adminlist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$("#subadmin").html(result);
		}
	});
	<?php
	} ?>
}); 

<?php
if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
{ ?>
function change_page(page_id)  
{
	var txtsearch = $("#txtsearch").val();
	var status = $("#status").val();
	var dataString ='page_id='+page_id +'&txtsearch='+escape(txtsearch) +'&status='+status+'&action=adminlist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#subadmin").html(result);
		}
	});
} 

function refineSearch()  
{
	var txtsearch = $("#txtsearch").val();
	var status = $("#status").val();
	var dataString ='txtsearch='+escape(txtsearch) +'&status='+status+'&action=adminlist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#subadmin").html(result);
		}
	});
} 
<?php
} ?>

<?php
if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
{ ?>	

function deleteMultipleAdmin()
{
	var favorite = [];
	var chkbox_records = "";
	$.each($("input[name='chkbox_records[]']:checked"), function(){            
		favorite.push($(this).val());
	});
	chkbox_records = favorite.join(",");
	if(chkbox_records == "")
	{
		BootstrapDialog.show({
			title: 'Error' +" "+" "+'Response',
			message:"Please select any record"
		}); 
	}
	else
	{
		var r = confirm("Are you sure to delete this record?");
		if (r == true) 
		{
			var dataString ='chkbox_records='+chkbox_records+'&action=deletemultipleadmin';
			$.ajax({
				type: "POST",
				url: "ajax/remote.php",
				data: dataString,
				cache: false,      
				success: function(result)
				{
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
						
					if(rslt==1)
					{
						window.location.href="manage_admins.php";  
					}
					else
					{
						BootstrapDialog.show({
							title: 'Error' +" "+" "+'Response',
							message:JSONObject[0]['msg']
						}); 
					}
				}
			});  
		}		
	}
}
<?php
} ?>
</script>
</body>
</html>