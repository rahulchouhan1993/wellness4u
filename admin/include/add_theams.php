<?php
require_once('config/class.mysql.php');
require_once('classes/class.theams.php');  
require_once('../init.php');
$obj = new Theams();

$add_action_id = '99';
require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

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
	$theam_name = strip_tags(trim($_POST['theam_name']));
        
        $listing_date_type = strip_tags(trim($_POST['listing_date_type']));
        $days_of_month = strip_tags(trim($_POST['days_of_month']));
        $single_date = strip_tags(trim($_POST['single_date']));
        $start_date = strip_tags(trim($_POST['start_date']));
        $end_date = strip_tags(trim($_POST['end_date']));
        $days_of_week = strip_tags(trim($_POST['days_of_week']));
        $months = strip_tags(trim($_POST['months']));
	$image 		= strip_tags(trim($_POST['image']));
	$credit 	= strip_tags(trim($_POST['credit']));
	$credit_url = strip_tags(trim($_POST['credit_url'])); 
	$color_code 	= strip_tags(trim($_POST['color_code']));
	$identity_id = $_SESSION['admin_id'];
    

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


//
//    if(count($arr_prct_id) == 0)
//
//    {
//
//        $error = true;
//
//        $err_msg = 'Please select Situation/Trigger';
//
//    }


//	if($icons_type_id == "")
//	{
////		$error = true;
////		$err_msg = "Please enter details";
//	}
	if($theam_name == "")
	{
		$error = true;
		$err_msg = "Please Enter  Name.";
	}
	
//	if($day == "")
//	{
////		$error = true;
////		$err_msg .= "<br>Please Select Day.";
//	}
	
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

		
	if($color_code == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Color Code.";
	}
	
		
			if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '')
			{
			
				$image = basename($_FILES['image']['name']);
				
				$type_of_uploaded_file =substr($image,strrpos($image, '.') + 1);
				$target_size = $_FILES['image']['size']/1024;
					
				$max_allowed_file_size = 1000; // size in KB
				$target_type = array("jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG");
			
					if($target_size > $max_allowed_file_size )
					{
						$error = true;
						$err_msg .=  "\n Size of file should be less than $max_allowed_file_size kb";
					}
			
				$allowed_ext = false;
					for($i=0; $i<count($target_type); $i++)
					{
						if(strcasecmp($target_type[$i],$type_of_uploaded_file) == 0)
						{
							$allowed_ext = true;
						}
					  
					}
			
				if(!$allowed_ext)
				{
					$error = true;
					
					$err_msg .= "\n The uploaded file is not supported file type. ".
							   "<br>Only the following file types are supported: ".implode(',',$target_type);
				}
		
				if(!$error)
				{
					
					$target_path = SITE_PATH."/uploads/";
					$image = time().'_'.$image;
					$target_path = $target_path .$image;
				
					
					if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path))
						{		    
					
						} 
					else
						{
							$error = true;
							$err_msg .= '<br>File Not Uploaded. Please Try Again Later';
						}
				
				}
		
	}	
	else
		{
		  $error = true; 
		  $err_msg .= '<br>Please upload Image'; 
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
				if($obj->Add_Theams($identity_id,$theam_name,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$months,$color_code,$image,$credit,$credit_url,$day))
					{
						$msg = "Record Added Successfully!";
						header('location: index.php?mode=theams&msg='.urlencode($msg));
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
		$credit_url = 'http://';
		$arr_day = array();
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
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jscolor.js"></script>
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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Theam</td>
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
							<form action="#" method="post" name="frmadd_theams" id="frmadd_theams" enctype="multipart/form-data" >
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                            	<tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>
                                                            
                                                            
                                                            <tr>
									<td width="20%" align="right"><strong>Theam Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="theam_name" name="theam_name" value="<?php echo $theam_name; ?>"/>
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

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Credit</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit" name="credit" value="<?php echo $credit; ?>"/>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Credit URL</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit_url" name="credit_url" value="<?php echo $credit_url; ?>"/>&nbsp;(Please enter link like http://www.google.com)
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Color Code</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text" class="color"  id="color_code" name="color_code" value="<?php echo $color_code; ?>"/>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
                                   <td align="right"><strong>Upload Image</strong>
                                    <td align="center"><strong>:</strong></td>
                                    <td><input name="image" type="file" id="image" />
                                     </td>
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
</div>