<?php
require_once('config/class.mysql.php');
require_once('classes/class.places.php');
require_once('classes/class.scrollingwindows.php');
require_once('classes/class.users.php');
require_once('classes/class.generalstressors.php');
require_once('classes/class.profilecustomization.php');  
require_once('classes/class.dailymeals.php');
require_once('classes/class.workandenvironment.php');

$obj = new General_Stressors();
$obj1 = new Scrolling_Windows();
$obj2 = new Places();
$obj3 = new ProfileCustomization();
$obj4 = new Daily_Meals();
$obj5 = new Users();
$obj6 = new Work_And_Environment();

$data = $obj->getProUsersOptionsSearch($referred_from);

$tdata='"'.implode('","',$data).'"';

$data1 = $obj->getPersonUsersOptionsSerch($referred_by);

$tdata1='"'.implode('","',$data1).'"';

$add_action_id = '27';



$page_name = 'assign_interpretation';
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


$cnt = '1';

$totalRow = '1';



$tr_days_of_month = 'none';

$tr_single_date = 'none';

$tr_date_range = 'none';

$tr_month_date = 'none';

$tr_days_of_week = 'none';



$arr_prct_id = array();

$arr_selected_situation_id = array();

$arr_min_rating = array();

$arr_max_rating = array();

$arr_sol_cat_id = array();

$arr_sol_item_id = array();



$arr_days_of_month = array();

$arr_days_of_week = array();

$arr_month = array();



$prct_cat_id = '2';
if(isset($_POST['btnSubmit']))
{
	$row_totalRow = trim($_POST['hdnrow_totalRow']);  
	$row_cnt = trim($_POST['hdnrow_cnt']);
        
        $identity_type = $_POST['identity_type'];
        
        $identity_id = $_POST['identity_id'];
        $healcareandwellbeing = $_POST['healcareandwellbeing'];
        $lab = $_POST['lab'];
        $adviser = $_POST['adviser'];
        $referred_by = $_POST['referred_by'];
        $referred_from = $_POST['referred_from'];
        
        $patient_name = $_POST['patient_name'];
       
        $reg_id = $_POST['reg_id'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $test_no = $_POST['test_no'];
        $test_date = $_POST['test_date']; 
        
        
        $interpretation_criteria = implode(',',$_POST['interpretation_criteria']);
        $user_interaction_type = trim($_POST['user_interaction_type']);
        
	$scale_form = trim($_POST['scale_form']);
	$scale_to = trim($_POST['scale_to']);
	$symptom_type = trim($_POST['symptom_type']);
        $symptom_name=$_POST['symptom_name'];
        
        $listing_order = trim($_POST['listing_order']);
        $share_type = $_POST['share_type'];
        
        
	$question = strip_tags(trim($_POST['question']));
	$situation_font_family = trim($_POST['situation_font_family']);
	$situation_font_size = trim($_POST['situation_font_size']);
	$situation_font_color = trim($_POST['situation_font_color']);
	
	$listing_date_type = trim($_POST['listing_date_type']);
        
    

    foreach ($_POST['days_of_month'] as $key => $value) 

    {

        array_push($arr_days_of_month,$value);

    }

    

    foreach ($_POST['days_of_week'] as $key => $value) 

    {

        array_push($arr_days_of_week,$value);

    }

    

    foreach ($_POST['months'] as $key => $value) 

    {

        array_push($arr_month,$value);

    }



    $single_date = trim($_POST['single_date']);

    $start_date = trim($_POST['start_date']);

    $end_date = trim($_POST['end_date']);

    
    $cat_error = false;

    $item_error = false;

	
        if($listing_date_type == '')

    {

        //$error = true;

        //$err_msg .= '<br>Please select selection date type';

    }

    elseif($listing_date_type == 'days_of_month')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = '';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = 'none';



        if(count($arr_days_of_month) < 1)

        {

            $error = true;

            $err_msg .= '<br>Please select days of month';

        }

        else

        {

            $days_of_month = implode(',',$arr_days_of_month);

        }	

    }

    elseif($listing_date_type == 'days_of_week')

    {

        $tr_days_of_week = '';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = 'none';



        if(count($arr_days_of_week) < 1)

        {

            $error = true;

            $err_msg .= '<br>Please select days of week';

        }

        else

        {

            $days_of_week = implode(',',$arr_days_of_week);

        }	

    }

    elseif($listing_date_type == 'single_date')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = '';

        $tr_date_range = 'none';

        $tr_month_date = 'none';



        if($single_date == '')

        {

            $error = true;

            $err_msg .= '<br>Please select single date';

        }	

    }

    elseif($listing_date_type == 'date_range')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = '';

        $tr_month_date = 'none';



        if($start_date == '')

        {

            $error = true;

            $err_msg .= '<br>Please select start date';

        }

        elseif($end_date == '')

        {

            $error = true;

            $err_msg .= '<br>Please select end date';

        }

        else

        {

            if(strtotime($start_date) > strtotime($end_date))

            {

                $error = true;

                $err_msg .= '<br>Please select end date greater than start date';

            }

        }	

    }

    elseif($listing_date_type == 'month_wise')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = '';

        

        //echo '<br><pre>';

        //print_r($arr_month);

        //echo '<br></pre>';

        

        if(count($arr_month) == 0)

        {

            $error = true;

            $err_msg .= '<br>Please select months';

        }

        else

        {

            $months = implode(',',$arr_month);

        }

    }
	if(!$error)
			{  
                    
                                if($listing_date_type == 'days_of_month')

        {

            $single_date = '';

            $start_date = '';

            $end_date = '';

            $days_of_week = '';

            $months = '';

        }

        elseif($listing_date_type == 'days_of_week')

        {

            $single_date = '';

            $start_date = '';

            $end_date = '';

            $days_of_month = '';

            $months = '';

        }

        elseif($listing_date_type == 'single_date')

        {

            $days_of_month = '';

            $start_date = '';

            $end_date = '';

            $days_of_week = '';

            $months = '';



            $single_date = date('Y-m-d',strtotime($single_date));

        }

        elseif($listing_date_type == 'date_range')

        {

            $days_of_month = '';

            $single_date = '';

            $days_of_week = '';

            $months = '';



            $start_date = date('Y-m-d',strtotime($start_date));

            $end_date = date('Y-m-d',strtotime($end_date));

        }

        elseif($listing_date_type == 'month_wise')

        {

            $days_of_month = '';

            $single_date = '';

            $days_of_week = '';

            $start_date = '';

            $end_date = '';

        }

        else

        {

            $single_date = '';

            $start_date = '';

            $end_date = '';

            $days_of_month = '';

            $days_of_week = '';

            $months = '';

        }

       
		
		
		if($obj->addGoalAndQuery($user_interaction_type,$question,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$healcareandwellbeing,$identity_type,$identity_id,$lab,$adviser,$referred_by,$referred_from,$patient_name,$reg_id,$gender,$age,$test_no,$test_date,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$share_type))
		{
			$msg = "Question Added Successfully!";
			header('location: index.php?mode=set_goals_and_query&msg='.urlencode($msg));
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
          $totalRow = trim($_POST['totalRow']);  

    $cnt = trim($_POST['cnt']);

    

    $prct_ref_no = $_POST['prct_ref_no'];

    

    foreach ($_POST['prct_id'] as $key => $value) 

    {

        array_push($arr_prct_id,$value);

    }

    

    $listing_date_type = trim($_POST['listing_date_type']);

		

    foreach ($_POST['days_of_month'] as $key => $value) 

    {

        array_push($arr_days_of_month,$value);

    }

    

    foreach ($_POST['days_of_week'] as $key => $value) 

    {

        array_push($arr_days_of_week,$value);

    }

    

    foreach ($_POST['months'] as $key => $value) 

    {

        array_push($arr_month,$value);

    }

    $single_date = trim($_POST['single_date']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);

    

    

   

    $cat_error = false;

    $item_error = false;

    foreach ($_POST['sol_cat_id'] as $key => $value) 

    {

        array_push($arr_sol_cat_id,$value);

        if($value == '')

        {

            $cat_error = true;

        }

        

        $arr_sol_item_id[$key] = array();

        

        if(isset($_POST['sol_item_id_'.$key]))

        {

            foreach ($_POST['sol_item_id_'.$key] as $key2 => $value2) 

            {

                array_push($arr_sol_item_id[$key],$value2);

            }

        }

        else

        {

            $item_error = true;

        }

    }

    

    //echo '<br><pre>';

    //print_r($arr_sol_cat_id);

    //echo '<br></pre>';

    

    //echo '<br><pre>';

    //print_r($arr_sol_item_id);

    //echo '<br></pre>';



    if(count($arr_prct_id) == 0)

    {

//        $error = true;

//        $err_msg = 'Please select Situation/Trigger';

    }

    
//
//    if($listing_date_type == '')
//
//    {
//
//        //$error = true;
//
//        //$err_msg .= '<br>Please select selection date type';
//
//    }

    elseif($listing_date_type == 'days_of_month')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = '';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = 'none';



        if(count($arr_days_of_month) < 1)

        {

            $error = true;

            $err_msg .= '<br>Please select days of month';

        }

        else

        {

            $days_of_month = implode(',',$arr_days_of_month);

        }	

    }

    elseif($listing_date_type == 'days_of_week')

    {

        $tr_days_of_week = '';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = 'none';



        if(count($arr_days_of_week) < 1)

        {

            $error = true;

            $err_msg .= '<br>Please select days of week';

        }

        else

        {

            $days_of_week = implode(',',$arr_days_of_week);

        }	

    }

    elseif($listing_date_type == 'single_date')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = '';

        $tr_date_range = 'none';

        $tr_month_date = 'none';



        if($single_date == '')

        {

            $error = true;

            $err_msg .= '<br>Please select single date';

        }	

    }

    elseif($listing_date_type == 'date_range')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = '';

        $tr_month_date = 'none';



        if($start_date == '')

        {

            $error = true;

            $err_msg .= '<br>Please select start date';

        }

        elseif($end_date == '')

        {

            $error = true;

            $err_msg .= '<br>Please select end date';

        }

        else

        {

            if(strtotime($start_date) > strtotime($end_date))

            {

                $error = true;

                $err_msg .= '<br>Please select end date greater than start date';

            }

        }	

    }

    elseif($listing_date_type == 'month_wise')

    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = '';

        

        //echo '<br><pre>';

        //print_r($arr_month);

        //echo '<br></pre>';

        

        if(count($arr_month) == 0)

        {

            $error = true;

            $err_msg .= '<br>Please select months';

        }

        else

        {

            $months = implode(',',$arr_month);

        }

    }

    
    

    if($item_error)

    {

        $error = true;

        $err_msg .= '<br>Please select Item';

    }



    if($cat_error)

    {

        $error = true;

        $err_msg .= '<br>Please select category';

    }

    

    if(!$error)

    {

        

        if($listing_date_type == 'days_of_month')

        {

            $single_date = '';

            $start_date = '';

            $end_date = '';

            $days_of_week = '';

            $months = '';

        }

        elseif($listing_date_type == 'days_of_week')

        {

            $single_date = '';

            $start_date = '';

            $end_date = '';

            $days_of_month = '';

            $months = '';

        }

        elseif($listing_date_type == 'single_date')

        {

            $days_of_month = '';

            $start_date = '';

            $end_date = '';

            $days_of_week = '';

            $months = '';



            $single_date = date('Y-m-d',strtotime($single_date));

        }

        elseif($listing_date_type == 'date_range')

        {

            $days_of_month = '';

            $single_date = '';

            $days_of_week = '';

            $months = '';



            $start_date = date('Y-m-d',strtotime($start_date));

            $end_date = date('Y-m-d',strtotime($end_date));

        }

        elseif($listing_date_type == 'month_wise')

        {

            $days_of_month = '';

            $single_date = '';

            $days_of_week = '';

            $start_date = '';

            $end_date = '';

        }

        else

        {

            $single_date = '';

            $start_date = '';

            $end_date = '';

            $days_of_month = '';

            $days_of_week = '';

            $months = '';

        }

        

        

        
//
//        if($obj->addSolution($arr_prct_id,$arr_sol_cat_id,$arr_sol_item_id,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$months))
//
//        {
//
//            $msg = "Record Added Successfully!";
//
//            header('location: index.php?mode=wellness_solutions&msg='.urlencode($msg));
//
//        }
//
//        else
//
//        {
//
//            $error = true;
//
//            $err_msg = "Currently there is some problem.Please try again later.";
//
//        }

        

        

    }	



else

{

    $prct_ref_no = '';

    $listing_date_type = '';

    $days_of_month = '';

    $single_date = '';

    $start_date = '';

    $end_date = '';

    $days_of_week = '';

    $months = '';

    $arr_min_rating[0] = '0';

    $arr_max_rating[0] = '0';

    $arr_sol_cat_id[0] = '';

    $arr_sol_item_id[0] = array();

}


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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Goals and Query</td>
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
                            <input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
			<input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count;?>" >
                                                        				
                            <input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                                            
							<tbody>
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
                                            <select name="healcareandwellbeing" id="healcareandwellbeing" style="width:150px;">
                                               
                                                 <?php echo $obj1->getFavCategoryRamakant('42',$fav_cat_id)?>
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
                                                 <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>Referral Details:</strong></td>
                                             <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                   <td width="10%" height="30" align="left" valign="middle"><strong>Referred By&nbsp;&nbsp;(Practitioner/Adviser)::</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                          
                                     
                                            <input name="referred_by" type="text" id="referred_by<?php echo $i;?>" onkeyup="suggestionsearch1(<?php echo $i;?>); return false;" style="width:350px; height: 25px;">
                                        </td>
                                             <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>

                                                                 <td width="10%" height="30" align="left" valign="middle"><strong>Referred From&nbsp;&nbsp;(Institution/Clinic):</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                          
                                     
                                            <input name="referred_from" type="text" id="referred_from<?php echo $i;?>" onkeyup="suggestionsearch(<?php echo $i;?>); return false;" style="width:350px; height: 25px;">
                                        </td>

                                             <tr>
                                                  <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                   
<!--                                                  <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>Interpretation System Details:</strong></td>-->
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
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                 <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>Patient Details:</strong></td>
                            	                               
                                            <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
                                             <td width="10%" height="30" align="left" valign="middle"><strong>Patient Name:</strong></td>
                                            <td>
                                                <select name="patient_name" id="patient_name" style="width:150px;" onchange="getMainCategoryOptionAddMore()">
                                                    <option value="">All Type</option>
                                                       <?php echo $obj->getUsers($name); ?>
                                                </select>
                                            </td>
                                          
                                                                <td width="5%" height="30" align="left" valign="middle"><strong>Registration Id:</strong></td>
                                            <td>
                                                <input type="text" id="reg_id" name="reg_id" style="width:150px;" value="<?php echo $search; ?>" />
                                            </td>
  
                                                  <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                <td width="10%" height="30" align="left" valign="middle"><strong>Gender:</strong></td>
                                            <td>
                                                <select name="gender" id="gender" style="width:150px;" onchange="getMainCategoryOptionAddMore()">
                                                    <option value="">All Type</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    
                                                </select>
                                               
                                                                <td width="10%" height="30" align="left" valign="middle"><strong>Age&nbsp;&nbsp;(Years):</strong></td>
                                            <td>
                                                <select name="age" id="age" style="width:150px;" onchange="getMainCategoryOptionAddMore()">
                                                    <option value="">Age</option>
                                                    <?php for($i=1;$i<61;$i++){?>
                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>
                                                   
                                                    
                                                </select>
                                            </td>
                                            
                                             
                                            
					   <tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                                <td width="5%" height="30" align="left" valign="middle"><strong>Test No:</strong></td>
                                            <td>
                                                <input type="text" id="test_no" name="test_no" style="width:150px;" value="<?php echo $search; ?>" />
                                            </td>
                                                                <td width="5%" height="30" align="left" valign="middle"><strong>Test/Investigation Date:</strong></td>
                                            <td>
                                              
                                                <input type="Date" id="test_date" name="test_date" style="width:150px;"/>
                                            </td>
                                                                                              <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                                 <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>ABC Details:</strong></td>
                                             <tr>
                                                            <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                            	  <tr>
									<td align="right"><strong>User Interaction Type</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="user_interaction_type" id="user_interaction_type" style="width:200px;">
                                                                                       <option value="">All Type</option>
											<option value="goals">Goals</option>
                                                                                        <option value="query">Query</option>
		                                   	
                                        </select>
                                   	</td>
								</tr>
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
                                                                               <option value="">Select Symptom Name</option>
                                                                                <?php echo $obj1->getFavCategoryRamakant($arr_cucat_parent_cat_id,$arr_cucat_cat_id);?>
                                                                            </select>
                                                                            </td>
                                                                       
                                                                            </tr>
                                                                        </table>
                                                                            
                                                                    </td>
									
								</tr>
                                                                
                                                                <tr>
                                                                    	<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                  
                                                                 
                                                                                            	<tr>
									<td width="30%" align="right" valign="top"><strong>Question</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="65%" align="left" valign="top">
										<textarea name="question" id="question" rows="5" cols="25" ><?php echo $question;?></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Family - Question</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="situation_font_family" id="situation_font_family" style="width:200px;">
											<option value="">Select Font Family</option>
		                                   	<?php echo $obj6->getFontFamilyOptions($situation_font_family); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Size - Question</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="situation_font_size" id="situation_font_size" style="width:200px;">
											<option value="">Select Font Size</option>
		                                   	<?php echo $obj->getFontSizeOptions($situation_font_size); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Color - Question</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <input type="text" class="color"  id="situation_font_color" name="situation_font_color" value="<?php echo $situation_font_color; ?>"/>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>

                                    <tr>

                                        <td align="right"><strong>Date Selection Type</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select name="listing_date_type" id="listing_date_type" onchange="toggleDateSelectionType('listing_date_type')" style="width:200px;">

                                        	<option value="">All</option>

                                                <option value="days_of_month" <?php if($listing_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>

                                                <option value="single_date" <?php if($listing_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>

                                                <option value="date_range" <?php if($listing_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>

                                                <option value="month_wise" <?php if($listing_date_type == 'month_wise') { ?> selected="selected" <?php } ?>>Month Wise</option>

                                                <option value="days_of_week" <?php if($listing_date_type == 'days_of_week') { ?> selected="selected" <?php } ?>>Days of Week</option>

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

                                    <tr id="tr_days_of_week" style="display:<?php echo $tr_days_of_week;?>">

                                        <td align="right" valign="top"><strong>Select days of week</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td align="left">

                                            <select id="days_of_week" name="days_of_week[]" multiple="multiple" style="width:200px;">

                                            <?php echo $obj1->getDayOfWeekOptionsMultiple($arr_days_of_week); ?>	

                                            </select>&nbsp;*<br>

                                            You can choose more than one option by using the ctrl key.

                                        </td>

                                    </tr>

                                    <tr id="tr_month_date" style="display:<?php echo $tr_month_date;?>">

                                        <td align="right" valign="top"><strong>Select Month</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td align="left">

                                            <select id="months" name="months[]" multiple="multiple" style="width:200px;">

                                            <?php echo $obj1->getMonthsOptionsMultiple($arr_month); ?>	

                                            </select>&nbsp;*<br>

                                            You can choose more than one option by using the ctrl key.

                                        </td>

                                    </tr>
                                    	<tr>
									<td colspan="9" align="center">&nbsp;</td>
								</tr>
                                                 <td width="10%" height="40" align="left" valign="middle" style="color:red"><strong>Customisation Details:</strong></td>
                                                
                                                 <td width="10%" height="40" align="left" valign="middle" >(SET below your User, Keyword & Date preferences):</td>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                              
                                                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <td align="right"><strong>Share Type:</strong></td>
                                                                <td align="center"><strong>:</strong></td>

                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="share_type" id="share_type" style="width:200px;">
                                                    <?php echo $obj1->getFavCategoryRamakant('49','')?>
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
                            <?php //
//							for($i=0;$i<$row_totalRow;$i++)
//							{  ?>
<!--								<tr id="row_id_1_<?php echo $i;?>">
									<td align="right"><strong>Rating</strong></td>
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
								<tr id="row_id_4_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr id="row_id_5_<?php echo $i;?>">
									<td align="right" valign="top"><strong>Interpretation</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<textarea name="interpretaion[]" id="interpretaion_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_interpretaion[$i]; ?></textarea>
									</td>
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
								</tr>-->
							<?php
//							} ?>
<!--                                <tr id="add_before_this_row">
                                    <td align="right" valign="top">&nbsp;</td>
                            	    <td align="center" valign="top">&nbsp;</td>
                                    <td align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreRows">Add More Rating</a></td>
                                </tr>	-->
                                
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
   // alert(num);
    var availableTags = [
        <?php echo $tdata; ?>
    ];


    $( "#referred_from"+num).autocomplete({
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
   function suggestionsearch1(num) {
   // alert(num);
    var availableTags = [
        <?php echo $tdata1; ?>
    ];


    $( "#referred_by"+num).autocomplete({
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
                        //alert(sub_cat);
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
  
        </script>
</div>