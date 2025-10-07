<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '16';

$page_id="89";

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



$error = false;

$err_msg = "";

$msg = '';



if($adm_vendor_id != '')

{

	$vendor_id = $adm_vendor_id;

	$arr_record = $obj->getVendorDetails($vendor_id);

	if(count($arr_record) == 0)

	{

		header("Location: index.php");

		exit(0);

	}

	

	$vendor_parent_cat_id = $arr_record['vendor_parent_cat_id'];

	$vendor_cat_id = $arr_record['vendor_cat_id'];

	$vendor_name = $arr_record['vendor_name'];

	$vendor_username = $arr_record['vendor_username'];

	$vendor_status = $arr_record['vendor_status'];

    $vendor_email = $arr_record['vendor_email'];

    $vendor_mobile = $arr_record['vendor_mobile'];

    $vendor_unique_id=$arr_record['vendor_unique_id']; //added by ample 07-12-20
    $reference_id=$arr_record['reference_id']; //added by ample 07-12-20

    $food_products_offered =  explode(',', $arr_record['food_products_offered']); //add by ample 03-09-20


	$va_cat_name = $obj->getProfileCategoryName($arr_record['vendor_parent_cat_id']);

    $va_sub_cat_name = $obj->getSubCategoryName($arr_record['vendor_cat_id']);

	$arr_loc_record = $obj->getVendorAllLocationsAndCertifications($vendor_id);

	
	//add by ample 05-09-20
	$tag_level_1=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($arr_record['vendor_cat_id'],39,1);
	$tag_level_2=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($arr_record['vendor_cat_id'],39,2);


	 //add by ample 11-09-20
    $vendor_loc_data = $obj->getVendorAllLocationsAndCertifications($vendor_id);

    // echo '<pre>';
    // print_r( $vendor_loc_data);
    // die();

}	

else

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

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

	<style type="text/css">
		.box
		{
			border: 1px solid #eee;
    		padding: 5px;
    		border-radius: 2.5px;
    		margin: 2.5px;
		}
	</style>

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-md-10">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>

						</div>

					</div>

					<hr>

					<center><div id="error_msg">
							<?php 
								if(isset($_GET['msg']) && !empty($_GET['msg']))
								{
									echo '<div class="alert alert-info">'.$_GET['msg'].'</div>';
								}
							?>
						</div>
						    <?php 

								if(!empty($_SESSION['MSG'])) {
								   $message = $_SESSION['MSG'];
								   echo '<div class="alert alert-success">'.$message.'</div>';
								   unset($_SESSION['MSG']);
								}

								    ?>
					</center>

					<form role="form" class="form-horizontal" id="edit_vendor" name="edit_vendor" method="post"> 

						<input type="hidden" name="hdnvendor_id" id="hdnvendor_id" value="<?php echo $vendor_id;?>" >

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

                                                <input type="hidden" name="vendor_parent_cat_id" id="vendor_parent_cat_id" value="<?php echo $vendor_parent_cat_id; ?>">

						<input type="hidden" name="vendor_cat_id" id="vendor_cat_id" value="<?php echo $vendor_cat_id; ?>">

<!--						<div class="form-group">

							<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<select name="vendor_parent_cat_id" id="vendor_parent_cat_id" class="form-control" onchange="getMainCategoryOptionCommon('vendor','1');" required  >

								  <?php //echo $obj->getMainProfileOption($vendor_parent_cat_id);?>

                                                                    <?php //echo $obj->getEventCategoryRamakant('39',$vendor_parent_cat_id);?>

                                                                    <?php //echo $obj->getvendoraccesdropdownmain($vendor_parent_cat_id);?>

								</select>

							</div>

							<div class="col-lg-2"></div>

							<div class="col-lg-4">

								<select name="vendor_cat_id" id="vendor_cat_id" class="form-control" required>

									<?php //echo $obj->getMainCategoryOption($vendor_parent_cat_id,$vendor_cat_id); ?>

								</select>

							</div>

						</div>-->

						

                                                <div class="form-group">

							<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<?php echo $va_cat_name; ?>

							</div>

							<div class="col-lg-2"></div>

							<div class="col-lg-4">

                            <?php echo $va_sub_cat_name; ?>

							</div>

						</div>

                                                

						<div class="form-group"><label class="col-lg-2 control-label">Company Name<span style="color:red">*</span></label>

							<div class="col-lg-10">

								<input type="text" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" placeholder="Company Name" class="form-control" required>

							</div>

						</div>

						

						<div class="form-group">

							<label class="col-lg-2 control-label">Username<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="vendor_username" id="vendor_username" value="<?php echo $vendor_username;?>" placeholder="Vendor Username" class="form-control" required>

							</div>

							

							<label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<select name="vendor_status" id="vendor_status" class="form-control" readonly>

									<option value="1" <?php if($vendor_status == '1'){?> selected <?php } ?>>Active</option> 

									<option value="0" <?php if($vendor_status == '0'){?> selected <?php } ?>>Inactive</option> 

								</select>

							</div>

						</div>

                                                <div class="form-group">

						<label class="col-lg-2 control-label">Admin Email<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="vendor_email" id="vendor_email" value="<?php echo $vendor_email;?>" placeholder="Vendor Email" class="form-control" readonly required>

							</div>

						

						<label class="col-lg-2 control-label">Admin Mobile<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="vendor_mobile" id="vendor_mobile" value="<?php echo $vendor_mobile;?>" placeholder="Vendor Mobile" class="form-control" readonly required>

                                                                

                                                        </div>


						</div>


						<div class="form-group">
                              <label class="col-lg-2 control-label"><?=($tag_level_1['tag_heading'])? $tag_level_1['tag_heading'] : 'Speciality';?></label>
                              <div class="col-lg-10">
                                 <select name="food_products_offered[]" id="speciality_offered" multiple="multiple" class="form-control vloc_speciality_offered" >
                                            <?php //echo $obj->getFavCategoryVendorEdit('13,53,42,64',$food_products_offered); 

                                             if(!empty($tag_level_1['tag_data']))
                                             {
                                             	foreach ($tag_level_1['tag_data'] as $key => $value) {
                                             		$sel="";
                                             		if (in_array($value, $food_products_offered))
													  {
													  	$sel="selected";
													  }
													?>
                                             		<option value="<?=$value;?>" <?=$sel?> ><?=$value;?></option>
                                             		<?php
                                             	}
                                             }

                                            ?>

                                 </select>
                              </div>
                           </div> 

                        <hr>

                        <div class="pull-left">
                        	 <h3 style="color: purple;"><b> &nbsp; &nbsp; Your WW4U ID : <span style="text-shadow: 1px 1px 3px;"><?=$vendor_unique_id;?></span></b></h3>
                        </div>
                        <div class="pull-right">
                        	<h4 style="color: #1d60da;">Reference BY :
	                          <?php 
				                $refer_name="";
				                if(!empty($reference_id))
				                {
				                    $refer_name=$obj->get_user_name_by_referenceID($reference_id);
				                    echo $refer_name.' ('.$reference_id.')';
				                }
				            ?>
				        	</h4>
                        </div>
                        <div style="clear: both;"></div>
                        <hr>
                    <a href="add_location_contact.php" target="_blank" class="pull-right"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">ADD Company-Location details</button></a>
                    <br>
                    <table class="table table-bordered" style="margin-top: 15px;">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Services</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($vendor_loc_data))
                            {
                                foreach ($vendor_loc_data as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?=$key+1;?></td>
                                        <td><?=$obj->getProfileCategoryName($value['vloc_parent_cat_id']);?> <br>
                                        	<?=$obj->getFavCategoryNameVivek($value['vloc_cat_id']);?>
                                        </td>
                                        <td>
                                            <b>Area: </b> <?=$obj->getAreaName($value['area_id']);?> &nbsp;
                                            <b>City: </b> <?=$obj->GetCityName($value['city_id']);?> &nbsp;
                                            <br>
                                            <b>State: </b> <?=$obj->GetStateName($value['state_id']);?> &nbsp;
                                            <b>Country: </b> <?=$obj->GetCountryName($value['country_id']);?> &nbsp;
                                        </td>
                                        <td>
                                            <?=$value['vloc_speciality_offered'];?>
                                        </td>
                                        <td>
                                            <?=($value['vloc_status']==1)? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';?>
                                        </td>
                                        <td>
                                            
                                            <a href="edit_location_contact.php?token=<?=base64_encode($value['vloc_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">Edit</button></a>

                                             <?php 
                                           if($value['vloc_status']==1)
                                           {
                                             ?>
                                             <button class="btn btn-danger rounded" type="button" onclick="vendorLocationStatus(<?=$value['vloc_id'];?>,0)">Inactivate</button>
                                             <?php
                                           }
                                           else
                                           {
                                            ?>
                                             <button class="btn btn-success rounded" type="button" onclick="vendorLocationStatus(<?=$value['vloc_id'];?>,1)">Activate</button>
                                             <?php
                                           }
                                           ?>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr><td colspan="6" class="text-center">No vendor location found</td></tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
						

						<hr>

						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

                                                                       

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

                                                                       

                                    <a href="manage_vendors.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>



                                    <img border="0" class="image_load" src="<?php echo SITE_URL.'/images/loading.gif'?>" style=" width: 6%; display: none; float: right; margin-right:75%;">





								</div>

							</div>

						</div>

					</form>	

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

<script src="admin-js/edit-vendor-validator.js" type="text/javascript"></script>

<script>

	$(document).ready(function()

	{

		$('.vloc_speciality_offered').tokenize2();

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

                $("input[name^='city_id']").attr('autocomplete', 'off');

                $("input[name^='vc_cert_reg_date']").attr('autocomplete', 'off');

                $("input[id^='capitals']").attr('autocomplete', 'off');

                $("input[id^='vc_cert_validity_date']").attr('autocomplete', 'off');

	});	

	

	function getStateOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		

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

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				$("#state_id_"+id_val).html(result);

				getCityOptionAddMore(id_val);

			}

		});

	}

	

	function getCityOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		

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

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

                                //alert(result);

				//$("#city_id_"+id_val).html(result);

                                $("#capitals_"+id_val).html(result);

				getAreaOptionAddMore(id_val);

			}

		});

	}

	

	function getAreaOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		var area_id = $('#area_id_'+id_val).val();

		

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

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				$("#area_id_"+id_val).html(result);

			}

		});

	}




	

	function removeFileOfRow(idval)

	{

		$("#divid_"+idval).remove();

		$("#hdn"+idval).val('');

		

	}

        

        function getlocation(id_val)

       {           

           var city = $("#city_id_"+id_val).val();

            //alert(city);

            var dataString ='city='+city+'&action=getlocation';

            $.ajax({

                   type: "POST",

                    url: 'ajax/remote.php', 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                            //  alert(result);

                         var JSONObject = JSON.parse(result);

                         //var rslt=JSONObject[0]['status'];   

                        $('#area_id_'+id_val).html(JSONObject[0]['place_option']);

                       }

              }); 

       }

      //add by ample 18-09-20
    function vendorLocationStatus(id,status)
    {

        var action='vendorLocationStatus';
        $.ajax({
           url: 'ajax/remote.php',
           type: 'POST',
           data: {id: id, status: status, action:action},
           error: function() {
              alert('Something is wrong');
           },
           success: function(res) {
                alert(res);
                location.reload();
           }
        });
    }

  //add by ample
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();  
});

</script>



</body>

</html>