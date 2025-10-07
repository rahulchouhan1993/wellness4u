<?php 
include('classes/config.php');
$page_id = '45';
$obj = new frontclass();

$page_data = $obj->getPageDetails($page_id);

$ref = base64_encode($page_data['menu_link']);

if(!$obj->isLoggedIn())

{

	$obj->doUpdateOnline($_SESSION['user_id']);
        //echo "<script>window.location.href='user_dashboard.php'</script>";
	header("Location: login.php?ref=".$ref);
        exit();

}
 else {
     $user_id = $_SESSION['user_id'];
     $obj->doUpdateOnline($_SESSION['user_id']);
}

$now = time();
$today_year = date("Y",$now);
$today_month = date("m",$now);
$today_day = date("d",$now); 

if(isset($_POST['btnSubmit']))	

{

    $day = trim($_POST['day']);

    $month = trim($_POST['month']);

    $year = trim($_POST['year']);

    $totalRow = trim($_POST['totalRow']);

    $cnt = $totalRow;

    

    $totalRow_t = trim($_POST['totalRow_t']);

    $cnt_t = $totalRow_t;

    

    $bes_time = trim($_POST['bes_time']);

    $bes_duration = trim($_POST['bes_duration']);

    

    $display_goto = 'none';

    $display_submit = '';

    $div_trigger = '';



    list($scale,$scale_add,$scale_rest,$scale_cnt,$scale_arr_rest,$scale_arr) = getMultipleFieldsValueByComma('scale');

    list($scale_t,$scale_t_add,$scale_t_rest,$scale_t_cnt,$scale_t_arr_rest,$scale_t_arr) = getMultipleFieldsValueByComma('scale_t');

    list($remarks_t,$remarks_t_add,$remarks_t_rest,$remarks_t_cnt,$remarks_t_arr_rest,$remarks_t_arr) = getMultipleFieldsValueByComma('remarks_t');

    

    if( ($day == '') || ($month == '') || ($year == '') )

    {

        $error = true;

        $tr_err_bes_date = '';

        $err_bes_date = 'Please select date!';

    }

    elseif(!checkdate($month,$day,$year))

    {

        $error = true;

        $tr_err_bes_date = '';

        $err_bes_date = 'Please select valid date!';

    }

    elseif(mktime(0,0,0,$month,$day,$year) > $now)

    {

        $error = true;

        $tr_err_bes_date = '';

        $err_bes_date = 'Please select today or previous date!';

    }

    else

    {

        $bes_date = $year.'-'.$month.'-'.$day;

    }

        

    //echo'<br><pre>';

    //print_r($_POST);

    //echo'<br></pre>';

    

    $empty_selected_bms_id_arr = true;

    for($i=0;$i<$totalRow;$i++)

    {

        if(isset($_POST['as_values_bes_id_'.$i]))

        {

            $selected_bes_id = strip_tags(trim($_POST['as_values_bes_id_'.$i]));

            //echo '<br>bes_id = '.$selected_bes_id;

            if($selected_bes_id != '')

            {

                $empty_selected_bms_id_arr = false;

                $tr_response_img[$i] = 'none';

                $tr_response_slider[$i] = '';

                

                $bms_id = strip_tags(trim($_POST['as_values_bes_id_'.$i]));



                $bms_id = str_replace(",", "", $bms_id);

                $temp_arr_bmst = explode('_',$bms_id);

                

                

                //$bmst_id = getBobyMainSymptomType($bms_id);

                $bmst_id = $temp_arr_bmst[0];

                $bms_id = $temp_arr_bmst[1];

                

                array_push($bms_id_arr,$bms_id);

                array_push($bms_type_arr,$bmst_id);

                

                if($bms_id == '') 

                {

                    array_push($bes_prefill_arr ,'{}');

                }

                else

                { 

                    /*

                    $json = array();

                    $json['value'] = $bms_id;

                    $json['name'] = getBobyMainSymptomName($bms_id);

                    array_push($bes_prefill_arr ,json_encode($json));

                    */

                    

                    

                    $json = array();

                    $json['value'] = $bms_id;

                    if($temp_arr_bmst[0] == 'adct')

                    {

                        $json['name'] = getADCTSituation($temp_arr_bmst[1]);

                    }

                    elseif($temp_arr_bmst[0] == 'sleep')

                    {

                        $json['name'] = getSleepSituation($temp_arr_bmst[1]);

                    }

                    elseif($temp_arr_bmst[0] == 'gs')

                    {

                        $json['name'] = getGSSituation($temp_arr_bmst[1]);

                    }

                    elseif($temp_arr_bmst[0] == 'wae')

                    {

                        $json['name'] = getWAESituation($temp_arr_bmst[1]);

                    }

                    elseif($temp_arr_bmst[0] == 'mc')

                    {

                        $json['name'] = getMCSituation($temp_arr_bmst[1]);

                    }

                    elseif($temp_arr_bmst[0] == 'mr')

                    {

                        $json['name'] = getMRSituation($temp_arr_bmst[1]);

                    }

                    elseif($temp_arr_bmst[0] == 'mle')

                    {

                        $json['name'] = getMLESituation($temp_arr_bmst[1]);

                    }

                    else 

                    {

                        $json['name'] = getBobyMainSymptomName($temp_arr_bmst[1]);    

                    }





                    array_push($bes_prefill_arr ,json_encode($json));

                }	



                $temp_err = '';

                $temp_tr_err = 'none';





                if( ($bms_id == '') )

                {

                    //$error = true;

                    //$temp_tr_err = '';

                    //$temp_err = 'Please enter your emotional state item!';

                }

                elseif(!chkBMSExists($bms_id,$temp_arr_bmst[0]))

                {

                    $error = true;

                    $temp_tr_err = '';

                    $temp_err = 'Sorry this situation is not available.Please select item from auto suggest list!';

                    $err_msg .= '<br>'.$temp_err; 

                }



                if($temp_err != '')

                {

                    $temp_err = '<div class="err_msg_box"><span class="blink_me">'.$temp_err.'</span></div>';

                }



                array_push($tr_err_bes , $temp_tr_err);

                array_push($err_bes , $temp_err);

            }

            else

            {

                $tr_response_img[$i] = '';

                $tr_response_slider[$i] = 'none';

                array_push($bes_prefill_arr ,'{}');

                array_push($bms_id_arr,'');

                array_push($bms_type_arr,'');

            }

        }

        else

        {

            $tr_response_img[$i] = '';

            $tr_response_slider[$i] = 'none';

            array_push($bes_prefill_arr ,'{}');

            array_push($bms_id_arr,'');

            array_push($bms_type_arr,'');

        }

    }

        

    if($empty_selected_bms_id_arr)

    {

        $error = true;

        $err_msg = 'Please enter atleast one current situation!';

    }

     

    

    

    $empty_selected_trigger_id_arr = true;

    for($i=0;$i<$totalRow_t;$i++)

    {

        if(isset($_POST['as_values_trigger_id_'.$i]))

        {

            $selected_trigger_id = strip_tags(trim($_POST['as_values_trigger_id_'.$i]));

            if($selected_trigger_id != '')

            {

                $empty_selected_trigger_id_arr = false;

                $tr_response_img_t[$i] = 'none';

                $tr_response_slider_t[$i] = '';

                

                $trigger_id = strip_tags(trim($_POST['as_values_trigger_id_'.$i]));



                $trigger_id = str_replace(",", "", $trigger_id);



                $temp_arr_tri = explode('_',$trigger_id);



                array_push($trigger_id_arr,$temp_arr_tri[1]);

                array_push($trigger_type_arr,$temp_arr_tri[0]);



                if($trigger_id == '') 

                {

                    array_push($trigger_prefill_arr ,'{}');

                }

                else

                { 

                    $json = array();

                    $json['value'] = $trigger_id;

                    if($temp_arr_tri[0] == 'adct')

                    {

                        $json['name'] = getADCTSituation($temp_arr_tri[1]);

                    }

                    elseif($temp_arr_tri[0] == 'sleep')

                    {

                        $json['name'] = getSleepSituation($temp_arr_tri[1]);

                    }

                    elseif($temp_arr_tri[0] == 'gs')

                    {

                        $json['name'] = getGSSituation($temp_arr_tri[1]);

                    }

                    elseif($temp_arr_tri[0] == 'wae')

                    {

                        $json['name'] = getWAESituation($temp_arr_tri[1]);

                    }

                    elseif($temp_arr_tri[0] == 'mc')

                    {

                        $json['name'] = getMCSituation($temp_arr_tri[1]);

                    }

                    elseif($temp_arr_tri[0] == 'mr')

                    {

                        $json['name'] = getMRSituation($temp_arr_tri[1]);

                    }

                    elseif($temp_arr_tri[0] == 'mle')

                    {

                        $json['name'] = getMLESituation($temp_arr_tri[1]);

                    }

                    else 

                    {

                        $json['name'] = getBobyMainSymptomName($temp_arr_tri[1]);    

                    }





                    array_push($trigger_prefill_arr ,json_encode($json));

                }	



                $temp_err = '';

                $temp_tr_err = 'none';





                if( ($trigger_id == '') )

                {

                    //$error = true;

                    //$temp_tr_err = '';

                    //$temp_err = 'Please enter your emotional state item!';

                }

                elseif(!chkBMSExists($bms_id))

                {

                    //$error = true;

                    //$temp_tr_err = '';

                    //$temp_err = 'Sorry this situation is not available.Please select item from auto suggest list!';

                    //$err_msg .= '<br>'.$temp_err; 

                }



                if($temp_err != '')

                {

                    $temp_err = '<div class="err_msg_box"><span class="blink_me">'.$temp_err.'</span></div>';

                }



                array_push($tr_err_bes , $temp_tr_err);

                array_push($err_bes , $temp_err);

            }

            else

            {

                $tr_response_img_t[$i] = '';

                $tr_response_slider_t[$i] = 'none';

                array_push($trigger_prefill_arr ,'{}');

                array_push($trigger_id_arr,'');

                array_push($trigger_type_arr,'');

            }

        }

        else 

        {

            $tr_response_img_t[$i] = '';

            $tr_response_slider_t[$i] = 'none';

            array_push($trigger_prefill_arr ,'{}');

            array_push($trigger_id_arr,'');

            array_push($trigger_type_arr,'');

        }

        

    }

        

    if($empty_selected_trigger_id_arr)

    {

        $error = true;

        $err_msg .= '<br>Please enter atleast one current trigger!';

    }

    

    if($bes_time == '')

    {

        $error = true;

        $err_msg .= '<br>Please select time!';

    }

    

    if($bes_duration == '')

    {

        //$error = true;

        //$err_msg .= '<br>Please enter duration in mins!';

    }

    

        

    if(!$error)

    {

        $addUsersMDT = addUsersMDT($user_id,$bes_date,$bms_id_arr,$bms_type_arr,$scale_arr,$bes_time,$bes_duration,$trigger_id_arr,$trigger_type_arr,$scale_t_arr,$remarks_t_arr);

        if($addUsersMDT)

        {

//             header("Location: message.php?msg=14");	
             echo "<script>window.location.href='message.php?msg=14'</script>";

/*

//header("Location: message.php?msg=14&gotopage=".$page_id); 

            header("Location: my_wellness_solutions.php?mid=".$page_id."&date=".$bes_date); 

            exit(0);

*/

        }

        else

        {

            $error = true;

            $err_msg = 'There is some problem right now!Please try again later';

        }

    }

    

    if($err_msg != '')

    {

        $err_msg = '<div class="err_msg_box"><span class="blink_me">'.$err_msg.'</span></div>';

    }

}

elseif(isset($_POST['btnUpdate']))	

{

    $divaddformmdt = 'none';

    $diveditformmdt = '';

    

    $day = trim($_POST['day']);

    $month = trim($_POST['month']);

    $year = trim($_POST['year']);

    

    $cnt_main = trim($_POST['cnt_main']);

    

    

    if( ($day == '') || ($month == '') || ($year == '') )

    {

        $error = true;

        $tr_err_bes_date = '';

        $err_bes_date = 'Please select date!';

    }

    elseif(!checkdate($month,$day,$year))

    {

        $error = true;

        $tr_err_bes_date = '';

        $err_bes_date = 'Please select valid date!';

    }

    elseif(mktime(0,0,0,$month,$day,$year) > $now)

    {

        $error = true;

        $tr_err_bes_date = '';

        $err_bes_date = 'Please select today or previous date!';

    }

    else

    {

        $bes_date = $year.'-'.$month.'-'.$day;

    }

        

    //echo'<br><pre>';

    //print_r($_POST);

    //echo'<br></pre>';

    

    list($bes_time_edit,$bes_time_edit_add,$bes_time_edit_rest,$bes_time_edit_cnt,$bes_time_edit_arr_rest,$bes_time_edit_arr) = getMultipleFieldsValueByComma('bes_time_edit');

    list($bes_duration_edit,$bes_duration_edit_add,$bes_duration_edit_rest,$bes_duration_edit_cnt,$bes_duration_edit_arr_rest,$bes_duration_edit_arr) = getMultipleFieldsValueByComma('bes_duration_edit');

        

    for($i=0;$i<count($bes_time_edit_arr);$i++)

    {

        if($bes_time_edit_arr[$i] == '')

        {

            $error = true;

            $err_msg .= '<br>Please select time!';

            break;

        }

    }

    

    foreach ($_POST['cnt_edit'] as $key => $value) 

    {

        array_push($cnt_edit_arr, $value);

    }

    

    foreach ($_POST['totalRow_edit'] as $key => $value) 

    {

        array_push($totalRow_edit_arr, $value);

    }

    

    foreach ($_POST['cnt_t_edit'] as $key => $value) 

    {

        array_push($cnt_t_edit_arr, $value);

    }

    

    foreach ($_POST['totalRow_t_edit'] as $key => $value) 

    {

        array_push($totalRow_t_edit_arr, $value);

    }

    

    for($i=0;$i<$cnt_main;$i++)

    {

        if($bes_time_edit_arr[$i] == '')

        {

            $error = true;

            $err_msg .= '<br>Please select time!';

            break;

        }

    }

    

    $empty_selected_bms_id_arr = true;

    $empty_selected_trigger_id_arr = true;

    for($i=0;$i<$cnt_main;$i++)

    {

        for($j=0;$j<$totalRow_edit_arr[$i];$j++)

        {

            if(isset($_POST['scale_edit_'.$i.'_'.$j]))

            {

                $scale_edit_arr[$i][$j] = trim($_POST['scale_edit_'.$i.'_'.$j]);

            }

            else

            {

                $scale_edit_arr[$i][$j] = '0';

            }

            

            if(isset($_POST['as_values_bes_id_edit_'.$i.'_'.$j]))

            {

                $selected_bes_id = strip_tags(trim($_POST['as_values_bes_id_edit_'.$i.'_'.$j]));

                if($selected_bes_id != '')

                {

                    $empty_selected_bms_id_arr = false;

                    $tr_response_img_edit[$i][$j] = 'none';

                    $tr_response_slider_edit[$i][$j] = '';



                    $bms_id = strip_tags(trim($_POST['as_values_bes_id_edit_'.$i.'_'.$j]));



                    /*

                    $bms_id = str_replace(",", "", $bms_id);

                    $bmst_id = getBobyMainSymptomType($bms_id);

                    

                    $bms_id_edit_arr[$i][$j] = $bms_id;

                    $bms_type_edit_arr[$i][$j] = $bmst_id;

                    

                    if($bms_id == '') 

                    {

                        $bes_prefill_edit_arr[$i][$j] = '{}';

                    }

                    else

                    { 

                        $json = array();

                        $json['value'] = $bms_id;

                        $json['name'] = getBobyMainSymptomName($bms_id);

                        $bes_prefill_edit_arr[$i][$j] = json_encode($json);

                    }	



                    $temp_err = '';

                    $temp_tr_err = 'none';





                    if( ($bms_id == '') )

                    {

                        //$error = true;

                        //$temp_tr_err = '';

                        //$temp_err = 'Please enter your emotional state item!';

                    }

                    elseif(!chkBMSExists($bms_id))

                    {

                        $error = true;

                        $temp_tr_err = '';

                        $temp_err = 'Sorry this situation is not available.Please select item from auto suggest list!';

                        $err_msg .= '<br>'.$temp_err; 

                    }

                     * 

                     */

                    

                    $bms_id = str_replace(",", "", $bms_id);

                    $temp_arr_bmst = explode('_',$bms_id);





                    //$bmst_id = getBobyMainSymptomType($bms_id);

                    $bmst_id = $temp_arr_bmst[0];

                    $bms_id = $temp_arr_bmst[1];

                    

                    $bms_id_edit_arr[$i][$j] = $bms_id;

                    $bms_type_edit_arr[$i][$j] = $bmst_id;



                    

                    if($bms_id == '') 

                    {

                        $bes_prefill_edit_arr[$i][$j] = '{}';

                    }

                    else

                    { 

                        /*

                        $json = array();

                        $json['value'] = $bms_id;

                        $json['name'] = getBobyMainSymptomName($bms_id);

                        array_push($bes_prefill_arr ,json_encode($json));

                        */





                        $json = array();

                        $json['value'] = $bms_id;

                        if($temp_arr_bmst[0] == 'adct')

                        {

                            $json['name'] = getADCTSituation($temp_arr_bmst[1]);

                        }

                        elseif($temp_arr_bmst[0] == 'sleep')

                        {

                            $json['name'] = getSleepSituation($temp_arr_bmst[1]);

                        }

                        elseif($temp_arr_bmst[0] == 'gs')

                        {

                            $json['name'] = getGSSituation($temp_arr_bmst[1]);

                        }

                        elseif($temp_arr_bmst[0] == 'wae')

                        {

                            $json['name'] = getWAESituation($temp_arr_bmst[1]);

                        }

                        elseif($temp_arr_bmst[0] == 'mc')

                        {

                            $json['name'] = getMCSituation($temp_arr_bmst[1]);

                        }

                        elseif($temp_arr_bmst[0] == 'mr')

                        {

                            $json['name'] = getMRSituation($temp_arr_bmst[1]);

                        }

                        elseif($temp_arr_bmst[0] == 'mle')

                        {

                            $json['name'] = getMLESituation($temp_arr_bmst[1]);

                        }

                        else 

                        {

                            $json['name'] = getBobyMainSymptomName($temp_arr_bmst[1]);    

                        }





                        $bes_prefill_edit_arr[$i][$j] = json_encode($json);

                    }	



                    $temp_err = '';

                    $temp_tr_err = 'none';





                    if( ($bms_id == '') )

                    {

                        //$error = true;

                        //$temp_tr_err = '';

                        //$temp_err = 'Please enter your emotional state item!';

                    }

                    elseif(!chkBMSExists($bms_id,$temp_arr_bmst[0]))

                    {

                        $error = true;

                        $temp_tr_err = '';

                        $temp_err = 'Sorry this situation is not available.Please select item from auto suggest list!';

                        $err_msg .= '<br>'.$temp_err; 

                    }



                    if($temp_err != '')

                    {

                        $temp_err = '<div class="err_msg_box"><span class="blink_me">'.$temp_err.'</span></div>';

                    }



                    array_push($tr_err_bes , $temp_tr_err);

                    array_push($err_bes , $temp_err);

                    

                    if($temp_err != '')

                    {

                        $temp_err = '<div class="err_msg_box"><span class="blink_me">'.$temp_err.'</span></div>';

                    }

                }

                else

                {

                    $tr_response_img_edit[$i][$j] = '';

                    $tr_response_slider_edit[$i][$j] = 'none';

                    $bes_prefill_edit_arr[$i][$j] = '{}';

                    $bms_id_edit_arr[$i][$j] = '';

                    $bms_type_edit_arr[$i][$j] = '';

                }

            }

            else

            {

                $tr_response_img_edit[$i][$j] = '';

                $tr_response_slider_edit[$i][$j] = 'none';

                $bes_prefill_edit_arr[$i][$j] = '{}';

                $bms_id_edit_arr[$i][$j] = '';

                $bms_type_edit_arr[$i][$j] = '';

            }

        } 

        

        for($j=0;$j<$totalRow_t_edit_arr[$i];$j++)

        {

            if(isset($_POST['scale_t_edit_'.$i.'_'.$j]))

            {

                $scale_t_edit_arr[$i][$j] = trim($_POST['scale_t_edit_'.$i.'_'.$j]);

            }

            else

            {

                $scale_t_edit_arr[$i][$j] = '0';

            }

            

            if(isset($_POST['remarks_t_edit_'.$i.'_'.$j]))

            {

                $remarks_t_edit_arr[$i][$j] = urldecode(trim($_POST['remarks_t_edit_'.$i.'_'.$j]));

            }

            else

            {

                $remarks_t_edit_arr[$i][$j] = '';

            }

            

            //echo'<br>11111111111 as_values_trigger_id_edit_'.$i.'_'.$j;

            if(isset($_POST['as_values_trigger_id_edit_'.$i.'_'.$j]))

            {

                

                $selected_trigger_id = strip_tags(trim($_POST['as_values_trigger_id_edit_'.$i.'_'.$j]));

                if($selected_trigger_id != '')

                {

                    $empty_selected_trigger_id_arr = false;

                    $tr_response_img_t_edit[$i][$j] = 'none';

                    $tr_response_slider_t_edit[$i][$j] = '';



                    $trigger_id = strip_tags(trim($_POST['as_values_trigger_id_edit_'.$i.'_'.$j]));



                    $trigger_id = str_replace(",", "", $trigger_id);

                    

                    $temp_arr_tri = explode('_',$trigger_id);



                    $trigger_id_edit_arr[$i][$j] = $temp_arr_tri[1];

                    $trigger_type_edit_arr[$i][$j] = $temp_arr_tri[0];

                    

                    if($trigger_id == '') 

                    {

                        $trigger_prefill_edit_arr[$i][$j] = '{}';

                    }

                    else

                    { 

                        $json = array();

                        $json['value'] = $trigger_id;

                        if($temp_arr_tri[0] == 'adct')

                        {

                            $json['name'] = getADCTSituation($temp_arr_tri[1]);

                        }

                        elseif($temp_arr_tri[0] == 'sleep')

                        {

                            $json['name'] = getSleepSituation($temp_arr_tri[1]);

                        }

                        elseif($temp_arr_tri[0] == 'gs')

                        {

                            $json['name'] = getGSSituation($temp_arr_tri[1]);

                        }

                        elseif($temp_arr_tri[0] == 'wae')

                        {

                            $json['name'] = getWAESituation($temp_arr_tri[1]);

                        }

                        elseif($temp_arr_tri[0] == 'mc')

                        {

                            $json['name'] = getMCSituation($temp_arr_tri[1]);

                        }

                        elseif($temp_arr_tri[0] == 'mr')

                        {

                            $json['name'] = getMRSituation($temp_arr_tri[1]);

                        }

                        elseif($temp_arr_tri[0] == 'mle')

                        {

                            $json['name'] = getMLESituation($temp_arr_tri[1]);

                        }

                        else 

                        {

                            $json['name'] = getBobyMainSymptomName($temp_arr_tri[1]);    

                        }



                        $trigger_prefill_edit_arr[$i][$j] = json_encode($json);

                    }

                }

                else

                {

                    $tr_response_img_t_edit[$i][$j] = '';

                    $tr_response_slider_t_edit[$i][$j] = 'none';

                    $trigger_prefill_edit_arr[$i][$j] = '{}';

                    $trigger_id_edit_arr[$i][$j] = '';

                    $trigger_type_edit_arr[$i][$j] = '';

                }

            }

            else

            {

                $tr_response_img_t_edit[$i][$j] = '';

                $tr_response_slider_t_edit[$i][$j] = 'none';

                $trigger_prefill_edit_arr[$i][$j] = '{}';

                $trigger_id_edit_arr[$i][$j] = '';

                $trigger_type_edit_arr[$i][$j] = '';

            }

        } 

    }

        

    if($empty_selected_bms_id_arr)

    {

        $error = true;

        $err_msg .= '<br>Please enter atleast one current situation!';

    }

        

    if($empty_selected_trigger_id_arr)

    {

        $error = true;

        $err_msg .= '<br>Please enter atleast one current trigger!';

    }

    

        

    if(!$error)

    {

        $arr_bms_id = array();

        $arr_bms_type = array();

        $arr_bms_entry_type = array();

        $arr_scale = array();

        $arr_remarks = array();

        $arr_mdt_time = array();

        $arr_mdt_duration = array();

        for($i=0;$i<$cnt_main;$i++)

        {

            for($j=0;$j<$totalRow_edit_arr[$i];$j++)

            {

                array_push($arr_bms_id , $bms_id_edit_arr[$i][$j]);

                array_push($arr_bms_type , $bms_type_edit_arr[$i][$j]);

                array_push($arr_bms_entry_type , 'situation');

                array_push($arr_scale , $scale_edit_arr[$i][$j]);

                array_push($arr_remarks , '');

                array_push($arr_mdt_time , $bes_time_edit_arr[$i]);

                array_push($arr_mdt_duration , $bes_duration_edit_arr[$i]);

            }

            

            for($j=0;$j<$totalRow_t_edit_arr[$i];$j++)

            {

                array_push($arr_bms_id , $trigger_id_edit_arr[$i][$j]);

                array_push($arr_bms_type , $trigger_type_edit_arr[$i][$j]);

                array_push($arr_bms_entry_type , 'trigger');

                array_push($arr_scale , $scale_t_edit_arr[$i][$j]);

                array_push($arr_remarks , $remarks_t_edit_arr[$i][$j]);

                array_push($arr_mdt_time , $bes_time_edit_arr[$i]);

                array_push($arr_mdt_duration , $bes_duration_edit_arr[$i]);

            }

        }

        

        

        $addUsersMDT = updateUsersMDT($user_id,$bes_date,$arr_bms_id,$arr_bms_type,$arr_bms_entry_type,$arr_scale,$arr_remarks,$arr_mdt_time,$arr_mdt_duration);

        if($addUsersMDT)

        {

//            header("Location: message.php?msg=14");
            echo "<script>window.location.href='message.php?msg=14'</script>";

/*

            //header("Location: message.php?msg=14&gotopage=".$page_id); 

            header("Location: my_wellness_solutions.php?mid=".$page_id."&date=".$bes_date); 

            exit(0);

*/

        }

        else

        {

            $error = true;

            $err_msg = 'There is some problem right now!Please try again later';

        }

    }

    

    if($err_msg != '')

    {

        $err_msg = '<div class="err_msg_box"><span class="blink_me">'.$err_msg.'</span></div>';

    }

    

    $cnt = '1';

    $totalRow = '1';

    $cnt_t = '1';

    $totalRow_t = '1';

    $tr_err_bes[0] = 'none';

    $err_bes[0] = '';

    array_push($bes_prefill_arr ,'{}');

    $tr_response_img[0] = '';

    $tr_response_slider[0] = 'none';

    array_push($trigger_prefill_arr ,'{}');

    $tr_response_img_t[0] = '';

    $tr_response_slider_t[0] = 'none';

    $scale_arr[0] = '';

    $scale_t_arr[0] = '';

}

elseif(isset($_POST['btnEditPostedData']))	

{

    $divaddformmdt = 'none';

    $diveditformmdt = '';



    $day = trim($_POST['day']);

    $month = trim($_POST['month']);

    $year = trim($_POST['year']);

    

    $bes_date = $year.'-'.$month.'-'.$day;

    

    $arr_records = getUsersMDTDetails($user_id,$bes_date);

    //echo'<br><pre>';

    //print_r($arr_records);

    //echo'<br></pre>';

    

    

    

    if(count($arr_records)> 0)

    {

        for($i=0;$i<count($arr_records);$i++)

        {

            foreach ($arr_records[$i] as $key => $value) 

            {

                $temp_time_arr = explode('_',$key);

                array_push($bes_time_edit_arr , $temp_time_arr[0]);

                array_push($bes_duration_edit_arr , $temp_time_arr[1]);

                

                $cnt_edit = 0;

                $cnt_t_edit = 0;

                for($j=0;$j<count($value);$j++)

                {

                    //echo'<br>['.$i.']['.$j.']<pre>';

                    //print_r($value[$j]);

                    //echo'<br></pre>';

                    if($value[$j]['bms_entry_type'] == 'trigger')

                    {

                        $tr_response_img_t_edit[$i][$cnt_t_edit] = 'none';

                        $tr_response_slider_t_edit[$i][$cnt_t_edit] = '';



                        $json = array();

                        $json['value'] = $value[$j]['bms_type'].'_'.$value[$j]['bms_id'];

                        

                        if($value[$j]['bms_type'] == 'adct')

                        {

                            $json['name'] = getADCTSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'sleep')

                        {

                            $json['name'] = getSleepSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'gs')

                        {

                            $json['name'] = getGSSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'wae')

                        {

                            $json['name'] = getWAESituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'mc')

                        {

                            $json['name'] = getMCSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'mr')

                        {

                            $json['name'] = getMRSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'mle')

                        {

                            $json['name'] = getMLESituation($value[$j]['bms_id']);

                        }

                        else 

                        {

                            $json['name'] = getBobyMainSymptomName($value[$j]['bms_id']);    

                        }

                        

                        

                        $trigger_prefill_edit_arr[$i][$cnt_t_edit] = json_encode($json);

                        $trigger_id_edit_arr[$i][$cnt_t_edit] = $value[$j]['bms_id'];

                        $trigger_type_edit_arr[$i][$cnt_t_edit] = $value[$j]['bms_type'];

                        $remarks_t_edit_arr[$i][$cnt_t_edit] = $value[$j]['remarks'];

                        $scale_t_edit_arr[$i][$cnt_t_edit] = $value[$j]['scale'];

                        

                        $cnt_t_edit++;

                    }

                    else 

                    {

                        $tr_response_img_edit[$i][$cnt_edit] = 'none';

                        $tr_response_slider_edit[$i][$cnt_edit] = '';

                        

                        ///$json = array();

                        //$json['value'] = $value[$j]['bms_id'];

                        //$json['name'] = getBobyMainSymptomName($value[$j]['bms_id']);

                        

                        $json = array();

                        $json['value'] = $value[$j]['bms_type'].'_'.$value[$j]['bms_id'];

                        

                        if($value[$j]['bms_type'] == 'adct')

                        {

                            $json['name'] = getADCTSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'sleep')

                        {

                            $json['name'] = getSleepSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'gs')

                        {

                            $json['name'] = getGSSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'wae')

                        {

                            $json['name'] = getWAESituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'mc')

                        {

                            $json['name'] = getMCSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'mr')

                        {

                            $json['name'] = getMRSituation($value[$j]['bms_id']);

                        }

                        elseif($value[$j]['bms_type'] == 'mle')

                        {

                            $json['name'] = getMLESituation($value[$j]['bms_id']);

                        }

                        else 

                        {

                            $json['name'] = getBobyMainSymptomName($value[$j]['bms_id']);    

                        }

                        

                                               

                        

                        $bes_prefill_edit_arr[$i][$cnt_edit] = json_encode($json);

                        $bms_id_edit_arr[$i][$cnt_edit] = $value[$j]['bms_id'];

                        $bms_type_edit_arr[$i][$cnt_edit] = $value[$j]['bms_type'];

                        $scale_edit_arr[$i][$cnt_edit] = $value[$j]['scale'];

                        

                        $cnt_edit++;

                    }

                }

                

                $cnt_edit_arr[$i] = $cnt_edit;

                $totalRow_edit_arr[$i] = $cnt_edit;

                

                $cnt_t_edit_arr[$i] = $cnt_t_edit;

                $totalRow_t_edit_arr[$i] = $cnt_t_edit;

            }

        }

        

        $cnt_main = count($arr_records);

        $totalRow_main = count($arr_records);

    }

    else

    {

        $divaddformmdt = '';

        $diveditformmdt = 'none';

    

        $cnt_main = '1';

        $totalRow_main = '1';

        

        $cnt_edit_arr[0] = '1';

        $totalRow_edit_arr[0] = '1';



        $cnt_t_edit_arr[0] = '1';

        $totalRow_t_edit_arr[0] = '1';

        

        $bes_time_edit_arr[0] = '';

        $bes_duration_edit_arr[0] = '';

        

        $tr_response_img_edit[0][0] = '';

        $tr_response_slider_edit[0][0] = 'none';

        

        $bes_prefill_edit_arr[0][0] = '{}';

        $bms_id_edit_arr[0][0] = '';

        $bms_type_edit_arr[0][0] = '';

        

        $tr_response_img_t_edit[0][0] = 'none';

        $tr_response_slider_t_edit[0][0] = '';

        

        $trigger_prefill_edit_arr[0][0] = '{}';

        $trigger_id_edit_arr[0][0] = '';

        $trigger_type_edit_arr[0][0] = '';

        $remarks_t_edit_arr[0][0] = '';

        

        $scale_edit_arr[0][0] = '';

        $scale_t_edit_arr[0][0] = '';

    }

    

    //echo '<br><pre>';

    //print_r($bes_prefill_edit_arr);

    //echo '<br></pre>';

    

    $cnt = '1';

    $totalRow = '1';

    $cnt_t = '1';

    $totalRow_t = '1';

    $tr_err_bes[0] = 'none';

    $err_bes[0] = '';

    array_push($bes_prefill_arr ,'{}');

    $tr_response_img[0] = '';

    $tr_response_slider[0] = 'none';

    array_push($trigger_prefill_arr ,'{}');

    $tr_response_img_t[0] = '';

    $tr_response_slider_t[0] = 'none';

    $scale_arr[0] = '';

    $scale_t_arr[0] = '';

}    

else

{
    $year = $today_year;
    $month = $today_month;
    $day = $today_day;
    
    
    $cnt = '1';
    $totalRow = '1';
    $cnt_t = '1';
    $totalRow_t = '1';
}


if(isset($_REQUEST['action']) && $_REQUEST['action'] =='changtheammdt')
    {        
        $theam_id = stripslashes($_REQUEST['theam_id']);
        $_SESSION['mdttheam_id'] = $theam_id;
        $response = array();
        list($image,$color_code) = $obj->getTheamDetailsMDT($theam_id);
        $output = $image.'::'.$color_code;
        $response['image'] = $image;
        $response['color_code'] = $color_code;
        $response['error'] = 0;
        echo json_encode(array($response));
        exit(0);    
    }

    
    $data_dropdown = $obj->GETDATADROPDOWNMYDAYTODAY('423','45');
    $arr_cert_cnt = array(0);
    $arr_cert_total_cnt = array(1);
    
    //echo '<pre>';
    //print_r($data_dropdown);
    //echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">
<head>    
    <?php include_once('head.php');?>
    <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">
    <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>
    <style>
        .ui-datepicker-header {
        display:none!important;
      }
    </style>
</head>
<body>
<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>
<?php include_once('header-new.php');?>
<section id="checkout">
	<div class="container">
                <div class="breadcrumb">

               

                    <div class="row">

                    <div class="col-md-8">	

                      <?php echo $obj->getBreadcrumbCode($page_id);?> 

                       </div>

                         <div class="col-md-4">

                         <?php

                                    if($obj->isLoggedIn())

                                    { 

                                        echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

                                    }

                                    ?>

                         </div>

                       </div>

                </div>
		<div class="row">
                    
                    <div class="col-md-8" id="bgimage" style="background-repeat:repeat; padding:5px;">
                        <div class="col-md-12">
                        <!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);?></span></h2>-->
                        <?php echo $obj->getPageContents($page_id);?>
                    </div>
                        <div class='col-md-12' style="margin-bottom:20px;">
                            <div class="col-md-6">
                                <span style="font-size:15px; font-weight: bold;" class="Header_brown">Set your Mood</span>
                                <select name="theam_id1" id="theam_id" onchange="ChangeTheamMDT()" class="form-control">
                                <option>Select Theme</option>
                                <?php echo $obj->getTheamOptions($theam_id,$day); ?>
                            </select>
                            </div>
                            
                        </div>
                        <div class='col-md-5' style="margin-bottom:20px;">
                            <span style="font-size:15px; font-weight: bold;" class="Header_brown">Build your path</span>
                            <input type="text" name="day_month_year" id="day_month_year" placeholder="Select Date" class="form-control">
                        </div>
                        
                        <div class="col-md-12" style="border:1px solid #CBCFD4;background-color: #CBCFD4;">
                           
                           <form role="form" class="form-horizontal" id="frmdaily_meal" name="frmdaily_meal" enctype="multipart/form-data" method="post"> 
                               
                               <?php for($i=0;$i<count($data_dropdown);$i++) {
                                   
                                   $symtum_cat = '';
                                   
                                   if($data_dropdown[$i]['sub_cat1']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat1'].',';
                                   }
                                   
                                   if($data_dropdown[$i]['sub_cat2']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat2'].',';
                                   }
                                   
                                   if($data_dropdown[$i]['sub_cat3']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat3'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat4']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat4'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat5']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat5'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat6']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat6'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat7']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat7'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat8']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat8'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat9']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat9'].',';
                                   }
                                   if($data_dropdown[$i]['sub_cat10']!='')
                                   {
                                    $symtum_cat .= $data_dropdown[$i]['sub_cat10'].',';
                                   }
                                   
                                   $symtum_cat = explode(',', $symtum_cat);
                                   
                                   $symtum_cat = array_filter($symtum_cat);
                                   
                                   
//                                   echo '$symtum_cat<pre>';
//                                   print_r($symtum_cat);
//                                   echo '</pre>';
                                   //die();
                                   
                                   $final_array = $obj->getAllMainSymptomsRamakantFront($symtum_cat);
                                   
//                                   echo '$final_array<pre>';
//                                   print_r($final_array);
//                                   echo '</pre>';
                                   
                                  if($data_dropdown[$i]['time_show']!=0)
                                  {
                                     $time_show_icon = $obj->getMyDayTodayIcon('time_show'); 
                                  }
                                    else {
                                        $time_show_icon = '';
                                    }
                                   
                                   if($data_dropdown[$i]['duration_show']!=0)
                                    {
                                       $duration_show_icon = $obj->getMyDayTodayIcon('duration_show'); 
                                    }
                                    else {
                                        $duration_show_icon = '';
                                    }
                                    
                                    if($data_dropdown[$i]['location_show']!=0)
                                    {
                                       $location_show_icon = $obj->getMyDayTodayIcon('location_show'); 
                                    }
                                    else {
                                        $location_show_icon = '';
                                    }
                                    
                                     if($data_dropdown[$i]['User_view']!=0)
                                    {
                                       $User_view_icon = $obj->getMyDayTodayIcon('User_view'); 
                                    }
                                    else {
                                        $User_view_icon = '';
                                    }
                                    
                                     if($data_dropdown[$i]['User_Interaction']!=0)
                                    {
                                       $User_Interaction_icon = $obj->getMyDayTodayIcon('User_Interaction'); 
                                    }
                                    else {
                                        $User_Interaction_icon = '';
                                    }
                                    
                                    if($data_dropdown[$i]['scale_show']!=0)
                                    {
                                       $scale_show_icon = $obj->getMyDayTodayIcon('scale_show'); 
                                    }
                                    else {
                                        $scale_show_icon = '';
                                    }
                                    
                                    if($data_dropdown[$i]['alert_show']!=0)
                                    {
                                       $alert_show_icon = $obj->getMyDayTodayIcon('alert_show'); 
                                    }
                                    else {
                                        $alert_show_icon = '';
                                    }
                                    
                                    if($data_dropdown[$i]['comment_show']!=0)
                                    {
                                       $comment_show_icon = $obj->getMyDayTodayIcon('comments_show'); 
                                    }
                                    else {
                                        $comment_show_icon = '';
                                    }
                                    
                                   ?>
                               
                               <div class="col-md-10" style="margin-bottom:25px;">
                                   <label class="col-lg-6"><?php echo $data_dropdown[$i]['heading']; ?></label><br>
                                   <input type="text" required="" name="bes_id[]" id="bes_id_<?php echo $i;?>" placeholder="Select your <?php echo $data_dropdown[$i]['heading']; ?>" list="capitals<?php echo $i; ?>" class="input-text-box" style="width:300px;" />
                                    <datalist id="capitals<?php echo $i; ?>">
                                        <?php echo $obj->GetDatadropdownoption($final_array); ?>  
                                    </datalist>
                                        <?php if($time_show_icon!='') { ?>
                                   &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $time_show_icon; ?>" name="time_show_icon_<?php echo $i; ?>" id="time_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select Time" onclick="ShowTime(<?php echo $i; ?>);">
                                        <?php } ?>
                                        <?php if($duration_show_icon!='') { ?>
                                   &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $duration_show_icon; ?>" name="duration_show_icon_<?php echo $i; ?>" id="duration_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select Duration" onclick="ShowDuration(<?php echo $i; ?>);">
                                        <?php } ?>
                                        
                                        <?php if($scale_show_icon!='') { ?>
                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $scale_show_icon; ?>" name="scale_show_icon_<?php echo $i; ?>" id="scale_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select Intensity" onclick="ShowScale(<?php echo $i; ?>);">
                                        <?php } ?>
                                            
                                        <?php if($location_show_icon!='') { ?>
                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>" name="location_show_icon_<?php echo $i; ?>" id="location_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select Location" onclick="ShowLocation(<?php echo $i; ?>);">
                                         <?php } ?>
                                        
                                         <?php if($User_view_icon!='') { ?>
                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>" name="User_view_icon_<?php echo $i; ?>" id="User_view_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select Response" onclick="ShowUserview(<?php echo $i; ?>);">
                                        <?php } ?>
                                        
                                        <?php if($User_Interaction_icon!='') { ?>
                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>" name="User_Interaction_icon_<?php echo $i; ?>" id="User_Interaction_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select what's your next step" onclick="ShowUserInteraction(<?php echo $i; ?>);">
                                          <?php } ?>
                                        
                                         <?php if($comment_show_icon!='') { ?>
                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>" name="comment_show_icon_<?php echo $i; ?>" id="comment_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Post your additional information" onclick="ShowComment(<?php echo $i; ?>);">
                                        <?php } ?>
                                        
                                         <?php if($alert_show_icon!='') { ?>
                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>" name="alert_show_icon_<?php echo $i; ?>" id="alert_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select Alerts/Updates required" onclick="ShowAlert(<?php echo $i; ?>);">
                                        <?php } ?>
                                        <div class="md-col-12">
                                            <select required="" class="input-text-box input-quarter-width" name="bes_time[]" id="bes_time_<?php echo $i;?>" style="display:none;">
                                                <option value="">Select Time</option>
                                                <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
                                            </select>
                                            <input required="" type="text" name="duration[]" id="duration_<?php echo $i;?>" onKeyPress="return isNumberKey(event);" placeholder="Enter Duration" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">
                                            <input required="" type="text" name="scale[]" id="scale_<?php echo $i;?>"  placeholder="Enter Scale" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">
                                            
                                            <select required="" class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo $i;?>" style="display:none;">
                                                <option value="">Select Location</option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['location_fav_cat']); ?>
                                            </select>
                                            
                                            <select required="" class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo $i;?>" style="display:none;">
                                                <option value="">Select Response</option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['user_response_fav_cat']); ?>
                                            </select>
                                            
                                            <select required="" class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo $i;?>" style="display:none;">
                                                <option value="">Select What for next</option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['user_what_fav_cat']); ?>
                                            </select>
                                            
                                            <input required="" type="text" name="comment[]" id="comment_<?php echo $i;?>"  placeholder="Enter Comment" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">
                                            
                                            <select required="" class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo $i;?>" style="display:none;">
                                                <option value="">Select Alerts/Updates</option>
                                                <?php echo $obj->getFavCategoryRamakant($data_dropdown[$i]['alerts_fav_cat']); ?>
                                            </select>
                                        </div>
                              </div>
                               
                               <?php } ?>
                           </form>
                        </div>
                        
                        
                    </div>
		<div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>
		<div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>
			
		</div>
	</div>
</section>
<?php include_once('footer-new.php');?>	 
    <script>
        $(document).ready(function()
            { 
                $('#day_month_year').datepicker(
                        {
                            dateFormat: 'dd-mm-yy',
                            minDate: '-1D',
                            maxDate: '+0D',
                        }        
                );
               
               $('.vloc_speciality_offered').tokenize();
                
            }
        );
        
function ChangeTheamMDT()
{
    var theam_id = $("#theam_id").val();
    var dataString ='theam_id='+theam_id +'&action=changtheammdt';
    $.ajax({
            type: "POST",
            url: 'my_day_today.php', 
            data: dataString,
            cache: false,
            success: function(result)
                 {
                  var JSONObject = JSON.parse(result);
                 //$('#bgimage').html(JSONObject[0]['image']);
                 $('#bgimage').css("background-image", "url("+JSONObject[0]['image']+")");
                 $('#color_code').css("background-color", JSONObject[0]['color_code']);
                }
           });
}
    function ShowTime(id)
    {
      //alert("hiiii");
      $('#bes_time_'+id).show();  
    }
    
    function ShowDuration(id)
    {
      //alert("hiiii");
      $('#duration_'+id).show();  
    }
    
    function ShowScale(id)
    {
      //alert("hiiii");
      $('#scale_'+id).show();  
    }
    
    function ShowLocation(id)
    {
      //alert("hiiii");
      $('#location_'+id).show();  
    }
    
    function ShowAlert(id)
    {
      //alert("hiiii");
      $('#alert_'+id).show();  
    }
    
    function ShowUserInteraction(id)
    {
      //alert("hiiii");
      $('#User_Interaction_'+id).show();  
    }
    
    function ShowUserview(id)
    {
      //alert("hiiii");
      $('#User_view_'+id).show();  
    }
    
    function ShowComment(id)
    {
      //alert("hiiii");
      $('#comment_'+id).show();  
    }
    
    function isNumberKey(evt){  <!--Function to accept only numeric values-->
    //var e = evt || window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
        return false;
        return true;
	}
</script>
</body>
</html>