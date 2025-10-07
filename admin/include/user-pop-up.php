<?php 
require_once('../config/class.mysql.php');

require_once('../classes/class.places.php');


require_once('../classes/class.profilecustomization.php');  
$obj3 = new ProfileCustomization();

$obj2 = new Places();

 $user_height1 = '';

    $user_height2 = '';

    $user_weight1 = '';

    $user_weight2 = '';
    
    $user_age1 = '';

    $user_age2 = '';

    $user_bmi1 = '';

    $user_bmi2 = '';
    
    $user_food_option = '';
    
     $user_gender = '';
?>                                              

                                                                
                                       <tr>

                                                                <td height="100" align="left" valign="top"><strong>Country:</strong></td>

                                                                <td align="left" valign="top">

                                                                    <select name="user_country_id" id="user_country_id" onchange="getStateOptionsMultiCMN('user');" style="width:200px;">

                                                                        <option value="" >All Country</option>

                                                                        <?php echo $obj2->getCountryOptions($user_country_id); ?>

                                                                    </select>

                                                                </td>

                                                                <td height="100" align="left" valign="top" class="Header_brown"><strong>State:</strong></td>

                                                                <td align="left" valign="top" id="tdstate_user">

                                                                    <select multiple="multiple" name="user_state_id[]" id="user_state_id" onchange="getCityOptionsMultiCMN('user');" style="width:200px;">

                                                                        <option value="" <?php if (in_array('', $arr_user_state_id)) {?> selected="selected" <?php } ?>>All States</option>

                                                                        <?php echo $obj2->getStateOptionsMulti($user_country_id,$arr_user_state_id); ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td height="100" align="left" valign="top"><strong>City:</strong></td>

                                                                <td align="left" valign="top" id="tdcity_user">

                                                                    <select multiple="multiple" name="user_city_id[]" id="user_city_id" onchange="getPlaceOptionsMultiCMN('user');" style="width:200px;">

                                                                        <option value="" <?php if (in_array('', $arr_user_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>

                                                                        <?php echo $obj2->getCityOptionsMulti($user_country_id,$arr_user_state_id,$arr_user_city_id); ?>

                                                                    </select>

                                                                </td>

                                                                <td height="100" align="left" valign="top" class="Header_brown"><strong>Place:</strong></td>

                                                                <td align="left" valign="top" id="tdplace_user">

                                                                    <select multiple="multiple" name="user_place_id[]" id="user_place_id" style="width:200px;">

                                                                        <option value="" <?php if (in_array('', $arr_user_place_id)) {?> selected="selected" <?php } ?>>All Places</option>

                                                                        <?php echo $obj2->getPlaceOptionsMulti($user_country_id,$arr_user_state_id,$arr_user_city_id,$arr_user_place_id); ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td width="150" height="45" align="left" valign="top"><strong>Gender:</strong></td>

                                                                <td width="250" align="left" valign="top">

                                                                    <select name="user_gender" id="user_gender">

                                                                        <option value="">All Gender</option>

                                                                        <option value="Male" <?php if($user_gender == 'Male') {?> selected <?php } ?> >Male</option>

                                                                        <option value="Female" <?php if($user_gender == 'Female') {?> selected <?php } ?> >Female</option>

                                                                    </select>

                                                                </td>

                                                                <td width="150" height="45" align="left" valign="top"><strong>Food Option:</strong></td>

                                                                <td width="250" align="left" valign="top">

                                                                    <select name="user_food_option" id="user_food_option">

                                                                        <option value="">All</option>

                                                                        <option value="V" <?php if($user_food_option == 'V') {?> selected <?php } ?> >Veg</option>

                                                                        <option value="VE" <?php if($user_food_option == 'VE') {?> selected <?php } ?> >Veg + Egg</option>

                                                                        <option value="NV" <?php if($user_food_option == 'NV') {?> selected <?php } ?> >All(Veg + Non Veg)</option>

                                                                        <option value="NVB" <?php if($user_food_option == 'NVB') {?> selected <?php } ?> >All(Veg + Non Veg + Beef)</option>

                                                                        <option value="NVP" <?php if($user_food_option == 'NVP') {?> selected <?php } ?> >All(Veg + Non Veg + Pork)</option>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td height="45" align="left" valign="top" class="Header_brown"><strong>User Height Range:</strong></td>

                                                                <td colspan="3" align="left" valign="top">

                                                                    <select name="user_height1" id="user_height1">

                                                                        <option value="">All</option>

                                                                        <?php echo $obj3->getHeightOptions($user_height1); ?>

                                                                    </select>

                                                                    &nbsp; - &nbsp;

                                                                    <select name="user_height2" id="user_height2">

                                                                        <option value="">All</option>

                                                                        <?php echo $obj3->getHeightOptions($user_height2); ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td height="45" align="left" valign="top" class="Header_brown"><strong>User Weight Range:</strong></td>

                                                                <td colspan="3" align="left" valign="top">

                                                                    <select name="user_weight1" id="user_weight1">

                                                                        <option value="">All</option>

                                                                    <?php

                                                                    for($i=45;$i<=200;$i++)

                                                                    { ?>

                                                                        <option value="<?php echo $i;?>" <?php if($user_weight1 == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Kgs</option>

                                                                    <?php

                                                                    } ?>

                                                                    </select>

                                                                    &nbsp; - &nbsp;

                                                                    <select name="user_weight2" id="user_weight2">

                                                                        <option value="">All</option>

                                                                    <?php

                                                                    for($i=45;$i<=200;$i++)

                                                                    { ?>

                                                                        <option value="<?php echo $i;?>" <?php if($user_weight2 == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Kgs</option>

                                                                    <?php

                                                                    } ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td height="45" align="left" valign="top" class="Header_brown"><strong>User Age Range:</strong></td>

                                                                <td colspan="3" align="left" valign="top">

                                                                    <select name="userage1" id="userage1">

                                                                        <option value="">All</option>

                                                                    <?php

                                                                    for($i=18;$i<=100;$i++)

                                                                    { ?>

                                                                        <option value="<?php echo $i;?>" <?php if($user_age1 == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Years</option>

                                                                    <?php

                                                                    } ?>

                                                                    </select>

                                                                    &nbsp; - &nbsp;

                                                                    <select name="userage2" id="userage2">

                                                                        <option value="">All</option>

                                                                    <?php

                                                                    for($i=18;$i<=100;$i++)

                                                                    { ?>

                                                                        <option value="<?php echo $i;?>" <?php if($user_age2 == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Years</option>

                                                                    <?php

                                                                    } ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td height="45" align="left" valign="top" class="Header_brown"><strong>User BMI Range:</strong></td>

                                                                <td colspan="3" align="left" valign="top">

                                                                    <input type="text" name="user_bmi1" id="user_bmi1" value="<?php echo $user_bmi1;?>">

                                                                    &nbsp; - &nbsp;

                                                                    <input type="text" name="user_bmi2" id="user_bmi2" value="<?php echo $user_bmi2;?>">

                                                                </td>

                                                            </tr>
                                                                    <?php

                                                                    for($i=45;$i<=200;$i++)

                                                                    { ?>

                                                                        <option value="<?php echo $i;?>" <?php if($user_weight2 == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Kgs</option>

                                                                    <?php

                                                                    } ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                                                                        <tr>
                                                                <td >
                                                                    
                                                                   <button type="submit" name="btnSubmit"  class="myButton no-print"  style="margin-left: 8px;" onClick="addUserData();return false;"> &nbsp;Submit</button>
                                                                </td>
                                                                <td >
                                                                    <button type="button" onClick="hidepopup();return false;" class="myButton1 no-print"> &nbsp;Cancel</button>
       
                                                                </td>
                                                            </tr>
                                                           
                                                            <script>
                                                            
            
            function getMainCategoryOptionAddMore()
               {

                    var parent_cat_id = $("#fav_cat_type_id").val();
                    //var sub_cat = $("#fav_cat_id_"+idval).val();
                    //alert(parent_cat_id);
                    var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;
                    $.ajax({
                            type: "POST",
                            url: "include/remote.php",
                            data: dataString,
                            cache: false,
                            success: function(result)
                            {
                                    //alert(result);
                                    //alert(sub_cat);
                                    $("#fav_cat_id").html(result);
                            }
                    });
               }
  function addUserData()
          {

            var user_country_id=$('#user_country_id').val();
            var user_state_id=$('#user_state_id').val();
            var user_city_id=$('#user_city_id').val();

            var user_place_id=$('#user_place_id').val();
            var user_gender=$('#user_gender').val();
            var userage1=$('#userage1').val();
            var userage2=$('#userage2').val();
            
            
            var user_food_option=$('#user_food_option').val();
            var user_height1=$('#user_height1').val();
            var user_height2=$('#user_height2').val();
            var user_weight1=$('#user_weight1').val();
            var user_weight2=$('#user_weight2').val();
            var user_bmi1=$('#user_bmi1').val();
            var user_bmi2=$('#user_bmi2').val();
           
            var flag='2';

                        $('#country_id').val(user_country_id);
                        $('#state_id').val(user_state_id);
                        $('#city_id').val(user_city_id);
                        $('#place_id').val(user_place_id);
                        $('#gender').val(user_gender);
                        $('#flag').val(flag);
                        $('#user_age1').val(userage1);
                        $('#user_age2').val(userage2);
                        
                        $('#users_food_option').val(user_food_option);
                        $('#users_height1').val(user_height1);
                        $('#users_height2').val(user_height2);
                        $('#users_weight1').val(user_weight1);
                        $('#users_weight2').val(user_weight2);
                        $('#users_bmi1').val(user_bmi1);
                        $('#users_bmi2').val(user_bmi2);

                       $('.bootbox.modal').modal('hide');
 

          } 
  function hidepopup()
  {
      $('.bootbox.modal').modal('hide');
  }
                                                            </script>