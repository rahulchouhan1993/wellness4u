<?php
require_once('../config/class.mysql.php');
require_once('../classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
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



