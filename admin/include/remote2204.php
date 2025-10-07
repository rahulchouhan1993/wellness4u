<?php
require_once('../config/class.mysql.php');
require_once('../classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
require_once('../classes/class.contents.php'); 
$obj2 = new Contents();
//require_once('classes/class.dailymeals.php');
//$obj1 = new Daily_Meals();


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

if($action == 'getrefnumber')
{
    
	$table_name = trim($_REQUEST['table_name']);
        
	$data = $obj->getRefOption($table_name);

        echo $data;

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
                                          $fetch_cat1 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat1_link'],$data_dropdown[0]['sub_cat1']);
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
                                          $fetch_cat2 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat2_link'],$data_dropdown[0]['sub_cat2']);
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
                                          $fetch_cat3 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat3_link'],$data_dropdown[0]['sub_cat3']);
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
                                          $fetch_cat4 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat4_link'],$data_dropdown[0]['sub_cat4']);
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
                                          $fetch_cat5 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat5_link'],$data_dropdown[0]['sub_cat5']);
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
                                          $fetch_cat6 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat6_link'],$data_dropdown[0]['sub_cat6']);
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
                                          $fetch_cat7 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat7_link'],$data_dropdown[0]['sub_cat7']);
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
                                          $fetch_cat8 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat8_link'],$data_dropdown[0]['sub_cat8']);
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
                                          $fetch_cat9 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat9_link'],$data_dropdown[0]['sub_cat9']);
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
                                          $fetch_cat10 = $obj2->GetFecthData($data_dropdown[0]['canv_sub_cat10_link'],$data_dropdown[0]['sub_cat10']);
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









