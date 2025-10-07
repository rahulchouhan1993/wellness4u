<?php
$obj_comm_top = new commonFunctions();
if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
{
	$topcityid = $_SESSION['topcityid'];
	if($obj_comm_top->chkIfValidCityId($topcityid))
	{
		
	}
	else
	{
		$topcityid = '8';		
	}
}
else
{
	$topcityid = '8';	
}
if($page_id == 1)
{
	$topareaid = '';
	$_SESSION['topareaid'] = '';
}	

if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
{
	$topareaid = $_SESSION['topareaid'];
	if($obj_comm_top->chkIfValidAreaId($topareaid))
	{
		
	}
	else
	{
		$topareaid = '';		
	}
}
else
{
	$topareaid = '';	
}

$_SESSION['topcityid'] = $topcityid;
$_SESSION['topareaid'] = $topareaid;

$toplocationstr = $obj_comm_top->getTopLocationStr($topcityid,$topareaid);
$_SESSION['toplocationstr'] = $toplocationstr;
?>
<header>
	<nav>
		<div class="container">
			<div class="navbar-header">
				<button type="button"  class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="<?php echo SITE_URL;?>" class="logo">
					<img src="images/logo.png" class="img-responsive" alt="logo.png">
				</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="navbar-right">
					<li>
						<a id="btnTopLocation" href="#animatedModalLocation"><img src="images/icon1.png" alt="icon1.png">Menu for</a>
						<span id="labeltoplocation"><?php echo $toplocationstr?></span><br><span class="small_label">(Click to change city/town)</span>
						<input type="hidden" name="hdntopcityid" name="hdntopcityid" value="<?php echo $topcityid;?>">
						<input type="hidden" name="hdntopareaid" name="hdntopareaid" value="<?php echo $topareaid;?>">
					</li>
                    <li><a href=""><img src="images/icon2.png" alt="">Filter</a></li>
                    <?php if($page_id != '2'){?>
					<li><a href="javascript:void(0);" id="btnOpenCart" onclick="openCartPopup()" ><img src="images/icon3.png" alt="">Your Food Cart</a></li>
					<?php } ?>
                    <li><img src="images/icon4.png" alt="">8828033111</li>
                    <li>
					<?php
					if($obj->isUserLoggedIn())
					{ ?>
						<a href="<?php echo SITE_URL.'/my_account.php';?>"><?php echo $_SESSION['user_firstname'];?></a>
					<?php
					}
					else
					{ ?>
						<a href="<?php echo SITE_URL.'/login.php';?>">Login</a><span class="or">Or</span><a href="<?php echo SITE_URL.'/login.php';?>">Sign Up</a>
					<?php	
					} ?>						
						
					</li>
				</ul>
            </div>
			<div id="animatedModalLocation" style="display:none;">
				<!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
				<div class="close_anim_model">
					<div class="close-animatedModalLocation">X</div>
				</div>
				<div class="modal-content-loc">
					<div class="modal-content-inner">	
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<h4 align="center">Select Your Location</h4>
							</div>
						</div>	
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-12 col-sm-12">
								<select name="select_your_city" id="select_your_city" onchange="getTopAreaOption()" multiple >
									<?php 
									$obj_loc = new commonFunctions();
									echo $obj_loc->getAllLocationsOption($topcityid);	
									?>	
								</select>
							</div>
							
						</div>	
						<div class="row" style="margin-bottom:10px;display:none">
							<div class="col-md-12 col-sm-12">
								<select name="select_your_area" id="select_your_area" multiple >
									<?php 
									echo $obj_loc->getTopAreaOption($topcityid,$topareaid);	
									?>	
								</select>
							</div>
						</div>	
						<div class="row">	
							<div class="col-md-12 col-sm-12">
								<button name="btnSelectYourLocation" id="btnSelectYourLocation" onclick="setTopLocation()" class="btnoval">Select</button>
							</div>	
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</nav>
</header>
<?php
if($page_id == '1' || $page_id == '19')
{ 
	$current_showing_date_banner = date('Y-m-d');
	$arr_banners_records = $obj->getAllPublishedBannerSliders($topcityid,$topareaid,$current_showing_date_banner); 	
	//echo '<br><pre>';
	//print_r($arr_banners_records);
	//echo '<br></pre>';
	if(count($arr_banners_records) > 0)
	{
?>
<!-- banner part -->
<section id="banner">
	<div id="bootstrap-touch-slider" class="carousel bs-slider slide  control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="5000" >
		<!-- Indicators -->
		<ol class="carousel-indicators">
		<?php
		foreach($arr_banners_records as $i => $arr_banner)
		{ ?>
			<li data-target="#bootstrap-touch-slider" data-slide-to="<?php echo $i;?>" <?php if($i == 0){ ?> class="active" <?php } ?>></li>
		<?php
		} ?>	
		</ol>
		<!-- Wrapper For Slides -->
		<div class="carousel-inner" role="listbox">
		<?php
		foreach($arr_banners_records as $i => $arr_banner)
		{ ?>
			<!-- First Slide -->
			<div class="item <?php if($i == 0){ ?> active <?php } ?>">
				<!-- Slide Background -->
				<?php
				if($arr_banner['banner_image'] != '')
				{
					$banner_image = SITE_URL.'/uploads/'.$arr_banner['banner_image'];
				}
				else
				{
					$banner_image = SITE_URL.'/images/banner.png';
				} ?>
				<img src="<?php echo $banner_image;?>" alt="<?php echo $arr_banner['banner_title'];?>"  class="slide-image"/>
				<div class="bs-slider-overlay"></div>
				<div class="container">
					<div class="row">
						<!-- Slide Text Layer -->
						<div class="slide-text slide_style_center">
							<?php
							if($arr_banner['banner_title_font_size'] != '')
							{
								$style_bt_fs = ' font-size:'.$arr_banner['banner_title_font_size'].'px; ';	
							}
							else
							{
								$style_bt_fs = '';	
							}
							
							if($arr_banner['banner_title_font_family'] != '')
							{
								$style_bt_ff = ' font-family:'.$arr_banner['banner_title_font_family'].'; ';	
							}
							else
							{
								$style_bt_ff = '';	
							}
							
							if($arr_banner['banner_title_font_color'] != '')
							{
								$style_bt_fc = ' color:#'.$arr_banner['banner_title_font_color'].'; ';	
							}
							else
							{
								$style_bt_fc = '';	
							}
							
							if($arr_banner['banner_text_line1_font_size'] != '')
							{
								$style_tl1_fs = ' font-size:'.$arr_banner['banner_text_line1_font_size'].'px; ';	
							}
							else
							{
								$style_tl1_fs = '';	
							}
							
							if($arr_banner['banner_text_line1_font_family'] != '')
							{
								$style_tl1_ff = ' font-family:'.$arr_banner['banner_text_line1_font_family'].'; ';	
							}
							else
							{
								$style_tl1_ff = '';	
							}
							
							if($arr_banner['banner_text_line1_font_color'] != '')
							{
								$style_tl1_fc = ' color:#'.$arr_banner['banner_text_line1_font_color'].'; ';	
							}
							else
							{
								$style_tl1_fc = '';	
							}
							
							if($arr_banner['banner_text_line2_font_size'] != '')
							{
								$style_tl2_fs = ' font-size:'.$arr_banner['banner_text_line2_font_size'].'px; ';	
							}
							else
							{
								$style_tl2_fs = '';	
							}
							
							if($arr_banner['banner_text_line2_font_family'] != '')
							{
								$style_tl2_ff = ' font-family:'.$arr_banner['banner_text_line2_font_family'].'; ';	
							}
							else
							{
								$style_tl2_ff = '';	
							}
							
							if($arr_banner['banner_text_line2_font_color'] != '')
							{
								$style_tl2_fc = ' color:#'.$arr_banner['banner_text_line2_font_color'].'; ';	
							}
							else
							{
								$style_tl2_fc = '';	
							}
							?>
							<h1 style="<?php echo $style_bt_fs.' '.$style_bt_ff.' '.$style_bt_fc;?>" data-animation="animated zoomInRight"><?php echo $arr_banner['banner_title'];?></h1>
							
							<p style="<?php echo $style_tl1_fs.' '.$style_tl1_ff.' '.$style_tl1_fc;?>" data-animation="animated fadeInLeft"><?php echo $arr_banner['banner_text_line1'];?></p>
							<p style="<?php echo $style_tl2_fs.' '.$style_tl2_ff.' '.$style_tl2_fc;?>" data-animation="animated fadeInRight"><?php echo $arr_banner['banner_text_line2'];?></p>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Slide -->
		<?php
		} ?>
		</div><!-- End of Wrapper For Slides -->
		<!-- Left Control -->
		<a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
			<span class="fa fa-angle-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>

		<!-- Right Control -->
		<a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
			<span class="fa fa-angle-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
    </div> <!-- End touch-slider Slider -->        
</section>
<?php
	}
} ?>