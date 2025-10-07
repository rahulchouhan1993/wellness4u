<?php

require_once('config/class.mysql.php');

require_once('classes/class.dailymeals.php');

$obj1 = new Daily_Meals();

require_once('classes/class.scrollingwindows.php');

$obj = new Scrolling_Windows();

$edit_action_id = '11';



$arr_fav_cat_type_id = array();

$arr_fav_cat_id = array();

$cat_cnt = 0;

$cat_total_cnt = 0;

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
   
	$page = $_POST['hdnpage'];

	$meal_item = strip_tags(trim($_POST['meal_item']));

	$meal_measure = strip_tags(trim($_POST['meal_measure']));

	$meal_ml = strip_tags(trim($_POST['meal_ml']));

	$weight = strip_tags(trim($_POST['weight']));

	//$food_type = strip_tags(trim($_POST['food_type']));

	// add by ample 02-12-19
	$status = $_POST['status'];

    $arr_selected_cat_id = array();
    foreach ($_POST['selected_cat_id1'] as $key => $value) 

    {

        array_push($arr_selected_cat_id,$value);

    }


	$food_veg_nonveg = strip_tags(trim($_POST['food_veg_nonveg']));
        
	//$id = $_POST['id'];
	//added by ample 29-11-19
	$show_hide = $_POST['show_hide'];
    $uom = $_POST['uom'];
    $fav_cat_id = $_POST['fav_cat_id'];
    $content = $_POST['content'];
    $cat_total_cnt = $_POST['cat_total_cnt'];

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

		// add by ample 02-12-19
        $food_type = implode(',',$arr_selected_cat_id);

//		if($obj1->updateDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine,$meal_id))

		if($obj1->updateDailyMeal($posted_by,$benefits,$daily_core,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$meal_id,$status))

		{
			//added by ample 29-11-19
				if($cat_total_cnt>0)
				{

                    $data=$obj1->insertDailyMealFavCat($show_hide,$uom,$fav_cat_id,$content,$meal_id,$cat_total_cnt,$posted_by);
				}

			$msg = "Record Updated Successfully!";

			header('location: index.php?mode=daily_meals&page='.$page.'&msg='.urlencode($msg));

		}

		else

		{	//added by ample 29-11-19

			if($cat_total_cnt>0)
				{

                    if($obj1->insertDailyMealFavCat($show_hide,$uom,$fav_cat_id,$content,$meal_id,$cat_total_cnt,$posted_by))
                    {
                    	 $msg = "Record Updated Successfully!";

						header('location: index.php?mode=daily_meals&page='.$page.'&msg='.urlencode($msg));
                    }
                   
				}

			


			$error = true;

			//$err_msg = "Currently there is some problem.Please try again later.";

			$err_msg = "You have not made any changes.";

		}

	}

}

//added by ample 29-11-19
if(isset($_POST['btnSave']))

{

    $meal_id = $_POST['hdnmeal_id'];
	$page = $_POST['hdnpage'];
	$id = $_POST['id'];
	$show_hide = $_POST['show_hide'];
    $uom = $_POST['uom'];
    $fav_cat_id = $_POST['fav_cat_id'];
    $content = strip_tags(trim($_POST['content']));

    $modified_by = $_SESSION['admin_id'];

	if(!$error)

	{


		if($obj1->updateDailyMealFavCat($show_hide,$uom,$fav_cat_id,$content,$id,$modified_by))
		{

			$msg = "Meals Composition Updated Successfully!";

			//header('location: index.php?mode=daily_meals&page='.$page.'&msg='.urlencode($msg));

		}

		else

		{

			$error = true;

			//$err_msg = "Currently there is some problem.Please try again later.";

			$err_msg = "You have not made any changes.";

		}

	}

}
// update by ample 29-11-19
if(isset($_GET['meal_id']))

{

	//$id = $_GET['id'];

    $meal_id = $_GET['meal_id'];

        

	$page = $_GET['page'];

	// list($benefits,$daily_core,$content,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$fav_cat_id,$show_hide,$uom,$id) = $obj1->getMealDetails($id);

	$meal_info=$obj1->getMealInfo($meal_id);

	if(!empty($meal_info))
	{
		$food_info=$obj1->compositionInfo($meal_id);
	}

	// echo "<pre>";

	// print_r($meal_info);

	// print_r($composition_info);

	// die();
       

	if(empty($meal_info))

	{

		header('location: index.php?mode=daily_meals');	

	}	

}	

else

{

	header('location: index.php?mode=daily_meals');

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
	else
	{
		if(isset($msg) && !empty($msg))
		{
			echo $msg;
		}
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

							<!-- update by ample 29-11-19-->

							<form action="" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >

							<input type="hidden" name="hdnmeal_id" id="hdnmeal_id" value="<?php echo $meal_id;?>" />

                                                        <!-- <input type="hidden" name="id" id="id" value="<?php echo $id;?>" /> -->

                               		<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

									<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>" >

							<input type="hidden" name="hdnpage" id="hdnpage" value="<?php echo $page;?>" />

                                                              <table border="0" width="100%" cellpadding="0" cellspacing="0">

                                                                    <tbody>

                                                            <tr>

                                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                                            </tr>            

                                                             <tr>

                                                                <td width="10%" height="30" align="left" valign="middle"><strong>Food Code:</strong></td>

                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                   <input name="daily_core" type="text" id="daily_core" value="<?php echo $meal_info['daily_core']; ?>" style="width:150px; height: 23px;">

                                                                </td> 

                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Food Description:</strong></td>

                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                   <input name="meal_item" type="text" id="meal_item" value="<?php echo $meal_info['meal_item']; ?>" style="width:150px; height: 23px;">

                                                                </td>

                                                                 <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Benefits:</strong></td>

                                                                 <td width="15%" height="30" align="left" valign="middle">

                                                                    <textarea name="benefits" id="benefits"  style="width:150px; height: 23px;"><?php echo $meal_info['benefits']; ?></textarea>

                                                                 </td>

                                                            </tr>



                                                             <tr>

                                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                                            </tr>             

                                                            <tr>

                                                               

                                                                <td width="10%" height="30" align="left" valign="middle"><strong>Serving Size:</strong></td>

                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                    <select name="meal_measure" id="meal_measure" style="width:150px; height: 23px;">

                                                                        <?php echo $obj->getFavCategoryRamakant('22',$meal_info['meal_measure'])?>

                                                                    </select>

                                                                </td>

                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volume:</strong></td>

                                                                <td width="15%" height="30" align="left" valign="middle">



                                                                   <select name="meal_ml" id="meal_ml" style="width:150px; height: 23px;">

                                                                        <?php echo $obj->getFavCategoryRamakant('23',$meal_info['meal_ml'])?>

                                                                    </select>

                                                                </td>

                                                                 <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Weight(g):</strong></td>

                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                    <input name="weight" type="text" id="weight" value="<?php echo $meal_info['weight']; ?>" style="width:150px; height: 23px;">

                                                                </td>



                                                            </tr>

                                                            <tr>

                                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                                            </tr>



                                                            <tr>



                                                                <td width="10%" height="30" align="left" valign="middle"><strong>Ingredient Type:</strong></td>

                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                    <!-- <select name="food_type" id="food_type" style="width:150px; height: 23px;">

                                                                        <?php echo $obj->getFavCategoryRamakant('26',$meal_info['food_type'])?>

                                                                    </select> -->

                                                                    <?php 
                                                                    $food_type=explode(',', $meal_info['food_type']);

                                                                    echo $obj->getAllCategoryChkeckbox('26',$food_type,'','','300','200'); 
                                                                    ?>

                                                                </td>



                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Food Type:</strong></td>

                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                    <select name="food_veg_nonveg" id="food_veg_nonveg" style="width:150px; height: 23px;">

                                                                        <?php echo $obj->getFavCategoryRamakant('25',$meal_info['food_veg_nonveg'])?>

                                                                    </select>

                                                                </td>

                                                                 <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status:</strong>  </td>

                                                                   <td width="15%" height="30" align="left" valign="middle">

                                                                   	<select name="status" id="status" style="width:150px; height: 23px;">
						                                                <option value="1" <?=($meal_info['status']=='1')? 'selected' : ''; ?> >Active</option>
						                                                <option value="0" <?=($meal_info['status']=='0')? 'selected' : ''; ?> >Inactive</option>
						                                            </select>
						                                           	&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                                                   	<a href="javascript:void(0);" onclick="addMoreRowCategory();"><img src="images/add.gif" width="10" height="8" border="0" />Add &nbsp;&nbsp;New food Composition</a>

                                                                   </td>

                                                            </tr>

                                                             <tr id="row_cat_first">

                                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="8" height="30" align="left" valign="middle" style="text-align: center;">&nbsp;<input type="Submit" name="btnSubmit" value="Submit" /></td>

                                                            </tr>


                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>


                                </tbody>

                                                              </table>    

                                                        </form>

						</td>

					</tr>

				</tbody>

				</table>
				<!-- added by ample 29-11-19-->
		<?php 
		if(!empty($food_info))
		{
			foreach ($food_info as $key => $food) {
				?>
					<!-- food comosition-->			
					<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
						<tbody>
							<tr>
								<td class="mainbox-body">
									<form action="" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
									<input type="hidden" name="hdnmeal_id" id="hdnmeal_id" value="<?php echo $meal_id;?>" />
									<input type="hidden" name="hdnpage" id="hdnpage" value="<?php echo $page;?>" />
									<input type="hidden" name="id" id="id" value="<?php echo $food['id'];?>" />
		                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
		                                <tbody>
		                                    <tr>
		                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
		                                    </tr>            
		                              		<tr>
		                                        <td width="10%" height="30" align="left" valign="middle"><strong>Food Composition:</strong></td>
		                                        <td width="10%" height="30" align="left" valign="middle">
		                                            <select name="fav_cat_id" id="fav_cat_id" style="width:150px; height: 23px;">
		                                                <?php echo $obj->getFavCategoryRamakant('24',$food['fav_cat_id'])?>
		                                            </select>
		                                        </td>
		                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Content:</strong></td>
		                                        <td width="10%" height="30" align="left" valign="middle">
		                                            <input type="text" name="content" id="content" value="<?php echo $food['content'];?>" style="width:150px; height: 23px;"/>
		                                        </td>
		                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UOM:</strong></td>
		                                        <td width="10%" height="30" align="left" valign="middle">
		                                            <select name="uom" id="uom" style="width:150px; height: 23px;">
		                                                <?php echo $obj->getFavCategoryRamakant('23',$food['uom'])?>
		                                            </select>
		                                        </td>
		                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>
		                                        <td width="10%" height="30" align="left" valign="middle">
		                                            <select name="show_hide" id="show_hide" style="width:150px; height: 23px;" required="">
		                                                <?php echo $obj->getShowHideOption($food['show_hide']); ?>
		                                            </select>
		                                        </td>
		                                        <td width="10%" height="30" align="left" valign="middle">&nbsp;&nbsp;&nbsp;<input type="submit" name="btnSave" value="save" /></td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
		                                    </tr>
		                                </tbody>
		                            </table>    
		                        </form>
							</td>
						</tr>
					</tbody>
				</table>
				<?php
			}
		}
		?>
	
			


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

    

</script>
</div>