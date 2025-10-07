<!--side navigation start-->
<div id="hoeapp-wrapper" class="hoe-hide-lpanel" hoe-device-type="desktop">
	<header id="hoe-header" hoe-lpanel-effect="shrink">
		<div class="hoe-left-header">
			<a href="index.php"><span><?php echo SITE_NAME;?></span></a>
			<span class="hoe-sidebar-toggle"><a href="#"></a></span>
		</div>
		<div class="hoe-right-header" hoe-position-type="relative">
			<span class="hoe-sidebar-toggle"><a href="#"></a></span>
			<?php
			/*
			<ul class="left-navbar">
				<li>
					<div class="top-search hidden-xs">
						<form>
							<input type="text" class="form-control" placeholder="Search here">
							<i class="ion-search"></i>
						</form>
					</div>
				</li>
			</ul>
			*/
			?>
			<ul class="right-navbar navbar-right">
				<?php
				/*
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle"> <i class="ion-ios-bell-outline"></i> <span class="label label-danger">4</span></a>
					<ul class="dropdown-menu dropdown-menu-scale lg-dropdown notifications">
						<li> <p>You have 3 new notifications <a href="#"> Mark all Read</a></p></li>
						<li class="unread-notifications">
							<a href="#">
								<i class="ion-ios-email-outline pull-right"></i>
								<span class="line">You have 8 Messages</span>
								<span class="small-line">3 Minutes ago</span>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="ion-social-twitter-outline pull-right"></i>
								<span class="line">You have 3 new followers</span>
								<span class="small-line">8 Minutes ago</span>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="ion-ios-download-outline pull-right"></i>
								<span class="line">Download Complete</span>
								<span class="small-line">6 Minutes ago</span>
							</a>
						</li>
					</ul>
				</li>
				<?php
				*/
				/*
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle"><img src="assets/images/us.png" alt=""> English</a>
					<ul class="dropdown-menu dropdown-menu-scale lang-dropdown">
						<li><a href="#"><img src="assets/images/us.png" alt=""> English </a></li>
						<li><a href="#"><img src="assets/images/es.png" alt=""> Spanish </a></li>
						<li><a href="#"><img src="assets/images/tr.png" alt=""> Turkish </a></li>
					</ul>
				</li>
				*/
				?>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle"><img src="assets/images/avtar.png" alt="" width="30" class="img-circle"><?php echo $_SESSION['admin_username'];?></a>
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
		</div>
	</header>
	<div id="hoeapp-container" hoe-color-type="lpanel-bg7" hoe-lpanel-effect="shrink">
		<aside id="hoe-left-panel" hoe-position-type="absolute">
			<?php echo $obj->getAdminMenuCode($_SESSION['admin_id'],$admin_main_menu_id);?>
			<?php
			/*
			<ul class="nav panel-list">
				<li class="active">
					<a href="index.html">
						<i class="fa fa-home"></i>
						<span class="menu-text">Dashboard</span>
						<span class="selected"></span>
					</a>
				</li>
				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="fa fa-envelope"></i>
						<span class="menu-text">Email</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="email-inbox.html">
								<span class="menu-text">Inbox</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="email-compose.html">
								<span class="menu-text">Compose</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="email-view.html">
								<span class="menu-text">Email View</span>
								<span class="selected"></span>
							</a>
						</li>
					</ul>
				</li>
				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="fa fa-bar-chart-o"></i>
						<span class="menu-text">Charts</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="chart-flot.html">
								<span class="menu-text">Flot charts</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="chart-morris.html">
								<span class="menu-text">Morris charts</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="chart-chartjs.html">
								<span class="menu-text">Chartjs</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="chart-sparkline.html">
								<span class="menu-text">Sparkline</span>
								<span class="selected"></span>
							</a>
						</li>
					</ul>
				</li>
				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="fa fa-th-large"></i>
						<span class="menu-text">Forms</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="form-basic.html">
								<span class="menu-text">Basic elements</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="form-file-upload.html">
								<span class="menu-text">File upload</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="form-text-editor.html">
								<span class="menu-text">Text editor</span>
								<span class="selected"></span>
							</a>
						</li>
					</ul>
				</li>
				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="fa fa-table"></i>
						<span class="menu-text">Tables</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="table-static.html">
								<span class="menu-text">Static tables</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="table-responsive.html">
								<span class="menu-text">Responsive Tables</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="table-data.html">
								<span class="menu-text">Data tables</span>
								<span class="selected"></span>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="calendar.html">
						<i class="fa fa-calendar"></i>
						<span class="menu-text">Calendar</span>
						<span class="selected"></span>
					</a>
				</li>
				<li>
					<a href="user-profile.html">
						<i class="fa fa-user"></i>
						<span class="menu-text">User Profile</span>
						<span class="selected"></span>
					</a>
				</li>
				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="fa fa-envelope"></i>
						<span class="menu-text">Pages</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="page-login.html">
								<span class="menu-text">Login</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="page-register.html">
								<span class="menu-text">Register</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="page-404.html">
								<span class="menu-text">404</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="page-forget-password.html">
								<span class="menu-text">Forget password</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="page-empty.html">
								<span class="menu-text">Empty page</span>
								<span class="selected"></span>
							</a>
						</li>
					</ul>
				</li>
				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="fa fa-cogs"></i>
						<span class="menu-text">UI elements</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="ui-buttons.html">
								<span class="menu-text">Buttons</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="ui-typography.html">
								<span class="menu-text">typography</span>
								<span class="selected"></span>
							</a>
						</li>

						<li>
							<a href="ui-tabs.html">
								<span class="menu-text">Tabs</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="ui-alerts.html">
								<span class="menu-text">Alerts</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="ui-tooltip_popovers.html">
								<span class="menu-text">Tooltips & popovers</span>
								<span class="selected"></span>
							</a>
						</li>
					</ul>
				</li>
				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="fa fa-map-o"></i>
						<span class="menu-text">Maps</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="map-vector.html">
								<span class="menu-text">Vector map</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="map-google.html">
								<span class="menu-text">Google map</span>
								<span class="selected"></span>
							</a>
						</li>
					</ul>
				</li>

				<li class="hoe-has-menu">
					<a href="javascript:void(0)">
						<i class="ion-ios-filing-outline"></i>
						<span class="menu-text">Menu Lavel 1</span>
						<span class="selected"></span>
					</a>
					<ul class="hoe-sub-menu">
						<li>
							<a href="javascript:void(0)">
								<span class="menu-text">level 2</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="menu-text">level 2</span>
								<span class="selected"></span>
							</a>
						</li>
						<li class="hoe-has-menu">
							<a href="javascript:void(0)">
								<span class="menu-text">level 2</span>
								<span class="selected"></span>
							</a>
							<ul class="hoe-sub-menu">
								<li class="hoe-has-menu">
									<a href="javascript:void(0)">
										<span class="menu-text">level 3</span>
										<span class="selected"></span>
									</a>
									<ul class="hoe-sub-menu">
										<li>
											<a href="javascript:void(0)">
												<span class="menu-text">level 4</span>
												<span class="selected"></span>
											</a>
										</li>
										<li>
											<a href="javascript:void(0)">
												<span class="menu-text">level 4</span>
												<span class="selected"></span>
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:void(0)">
										<span class="menu-text">level 3</span>
										<span class="selected"></span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<span class="menu-text">level 3</span>
										<span class="selected"></span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<span class="menu-text">level 3</span>
										<span class="selected"></span>
									</a>
								</li>
							</ul>
						</li>  
					</ul>
				</li>
			</ul>
			*/
			?>
		</aside>
		<!--aside left menu end-->
		<!--start main content-->
		<section id="main-content">
			<div class="space-30"></div>