<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');  
require_once('classes/class.places.php');

require_once('classes/class.dailymeals.php');
$obj1 = new Daily_Meals();
$obj = new Contents();
$obj2 = new Places();


require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

$edit_action_id = '356';

if(!$obj->isAdminLoggedIn())
{
    header("Location: index.php?mode=login");
    exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
{	
    header("Location: index.php?mode=invalid");
    exit(0);
}

$error = false;
$err_msg = "";

$prof_cat1 = array();
// $prof_cat2 = array();
// $prof_cat3 = array();
// $prof_cat4 = array();
// $prof_cat5 = array();
// $prof_cat6 = array();
// $prof_cat7 = array();
// $prof_cat8 = array();
// $prof_cat9 = array();
// $prof_cat10 = array();

if(isset($_POST['btnSubmit']))
{
    
   // echo '<pre>';
   // print_r($_POST);
   // echo '</pre>';
   // die();
    $id = strip_tags(trim($_POST['hdnpd_id']));
    $healcareandwellbeing = $_POST['healcareandwellbeing'];
    
    $time_show = $_POST['time_show'];
    $duration_show = $_POST['duration_show'];
    $location_show = $_POST['location_show'];
    $like_dislike_show = $_POST['like_dislike_show'];
    $set_goals_show = $_POST['set_goals_show'];
    $scale_show = $_POST['scale_show'];
    $reminder_show = $_POST['reminder_show'];
    $comments_show = $_POST['comments_show'];
    $heading = strip_tags(trim($_POST['heading']));
    $order_show = strip_tags(trim($_POST['order_show']));
    
    $location_category = implode(',', $_POST['location_category']);
    $user_response_category = implode(',', $_POST['user_response_category']);
    $user_what_next_category = implode(',', $_POST['user_what_next_category']);
    $alerts_updates_category = implode(',', $_POST['alerts_updates_category']);
    $data_source = $_POST['data_source'];
    
    
    $arr_heading = array();
    $arr_heading['time_heading']=$_POST['time_heading'];
    $arr_heading['duration_heading']=$_POST['duration_heading'];
    $arr_heading['location_heading']=$_POST['location_heading'];
    $arr_heading['like_dislike_heading']=$_POST['like_dislike_heading'];
    $arr_heading['set_goals_heading']=$_POST['set_goals_heading'];
    $arr_heading['scale_heading']=$_POST['scale_heading'];
    $arr_heading['reminder_heading']=$_POST['reminder_heading'];
    $arr_heading['comments_heading']=$_POST['comments_heading'];
    
    $page_name = strip_tags(trim($_POST['page_name']));
    $pag_cat_status = strip_tags(trim($_POST['pag_cat_status']));
    $ref_code = strip_tags(trim($_POST['ref_code']));
    $prof_cat1 = $_POST['fav_cat_type_id'];
    

    $table_dropdown_ref=$_POST['table_dropdown_ref'];
    $data_source=$_POST['data_source'];
    $report_name=$_POST['report_name'];
   

    
    $arr_selected_cat_id1 = $_POST['selected_cat_id1'];
    $admin_comment = $_POST['admin_comment'];

     $show_value=$_POST['show_value'];
     $va_cat_id=$_POST['va_cat_id'];
     $va_sub_cat_id=$_POST['va_sub_cat_id'];


    $cat_fetch_show_data = array();
    
    if(isset($_POST['canv_sub_cat1_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat1_show_fetch']= $_POST['canv_sub_cat1_show_fetch']; // Displaying Selected Value
    }    
    

    
    $canv_sub_cat_link = array();
    $canv_sub_cat_link['canv_sub_cat1_link']= $_POST['canv_sub_cat1_link'];

   
    if($page_name == '')
    {
        $error = true;
        $err_msg = 'Please select Page';
    }

    $get_unoqu=$_POST['get_unoqu'];
    $get_col_id=$_POST['get_col_id'];
    $check_=$_POST['check_'];
    $checkvalue=$_POST['checkvalue'];
    $report_header=$_POST['report_header'];
    $row_col=$_POST['row_col'];
    $query_field_Y_N=$_POST['query_field_Y_N'];
    $query_order=$_POST['query_order'];
    $query_combo=$_POST['query_combo'];
    $report_field_Y_N=$_POST['report_field_Y_N'];
    $report_order=$_POST['report_order'];

    $tables_names=$_POST['tables_names'];
    $columns_dropdown=$_POST['columns_dropdown'];
    $columns_dropdown_value=$_POST['columns_dropdown_value'];

  
    $arr=array(
      $get_unoqu,
      $get_col_id,
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

 
    foreach($first_ as $getselected)
    {
        if($getselected[0]!='')
        {
            $getselected_data[]=$getselected;
        }
    }

foreach($getselected_data as $key=>$tblvalue)
{
   // echo "<pre>";print_r($tblvalue);echo "</pre>"; 

         if($tblvalue[8]=='Yes')
         {
             if($tblvalue[3]=="")
              {
              $error = true;
              $err_field_msg_empty[] = 'Your report lable ['.$tblvalue[2].'] field is Empty.';
              }


               if($tblvalue[4]=='' && $tblvalue[7]!='query_date')
                {
                  $empty_RC="Select Rows/colums Field";
                  $error = true;
                }


                 if($tblvalue[9]=='' && $tblvalue[7]!='query_date')
                  {
                    $empty_RO="Select your report order.";
                    $error = true;
                  }
         }



  
        if($tblvalue[4]=='Rows')
        {
        $row_order[]=$tblvalue[9];
        }



        if($tblvalue[4]=='Colums')
        {
        $col_order[]=$tblvalue[9];
        }


        if($tblvalue[7]=='query_date')
        {
           if($tblvalue[5]=='')
            {
              $empty_QF="Select your query field";
              $error = true;
            }
        }



      // if($tblvalue[5]!='Yes') 
      //    {
      //         if($tblvalue[8]=='' ||$tblvalue[8]==0) 
      //         {
      //           $empty_RF="Select your report field.";
      //           $error = true;
      //         }
      //    }





    $keyword_for_query_order[]=$tblvalue[6];
    $date_query_for_Qc[]=$tblvalue[7];
   
}


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


        if(!in_array(1,$keyword_for_query_order))
        {
            $error = true;
           $err_field_msg_query_ord_1 = 'At least! One Query order should be 1.';
        }
       
        if(!in_array(2,$keyword_for_query_order))
        {
            $error = true;
           $err_field_msg_query_ord_2 = 'At least! One Query order should be 2.';
        }

        

        // echo "<pre>";print_r($date_query_for_Qc);echo "</pre>";
        if(!in_array('query_date',$date_query_for_Qc))
        {
            $error = true;
            $err_field_msg_query_date = 'At least! One Query date should be.';
        }


 
     $val_count=array_count_values($date_query_for_Qc);
     $get_query_value=$val_count['query_date'];
     if($get_query_value>1)
     {
         $error = true;
         $err_field_msg_query_date_allowed = 'Only One query date allowed.';
     }
      
   
    $page_cat_id = $_GET['id'];
     list($admin_comment_1,$arr_heading_1,$healcareandwellbeing_1,$page_name_1,$ref_code_1,$profcat1_1,$pag_cat_status_1,$heading_1,$time_show_1,$location_show_1,$like_dislike_show_1,$set_goals_show_1,$scale_show_1,$reminder_show_1,$order_show_1,$duration_show_1,$comments_show_1,$location_category_1,$user_response_category_1,$user_what_next_category_1,$alerts_updates_category_1,$canv_sub_cat1_link_1,$canv_sub_cat1_show_fetch_1,$page_type_1,$reference_name_1,$table_name_1,$report_name_1,$details_arr) = $obj->getDataRecordsDropdownDetails($page_cat_id);

     
    if(!$error)
    {
        $sub_cat1 = implode(',',$arr_selected_cat_id1);
        if($obj->updateRecordsCatDropdown($admin_comment,$arr_heading,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$prof_cat1,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source,$report_name,$arr,$checkvalue))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=report_customisation&msg='.urlencode($msg));
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
   // $pd_id = $_GET['id'];
     $page_cat_id = $_GET['id'];
     list($admin_comment,$arr_heading,$healcareandwellbeing,$page_name,$ref_code,$profcat1,$pag_cat_status,$heading,$time_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$order_show,$duration_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$canv_sub_cat1_link,$canv_sub_cat1_show_fetch,$page_type,$reference_name,$table_name,$report_name,$details_arr,$enduse,$wa_main_cat,$wa_sub_cat) = $obj->getDataRecordsDropdownDetails($page_cat_id);
       // echo "<pre>";print_r($details_arr);echo "</pre>";
     
       // exit;
        $oldvalue=0;
        if($prof_cat1!='')
        {
           $oldvalue= $oldvalue+1;
        }
   
    
    $prof_cat1 = explode(',',$prof_cat1);
  
}	
else
{
    header('location: index.php?mode=report_customisation');
    exit(0);
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
							<td class="notification-body-e">
                        
                                  <?php 
                                  echo $err_msg ."<br>";
                                  echo $err_field_msg_report_name."<br>";
                                  echo $err_field_msg_check."<br>";
                                  echo $empty_QF."<br>";
                                  echo $empty_RC."<br>";
                                  // echo $empty_RF."<br>";
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Report Customisation</td>
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
							<form action="" method="post" name="frmedit_my_relation" id="frmedit_my_relation" enctype="multipart/form-data" >
							<input type="hidden" name="hdnpd_id" id="hdnpd_id" value="<?php echo $page_cat_id;?>" />
                                                        <input type="hidden" name="oldvalue" id="oldvalue" value="<?php echo $oldvalue;?>" />
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                    <tr>
                                            <td width="30%" align="right"><strong>Status</strong></td>
                                            <td width="5%" align="center"><strong>:</strong></td>
                                            <td width="65%" align="left">
                                                <select id="pag_cat_status" name="pag_cat_status" style="width:200px;height: 24px;">
                                                    <option value="1" <?php if($pag_cat_status == '1'){ ?> selected <?php } ?>>Active</option>
                                                    <option value="0" <?php if($pag_cat_status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                </select>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Reference Code</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="ref_code" id="ref_code" style="width:200px;height: 24px;" value="<?php echo $ref_code;?>">
                                           
                                        </td>
                                    </tr>
                                     <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                        </tr>
                                    <tr>
                                            <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>
                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                            <td width="65%" align="left" valign="top">
                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo $admin_comment; ?></textarea>

                                            </td>
                                        </tr>
                                       
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>System Category</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type='text' name="healcareandwellbeing" id="healcareandwellbeing" style="width:200px; " value="<?php echo $healcareandwellbeing;?>" readonly/>
                                               
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Page Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="hidden" name="page_name" id="page_name" value="<?php echo $page_name; ?>">
                                           <?php echo $obj->getPagenamebyPage_menu_id('4',$page_name,$page_type); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Header <input type="text" name="heading" id="heading" value="<?php echo $heading; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>



                             <!-- ----------------------------- -->


                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Table Dropdown Ref.</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="table_dropdown_ref" id="table_dropdown_ref" style="width:200px; height: 24px;" onchange="return getTableOnRef();" disabled="">
                                                <option value="<?php echo $reference_name;?>"><?php echo $reference_name;?></option>
                                               <?php //echo $obj->getTableNamedropdown();?>
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
                                            <select name="data_source" id="data_source" style="width:200px; height: 24px;" onchange="return getTableColums();" disabled="">
                                                <option value="<?php echo $table_name;?>"><?php echo $table_name;?></option>
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                       <td colspan="3" align="center">&nbsp;</td>
                                   </tr>
                                <tr>
                                  <td align="right"></td>
                                  <td align="center"></td>
                                  <tr>
                                                        
                                      <td width="30%" align="right" valign="top"><strong>Report name</strong></td>
                                      <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                      <td width="65%" align="left" valign="top">
                                    <input type="text" name="report_name" id="report_name" style="width:200px; height: 24px;" value="<?php echo $report_name;?>">
                                      </td>
                                  </tr>
                                </tr>
                                <tr>
                                  <td colspan="3" align="center">&nbsp;</td>
                                </tr>


                                               
                                <tr>
                                  <td align="right"></td>
                                  <td align="center"></td>
                                  <td align="left">

                                   

                                     <table align="left" border="0" width="100%" cellpadding="0" cellspacing="0"  id="getcolums">
                                        <tr>
                                        <td><strong>ColumsName</strong></td>
                                        <td><strong>Checkbox</strong></td>
                                        <td><strong>Report-field Label</strong></td>
                                       
                                        <td><strong>Query field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                        <td><strong>Query Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                        <td><strong>Query Combo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                         <td><strong>R/C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                        <td><strong>Report field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                        <td><strong>Report Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                                         <td><strong>ID-Tables&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                        <td><strong>Fetch field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                         <td><strong>Fetch ID-Value&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                      </tr>

                                    <?php
                                     

                                    $index=0;

                                   foreach($details_arr as $del_value)
                                   {
                                     // echo "<pre>";print_r($del_value);echo "</pre>";
                                      if($del_value['uniqu_m_id']!='')
                                      {
                                        $checked='checked';
                                        $col_name=$del_value['col_name'];
                                      }
                                      else{
                                          $checked='';
                                          $col_name='';

                                      }
                                      $unique=$del_value['uniqu_m_id'];
                                   
                                  $index++;
                                    ?>
                                         <tr>
                                 <td width="15%" align="left"><?php echo $del_value['col_name'];?>

                                 </td>
                                  <td width="10%" align="left" valign="top">

                                    <input type="hidden" name="get_unoqu[]" id="get_unoqu<?php echo $index;?>" value="<?php echo $del_value['uniqu_m_id'];?>">
                                    <input type="hidden" name="get_col_id[]" id="get_col_id<?php echo $index;?>" value="<?php echo $del_value['col_id'];?>">
                                    <input type="hidden" name="checkvalue[]" id="checkvalue<?php echo $index;?>" value="<?php echo $col_name;?>">

                                    <input class="chkbxapaid" type="checkbox" name="check_[]" id="check_<?php echo $index;?>" value="<?php echo $del_value['col_name'];?>" onclick="return selectcheck(<?php echo $index;?>,'<?php echo $del_value['col_name'];?>');" <?php echo $checked;?>></td>

                                    <td width="20%" align="left" valign="top">
                                    <input type="text" name="report_header[]" id="report_header<?php echo $index;?>" value="<?php echo $del_value['col_report_label'];?>">
                                    </td>
                                   
                                     <td width="10%" valign="top">
                                        <select class="selapaid" name="query_field_Y_N[]" id="query_field_Y_N<?php echo $index;?>" style="width:60px;">
                                           <?php
                                           if($del_value['col_query_field']=="")
                                           {
                                            ?>
                                            <option value="">-Select-</option>
                                            <?php
                                           }else
                                           {
                                           ?>
                                            <option value="<?php echo $del_value['col_query_field'];?>"><?php echo $del_value['col_query_field'];?></option>
                                            <?php
                                           }
                                            ?>
                                              <option value="Yes">Yes</option>
                                              <option value="No">No</option>
                                              <option value="">-Select-</option>
                                        </select>
                                    </td>

                                     <td width="1%" valign="top">
                                        <select class="selapaid" name="query_order[]" id="query_order<?php echo $index;?>" style="width:60px;">
                                        <?php
                                        if($del_value['col_query_order']=="" ||$del_value['col_query_order']==0)
                                        {
                                          ?>
                                               <option value="">-Select-</option>
                                          <?php
                                        }
                                        else
                                        {
                                          ?>
                                            <option value="<?php echo $del_value['col_query_order'];?>"><?php echo $del_value['col_query_order'];?></option>
                                          <?php
                                        }
                                        ?>
                                           <?php
                                             for($i=1;$i<11;$i++)
                                               {
                                                 echo '<option value="'.$i.'">'.$i.'</option>'; 
                                                }
                                             ?>
                                            <option value="">-Select-</option>
                                             </select>
                                    </td>


                                     <td width="9%" valign="top">
                                        <select class="selapaid" name="query_combo[]" id="query_combo<?php echo $index;?>" style="width:60px;">
                                           
                                            <?php
                                            if($del_value['col_query_combo']=="")
                                            {
                                              ?>
                                                   <option value="">-Select-</option>
                                              <?php
                                            }
                                            else
                                            {
                                              ?>
                                                  <option value="<?php echo $del_value['col_query_combo'];?>"><?php echo $del_value['col_query_combo'];?></option>
                                              <?php
                                            }
                                            ?>
                                             <?php
                                             for($i=1;$i<6;$i++)
                                               {
                                               echo '<option value="QC'.$i.'">QC'.$i.'</option>'; 
                                                }
                                                echo '<option value="query_date">query date</option>'; 
                                                ?>
                                                <option value="">-Select-</option>
                                        </select>
                                    </td>

                                      <td align="left" valign="top">
                                        <select class="selapaid" name="row_col[]" id="row_col<?php echo $index;?>" style="width:60px;" >
                                        <?php
                                            if($del_value['col_row_col']=="")
                                            {
                                              ?>
                                                   <option value="">-Select-</option>
                                             <?php
                                            }
                                            else
                                            {
                                              ?>
                                                  <option value="<?php echo $del_value['col_row_col'];?>"><?php echo $del_value['col_row_col'];?></option>
                                              <?php
                                            }
                                            ?>
                                             
                                              <option value="Rows">Rows</option>
                                              <option value="Colums">Colums</option>
                                              <option value="">-Select-</option>
                                        </select>
                                    </td>


                                    <td width="9%" valign="top">
                                        <select class="selapaid" name="report_field_Y_N[]" id="report_field_Y_N<?php echo $index;?>" style="width:60px;">

                                          <?php
                                            if($del_value['col_report_feild']=="")
                                            {
                                              ?>
                                                   <option value="">-Select-</option>
                                             <?php
                                            }
                                            else
                                            {
                                              ?>
                                                    <option value="<?php echo $del_value['col_report_feild'];?>"><?php echo $del_value['col_report_feild'];?></option>
                                              <?php
                                            }
                                            ?>

                                           
                                              <option value="Yes">Yes</option>
                                              <option value="No">No</option>
                                              <option value="">-Select-</option>
                                        </select>
                                    </td>

                                     <td align="left" valign="top">
                                        <select class="selapaid" name="report_order[]" id="report_order<?php echo $index;?>" style="width:60px;">

                                           <?php
                                            if($del_value['col_report_order']=="" || $del_value['col_report_order']==0)
                                            {
                                              ?>
                                                   <option value="">-Select-</option>
                                             <?php
                                            }
                                            else
                                            {
                                              ?>
                                                     <option value="<?php echo $del_value['col_report_order'];?>"><?php echo $del_value['col_report_order'];?></option>
                                              <?php
                                            }
                                            ?>
                                             <?php
                                            for($i=1;$i<17;$i++)
                                            {
                                             echo '<option value="'.$i.'">'.$i.'</option>'; 
                                            }
                                            ?>
                                           <option value="">-Select-</option>
                                    </select>
                                </td>
                                 <td align="left" valign="top">

                                 <?php echo $obj->getTableNameOptions_dropdown($index,$del_value['Id_table']);?>
                                 </td>


                                <td align="left" valign="top">
                                  <select id="columns_dropdown<?php echo $index ;?>" style="width:100px;" name="columns_dropdown[]">
                                   <?php
                                  if($del_value['fetch_columns']!="")
                                  {
                                    ?>
                                    <option value="<?php echo $del_value['fetch_columns'];?>"><?php echo $del_value['fetch_columns'];?></option>
                                    <?php
                                  }
                                  else
                                  {
                                    ?>
                                    <option value="">-Select-</option>
                                    <?php
                                  }
                                   ?>
                                    </select>
                                </td>

                                <td align="left" valign="top">
                                  <select id="columns_dropdown_value<?php echo $index;?>" style="width:100px;" name="columns_dropdown_value[]">
                                    <?php
                                  if($del_value['fetch_value']!="")
                                  {
                                    ?>
                                    <option value="<?php echo $del_value['fetch_value'];?>"><?php echo $del_value['fetch_value'];?></option>
                                    <?php
                                  }
                                  else
                                  {
                                    ?>
                                    <option value="">-Select-</option>
                                    <?php
                                  }
                                   ?>
                                    </select>
                                </td>





                                </tr>
                                <?php
                               }
                                ?>


                                         
                             </table> 
                        </td>
                       </tr>
                       <tr>
                         <td></td>
                         <td></td>
                         <td>
                          <ul style="padding:2%;">
                              <li style="list-style: none; color:red;font-size: 13px;">-Report Label for Time, Scale, Duration (in this Upper &  Loower Case Format), otherwise js issue & range boxes will NOT be seen.</li>
                              <!-- <li style="list-style: none;color:red;font-size: 13px;">-Select either ONLY Value Or ID for query 1,2,3. If select both, it will give error & Report will not be generated.</li> -->

                               <li style="list-style: none;color:red;font-size: 13px;">-Select query 1 for keywords</li>
                               <li style="list-style: none;color:red;font-size: 13px;">-Select query 2 for Criteria1</li>
                              <li style="list-style: none;color:red;font-size: 13px;">-Select query 3 for Criteria2</li>
                               <li style="list-style: none;color:red;font-size: 13px;">-Select query 4 for Parameters</li>

                              <li style="list-style: none;color:red;font-size: 13px;">-Atleast select One query date from dropdown</li>

                               <li style="list-style: none;color:red;font-size: 13px;">-At least! One Query order should be 1,2</li>
                             <li style="list-style: none;color:red;font-size: 13px;">-At least! One Query date should be</li>

                           </ul>
                         </td>
                       </tr>






                                       <!-- ------------------------------------------------ -->


                                    
                                   <!--  <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Data Source</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="data_source" id="data_source" style="width:200px; height: 24px;" >
                                                <option value="">Select Data Source</option>
                                               <?php echo $obj->getDatadropdownPage('6',$data_source,'');?>
                                            </select>
                                        </td>
                                    </tr> -->
                                    
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category1</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id" id="fav_cat_type_id" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat1);?>
                                            </select>


                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat1_show_fetch" <?php if($canv_sub_cat1_show_fetch == 1){ echo 'checked'; } ?> value="1">Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat1_show_fetch" <?php if($canv_sub_cat1_show_fetch == 2){ echo 'checked'; } ?> value="2">Fetch
                                            &nbsp;&nbsp;&nbsp;Link 



                                            <select name="canv_sub_cat1_link" id="canv_sub_cat1_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat1_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat1_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat1_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat1_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                                <option value="tbl_event_master" <?php if($canv_sub_cat1_link == 'tbl_event_master'){ echo 'selected'; } ?>>tbl_event_master</option>
                                            </select>
                                            <!--<input type="text" name="canv_sub_cat1_link" id="canv_sub_cat1_link" value="<?php //echo $canv_sub_cat1_link; ?>" >-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category1</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id" align="left" valign="top">
                                            
                                            <?php  //echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <!-- <tr> -->
                                        
                                       <!--  <td width="30%" align="right" valign="top"><strong>Profile Category2</strong></td> -->
                                        <!-- <td width="5%" align="center" valign="top"><strong>:</strong></td> -->
                                       <!--  <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id2" id="fav_cat_type_id2" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore2()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat2);?>
                                            </select>
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat2_show_fetch" value="1" <?php if($canv_sub_cat2_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat2_show_fetch" value="2" <?php if($canv_sub_cat2_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;
                                            <select name="canv_sub_cat2_link" id="canv_sub_cat2_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat2_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat2_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat2_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat2_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                                <option value="tbl_event_master" <?php if($canv_sub_cat2_link == 'tbl_event_master'){ echo 'selected'; } ?>>tbl_event_master</option>
                                            </select>
                                        </td> -->
                                    <!-- </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr> -->
                                   <!--  <tr>                                                                    
                                        <td align="right" valign="top"><strong>Sub Category2</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id2" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr> -->
                                   <!--  <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category3</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id3" id="fav_cat_type_id3" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore3()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat3);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat3_show_fetch" value="1" <?php if($canv_sub_cat3_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat3_show_fetch" value="2" <?php if($canv_sub_cat3_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat3_link" id="canv_sub_cat3_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat3_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat3_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat3_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat3_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                                <option value="tbl_event_master" <?php if($canv_sub_cat3_link == 'tbl_event_master'){ echo 'selected'; } ?>>tbl_event_master</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Sub Category3</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id3" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category4</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id4" id="fav_cat_type_id4" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore4()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat4);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat4_show_fetch" value="1" <?php if($canv_sub_cat4_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat4_show_fetch" value="2" <?php if($canv_sub_cat4_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat4_link" id="canv_sub_cat4_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat4_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat4_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat4_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat4_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category4</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id4" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category5</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id5" id="fav_cat_type_id5" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore5()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat5);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat5_show_fetch" value="1" <?php if($canv_sub_cat5_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat5_show_fetch" value="2" <?php if($canv_sub_cat5_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat5_link" id="canv_sub_cat5_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat5_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat5_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat5_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat5_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                  <!--   <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category5</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id5" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category6</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id6" id="fav_cat_type_id6" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore6()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat6);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat6_show_fetch" value="1" <?php if($canv_sub_cat6_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat6_show_fetch" value="2" <?php if($canv_sub_cat6_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat6_link" id="canv_sub_cat6_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat6_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat6_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat6_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat6_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category6</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id6" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category7</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id7" id="fav_cat_type_id7" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore7()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat7);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat7_show_fetch" value="1" <?php if($canv_sub_cat7_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat7_show_fetch" value="2" <?php if($canv_sub_cat7_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat7_link" id="canv_sub_cat7_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat7_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat7_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat7_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat7_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category7</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id7" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category8</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id8" id="fav_cat_type_id8" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore8()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat8);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat8_show_fetch" value="1" <?php if($canv_sub_cat8_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat8_show_fetch" value="2" <?php if($canv_sub_cat8_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat8_link" id="canv_sub_cat8_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat8_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat8_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat8_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat8_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category8</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id8" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category9</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id9" id="fav_cat_type_id9" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore9()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat9);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat9_show_fetch" value="1" <?php if($canv_sub_cat9_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat9_show_fetch" value="2" <?php if($canv_sub_cat9_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat9_link" id="canv_sub_cat9_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat9_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat9_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat9_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat9_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category9</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id9" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category10</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id10" id="fav_cat_type_id10" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore10()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat10);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat10_show_fetch" value="1" <?php if($canv_sub_cat10_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat10_show_fetch" value="2" <?php if($canv_sub_cat10_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat10_link" id="canv_sub_cat10_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat10_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat10_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat10_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat10_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category10</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id10" align="left" valign="top">
                                            
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Time (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="time_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($time_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($time_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="time_heading" id="time_heading" value="<?php/// echo $arr_heading['time_heading'] ?>" >
                                        </td>
                                    </tr> -->
                                  <!--    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Duration (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="duration_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($duration_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($duration_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="duration_heading" id="duration_heading"  value="<?php ///echo $arr_heading['duration_heading'] ?>">
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Location (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="location_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($location_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($location_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                             &nbsp;&nbsp;&nbsp;Heading <input type="text" name="location_heading" id="location_heading" value="<?php //echo $arr_heading['location_heading'] ?>">
                                        </td>
                                    </tr> -->
                                     <!-- <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Location Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php //echo $obj->getAllFavCatChkeckbox('location_category',$location_category,'200','150');?>                                           
                                        </td>
                                    </tr> -->
                                   <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User Response (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="like_dislike_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($like_dislike_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($like_dislike_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="like_dislike_heading" id="like_dislike_heading" value="<?php //echo $arr_heading['like_dislike_heading'] ?>">
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User Response Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php //echo $obj->getAllFavCatChkeckbox('user_response_category',$user_response_category,'200','150');?>                                           
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User What Next (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="set_goals_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($set_goals_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($set_goals_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="set_goals_heading" id="set_goals_heading" value="<?php //echo $arr_heading['set_goals_heading'] ?>">
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User What Next Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php //echo $obj->getAllFavCatChkeckbox('user_what_next_category',$user_what_next_category,'200','150');?>                                           
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Scale (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="scale_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($scale_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($scale_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="scale_heading" id="scale_heading" value="<?php //echo $arr_heading['scale_heading'] ?>">
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Alerts/Updates (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="reminder_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($reminder_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($reminder_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="reminder_heading" id="reminder_heading" value="<?php //echo $arr_heading['reminder_heading'] ?>">
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Alerts/Updates Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php //echo $obj->getAllFavCatChkeckbox('alerts_updates_category',$alerts_updates_category,'200','150');?>                                           
                                        </td>
                                    </tr> -->
                                    <!--  <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Comments (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="comments_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php //if($comments_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php //if($comments_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="comments_heading" id="comments_heading" value="<?php //echo $arr_heading['comments_heading'] ?>">
                                        </td>
                                    </tr> -->
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Show</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="show_value" style="width:200px; height: 24px;" onchange="ChangeShowData();" id="show_value" disabled>
                                              <?php
                                              if($enduse=="wa")
                                              {
                                              ?>
                                               <option value="wa">Wellness Associate</option>
                                              <?php
                                              }
                                              else if($enduse=="user")
                                              {
                                                ?>
                                                <option value="user">User</option>
                                                <?php
                                              }
                                              else if($enduse=="admin")
                                              {
                                                ?>
                                                  <option value="admin">Admin</option>
                                                <?php
                                              }

                                              ?>
                                             
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





                               <tr id="your_buss_cate" >
                                  <td align="right" valign="top"> <strong>Your Business category</strong></td>
                                  <td align="center" valign="top"><strong>:</strong></td>
                                  <td  align="left" valign="top">
                                  <!-- <div class="form-group"> -->
                                   <select name="va_cat_id" id="va_cat_id" class="input-text-box" onchange="getvendoraccesssubcat();" style="width:200px; height: 24px;" disabled>
                                     <!-- <option value><?php echo $wa_main_cat; ?> </option> -->
                                      <?php echo $obj->getvendoraccesdropdownmain($wa_main_cat); ?>  
                                    </select>
                                  <!-- </div> -->
                                </td>
                              </tr>
                                 <tr>
                                      <td colspan="8" align="center">&nbsp;</td>
                                 </tr>


                                <tr id="your_buss_sub_cate">
                                    <td align="right" valign="top"> <strong>Your Business sub category</strong></td>
                                     <td align="center" valign="top"><strong>:</strong></td>
                                       <!-- <div class="form-group"> -->
                                      <td  align="left" valign="top">
                                     
                                    
                                       
                                       <select name="va_sub_cat_id" id="va_sub_cat_id" class="input-text-box" style="width:200px; height: 24px;" disabled>
                                        <?php echo $obj->getvendoraccesdropdownsub($wa_main_cat,$wa_sub_cat);?>
                                        <!-- <option value><?php echo $wa_sub_cat; ?> </option> -->
                                        <option value="">Select</option>
                                    </select>
                                  </td>
                                  </tr>

                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>


                                    <tr>
                                        <tr>                                                                    
                                        <td align="right" valign="top"><strong>Order</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="order_show" style="width:200px; height: 24px;">
                                                <?php for($i=1;$i<=50;$i++) { ?>
                                                <option value="<?php echo $i ?>"  <?php if($order_show == $i){ echo 'selected'; } ?>><?php echo $i ?></option>
                                                <?php } ?>
                                            </select>
<!--                                            <select name="order_show" style="width:200px; height: 24px;">
                                                <option value="1" <?php // if($order_show == 1){ echo 'selected'; } ?>>1</option>
                                                <option value="2" <?php //if($order_show == 2){ echo 'selected'; } ?>>2</option>
                                                <option value="3" <?php //if($order_show == 3){ echo 'selected'; } ?>>3</option>
                                                <option value="4" <?php //if($order_show == 4){ echo 'selected'; } ?>>4</option>
                                                <option value="5" <?php //if($order_show == 5){ echo 'selected'; } ?>>5</option>
                                                <option value="6" <?php //if($order_show == 6){ echo 'selected'; } ?>>6</option>
                                            </select>-->
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





            
    $( document ).ready(function()
    {
        var parent_cat_id1 = $("#fav_cat_type_id").val();
        var parent_cat_id2 = $("#fav_cat_type_id2").val();
        var parent_cat_id3 = $("#fav_cat_type_id3").val();
        var parent_cat_id4 = $("#fav_cat_type_id4").val();
        var parent_cat_id5 = $("#fav_cat_type_id5").val();
        var parent_cat_id6 = $("#fav_cat_type_id6").val();
        var parent_cat_id7 = $("#fav_cat_type_id7").val();
        var parent_cat_id8 = $("#fav_cat_type_id8").val();
        var parent_cat_id9 = $("#fav_cat_type_id9").val();
        var parent_cat_id10 =$("#fav_cat_type_id10").val();
        
        var id = $("#hdnpd_id").val();
        
        
        if(parent_cat_id1!='')
        {
            var dataString = 'action=getdatasubcatoption_report&parent_cat_id='+parent_cat_id1+'&id='+id+'&columns=sub_cat1';
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
        
        if(parent_cat_id2!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id2+'&id='+id+'&columns=sub_cat2';
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
        
        if(parent_cat_id3!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id3+'&id='+id+'&columns=sub_cat3';
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
        
        if(parent_cat_id4!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id4+'&id='+id+'&columns=sub_cat4';
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
        
        if(parent_cat_id5!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id5+'&id='+id+'&columns=sub_cat5';
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
        
        if(parent_cat_id6!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id6+'&id='+id+'&columns=sub_cat6';
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
        
        if(parent_cat_id7!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id7+'&id='+id+'&columns=sub_cat7';
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
        
        if(parent_cat_id8!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id8+'&id='+id+'&columns=sub_cat8';
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
        
        if(parent_cat_id9!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id9+'&id='+id+'&columns=sub_cat9';
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
        
        if(parent_cat_id10!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id10+'&id='+id+'&columns=sub_cat10';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id10").html(result);
		}
	});
        }
        
    });        
    function getMainCategoryOptionAddMore()
{
        
	var parent_cat_id = $("#fav_cat_type_id").val();
        var id='';

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
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
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
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
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
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
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
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
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
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getsubcat10option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
            //alert(sub_cat);
			$("#fav_cat_id10").html(result);
		}
	});
}



function getTableOnRef()
{
  var table_dropdown_ref=$('#table_dropdown_ref').val();
  
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
      }
      else
      {

        alert('No table name.');
        $("#data_source").html('<option>Select Data Source</option>');
      }
    }
  }); 

}

function getTableColums()
{
    var data_source=$('#data_source').val();
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
           $('#getcolums').html(result);
          }
          else
          {
            $('#getcolums').html('');
          }
        }
      });


    // alert(data_source);
}

function selectcheck(num,colums)
{

if($('#check_'+num).is(":checked")) {
    $('#checkvalue'+num).val(colums);
  }
  else
  {
     $('#checkvalue'+num).val('');
  }
 

}


            
            </script>
</div>