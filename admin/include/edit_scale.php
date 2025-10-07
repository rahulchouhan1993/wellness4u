<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj1 = new Daily_Meals();
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
$edit_action_id = '11';

$arr_fav_cat_type_id = array();
$arr_fav_cat_id = array();

// if(isset($_REQUEST['action']) && $_REQUEST['action'] =='addData')
//    {
//     $count_prof_cat_data=isset($_REQUEST['count_prof_cat_data'])&&$_REQUEST['count_prof_cat_data']!='' ? $_REQUEST['count_prof_cat_data'] : '';
//     $total_count=isset($_REQUEST['total_count'])&&$_REQUEST['total_count']!='' ? $_REQUEST['total_count'] : '';
//      
//       $scale_prof_cat_id_data= $total_count-$count_prof_cat_data;
//        
//        for($m=0;$i<$scale_prof_cat_id_data;$m++)
//        {
//        $scale_prof_cat_id_data=$obj1->addScaleProfCatData($scale_id);
//        }
//      
//    }
       
   
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

if(!$obj1->chkValidActionPermission($admin_id,$edit_action_id))
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
        $id = $_POST['id'];
        $scale_id = $_POST['scale_id'];
        $count_prof_cat_data = $_POST['count_prof_cat_data'];
        $scale_prof_cat_id = $_POST['scale_prof_cat_id'];
        
        
       
//	if($prof_cat1 == '')
//	{
//		$error = true;
//		$err_msg .= 'Please enter Profile Category1';
//	}
//        if($sub_cat1 == '')
//	{
//		$error = true;
//		$err_msg .= 'Please enter Sub Category1';
//	}
//	elseif($obj1->chkMealItemAlreadyExists_edit($meal_item,$meal_id))
//	{
//		$error = true;
//		$err_msg .= 'This meal is already existed</div>';
//	}

	if(!$error)
	{
//		if($obj1->updateDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine,$meal_id))
		if($obj1->updateScale($scale_code,$from_range,$to_range,$comment,$scale_id))
		{
                    $addmorescaledata=$obj1->updateScaleAddMore($from_scale,$to_scale,$label_of_scale,$id);
                    $prof_cat_data=$obj1->updateScaleProfCat($prof_cat,$sub_cat,$scale_prof_cat_id,$total_count);
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=manage_scale&page='.$page.'&msg='.urlencode($msg));
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
        
        
	$page = $_GET['page'];
	list($scale_code,$from_range,$to_range,$comment,$from_scale,$to_scale,$label_of_scale,$scale_id) = $obj1->getScaleDetails($id);
//        list($dataadd) = $obj1->getScalePrfoCatDetails1($scale_id);
//        
//          $count_prof_cat_data=count($dataadd);
//         
//          echo $scale_prof_cat_id_data= $total_count-$count_prof_cat_data;
//        
//        for($m=0;$m<=count($scale_prof_cat_id_data);$m++)
//        {
//            echo '1';
//        $scale_prof_cat_id_data=$obj1->addScaleProfCatData($scale_id);
//        }die();
       list($data) = $obj1->getScalePrfoCatDetails($scale_id);
        
        
        

}	
else
{
	header('location: index.php?mode=manage_scale');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Scale</td>
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
							<form action="#" method="post" name="frmedit_scale" id="frmedit_scale" enctype="multipart/form-data" >
							<input type="hidden" name="scale_id" id="scale_id" value="<?php echo $scale_id;?>" />
                                                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                                                        <input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count;?>" >
                                                        <input type="hidden" name="count_prof_cat_data" id="count_prof_cat_data" value="<?php echo $count_prof_cat_data;?>" >
                                
							<input type="hidden" name="hdnpage" id="hdnpage" value="<?php echo $page;?>" />
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
                                                
                                                <?php echo $obj1->getMoreFavCategoryTypeOptions($prof_cat_value[$i+1],$data[$i]['prof_cat']); ?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub &nbsp;&nbsp;&nbsp;&nbsp;Category<?php echo $i+1 ;?>:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select name="sub_cat[]" id="sub_cat<?php echo $i+1?>" style="width:150px; height: 24px;">
                                                <?php echo $obj1->getMoreFavCategoryRamakant($prof_cat_value[$i+1],$data[$i]['sub_cat'])?>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <?php }?>

                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Normal Range From:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <input name="from_range" type="text" id="from_range" value="<?php echo $from_range; ?>" style="width:150px;height: 24px;">
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;To:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                           <input name="to_range" type="text" id="to_range" value="<?php echo $to_range; ?>" style="width:150px;height: 24px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Comment:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                          <textarea name="comment" type="text" id="comment"  style="width:150px; height: 24px;"><?php echo $comment; ?></textarea>
                                        </td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>                        
                                                            
                                    <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Scale From:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <input name="from_scale" type="text" id="from_scale" value="<?php echo $from_scale; ?>" style="width:150px; height: 24px;">
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Scale To:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                           <input name="to_scale" type="text" id="to_scale" value="<?php echo $to_scale; ?>" style="width:150px; height: 24px;">
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp; Label Of Scale:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                           <input name="label_of_scale" type="text" id="label_of_scale" value="<?php echo $label_of_scale; ?>" style="width:150px; height: 24px;">
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
   
    
//function getMainCategoryOptionAddMore()
//{
//        
//	var parent_cat_id = $("#prof_cat1").val();
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
//			$("#sub_cat1").html(result);
//		}
//	});
//}
//
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

//function addAllDropdown()
//{
//        
//	var total_count = $("#total_count").val();
//       var count_prof_cat_data = $("#count_prof_cat_data").val();
//       alert(count_prof_cat_data);
//	var dataString = 'action=addData&total_count='+total_count+'&count_prof_cat_data='+count_prof_cat_data;
//	$.ajax({
//		type: "POST",
//		url: "include/remote.php",
//		data: dataString,
//		cache: false,
//		success: function(result)
//		{
//			alert(result);
//                        //alert(sub_cat);
////			$("#sub_cat"+num).html(result);
//		}
//	});
//}

 function getMainCategoryOptionAddMore(num)
{
//        addAllDropdown();
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

</script>
</div>