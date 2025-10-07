<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '35';

$add_action_id = '36';

$page_id = '117';

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

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>              

                                   <?php echo $obj->getPageIcon($page_id);?>  
					<?php echo $obj->getPageContents($page_id);  ?>

                                      



                                        <center><div id="error_msg" style="color: red;"><?php if($error) { echo $err_msg; } ?></div></center>

										<form class="search-panel" method="get">

												<div class="row" >

													<div class="col-sm-2"></div>

													<div class="col-sm-3"><strong>Vendor:</strong>&nbsp;<br>

														<select name="vid" id="vendor_id" class="form-control" >
						                                       <option value="">All Vendors</option>
						                                       <?php 
						                                      echo $obj->getVendorFromAdviserReffral($_GET['vid']);

						                                      ?>
						                                    </select>

													</div>

													<div class="col-sm-3"><strong>User:</strong>&nbsp;<br>

														 <select name="uid" id="user_id" class="form-control" >
						                                       <option value="">All Users</option>
						                                       <?php 
						                                      echo $obj->getUserFromAdviserReffral($_GET['uid']);

						                                      ?>
						                                    </select>

													</div>


												
													
													<div class="col-sm-2">

														<input type="submit" id="btnsearch" class="btn btn-primary btn-search">

													</div>

													<div class="col-sm-2"></div>

												</div>

											</form>

												<hr>


                                       <div id="eventlist"></div>

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

    var dataString ='action=myuser_activity&user_id=<?php echo $_GET['uid'];?>&vendor_id=<?php echo $_GET['vid'];?>';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                    //alert(result);

		    $("#eventlist").html(result);

		}

	});

}); 

function change_page(page_id)
{	


	var dataString ='action=myuser_activity&user_id=<?php echo $_GET['uid'];?>&vendor_id=<?php echo $_GET['vid'];?>'+'&page_id='+page_id;

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