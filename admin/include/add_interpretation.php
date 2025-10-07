<?php
require_once('config/class.mysql.php');
require_once('classes/class.generalstressors.php');
require_once('classes/class.places.php');
require_once('classes/class.scrollingwindows.php');

require_once('classes/class.dailymeals.php');
require_once('classes/class.profilecustomization.php');
$obj = new General_Stressors();
$obj1 = new Scrolling_Windows();
$obj2 = new Places();
$obj3 = new ProfileCustomization();
$obj4 = new Daily_Meals();

//$data = $obj->getProUsersOptionsSearch($referred_from);
//
//$tdata='"'.implode('","',$data).'"';
//
//$data1 = $obj->getPersonUsersOptionsSerch($referred_by);
//
//$tdata1='"'.implode('","',$data1).'"';
//
//
//$data2 = $obj1->getInterpretationAddOption('71');
//
//$tdata2='"'.implode('","',$data2).'"';

//print_r($tdata);
//die();








$add_action_id = '298';

$cat_cnt = 0;
$cat_total_cnt = 1;


$page_name = 'assign_interpretation';
list($header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value) = $obj4->getPageCatDropdownValue($page_name);

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


$header[$j]=  $header1;
$header[$j+1]=  $header2;
$header[$j+2]=  $header3;
$header[$j+3]=  $header4;
$header[$j+4]=  $header5;
$header[$j+5]=  $header6;
$header[$j+6]=  $header7;
$header[$j+7]=  $header8;
$header[$j+8]=  $header9;
$header[$j+9]=  $header10;

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$add_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

$error = false;
$err_msg = "";

$tr_days_of_month = 'none';
$tr_single_date = 'none';
$tr_date_range = 'none';

$arr_days_of_month = array();
$arr_state_id = array();
$arr_city_id = array();
$arr_place_id = array();
$arr_user_id = array();
$arr_min_rating = array();
$arr_max_rating = array();
$arr_interpretaion = array();
$comment = array();

$row_cnt = '1';
$row_totalRow = '1';

if(isset($_POST['btnSubmit']))
{
	
	$row_cnt = trim($_POST['hdnrow_cnt']);
        $lab=$_POST['lab'];
         $adviser=$_POST['adviser'];
        $healcareandwellbeing=$_POST['healcareandwellbeing'];
        
        $interpretation_code=$_POST['interpretation_code'];
        $interpretation_no=$_POST['interpretation_no'];
        $prof_cat = $_POST['prof_cat'];
        $sub_cat = $_POST['sub_cat'];
        $total_count = $_POST['total_count'];
       
	
	
        $interpretation_criteria = implode(',',$_POST['interpretation_criteria']);
       
	$scale_form = trim($_POST['scale_form']);
	$scale_to = trim($_POST['scale_to']);
	$symptom_type = trim($_POST['symptom_type']);
        $symptom_name=$_POST['symptom_name'];
        $listing_order = trim($_POST['listing_order']);
        $share_type = trim($_POST['share_type']);
        $user_type=1;
       $header1 = $_POST['header1'];
     
    $header2 = $_POST['header2'];
    
    $header3 = $_POST['header3'];
    
    $header4 =$_POST['header4'];
     
    $header5 = $_POST['header5'];
    
    $header6 = $_POST['header6'];
    
    $header7 = $_POST['header7'];
     
    $header8 =  $_POST['header8'];
    
    $header9 =  $_POST['header9'];
    
     $header10 =  $_POST['header10'];
	
	foreach ($_POST['interpretaion'] as $key => $value) 
	{
		array_push($arr_interpretaion,$value);
	}
       
	//print_r($arr_interpretaion);
        //die();
        
	foreach ($_POST['comment'] as $key => $value) 
	{
		array_push($comment,$value);
	}
	
        $row_totalRow = trim($_POST['cat_total_cnt']);  
	if(!$error)
	{
            
            $cnt = '1';

           $totalRow = '1';
           
		
		
		if($obj->addInterpretation($healcareandwellbeing,$lab,$adviser,$interpretation_code,$interpretation_no,$prof_cat,$sub_cat,$total_count,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$arr_interpretaion,$comment,$share_type,$row_totalRow,$admin_id,$user_type))
		{   
			$msg = "Question Added Successfully!";
			header('location: index.php?mode=assign_interpretation&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
else
{
	$situation = '';
	$situation_font_family = '';
	$situation_font_size = '';
	$situation_font_color = '000000';
	$listing_date_type = '';
	$days_of_month = '';
	$single_date = '';
	$start_date = '';
	$end_date = '';
	$country_id = '';
	$arr_state_id[0] = '';
	$arr_city_id[0] = '';
	$arr_place_id[0] = '';
	$arr_user_id[0] = '';
	$practitioner_id = '';
	$keywords = '';
	$listing_order = '1';
	$arr_min_rating[0] = '0';
	$arr_max_rating[0] = '0';
	$arr_interpretaion[0] = '';
	$comment[0] = '';
        $cnt = '1';

    $totalRow = '1';
}	

$add_more_row_cat_str = '<tr id="row_cat_\'+cat_cnt+\'"><td width="10%" height="30" align="left" valign="middle"><strong>Interpretaion:</strong></td><td width="15%" height="30" align="left" valign="middle"><input type="text" name="interpretaion[]" id="interpretaion_\'+cat_cnt+\'" style="width:350px; height: 25px;" onkeyup="suggestionsearch(\'+cat_cnt+\'); return false;"/></td><td width="10%" height="30" align="center" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Comment:</strong></td><td width="15%" height="30" align="right" valign="middle"><textarea name="comment[]" id="comment_\'+cat_cnt+\'" style="width:150px; height: 50px;"></textarea></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';

?>
<script type="text/javascript" src="js/jscolor.js"></script>

<script type="text/javascript"> 
	$(document).ready(function() {
		$('#addMoreRows').click(function() {
		
			var row_cnt = parseInt($('#hdnrow_cnt').val());
			var row_totalRow = parseInt($('#hdnrow_totalRow').val());
			
			$('#tblrow tr:#add_before_this_row').before('<tr id="row_id_1_'+row_cnt+'"><td align="right"><strong>Rating</strong></td><td align="center"><strong>:</strong></td><td align="left"><strong>From</strong>&nbsp;<select name="min_rating[]" id="min_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>&nbsp;&nbsp;<strong>To</strong>&nbsp;<select name="max_rating[]" id="max_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></td></tr><tr id="row_id_2_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_3_'+row_cnt+'"><td align="right" valign="top"><strong>Interpretation</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="interpretaion[]" id="interpretaion_'+row_cnt+'" rows="5" cols="25"></textarea></td></tr><tr id="row_id_4_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_5_'+row_cnt+'"><td align="right" valign="top"><strong>Treatment</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="treatment[]" id="treatment_'+row_cnt+'" rows="5" cols="25"></textarea>&nbsp;<input type="button" value="Remove Item" id="tr_row_'+row_cnt+'" name="tr_row_'+row_cnt+'" onclick="removeRows('+row_cnt+')" /></td></tr><tr id="row_id_6_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr>');	
				
			row_cnt = row_cnt + 1;       
			$('#hdnrow_cnt').val(row_cnt);
			var row_cnt = $('#hdnrow_cnt').val();
			row_totalRow = row_totalRow + 1;       
			$('#hdnrow_totalRow').val(row_totalRow);
						
		});
	});
</script>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Interpretation&nbsp;&nbsp;&nbsp;(Assign)</td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
                             <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                                 
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							<form action="#" method="post" name="frmadd_sleep" id="frmadd_sleep" enctype="multipart/form-data" >
                                                        <input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt;?>" />
                                                        <input type="hidden" name="totalRow" id="totalRow" value="<?php echo $totalRow;?>" />
                                                        
                                                        <input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
				                        <input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>"> 
                                                        <input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
							<input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
							<input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count;?>" >

                                

                                
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                                            
                                                                
							<tbody>
                                                                                                <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>Identity Type:</strong></td>
                                            <td>
                                                <input type="text" id="identity_type" name="identity_type" style="width:150px;"/>
                                            </td>
                                           
                                                      
                                                                <td width="15%" height="30" align="left" valign="middle"><strong>Identity Id:</strong></td>
                                            <td>
                                                <input type="text" id="identity_id" name="identity_id" style="width:200px;"/>
                                                
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
                                               
                                                 <?php echo $obj1->getFavCategoryRamakant('42',$healcareandwellbeing)?>
                                            </select>
                                        </td>
                                    </tr>  
                                                            <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                    <td width="10%" height="30" align="left" valign="middle"><strong>Hospital/Clinic/Lab:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                          
                                     
                                            <input name="lab" type="text" id="lab<?php echo $i;?>" onkeyup="serch(<?php echo $i;?>); return false;" style="width:350px; height: 25px;">
                                        </td>
                                            <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                                           <td width="10%" height="30" align="left" valign="middle"><strong>Practitioner/Adviser:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                          
                                     
                                            <input name="adviser" type="text" id="adviser<?php echo $i;?>" onkeyup="serch1(<?php echo $i;?>); return false;" style="width:350px; height: 25px;">
                                        </td>
                                                <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                 <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>SET UP Your Interpretation System:</strong></td>
                                                          
                            	                               <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                
                                  <?php for($i=0;$i<$total_count;$i++) {  ?>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                    <tr>
                                        
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category<?php echo $i+1 ;?>:</strong></td>
                                        <td width="14%" height="30" align="right" valign="middle">
                                             
                                                       
                                            <select  name="prof_cat[]" id="prof_cat<?php echo $i+1?>" onchange="getMainCategoryOptionAddMoreValue(<?php echo $i+1?>)" style="width:150px; height: 24px;" >
                                                
                                                <?php echo $obj4->getMoreFavCategoryTypeOptions($prof_cat_value[$i+1]); ?>
                                            </select>
                                            
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub &nbsp;&nbsp;&nbsp;&nbsp;Category<?php echo $i+1 ;?>:&nbsp;&nbsp;</strong></td>
                                        
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select name="sub_cat[]" id="sub_cat<?php echo $i+1?>" style="width:150px; height: 24px;">
                                                <?php echo $obj4->getMoreFavCategoryRamakant($prof_cat_value[$i+1],$arr_cucat_cat_id[$i+1])?>
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
                                   
                                   	
                                                                  <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                                  <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>SET UP Your Interpretation Database:</strong></td>
                                                <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                <td width="5%" height="30" align="left" valign="middle"><strong>Interpretation System Code:</strong></td>
                                            <td>
                                                <input type="text" id="interpretation_code" name="interpretation_code" style="width:150px;"/>
                                            </td>
                                                      
                                                                <td width="15%" height="30" align="left" valign="middle"><strong>Interpretation System Reference No:</strong></td>
                                            <td>
                                                <input type="text" id="interpretation_no" name="interpretation_no" style="width:200px;"/>
                                            </td>
                                          
                                                                              <tr>
                                        <td colspan="2" height="10" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                                                <tr>
									<td align="right"><strong>Interpretation Criteria : </strong></td>
                                                                        <td align="right" colspan="2">
                                                                        <select name="interpretation_criteria[]" multiple="" id="interpretation_criteria" style="width:300px;" onchange="displayInterpretationCriteriaData();return false;">
                                                                                 <?php echo $obj4->getMoreFavCategoryRamakant('43'); ?>
                                                                        </select>
                                                                       
									</td>
								</tr>
                                                                
                                                                <tr>
                                                                <td colspan="4" align="center">&nbsp;</td>
								</tr>
                                                                
                                                                <tr class="displayscale" id="row_id_1_<?php echo $i;?>">
									<td align="right"><strong>Scale</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                        <strong>From</strong>&nbsp;
										<select name="scale_form" id="scale_form">
										<?php
										for($j=0;$j<=10;$j++)
										{ ?>
											<option value="<?php echo $j;?>" <?php if ($arr_min_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
										<?php
										} ?>	
                                                                        </select>
                                                                        &nbsp;&nbsp;<strong>To</strong>&nbsp;
                                                                        <select name="scale_to" id="scale_to">
										<?php
										for($j=0;$j<=10;$j++)
										{ ?>
											<option value="<?php echo $j;?>" <?php if ($arr_max_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
										<?php
										} ?>	
                                                                        </select>
                                        
									</td>
								</tr>
                                                                
                                                                <tr>
                                                                <td colspan="4" align="center">&nbsp;</td>
								</tr>
                                                                
                                                                <tr class="displaysymptom"> 
                                                                    <td colspan="9">
                                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                                                            <tr>
                                                                       <td align="right"><strong>Symptom Type</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                           <select name="symptom_type" id="symptom_type" style="width:150px; height:24px;" onchange="getSymptomNameOptionAddMore()">
                                                                               
                                                                                <?php echo $obj1->getFavCategoryRamakant('36',$arr_cucat_cat_id);?>
                                                                            </select>
                                                                            </td>
                                                                            
                                                                            <td align="right"><strong>Symptom Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                           <select name="symptom_name" id="symptom_name" style="width:150px; height:24px;" >
                                                                                <option>Select Symptom Name</option>
                                                                                <?php echo $obj1->getFavCategoryRamakant($arr_cucat_parent_cat_id,$arr_cucat_cat_id);?>
                                                                            </select>
                                                                            </td>
                                                                       
                                                                            </tr>
                                                                        </table>
                                                                            
                                                                    </td>
									
								</tr>
                                                                
                                                                <tr>
                                                                <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                
                                    
<!--                                    
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                </tr>

                                                                <tr class="">
                                                                    <td colspan="4" class="" align="" >
                                                                        <table>
                                                                            <tr class="manage-header">
										 <td width="10%" class="manage-header" align="center" >S.No.</td>
										 <td width="50%" class="manage-header" align="center">Manage Fav Categories</td>
                                                                                 <td width="20%" class="manage-header" align="left">Reading</td>
                                                                                 <td width="20%" class="manage-header" align="center">Comments</td>
                                                                            </tr>
                                                                            <tr>
										 <td width="10%"  align="center" >1</td>
										 <td width="50%"  align="center">Manage Fav Categories</td>
                                                                                 <td width="20%"  align="left">Reading</td>
                                                                                 <td width="20%"  align="center">Comments</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
										 
                                                                </tr>-->
                                                                
                                                                        
                                                                        
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>

       <?php
                                    for($i=0;$i<$cat_total_cnt;$i++)
                                    { ?>
                                    
                                   <tr id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Interpretation:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                          
                                     
                                            <input name="interpretaion[]" type="text" id="interpretaion_<?php echo $i;?>" onkeyup="suggestionsearch(<?php echo $i;?>); return false;" style="width:350px; height: 25px;">
                                        </td>
                                         <td width="10%" height="30" align="center" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Comment:</strong></td>
                                        <td width="15%" height="30" align="center" valign="middle">
                                        <td width="15%" height="30" align="center" valign="middle"> 
                                            <textarea name="comment[]" type="text" id="comment_<?php echo $i;?>"  style="width:150px; height: 50px;" ></textarea>
                                        </td>
                               
                                        
                                        <?php
                                            if($i == 0)
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="addMoreRowCategory();"><img src="images/add.gif" width="10" height="8" border="0" />Add More</a></td>
                                            <?php  	
                                            }
                                            else
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(//<?php echo $i;?>);"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td>
                                                    
                                            <?php	
                                            }
//                                            ?>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <?php  	
                                    } ?>
                                    
								                                            
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <td align="right"><strong>Share Type:</strong></td>
                                                                <td align="center"><strong>:</strong></td>

                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="share_type" id="share_type" style="width:200px;">
                                                    <?php echo $obj1->getFavCategoryRamakant('49',$share_type)?>
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
        <script src="../csswell/js/jquery.min.js"></script>  
        <script src="../csswell/bootstrap/js/bootstrap.js" type="text/javascript"></script>    
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
        <script src="../csswell/bootstrap/js/bootbox.min.js" type="text/javascript"></script>   
       
        
        
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
               
            function practitionerGetPopUp()
            
             { 
                    var practitioner_id = $("#practitioner_id").val();
                   
                    $.ajax({
                            type: "POST",
                            url: "include/practioners-pop-up.php",
                           
                            cache: false,
                            success: function(result)
                                     {
                                        if(practitioner_id=='')
                                        {
                            bootbox.dialog({
                                title: 'PRACTITIONER',
                                message: result
                            });        }                     }
                    });
               }
           function userGetPopUp()
            
             {
             var user_id = $("#user_id").val();
            
                   
                    $.ajax({
                            type: "POST",
                            url: "include/user-pop-up.php",
                           
                            cache: false,
                            success: function(result)
                                     {
                                        if(user_id=='')
                                        {
                                            bootbox.dialog({
                                                title: 'USER',
                                                message: result
                                            });       
                                        }                      }
                    });
               }    
            
            
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
            
         
         $('.displaysymptom').hide();
         $('.displayscale').hide();
         
       });
       
       function getMainCategoryOptionAddMore1()
{
        
	var parent_cat_id = $("#share_type2").val();
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
			$("#sub").html(result);
		}
	});
}
       function getMainCategoryOptionAddMore2()
{
        
	var parent_cat_id = $("#share_type1").val();
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
			$("#sub1").html(result);
		}
	});
}
  
        </script>
</div>