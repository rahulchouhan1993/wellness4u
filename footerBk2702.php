<footer>
        <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.1';
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
	<div class="container">

		<div class="row">

			<div class="col-md-3 col-xs-12 footer_menu ">

				<h4>COMPANY</h4>

				<ul>

					<li><a href="<?php echo SITE_URL.'/about_us.php';?>">About Us</a></li>

					<li><a href="<?php echo SITE_URL.'/terms_and_conditions.php';?>">Terms & Conditions Policy</a></li>

					<li><a href="<?php echo SITE_URL.'/disclaimer.php';?>">Disclaimer Policy</a></li>

					<li><a href="<?php echo SITE_URL.'/privacy_policy.php';?>">Privacy Policy</a></li>

					<li><a href="<?php echo SITE_URL.'/resources.php';?>">Resources</a></li>

				</ul>

			</div>

			<div class="col-md-3 col-xs-12 footer_menu ">

				<h4>Business Associates</h4>

				<ul>

					<li><a href="<?php echo SITE_URL.'/wa_register.php';?>">Business Associates Registration</a></li>

					<!--<li><a href="<?php //echo BA_URL.'/login.php';?>">Business Associates Login</a></li>-->

				</ul>

			</div>

			<div class="col-md-3 col-xs-12 footer_menu ">

				<h4>CONTACT</h4>

				<ul>

					<li><a href="<?php echo SITE_URL.'/contact_us.php';?>">Contact Us</a></li>

					<li><img src="images/icon4.png" alt="">8655018341</li>

					<li><a href="mailto:info@wellnessway4u.com">info@wellnessway4u.com</a></li>

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
                         
                                                <div class="sharethis-inline-share-buttons">
					</div>

					<div class="col-md-12">

						<div class="follow_title">Follow Us:</div>

						<ul class="social">    	

							<li><a href="https://www.facebook.com/WellnessWay4U/" target="_blank" alt="Facebook"><i class="fa fa-facebook">&nbsp;</i></a></li>

							<li><a href="https://twitter.com/WellnessWay4U" target="_blank" alt="Twitter"><i class="fa fa-twitter">&nbsp;</i></a></li>    	

						</ul>            

					</div>

				</div>		

			</div>

		</div>

	</div>

</footer>



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

<div class="feedback" onclick="FeedBackForm()"><img src="images/feedback_button.png" width="35" height="127" /></div>
         <div class="QTPopup">    
             <div class="popupGrayBg"></div>    
             <div class="QTPopupCntnr">        
                 <div class="gpBdrRight">            
                     <div class="caption">                
                         <div id="caption_text">Feedback and Suggestions</div>            
                     </div><a href="#" class="closeBtn" title="Close"></a>            
                     <div id="prwcontent"> <br />                
                         <form id="frm_feedback" name="frm_feedback" method="post" action="#" enctype="multipart/form-data">                    
                             <input type="hidden" name="main_page_id" id="main_page_id" value="<?php echo $main_page_id; ?>" />                    
                             <input type="hidden" name="hdn_p_id" id="hdn_p_id" value="" />                    
                                 <?php $temp_page_id = $obj->getTemppageId($page_id);?>                    
                             <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">                        
                                 <tr>                            
                                     <td width="60%" height="40" align="left" valign="top">Subject:</td>                            
                                     <td width="40%" height="40" align="left" valign="top">                                
                                         <select id="temp_page_id" name="temp_page_id">                                    
                                             <?php echo $obj->getFeeadBackPages($temp_page_id); ?>                                
                                         </select>                            
                                     </td>                        
                                 </tr>                        
                                     <?php if($obj->isLoggedIn()) { 
                                         $user_id = $_SESSION['user_id'];                            
                                         $name = $obj->getUserFullNameById($user_id);                            
                                         $email = $obj->getUserEmailById($user_id);                            
                                         $readonly = ' readonly ';                        
                                         
                                     } else 
                                         { 
                                         $readonly = ''; 
                                         
                                         } ?>                        
                                 <tr> 
                                     <td width="60%" height="40" align="left" valign="top">Name:</td>                            
                                     <td width="40%" height="40" align="left" valign="top">                                
                                         <input type="text" id="name" name="name" <?php  echo $readonly; ?> value="<?php echo $name; ?>"/>                            
                                     </td>                        
                                 </tr>                        
                                 <tr>                            
                                     <td width="60%" height="40" align="left" valign="top">Email:</td>                            
                                     <td width="40%" height="40" align="left" valign="top">                                
                                         <input type="text" id="email" name="email" <?php  echo $readonly; ?> value="<?php echo $email; ?>"/>                                                                         
                                     </td>                        
                                 </tr>                        
                                 <tr>                            
                                     <td width="60%" height="110" align="left" valign="top">Feedback and Suggestions:</td>                            
                                     <td width="40%" height="110" align="left" valign="top">                                    
                                         <textarea  cols="30" rows="5" type="text" id="feedback" name="feedback"><?php echo $textarea;?></textarea>                                                                         
                                     </td>                        
                                 </tr>                        
                                 <tr>                            
                                     <td width="60%" height="40" align="left" valign="middle">&nbsp;</td>                            
                                     <td width="40%" height="40" align="left" valign="middle">                                
                                         <input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="GetFeedback()"/>                            
                                     </td>                        
                                 </tr>                       
                             </table>                
                         </form>            
                     </div>        
                 </div>    
             </div>
         </div>


<div id="overlay-box" class="overlay-box" style="display:none;"></div>

<script src="w_js/jquery-1.12.4.min.js"></script>
<script src="w_js/jquery-ui.js"></script>
<script src="w_js/bootstrap.min.js"></script>
<script src="w_js/banner.js"></script>
<script src="w_js/slick.js"></script>
<script src="w_js/main.js"></script>
<script src="w_js/animatedModal.min.js"></script>
<script src="w_js/tokenize2.js"></script>
<script src="w_js/bootbox.min.js"></script>
<script src="w_js/bootstrap-dialog.js"></script>
<script src="w_js/commonfn.js?v=<?php echo time();?>"></script>

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

	
        $('#btnTopLocation15').on('click', function() {

		$('#animatedModalLocation15').show();

	});

	

	$("#btnTopLocation15").animatedModal({

		modalTarget:'animatedModalLocation15',

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

	$('#request_city_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter City'

	});

	$('#contactus_city_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter City'

	});
        $('#request_area_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Area'

	});
        
        $('#request_city_id').on('tokenize:tokens:add', getRequestAreaOption);

	$('#request_city_id').on('tokenize:tokens:remove', getRequestAreaOption);

        
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

	
// Form Other request for cuisin 

function FeedBackForm()
{
    var dataString ='action=feedback_form';
	$.ajax({
		type: "POST",
		url: "remote2.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
                     BootstrapDialog.show({
                                title: 'Feedback Form',
                                message:result
                            });
		}
	});
}

</script>