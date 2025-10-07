<?php 

include('classes/config.php');

$page_id = '11';

$obj = new frontclass();

$page_data = $obj->getPageDetails($page_id);



if(!$obj->isLoggedIn())

{

//	header("Location: login.php?ref=".$ref);

echo "<script>window.location.href='login.php?ref=$ref'</script>";

exit(0);

}



else



{



$user_id = $_SESSION['user_id'];

$obj->doUpdateOnline($_SESSION['user_id']);

list($return,$name,$middle_name,$last_name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$practitioner_id,$country_id, $reference_id) = $obj->getUserDetailsVivek($user_id);

if($food_veg_nonveg == 'NV')



{



$tr_beef_pork = '';



}



else



{



$tr_beef_pork = 'none';



}

}







if(isset($_GET['ref']))



{



$ref = $_GET['ref'];



}



elseif(isset($_POST['ref']))



{



$ref = $_POST['ref'];



}



else



{



$ref = '';



}





if(isset($_GET['gestid']))



{



$gestid = $_GET['gestid'];



}

else



{



$gestid = '';



}



if(isset($_GET['uid']))

{



$uid =  base64_decode($_GET['uid']);

}

else

{

$uid =  '';

}





$ref_url = base64_decode($ref);

$tr_err_msg = 'none';

$error = false;

$err_msg = '';



if(isset($_REQUEST['action']) && $_REQUEST['action'] =='getlocation')

{



$response=array();

$signup_city=$_REQUEST['signup_city']!='' ? $_REQUEST['signup_city'] : '';

$city_id = $obj->getCityIdbyName($signup_city);



if($city_id!='')

{

$response['place_option'] = $obj->getPlaceOptions($city_id);

$response['error'] = 0;

}

echo json_encode(array($response));

exit(0);    

}





if(isset($_POST['btnSubmit']))	



{



$user_id = $_SESSION['user_id'];

$name = strip_tags(trim($_POST['name']));

$middle_name = strip_tags(trim($_POST['middle_name']));

$last_name = strip_tags(trim($_POST['last_name']));

$dob = $_POST['day_month_year'];

$height = strip_tags(trim($_POST['height']));

$weight = strip_tags(trim($_POST['weight']));

$sex = strip_tags(trim($_POST['sex']));

$mobile = strip_tags(trim($_POST['signup_mobile_no']));

$country_id = strip_tags(trim($_POST['country_id']));

$state_id = strip_tags(trim($_POST['state_id']));

$city_id = $obj->getCityIdbyName($_POST['city_id']);

$place_id = strip_tags(trim($_POST['area_id']));

$food_veg_nonveg = strip_tags(trim($_POST['food_veg_nonveg']));

$beef = strip_tags(trim($_POST['beef']));

$pork = strip_tags(trim($_POST['pork']));





if($name == '')

{

$error = true;

$tr_err_name = '';

$err_msg .= '<p>Please enter your name</p>';

}



if($middle_name == '')

{

$error = true;

$tr_err_middle_name = '';

$err_msg .= '<p>Please enter your middle name</p>';

}

if($last_name == '')

{

$error = true;

$tr_err_last_name = '';

$err_msg .= '<p>Please enter your last name</p>';

}



if($dob == '')

{

$error = true;

$tr_err_last_name = '';

$err_msg .= '<p>Please select date of birth</p>'; 

}

else {



$dob = date("Y-m-d", strtotime($dob));

}





if($height == '')



{



$error = true;



$tr_err_height = '';



$err_msg .= '<p>Please select your height</p>';



}



elseif(!is_numeric($height))



{



$error = true;

$tr_err_height = '';

$err_msg .= '<p>Please enter valid height in cm</p>';



}



if($weight == '')



{



$error = true;

$tr_err_weight = '';

$err_msg .= '<p>Please enter your weight in kgs</p>';

}



elseif(!is_numeric($weight))



{



$error = true;

$tr_err_weight = '';

$err_msg .= '<p>Please enter valid weight in kgs</p>';

}



if($sex == '')



{



$error = true;

$tr_err_sex = '';

$err_msg .='<p>Please select your sex</p>';

}



if($mobile == '')

{



$error = true;

$tr_err_mobile = '';

$err_msg .= '<p>Please enter your mobile no</p>';



}



if($country_id == '')



{



$error = true;

$tr_err_country_id = '';

$err_msg .= '<p>Please select your country</p>';

}

if($state_id == '')

{



$error = true;

$tr_err_state_id = '';

$err_msg .= '<p>Please select your state</p>';

}



if($city_id == '')

{



$error = true;

$tr_err_city_id = '';

$err_msg .= '<p>Please select your city</p>';

}







if($place_id == '')



{

$error = true;

$tr_err_place_id = '';

$err_msg .= '<p>Please select your place</p>';

}



if($food_veg_nonveg == '')



{

$error = true;

$tr_err_food_veg_nonveg = '';

$err_msg .= '<p>Please select food option</p>';

}



else



{



if($food_veg_nonveg == 'NV')

{

$tr_beef_pork = '';

}

else

{



$beef = '0';

$pork = '0';

$tr_beef_pork = 'none';

}

}



if(!$error)



{

// echo 'hiiii';



// exit;

$updateUser = $obj->updateUserVivek($name,$middle_name,$last_name,$dob,$height,$weight,$sex,$mobile,$country_id,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_id);

if($updateUser)



{



$_SESSION['name'] = $name;

//			header("Location: message.php?msg=2"); 

echo "<script>window.location.href='message.php?msg=1'</script>"; //2 is old message id



}



else



{



$err_msg .= '<p>There is some problem right now!Please try again later</p>';



}



}



}    



?>

<!DOCTYPE html>

<html lang="en">

<head>



<?php include_once('head.php');?>

</head>

<body>

<?php include_once('header.php');?>

<section id="checkout">

<div class="container">

<div class="row">

<div class="col-md-8">

<div id="checkout-accordion">

<h3 data-corners="false">

<p style="margin-top: 0px;"><?php echo $obj->getPageTitle($page_id);?></p>

</h3>

<div class="checkout-accordion-content">

<?php if($error)    {  ?>

<span style="color:red;"><?php echo $err_msg; ?></span>

<?php 

}

?>

<div id="checkout-tabs" class="checkout-tabs">

<br>
 <h3 style="color: purple;"><b> &nbsp; &nbsp; Your WW4U ID : <span style="text-shadow: 1px 1px 3px;"><?=$obj->getUserUniqueId($user_id);?></span></b></h3>
<hr>


<form name="frm_signup" id="frm_signup" method="post">

<input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>" />             

<input type="hidden" name="gestid" id="gestid" value="<?php echo base64_decode($gestid);?>" /> 

<input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" />

<input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />

<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id'];?>" />

<div id="checkout-signup-tab">

<span id="err_msg_signup"></span>

<div id="signup-box">

    <div class="form-group">

        <label class="col-lg-6">First Name</label>

        <label class="col-lg-6">Middle Name</label>

     </div>

<div class="form-group">

            <input required="" type="text" name="name" id="name" placeholder="First Name" value="<?php echo $name; ?>" class="input-text-box input-half-width" autocomplete="false">

                <input required="" type="text" name="middle_name" id="middle_name" value="<?php echo $middle_name; ?>" placeholder="Middle Name" class="input-text-box input-half-width" autocomplete="false">



</div>

        <div class="form-group">

            <label class="col-lg-6">Last Name</label>

            <label class="col-lg-6">Gender</label>

        </div>

        <div class="form-group">

            <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" placeholder="Last Name" class="input-text-box input-half-width" autocomplete="false">

            &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" id="sex" <?php if($sex == 'Male') { echo 'Checked'; } ?> value="Male"> Male

            &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" id="sex" <?php if($sex == 'Female') { echo 'Checked'; } ?> value="Female"> Female

        </div>

        <div class="form-group">

            <label class="col-lg-6">Email</label>

            <label class="col-lg-6">Mobile</label>

        </div>

<div class="form-group">

            <input type="text" required="" readonly="" name="signup_email" id="signup_email" value="<?php echo $email; ?>" placeholder="Email" class="input-text-box input-half-width" autocomplete="false">

            <input type="text" required="" onKeyPress="return isNumberKey(event);" maxlength="10" name="signup_mobile_no" id="signup_mobile_no" value="<?php echo $mobile; ?>" placeholder="10 digit Mobile Number" class="input-text-box input-half-width" autocomplete="false">

        </div>

<div class="form-group">

            <label class="col-lg-6">Country</label>

            <label class="col-lg-6">State</label>

        </div>

        <div class="form-group">

            

               <select required="" class="input-text-box input-half-width" name="country_id" id="country_id" onchange="getStateOption()">

                    <?php echo $obj->getCountryOption($country_id); ?>

                </select>



            <select required="" class="input-text-box input-half-width" name="state_id" id="state_id" onchange="getCityOption();">

                    <option value="">Select your state</option>

                    <?php echo $obj->getStateOption($country_id,$state_id); ?>

                </select>



</div>

        <div class="form-group">

            <label class="col-lg-6">City</label>

            <label class="col-lg-6">Location</label>

        </div>

        <div class="form-group">

            <input type="text" required="" name="city_id" value="<?php echo $obj->GetCityName($city_id); ?>" id="city_id" placeholder="Select your city" list="capitals" class="input-text-box input-half-width" onchange="getlocation();" autocomplete="off"/>

                <datalist id="capitals">

                    <?php echo $obj->getCityOptions($city_id); ?>

                </datalist>

                <select required="" class="input-text-box input-half-width" name="area_id" id="area_id">

                    <option value="">Select your location</option>

                    <?php echo $obj->getAreaOption($country_id,$state_id,$city_id,$place_id); ?>

                </select>



</div>

     <div class="form-group">

        <label class="col-lg-12">Date of Birth</label>

       

     </div>

        <div class="form-group">

            

            <input type="date" required="" name="day_month_year" id="DOB" placeholder="Select Date" value="<?php echo date("d-m-Y",strtotime($dob)); ?>" class="input-text-box input-half-width" autocomplete="off">

            

</div>

    

        

     <div class="form-group">

        <label class="col-lg-6">Height</label>

        <label class="col-lg-6">Weight: (kg)</label>

     </div>

    <div class="form-group">

        <select required="" class="input-text-box input-half-width" name="height" id="height">

                    <option value="">Select your height</option>

                    <?php echo $obj->getHeightOptions($height); ?>

                </select> 

        <select required="" class="input-text-box input-half-width" name="weight" id="weight">

               <option value="">Select your Weight</option>

              <?php



               for($i=45;$i<=200;$i++)



               { ?>



                   <option value="<?php echo $i;?>" <?php if($weight == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Kgs</option>



               <?php



               } ?>

           </select> 

        

            

</div>

     <div class="form-group">

        <label class="col-lg-12">Food Option</label>

     </div>

<div class="form-group md-col-12">

        <input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="V" <?php if($food_veg_nonveg == "V") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg &nbsp;



            <input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="VE" <?php if($food_veg_nonveg == "VE") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg + Egg&nbsp;



            <input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="NV" <?php if($food_veg_nonveg == "NV") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />All(Veg + Non Veg)&nbsp;

            <span id="tr_beef_pork" style="display:<?php echo $tr_beef_pork;?>;">

            <input type="checkbox" name="beef" id="beef" value="1" <?php if($beef == "1") { ?> checked="checked" <?php } ?> />Beef &nbsp;



            <input type="checkbox" name="pork" id="pork" value="1" <?php if($pork == "1") { ?> checked="checked" <?php } ?> />Pork &nbsp;

            </span>

        </div>

<div class="form-group">

                <button type="submit" class="btn-red" name="btnSubmit" id="btnSubmit" >Update My Account</button>

                

</div>	

</div>



</div>

</form>

</div>

</div>

</div>
    <br>
    <h4 style="color: #1d60da;">Reference BY : 

            <?php 
                $refer_name="";
                if(!empty($reference_id))
                {
                    $refer_name=$obj->get_user_name_by_referenceID($reference_id);
                    if(empty($refer_name))
                    {
                        $refer_name=$obj->get_vendor_name_by_referenceID($reference_id);
                    }
                    echo $refer_name.' ('.$reference_id.')';
                }
            ?>
    </h4>
        

</div>

<div class="col-md-2">

<?php include_once('left_sidebar.php'); ?>

</div>

<div class="col-md-2">

<?php include_once('right_sidebar.php'); ?>

</div>



</div>

</div>

</section>

<?php include_once('footer.php');?>	

<script>



$(document).ready(function()

{

$('#DOB').attr('autocomplete', 'off');

$('#DOB').datepicker(

{

dateFormat: 'dd-mm-yy'

}        

);



$('.vloc_speciality_offered').tokenize();



}

);



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



function toggleBeefAndPorkOption()

{

var food_veg_nonveg = $('input:radio[name=food_veg_nonveg]:checked').val();

if(food_veg_nonveg == 'NV')

{

document.getElementById('tr_beef_pork').style.display = '';

}

else

{

document.getElementById('tr_beef_pork').style.display = 'none';

}	



}    



function getStateOption()

{

var country_id = $('#country_id').val();

var state_id = $('#state_id').val();



if(country_id == null)

{

country_id = '-1';

}



if(state_id == null)

{

state_id = '-1';

}





var dataString ='country_id='+country_id+'&state_id='+state_id+'&action=getstateoption';

$.ajax({

type: "POST",

url: "remote2.php",

data: dataString,

cache: false,      

success: function(result)

{

$("#state_id").html(result);

getCityOption();

}

});

}

function getCityOption(id_val)

{

var country_id = $('#country_id').val();

var state_id = $('#state_id').val();

var city_id = $('#city_id').val();



if(country_id == null)

{

country_id = '-1';

}



if(state_id == null)

{

state_id = '-1';

}



if(city_id == null)

{

city_id = '-1';

}



var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';

$.ajax({

type: "POST",

url: "remote2.php",

data: dataString,

cache: false,      

success: function(result)

{

//alert();

$("#capitals").html(result);

getAreaOption();

}

});

}



function getAreaOption()

{

var country_id = $('#country_id').val();

var state_id = $('#state_id').val();

var city_id = $('#city_id').val();

var area_id = $('#area_id').val();



if(country_id == null)

{

country_id = '-1';

}



if(state_id == null)

{

state_id = '-1';

}



if(city_id == null)

{

state_id = '-1';

}



if(area_id == null)

{

area_id = '-1';

}



var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&action=getareaoption';

$.ajax({

type: "POST",

url: "remote2.php",

data: dataString,

cache: false,      

success: function(result)

{

$("#area_id").html(result);

}

});

}



function getlocation()

{

var city = $("#city_id").val();

//alert(city);

var dataString ='city='+city+'&action=getlocation';

$.ajax({

type: "POST",

url: 'remote2.php', 

data: dataString,

cache: false,

success: function(result)

{

//alert(result);

var JSONObject = JSON.parse(result);

//var rslt=JSONObject[0]['status'];   

$('#area_id').html(JSONObject[0]['place_option']);

}

}); 

}

</script>





</body>

</html>