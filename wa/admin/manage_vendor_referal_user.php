<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '35';

$add_action_id = '36';

$page_id = '83';


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

							<h2 class="panel-title"><?php echo $obj->getAdminMenuName($admin_main_menu_id);?></h2>

						</div>

					</div>

					<hr>
					<?php echo $obj->getPageIcon($page_id);?>  
					<?php echo $obj->getPageContents($page_id);  ?>

                        <center><div id="error_msg" style="color: red;"><?php if($error) { echo $err_msg; } ?></div></center>


                        <br>

                        <?php

						if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))

						{ ?>

						<div class="search-panel">

						<div class="row" >

							<div class="col-sm-3"><strong>Search:</strong>&nbsp;<br>

								<input type="text" id="txtsearch" name="txtsearch" value="<?php echo $txtsearch;?>" class="form-control"  >

							</div>

							<div class="col-sm-3"><strong>Vendor:</strong>&nbsp;<br>

								<select name="vendor_id" id="vendor_id" class="form-control" >
                                       <option value="">All Vendors</option>
                                       <?php 
                                      echo $obj->getVendorFromAdviserReffral($vendor_id);

                                      ?>
                                    </select>

							</div>

							<div class="col-sm-3"><strong>User:</strong>&nbsp;<br>

								 <select name="user_id" id="user_id" class="form-control" >
                                       <option value="">All Users</option>
                                       <?php 
                                      echo $obj->getUserFromAdviserReffral($user_id);

                                      ?>
                                    </select>

							</div>


						</div>

						<div class="row" >

							<div class="col-sm-3"><strong>Invitation Start Date :</strong>&nbsp;<br>

								<input type="text" name="invite_start_date" id="invite_start_date" placeholder="Select Start Date" class="form-control" autocomplete="off">


							</div>

							<div class="col-sm-3"><strong>Invitation End Date :</strong>&nbsp;<br>

								<input type="text" name="invite_end_date" id="invite_end_date" placeholder="Select End Date" class="form-control" autocomplete="off">

							</div>


						</div>

						<div class="row" >	
							
							<div class="col-sm-3">

								<input type="button" id="btnsearch" name="btnsearch" value="Search" class="btn btn-primary btn-search" onclick="refineSearch();">

							</div>

						</div>

					</div>



						 <div id="eventlist"></div>

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

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="js/tokenize2.js"></script>

<script>

$(document).ready(function()

{ 	
	$('#invite_start_date').datepicker();
	$('#invite_end_date').datepicker();
	refineSearch();

}); 


function refineSearch()
{
	var txtsearch = $("#txtsearch").val();
	var vendor_id = $("#vendor_id").val();
	var user_id = $("#user_id").val();
	var invite_start_date = $("#invite_start_date").val();
	var invite_end_date = $("#invite_end_date").val();


    var dataString ='action=myreferral&txtsearch='+txtsearch+'&user_id='+user_id+'&vendor_id='+vendor_id+'&invite_start_date='+invite_start_date+'&invite_end_date='+invite_end_date+'&txtsearch'+txtsearch;

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
}

function change_page(page_id)
{	
	var txtsearch = $("#txtsearch").val();
	var vendor_id = $("#vendor_id").val();
	var user_id = $("#user_id").val();
	var invite_start_date = $("#invite_start_date").val();
	var invite_end_date = $("#invite_end_date").val();

	var dataString ='action=myreferral&txtsearch='+txtsearch+'&user_id='+user_id+'&vendor_id='+vendor_id+'&invite_start_date='+invite_start_date+'&invite_end_date='+invite_end_date+'&txtsearch'+txtsearch+'&page_id='+page_id;

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
}


</script>

</body>

</html>