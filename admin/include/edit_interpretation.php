<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
require_once('classes/class.generalstressors.php');
require_once('classes/class.scrollingwindows.php');


$obj = new Scrolling_Windows();
$obj1 = new Daily_Meals();

$obj2 = new General_Stressors();
//$data = $obj2->getProUsersOptionsSearch($referred_from);
//
//$tdata='"'.implode('","',$data).'"';
//
//$data1 = $obj2->getPersonUsersOptionsSerch($referred_by);
//
//$tdata1='"'.implode('","',$data1).'"';
//
//$edit_action_id = '299';
//
//$data2 = $obj->getInterpretationAddOption('71');
//
//$tdata2='"'.implode('","',$data2).'"';




$arr_fav_cat_type_id = array();
$arr_fav_cat_id = array();

  

$page_name = 'assign_interpretation';
list($header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value) = $obj1->getPageCatDropdownValue($page_name);

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
        
	$interpretation_id = $_POST['interpretation_id'];
	$id = $_POST['id'];
        $lab=$_POST['lab'];
        $healcareandwellbeing=$_POST['healcareandwellbeing'];
        $adviser=$_POST['adviser'];
        $interpretation_code=$_POST['interpretation_code'];
     
        $interpretation_no=$_POST['interpretation_no'];
        $prof_cat = $_POST['prof_cat'];
        $sub_cat = $_POST['sub_cat'];
        
        
        $interpretation_criteria = implode(',',$_POST['interpretation_criteria']);
       
	$scale_form = trim($_POST['scale_form']);
	$scale_to = trim($_POST['scale_to']);
	$symptom_type = trim($_POST['symptom_type']);
        $symptom_name=$_POST['symptom_name'];
        $listing_order = trim($_POST['listing_order']);
        
        $interpretaion=$_POST['interpretaion'];
        $comment = trim($_POST['comment']);
        $share_type = trim($_POST['share_type']);
            
         $user_type=1;
	if(!$error)
	{
//		if($obj1->updateDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine,$meal_id))
		if($obj1->updateInterpretation($healcareandwellbeing,$lab,$adviser,$interpretation_code,$interpretation_no,$interpretation_id,$prof_cat,$sub_cat,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$admin_id,$user_type,$share_type))
		{
                    $addmorescaledata=$obj1->updateInterpretationAddMore($interpretaion,$comment,$id);
                    
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=assign_interpretation&page='.$page.'&msg='.urlencode($msg));
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
	list($healcareandwellbeing,$lab,$adviser,$interpretation_id,$interpretation_code,$interpretation_no,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$prof_cat1,$sub_cat1,$prof_cat2,$sub_cat2,$prof_cat3,$sub_cat3,$prof_cat4,$sub_cat4,$prof_cat5,$sub_cat5,$prof_cat6,$sub_cat6,$prof_cat7,$sub_cat7,$prof_cat8,$sub_cat8,$prof_cat9,$sub_cat9,$prof_cat10,$sub_cat10,$interpretation,$comment,$identity_id,$user_type,$share_type) = $obj2->getInterpretationDetails($id);
        
        
//        $updated_by=
        $interpretation_criteriaexplode=explode(',',$interpretation_criteria);
 
  $interpretationname=$obj1->getInterpretationIdbyName($interpretation);
 
 
 $prof_cat[]=$prof_cat1;
 $prof_cat[]=$prof_cat2;
 $prof_cat[]=$prof_cat3;
 $prof_cat[]=$prof_cat4;
 $prof_cat[]=$prof_cat5;
 $prof_cat[]=$prof_cat6;
 $prof_cat[]=$prof_cat7;
 $prof_cat[]=$prof_cat8;
 $prof_cat[]=$prof_cat9;
 $prof_cat[]=$prof_cat10;
 
 $sub_cat[]=$sub_cat1;
 $sub_cat[]=$sub_cat2;
 $sub_cat[]=$sub_cat3;
 $sub_cat[]=$sub_cat4;
 $sub_cat[]=$sub_cat5;
 $sub_cat[]=$sub_cat6;
 $sub_cat[]=$sub_cat7;
 $sub_cat[]=$sub_cat8;
 $sub_cat[]=$sub_cat9;
 $sub_cat[]=$sub_cat10;
 
 
//$interpretation_criteriavalue=implode('\',\'',$interpretation_criteriaexplode);
//       list($data) = $obj1->getScalePrfoCatDetails($scale_id);
//        
        
        

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Interpretation&nbsp;&nbsp;(Assign)</td>
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
							<input type="hidden" name="interpretation_id" id="interpretation_id" value="<?php echo $interpretation_id;?>" />
                                                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                                                        <input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count;?>" >
                                                        <input type="hidden" name="count_prof_cat_data" id="count_prof_cat_data" value="<?php echo $count_prof_cat_data;?>" >
                                
							<input type="hidden" name="hdnpage" id="hdnpage" value="<?php echo $page;?>" />
                                                              <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                                    <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>Identity Type:</strong></td>
                                            <td>
                                                <input type="text" id="identity_type" name="identity_type" style="width:150px;" value="<?php echo ($user_type == 1 ? 'admin' : 'practioner'); ?>" disabled=""/>
                                            </td>
                                                    
<!--                                                                <td width="5%" height="30" align="left" valign="middle"><strong>Identity Level:</strong></td>
                                            <td>
                                                <input type="text" id="identity_level" name="identity_level" style="width:150px;"/>
                                            </td>-->
                                                      
                                                                <td width="15%" height="30" align="left" valign="middle"><strong>Identity Id:</strong></td>
                                            <td>
                                                <input type="text" id="identity_id" name="identity_id" style="width:200px;" value="<?php echo $identity_id; ?>" disabled=""/>
                                                
                                                                </tr>
                                                                
                                    <tr>
					<td colspan="9" align="center">&nbsp;</td>
				    </tr>            
                                    <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>Interpretation System Details:</strong></td>
                                    <tr>
					<td colspan="9" align="center">&nbsp;</td>
				    </tr>
                                    <tr>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Healthcare / Wellbeing System</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                            <select name="healcareandwellbeing" id="healcareandwellbeing" style="width:120px;">
                                               
                                                 <?php echo $obj->getFavCategoryRamakant('42',$healcareandwellbeing)?>
                                            </select>
                                        </td>
                                    </tr>                        
                                        <tr>
                                            <td colspan="9" align="center">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Hospital/Clinic/Lab:</strong></td>
                                            <td width="14%" height="30" align="left" valign="middle">
                                          
                                     
                                            <input name="lab" type="text" id="lab<?php echo $i;?>" value="<?php echo $lab; ?>" onkeyup="serch(<?php echo $i;?>); return false;"/>
                                        </td>
                                        
                                            <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                                           <td width="10%" height="30" align="left" valign="middle"><strong>Practitioner/Adviser:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                          
                                     
                                            <input name="adviser" type="text" id="adviser<?php echo $i;?>" value="<?php echo $adviser; ?>" onkeyup="serch1(<?php echo $i;?>); return false;" />
                                        </td>
                                        
                                                  <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                 <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>SET UP Your Interpretation System:</strong></td>                           
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                    <?php for($i=0;$i<$total_count;$i++) {  ?>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                    <tr>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category<?php echo $i+1 ;?>:</strong></td>
                                        <td width="14%" height="30" align="right" valign="middle">
                                            <select  name="prof_cat[]" id="prof_cat<?php echo $i+1?>" onchange="getMainCategoryOptionAddMoreValue(<?php echo $i+1?>)" style="width:150px; height: 24px;" >
                                                
                                                <?php echo $obj1->getMoreFavCategoryTypeOptions($prof_cat_value[$i+1],$prof_cat[$i]); ?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub &nbsp;&nbsp;&nbsp;&nbsp;Category<?php echo $i+1 ;?>:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select name="sub_cat[]" id="sub_cat<?php echo $i+1?>" style="width:150px; height: 24px;">
                                                <?php echo $obj1->getMoreFavCategoryRamakant($prof_cat_value[$i+1],$sub_cat[$i]);?>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                         <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong><?php echo $header[$i+1];?></strong></td>
                                                 
                                    </tr>
                                    <?php }?>
                                                                  <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                                  <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>SET UP Your Interpretation Database:</strong></td>
                                                                                     <tr>
                                        <td colspan="2" height="10" align="left" valign="middle">&nbsp;</td>
                                    </tr> 
                                   
                                                           <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                <td width="5%" height="30" align="left" valign="middle"><strong>Interpretation System Code:</strong></td>
                                            <td>
                                                <input type="text" id="interpretation_code" name="interpretation_code" style="width:150px;"value="<?php echo $interpretation_code; ?>"/>
                                            </td>
                                                      
                                                                <td width="15%" height="30" align="left" valign="middle"><strong>Interpretation System Reference No:</strong></td>
                                            <td>
                                                <input type="text" id="interpretation_no" name="interpretation_no" style="width:200px;" value="<?php echo $interpretation_no; ?>"/>
                                            </td>
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                     <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Interpretation Criteria:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                                <select name="interpretation_criteria[]" multiple="" id="interpretation_criteria" style="width:150px;" onchange="displayInterpretationCriteriaData();return false;">
                                                         <?php echo $obj1->getMoreFavCategoryVivek('43',$interpretation_criteriaexplode); ?>
                                                </select>
                                        </td>
                                       
                                    </tr>  
                                    
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>

                                    
                                     <tr class="displayscale">
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Scale From:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                        <select name="scale_form" id="scale_form" style="width:150px; height:24px;">
                                                <?php
                                                for($j=0;$j<=10;$j++)
                                                { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($j == $scale_form) {echo "selected"; } ?>><?php echo $j;?></option>
                                                <?php
                                                } ?>	
                                        </select>
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Scale To:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                        <select name="scale_to" id="scale_to" style="width:150px; height:24px;">
                                                <?php
                                                for($j=0;$j<=10;$j++)
                                                { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($scale_to == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                <?php
                                                } ?>	
                                        </select>
                                        </td>
                                       
                                    </tr>
                                   
                                    <tr class="displayscale">
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <tr class="displaysymptom">
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Symptom Type:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                        <select name="symptom_type" id="symptom_type" style="width:150px; height:24px;" onchange="getSymptomNameOptionAddMore()">
                                                                               
                                            <?php echo $obj->getFavCategoryRamakant('36',$symptom_type);?>
                                        </select>
                                        </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Symptom Name:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select name="symptom_name" id="symptom_name" style="width:150px; height:24px;" >
                                                <option>Select Symptom Name</option>
                                                <?php echo $obj->getSymptomName($symptom_name);?>
                                            </select>
                                        </td>
                                       
                                    </tr>
                                   
                                    <tr class="displaysymptom">
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                  

                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    
                                    <tr>
                                       
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Interpretation:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <input name="interpretaion" type="text" id="interpretaion_<?php echo $i;?>" value="<?php echo $interpretationname; ?>" onkeyup="suggestionsearch(<?php echo $i;?>); return false;" style="width:150px; height: 23px;">
                                       </td>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Comment:</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <textarea name="comment" type="text" id="comment"  style="width:150px; height: 50px;" ><?php echo $comment;?> </textarea>
                                        </td>
                                    </tr>
                                   
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <td align="right"><strong>Share Type:</strong></td>
                                                                <td align="center"><strong>:</strong></td>

                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="share_type" id="share_type" style="width:200px;"value="<?php echo $share_type;?>">
                                                    <?php echo $obj->getFavCategoryRamakant('49',$share_type)?>
                                                </select>
                                            </td>

                                           
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>               
                                
									<td align="right"><strong>Order</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                        <select name="listing_order" id="listing_order" style="width:200px;">
                                                                                <?php
                                                                                for($i=1;$i<=20;$i++)
                                                                                { 
                                                                                        if($listing_order == $i)
                                                                                        {
                                                                                                $sel = ' selected ';
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                                $sel = ''; 
                                                                                        }
                                                                                ?>
                                                                            <option value="<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?></option>
                                                                            <?php
                                                                                    } ?>
                                                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                    
                                <tr id="add_before_this_row">
                                    <td align="right" valign="top">&nbsp;</td>
                            	    <td align="center" valign="top">&nbsp;</td>
                                    <!--<td align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreRows">Add More Rating</a></td>-->
                                </tr>	
                                
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left"><input type="Submit" name="btnSubmit" value="Submit" /></td>
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
          <script>
   

function suggestionsearch(num) {
//    alert(num);
    var availableTags = [
        <?php echo $tdata2; ?>
    ];


    $( "#interpretaion_"+num).autocomplete({
      source: availableTags
    });
//    $( "#interpretaion_"+num).val()
  
  }
   function serch(num) {
   // alert(num);
    var availableTags = [
        <?php echo $tdata; ?>
    ];


    $( "#lab"+num).autocomplete({
      source: availableTags
    });
//    $( "#interpretaion_"+num).val()
  
  }
     function serch1(num) {
   // alert(num);
    var availableTags = [
        <?php echo $tdata1; ?>
    ];


    $( "#adviser"+num).autocomplete({
      source: availableTags
    });
//    $( "#interpretaion_"+num).val()
  
  }
  
function getMainCategoryOptionAddMoreValue(num)
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
//			alert(result);
                        
			$("#sub_cat"+num).html(result);
		}
	});
   }
  
  
//function suggestionsearch1(num) {
////    alert(num);
//    var availableTags = [
//        <?php echo $tdata; ?>
//    ];
//
//
//    $( "#interpretaion_"+num).autocomplete({
//      source: availableTags
//    });
//  
//
//}  
////      );
    
//  } 
 
    
function displayInterpretationCriteriaData()
        {
         var interpretation_criteria = $('#interpretation_criteria').val();
         
         if(interpretation_criteria == '')
         {
         $('.displaysymptom').hide();
         $('.displayscale').hide();
         }
         
        else if(interpretation_criteria == 335)
         {
         $('.displaysymptom').hide();
         $('.displayscale').show();
         }
         else if(interpretation_criteria == 338)
         {
         $('.displaysymptom').show();
         $('.displayscale').hide();
         }
         else if(interpretation_criteria == 338,335 )
         {
         $('.displaysymptom').show();
         $('.displayscale').show();
         }
         if(interpretation_criteria != '335' && interpretation_criteria !='338' && interpretation_criteria !='338,335' )
         {
             $('.displaysymptom').hide();
             $('.displayscale').hide();
             alert('Data is Not Available');
         }
        
        
        }
        
        $( document ).ready(function() {
            
         var interpretation_criteria = $('#interpretation_criteria').val();
         
         if(interpretation_criteria == '')
         {
         $('.displaysymptom').hide();
         $('.displayscale').hide();
         }
         
        else if(interpretation_criteria == 335)
         {
         $('.displaysymptom').hide();
         $('.displayscale').show();
         }
         else if(interpretation_criteria == 338)
         {
         $('.displaysymptom').show();
         $('.displayscale').hide();
         }
         else if(interpretation_criteria == 338,335 )
         {
         $('.displaysymptom').show();
         $('.displayscale').show();
         }
         if(interpretation_criteria != '335' && interpretation_criteria !='338' && interpretation_criteria !='338,335' )
         {
             $('.displaysymptom').hide();
             $('.displayscale').hide();
           //  alert('Data is Not Available');
         }
        
         
       });
       
       
       function getSymptomNameOptionAddMore()
               {

                    var symptom_type = $("#symptom_type").val();
                   
                    //var sub_cat = $("#fav_cat_id_"+idval).val();
                    //alert(parent_cat_id);
                    var dataString = 'action=getsymptomnameoption&symptom_type='+symptom_type;
                    $.ajax({
                            type: "POST",
                            url: "include/remote.php",
                            data: dataString,
                            cache: false,
                            success: function(result)
                            {
//                                    alert(result);
                                    //alert(sub_cat);
                                    $("#symptom_name").html(result);
                            }
                    });
               }
  

</script>
</div>