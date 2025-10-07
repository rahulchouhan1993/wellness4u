<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');



$obj = new Admin();



if($obj->isAdminLoggedIn())

{

    header("Location: index.php");

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

<style>
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-text-box {
        width: 100%;
        padding-right: 40px;
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }
</style>
</head>

<body>

<div class="page-center">

	<div class="page-center-in">

		<form class="sign-box" name="admin-login-form" id="admin-login-form">

			<div class="sign-avatar">

				<img src="../images/cwri_logo.png" alt="Wellness" class="">

			</div>

			<header class="sign-title">Sign In</header>

			<div class="form-group">

				<input type="text" class="form-control" name="username" id="username" placeholder="Username">

			</div>

			<div class="form-group">

				<!-- <input type="password" class="form-control" name="password" id="password" placeholder="Password"> -->
				<div class="password-wrapper">
				    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
				    <span toggle="#password" class="toggle-password" onclick="togglePassword()">👁️</span>
				</div>

			</div>

			<button type="button" value="Submit" name="logBtn" onclick="loginproceed(); return false;" class="btn btn-success rounded btn-lg">Login</button>

			<hr>

		</form>

	</div><!--page center in-->

</div><!--page center-->

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script>

function loginproceed()

{ 

	var formData = new FormData($('#admin-login-form')[0]); 

	formData.append("logBtn",'logBtn');

	var error = true;

        

    if(error)

	{

		jQuery.ajax({

			url: 'ajax/login.php',

			type: "POST",

			data:formData,

			processData: false,

			contentType: false,

			//beforeSend: function(){ $("#logBtn").val('Connecting...');},

			success: function(result)

			{

				//alert(result);

				var JSONObject = JSON.parse(result);

                var rslt=JSONObject[0]['status'];

                if(rslt==1)

				{

					window.location.href= JSONObject[0]['refurl'];  

				}

				else

				{

                    //alert('failure');

                    BootstrapDialog.show({

						title: 'Error' +" "+" "+'Response',

						message:JSONObject[0]['msg']

					}); 

				}      

			}

		});

	}

}

</script>

<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.querySelector(".toggle-password");
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈"; // Eye-off icon
        } else {
            input.type = "password";
            icon.textContent = "👁️"; // Eye icon
        }
    }
</script>

</body>

</html>