<?php
require_once('config/class.mysql.php');
require_once('classes/class.generalstressors.php');
require_once('classes/class.places.php');
require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

require_once('classes/class.dailymeals.php');
$obj4 = new Daily_Meals();

require_once('classes/class.profilecustomization.php');  
$obj3 = new ProfileCustomization();
$obj = new General_Stressors();
$obj2 = new Places();

$add_action_id = '31';

$cat_cnt = 0;
$cat_total_cnt = 1;


$page_name = 'wellness_solutions';
list($prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value) = $obj4->getPageCatDropdownValue($page_name);

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
$arr_treatment = array();

$row_cnt = '1';
$row_totalRow = '1';

if(isset($_POST['btnSubmit']))
{
	$row_totalRow = trim($_POST['hdnrow_totalRow']);  
	$row_cnt = trim($_POST['hdnrow_cnt']);
        
        
        
        $prof_cat = $_POST['prof_cat'];
        $sub_cat = $_POST['sub_cat'];
        $total_count = $_POST['total_count'];
         
//	$situation = strip_tags(trim($_POST['situation']));
//	$situation_font_family = trim($_POST['situation_font_family']);
//	$situation_font_size = trim($_POST['situation_font_size']);
//	$situation_font_color = trim($_POST['situation_font_color']);
	
	$listing_date_type = trim($_POST['listing_date_type']);
		
	foreach ($_POST['days_of_month'] as $key => $value) 
	{
		array_push($arr_days_of_month,$value);
	}
	
	$single_date = trim($_POST['single_date']);
	$start_date = trim($_POST['start_date']);
	$end_date = trim($_POST['end_date']);
	
	$country_id = trim($_POST['country_id']);
        $state_id=$_POST['state_id'];
        $city_id=$_POST['city_id'];
        $place_id=$_POST['place_id'];
        
        
        $gender = trim($_POST['gender']);
	$flag = trim($_POST['flag']);
	$user_age1 = trim($_POST['user_age1']);
	
	$user_age1 = trim($_POST['user_age2']);
        $user_service=$_POST['user_service'];
        $users_food_option=$_POST['users_food_option'];
        $users_height1=$_POST['users_height1'];
        $users_height2 = trim($_POST['users_height2']);
        $users_weight1=$_POST['users_weight1'];
        $users_weight2=$_POST['users_weight2'];
        $users_bmi1=$_POST['users_bmi1'];
        $users_bmi2=$_POST['users_bmi2'];
	
//	foreach ($_POST['state_id'] as $key => $value) 
//	{
//		array_push($arr_state_id,$value);
//	}
//        print_r($arr_state_id);
//	
//	foreach ($_POST['city_id'] as $key => $value) 
//	{
//		array_push($arr_city_id,$value);
//	}
//	 print_r($arr_city_id);
//	foreach ($_POST['place_id'] as $key => $value) 
//	{
//		array_push($arr_place_id,$value);
//	}
//         print_r($arr_place_id);die();
	
	foreach ($_POST['user_id'] as $key => $value) 
	{
		array_push($arr_user_id,$value);
	}
	 
	$practitioner_id = trim($_POST['practitioner_id']);
//	$order = trim($_POST['order']);
	$listing_order = trim($_POST['listing_order']);
	
//	foreach ($_POST['min_rating'] as $key => $value) 
//	{
//		array_push($arr_min_rating,$value);
//	}
//	
//	foreach ($_POST['max_rating'] as $key => $value) 
//	{
//		array_push($arr_max_rating,$value);
//	}
	
	foreach ($_POST['interpretaion'] as $key => $value) 
	{
		array_push($arr_interpretaion,$value);
	}
	
	foreach ($_POST['treatment'] as $key => $value) 
	{
		array_push($arr_treatment,$value);
	}
	
//	if($situation == '')
//	{
//		$error = true;
//		$err_msg = 'Please enter question';
//	}
//	
//	if($situation_font_family == '')
//	{
//		$error = true;
//		$err_msg .= '<br>Please enter font family for question';
//	}
//	
//	if($situation_font_size == '')
//	{
//		$error = true;
//		$err_msg .= '<br>Please enter font size for question';
//	}
//	
//	if($listing_date_type == '')
//	{
//		$error = true;
//		$err_msg .= '<br>Please select selection date type';
//	}
//	elseif($listing_date_type == 'days_of_month')
//	{
//		$tr_days_of_month = '';
//		$tr_single_date = 'none';
//		$tr_date_range = 'none';
//		
//		if(count($arr_days_of_month) < 1)
//		{
//			$error = true;
//			$err_msg .= '<br>Please select days of month';
//		}
//		else
//		{
//			$days_of_month = implode(',',$arr_days_of_month);
//		}	
//	}
//	elseif($listing_date_type == 'single_date')
//	{
//		$tr_days_of_month = 'none';
//		$tr_single_date = '';
//		$tr_date_range = 'none';
//		
//		if($single_date == '')
//		{
//			$error = true;
//			$err_msg .= '<br>Please select single date';
//		}	
//	}
//	elseif($listing_date_type == 'date_range')
//	{
//		$tr_days_of_month = 'none';
//		$tr_single_date = 'none';
//		$tr_date_range = '';
//		
//		if($start_date == '')
//		{
//			$error = true;
//			$err_msg .= '<br>Please select start date';
//		}
//		elseif($end_date == '')
//		{
//			$error = true;
//			$err_msg .= '<br>Please select end date';
//		}
//		else
//		{
//			if(strtotime($start_date) > strtotime($end_date))
//			{
//				$error = true;
//				$err_msg .= '<br>Please select end date greater than start date';
//			}
//		}	
//	}
	
	if(!$error)
	{
		if($listing_date_type == 'days_of_month')
		{
			$single_date = '';
			$start_date = '';
			$end_date = '';
		}
		elseif($listing_date_type == 'single_date')
		{
			$days_of_month = '';
			$start_date = '';
			$end_date = '';
			
			$single_date = date('Y-m-d',strtotime($single_date));
		}
		elseif($listing_date_type == 'date_range')
		{
			$days_of_month = '';
			$single_date = '';
			
			$start_date = date('Y-m-d',strtotime($start_date));
			$end_date = date('Y-m-d',strtotime($end_date));
		}
		
		if($arr_state_id[0] == '')
		{
			$str_state_id = '';
		}
		else
		{
			$str_state_id = implode(',',$arr_state_id);
		}
		
		if($arr_city_id[0] == '')
		{
			$str_city_id = '';
		}
		else
		{
			$str_city_id = implode(',',$arr_city_id);
		}
		
		if($arr_place_id[0] == '')
		{
			$str_place_id = '';
		}
		else
		{
			$str_place_id = implode(',',$arr_place_id);
		}
		
		if($arr_user_id[0] == '')
		{
			$str_user_id = '';
		}
		else
		{
			$str_user_id = implode(',',$arr_user_id);
		}
		
		if($obj->addQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$str_state_id,$str_city_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$str_place_id))
		{
			$msg = "Question Added Successfully!";
			header('location: index.php?mode=general_stressors&msg='.urlencode($msg));
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
	$arr_treatment[0] = '';
}	
//$add_more_row_cat_str = '<tr id="row_cat_\'+cat_cnt+\'"><td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="fav_cat_id[]" id="fav_cat_id_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj1->getInterpretationOption('17','').'</select></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add General Stressors Question</td>
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
							<form action="#" method="post" name="frmadd_sleep" id="frmadd_sleep" enctype="multipart/form-data" >
                                                        <input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
				                        <input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>"> 
                                                        <input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
							<input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
							<input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count;?>" >
                                                        
                                                        <input type="text" name="country_id" id="country_id"  />
                                                        <input type="text" name="state_id" id="state_id"  />
							<input type="text" name="city_id" id="city_id"  />
							<input type="text" name="place_id" id="place_id"  >
                                                        <input type="text" name="gender" id="gender" />
                                                        <input type="text" name="flag" id="flag"  >
                                                        <input type="text" name="user_age1" id="user_age1"  />
							<input type="text" name="user_age2" id="user_age2"  >
                                                        
							<input type="text" name="user_service" id="user_service"  />
							
                                                        
                                                         <input type="text" name="users_food_option" id="users_food_option"  />
                                                        <input type="text" name="users_height1" id="users_height1"  />
							<input type="text" name="users_height2" id="users_height2"  />
							<input type="text" name="users_weight1" id="users_weight1"  >
                                                        <input type="text" name="users_weight2" id="users_weight2" />
                                                        <input type="text" name="users_bmi1" id="users_bmi1"  >
                                                        <input type="text" name="users_bmi2" id="users_bmi2"  >
                                

                                
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
							<tbody>
                                                                
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
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub &nbsp;&nbsp;&nbsp;&nbsp;Category<?php echo $i+1 ;?>:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="right" valign="middle">
                                            <select name="sub_cat[]" id="sub_cat<?php echo $i+1?>" style="width:150px; height: 24px;">
                                                <?php echo $obj4->getMoreFavCategoryRamakant($prof_cat_value[$i+1],$arr_cucat_cat_id[$i+1])?>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <?php }?>

                                                                <tr>
                                                                <td colspan="4" align="center">&nbsp;</td>
								</tr>
                                                                <tr id="row_id_1_<?php echo $i;?>">
									<td align="right"><strong>Scale</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                        <strong>From</strong>&nbsp;
										<select name="min_rating[]" id="min_rating_<?php echo $i; ?>">
										<?php
										for($j=0;$j<=10;$j++)
										{ ?>
											<option value="<?php echo $j;?>" <?php if ($arr_min_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
										<?php
										} ?>	
                                                                        </select>
                                                                        &nbsp;&nbsp;<strong>To</strong>&nbsp;
                                                                        <select name="max_rating[]" id="max_rating_<?php echo $i; ?>">
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
                                                                <tr>
                                                                    <td colspan="9">
                                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                                                            <tr>
                                                                                <td align="right"><strong>Profile Category</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <select name="fav_cat_type_id" id="fav_cat_type_id" style="width:150px; height:24px;" onchange="getMainCategoryOptionAddMore()">
                                                                                      <option value="">Select Profile Category</option>
                                                                                       <?php  echo $obj1->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
                                                                            </select>
                                                                       </td>
                                                                       <td align="right"><strong>Symptom Type</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                           <select name="symptom_type" id="symptom_type" style="width:150px; height:24px;" onchange="getSymptomNameOptionAddMore()">
                                                                               <option>Select Symptom Type</option>
                                                                                <?php echo $obj1->getFavCategoryRamakant($arr_cucat_parent_cat_id,$arr_cucat_cat_id)?>
                                                                            </select>
                                                                            </td>
                                                                            
                                                                            <td align="right"><strong>Symptom Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                           <select name="symptom_name" id="symptom_name" style="width:150px; height:24px;" >
                                                                                <option>Select Symptom Name</option>
                                                                                <?php echo $obj1->getFavCategoryRamakant($arr_cucat_parent_cat_id,$arr_cucat_cat_id)?>
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
                                    
                                    <?php
                                    for($i=0;$i<$cat_total_cnt;$i++)
                                    { ?>
                                    
                                    <tr id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Interpretation:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                            <select  name="interpretaion[]" id="interpretaion_<?php echo $i;?>"  style="width:150px; height: 23px;" required="">
<!--                                                <option value="">Select Type</option>-->
                                                <?php echo $obj1->getInterpretationOption('17',$arr_cucat_cat_id[$i])?>
                                            </select>
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
									<td colspan="3" align="center">&nbsp;</td>
								</tr>

								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Date Selection Type</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                        <select name="listing_date_type" id="listing_date_type" onchange="toggleDateSelectionType('listing_date_type')" style="width:200px;">
                                                                                <option value="">Select Option</option>
                                                                            <option value="days_of_month" <?php if($listing_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                                                            <option value="single_date" <?php if($listing_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>
                                                                            <option value="date_range" <?php if($listing_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>
                                                                        </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr id="tr_days_of_month" style="display:<?php echo $tr_days_of_month;?>">
                                                                                                      <td align="right" valign="top"><strong>Select days of month</strong></td>
                                                                                                      <td align="center" valign="top"><strong>:</strong></td>
                                                                                                      <td align="left">
                                                                      <select id="days_of_month" name="days_of_month[]" multiple="multiple" style="width:200px;">
                                                                                                              <?php
                                                                      for($i=1;$i<=31;$i++)
                                                                      { ?>
                                                                              <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                                      <?php
                                                                      } ?>	
                                                                      </select>&nbsp;*<br>
                                                                      You can choose more than one option by using the ctrl key.
                                                                  </td>
								</tr>
                                                                <tr id="tr_single_date" style="display:<?php echo $tr_single_date;?>">
									<td align="right" valign="top"><strong>Select Date</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                                                        <input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>" style="width:200px;"  />
                                                                        <script>$('#single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                                                    </td>
								</tr>
                                                                 <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
									<td align="right" valign="top"><strong>Select Date Range</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                                                        <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:200px;"  /> - <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:200px;"  />
                                                                        <script>$('#start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});$('#end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Practitioner</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                                <select name="practitioner_id"  id="practitioner_id" onchange="getAdvisersUserOptionsMulti();" style="width:200px;">
                                                                                                                                <option value="">All Practitioner</option>
                                                                                    <?php echo $obj2->getProUsersOptions($practitioner_id); ?>
										</select>
                                                                            <input type="button" value="Practitioner" name="practitioner_btn" id="practitioner_btn" onclick="practitionerGetPopUp();">
                                   	</td>
                                       
			        </tr>
                                
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                
                                                                
                                                                

                                                              
                                                                
                                <tr>
									<td align="right" valign="top"><strong>User</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div id="tduser">	
                                                                                            <select multiple="multiple" name="user_id[]" id="user_id" style="width:200px;">
                                                                                                <option value="" <?php if (in_array('', $arr_user_id)) {?> selected="selected" <?php } ?>>All Users</option>
                                                                                                <?php echo $obj2->getAdvisersUserOptionsMulti($arr_user_id,$practitioner_id); ?>
                                                                                            </select>

                                                                                        </div> 
                                                                                    </td> 
                                                                                    <td> &nbsp;&nbsp;</td> 
                                                                                    <td> 
                                                                                         <input type="button" value="User" name="user_btn" id="user_btn" onclick="userGetPopUp();">                                
                                                                                    </td> 
                                                                                </tr>
                                                                            </table>
                                                                            &nbsp;&nbsp;<a href="javascript:void(0)" target="_self" class="body_link" onclick="viewUsersSelectionPopup()" >Select Users</a>

                                                                        </td>
                                       
				</tr>
                                <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                </tr>
<!--                                <tr>
									<td align="right" valign="top"><strong>Keywords</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <input type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>">
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>-->
<!--                                <tr>
									<td align="right" valign="top"><strong>Country</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select name="country_id" id="country_id" onchange="getStateOptionsMulti();" style="width:200px;">
											<option value="" >All Country</option>
											<?php echo $obj2->getCountryOptions($country_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>State</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdstate">
                                        <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
											<?php echo $obj2->getStateOptionsMulti($country_id,$arr_state_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>City</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdcity">
                                        <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
											<?php echo $obj2->getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Place</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdplace">
                                        <select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
											<?php echo $obj2->getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>-->
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
                                                    <?php
							for($i=0;$i<$row_totalRow;$i++)
							{  ?>
                                                                
								<tr id="row_id_4_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								
								<tr id="row_id_6_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr id="row_id_7_<?php echo $i;?>">
									<td align="right" valign="top"><strong>Treatment</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<textarea name="treatment[]" id="treatment_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_treatment[$i]; ?></textarea>
										&nbsp;
										<?php
										if($i > 0)
										{ ?>
											<input type="button" value="Remove Item" id="tr_row_<?php echo $i; ?>" name="tr_row_<?php echo $i; ?>" onclick="removeRows('<?php echo $i;?>')" />
										<?php } ?>
									 </td>
								</tr>
								<tr id="row_id_8_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
							<?php
							} ?>
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
       
        
        <script>
            
            
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
			//alert(result);
                        //alert(sub_cat);
			$("#sub_cat"+num).html(result);
		}
	});
   }

       function getSymptomNameOptionAddMore()
               {

                    var fav_cat_type_id = $("#fav_cat_type_id").val();
                    var fav_cat_id = $("#fav_cat_id").val();
                    //var sub_cat = $("#fav_cat_id_"+idval).val();
                    //alert(parent_cat_id);
                    var dataString = 'action=getsymptomnameoption&fav_cat_type_id='+fav_cat_type_id+'&fav_cat_id='+fav_cat_id;
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
    

  
        </script>
</div>