<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');  

require_once('classes/class.places.php');



$obj = new Contents();

$obj2 = new Places();



require_once('classes/class.scrollingwindows.php');

$obj1 = new Scrolling_Windows();



$add_action_id = '355';



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



//if($action == 'getsubcategoryoption')

//{

//    

//        

//	$profid = trim($_REQUEST['profid']);

//        $arr_selected_cat_id1 =array();

//	$data = $obj->getAllSubCategoryChkeckbox($arr_selected_cat_id1,$profid,'0','300','200');

//     print_r($data) ;

//

//}



$arr_selected_cat_id1=array();

$error = false;

$err_msg = "";





if(isset($_POST['btnSubmit']))

{



// echo '<br><pre>';

// print_r($_POST);

// echo '</pre>';

// die();



  $ref_code = strip_tags(trim($_POST['ref_code']));



  $fav_cat_type_id_0 = $_POST['fav_cat_type_id_0'];

   if($_POST['healcareandwellbeing']=='')

   {

     $healcareandwellbeing = $obj->getAllHealcareAndWellbeingPageDropdownData($fav_cat_type_id_0);

   }

   else

   {

      $healcareandwellbeing = $_POST['healcareandwellbeing'];

   }





   



   

    $page_name = strip_tags(trim($_POST['page_name']));

    $page_type = strip_tags(trim($_POST['page_type']));



    $table_dropdown_ref=$_POST['table_dropdown_ref'];

    $data_source=$_POST['data_source'];

    $report_name=$_POST['report_name'];

   

    $prof_cat1 = $_POST['fav_cat_type_id'];

    



    // selected_cat_id1

   if($report_name=="")

   {

     $error = true;

     $err_field_msg_report_name = 'Enter report name.';

   }







    $cat_fetch_show_data = array();

    if(isset($_POST['canv_sub_cat1_show_fetch']))

    {

        $cat_fetch_show_data['canv_sub_cat1_show_fetch']= $_POST['canv_sub_cat1_show_fetch']; // Displaying Selected Value

    }  



    foreach ($_POST['selected_cat_id1'] as $key => $value) 

    {

        array_push($arr_selected_cat_id1,$value);

    }

    

  

    $canv_sub_cat_link = array();

    $canv_sub_cat_link['canv_sub_cat1_link']= $_POST['canv_sub_cat1_link'];

   

    

    $heading = strip_tags(trim($_POST['heading']));

    $order_show = strip_tags(trim($_POST['order_show']));

    $admin_comment = $_POST['admin_comment'];

  

     $show_value=$_POST['show_value'];

     $va_cat_id=$_POST['va_cat_id'];

     $va_sub_cat_id=$_POST['va_sub_cat_id'];





    if($page_name == '')

    {

      $error = true;

      $err_msg = 'Please select Page';

    }





    $check_=$_POST['check_'];

    $checkvalue=$_POST['checkvalue'];

    $report_header=$_POST['report_header'];

    $row_col=$_POST['row_col'];

    $query_field_Y_N=$_POST['query_field_Y_N'];

    $query_order=$_POST['query_order'];

    $query_combo=$_POST['query_combo'];

    $report_field_Y_N=$_POST['report_field_Y_N'];

    $report_order=$_POST['report_order'];

    $is_action=$_POST['is_action']; // add by  ample 04-05-20

    $tables_names=$_POST['tables_names'];

    $columns_dropdown=$_POST['columns_dropdown'];

    $columns_dropdown_value=$_POST['columns_dropdown_value'];



   // echo "<pre>";print_r($check_);echo "</pre>";
   //validation code comment by ample 07-11-19
   // if($check_=="")

   // {

   //   $error = true;

   //   $err_field_msg_check = 'Please Select your columns checkbox.';

   // }





    $arr=array(

      $checkvalue,

      $report_header,

      $row_col,

      $query_field_Y_N,

      $query_order,

      $query_combo,

      $report_field_Y_N,

      $report_order,

      $tables_names,

      $columns_dropdown,

      $columns_dropdown_value



    );











    foreach($checkvalue as $key=>$cols_name)

    {

       if($cols_name!="")

       {

        $get_key[]=$key;

       } 

    }



   foreach($get_key as $find_key_value)

   {

     $first_[] = array_column($arr,$find_key_value);

   }

// echo "<pre>";print_r($first_);echo "</pre>";

   // for($i=0;$i<count($arr);$i++)

   // {

  

   //   $first_[] = array_column($arr,$i);

   //   echo "<pre>";print_r($first_);echo "</pre>";



   // }



    foreach($first_ as $getselected)

    {

        if($getselected[0]!='')

        {

            $getselected_data[]=$getselected;

        }

    }







  //validation code comment by ample 07-11-19

// foreach($getselected_data as $key=>$tblvalue)

// {

//       // echo "<pre>";print_r($tblvalue);echo "</pre>"; 



//   // 0:colums name

//   // 1:report label

//   // 2:R/C

//   // 3: query field

//   // 4:query order

//   // 5:Query date

//   // 6:report field

//   // 7:report order





//      if($tblvalue[6]=='Yes')

//        {

//           if($tblvalue[1]=="")

//           {

//           $error = true;

//           $err_field_msg_empty[] = 'Your report lable ['.$tblvalue[0].'] field is Empty.';

//           }



//           if($tblvalue[2]=='' && $tblvalue[5]!='query_date')

//           {

//             $empty_RC="Select Rows/colums Field";

//             $error = true;

//           }



//           if($tblvalue[7]=='' && $tblvalue[5]!='query_date')

//           {

//             $empty_RO="Select your report order.";

//             $error = true;

//           }



//       }





//         if($tblvalue[2]=='Rows')

//             {

//             $row_order[]=$tblvalue[7];

//             }



//             if($tblvalue[2]=='Colums')

//             {

//             $col_order[]=$tblvalue[7];

//             }



         



//         if($tblvalue[5]=='query_date')

//         {

//            if($tblvalue[3]=='')

//             {

//               $empty_QF="Select your query field";

//               $error = true;

//             }

//         }



      

//        if($tblvalue[3]=='Yes')

//        {

//             if($tblvalue[6]=='')

//             {

//               $empty_RF="Select your report field.";

//               $error = false;

//             }

//        }



//         $keyword_for_query_order[]=$tblvalue[4];

//         $date_query_for_Qc[]=$tblvalue[5];

   

// }



     // exit;



        $row_order_unitc = array_unique($row_order);

        if(count($row_order)!=count($row_order_unitc))

        {

            $error = true;

            $err_field_msg_row = 'There are duplicate row value.';

        }





        $col_order_unitc = array_unique($col_order);

        if(count($col_order)!=count($col_order_unitc))

        {

            $error = true;

            $err_field_msg_colums = 'There are duplicate colums value.';



        }



          //validation code comment by ample 07-11-19

        // if(!in_array(1,$keyword_for_query_order))

        // {

        //     $error = true;

        //    $err_field_msg_query_ord_1 = 'At least! One Query order should be 1.';

        // }

       

        // if(!in_array(2,$keyword_for_query_order))

        // {

        //     $error = true;

        //    $err_field_msg_query_ord_2 = 'At least! One Query order should be 2.';

        // }



      

        // if(!in_array('query_date',$date_query_for_Qc))

        // {

        //     $error = true;

        //     $err_field_msg_query_date = 'At least! One Query date should be.';

        // }

       

        

         $val_count=array_count_values($date_query_for_Qc);

         $get_query_value=$val_count['query_date'];

         if($get_query_value>1)

         {

             $error = true;

             $err_field_msg_query_date_allowed = 'Only One query date allowed.';

         }





        // echo "<pre>";print_r($val_count);echo "</pre>";   

        // echo "<pre>";print_r($row_order);echo "</pre>";

        // echo "<pre>";print_r($col_order);echo "</pre>";

     // exit;

    if(!$error)

    {

        //update by ample 04-05-20

        if($obj->addRecordsDropdown($ref_code,$admin_comment,$fav_cat_type_id_0,$healcareandwellbeing,$page_type,$page_name,$heading,$table_dropdown_ref,$data_source,$report_name,$prof_cat1,$arr_selected_cat_id1,$cat_fetch_show_data,$canv_sub_cat_link,$order_show,$admin_id,$arr,$checkvalue,$show_value,$va_cat_id,$va_sub_cat_id,$is_action))

        {

            $msg = "Record Added Successfully!";

            header('location: index.php?mode=report_customisation&msg='.urlencode($msg));

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

    $pdm_id = '';

    

}	

?>

<div id="central_part_contents">

    <div id="notification_contents">

    <?php

    if($error)

    { ?>

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

                            <td class="notification-body-e">

                                <?php 

                                  echo $err_msg ."<br>";

                                  echo $err_field_msg_report_name."<br>";

                                  echo $err_field_msg_check."<br>";

                                  echo $empty_RC."<br>";

                                  echo $empty_QF."<br>";

                                  echo $empty_RF."<br>";

                                  echo $empty_RO."<br>";

                                 foreach($err_field_msg_empty as $msgme_value)

                                 {

                                  echo $msgme_value."<br>";

                                 }

                                 echo $err_field_msg_query_ord_1."<br>";

                                 echo $err_field_msg_query_ord_2."<br>";

                                 echo $err_field_msg_row."<br>";

                                 echo $err_field_msg_colums."<br>";

                                 echo $err_field_msg_query_date."<br>";

                                 echo $err_field_msg_query_date_allowed."<br>";



                                ?>

                                    

                                </td>

                        </tr>

                    </tbody>

                    </table>

                </td>

            </tr>

        </tbody>

        </table>

    <?php

    } ?>

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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Report Customisation</td>

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

                            <form action="#" method="post" name="frmadd_my_relation" id="frmadd_my_relation" enctype="multipart/form-data" >

                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">

                                <tbody>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                     <tr>

                                        <td width="30%" align="right" valign="top"><strong>Reference Code</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <input type="text" name="ref_code" id="ref_code" style="width:200px;height: 24px;">

                                           

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    <tr>

			                          		<td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                        <tr>

                                            <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>

                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                            <td width="65%" align="left" valign="top">

                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"></textarea>



                                            </td>

                                        </tr>

                                        <tr>

                                                <td colspan="3" align="center">&nbsp;</td>

                                        </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>System Category</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id_0" id="fav_cat_type_id_0" required="" style="width:200px; height: 24px;" onchange="getMainCategoryOption('0','healcareandwellbeing')">                                                

                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>System Sub Category</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top" id="fav_cat_id_0">

<!--                                            <select name="healcareandwellbeing[]" id="healcareandwellbeing" style="width:200px; height: 90px;" multiple>

                                               

                                                 <?php //echo $obj1->getFavCategoryRamakant('42',$fav_cat_id)?>

                                            </select>-->

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Page Type</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="page_type" id="page_type" style="width:200px; height: 24px;" required="" onchange="getDatadropdownPage('24')">

                                                <option value="">Select Page Type</option>

                                                <option value="Menu">Menu</option>

                                                <option value="Page">Page</option>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <!-- onchange="return get_storevalue();" -->

                                        <td width="30%" align="right" valign="top"><strong>Page Name</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="page_name" id="page_name" style="width:200px; height: 24px;" onchange="getpagenamesession();">

                                                <option value="">Select Page Name</option>

                                                <?php echo $obj->getDatadropdownPage('24','','');?>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Header <input type="text" name="heading" id="heading" >

                                        </td>

                                    </tr>



                                      <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>



<!-- ------------------------------------------------- -->



                                    <tr>

                                        <td width="30%" align="right" valign="top"><strong>Table Dropdown Ref.</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="table_dropdown_ref" id="table_dropdown_ref" style="width:200px; height: 24px;" onchange="return getTableOnRef();">

                                                <option value="">Select table dropdown</option>

                                               <?php echo $obj->getTableNamedropdown();?>

                                            </select>

                                        </td>

                                    </tr>

                                    <!-- --- -->

                                    

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Data Source</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="data_source" id="data_source" style="width:200px; height: 24px;" onchange="return getTableColums();">

                                                <option value="">Select Data Source</option>

                                            </select>

                                            &nbsp; &nbsp; &nbsp;

                                            Action : 

                                            <select name="is_action" id="is_action" style="width:200px; height: 24px;">

                                                <option value="0">Select</option>

                                                <option value="1">Check key status</option>

                                                <option value="2">Check User Plan</option>

                                                <option value="3">Check Vendor Plan</option>

                                            </select>

                                        </td>

                                    </tr>





                                    <tr>

                                       <td colspan="3" align="center">&nbsp;</td>

                                   </tr>



                                  

                <!-- <td align="left" valign="top" style="width:50%;">

                        <?php //echo $obj->getTableNameOptions_dropdown();?>

                  </td> -->









                                <tr>

                  <td align="right"></td>

                  <td align="center"></td>

                  <tr>

                                        

                      <td width="30%" align="right" valign="top"><strong>Report name</strong></td>

                      <td width="5%" align="center" valign="top"><strong>:</strong></td>

                      <td width="65%" align="left" valign="top">

                        <input type="text" name="report_name" id="report_name" style="width:200px; height: 24px;" onkeyup="return getreportsession();">

                      </td>

                  </tr>

                </tr>

                <tr>

                  <td colspan="3" align="center">&nbsp;</td>

                </tr>



                <tr>

                  <td align="right">

                    

                  </td>

                  <td align="center"></td>

                  <td align="left">

                     <table align="left" border="0" width="100%" cellpadding="0" cellspacing="0"  id="getcolums" class="tblCustomers"></table> 

                </td>

               </tr>



                <tr>

                         <td></td>

                         <td></td>

                         <td>

                          <ul style="padding:2%;">

                              <li style="list-style: none; color:red;font-size: 13px;">-Report Label for Time, Scale, Duration (in this Upper &  Loower Case Format), otherwise js issue & range boxes will NOT be seen.</li>

                            <!--   <li style="list-style: none;color:red;font-size: 13px;">-Select either ONLY Value Or ID for query 1,2,3. If select both, it will give error & Report will not be generated.</li> -->



                               <li style="list-style: none;color:red;font-size: 13px;">-Select query 1 for keywords</li>

                               <li style="list-style: none;color:red;font-size: 13px;">-Select query 2 for Criteria1</li>

                               <li style="list-style: none;color:red;font-size: 13px;">-Select query 3 for Criteria2</li>

                               <li style="list-style: none;color:red;font-size: 13px;">-Select query 4 for Parameters</li>

                              <li style="list-style: none;color:red;font-size: 13px;">-Atleast select One query date from dropdown</li>

                              <li style="list-style: none;color:red;font-size: 13px;">-At least! One Query order should be 1,2</li>

                             <li style="list-style: none;color:red;font-size: 13px;">-At least! One Query date should be</li>

                             <!--add by ample 24-03-20 -->
                             <li style="list-style: none;color:red;font-size: 13px;">-Atleast ONE TK  selected in R/C field</li>
                             <li style="list-style: none;color:red;font-size: 13px;">-TK Value will be displayed on TOP of each VIEW Table in frontend, in the Report Order selected</li>
                             <li style="list-style: none;color:red;font-size: 13px;">-selection of MH in R/C column is NOT compulsory</li>
                             <li style="list-style: none;color:red;font-size: 13px;">-MH Value will be displayed ONCE on Top of the entire Pattern Tables, below the Disclaimer.</li>

                           </ul>

                         </td>

                       </tr>

<!-- ---------------------------------------------------------------------- -->

                    <tr>

                      <td colspan="3" align="center">&nbsp;</td>

                    </tr>

                                      

                                    <!-- ------ -->

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category1</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id" id="fav_cat_type_id" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore()">

                                                <option value="">Select Prof Cat</option>

                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>

                                            </select>



                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat1_show_fetch" value="1">Show

                                             &nbsp;&nbsp;



                                            <input type="radio" name="canv_sub_cat1_show_fetch" value="2">Fetch



                                            &nbsp;&nbsp;&nbsp;Link 

                                            <select name="canv_sub_cat1_link" id="canv_sub_cat1_link">
                                              <!-- add by ample-->
                                               <?php echo $obj->getTableNameFrom_tbltabldropdown('3',$canv_sub_cat1_link); ?> 

                                               <!--  <option value="">Select</option>

                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat1_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>

                                                <option value="tblsolutionitems" <?php if($canv_sub_cat1_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>

                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat1_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>

                                                <option value="tbldailyactivity" <?php if($canv_sub_cat1_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>

                                                <option value="tbl_event_master" <?php if($canv_sub_cat1_link == 'tbl_event_master'){ echo 'selected'; } ?>>tbl_event_master</option> -->

                                            </select>

                                        </td>

                                    </tr>



                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category1</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id" align="left" valign="top">

                                            

                                            <?php // echo $obj->($arr_selected_cat_id2,'0','300','200');?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                          

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>



                                    <!--   <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr> -->



                                      <tr>                                                                    

                                        <td align="right" valign="top"><strong>Show</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="show_value" style="width:200px; height: 24px;" onchange="ChangeShowData();" id="show_value">

                                               <option value="">-Select-</option>

                                               <!-- <option value="all">All</option> -->

                                               <option value="user">User</option>

                                               <option value="admin">Admin</option>

                                               <option value="wa">Wellness Associate</option>

                                            </select>

                                        </td>

                                    </tr>

                                      <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>







                             <tr id="your_buss_cate" style="display: none;">

                                  <td align="right" valign="top"> <strong>Your Business category</strong></td>

                                  <td align="center" valign="top"><strong>:</strong></td>

                                  <td  align="left" valign="top">

                                  <!-- <div class="form-group"> -->

                                   <select name="va_cat_id" id="va_cat_id" class="input-text-box" onchange="getvendoraccesssubcat();" style="width:200px; height: 24px;">



                                      <?php echo $obj->getvendoraccesdropdownmain(''); ?>  

                                    </select>

                                  <!-- </div> -->

                                </td>

                              </tr>

                                   <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>





                                  <tr id="your_buss_sub_cate" style="display: none;">

                                    <td align="right" valign="top"> <strong>Your Business sub category</strong></td>

                                     <td align="center" valign="top"><strong>:</strong></td>

                                       <!-- <div class="form-group"> -->

                                      <td  align="left" valign="top">

                                       <select name="va_sub_cat_id" id="va_sub_cat_id" class="input-text-box" style="width:200px; height: 24px;">

                                        <option value="">Select</option>

                                    </select>

                                  </td>

                                  </tr>



                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>





                                      <tr>                                                                    

                                        <td align="right" valign="top"><strong>Order</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="order_show" style="width:200px; height: 24px;">

                                                <?php for($i=1;$i<=50;$i++) { ?>

                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>

                                                <?php } ?>

                                            </select>

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

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

     <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

	<script type="text/javascript">

		tinyMCE.init({

			mode : "exact",

			theme : "advanced",

			elements : "admin_comment",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

		});

    </script>

    <script>





function ChangeShowData()

{

  

  var show_value=$('#show_value').val();

  if(show_value=='wa')

  {

    $('#your_buss_cate').show();

    $('#your_buss_sub_cate').show();

  }

  else

  {

     $('#your_buss_cate').hide();

    $('#your_buss_sub_cate').hide();



  }



}







function getvendoraccesssubcat()

       {

           var va_cat_id = $("#va_cat_id").val();

           var dataString = 'action=getvendoraccesssubcat&va_cat_id='+va_cat_id;

            $.ajax({

                   type: "POST",

                   url: "include/remote.php", 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                            //alert(result);

                         var JSONObject = JSON.parse(result);

                         //var rslt=JSONObject[0]['status'];   

                        $('#va_sub_cat_id').html(JSONObject[0]['va_sub_cat_id']);

                       }

              }); 

       }







        

function getMainCategoryOption(serial,checkboxname)

{

        

	var parent_cat_id = $("#fav_cat_type_id_0").val();

        var id='0';

//        alert(parent_cat_id);

        //var sub_cat = $("#fav_cat_id_"+idval).val();

        //alert(parent_cat_id);

	var dataString = 'action=getsubcatoptionCommon&parent_cat_id='+parent_cat_id+'&id='+id+'&serial='+serial+'&checkboxname='+checkboxname;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id_0").html(result);

		}

	});

}





function getMainCategoryOptionAddMore()

{

        

	var parent_cat_id = $("#fav_cat_type_id").val();

        var id='';

//        alert(parent_cat_id);

        //var sub_cat = $("#fav_cat_id_"+idval).val();

        //alert(parent_cat_id);

	var dataString = 'action=getsubcatoption&parent_cat_id='+parent_cat_id+'&id='+id;

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





 function getMainCategoryOptionAddMore2()

{

        

	var parent_cat_id = $("#fav_cat_type_id2").val();

        var id='';



	var dataString = 'action=getsubcat2option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id2").html(result);

		}

	});

}



 function getMainCategoryOptionAddMore3()

{

        

	var parent_cat_id = $("#fav_cat_type_id3").val();

        var id='';

	var dataString = 'action=getsubcat3option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id3").html(result);

		}

	});

}

 function getMainCategoryOptionAddMore4()

{

        

	var parent_cat_id = $("#fav_cat_type_id4").val();

        var id='';

	var dataString = 'action=getsubcat4option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id4").html(result);

		}

	});

}



 function getMainCategoryOptionAddMore5()

{

        

	var parent_cat_id = $("#fav_cat_type_id5").val();

        var id='';

	var dataString = 'action=getsubcat5option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id5").html(result);

		}

	});

}

 function getMainCategoryOptionAddMore6()

{

        

	var parent_cat_id = $("#fav_cat_type_id6").val();

        var id='';

	var dataString = 'action=getsubcat6option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id6").html(result);

		}

	});

}



 function getMainCategoryOptionAddMore7()

{

        

	var parent_cat_id = $("#fav_cat_type_id7").val();

        var id='';

	var dataString = 'action=getsubcat7option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id7").html(result);

		}

	});

}

 function getMainCategoryOptionAddMore8()

{

        

	var parent_cat_id = $("#fav_cat_type_id8").val();

        var id='';

	var dataString = 'action=getsubcat8option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id8").html(result);

		}

	});

}



 function getMainCategoryOptionAddMore9()

{

        

	var parent_cat_id = $("#fav_cat_type_id9").val();

        var id='';

	var dataString = 'action=getsubcat9option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

                        //alert(sub_cat);

			$("#fav_cat_id9").html(result);

		}

	});

}

 function getMainCategoryOptionAddMore10()

{

        

	var parent_cat_id = $("#fav_cat_type_id10").val();

        var id='';

	var dataString = 'action=getsubcat10option&parent_cat_id='+parent_cat_id+'&id='+id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			$("#fav_cat_id10").html(result);

		}

	});

}



function getDatadropdownPage(idval)

{

        var pdm_id = idval;

        var page_type = $("#page_type").val();

          sessionStorage.setItem('page_type',page_type);

	    var dataString = 'action=getDatadropdownPage&pdm_id='+pdm_id+'&page_type='+page_type;

	 $.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			$("#page_name").html(result);

           sessionStorage.setItem('page_type_drop',result);



		}

	});  

}

$('#page_name').html(sessionStorage.getItem('page_type_drop'));



function getTableOnRef()

{

  var table_dropdown_ref=$('#table_dropdown_ref').val();

    sessionStorage.setItem('table_dropdown_ref', table_dropdown_ref);

  var dataString = 'action=getTabldropdownKR&tablm_id='+table_dropdown_ref;

  $.ajax({

    type: "POST",

    url: "include/remote.php",

    data: dataString,

    cache: false,

    success: function(result)

    {

      if(result!=0)

      {

         $("#data_source").html(result);

         sessionStorage.setItem('data_source_drop', result);

      }

      else

      {

        alert('No table name.');

        $("#data_source").html('<option>Select Data Source</option>');

      }

    }

  }); 



}



$('#data_source').html(sessionStorage.getItem('data_source_drop'));





function Selectable(get)

{   

    var table_name=$('#tables_names'+get).val();   

    var dataString = 'action=getTableColumnsNameKR&tablm_name='+table_name+'&get='+get;

      $.ajax({

        type: "POST",

        url: "include/remote.php",

        dataType:'JSON',

        data: dataString,

        cache: false,

        success: function(result)

        {

         $('#columns_dropdown'+get).html(result);

         $('#columns_dropdown_value'+get).html(result);

        }

      });



}









function getTableColums()

{

    var data_source=$('#data_source').val();

    sessionStorage.setItem('data_source',data_source);



     for(var i=0;i<100;i++)

     {

          var num=Number(i)+Number(1);

          // oninput_reportname(num);

          get_query_field(num);

          get_query_order(num);

          get_query_combo(num);

          row_colums(num);

          get_report_field(num);

          get_report_order(num);

     }

    allcol();





     var dataString = 'action=getTableColumsKR&tablm_name='+data_source;

      $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

          if(result!=0)

          {

            sessionStorage.setItem("value", result);



                 // for(var i=0;i<100;i++)

                 // {

                 //      var a=Number(i)+Number(1);

                 //    $('#query_field_Y_N1').val(sessionStorage.getItem('query_field_Y_N1'));

                 // }



            // console.log(result)

           $('#getcolums').html(result);

          }

          else

          {

            $('#getcolums').html('');

          }

        }

      });



}



   var getvalue= sessionStorage.getItem("value");

    if(getvalue!=null)

    {

        document.getElementById("getcolums").innerHTML = getvalue;   

    }





function selectcheck(num,colums)

{

if($('#check_'+num).is(":checked")) {

    $('#checkvalue'+num).val(colums);



     sessionStorage.setItem('check_'+num, true);

     sessionStorage.setItem('checkvalue'+num, colums);



     









     getkeepling(num);

  }

   else

  {

     $('#checkvalue'+num).val('');

     sessionStorage.setItem('check_'+num, false);

     sessionStorage.setItem('checkvalue'+num, '');

     getkeepling(num);

  }

}









function getkeepling(num)

{

    var checked = JSON.parse(sessionStorage.getItem('check_'+num));

}



function oninput_reportname(num)

{

    var repor_nam=$('#report_header'+num).val();

    sessionStorage.setItem('report_header'+num, repor_nam);

}



function get_query_field(num)

{

    var query_field_Y_N=$('#query_field_Y_N'+num).val();

    sessionStorage.setItem('query_field_Y_N'+num, query_field_Y_N);

}



function get_query_order(num)

{

    var query_order=$('#query_order'+num).val();

    sessionStorage.setItem('query_order'+num, query_order);  

}



function get_query_combo(num)

{

     var query_combo=$('#query_combo'+num).val();

     sessionStorage.setItem('query_combo'+num, query_combo);  



    // var query_combo=$('#row_col'+num).val('');



    // alert(query_combo);

     // sessionStorage.setItem('row_col'+num,'');     



    // var report_order=$('#report_order'+num).val(0);

     // sessionStorage.setItem('report_order'+num,0);   



}



function row_colums(num)

{

  var query_combo=$('#row_col'+num).val();

     sessionStorage.setItem('row_col'+num, query_combo);     

}

function get_report_field(num)

{

   var query_combo=$('#report_field_Y_N'+num).val();

     sessionStorage.setItem('report_field_Y_N'+num, query_combo);   

}

function get_report_order(num)

{

     var report_order=$('#report_order'+num).val();

     sessionStorage.setItem('report_order'+num, report_order);   

}



function getreportsession()

{

    var report_name=$('#report_name').val();

     sessionStorage.setItem('report_name', report_name);   

}



function getpagenamesession()

{

    var page_name1=$('#page_name').val();

     sessionStorage.setItem('page_name1', page_name1);  

}



// function 

function allcol()

{

     var countfeild=$('.chkbxapaid').length;

     for(var i=0;i<countfeild;i++)

     {

          var a=Number(i)+Number(1);

          var checked1 = JSON.parse(sessionStorage.getItem('check_'+a));

          document.getElementById('check_'+a).checked = checked1; 



         $('#checkvalue'+a).val(sessionStorage.getItem('checkvalue'+a));

         $('#report_header'+a).val(sessionStorage.getItem('report_header'+a));

         $('#query_field_Y_N'+a).val(sessionStorage.getItem('query_field_Y_N'+a));

         $('#query_order'+a).val(sessionStorage.getItem('query_order'+a));

         $('#query_combo'+a).val(sessionStorage.getItem('query_combo'+a));



         // console.log(sessionStorage.getItem('report_order'+a));

         $('#row_col'+a).val(sessionStorage.getItem('row_col'+a));

         $('#report_field_Y_N'+a).val(sessionStorage.getItem('report_field_Y_N'+a));

         $('#report_order'+a).val(sessionStorage.getItem('report_order'+a));

     }





       $('#page_type').val(sessionStorage.getItem('page_type'));

       $('#table_dropdown_ref').val(sessionStorage.getItem('table_dropdown_ref'));

       $('#data_source').val(sessionStorage.getItem('data_source'));

       $('#report_name').val(sessionStorage.getItem('report_name'));

      $('#page_name').val(sessionStorage.getItem('page_name1'));

    // console.log(countfeild);

    }

   allcol();





   function ChangeQueryDate(index)

   {

    // query_date

     var values=$('#query_combo'+index).val();

     if(values=='query_date')

     {

      $('#row_col'+index).html('<option value=""></option><option value="Rows">Rows</option><option value="Colums">Colums</option>');





         var html= '<option value="0">0</option>'+

         '<?php for($i=1;$i<16;$i++){?>'+

                    '<option value="<?php echo $i;?>"><?php echo $i;?></option>'+ 

                   '<?php }?>';



      $('#report_order'+index).html(html);



      // sessionStorage.setItem('row_col'+index,'');     

      // sessionStorage.setItem('report_order'+index,0); 



       document.getElementById('row_col'+index).disabled=true;

       document.getElementById('report_order'+index).disabled=true;



     }

     else

     {



    var html1='<option value="Rows">Rows</option><option value="Colums">Colums</option>';

     $('#row_col'+index).html(html1);

       

       var html= '<?php for($i=1;$i<16;$i++){?>'+

                    '<option value="<?php echo $i;?>"><?php echo $i;?></option>'+ 

                   '<?php }?>';

     $('#report_order'+index).html(html);



     document.getElementById('row_col'+index).disabled=false;

     document.getElementById('report_order'+index).disabled=false;



      // sessionStorage.setItem('row_col'+index,html1);     

      // sessionStorage.setItem('report_order'+index,html); 

     }



   }



    </script>

</div>