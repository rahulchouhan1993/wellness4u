<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj1 = new Daily_Meals();

require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
$add_action_id = '288';

$cat_cnt = 0;
$cat_total_cnt = 1;

$uom = array();
$arr_fav_cat_id = array();
$arr_cucat_parent_cat_id = array('');
$arr_cucat_cat_id = array('');
$arr_cucat_show = array('');
$from_scale = array();
$to_scale = array();
$txt = array();

$prof_cat = array('');
$sub_cat1 = array();
$prof_cat2 = array();
$sub_cat2 = array();
//$prof_cat_values = array('');

$page_name = 'manage_scale';
list($prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value) = $obj1->getPageCatDropdownValue($page_name);

$value=0;
if($prof_cat1_value=='')
{
 $value=$value+1;
}
if($prof_cat2_value=='')
{
 $value=$value+1;
}
if($prof_cat3_value=='')
{
$value=$value+1;
}
if($prof_cat4_value=='')
{
$value=$value+1;
}
if($prof_cat5_value=='')
{
$value=$value+1;
}
if($prof_cat6_value=='')
{
$value=$value+1;
}
if($prof_cat7_value=='')
{
$value=$value+1;
}
if($prof_cat8_value=='')
{
$value=$value+1;
}
if($prof_cat9_value=='')
{
$value=$value+1;
}
if($prof_cat10_value=='')
{
 $value=$value+1;
}
$total_count = 10-$value;


$prof_cat1_value=  explode(',', $prof_cat1_value);
$prof_cat2_value=  explode(',', $prof_cat2_value);
$prof_cat3_value=  explode(',', $prof_cat3_value);
$prof_cat4_value=  explode(',', $prof_cat4_value);
$prof_cat5_value=  explode(',', $prof_cat5_value);
$prof_cat6_value=  explode(',', $prof_cat6_value);
$prof_cat7_value=  explode(',', $prof_cat7_value);
$prof_cat8_value=  explode(',', $prof_cat8_value);
$prof_cat9_value=  explode(',', $prof_cat9_value);
$prof_cat10_value=  explode(',', $prof_cat10_value);

$j=1;

$prof_cat_value[$j]=  implode('\',\'', $prof_cat1_value);
$prof_cat_value[$j+1]=  implode('\',\'', $prof_cat2_value);
$prof_cat_value[$j+2]=  implode('\',\'', $prof_cat3_value);
$prof_cat_value[$j+3]=  implode('\',\'', $prof_cat4_value);
$prof_cat_value[$j+4]=  implode('\',\'', $prof_cat5_value);
$prof_cat_value[$j+5]=  implode('\',\'', $prof_cat6_value);
$prof_cat_value[$j+6]=  implode('\',\'', $prof_cat7_value);
$prof_cat_value[$j+7]=  implode('\',\'', $prof_cat8_value);
$prof_cat_value[$j+8]=  implode('\',\'', $prof_cat9_value);
$prof_cat_value[$j+9]=  implode('\',\'', $prof_cat10_value);




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

$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$scale_code = strip_tags(trim($_POST['scale_code']));
	$prof_cat = $_POST['prof_cat'];
        $sub_cat = $_POST['sub_cat'];
        $from_range = strip_tags(trim($_POST['from_range']));
        $to_range = strip_tags(trim($_POST['to_range']));
	$comment = strip_tags(trim($_POST['comment']));
        
        $from_scale = $_POST['from_scale'];
        $to_scale = $_POST['to_scale'];
        $label_of_scale = $_POST['label_of_scale'];
        $cat_total_cnt = $_POST['cat_total_cnt'];
        $total_count = $_POST['total_count'];
        
	
	
//	elseif($obj1->chkMealItemAlreadyExists($meal_item))
//	{
//		$error = true;
//		$err_msg .= 'This meal is already existed</div>';
//	}

	if(!$error)
	{
//		if($obj1->addDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine))
		if($obj1->addScale($scale_code,$prof_cat,$sub_cat,$from_range,$to_range,$comment,$from_scale,$to_scale,$label_of_scale,$cat_total_cnt,$total_count))
                {
			$msg = "Record Added Successfully!";
			header('location: index.php?mode=manage_scale&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
$add_more_row_cat_str = '<tr id="row_cat_\'+cat_cnt+\'"><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>Scale From:&nbsp;&nbsp;</strong></td><td width="14%" height="30" align="left" valign="middle"><input type="text" name="from_scale[]" id="from_scale_\'+cat_cnt+\'" style="width:150px;height: 24px;"/></td><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>&nbsp;&nbsp;Scale To:</strong></td><td width="14%" height="30" align="left" valign="middle"><input type="text" name="to_scale[]" id="to_scale_\'+cat_cnt+\'" style="width:150px; height: 24px;"/></td><td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Label Of Scale:</strong></td><td width="15%" height="30" align="left" valign="middle"><input type="txt" name="label_of_scale[]" id="label_of_scale_\'+cat_cnt+\'" style="width:150px; height: 24px;"/></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Scale</td>
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
                                <form action="#" method="post" name="frmadd_scale_meal" id="frmadd_scale_meal" enctype="multipart/form-data" >
                                <input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
                                <input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>" >
                                <input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count;?>" >
                                
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                     <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Scale Code:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <input name="scale_code" type="text" id="scale_code" value="<?php echo $scale_code; ?>" style="width:150px; height: 24px;">
                                        </td>
                                       
                                    </tr>
                                    <?php for($i=0;$i<$total_count;$i++) {  ?>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                    <tr>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category<?php echo $i+1 ;?>:</strong></td>
                                        <td width="14%" height="30" align="right" valign="middle">
                                            <select  name="prof_cat[]" id="prof_cat<?php echo $i+1?>" onchange="getMainCategoryOptionAddMore(<?php echo $i+1?>)" style="width:150px; height: 24px;" >
                                                
                                                <?php echo $obj1->getMoreFavCategoryTypeOptions($prof_cat_value[$i+1]); ?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub &nbsp;&nbsp;&nbsp;&nbsp;Category<?php echo $i+1 ;?>:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select name="sub_cat[]" id="sub_cat<?php echo $i+1?>" style="width:150px; height: 24px;">
                                                <?php echo $obj1->getMoreFavCategoryRamakant($prof_cat_value[$i+1],$arr_cucat_cat_id[$i+1])?>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
<!--                                    <tr>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category2:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select  name="prof_cat2" id="prof_cat2" onchange="getMainCategoryOptionAddMore1()" style="width:150px; height: 24px;" >
                                                
                                                <?php echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub &nbsp;&nbsp;&nbsp;&nbsp;Category2:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                          <select name="sub_cat2" id="sub_cat2" style="width:150px; height: 24px;">
                                                <?php echo $obj->getFavCategoryRamakant($arr_cucat_parent_cat_id,$arr_cucat_cat_id)?>
                                          </select>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                     <tr>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category3:</strong></td>
                                        <td width="14%" height="30" align="right" valign="middle">
                                            <select  name="prof_cat3" id="prof_cat3" onchange="getMainCategoryOptionAddMore2()" style="width:150px; height: 24px;" >
                                                
                                                <?php echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub &nbsp;&nbsp;&nbsp;&nbsp;Category3:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select name="sub_cat3" id="sub_cat3" style="width:150px; height: 24px;">
                                                <?php echo $obj->getFavCategoryRamakant($arr_cucat_parent_cat_id,$arr_cucat_cat_id)?>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>-->
                                    <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Normal Range From:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <input name="from_range" type="text" id="from_range" value="<?php echo $from_range; ?>" style="width:150px; height: 24px;">
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;To:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                           <input name="to_range" type="text" id="to_range" value="<?php echo $to_range; ?>" style="width:150px; height: 24px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Comment:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                          <textarea name="comment" type="text" id="comment"  style="width:150px; height: 24px;" ><?php echo $comment; ?></textarea>
                                        </td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                     <?php
                                    for($i=0;$i<$cat_total_cnt;$i++)
                                    { ?>
                                    
                                    <tr id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">

                               
<!--                                        <td width="10%" height="30" align="left" valign="middle"><strong>Food Composition:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="fav_cat_id[]" id="fav_cat_id_<?php echo $i;?>" style="width:200px;">
                                               <?php echo $obj->getFavCategoryRamakant('24',$arr_cucat_cat_id[$i])?>
                                            </select>
                                        </td>-->
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Scale From:</strong></td>
                                       
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" name="from_scale[]" id="from_scale_<?php echo $i;?>" style="width:150px; height: 24px;">
                                                
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Scale To:</strong></td>
                                       
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" name="to_scale[]" id="to_scale_<?php echo $i;?>" style="width:150px; height: 24px;">
                                                
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Label Of Scale:</strong></td>
                                       
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" name="label_of_scale[]" id="label_of_scale_<?php echo $i;?>" style="width:150px; height: 24px;">
                                                
                                        </td>
                                        
                            
                                        <?php
                                            if($i == 0)
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="addMoreRowCategory();"><img src="images/add.gif" width="10" height="8" border="0" />Add More</a></td>
                                            <?php  	
                                            }
                                            else
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(<?php echo $i;?>);"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td>
                                                    
                                            <?php	
                                            }
                                            ?>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <?php  	
                                    } ?>
                                   
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
    
 function getMainCategoryOptionAddMore(num)
{
        
	var parent_cat_id = $("#prof_cat"+num).val();
       
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
			$("#sub_cat"+num).html(result);
		}
	});
}

//function getMainCategoryOptionAddMore1()
//{
//        
//	var parent_cat_id = $("#prof_cat2").val();
//        //var sub_cat = $("#fav_cat_id_"+idval).val();
//        //alert(parent_cat_id);
//	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;
//	$.ajax({
//		type: "POST",
//		url: "include/remote.php",
//		data: dataString,
//		cache: false,
//		success: function(result)
//		{
//			//alert(result);
//                        //alert(sub_cat);
//			$("#sub_cat2").html(result);
//		}
//	});
//}
//
//function getMainCategoryOptionAddMore2()
//{
//        
//	var parent_cat_id = $("#prof_cat3").val();
//        //var sub_cat = $("#fav_cat_id_"+idval).val();
//        //alert(parent_cat_id);
//	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;
//	$.ajax({
//		type: "POST",
//		url: "include/remote.php",
//		data: dataString,
//		cache: false,
//		success: function(result)
//		{
//			//alert(result);
//                        //alert(sub_cat);
//			$("#sub_cat3").html(result);
//		}
//	});
//}

</script>
      </div>