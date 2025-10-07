<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '24';

$view_action_id = '80';

$add_action_id = '81';

$edit_action_id = '82';

$delete_action_id = '83';



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



$txtsearch = '';

$item_id = '';

$vendor_id = '';

$customer_id = '';

$country_id = '';

$state_id = '';

$city_id = '';

$area_id = '';



$cancel_request_date = '';

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

				<header class="panel-heading">

					<h2 class="panel-title"><?php echo $obj->getAdminMenuName($admin_main_menu_id);?></h2>

				</header>

				<div class="pull-right tooltip-show">

				<?php

				/*if($obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))

				{ ?>

					<a href="<?php echo $obj->getAdminActionLink($add_action_id);?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $obj->getAdminActionName($add_action_id);?>" data-original-title=""><i class="fa fa-plus"></i></a>

				<?php

				}*/ ?>	

				</div>

				<div class="space-30"></div>

				<?php

				if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))

				{ ?>

				<div class="search-panel">

					<div class="row" >

						<div class="col-sm-3"><strong>Search:</strong>&nbsp;<br>

							<input type="text" id="txtsearch" name="txtsearch" value="<?php echo $txtsearch;?>" class="form-control"  >

						</div>

						<div class="col-lg-3">

							<strong>Item:</strong>&nbsp;<br>

							<select name="item_id" id="item_id" class="form-control">

								<?php echo $obj->getItemOption($item_id,2); ?>

							</select>

						</div>

						<div class="col-lg-3">

							<strong>Vendor:</strong>&nbsp;<br>

							<select name="vendor_id" id="vendor_id" class="form-control" >

								<?php echo $obj->getVendorOption($vendor_id,2); ?>

							</select>

						</div>

						<div class="col-lg-3">

							<strong>User:</strong>&nbsp;<br>

							<select name="customer_id" id="customer_id" class="form-control">

								<?php echo $obj->getUsersOption($customer_id,2); ?>

							</select>

						</div>

					</div>

					<div class="row" >

						<div class="col-sm-3"><strong>Country:</strong>&nbsp;<br>

							<select name="country_id" id="country_id" class="form-control" onchange="getStateOptionCommon('2','2');">

								<?php echo $obj->getCountryOption($country_id,'2'); ?>

							</select>

						</div>

						<div class="col-sm-3"><strong>State:</strong>&nbsp;<br>

							<select name="state_id" id="state_id" class="form-control"  onchange="getCityOptionCommon('2','2');">

								<?php echo $obj->getStateOption($country_id,$state_id,'2'); ?>

							</select>

						</div>

						<div class="col-sm-3"><strong>City:</strong>&nbsp;<br>

							<select name="city_id" id="city_id" class="form-control"  onchange="getAreaOptionCommon('2','2');">

								<?php echo $obj->getCityOption($country_id,$state_id,$city_id,'2'); ?>

							</select>

						</div>

						<div class="col-sm-3"><strong>Area:</strong>&nbsp;<br>

							<select name="area_id" id="area_id" class="form-control">

								<?php echo $obj->getAreaOption($country_id,$state_id,$city_id,$area_id,'2'); ?>

							</select>

						</div>

					</div>	

					<div class="row">

						<div class="col-lg-3">

							<strong>Cancellation Date :</strong>&nbsp;<br>

							<input type="text" name="cancel_request_date" id="cancel_request_date" placeholder="Select Date" class="form-control" required >

						</div>

						

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

					if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))

					{ ?>

					<div id="ordercancellationlist"></div>

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

<script src="js/tokenize2.js"></script>

<script>



	

$(document).ready(function()

{ 

	$('#cancel_request_date').datepicker();

	<?php

	if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))

	{ ?>

    var dataString ='action=ordercancellationlist';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

			$("#ordercancellationlist").html(result);

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

	var item_id = $("#item_id").val();

	var vendor_id = $("#vendor_id").val();

	var customer_id = $("#customer_id").val();

	var country_id = $("#country_id").val();

	var state_id = $("#state_id").val();

	var city_id = $("#city_id").val();

	var area_id = $("#area_id").val();

	var cancel_request_date = $("#cancel_request_date").val();

	

	var dataString ='page_id='+page_id +'&txtsearch='+escape(txtsearch)+'&item_id='+item_id+'&vendor_id='+vendor_id+'&customer_id='+customer_id+'&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&cancel_request_date='+escape(cancel_request_date)+'&action=ordercancellationlist';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			$(".se-pre-con ").hide();

			$("#ordercancellationlist").html(result);

		}

	});

} 



function refineSearch()  

{

	var txtsearch = $("#txtsearch").val();

	var item_id = $("#item_id").val();

	var vendor_id = $("#vendor_id").val();

	var customer_id = $("#customer_id").val();

	var country_id = $("#country_id").val();

	var state_id = $("#state_id").val();

	var city_id = $("#city_id").val();

	var area_id = $("#area_id").val();

	var cancel_request_date = $("#cancel_request_date").val();

	

	var dataString ='txtsearch='+escape(txtsearch)+'&item_id='+item_id+'&vendor_id='+vendor_id+'&customer_id='+customer_id+'&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&cancel_request_date='+escape(cancel_request_date)+'&action=ordercancellationlist';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			$(".se-pre-con ").hide();

			$("#ordercancellationlist").html(result);

		}

	});

} 

<?php

} ?>



<?php

/*

if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))

{ ?>	

function deletemultipleorders()

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

			var dataString ='chkbox_records='+chkbox_records+'&action=deletemultiplebannersliders';

			

			$.ajax({

				type: "POST",

				url: "ajax/remote.php",

				data: dataString,

				cache: false,     

				

				success: function(result)

				{

					//alert(result);		

					var JSONObject = JSON.parse(result);

					var rslt=JSONObject[0]['status'];

						

					if(rslt==1)

					{

						window.location.href="manage_banner_sliders.php";  

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

} */ ?>

</script>

</body>

</html>