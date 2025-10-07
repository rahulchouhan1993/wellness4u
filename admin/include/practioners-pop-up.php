<?php 
require_once('../config/class.mysql.php');

require_once('../classes/class.places.php');


require_once('../classes/class.profilecustomization.php');  
$obj3 = new ProfileCustomization();

$obj2 = new Places();

 $pro_user_gender = '';

    $pro_user_service = '';

    $pro_user_age1 = '';

    $pro_user_age2 = '';
    
    $pro_user_service = '';

   
?>                                              

                                                                
                                     <tr>

                                                                <td height="100" align="left" valign="top"><strong>Country:</strong></td>

                                                                <td align="left" valign="top">

                                                                    <select name="pro_user_country_id" id="pro_user_country_id" onchange="getStateOptionsMultiCMN('pro_user');" style="width:200px;">

                                                                        <option value="" >All Country</option>

                                                                        <?php echo $obj2->getCountryOptions($pro_user_country_id); ?>

                                                                    </select>

                                                                </td>

                                                                <td height="100" align="left" valign="top" class="Header_brown"><strong>State:</strong></td>

                                                                <td align="left" valign="top" id="tdstate_pro_user">

                                                                    <select multiple="multiple" name="pro_user_state_id[]" id="pro_user_state_id" onchange="getCityOptionsMultiCMN('pro_user');" style="width:200px;">

                                                                        <option value="" <?php if (in_array('', $arr_pro_user_state_id)) {?> selected="selected" <?php } ?>>All States</option>

                                                                        <?php echo $obj2->getStateOptionsMulti($pro_user_country_id,$arr_pro_user_state_id); ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td height="100" align="left" valign="top"><strong>City:</strong></td>

                                                                <td align="left" valign="top" id="tdcity_pro_user">

                                                                    <select multiple="multiple" name="pro_user_city_id[]" id="pro_user_city_id" onchange="getPlaceOptionsMultiCMN('pro_user');" style="width:200px;">

                                                                        <option value="" <?php if (in_array('', $arr_pro_user_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>

                                                                        <?php echo $obj2->getCityOptionsMulti($pro_user_country_id,$arr_pro_user_state_id,$arr_pro_user_city_id); ?>

                                                                    </select>

                                                                </td>

                                                                <td height="100" align="left" valign="top" class="Header_brown"><strong>Place:</strong></td>

                                                                <td align="left" valign="top" id="tdplace_pro_user">

                                                                    <select multiple="multiple" name="pro_user_place_id[]" id="pro_user_place_id" style="width:200px;">

                                                                        <option value="" <?php if (in_array('', $arr_pro_user_place_id)) {?> selected="selected" <?php } ?>>All Places</option>

                                                                        <?php echo $obj2->getPlaceOptionsMulti($pro_user_country_id,$arr_pro_user_state_id,$arr_pro_user_city_id,$arr_pro_user_place_id); ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td width="150" height="45" align="left" valign="top"><strong>Gender:</strong></td>

                                                                <td width="230" align="left" valign="top">

                                                                    <select name="pro_user_gender" id="pro_user_gender">

                                                                        <option value="">All Gender</option>

                                                                        <option value="Male" <?php if($pro_user_gender == 'Male') {?> selected <?php } ?> >Male</option>

                                                                        <option value="Female" <?php if($pro_user_gender == 'Female') {?> selected <?php } ?> >Female</option>

                                                                    </select>

                                                                </td>

                                                                <td width="170" height="45" align="left" valign="top"><strong>Specialities - Services Rendered:</strong></td>

                                                                <td width="250" align="left" valign="top">

                                                                    <select name="pro_user_service" id="pro_user_service" style="width:200px;">

                                                                        <option value="2">All</option>

                                                                        <?php echo $obj3->getAllProUserServicesOptions($pro_user_service); ?>

                                                                    </select>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td height="45" align="left" valign="top" class="Header_brown"><strong>Age Range:</strong></td>

                                                                <td colspan="3" align="left" valign="top">

                                                                    <select name="pro_user_age1" id="pro_user_age1">

                                                                        <option value="1">All</option>

                                                                    <?php

                                                                    for($i=18;$i<=100;$i++)

                                                                    { ?>

                                                                        <option value="<?php echo $i;?>" <?php if($pro_user_age1 == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Years</option>

                                                                    <?php

                                                                    } ?>

                                                                    </select>

                                                                    &nbsp; - &nbsp;

                                                                    <select name="pro_user_age2" id="pro_user_age2">

                                                                        <option value="1">All</option>

                                                                    <?php

                                                                    for($j=18;$j<=100;$j++)

                                                                    { ?>

                                                                        <option value="<?php echo $j;?>" <?php if($pro_user_age2 == $j) { echo "selected" ; } ?>><?php echo $j;?> Years</option>

                                                                    <?php

                                                                    } ?>

                                                                    </select>

                                                                </td>

                                                            </tr>
                                                            
                                                            <tr>
                                                                <td >
                                                                    
                                                                   <button type="submit" name="btnSubmit"  class="myButton no-print"  style="margin-left: 8px;" onClick="addCashData();return false;"> &nbsp;Submit</button>
                                                                </td>
                                                                <td >
                                                                    <button type="button" onClick="hidepopup();return false;" class="myButton1 no-print"> &nbsp;Cancel</button>
       
                                                                </td>
                                                            </tr> </div>
                                                           
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
               
                 function addCashData()
          {

            var pro_user_country_id=$('#pro_user_country_id').val();
            var pro_user_state_id=$('#pro_user_state_id').val();
            var pro_user_city_id=$('#pro_user_city_id').val();

            var pro_user_place_id=$('#pro_user_place_id').val();
            var pro_user_gender=$('#pro_user_gender').val();
            var pro_user_service=$('#pro_user_service').val();
            var pro_user_age1=$('#pro_user_age1').val();
          
            var pro_user_age2=$('#pro_user_age2').val();
           
            var flag='1';

                        $('#country_id').val(pro_user_country_id);
                        $('#state_id').val(pro_user_state_id);
                        $('#city_id').val(pro_user_city_id);
                        $('#place_id').val(pro_user_place_id);
                        $('#gender').val(pro_user_gender);
                        $('#flag').val(flag);
                        $('#user_service').val(pro_user_service);
                        $('#user_age1').val(pro_user_age1);
                         $('#user_age2').val(pro_user_age2);

                       $('.bootbox.modal').modal('hide');
 

          } 
  function hidepopup()
  {
      $('.bootbox.modal').modal('hide');
  }
                                                            </script>