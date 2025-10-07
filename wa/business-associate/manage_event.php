<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '11';

$view_action_id = '25';

$add_action_id = '21';

$edit_action_id = '22';



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



if(!$obj->chkIfAccessOfMenu($adm_vendor_id,$admin_main_menu_id))

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

$cucat_parent_cat_id = '';

$cucat_cat_id = '';

$vendor_id = '';

$added_by_admin = '';

$added_days_of_month = '';

$added_days_of_week = '';

$added_single_date = '';

$added_start_date = '';

$added_end_date = '';



$country_id = '';

$state_id = '';

$city_id = '';

$area_id = '';

$delivery_date = '';



$added_show_days_of_month = 'none';

$added_show_days_of_week = 'none';

$added_show_single_date = 'none';

$added_show_start_date = 'none';

$added_show_end_date = 'none';

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

		<div class="col-md-10">

			<div class="panel">

				<header class="panel-heading">

					<h2 class="panel-title"><?php echo $obj->getAdminMenuName($admin_main_menu_id);?></h2>

				</header>

				<div class="pull-right">

				<?php

				if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$add_action_id))

				{ 

                                 //echo 'hiiii';   

                                 ?>

					<a href="<?php echo $obj->getAdminActionLink($add_action_id);?>" class="btn btn-default btn-sm" title="<?php echo $obj->getAdminActionName($add_action_id);?>"><i class="fa fa-plus"></i></a>

				<?php

				} ?>	

				</div>

				<div class="space-30"></div>

				<?php

				if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$view_action_id))

				{ ?>

				<div class="search-panel">

					<div class="row" >

						<div class="col-sm-4"><strong>Search:</strong>&nbsp;<br>

							<input type="text" id="txtsearch" name="txtsearch" class="form-control" value="<?php echo $txtsearch;?>" >

						</div>

						<div class="col-sm-4"><strong>Main Profile:</strong>&nbsp;<br>

							<select name="cucat_parent_cat_id" id="cucat_parent_cat_id" class="form-control" onchange="getMainCategoryOptionCommon('cucat','2');" required  >

								<?php echo $obj->getMainProfileOption($cucat_parent_cat_id,'2');?>

							</select>

						</div>

						<div class="col-sm-4"><strong>Category:</strong>&nbsp;<br>

							<select name="cucat_cat_id" id="cucat_cat_id" class="form-control" required>

								<?php echo $obj->getMainCategoryOption($cucat_parent_cat_id,$cucat_cat_id,'2'); ?>

							</select>

						</div>

					</div>

					<div class="row" >

						<div class="col-sm-4"><strong>Status:</strong>&nbsp;<br>

							<select name="status" id="status" class="form-control">

								<option value="" >All</option>

								<option value="1">Active</option>

								<option value="0">Inactive</option>

							</select>

						</div>

					</div>


					<div class="row">

						

						<div class="col-sm-3">

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

					if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$view_action_id))

					{ ?>

					<div id="eventlist"></div>

					<?php

					} ?>

				</div>

			</div>

		</div>
		<div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>

	</div>

</div>

<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script>



	

$(document).ready(function()

{ 

	$('#added_single_date').datepicker();

	$('#added_start_date').datepicker();

	$('#added_end_date').datepicker();

	$('#delivery_date').datepicker();

	<?php

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$view_action_id))

	{ ?>

    var dataString ='action=eventlist';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			$("#eventlist").html(result);

		}

	});

	<?php

	} ?>

}); 

<?php

if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$view_action_id))

{ ?>

function change_page(page_id)  

{

	var txtsearch = $("#txtsearch").val();

	var status = $("#status").val();

	var cucat_parent_cat_id = $("#cucat_parent_cat_id").val();

	var cucat_cat_id = $("#cucat_cat_id").val();


	var added_start_date = $("#added_start_date").val();

	var added_end_date = $("#added_end_date").val();

	var dataString ='page_id='+page_id +'&txtsearch='+escape(txtsearch)+'&status='+status+'&cucat_parent_cat_id='+cucat_parent_cat_id+'&cucat_cat_id='+cucat_cat_id+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&action=eventlist';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			$(".se-pre-con ").hide();

			$("#eventlist").html(result);

		}

	});

} 



function refineSearch()  

{

	var txtsearch = $("#txtsearch").val();

	var status = $("#status").val();

	var cucat_parent_cat_id = $("#cucat_parent_cat_id").val();

	var cucat_cat_id = $("#cucat_cat_id").val();


	var added_start_date = $("#added_start_date").val();

	var added_end_date = $("#added_end_date").val();
	

	var dataString ='txtsearch='+escape(txtsearch)+'&status='+status+'&cucat_parent_cat_id='+cucat_parent_cat_id+'&cucat_cat_id='+cucat_cat_id+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&action=eventlist';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			$(".se-pre-con ").hide();

			$("#eventlist").html(result);

		}

	});

} 

<?php

} ?>



<?php

/*

if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

{ ?>	

function deletemultiplecusines()

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

			var dataString ='chkbox_records='+chkbox_records+'&action=deletemultiplecusines';

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

						window.location.href="manage_cusines.php";  

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

}

*/ ?>

</script>

</body>

</html>