<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj1 = new Daily_Meals();
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
$edit_action_id = '11';

$arr_fav_cat_type_id = array();
$arr_fav_cat_id = array();

if(!$obj1->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj1->chkValidActionPermission($admin_id,$edit_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}

$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$daily_core = $_POST['daily_core'];
        $meal_id = $_POST['hdnmeal_id'];
        $id = $_POST['id'];
	$page = $_POST['hdnpage'];
	$meal_item = strip_tags(trim($_POST['meal_item']));
	$meal_measure = strip_tags(trim($_POST['meal_measure']));
	$meal_ml = strip_tags(trim($_POST['meal_ml']));
	$weight = strip_tags(trim($_POST['weight']));
	$food_type = strip_tags(trim($_POST['food_type']));
	$food_veg_nonveg = strip_tags(trim($_POST['food_veg_nonveg']));
        
	$show_hide = $_POST['show_hide'];
        $uom = $_POST['uom'];
        
        $fav_cat_id = $_POST['fav_cat_id'];
        $content = strip_tags(trim($_POST['content']));
        $benefits = $_POST['benefits'];
        $posted_by = $_SESSION['admin_id'];
	if($meal_item == '')
	{
		$error = true;
		$err_msg .= 'Please enter food description ';
	}
	elseif($obj1->chkMealItemAlreadyExists_edit($meal_item,$meal_id))
	{
		$error = true;
		$err_msg .= 'This meal is already existed</div>';
	}

	if(!$error)
	{
//		if($obj1->updateDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine,$meal_id))
		if($obj1->updateDailyMeal($posted_by,$benefits,$daily_core,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$meal_id))
		{
                    $data=$obj1->updateDailyMealFavCat($show_hide,$uom,$fav_cat_id,$content,$id);
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=daily_meals&page='.$page.'&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
elseif(isset($_GET['id']))
{
	$id = $_GET['id'];
        $meal_id = $_GET['meal_id'];
        
	$page = $_GET['page'];
	list($benefits,$daily_core,$content,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$fav_cat_id,$show_hide,$uom,$id) = $obj1->getMealDetails($id);
       
	if($meal_item == '')
	{
		header('location: index.php?mode=daily_meals');	
	}	
}	
else
{
	header('location: index.php?mode=daily_meals');
}

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Daily Meal</td>
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
							<form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
							<input type="hidden" name="hdnmeal_id" id="hdnmeal_id" value="<?php echo $meal_id;?>" />
                                                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
							<input type="hidden" name="hdnpage" id="hdnpage" value="<?php echo $page;?>" />
                                                              <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                            <tr>
                                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                                            </tr>            
                                                             <tr>
                                                                <td width="10%" height="30" align="left" valign="middle"><strong>Food Code:</strong></td>
                                                                <td width="15%" height="30" align="left" valign="middle">
                                                                   <input name="daily_core" type="text" id="daily_core" value="<?php echo $daily_core; ?>" style="width:150px; height: 23px;">
                                                                </td> 
                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Food Description:</strong></td>
                                                                <td width="15%" height="30" align="left" valign="middle">
                                                                   <input name="meal_item" type="text" id="meal_item" value="<?php echo $meal_item; ?>" style="width:150px; height: 23px;">
                                                                </td>
                                                                 <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Benefits:</strong></td>
                                                                 <td width="15%" height="30" align="left" valign="middle">
                                                                    <textarea name="benefits" id="benefits"  style="width:150px; height: 23px;"><?php echo $benefits; ?></textarea>
                                                                 </td>
                                                            </tr>

                                                             <tr>
                                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                                            </tr>             
                                                            <tr>
                                                               
                                                                <td width="10%" height="30" align="left" valign="middle"><strong>Serving Size:</strong></td>
                                                                <td width="15%" height="30" align="left" valign="middle">
                                                                    <select name="meal_measure" id="meal_measure" style="width:150px; height: 23px;">
                                                                        <?php echo $obj->getFavCategoryRamakant('22',$meal_measure)?>
                                                                    </select>
                                                                </td>
                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volume:</strong></td>
                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                   <select name="meal_ml" id="meal_ml" style="width:150px; height: 23px;">
                                                                        <?php echo $obj->getFavCategoryRamakant('23',$meal_ml)?>
                                                                    </select>
                                                                </td>
                                                                 <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Weight(g):</strong></td>
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

                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Food Type:</strong></td>
                                                                <td width="15%" height="30" align="left" valign="middle">
                                                                    <select name="food_veg_nonveg" id="food_veg_nonveg" style="width:150px; height: 23px;">
                                                                        <?php echo $obj->getFavCategoryRamakant('25',$food_veg_nonveg)?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                                            </tr>
                                                            
                                                             <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                              <tr>
                                                                    <td width="15%" height="30" align="left" valign="middle"><strong>Food Composition:</strong></td>
                                                                    <td width="15%" height="30" align="left" valign="middle">
                                                                        <select name="fav_cat_id" id="fav_cat_id" style="width:150px; height: 23px;">
                                                                            
                                                                            <?php echo $obj->getFavCategoryRamakant('24',$fav_cat_id)?>
                                                                        </select>
                                                                    </td>
                                                                    
                                                                    <td width="15%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Content:</strong></td>
                                                                    <td width="15%" height="30" align="left" valign="middle">
                                                                        <input type="text" name="content" id="content" value="<?php echo $content;?>" style="width:150px; height: 23px;"/>
                                                                           
                                                                    </td>
                                                                    
                                                                    <td width="15%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UOM:</strong></td>
                                                                    <td width="15%" height="30" align="left" valign="middle">
                                                                        <select name="uom" id="uom" style="width:150px; height: 23px;">
                                                                            <?php echo $obj->getFavCategoryRamakant('23',$uom)?>
                                                                        </select>
                                                                    </td>
                                                                    
                                                                   
                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>
                                                                    <td width="10%" height="30" align="left" valign="middle">
                                                                        <select name="show_hide" id="show_hide" style="width:150px; height: 23px;" required="">
                                                                            <?php echo $obj->getShowHideOption($show_hide); ?>
                                                                        </select>
                                                                    </td>
                                                                    
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                   
 
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