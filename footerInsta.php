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
					<!-- <li><a href="<?php echo SITE_URL.'/blog';?>">Blog</a></li> -->

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

					<li><i class="fa fa-mobile" aria-hidden="true"></i> &nbsp;8655018341</li>

					<li><a href="mailto:info@wellnessway4u.com"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;info@wellnessway4u.com</a></li>

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

							<li><a href="https://www.facebook.com/WellnessWay4U/" target="_blank" alt="Facebook"><i class="fab fa-facebook-f iconshow" >&nbsp;</i></a></li>

							<li><a href="https://twitter.com/WellnessWay4U" target="_blank" alt="Twitter"><i class="fab fa-twitter iconshow">&nbsp;</i></a></li>  

							<li><a href="https://instagram.com/WellnessWay4U" target="_blank" alt="Instagram"><i class="fab fa-instagram iconshow">&nbsp;</i></a></li>
                                                        
                                                        <li><a href="<?php echo SITE_URL.'/blog';?>" target="_blank" alt="blog"><i class="fab fa-blogger-b iconshow"></i></a></li>   

						</ul>            

					</div>

				</div>		

			</div>

		</div>

	</div>

</footer>


<section class="side-cart-box" id="side-cart-box"  style="display:none;">
	<?php echo $obj->getSideCartBox();?>
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
                                         <input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="GetFeedback();"/>                            
                                     </td>                        
                                 </tr>                       
                             </table>                
                         </form>            
                     </div>        
                 </div>    
             </div>
         </div>


<div id="overlay-box" class="overlay-box" style="display:none;"></div>

<!-- <script src="w_js/jquery-1.12.4.min.js"></script> -->


<script src="w_js/jquery-ui.js"></script>
<script src="w_js/bootstrap.min.js"></script>
<script src="w_js/banner.js"></script>

<script src="w_js/bootbox.min.js"></script>
<script src="w_js/bootstrap-dialog.js"></script>
<!-- <script src="js/commonfnz.js"></script> -->
<!-- <script src="js/jquery.ticker.js" type="text/javascript"></script> -->

<script type="text/javascript" src="js/jquery.bxSlider.js"></script>
<script type="text/javascript" src="js/jquery.datepick.js"></script>

<!-- <script src="js/jquery.ticker.js" type="text/javascript"></script> -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="js/jquery.simpleTicker.js"></script>

<script src="w_js/slick.js"></script>
<script src="w_js/main.js"></script>
<script src="w_js/commonfn.js?v=<?php echo time();?>"></script>

<script src="js/commonfn.js?v=<?php echo time();?>"></script>

<script src="w_js/animatedModal.min.js"></script>
<script src="w_js/tokenize2.js"></script>

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script>
$(function(){
  $.simpleTicker($("#news-ticker-fade-demo"),{'effectType':'fade'});
});
</script>

<script src="https://cdn.rawgit.com/jackmoore/colorbox/master/jquery.colorbox-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.3/js.cookie.min.js"></script>


<!-- <script src="js/jquery.colorbox-min.js"></script> -->
<!-- <script src="js/js.cookie.min.js"></script> -->
  <script type="text/javascript" src="js/ddsmoothmenu.js"></script>
      <!-- <script src = "https://code.jquery.com/jquery-1.10.2.js"></script> -->
      <!-- <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->

<style>
.iconshow
{
    font-size: 15px !important;
    text-align: center !important;
}
</style>


<script>

	
	// $('#btnOpenCart').on('click', function() {
	// 	$(".overlay-box").show();
	// 	$("#side-cart-box").show(0).animate({'right': 0},500);	
	// });

	

	// $('#cart-box-toggle').on('click', function() {
	// 	$("#side-cart-box").show(0).animate({'right': -320},500);	
	// 	$(".overlay-box").hide();
	// });
	




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


  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#start_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
    $( "#end_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
    $( "#single_date" ).datepicker({ dateFormat: 'dd-mm-yy' });

    $( "#status_start_date" ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#status_end_date" ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#invite_end_date" ).datepicker({ dateFormat: 'dd/mm/yy' });

    // $( "#day_month_year" ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#day_month_year" ).datepicker({ dateFormat: 'dd-mm-yy',defaultDate: -1, minDate:'-1d',maxDate: 0});
    
    $( "#from_day_month_year" ).datepicker({ dateFormat: 'dd-mm-yy' });
    $( "#to_day_month_year" ).datepicker({ dateFormat: 'dd-mm-yy' });

    
    
  } );



  // datepicker({ dateFormat: 'dd-mm-yy' }).val();
  </script>







<script type="text/javascript">

        // $(document).ready(function(){
            // $('#js-news').ticker({
            //     controls: true,        // Whether or not to show the jQuery News Ticker controls
            //     htmlFeed: true, 
            //     titleText: '',   // To remove the title set this to an empty String
            //     displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
            //     direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
            // });

            // $('#slider1').bxSlider();
            // $('#slider2').bxSlider();
            // $('#slider3').bxSlider();
            // $('#slider4').bxSlider();
            // $('#slider5').bxSlider();
            // $('#slider6').bxSlider();


            // $('#slider_main1').bxSlider();
            // $('#slider_main2').bxSlider();
            // $('#slider_main3').bxSlider();
            // $('#slider_main4').bxSlider();
            // $('#slider_main5').bxSlider();
            // $('#slider_main6').bxSlider();

            // $(".QTPopup").css('display','none');

            // $(".feedback").click(function(){    
            //  $(".QTPopup").animate({width: 'show'}, 'slow');
            // }); 

            // $(".closeBtn").click(function(){            
            //     $(".QTPopup").css('display', 'none');
            // });

        // });

    </script>


<?php
 
 // if(isset($_SESSION['home_pop'])=="")
 // {
 // 	echo "helow";
 // }
 // else
 // {

 // 	echo "ok";
 // }
 
?>





<script>

// function home_popup(val)
// {
// 	var dataString ='&valid='+val+'&action=home_set_pop';
// 		$.ajax({
// 			type: "POST",
// 			url: "remote2.php",
// 			data: dataString,
// 			cache: false,
// 			success: function(result)
// 			{
//                 alert(result);
// 			}
// 		});



// }


// $(document).ready(function(){
// 	var validNavigation=false;
// 	window.onbeforeunload = function() {
//      if (!validNavigation) {
     	
//      	 Cookies.remove('colorboxShown');
//          $(this).replaceWith("<p><em>Cookie cleared. Re-run demo</em></p>");
//           // endSession();
//   }
// }

// });





// $(".clear-cookie").on("click", function() {
//   Cookies.remove('colorboxShown');
//   $(this).replaceWith("<p><em>Cookie cleared. Re-run demo</em></p>");
// });


<?php 
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$value=$obj->showPopupPageOnselectingPage(basename($path));
if($value==basename($path) && $value!="")
{
   ?>
$(".order-cheezburger").on("click", function() {
  $.colorbox.close();
});

function onPopupOpen() {

	// alert('hi');
  $("#modal-content").show();
  $("#yurEmail").focus();
  $('body').css('overflow','hidden');
}
function onPopupClose() {
	// alert('hi');
  $("#modal-content").hide();
  Cookies.set('colorboxShown', 'yes', {
    expires: 1
  });
  $(".clear-cookie").fadeIn();
  lastFocus.focus();

  $('body').css('overflow','visible');
}

function displayPopup() {
  $.colorbox({
    inline: true,
    href: "#modal-content",
    className: "cta",
    width: 600,
    height: 350,
    onComplete: onPopupOpen,
    onClosed: onPopupClose
  });
}

var lastFocus;
var popupShown = Cookies.get('colorboxShown');


if (popupShown) {

  // console.log("Cookie found. No action necessary");
  $(".clear-cookie").show();
} else {
	// alert('hi');
  // console.log("No cookie found. Opening popup in 3 seconds");


  $(".clear-cookie").hide();
  setTimeout(function() {
    lastFocus = document.activeElement;
    displayPopup();
  }, 500);

}


<?php

}

?>

function close_popup()
{
  
  $("#modal-content").hide();
  $("#colorbox").css("visibility","hidden");
  $("#cboxOverlay").css("visibility","hidden");
  
  onPopupClose();

}


</script>





<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>




 
  
    <script type="text/javascript">
        ddsmoothmenu.init({
            mainmenuid: "smoothmenu1", //menu DIV id 
            orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
            classname: 'ddsmoothmenu', //class added to menu's outer DIV
            //customtheme: ["#1c5a80", "#18374a"],
            contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
        })
    </script>

<!-- <script>
     $(function() {
        $( "#autocomplete-5" ).autocomplete({
           source: "search.php",
           minLength: 2
        });
     });
  </script>  -->

   <script>
       function getlocation()
       {
           var signup_city = $("#signup_city").val();
            var dataString ='signup_city='+signup_city +'&action=getlocation';
            $.ajax({
                   type: "POST",
                    url: 'login.php', 
                   data: dataString,
                   cache: false,
                   success: function(result)
                        {
                         var JSONObject = JSON.parse(result);
                         //var rslt=JSONObject[0]['status'];   
                        $('#signup_location').html(JSONObject[0]['place_option']);
                       }
              }); 
       }
       
       function isNumberKey(evt){  <!--Function to accept only numeric values-->
    //var e = evt || window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
        return false;
        return true;
	}
   </script>