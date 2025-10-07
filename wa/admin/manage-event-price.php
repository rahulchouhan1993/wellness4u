<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '12';

$view_action_id = '27';

$add_action_id = '28';

$edit_action_id = '29';

$delete_action_id = '30';



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

$vendor_parent_cat_id = '';

$vendor_cat_id = '';

$country_id = '';

$state_id = '';

$city_id = '';

$area_id = '';

$item_id = '';



$added_by_admin = '';

$added_days_of_month = '';

$added_days_of_week = '';

$added_single_date = '';

$added_start_date = '';

$added_end_date = '';



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

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-md-12">

			<div class="panel">

				<header class="panel-heading">

					<h2 class="panel-title"><?php echo $obj->getAdminMenuName($admin_main_menu_id);?> Location</h2>

				</header>

				

				<div class="space-30"></div>

				<?php

				if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))

				{ ?>

				<div class="search-panel">

					<div class="row" >

						<div class="col-sm-3"><strong>Search:</strong>&nbsp;<br>

							<input type="text" id="txtsearch" name="txtsearch" value="<?php echo $txtsearch;?>" class="form-control"  >

						</div>

						<div class="col-sm-3"><strong>Main Profile:</strong>&nbsp;<br>

							<select name="vendor_parent_cat_id" id="vendor_parent_cat_id" class="form-control" onchange="getMainCategoryOptionCommon('vendor','2');" required  >

								<?php echo $obj->getMainProfileOption($vendor_parent_cat_id,'2');?>

							</select>

						</div>

						<div class="col-sm-3"><strong>Category:</strong>&nbsp;<br>

							<select name="vendor_cat_id" id="vendor_cat_id" class="form-control" required>

								<?php echo $obj->getMainCategoryOption($vendor_parent_cat_id,$vendor_cat_id,'2'); ?>

							</select>

						</div>

						<div class="col-sm-3"><strong>Status:</strong>&nbsp;<br>

							<select name="status" id="status" class="form-control">

								<option value="" >All</option>

								<option value="1">Active</option>

								<option value="0">Inactive</option>

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

						<div class="col-lg-3"><strong>Added By Vendor:</strong>&nbsp;<br>

							<select name="added_by_admin" id="added_by_admin" class="form-control" required>

								<?php echo $obj->getVendorOption($added_by_admin,'2'); ?>

							</select>

						</div>

						

					</div>

					

					<div class="row" >	

						

						<div class="col-sm-3">

							<input type="button" id="btnsearch" name="btnsearch" value="Search" class="btn btn-primary btn-search" onclick="refineSearch();">

						</div>

					</div>

				</div>

                                <?php

                                    

                                   // $event_details = $obj->GetAllEventDetails(); 

                                   

				} ?> 

				<div class="panel-body">

                                    <input type="hidden" name="event_master_id" id="event_master_id" value="<?php echo $_GET['event_master_id']; ?>">

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

					<div id="eventpricelist"></div>

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

	$('#added_single_date').datepicker();

	$('#added_start_date').datepicker();

	$('#added_end_date').datepicker();

	<?php

	if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))

	{ ?>

    var dataString ='action=eventlocationlistprice';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                        //alert(result);

			$("#eventpricelist").html(result);

		}

	});

	<?php

	} ?>

}); 

<?php

if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))

{ ?>

	function refineSearch()  

	{

		var txtsearch = $("#txtsearch").val();

		var status = $("#status").val();

		var parent_cat_id = $("#vendor_parent_cat_id").val();

		var sub_cat_id = $("#vendor_cat_id").val();

		var added_start_date = $("#added_start_date").val();

		var added_end_date = $("#added_end_date").val();

		var country_id = $("#country_id").val();

		var state_id = $("#state_id").val();

		var city_id = $("#city_id").val();

		var area_id = $("#area_id").val();

		
		var dataString ='txtsearch='+escape(txtsearch)+'&status='+status+'&parent_cat_id='+parent_cat_id+'&sub_cat_id='+sub_cat_id+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&country_id='+escape(country_id)+'&state_id='+escape(state_id)+'&city_id='+escape(city_id)+'&area_id='+escape(area_id)+'&action=eventlocationlistprice';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,

			success: function(result)

			{

				$(".se-pre-con ").hide();

				$("#eventpricelist").html(result);

			}

		});

	} 

	function change_page(page_id)  

	{

		var txtsearch = $("#txtsearch").val();

		var status = $("#status").val();

		var parent_cat_id = $("#vendor_parent_cat_id").val();

		var sub_cat_id = $("#vendor_cat_id").val();

		var added_start_date = $("#added_start_date").val();

		var added_end_date = $("#added_end_date").val();

		var country_id = $("#country_id").val();

		var state_id = $("#state_id").val();

		var city_id = $("#city_id").val();

		var area_id = $("#area_id").val();

		
		var dataString ='page_id='+page_id +'&txtsearch='+escape(txtsearch)+'&status='+status+'&parent_cat_id='+parent_cat_id+'&sub_cat_id='+sub_cat_id+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&country_id='+escape(country_id)+'&state_id='+escape(state_id)+'&city_id='+escape(city_id)+'&area_id='+escape(area_id)+'&action=eventlocationlistprice';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,

			success: function(result)

			{

				$(".se-pre-con ").hide();

				$("#eventpricelist").html(result);

			}

		});

	} 


<?php

} ?>	

	

<?php

if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))

{ ?>	

function deletemultiplevendors()

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

			var dataString ='chkbox_records='+chkbox_records+'&action=deletemultiplevendors';

			

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

						window.location.href="manage_vendors.php";  

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