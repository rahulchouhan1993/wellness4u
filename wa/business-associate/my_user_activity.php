<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '35';

$add_action_id = '36';

$page_id = '117';

$obj = new Vendor();

$obj2 = new commonFunctions();

if(!$obj->isVendorLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

}



$vendor_details = $obj->getVendorUserDetails($adm_vendor_id);

















?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Business Associates</title>

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

                                     <?php //echo $user_id;?>

                                      



                                        <center><div id="error_msg" style="color: red;"><?php if($error) { echo $err_msg; } ?></div></center>

                                        <?php echo $obj->getPageContents($page_id);  ?>



                                        <form name="frmadviserquery" method="get" action="#" >

			                            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

			                                <tr>

			                                    <td width="10%" align="left" valign="middle" bgcolor="#FFFFFF">

			                                        <label><strong>Show For:</strong></label>

			                                        </td>

			                                        <td width="40%">





                                          <?php

                                         //  echo $_GET['id'];

                                         //  echo "<br>";

                                         //  echo $adm_vendor_id;

                                         // echo $obj->getAdviserAcceptedUsersOptions($_GET['id'],$adm_vendor_id); 

                                          ?>

			                                       <select name="id" id="id" class="form-control" >

		                                            <option value="">All Users</option>

		                                            <?php echo $obj->getAdviserAcceptedUsersOptions($_GET['id'],$adm_vendor_id); ?>

                                                  </select> 

			                                        </td>

			                                        <td width="50%">   

			                                        <input type="submit" name="btnSubmit" value="Search" />

			                                    </td>

			                            </tr>

			                            </table>

                                </form>





                                 <p>&nbsp;</p>



                                    <?php //echo $obj->getAdviserAcceptedUsersOptions($_GET['id'],$adm_vendor_id); ?>

                                      <!--  <select name="pro_user_id" id="pro_user_id" class="form-control" >

                                            <option value="">All Users</option>

                                            <?php //echo $obj->getAdviserAcceptedUsersOptions($_GET['id'],$adm_vendor_id); ?>

                                        </select>  -->



                                        <!-- <br> -->

                                       <div id="eventlist"></div>

				</div>

			</div>

		</div>

		<div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>

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

    var dataString ='action=myuser_activity&user_id=<?php echo $_GET['id'];?>';

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


function showActivateUserInvitationPopup(ar_id,puid,vendor)

{

	// alert(vendor);

	

        var dataString ='action=showactivateuserinvitationpopup&ar_id='+ar_id+'&puid='+puid+'&vendor='+vendor;

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                   BootstrapDialog.show({

                        title: 'User Activation',

                        message:result

                    });

		}

	});

        

}





function showDeactivateUserInvitationPopup(ar_id,puid,vendor)

{

 // alert(vendor);

        var dataString ='action=showdeactivateuserinvitationpopup&ar_id='+ar_id+'&puid='+puid+'&vendor='+vendor;

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                   BootstrapDialog.show({

                        title: 'User Deactivation',

                        message:result

                    });

		}

	});

        

}



function deactivateUserInvitation(ar_id,puid,vendor_id)

{

	var Choice = confirm("Do you wish to Deactivate User?");

	if (Choice == true)

	{

		var status_reason = escape($("#status_reason").val());

		if(status_reason == '')

		{

			alert('Please enter reason for deactivation');

		}

		else

		{

                        var dataString ='action=deactivateuserinvitation&ar_id='+ar_id+'&puid='+puid+'&status_reason='+status_reason+'&vendor='+vendor_id;

                            $.ajax({

                                    type: "POST",

                                    url: "ajax/remote.php",

                                    data: dataString,

                                    cache: false,

                                    success: function(result)

                                    {

                                       window.location.reload(true);

                                    }

                            });



                        

		}	

	}	

}



function activateUserInvitation(ar_id,puid,vendor)

{

	var Choice = confirm("Do you wish to Activate User?");

	if (Choice == true)

	{

		var status_reason = escape($("#status_reason").val());

		if(status_reason == '')

		{

			alert('Please enter reason for activation');

		}

		else

		{

                        var dataString ='action=activateuserinvitation&ar_id='+ar_id+'&puid='+puid+'&status_reason='+status_reason+'&vendor='+vendor;

                            $.ajax({

                                    type: "POST",

                                    url: "ajax/remote.php",

                                    data: dataString,

                                    cache: false,

                                    success: function(result)

                                    {

                                       window.location.reload(true);

                                    }

                            });

                        

                        

		}	

	}	

}



</script>

</body>

</html>