<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj1 = new Daily_Meals();

require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
$add_action_id = '10';

$cat_cnt = 0;
$cat_total_cnt = 1;

$uom = array();
$arr_fav_cat_id = array();
$arr_cucat_parent_cat_id = array('');
$arr_cucat_cat_id = array('');
$arr_cucat_show = array('');
$show_hide = array();

if(!$obj1->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj1->chkValidActionPermission($admin_id,$add_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}

//print_r($_SESSION);        
        
$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$meal_item = strip_tags(trim($_POST['meal_item']));
	$daily_core = strip_tags(trim($_POST['daily_core']));
        $meal_measure = strip_tags(trim($_POST['meal_measure']));
	$meal_ml = strip_tags(trim($_POST['meal_ml']));
	$weight = $_POST['weight'];
	$food_type = strip_tags(trim($_POST['food_type']));
	$food_veg_nonveg = strip_tags(trim($_POST['food_veg_nonveg']));
        
        $show_hide = $_POST['show_hide'];
        $uom = $_POST['uom'];
        $fav_cat_id = $_POST['fav_cat_id'];
        $cat_total_cnt = $_POST['cat_total_cnt'];
        $content = $_POST['content'];
        $benefits = $_POST['benefits'];
	$posted_by = $_SESSION['admin_id'];
	if($meal_item == '')
	{
		$error = true;
		$err_msg .= 'Please enter food description ';
	}
	elseif($obj1->chkMealItemAlreadyExists($meal_item))
	{
		$error = true;
		$err_msg .= 'This meal is already existed</div>';
	}

	if(!$error)
	{
//		if($obj1->addDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine))
		if($obj1->addDailyMeal($posted_by,$benefits,$daily_core,$content,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$show_hide,$uom,$fav_cat_id,$cat_total_cnt))
                {
			$msg = "Record Added Successfully!";
			header('location: index.php?mode=daily_meals&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
$add_more_row_cat_str = '<tr id="row_cat_\'+cat_cnt+\'"><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>Food Composition:</strong></td><td width="14%" height="30" align="left" valign="middle"><select name="fav_cat_id[]" id="fav_cat_id_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj->getFavCategoryRamakant('24','').'</select></td><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>&nbsp;&nbsp;Content:</strong></td><td width="14%" height="30" align="left" valign="middle"><input type="text" name="content[]" id="content_\'+cat_cnt+\'" style="width:150px; height: 23px;"/></td><td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UOM:</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="uom[]" id="uom_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj->getFavCategoryRamakant('23','').'</select></td><td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="show_hide[]" id="show_hide_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj->getShowHideOption('').'</select></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';

?>
<div id="central_part_contents">
	<div id="notification_contents">
	<?php
	if($error)
	{
	?>
		<table class="notification-border-e" id="notification" align="center" border="0" width="97%" cellpadding="1" cellspacing="1">
		<tbody>
			<tr>
				<td class="notification-body-e">
					<table border="0" width="100%" cellpadding="0" cellspacing="6">
					<tbody>
						<tr>
							<td><img src="images/notification_icon_e.gif" alt="" border="0" width="12" height="10"></td>
							<td width="100%">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td class="notification-title-E">Error</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="notification-body-e"><?php echo $err_msg; ?></td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
	<?php
	}
	?>
<!--notification_contents-->
	</div>	
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Daily Meal</td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
                                    
				<tbody>
					<tr>
						<td class="mainbox-body">
							<p class="err_msg"><?php if(isset($_GET['msg']) && $_GET['msg'] != '' ) { echo urldecode($_GET['msg']); }?></p>
							<div id="pagination_contents" align="center"> 
								<p>
                                <form action="#" method="post" name="frmadd_daily_meal" id="frmadd_daily_meal" enctype="multipart/form-data" >
                                <input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
				<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>" >
                                
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    
                                    <tr>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Food Code:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                           <input name="daily_core" type="text" id="daily_core" value="<?php echo $daily_core; ?>" style="width:150px; height: 23px;">
                                        </td> 
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;Food Description:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                           <input name="meal_item" type="text" id="meal_item" value="<?php echo $meal_item; ?>" style="width:150px; height: 23px;">
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Benefits:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <textarea name="benefits" id="benefits"  style="width:150px; height: 23px;"><?php echo $benefits; ?></textarea>
                                        </td>
                                    </tr>
                                    
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Serving Size:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="meal_measure" id="meal_measure" style="width:150px; height: 23px;">
                                                <?php echo $obj->getFavCategoryRamakant('22',$meal_measure)?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Volume:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                           
                                           <select name="meal_ml" id="meal_ml" style="width:150px; height: 23px;">
                                                <?php echo $obj->getFavCategoryRamakant('23',$meal_ml)?>
                                            </select>
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Weight(g):</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input name="weight" type="text" id="weight" value="<?php echo $weight; ?>" style="width:150px; height: 23px;">
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                       
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Ingredient Type:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="food_type" id="food_type" style="width:150px; height: 23px;">
                                                <?php echo $obj->getFavCategoryRamakant('26',$food_type)?>
                                            </select>
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Food Type:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="food_veg_nonveg" id="food_veg_nonveg" style="width:150px; height: 23px;">
                                                <?php echo $obj->getFavCategoryRamakant('25',$food_veg_nonveg)?>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                     <?php
                                    for($i=0;$i<$cat_total_cnt;$i++)
                                    { ?>
                                    
                                    <tr id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
                               
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Food Composition:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="fav_cat_id[]" id="fav_cat_id_<?php echo $i;?>" style="width:150px; height: 23px;">
                                               <?php echo $obj->getFavCategoryRamakant('24',$arr_cucat_cat_id[$i])?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Content:</strong></td>
                                       
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" name="content[]" id="content_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UOM:</strong></td>
                                       
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="uom[]" id="uom_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                <?php echo $obj->getFavCategoryRamakant('23',$fav_cat_id)?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="show_hide[]" id="show_hide_<?php echo $i;?>" style="width:150px; height: 23px;" >
                                                <?php echo $obj->getShowHideOption($arr_cucat_show[$i]); ?>
                                            </select>
                                        </td>
                                        
                                       <td >
                                        <?php
                                            if($i == 0)
                                            { ?>
                                                    <td><a href="javascript:void(0);" onclick="addMoreRowCategory();"><img src="images/add.gif" width="10" height="8" border="0" />Add &nbsp;&nbsp;More</a></td>
                                            <?php  	
                                            }
                                            else
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(<?php echo $i;?>);"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td>
                                                    
                                            <?php	
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <?php  	
                                    } ?>
                                   
<!--                                     <?php
                                    for($i=0;$i<$cat_total_cnt_symptom;$i++)
                                    { ?>
                                    
                                    <tr id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
                               
                                       
                                       
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UOM:</strong></td>
                                       
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="uom[]" id="uom_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                <?php echo $obj->getFavCategoryRamakant('23',$fav_cat_id)?>
                                            </select>
                                        </td>
                                       
                                        
                                       <td >
                                        <?php
                                            if($i == 0)
                                            { ?>
                                                    <td><a href="javascript:void(0);" onclick="addMoreRowCategory();"><img src="images/add.gif" width="10" height="8" border="0" />Add &nbsp;&nbsp;More</a></td>
                                            <?php  	
                                            }
                                            else
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(<?php echo $i;?>);"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td>
                                                    
                                            <?php	
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <?php  	
                                    } ?>
                                   -->
                                    <tr>
                                   <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
				    
                                    <td align="left" valign="top"><input type="Submit" name="btnSubmit" value="Submit" /></td>
                                    </tr>
                                </tbody>
                                </table>
                                </form>
                                        </td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
	</tbody>
	</table>
	<br>
        <script>
    function addMoreRowCategory()
    {
            var cat_cnt = parseInt($("#cat_cnt").val());
            cat_cnt = cat_cnt + 1;
            //alert("cat_cnt"+cat_cnt);
            $("#row_cat_first").after('<?php echo $add_more_row_cat_str;?>');
            $("#cat_cnt").val(cat_cnt);

            var cat_total_cnt = parseInt($("#cat_total_cnt").val());
            cat_total_cnt = cat_total_cnt + 1;
            $("#cat_total_cnt").val(cat_total_cnt);
    }
    
    function removeRowCategory(idval)
    {
            //alert("row_cat_"+idval);
            $("#row_cat_"+idval).remove();

            var cat_total_cnt = parseInt($("#cat_total_cnt").val());
            cat_total_cnt = cat_total_cnt - 1;
            $("#cat_total_cnt").val(cat_total_cnt);
    }
    
//    function addMoreRowCategorySymptom()
//    {
//            var cat_cnt = parseInt($("#cat_cnt").val());
//            cat_cnt = cat_cnt + 1;
//            //alert("cat_cnt"+cat_cnt);
//            $("#row_cat_first").after('<?php echo $add_more_row_cat_str;?>');
//            $("#cat_cnt").val(cat_cnt);
//
//            var cat_total_cnt = parseInt($("#cat_total_cnt").val());
//            cat_total_cnt = cat_total_cnt + 1;
//            $("#cat_total_cnt").val(cat_total_cnt);
//    }
//    
//    function removeRowCategorySymptom(idval)
//    {
//            //alert("row_cat_"+idval);
//            $("#row_cat_"+idval).remove();
//
//            var cat_total_cnt = parseInt($("#cat_total_cnt").val());
//            cat_total_cnt = cat_total_cnt - 1;
//            $("#cat_total_cnt").val(cat_total_cnt);
//    }
    
 function getMainCategoryOptionAddMore(idval)
{
        
	var parent_cat_id = $("#fav_cat_type_id_"+idval).val();
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
			$("#fav_cat_id_"+idval).html(result);
		}
	});
}
    
</script>
      </div>