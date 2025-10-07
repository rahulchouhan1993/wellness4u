<!--side navigation start-->

<div id="hoeapp-wrapper" class="hoe-hide-lpanel" hoe-device-type="desktop">

	<header id="hoe-header" hoe-lpanel-effect="shrink">

		<div class="hoe-left-header">

		<?php

		if($obj->isVendorLoggedIn())

		{ ?>

			<!-- <a href="index.php"><span><?php echo SITE_NAME;?> - Business Associates</span></a> -->
			<!-- update by ample 09-09-20 -->
			<a href="index.php"><span>Vendor Panel</span></a>

			<span class="hoe-sidebar-toggle"><a href="#"></a></span>

		<?php

		}

		else

		{ ?>

			<!-- <a href="#"><span><?php echo SITE_NAME;?> - Business Associates</span></a> -->
			<!-- update by ample 09-09-20 -->
			<a href="index.php"><span>Vendor Panel</span></a>
		<?php

		} ?>	

			

		</div>

		<div class="hoe-right-header" hoe-position-type="relative">

			<span class="hoe-sidebar-toggle"><a href="#"></a></span>

			<?php

			if($obj->isVendorLoggedIn())

			{ ?>

			<ul class="right-navbar navbar-right">

				<li class="dropdown">

					<a href="#" data-toggle="dropdown" class="dropdown-toggle"><img src="assets/images/avtar.png" alt="" width="30" class="img-circle"><?php echo $_SESSION['adm_vendor_username'];?></a>

					<ul class="dropdown-menu dropdown-menu-scale user-dropdown">

						<?php /*<li><a href="#"><i class="ion-email-unread"></i> Inbox <span class="label label-warning">3</span></a></li> */ ?>

						<li><a href="edit_profile.php"><i class="ion-person"></i> Profile </a></li>

						<li><a href="change_password.php"><i class="ion-settings"></i> Change Password</a></li>

						<?php /*<li><a href="#"><i class="ion-calendar"></i> Calendar </a></li>

						<li><a href="#"><i class="ion-ios-compose"></i> Tasks </a></li>*/ ?>

						<li><a href="logout.php"><i class="ion-log-out"></i> Logout </a></li>

					</ul>

				</li>

			</ul>

			<?php

			} ?>

				

		</div>

	</header>

	<div id="hoeapp-container" hoe-color-type="lpanel-bg7" hoe-lpanel-effect="shrink">

		<aside id="hoe-left-panel" hoe-position-type="absolute">

		<?php

		if($obj->isVendorLoggedIn())

		{ ?>

			<?php echo $obj->getAdminMenuCode($_SESSION['adm_vendor_id'],$admin_main_menu_id);?>

		<?php

		} ?>	

		</aside>

		<!--aside left menu end-->

		<!--start main content-->

		<section id="main-content">

			<div class="space-30"></div>