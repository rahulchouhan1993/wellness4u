<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-xs-12 footer_menu ">
				<h4>COMPANY</h4>
				<ul>
					<li><a href="<?php echo SITE_URL.'/about_us.php';?>">About Us</a></li>
					<li><a href="<?php echo SITE_URL.'/terms.php';?>">Terms & Conditions Policy</a></li>
					<li><a href="<?php echo SITE_URL.'/disclaimer.php';?>">Disclaimer Policy</a></li>
					<li><a href="<?php echo SITE_URL.'/privacy_policy.php';?>">Privacy Policy</a></li>
					<li><a href="<?php echo SITE_URL.'/cancellation_refund_policy.php';?>">Cancellation & Refund Policy</a></li>
					<li><a href="<?php echo SITE_URL.'/shipping_delivery_policy.php';?>">Shipping & Delivery Policy</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-xs-12 footer_menu ">
				<h4>Business Associates</h4>
				<ul>
					<li><a href="<?php echo SITE_URL.'/business-associate-register.php';?>">Business Associates Registration</a></li>
					<li><a href="<?php echo BA_URL.'/login.php';?>">Business Associates Login</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-xs-12 footer_menu ">
				<h4>CONTACT</h4>
				<ul>
					<li><a href="<?php echo SITE_URL.'/contact_us.php';?>">Contact Us</a></li>
					<li><img src="images/icon4.png" alt="">8828033111</li>
					<li><a href="mailto:support@tastes-of-states.com">support@tastes-of-states.com</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-xs-12 footer_menu ">
				<?php
				/*
				<ul>
					<li><a href="<?php echo SITE_URL.'/blog';?>">Blog</a></li>
				</ul>	
				*/ 
				?>
				<div class="row">
					<div class="col-md-12">
						<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5927dde055350600125cfd8d&product=inline-share-buttons"></script>
						<div class="sharethis-inline-share-buttons"></div>
					</div>
					<div class="col-md-12">
						<div class="follow_title">Follow Us:</div>
						<ul class="social">    	
							<li><a href="https://www.facebook.com/Tastes-of-States-766701600150656/" target="_blank" alt="Facebook"><i class="fa fa-facebook">&nbsp;</i></a></li>
							<li><a href="https://twitter.com/TastesOfStates?s=09" target="_blank" alt="Twitter"><i class="fa fa-twitter">&nbsp;</i></a></li>    	
						</ul>            
					</div>
				</div>		
			</div>
		</div>
	</div>
</footer>
<section class="side-cart-box" id="side-cart-box"  style="display:none;">
	<?php echo $obj_comm_top->getSideCartBox();?>
</section>
<div id="animatedModalIngredient" style="display:none;">
	<!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
	<div class="close_anim_model">
		<div class="close-animatedModalIngredient">X</div>
	</div>
	<div class="modal-content-loc">
		<div id="modal_ingredient_content" class="modal-content-inner">	
			
		</div>
	</div>
</div>
<div id="overlay-box" class="overlay-box" style="display:none;"></div>
<script src="<?php echo SITE_URL;?>/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery-ui.js"></script>
<script src="<?php echo SITE_URL;?>/js/bootstrap.min.js"></script>
<script src="<?php echo SITE_URL;?>/js/banner.js"></script>
<script src="<?php echo SITE_URL;?>/js/slick.js"></script>
<script src="<?php echo SITE_URL;?>/js/main.js"></script>
<script src="<?php echo SITE_URL;?>/js/animatedModal.min.js"></script>
<script src="<?php echo SITE_URL;?>/js/tokenize2.js"></script>
<script src="<?php echo SITE_URL;?>/js/commonfn.js?v=<?php echo time();?>"></script>
<script>
	/*
	$('#btnOpenCart').on('click', function() {
		$(".overlay-box").show();
		$("#side-cart-box").show(0).animate({'right': 0},500);	
	});
	
	$('#cart-box-toggle').on('click', function() {
		$("#side-cart-box").show(0).animate({'right': -320},500);	
		$(".overlay-box").hide();
	});
	*/
	$(function () {
		$('input').attr('autocomplete','false');
		$("#checkout-accordion").accordion({
			/*disabled: true,*/
			event: 'customClick',
			heightStyle: "content"
		});
		
		//$("#checkout-accordion").accordion("option", "active", 0);
		
		$( "#checkout-tabs" ).tabs();
		$( "#checkout-delivery-box" ).tabs();
		
		<?php
		if($page_id == '2')
		{
			if($obj->isUserLoggedIn())
			{ ?>
			operateAccordion(1);
			<?php	
			}
		} ?>
		
		<?php
		if($page_id == '4')
		{
			if($obj->isUserLoggedIn())
			{ ?>
			document.payment.submit();
			<?php	
			}
		} ?>
		
		<?php
		if($page_id == '19')
		{
			if(isset($_SESSION['cusinescrooltodiv']) && $_SESSION['cusinescrooltodiv'] != '')
			{ ?>
			scrollToDiv('<?php echo $_SESSION['cusinescrooltodiv'];?>');		
			<?php	
			}
		} ?>
	});
	function operateAccordion(tabNumber) {
		//alert(tabNumber);
		$("#checkout-accordion").accordion("option", "active", tabNumber);
	}
	
	//demo 01
	$('#btnTopLocation').on('click', function() {
		$('#animatedModalLocation').show();
	});
	
	$("#btnTopLocation").animatedModal({
		modalTarget:'animatedModalLocation',
		width:'50%', 
		height:'33%', 
		top:'33%', 
		left:'25%',
		color: '#FFFFFF', 
		afterOpen: function() {
			
		},
	});
	
	$('#btnTopLocation2').on('click', function() {
		$('#animatedModalLocation2').show();
	});
	
	$("#btnTopLocation2").animatedModal({
		modalTarget:'animatedModalLocation2',
		width:'50%', 
		height:'40%', 
		top:'30%', 
		left:'25%',
		color: '#FFFFFF', 
		afterOpen: function() {
			
		},
	});
	
	$('#btnTopLocation4').on('click', function() {
		$('#animatedModalLocation4').show();
	});
	
	$("#btnTopLocation4").animatedModal({
		modalTarget:'animatedModalLocation4',
		width:'50%', 
		height:'40%', 
		top:'30%', 
		left:'25%',
		color: '#FFFFFF', 
		afterOpen: function() {
			
		},
	});
	
	$('#btnTopLocation3').on('click', function() {
		$('#animatedModalLocation3').show();
	});
	
	$("#btnTopLocation3").animatedModal({
		modalTarget:'animatedModalLocation3',
		width:'50%', 
		height:'40%', 
		top:'30%', 
		left:'25%',
		color: '#FFFFFF', 
		afterOpen: function() {
			
		},
	});
	
	$('.cls_ingredient_popup').on('click', function() {
		$('#animatedModalIngredient').show();
	});
	
	$(".cls_ingredient_popup").animatedModal({
		modalTarget:'animatedModalIngredient',
		width:'60%', 
		height:'50%', 
		top:'25%', 
		left:'20%',
		color: '#FFFFFF', 
		beforeOpen: function() {
			//alert('111111');
			
			
		},
	});
	
	$('#select_your_city').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter City'
	});
	$('#select_your_city').on('tokenize:tokens:add', getTopAreaOption);
	$('#select_your_city').on('tokenize:tokens:remove', getTopAreaOption);
	
	$('#select_your_area').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter Area'
	});
	
	$('#select_your_city2').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter City'
	});
	$('#select_your_city2').on('tokenize:tokens:add', getDeliveryAreaOption);
	$('#select_your_city2').on('tokenize:tokens:remove', getDeliveryAreaOption);
	
	$('#select_your_area2').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter Area'
	});
	
	$('#select_your_city4').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter City'
	});
	$('#select_your_city4').on('tokenize:tokens:add', getBillingAreaOption);
	$('#select_your_city4').on('tokenize:tokens:remove', getBillingAreaOption);
	
	$('#select_your_area4').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter Area'
	});
	
	$('#contactus_city_id').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter City'
	});
	$('#contactus_city_id').on('tokenize:tokens:add', getContactUsAreaOption);
	$('#contactus_city_id').on('tokenize:tokens:remove', getContactUsAreaOption);
	
	$('#contactus_area_id').tokenize2({
		tokensMaxItems: 1,
		placeholder: 'Enter Area'
	});
	
	$('#contactus_item_id').tokenize2({
		placeholder: 'Enter Item'
	});
	
	$('#contactus_item_id').on('tokenize:tokens:add', toggleContactUsItemOther);
	$('#contactus_item_id').on('tokenize:tokens:remove', toggleContactUsItemOther);
	
	
</script>