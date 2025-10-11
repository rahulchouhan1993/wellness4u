<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// session add by ample 04-12-19
session_start();
require_once('../config/class.mysql.php');

require_once('../classes/class.scrollingwindows.php');

$obj = new Scrolling_Windows();

require_once('../classes/class.contents.php'); 

$obj2 = new Contents();

// add by ample 03-12-19
require_once('../classes/class.mindjumble.php');  
$obj1 = new Mindjumble();

//add by ample 05-12-19
require_once('../classes/class.solutions.php');
$obj3 = new Solutions();

//add by ample
require_once('../classes/class.rssfeedparser.php');
$obj4 = new FeedParser();

//add by ample
require_once('../classes/class.banner.php');  
$obj5 = new Banner();

//add by ample 19-08-20
require_once('../classes/class.rewardpoints.php');
$obj_r = new RewardPoint();

$error = false;

$err_msg = "";

$action = $_REQUEST['action'];





if($action == 'getmaincategoryoption')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

        $cat_id ='';

	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);



    echo $data;



}



else if($action == 'getrefnumber')

{
    $group_code=$selected="";
	$table_name = trim($_REQUEST['table_name']);

    if($table_name)
    {
         if(isset($_REQUEST['group_code']) && !empty($_REQUEST['group_code']))
        {
             $group_code = trim($_REQUEST['group_code']);
        }
        if(isset($_REQUEST['selected']) && !empty($_REQUEST['selected']))
        {
            $selected=$_REQUEST['selected'];
        }

        // echo "string".$group_code;
        
        //if($group_code == '' || $group_code == '0' || $group_code =='null')
        if(empty($group_code) || $group_code==0 )
        {   
            // die('test-54654');
           $data = $obj->getRefOption($table_name,$selected);
        }
        else
        {   
            // die('test-489');
           $data = $obj->getRefOptionbyGroup($table_name,$group_code,$selected); 
        }

        echo $data;
    }
        
}

else if($action == 'getgrupdropdown')
{
        $table_name = trim($_REQUEST['table_name']);
        if($table_name)
        {   
            $selected="";
            if(isset($_REQUEST['selected']) && !empty($_REQUEST['selected']) )
            {
                $selected=$_REQUEST['selected'];
            }

            $data = $obj->getGroupOption($table_name,$selected);
            echo $data; 
        }
         
}

//vivek start

else if($action == 'addFunctionName')

{

    

	$function_name = $_REQUEST['function_name'];

       

        if($function_name=='')

        {

            echo 'Please Enter Function Name';die();

        }

        else if($obj2->chkPageDropdownModuleExists_EditVivek($function_name))

        {

            echo 'This function already added';die();

        }

        else

        {

            echo $obj2->addPageDropdownModuleVivek($function_name);die();

        }



}



else if($action == 'show_event_data')

{

	$event_id = $_REQUEST['event_id'];

       

        if($event_id=='')

        {

            echo 'Please Select event name';

        }

        else

        {

           

            $data =  $obj2->getEventdatashow($event_id);

            $response['show_data'] = $data['show_data'];

            $response['fav_cat_type_id_1'] = $obj2->getprofcatoption('34',$data['healcareandwellbeing'],'prof_cat1');

            $response['fav_cat_type_id_2'] = $obj2->getprofcatoption('34',$data['healcareandwellbeing'],'prof_cat2');

            echo json_encode(array($response));

            exit(0);   

        }



}



else if($action == 'show_event_data_bonus')

{

    

	$event_id = $_REQUEST['event_id'];

       

        if($event_id=='')

        {

            echo 'Please Select event name';

        }

        else

        {

            

            $data =  $obj2->getEventdatashow($event_id);

            $response['show_data'] = $data['show_data'];

            $response['fav_cat_type_id_1'] = $obj2->getprofcatoption('36',$data['healcareandwellbeing'],'prof_cat1');

            $response['fav_cat_type_id_2'] = $obj2->getprofcatoption('36',$data['healcareandwellbeing'],'prof_cat2');

            echo json_encode(array($response));

            exit(0);   

        }



}

else if($action == 'show_event_data_list')

{

    

	$event_id = $_REQUEST['event_id'];

       

        if($event_id=='')

        {

            echo 'Please Select event name';

        }

        else

        {

            

            $data =  $obj2->getEventdatashow($event_id);

            $response['show_data'] = $data['show_data'];

            $response['fav_cat_type_id_1'] = $obj2->getprofcatoption('37',$data['healcareandwellbeing'],'prof_cat1');

            $response['fav_cat_type_id_2'] = $obj2->getprofcatoption('37',$data['healcareandwellbeing'],'prof_cat2');

            echo json_encode(array($response));

            exit(0);   

        }



}

//vivek end

else if($action == 'getmaincategoryoptionfrompagefavcatdropdown')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

        $cat_id ='';

        $page_name='icons';

        $sub_cat_page_dropdowndata = $obj->getPageFavCatDropdownData($page_name,$parent_cat_id);

        

        $sub_cat_pdd_imp = implode(',', $sub_cat_page_dropdowndata);

        $sub_cat_pdd_explode= explode(',',$sub_cat_pdd_imp);

        $sub_cat_pdd_implode = implode('\',\'', $sub_cat_pdd_explode);

        if($sub_cat_pdd_implode!='')

        {

	$data = $obj->getFavCategoryVivek($parent_cat_id,$sub_cat_pdd_implode,$cat_id);

        }

        else

        {

            $data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        }



    echo $data;



}



//else if($action == 'getmaincategoryoptionVivek')

//{

//    

//	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $cat_id ='';

//	$data = $obj->getSymptomDataOption($parent_cat_id,$cat_id='');

//

//        $tdata='"'.implode('","',$data).'"';

//

//

//        echo $tdata;

//

//}



else if($action == 'getdescriptiondataoption')

{

    

	$rss_feed_item_id = $_REQUEST['rss_feed_item_id'];

        

        $cat_id ='';

	$tdata = $obj->getDescriptionNameById($rss_feed_item_id);

        echo $tdata;



}



else if($action == 'getkeyworddataoption')

{

//    $page_name_data='';

    $page_name_data = 'wellness_solution_items';

    

	$box_desc_data = $_REQUEST['box_desc_data'];

        $box_title = $_REQUEST['box_title'];

        

        $rss_feed_item_id = $_REQUEST['rss_feed_item_id'];

        

        

//        $reference_title = $_REQUEST['reference_title'];

        

	$rss_feed_item_data = $obj->getRssTitleNameById($rss_feed_item_id);

        

        $alldata=$box_title.' '.$box_desc_data.' '.$rss_feed_item_data;



        $box_desc_data_explode = explode(' ',$alldata);

        

        $exclusion_name = $obj->getExclusionAllName($page_name_data);

//        print_r($exclusion_name);die();getExclusionAllName

        for($i=0;$i<count($box_desc_data_explode);$i++)

        {

//            if($box_desc_data_explode[$i]!='plain' && $box_desc_data_explode[$i]!='Plain' && $box_desc_data_explode[$i]!='on' && $box_desc_data_explode[$i]!='On' && $box_desc_data_explode[$i]!='double' && $box_desc_data_explode[$i]!='Double' && $box_desc_data_explode[$i]!='ka' && $box_desc_data_explode[$i]!='Ka' && $box_desc_data_explode[$i]!='for' && $box_desc_data_explode[$i]!='For' && $box_desc_data_explode[$i]!='get' && $box_desc_data_explode[$i]!='Get' && $box_desc_data_explode[$i]!='can' && $box_desc_data_explode[$i]!='Can' && $box_desc_data_explode[$i]!='you' && $box_desc_data_explode[$i]!='You' &&  $box_desc_data_explode[$i]!='Book' && $box_desc_data_explode[$i]!='book' && $box_desc_data_explode[$i]!='more' && $box_desc_data_explode[$i]!='More' && $box_desc_data_explode[$i]!='less' && $box_desc_data_explode[$i]!='Less' && $box_desc_data_explode[$i]!='him' && $box_desc_data_explode[$i]!='Him' && $box_desc_data_explode[$i]!='In' && $box_desc_data_explode[$i]!='in' && $box_desc_data_explode[$i]!='All' && $box_desc_data_explode[$i]!='all' && $box_desc_data_explode[$i]!='be' && $box_desc_data_explode[$i]!='Be' && $box_desc_data_explode[$i]!='had' && $box_desc_data_explode[$i]!='Had' && $box_desc_data_explode[$i]!='I' && $box_desc_data_explode[$i]!='it' && $box_desc_data_explode[$i]!='It' && $box_desc_data_explode[$i]!='of' && $box_desc_data_explode[$i]!='Of' && $box_desc_data_explode[$i]!='his' && $box_desc_data_explode[$i]!='His' && $box_desc_data_explode[$i]!='Her' && $box_desc_data_explode[$i]!='her' && $box_desc_data_explode[$i]!='just' && $box_desc_data_explode[$i]!='Just' && $box_desc_data_explode[$i]!='before' && $box_desc_data_explode[$i]!='Before' && $box_desc_data_explode[$i]!='a' && $box_desc_data_explode[$i]!='A' && $box_desc_data_explode[$i]!='An' && $box_desc_data_explode[$i]!='an' && $box_desc_data_explode[$i]!='to' && $box_desc_data_explode[$i]!='To'&& $box_desc_data_explode[$i]!='the' && $box_desc_data_explode[$i]!='The' && $box_desc_data_explode[$i]!='was' && $box_desc_data_explode[$i]!='is' && $box_desc_data_explode[$i]!='Was' && $box_desc_data_explode[$i]!='Is' && $box_desc_data_explode[$i]!='am' && $box_desc_data_explode[$i]!='Am' && $box_desc_data_explode[$i]!='here' && $box_desc_data_explode[$i]!='Here' && $box_desc_data_explode[$i]!='after' && $box_desc_data_explode[$i]!='After' && $box_desc_data_explode[$i]!='should' && $box_desc_data_explode[$i]!='Should' && $box_desc_data_explode[$i]!='there' && $box_desc_data_explode[$i]!='There' && $box_desc_data_explode[$i]!='then' && $box_desc_data_explode[$i]!='Then' && $box_desc_data_explode[$i]!='than' && $box_desc_data_explode[$i]!='Than' && $box_desc_data_explode[$i]!='and' && $box_desc_data_explode[$i]!='And' && $box_desc_data_explode[$i]!='or' && $box_desc_data_explode[$i]!='Or' && $box_desc_data_explode[$i]!='if' && $box_desc_data_explode[$i]!='If' && $box_desc_data_explode[$i]!='but' && $box_desc_data_explode[$i]!='But' && $box_desc_data_explode[$i]!='that' && $box_desc_data_explode[$i]!='That' && $box_desc_data_explode[$i]!='about' && $box_desc_data_explode[$i]!='About'&& $box_desc_data_explode[$i]!='by' && $box_desc_data_explode[$i]!='By')

          if(!in_array($box_desc_data_explode[$i],$exclusion_name)) 

            {

            $box_desc_data_explode_data[]=$box_desc_data_explode[$i];

            }

        }

        

       

	$tdata = $obj->chkDescriptionNameInTable($box_desc_data_explode_data);

        

//        foreach($tdata as $rec)

//        {

//            $newdat=$tdata;

//             print_r($newdat);

//        }

        print_r($tdata);

       

        

//        foreach($tdata as $rec)

//        {

//            $data[]=$rec;

//        }

       

//        $option = '';

//        $option =

//        die();

//        echo $tdata;



}



else if($action == 'getkeyworddataoption')

{

    

	$box_desc_data = $_REQUEST['box_desc_data'];

//        $cat_id ='';

	$tdata = $obj->getDescriptionNameById($rss_feed_item_id);

        echo $tdata;



}



else if($action == 'getsymptomnameoption')

{

    

	$symptom_type = trim($_REQUEST['symptom_type']);

//        $fav_cat_id = trim($_REQUEST['fav_cat_id']);

        $bmsid ='';

        

	 $id = $obj->getSymptomNameByFavId('36',$symptom_type);

         $bmsid=implode('\',\'',$id);

        $data = $obj->getSymptomName($bmsid);



     echo $data;



}

else if($action == 'getsubcatoption')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCatbyidVivek($ids); 

        

        $sub_cat_id1_explode=  explode(',', $sub_cat_id1);

        

        $data = $obj->getAllCategoryChkeckbox($parent_cat_id,$sub_cat_id1_explode,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat2option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat2byidVivek($ids); 

        

        $arr_selected_cat_id=  explode(',', $sub_cat_id1);

        

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox2($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat3option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat3byidVivek($ids); 

        

        $arr_selected_cat_id=  explode(',', $sub_cat_id1);

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox3($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat4option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat4byidVivek($ids); 

        

        $arr_selected_cat_id=  explode(',', $sub_cat_id1);

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox4($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat5option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat5byidVivek($ids); 

        

         $arr_selected_cat_id=  explode(',', $sub_cat_id1); 

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox5($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat6option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat6byidVivek($ids); 

        

        $arr_selected_cat_id=  explode(',', $sub_cat_id1);

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox6($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat7option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat7byidVivek($ids); 

        

        $arr_selected_cat_id=  explode(',', $sub_cat_id1);

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox7($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat8option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat8byidVivek($ids); 

        

        $arr_selected_cat_id=  explode(',', $sub_cat_id1);

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox8($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat9option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCat9byidVivek($ids); 

        

        $arr_selected_cat_id=  explode(',', $sub_cat_id1);

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox9($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getsubcat10option')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

        

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

           

        }

        

        $sub_cat_id1 = $obj->getSelectedSubCat10byidVivek($ids); 

        

           $arr_selected_cat_id =  explode(',', $sub_cat_id1);

           

//	$data = $obj->getFavCategoryRamakant($parent_cat_id,$cat_id);

        $data = $obj->getAllCategoryChkeckbox10($parent_cat_id,$arr_selected_cat_id,'0','300','200');



    echo $data;



}

else if($action == 'getmodulewisecriteriaoptionsVivek')

{

   $output  = '';

	$report_module = $_REQUEST['report_module'];

        $num = $_REQUEST['num'];

        $module_criteria ='';

        



//     $output .= '<select name="module_criteria[]" id="module_criteria_'.$num.'" style="width:200px;" onchange="toggleCriteriaScaleShow();">



            $output .= '<option value="">All</option>';



    if($report_module != '')



    {



        $output .= $obj->getModuleWiseCriteriaOptionsPCM($report_module,$module_criteria);



    }    



//    $output .= '</select>';







    echo $output;



}

else if($action == 'getmodulewisecriteriascalevaluesVivek')

{

  $output = '';



	



	$num = stripslashes($_REQUEST['num']);



        $report_module = stripslashes($_REQUEST['report_module']);



        $pro_user_id = stripslashes($_REQUEST['pro_user_id']);



        $module_criteria = stripslashes($_REQUEST['module_criteria']);



        $criteria_scale_range = stripslashes($_REQUEST['criteria_scale_range']);



        $user_id = '';



        $start_criteria_scale_value = '';



        $end_criteria_scale_value = '';

        



               



        $output = $obj->getModuleWiseCriteriaScaleValues($num,$user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);



        



        echo $output;



}

else if($action == 'getdatasubcatoption')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);



        $columns = trim($_REQUEST['columns']);

        $id=isset($_REQUEST['id']);



         // echo "<pre>";print_r($id);echo "</pre>";



        if($id!='')

        {

           $ids= $_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelecteddataSubCatbyid($ids,$columns); 

        

        $sub_cat_id1_explode=  explode(',', $sub_cat_id1);

        

        if($columns == 'sub_cat1')

        {

            $data = $obj->getAllCategoryChkeckbox($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat2')

        {

            $data = $obj->getAllCategoryChkeckbox2($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat3')

        {

            $data = $obj->getAllCategoryChkeckbox3($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat4')

        {

            $data = $obj->getAllCategoryChkeckbox4($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat5')

        {

            $data = $obj->getAllCategoryChkeckbox5($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat6')

        {

            $data = $obj->getAllCategoryChkeckbox6($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat7')

        {

            $data = $obj->getAllCategoryChkeckbox7($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat8')

        {

            $data = $obj->getAllCategoryChkeckbox8($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat9')

        {

            $data = $obj->getAllCategoryChkeckbox9($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat10')

        {

            $data = $obj->getAllCategoryChkeckbox10($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

    echo $data;



}

else if($action == 'getdatasubcatoption_report')

{

    

    $parent_cat_id = trim($_REQUEST['parent_cat_id']);



        $columns = trim($_REQUEST['columns']);

        $id=isset($_REQUEST['id']);



         // echo "<pre>";print_r($id);echo "</pre>";



        if($id!='')

        {

           $ids= $_REQUEST['id'];

        }

        

    $sub_cat_id1 = $obj->getSelecteddataSubCatbyid_report($ids,$columns); 

        

        $sub_cat_id1_explode=  explode(',', $sub_cat_id1);

        

        if($columns == 'sub_cat1')

        {

            $data = $obj->getAllCategoryChkeckbox($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat2')

        {

            $data = $obj->getAllCategoryChkeckbox2($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat3')

        {

            $data = $obj->getAllCategoryChkeckbox3($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat4')

        {

            $data = $obj->getAllCategoryChkeckbox4($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat5')

        {

            $data = $obj->getAllCategoryChkeckbox5($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat6')

        {

            $data = $obj->getAllCategoryChkeckbox6($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat7')

        {

            $data = $obj->getAllCategoryChkeckbox7($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat8')

        {

            $data = $obj->getAllCategoryChkeckbox8($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat9')

        {

            $data = $obj->getAllCategoryChkeckbox9($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat10')

        {

            $data = $obj->getAllCategoryChkeckbox10($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

    echo $data;



}

else if($action == 'getdatasubcatoption_solution')

{

    

    $parent_cat_id = trim($_REQUEST['parent_cat_id']);



        $columns = trim($_REQUEST['columns']);

        $id=isset($_REQUEST['id']);



         // echo "<pre>";print_r($id);echo "</pre>";



        if($id!='')

        {

           $ids= $_REQUEST['id'];

        }

        

    $sub_cat_id1 = $obj->getSelecteddataSubCatbyid_solution($ids,$columns); 

        

        $sub_cat_id1_explode=  explode(',', $sub_cat_id1);

        

        if($columns == 'sub_cat')

        {

            $data = $obj->getAllCategoryChkeckbox($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

    echo $data;



}







elseif($action == 'getdatasubcatoption_popup')

{



$parent_cat_id = trim($_REQUEST['parent_cat_id']);



        $columns = trim($_REQUEST['columns']);

        $id=isset($_REQUEST['id']);



         // echo "<pre>";print_r($id);echo "</pre>";



        if($id!='')

        {

           $ids= $_REQUEST['id'];

        }

        

    $sub_cat_id1 = $obj->getSelecteddataSubCatbyid_pop($ids,$columns); 



    // echo "<pre>";print_r($sub_cat_id1);echo "</pre>";

    // exit;

        

        $sub_cat_id1_explode=  explode(',', $sub_cat_id1);

        

        if($columns == 'sub_cat1')

        {

            $data = $obj->getAllCategoryChkeckbox($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat2')

        {

            $data = $obj->getAllCategoryChkeckbox2($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat3')

        {

            $data = $obj->getAllCategoryChkeckbox3($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat4')

        {

            $data = $obj->getAllCategoryChkeckbox4($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat5')

        {

            $data = $obj->getAllCategoryChkeckbox5($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat6')

        {

            $data = $obj->getAllCategoryChkeckbox6($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat7')

        {

            $data = $obj->getAllCategoryChkeckbox7($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat8')

        {

            $data = $obj->getAllCategoryChkeckbox8($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat9')

        {

            $data = $obj->getAllCategoryChkeckbox9($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

        if($columns == 'sub_cat10')

        {

            $data = $obj->getAllCategoryChkeckbox10($parent_cat_id,$sub_cat_id1_explode,'0','300','200');

        }

        

    echo $data;



}

elseif($action == 'updateMenuOrders')



{



	$result = stripslashes($_REQUEST['result']);



	



	$temp_arr = explode('::::',$result);



	



	$arr_page_id = array();



	$arr_parent_id = array();



	$arr_menu_lvl = array();



	$arr_menu_order = array();



	$arr_link_enable = array();



	



	$error = '0';



	$err_msg = '';



	



	for($i=0;$i<count($temp_arr);$i++)



	{



		$temp_arr_curr = explode('_',$temp_arr[$i]);



		$page_id_curr = $temp_arr_curr[0];



		$menu_lvl_curr = $temp_arr_curr[1];



		$menu_order_curr = $temp_arr_curr[2];



		$page_parent_id = 0;



		if($i == 0)



		{



			



		}



		else



		{	



			$temp_arr_prev = explode('_',$temp_arr[$i-1]);



			



			$page_id_prev = $temp_arr_prev[0];



			$menu_lvl_prev = $temp_arr_prev[1];



			$menu_order_prev = $temp_arr_prev[2];



			



			if($menu_lvl_curr > $menu_lvl_prev)



			{



				$page_parent_id = $page_id_prev;



			}



			elseif($menu_lvl_curr < $menu_lvl_prev)



			{



				$key = array_search($menu_lvl_curr, $arr_menu_lvl);



				$page_parent_id = $arr_parent_id[$key];



			}



			else



			{



				$page_parent_id = $arr_parent_id[$i-1];



			}



		}



		



		array_push($arr_page_id , $page_id_curr);	



		array_push($arr_parent_id , $page_parent_id);	



		array_push($arr_menu_lvl , $menu_lvl_curr);	



		array_push($arr_menu_order , $menu_order_curr);	



		array_push($arr_link_enable , 1);	



	}



	



	if(!$obj2->updateMenuOrders($arr_page_id,$arr_parent_id,$arr_menu_order,$arr_link_enable))



	{



		$error = '1';



		$err_msg = 'Something went wrong please try again later';



	}



	else



	{



		$err_msg = 'Menu updated Successfully';



	}



	$output = $test.'::::'.$error.'::::'.$err_msg;



	echo $output; 



}



else if($action == 'getsubcatoptionCommon')

{

    

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        $serial = $_REQUEST['serial'];

        $checkboxname = $_REQUEST['checkboxname'];

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

	$sub_cat_id1 = $obj->getSelectedSubCatbyidVivek($ids); 

        

        $sub_cat_id1_explode=  explode(',', $sub_cat_id1);

        

        $data = $obj->getAllCategoryChkeckboxCommon($checkboxname,$serial,$parent_cat_id,$sub_cat_id1_explode,'0','300','200');



    echo $data;



}

else if($action == 'getsubcatoptionPageDecor')
{

    $parent_cat_id = trim($_REQUEST['parent_cat_id']);

//        $arr_selected_cat_id=array();

        $serial = $_REQUEST['serial'];

        $checkboxname = $_REQUEST['checkboxname'];

        $id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

    $sub_cat_id1 = $obj->getSelectedSubCatPageDecor($ids); 

        $sub_cat_id1_explode=  explode(',', $sub_cat_id1);

        $data = $obj->getAllCategoryChkeckboxCommon($checkboxname,$serial,$parent_cat_id,$sub_cat_id1_explode,'0','300','200');
    echo $data;

}

elseif($action == 'getDatadropdownPage')

{

    

	$pdm_id = trim($_REQUEST['pdm_id']);

        $page_type = trim($_REQUEST['page_type']);

        $page_id = '';

	$data = $obj2->getDatadropdownPage($pdm_id,$page_id,$page_type);



    echo $data;



}

elseif($action == 'getkeywordsuggestions')

{

    require_once('../classes/class.bodyparts.php');

    $obj3 = new BodyParts();

    $key_prof_cat_id = trim($_REQUEST['key_prof_cat_id']);

    $key_subcat_id = trim($_REQUEST['key_subcat_id']);

    $sub_cat_link = trim($_REQUEST['link']);

    

    $data = $obj3->GetFecthData($sub_cat_link,$key_subcat_id);

    

    $tdata = $obj3->generateAutocompleteArray($data);

    

    //$tdata='"'.implode('","',$data).'"';

    

    

//    echo '<pre>';

//    print_r($data);

//    echo '</pre>';

    

    echo $tdata;

    

}

elseif($action == 'getboxtitle')

{

    $page_cat_id = $_REQUEST['page_cat_id'];

    $obj2 = new Contents();

    $data_dropdown =  $obj2->GETDATADROPDOWNMYDAYTODAYOPTION($page_cat_id,'127');

    $show_cat = '';

                                $fetch_cat1 = array();

                                $fetch_cat2 = array();

                                $fetch_cat3 = array();

                                $fetch_cat4 = array();

                                $fetch_cat5 = array();

                                $fetch_cat6 = array();

                                $fetch_cat7 = array();

                                $fetch_cat8 = array();

                                $fetch_cat9 = array();

                                $fetch_cat10 = array();

                                   

                                   if($data_dropdown[0]['sub_cat1']!='')

                                   {

                                      if($data_dropdown[0]['canv_sub_cat1_show_fetch']==1) 

                                      {

                                        $show_cat .= $data_dropdown[0]['sub_cat1'].',';

                                      }

                                      else

                                      { 
                                            $sub_cat1 = explode(',', $data_dropdown[0]['sub_cat1']);
                                            $fetch_cat1=$obj2->getDataFromReportCustomized($sub_cat1,$data_dropdown[0]['canv_sub_cat1_link'],$data_dropdown[0]['prof_cat1_ref_code'],$data_dropdown[0]['prof_cat1_uid']);

                                            //$fetch_cat1 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat1_link'],$data_dropdown[0]['sub_cat1']);

                                      }

                                   }

                                   

                                   if($data_dropdown[0]['sub_cat2']!='')

                                   {

                                    if($data_dropdown[0]['canv_sub_cat2_show_fetch']==1) 

                                    {

                                        $show_cat .= $data_dropdown[0]['sub_cat2'].',';

                                    }

                                    else

                                      {    

                                            $sub_cat2 = explode(',', $data_dropdown[0]['sub_cat2']);
                                            $fetch_cat2=$obj2->getDataFromReportCustomized($sub_cat2,$data_dropdown[0]['canv_sub_cat2_link'],$data_dropdown[0]['prof_cat2_ref_code'],$data_dropdown[0]['prof_cat2_uid']);

                                          //$fetch_cat2 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat2_link'],$data_dropdown[0]['sub_cat2']);

                                      }

                                   }

                                   

                                   if($data_dropdown[0]['sub_cat3']!='')

                                   {

                                     if($data_dropdown[0]['canv_sub_cat3_show_fetch'] == 1) 

                                     {

                                        $show_cat .= $data_dropdown[0]['sub_cat3'].',';

                                     }

                                     else

                                      {

                                            $sub_cat3 = explode(',', $data_dropdown[0]['sub_cat3']);
                                            $fetch_cat3=$obj2->getDataFromReportCustomized($sub_cat3,$data_dropdown[0]['canv_sub_cat3_link'],$data_dropdown[0]['prof_cat3_ref_code'],$data_dropdown[0]['prof_cat3_uid']);
                                          //$fetch_cat3 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat3_link'],$data_dropdown[0]['sub_cat3']);

                                      }

                                   }

                                   if($data_dropdown[0]['sub_cat4']!='')

                                   {

                                       if($data_dropdown[0]['canv_sub_cat4_show_fetch']==1) 

                                       {

                                            $show_cat .= $data_dropdown[0]['sub_cat4'].',';

                                       }

                                     else

                                      {

                                            $sub_cat4 = explode(',', $data_dropdown[0]['sub_cat4']);
                                            $fetch_cat4=$obj2->getDataFromReportCustomized($sub_cat4,$data_dropdown[0]['canv_sub_cat4_link'],$data_dropdown[0]['prof_cat4_ref_code'],$data_dropdown[0]['prof_cat4_uid']);
                                          //$fetch_cat4 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat4_link'],$data_dropdown[0]['sub_cat4']);

                                      }

                                   }

                                   if($data_dropdown[0]['sub_cat5']!='')

                                   {

                                       if($data_dropdown[0]['canv_sub_cat5_show_fetch']==1) 

                                       {

                                            $show_cat .= $data_dropdown[0]['sub_cat5'].',';

                                       }

                                       else

                                      { 

                                            $sub_cat5 = explode(',', $data_dropdown[0]['sub_cat5']);
                                            $fetch_cat5=$obj2->getDataFromReportCustomized($sub_cat5,$data_dropdown[0]['canv_sub_cat5_link'],$data_dropdown[0]['prof_cat5_ref_code'],$data_dropdown[0]['prof_cat5_uid']);
                                          //$fetch_cat5 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat5_link'],$data_dropdown[0]['sub_cat5']);

                                      }

                                   }

                                   if($data_dropdown[0]['sub_cat6']!='')

                                   {

                                       if($data_dropdown[0]['canv_sub_cat6_show_fetch']==1) 

                                       {

                                            $show_cat .= $data_dropdown[0]['sub_cat6'].',';

                                       }

                                       else

                                      {

                                            $sub_cat6 = explode(',', $data_dropdown[0]['sub_cat6']);
                                            $fetch_cat6=$obj2->getDataFromReportCustomized($sub_cat6,$data_dropdown[0]['canv_sub_cat6_link'],$data_dropdown[0]['prof_cat6_ref_code'],$data_dropdown[0]['prof_cat6_uid']);
                                          //$fetch_cat6 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat6_link'],$data_dropdown[0]['sub_cat6']);

                                      }

                                   }

                                   if($data_dropdown[0]['sub_cat7']!='')

                                   {

                                     if($data_dropdown[0]['canv_sub_cat7_show_fetch']==1) 

                                     {

                                        $show_cat .= $data_dropdown[0]['sub_cat7'].',';

                                     }

                                     else

                                      {

                                            $sub_cat7 = explode(',', $data_dropdown[0]['sub_cat7']);
                                            $fetch_cat7=$obj2->getDataFromReportCustomized($sub_cat7,$data_dropdown[0]['canv_sub_cat7_link'],$data_dropdown[0]['prof_cat7_ref_code'],$data_dropdown[0]['prof_cat7_uid']);

                                          //$fetch_cat7 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat7_link'],$data_dropdown[0]['sub_cat7']);

                                      }

                                   }

                                   if($data_dropdown[0]['sub_cat8']!='')

                                   {

                                       if($data_dropdown[0]['canv_sub_cat8_show_fetch']==1) 

                                       {

                                            $show_cat .= $data_dropdown[0]['sub_cat8'].',';

                                       }

                                       else

                                      { 
                                            $sub_cat8 = explode(',', $data_dropdown[0]['sub_cat8']);
                                            $fetch_cat8=$obj2->getDataFromReportCustomized($sub_cat8,$data_dropdown[0]['canv_sub_cat8_link'],$data_dropdown[0]['prof_cat8_ref_code'],$data_dropdown[0]['prof_cat8_uid']);

                                           //$fetch_cat8 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat8_link'],$data_dropdown[0]['sub_cat8']);

                                      }

                                   }

                                   if($data_dropdown[0]['sub_cat9']!='')

                                   {

                                    if($data_dropdown[0]['canv_sub_cat9_show_fetch']==1) 

                                    {

                                        $show_cat .= $data_dropdown[0]['sub_cat9'].',';

                                    }

                                    else

                                      { 

                                            $sub_cat9 = explode(',', $data_dropdown[0]['sub_cat9']);
                                            $fetch_cat9=$obj2->getDataFromReportCustomized($sub_cat9,$data_dropdown[0]['canv_sub_cat9_link'],$data_dropdown[0]['prof_cat9_ref_code'],$data_dropdown[0]['prof_cat9_uid']);

                                          //$fetch_cat9 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat9_link'],$data_dropdown[0]['sub_cat9']);

                                      }

                                   }

                                   if($data_dropdown[0]['sub_cat10']!='')

                                   {

                                    if($data_dropdown[0]['canv_sub_cat10_show_fetch']==1) 

                                    {

                                        $show_cat .= $data_dropdown[0]['sub_cat10'].',';

                                    }

                                    else

                                      { 

                                            $sub_cat10 = explode(',', $data_dropdown[0]['sub_cat10']);
                                            $fetch_cat10=$obj2->getDataFromReportCustomized($sub_cat10,$data_dropdown[0]['canv_sub_cat10_link'],$data_dropdown[0]['prof_cat10_ref_code'],$data_dropdown[0]['prof_cat10_uid']);

                                          //$fetch_cat10 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat10_link'],$data_dropdown[0]['sub_cat10']);

                                      }

                                   }

                                   

                                   //echo $symtum_cat;

                                   

                                   

                                   

                                   $show_cat = explode(',', $show_cat);

                                   $show_cat = array_filter($show_cat);

                                   

                                   $final_array = array_merge($fetch_cat1,$fetch_cat2,$fetch_cat3,$fetch_cat4,$fetch_cat5,$fetch_cat6,$fetch_cat7,$fetch_cat8,$fetch_cat9,$fetch_cat10);

                                   

                                   $final_dropdown = $obj2->CreateDesignLifeDropdown($show_cat,$final_array);

    

    echo $final_dropdown;

    

}

else if($action == 'getPageDropdown')

{

    

	$page_type = trim($_REQUEST['page_type']);

        $page_id = trim($_REQUEST['page_id']);

        $data = $obj->getAllPagesChkeckboxData($page_type,$page_id,'300','200');



    echo $data;



}

elseif($action == 'getusertypeselectedemaillist')



{



	$ult_id = stripslashes($_REQUEST['ult_id']);



	$country_id = stripslashes($_REQUEST['country_id']);



	$str_state_id = stripslashes($_REQUEST['str_state_id']);



	$str_city_id = stripslashes($_REQUEST['str_city_id']);



	$str_place_id = stripslashes($_REQUEST['str_place_id']);



	$str_selected_user_id = stripslashes($_REQUEST['str_selected_user_id']);



	$str_selected_adviser_id = stripslashes($_REQUEST['str_selected_adviser_id']);



	$str_ap_id = stripslashes($_REQUEST['str_ap_id']);



	$str_up_id = stripslashes($_REQUEST['str_up_id']);



	



	$str_state_id = substr($str_state_id,0,-1);



	$str_city_id = substr($str_city_id,0,-1);



	$str_place_id = substr($str_place_id,0,-1);



	$str_ap_id = substr($str_ap_id,0,-1);



	$str_up_id = substr($str_up_id,0,-1);



	



	$arr_state_id = explode(',',$str_state_id);



	$arr_city_id = explode(',',$str_city_id);



	$arr_place_id = explode(',',$str_place_id);



	$arr_selected_user_id = explode(',',$str_selected_user_id);



	$arr_selected_adviser_id = explode(',',$str_selected_adviser_id);



	$arr_ap_id = explode(',',$str_ap_id);



	$arr_up_id = explode(',',$str_up_id);



	



	$output = $obj2->getUserTypeSelectedEmailList($ult_id,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$arr_selected_user_id,$arr_selected_adviser_id,$arr_ap_id,$arr_up_id);



	echo $output;



}

elseif($action == 'deactivateuser')



{

    $user_id = $_POST['user_id'];

    $output = $obj2->DeactivateUser($user_id);

    echo $output;

    

}

elseif($action == 'activateuser')

{

    $user_id = $_POST['user_id'];

    $output = $obj2->activateUser($user_id);

    echo $output;

    

}

else if($action == 'addTablFunctionName')

{

    $function_name = $_REQUEST['function_name1'];

        if($function_name=='')

        {

            echo 'Please Enter Function Name';die();

        }

        else if($obj2->chkTablDropdownModuleExists_EditKR($function_name))

        {

            echo 'This function already added';die();

        }

        else

        {

            echo $obj2->addTablDropdownModuleKR($function_name);die();

        }

}

elseif($action == 'getTabldropdownKR')    // 28/2/2019 krishna

{

    

    $tablm_id = trim($_REQUEST['tablm_id']);



    $data = $obj2->getTabldropdownKR($tablm_id);



    echo $data;



}

elseif($action == 'getTableColumsKR')    // 28/2/2019 krishna

{

    

    $tablm_name = trim($_REQUEST['tablm_name']);



    $data = $obj2->getTablColumsKR($tablm_name);



    echo $data;

}

elseif($action == 'getTableColumnsNameKR')

{

  $tablm_name = trim($_REQUEST['tablm_name']); 

  $get=trim($_REQUEST['get']);

  $data = $obj2->getcolumsNameOftable($tablm_name);

  $output='';



   $output.='<option value="">-Select-</option>';

   foreach($data as $tbl_cols)

   {

     $output.='<option value='.$tbl_cols.'>'.$tbl_cols.'</option>';

   }

 

  echo $output;

}
//abb this action by ample 05-11-19
elseif($action == 'getTableColumnsName')

{
    $tbl_name = trim($_REQUEST['tbl_name']); 
    $selected=$select="";
    if(isset($_REQUEST['selected']))
    {
        $selected=trim($_REQUEST['selected']); 
    }
    $data = $obj2->getcolumsNameOftable($tbl_name);
    $output='';

   $output.='<option value="">-Select-</option>';

   foreach($data as $tbl_cols)

   {

    if($selected==$tbl_cols)
    {
        $select="selected";
    }

     $output.='<option value='.$tbl_cols.' ' .$select.' >'.$tbl_cols.'</option>';

    $select="";

   }

  echo $output;

}

elseif($action == 'getTableColumnsNameKR_new_field')

{

  $columns_dropdown0 = trim($_REQUEST['columns_dropdown0']); 

  $get=trim($_REQUEST['get']);

  $data = $obj2->getTableNameOptions_dropdown_kr2(0,'');



  

  // $output='';



  //  $output.='<option value="">-Select-</option>';

  //  foreach($data as $tbl_cols)

  //  {

  //    $output.='<option value='.$tbl_cols.'>'.$tbl_cols.'</option>';

  //  }

 

  echo $data;

}







else if($action == 'addMessagefunction')

{

    $message_name = $_REQUEST['message_name'];

        if($message_name=='')

        {

            echo 'Please Enter Function Name';die();

        }

        else if($obj2->chkMessageNameExists_EditKR($message_name))

        {

            echo 'This function already added';die();

        }

        else

        {

            echo $obj2->addMessageNameKR($message_name);die();

        }

}

else if($action =='getvendoraccesssubcat')

    {

        

    $response=array();

    $va_cat_id=$_REQUEST['va_cat_id']!='' ? $_REQUEST['va_cat_id'] : '';

    

    

    if($va_cat_id!='')

        {

            $response['va_sub_cat_id'] = $obj2->getvendoraccesdropdownsub($va_cat_id,'');

            $response['error'] = 0;

        }

    echo json_encode(array($response));

    exit(0);    

    }

    else if($action=='get_sponsor_name')

    {

         $sponsor_list = $_REQUEST['sponsor_list'];

         $mor_id= $_REQUEST['mor_id'];

         $data=$obj2->multisponsor_name($sponsor_list,$mor_id,'','');

         echo $data;

    }

    // code write by ample 20-11-19 & update 22-11-19 & again update 07-01-20
    else if($action=='getSelfColumnData')

    {
        $ID="";
        $link = $_REQUEST['link'];
        $ref_code= $_REQUEST['ref_code'];
        $UID= $_REQUEST['UID'];
        $u_col_name=$_REQUEST['u_col_name']; 
        //add by ample 07-01-20
        if(isset($_REQUEST['ID']))
        {
            $ID= $_REQUEST['ID'];
        }
        $columns=$obj2->table_colums($link);


        $details_arr=$obj2->get_report_custom_data($columns,$UID);

        $data='';

        $data.='<form method="post" action="">';
        $data.='<table align="left" border="0" width="100%" cellpadding="0" cellspacing="0"  id="getcolums" class="table">
                                    <thead>
                                    <tr>
                                        <th>ColumsName</th>
                                        <th>Checkbox</th>
                                        <th>ID-Tables</th>
                                        <th>Fetch field</th>
                                        <th>Match field</th>
                                    </tr> </thead> <tbody>';

                    foreach ($details_arr as $key => $del_value) {

                                if($del_value['uniqu_m_id']!='')
                                      {
                                        $checked='checked';
                                        $col_name=$del_value['col_name'];
                                      }
                                      else{
                                          $checked='';
                                          $col_name='';
                                      }
                                      $key++;
                                      $tbl=$obj2->getTableNameOptions_dropdown($key,$del_value["Id_table"]);
                                $data.='<tr>
                                        <td>'.$del_value['col_name'].'</td>
                                        <td>
                                        <input type="hidden" name="get_unoqu[]" id="get_unoqu'.$key.'" value="'.$del_value["uniqu_m_id"].'">
                                    <input type="hidden" name="get_col_id[]" id="get_col_id'.$key.'" value="'.$del_value["col_id"].'">
                                    <input type="hidden" name="checkvalue[]" id="checkvalue'.$key.'" value="'.$col_name.'">
                                        <input class="chkbxapaid" type="checkbox" name="check_[]" id="check_'.$key.'" value="'.$del_value['col_name'].'" '.$checked.' onclick="selectcheck('."'".$key."'".','."'".$del_value["col_name"]."'".');" >
                                        </td>
                                        <td> '.$tbl.'</td>
                                        <td>
                                        <select id="columns_dropdown'.$key.'" style="width:100px;" name="columns_dropdown[]">';
                                           
                                          if($del_value['fetch_columns']!="")
                                          {
                                            
                                            $data.='<option value="'.$del_value["fetch_columns"].'">'.$del_value["fetch_columns"].'</option>';
                                            
                                          }
                                          else
                                          {
                                            
                                            $data.='<option value="">-Select-</option>';
                                            
                                          }
                                        
                                     $data.='</select>
                                        </td>
                                        <td>
                                        <select id="columns_dropdown_value'.$key.'" style="width:100px;" name="columns_dropdown_value[]">';
                                        
                                          if($del_value['fetch_value']!="")
                                          {
                                        
                                            $data.='<option value="'.$del_value["fetch_value"].'">'.$del_value["fetch_value"].'</option>';
                                            
                                          }
                                          else
                                          {
                                        
                                            $data.='<option value="">-Select-</option>';
                                            
                                          }
                                        
                                        $data.='</select>
                                        </td>
                                        </tr>';
                        
                    }
                                
                                   
            $data.='</tbody></table>';
             $data.=' <input type="hidden" name="u_col_name" id="u_col_name" value="'.$u_col_name.'">';
             $data.=' <input type="hidden" name="ID" id="ID" value="'.$ID.'">';
            $data.=' <button type="submit" class="btn btn-primary" name="report_setting">Save changes</button> </form';
       

         //echo json_encode($data);
            echo $data;

    }
    // code write by ample 03-12-19
    elseif ($action=='approveUserUploads') {
            
            $id = $_REQUEST['id'];
            $result=$res=false;
            $upload_data=$obj1->getuseruploadsDetails($id);
            $admin_id = $_SESSION['admin_id'];
            if(!empty($upload_data))
            {
                if($upload_data['banner_type']=='image')
                {
                    $res=$obj1->copy_data_tbl_icons($upload_data);
                }
                else
                {
                    $res=$obj1->copy_data_tblmindjumble($upload_data);
                }
                if($res==true)
                {
                    $result=$obj1->approved_user_uploads($id,$admin_id);
                }
            }
            echo $result;
    }

    // code write by ample 04-12-19 & 05-12-19 & update 17-02-20
    elseif ($action=='galleryData') {
            
            $data='';
            $type=$_REQUEST['type']; 
            $id_field=$_REQUEST['id_field'];
            if($type=='IMG')
            {
                $icons_type_id=$_REQUEST['category'];
                $res=$obj1->get_data_from_tblicons($icons_type_id);

                $gallery="IMG";

                $data.='<div class="row">';

                $data.='<div class="col-sm-3"></div><div class="col-sm-6">';

                $data.='<div class="form-group">
                          <select class="form-control" name="icons_type_id" onchange="galleryData('."'".$gallery."'".',this,'."'".$id_field."'".');">
                           '.$obj->getFavCategoryRamakant('48',$icons_type_id).'
                          </select>
                        </div>';

                $data.='</div><div class="col-sm-3"></div>';

                $data.='</div>';

                $data.='<div class="row">';
                
                 if(!empty($res))  
                 {
                    foreach ($res as $key => $value) {
                        $data.='<div class="col-md-1">';
                        $data.='<a href="javascript:void(0);" onclick="selected_gallery_data('."'".$value['icons_id']."'".','."'".$id_field."'".','."'Image'".','."'".$value['icons_name']."'".','."'".$value['image']."'".','."'".$value['credit']."'".','."'".$value['credit_url']."'".')"><img src="../uploads/'.$value['image'].'" width="50px" height="50px" title="'.$value['icons_name'].'&nbsp;&nbsp;&nbsp;'.$value['icon_tags'].'"></a>';
                        $data.='</div>';
                    }
                 }
                 else
                 {
                    $data.='<div class="col-md-12 text-center"><h4>No Record Found</h4></div>';
                 }


                $data.='</div>';
            }
            else
            {   
                $gallery="OT";

                $banner_type=$_REQUEST['category'];

                $res=$obj1->get_data_from_tblsolutionitems($banner_type);

                $data.='<div class="row">';

                $data.='<div class="col-sm-3"></div><div class="col-sm-6">';

                $data.='<div class="form-group">
                          <select class="form-control" name="banner_type" onchange="galleryData('."'".$gallery."'".',this,'."'".$id_field."'".');">
                            <option value="">Select Category</option>
                           '.$obj3->getSolutionItemTypeOptions($banner_type).'
                          </select>
                        </div>';

                $data.='</div><div class="col-sm-3"></div>';

                $data.='</div>';

                $data.='<div class="row">';

                 if(!empty($res))  
                 {  
                    $data.='<div class="col-md-12"><table class="table table-condensed">';
                    $data.='<thead><tr><th>#</th><th>Title-Name</th><th>Attachement</th><th>Tags</th><th>Action</th></tr></thead>';
                    $data.='<tbody>';
                    foreach ($res as $key => $value) {
                        $data.='<tr>';
                        $data.='<td>'.$value['sol_item_id'].'</td>';
                        $data.='<td>'.$value['topic_subject'].'</td>';
                        $data.='<td>';
                        if($value['banner_type']=='rss')
                        {
                            $data.=$obj1->get_rss_feed_title($value['banner']);
                        }
                        else
                        if($value['banner_type']=='Video')
                        {
                            $data.='<iframe width="250" height="250" src="'.$value['banner'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        }
                        else
                        {
                            $data.='<a href="../uploads/'.$value['banner'].'" target="_blank">'.$value['banner'].'</a>';
                        }
                        $data.='</td>';
                        $data.='<td>'.$value['tags'].'</td>';
                        $data.='<td><button class="btn btn-info btn-xs" onclick="selected_gallery_data('."'".$value['sol_item_id']."'".','."'".$id_field."'".','."'".$value['banner_type']."'".','."'".$value['topic_subject']."'".','."'".$value['banner']."'".','."'".$value['credit']."'".','."'".$value['credit_url']."'".')">Select</button></td>';
                        $data.='</tr>';
                    }
                    $data.='</tbody></table></div>';
                 }
                 else
                 {
                    $data.='<div class="col-md-12 text-center"><h4>No Record Found</h4></div>';
                 }


                $data.='</div>';
            }
            

            echo $data;
    }
    // code write by ample 04-12-19 & 05-12-19 & update 17-02-20
    elseif ($action=='GetPRofCatData_DLY') {

        
        $selected=$_POST['selected'];
        $source=$_POST['source'];
        $profCat=explode(',', $_POST['source']);
        $data_id=$_POST['data_id'];
        $data_dropdown=$obj2->GetDesignYourLifeData($data_id);

        $show_cat = '';

                    $fetch_cat2 = array();
                    $fetch_cat3 = array();
                    $fetch_cat4 = array();

                    if(in_array("ProfCat2", $profCat) && $data_dropdown['sub_cat2']!='')
                       {
                        if($data_dropdown['sub_cat2_show_fetch']==1) 
                        {
                            $show_cat .= $data_dropdown['sub_cat2'].',';
                        }
                        else
                          {    
                                $sub_cat2 = explode(',', $data_dropdown['sub_cat2']);
                                $fetch_cat2=$obj2->getDataFromReportCustomized($sub_cat2,$data_dropdown['sub_cat2_link'],$data_dropdown['prof_cat2_ref_code'],$data_dropdown['prof_cat2_uid']);
                          }
                       }


                    if(in_array("ProfCat3", $profCat) && $data_dropdown['sub_cat3']!='')
                       {
                        if($data_dropdown['sub_cat3_show_fetch']==1) 
                        {
                            $show_cat .= $data_dropdown['sub_cat3'].',';
                        }
                        else
                          {    
                                $sub_cat3 = explode(',', $data_dropdown['sub_cat3']);
                                $fetch_cat3=$obj2->getDataFromReportCustomized($sub_cat3,$data_dropdown['sub_cat3_link'],$data_dropdown['prof_cat3_ref_code'],$data_dropdown['prof_cat3_uid']);
                          }
                       }


                    if(in_array("ProfCat4", $profCat) && $data_dropdown['sub_cat4']!='')
                       {
                        if($data_dropdown['sub_cat4_show_fetch']==1) 
                        {
                            $show_cat .= $data_dropdown['sub_cat4'].',';
                        }
                        else
                          {    
                                $sub_cat4 = explode(',', $data_dropdown['sub_cat4']);
                                $fetch_cat4=$obj2->getDataFromReportCustomized($sub_cat4,$data_dropdown['sub_cat4_link'],$data_dropdown['prof_cat4_ref_code'],$data_dropdown['prof_cat4_uid']);
                          }
                       }
                            
                                   
                       $show_cat = explode(',', $show_cat);

                       $show_cat = array_filter($show_cat);

                       $final_array = array_merge($fetch_cat2,$fetch_cat3,$fetch_cat4);

                        $final_dropdown = $obj2->CreateDesignLifeDropdown($show_cat,$final_array);

                if($selected)
                {
                    $final_dropdown.='<option value="'.$selected.'" selected>'.$selected.'</option>';
                }

                 echo $final_dropdown;

    }
    //add by ample 15-06-20
    else if($action == 'Add_email_function')
    {

        $function_name = $_REQUEST['email_action_title'];
            if($function_name=='')
            {
                $response=array('status'=>0);
            }
            else
            {
                $res=$obj2->AddEmailFunction($function_name);
                if($res==true)
                {
                    $response=array('status'=>1);
                }
                else
                {
                    $response=array('status'=>0);
                }
            }
        echo json_encode($response);
    }
     //add by ample 30-07-20
    else if($action == 'rss_html_code')
    {

        $rss_id = $_REQUEST['rss_id'];
         
                $data=$obj4->get_rss_feed_data($rss_id);

                if(!empty($data))
                {
                    $response=array('status'=>1, 'data'=>$data['rss_feed_html']);
                }
                else
                {
                    $response=array('status'=>0);
                }
            
        echo json_encode($response);
    }
    //add by ample 19-08-20
    else if($action == 'get_sponsor_list')
    {

        $sponsor = $_REQUEST['sponsor'];

        $sponsor_name = $_REQUEST['sponsor_name'];
         
        $html=$obj_r->multisponsor_name($sponsor,$sponsor_name); 
            
        echo $html;
    }
    //add by ample 13-10-20
    else if($action == 'getcityoption')
    {

        $country_id = $_REQUEST['country_id'];

        $state_id = $_REQUEST['state_id'];

        $city_id = $_REQUEST['city_id'];
         
        $html=$obj5->getCityOption($country_id,$state_id,$city_id); 
            
        echo $html;
    }
    //add by ample 14-10-20
    else if($action == 'getareaoption')
    {

        $country_id = $_REQUEST['country_id'];

        $state_id = $_REQUEST['state_id'];

        $city_id = $_REQUEST['city_id'];

        $area_id = $_REQUEST['area_id'];
         
        $html=$obj5->getAreaOption($country_id,$state_id,$city_id,$area_id); 
            
        echo $html;
    }
?>













