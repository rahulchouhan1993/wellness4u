<?php



ini_set("memory_limit","200M");



if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };



@set_time_limit(1000000);



include('classes/config.php');

$page_id = '38';

$obj = new frontclass();

$obj2 = new frontclass2();



$page_data = $obj->getPageDetails($page_id);



//list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);



$ref = base64_encode('digital_personal_wellness_diary.php');

if(isset($_SESSION['adm_vendor_id']) && !empty($_SESSION['adm_vendor_id']))
{
  $vendor_id=$_SESSION['adm_vendor_id'];

  $user_id = $_SESSION['adm_user_id'];

}
else
{

  if(!$obj->isLoggedIn())

  {

  //    header("Location: login.php?ref=".$ref);

  echo "<script>window.location.href='login.php?ref=$ref'</script>";

  exit(0);

  }

  else

  {

  $user_id = $_SESSION['user_id'];

  $obj->doUpdateOnline($_SESSION['user_id']);

  }

}


$valu_b=json_decode(base64_decode($_GET['b']));

// echo "<pre>";

// print_r($valu_b);

// die();


  if(isset($_POST['action_save']) && !empty($_POST))
  {

      $_POST['report_name']=$valu_b->report_name;

      $_POST['report_date_type']=$valu_b->report->date_type;
      $_POST['report_date_data']=json_encode($valu_b->report->arr);
       
      //  echo '<pre>';
      //   print_r($_POST);
      // die('---');

    $result=$obj->Post_user_report_action_data($_POST);

    if($result==true)
      {
         $_SESSION['success_msg']="Your Action Post Successfully";
      }
      else
      {
         $_SESSION['error_msg']="Try Later!";
      }

       header("Location: report_formate.php?b=".$_GET['b']);
         exit(0);

  }





  $DLY=$obj->GetDesignYourLifeData('18');

  $final_dropdown=$obj->getBoxtitleDYL($DLY['data_category']);



?>

<!DOCTYPE html>

<html lang="en">

<head>

<?php include_once('head.php');?>

<!-- <meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="<?php echo $meta_description;?>" />

<meta name="keywords" content="<?php echo $meta_keywords;?>" />

<meta name="title" content="<?php echo $meta_title;?>" />

<title><?php echo $meta_title;?></title>

<link href="cwri.css" rel="stylesheet" type="text/css" />

<link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       

<link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

<script type="text/JavaScript" src="js/commonfn.js"></script>

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/ticker-style.css" rel="stylesheet" type="text/css" />

<script src="js/jquery.ticker.js" type="text/javascript"></script>	

<style type="text/css">@import "css/jquery.datepick.css";</style> 

<script type="text/javascript" src="js/jquery.datepick.js"></script>	 -->

<script type="text/javascript">



ddsmoothmenu.init({

mainmenuid: "smoothmenu1", //menu DIV id

orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"

classname: 'ddsmoothmenu', //class added to menu's outer DIV

//customtheme: ["#1c5a80", "#18374a"],

contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]

})







$(document).ready(function() {

$('#js-news').ticker({

    controls: true,        // Whether or not to show the jQuery News Ticker controls

    htmlFeed: true, 

    titleText: '',   // To remove the title set this to an empty String

    displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'

    direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'

});







$(".QTPopup").css('display','none');

$(".feedback").click(function(){

        $(".QTPopup").animate({width: 'show'}, 'slow');

});	



$(".closeBtn").click(function(){			

        $(".QTPopup").css('display', 'none');

});

});	

</script>





<style>

.digitalshow

{

    text-align: center;

    font-style: 25px;

    color:red;

    padding:2%;

}

    .bg-box
    {
      padding: 15px;
    }
    .btn-dark
    {
      background: #555;
      color: #fff;
    }
    .btn-dark:hover
    {
      color: #eee;
    }
 

</style>







</head>

<body>



<?php //include_once('analyticstracking.php'); ?>

<?php //include_once('analyticstracking_ci.php'); ?>



<?php //include_once('analyticstracking_y.php'); ?>

<?php include_once('header.php');?>



<!--header End --> 			

<!--breadcrumb--> 

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

</div>



<!--breadcrumb end --> 



<!--container-->              



<div class="container" >

<div class="row">	

<div class="col-md-12">	


      <?php
         if(!empty($_SESSION['success_msg'])) 
         {
            $message = $_SESSION['success_msg'];
            echo '<div class="alert alert-success">'.$message.'</div>';
            unset($_SESSION['success_msg']);
         }

         if(!empty($_SESSION['error_msg'])) 
         {
            $message = $_SESSION['error_msg'];
            echo '<div class="alert alert-error">'.$message.'</div>';
            unset($_SESSION['error_msg']);
         }

         ?>


    <?php


      if(isset($_SESSION['adm_vendor_id']))
      {
         $user=$obj->getMylifepetterns($_SESSION['adm_user_id']);
      }
      else
      {
          $user=$obj->getMylifepetterns($_SESSION['user_id']);
      }


       // $valu_b=json_decode(base64_decode($_GET['b']));

       // echo "<pre>";print_r($user);echo "</pre>";

    // echo "<pre>";print_r($valu_b);echo "</pre>";

      $detais= $obj->userReportDetails($valu_b->report->arr,$valu_b->report->date_type,$valu_b->report->report_name,$valu_b->report->keywords,$valu_b->report->criteria_name,$valu_b->report->module_criteria,$valu_b->report->scale_range,$valu_b->report->module_sub_criteria,$valu_b->report->criteria_sub_name,$valu_b->report->last_parameter,$valu_b->report->parameter_value1,$valu_b->report->parameter_value2);

      krsort($detais);

 // echo "<pre>";print_r($detais);echo "</pre>"; 

 //   exit;


    ?>


 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

        <td align="left" valign="top" class="digitalshow"><h4><?php echo ucfirst($valu_b->report_name);?></h4></td>

    </tr>

</table>



 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

 

  <?php

  // echo "<pre>";print_r($valu_b->report->arr[0][0]);echo "</pre>";

    // echo $valu_b->report->arr[0];

   // echo $obj->getmonthname($valu_b->report->arr[0]);

     // echo $valu_b->report->arr[1];

     if($valu_b->report->date_type=="date_range")

     {

   ?>

     <tr>

        <td align="left" valign="top"><b>For the period from :</b></td>

        <td align="left" valign="top"><?php echo date('d M Y',strtotime($valu_b->report->arr[0]));?></td>

        <td align="left" valign="top"><b>to :</b></td>

        <td align="left" valign="top"><?php echo date('d M Y',strtotime($valu_b->report->arr[1]));?></td>

    </tr>

    <?php

   }

   elseif($valu_b->report->date_type=="single_date")

   {

    ?>

     <tr>

      <td align="left" valign="top"><b>Date :</b></td>

       <td align="left" valign="top" colspan="2"><?php echo date('d M Y',strtotime($valu_b->report->arr[0]));?></td>

     </tr>

    <?php

   }

   elseif($valu_b->report->date_type=="month_wise")

   {

    ?>

     <tr>

      <td align="left" valign="top"><b>Months :</b></td>

       <td align="left" valign="top" colspan="2"><?php echo $obj->getmonthname($valu_b->report->arr[0]).' '.$valu_b->report->arr[1];?></td>

     </tr>

    <?php

   }

   elseif($valu_b->report->date_type=="days_of_week")

   {

  ?>

       <td align="left" valign="top"><b>Week day :</b></td>

       <td align="left" valign="top" colspan="2">
        <?php
              // echo $obj->getWeekName($valu_b->report->arr[0]);
            //add by ample 13-03-20
                if(!empty($valu_b->report->arr[0]))
                { 
                  $arr=array();
                  foreach ($valu_b->report->arr[0] as $week) {
                    $arr[]=$obj->getWeekName($week);
                  }
                  echo implode(",",$arr);
                }

                echo " -(".$valu_b->report->arr[1].")";
        ?>


          
        </td>

  <?php

   }

   elseif($valu_b->report->date_type=="days_of_month")

   {
    ?>

      <td align="left" valign="top"><b>Days of Month :</b></td>

       <td align="left" valign="top" colspan="2">
        <?php   
              //echo $obj->getmonthname($valu_b->report->arr[0]);
              //add by ample 13-03-20
                // if(!empty($valu_b->report->arr[0]))
                // { 
                //   $arr=array();
                //   foreach ($valu_b->report->arr[0] as $month) {
                //     $arr[]=$obj->getmonthname($month);
                //   }
                //   echo implode(",",$arr);
                // }
        //add by ample 21-03-20
         if(!empty($valu_b->report->arr[0]))
                { 
                  $arr=array();
                  foreach ($valu_b->report->arr[0] as $month) {
                    $arr[]=$month;
                  }
                  echo implode(",",$arr);
                }
              echo " -(".$valu_b->report->arr[1].")";

              ?>
          
        </td>

    <?php

   }

    ?>

   

      <tr>

        <td align="left" valign="top"><b>Name:</b></td>

        <td align="left" valign="top"><?php echo ucfirst($user['name']).' '.ucfirst($user['middle_name']).' '.ucfirst($user['last_name']);?></td>

        <td align="left" valign="top"><b>CWRI Regn No :</b></td>

        <td align="left" valign="top"><?php echo $user['unique_id'];?></td>

    </tr>

      <tr>

        <td align="left" valign="top"><b>Age :</b></td>

        <td align="left" valign="top"><?php echo $user['dob'];?></td>

        <td align="left" valign="top"><b>Height:</b></td>

        <td align="left" valign="top"><?php echo $user['height'];?> cms</td>

        <td align="left" valign="top"><b>Weight:</b></td>

        <td align="left" valign="top"><?php echo $user['weight'];?> Kgs</td>

    </tr>



   <tr>

        <td align="left" valign="top"><b>BMI :</b></td>

        <td align="left" valign="top">20.2</td>

        <td align="left" valign="top"><b>BMI Observations:</b></td>

        <td align="left" valign="top">Normal BMI / Low Risk</td>

    </tr>

    <?php

  // }

 ?>

    <tr>

        <td align="left" valign="top"><b>Important:</b></td>

    </tr>



     <tr>

        <td align="left" valign="top">Disclaimers.</td>

    </tr>



      <tr>

     <td align="left" valign="top" colspan="4">Just a guide, not an exact scientific research, depends on many factors,as well as accuracy of your Input DATA.</td>

     </tr>

</table>

<br> <br>



 
  <!-- <table class="table table-bordered">
     <?php
       if(count($valu_b->report->keywords)==1)
       {
         $aa=$valu_b->report->keywords;
         $exp=explode('|', $aa[0]);
        ?>
         <tr>
          <td colspan="<?php echo $count;?>" style="background:#e0ebeb;"><?php echo $exp[1];?></td>
        </tr>
        <?php
         }
         else
         {
          ?>
        <tr>
            <td colspan="<?php echo $count;?>" style="background:#e0ebeb;"><p>&nbsp;</p></td>
        </tr>
          <?php
         }
     ?>
   </table>  -->

   <!-- code by ample 27-02-20-->

   <?php 
   if(!empty($valu_b->report->keywords))
   {
      ?>
      <table class="table table-bordered">
      <?php

        //update by ample 

          $count=count($valu_b->report->keywords);
          // add by ample 23-03-30
          if(!empty($detais['heading']))
          {
            ?>
                     <tr>
                        <th colspan="<?php echo $count;?>" style="background:#e0ebeb;"><?php echo $detais['heading'];?></th>
                      </tr>
            <?php
          }
        
         foreach ($valu_b->report->keywords as $key => $value) {
            
            $aa=$value;
            $exp=explode('|', $aa);

               if (is_numeric($exp[1])) 
                {     
                    $key_data="";
                      foreach($detais as $final_show)
                      {
                           foreach ($final_show['other_labels']['rows'] as $row) {
                           if($row['col_name']==$exp[0])
                           {
                                $key_data=$obj->dynamic_query_data($exp[1],$row['Id_table'],$row['fetch_columns'],$row['fetch_value']);
                                 
                           }
                        }
                      }
                      if(!empty($key_data))
                      {
                        ?>
                           <tr>
                            <td colspan="<?php echo $count;?>" style="background:#e0ebeb;"><?php echo $key_data;?> <a href="javascript:void(0)" onclick="action_popup('<?=$key_data;?>')" style="float: right;"><button class="btn btn-defult btn-sm btn-dark">ACTION</button></a> </td>
                          </tr>
                        <?php
                      }

                }
                else
                {

                   ?>
                    <tr>
                      <td colspan="<?php echo $count;?>" style="background:#e0ebeb;"><?php echo $exp[1];?> <a href="javascript:void(0)" onclick="action_popup('<?=$exp[1];?>')" style="float: right;"><button class="btn btn-defult btn-sm btn-dark">ACTION</button></a></td>
                    </tr>
                    <?php

                }
         }
      ?>
      </table>
      <?php
   }
   ?>


<?php
foreach($detais as $key=>$final_show)

{

  if($final_show[0]=='date_range')

  {

  

   $count=count($final_show['col_name'])+1;

?>

    <table class="table table-bordered">

       <!-- coment by ample 12-3-20 -->
     <!-- <tr>
        <td colspan="<?php echo $count;?>"><p>&nbsp;</p></td>
      </tr> -->

      <tr>
         <!-- update by ample 12-3-20 -->
        <td colspan="<?php echo $count;?>" style="background:#e0ebeb;">Date :<b><?php echo date('d F Y',strtotime($key));?> (<?php echo date('l', strtotime($key)); ?>)</b> <p>

        	<?php
       //  if(!empty($final_show['other_labels']['TK']))
       //  {   
       //     foreach ($final_show['other_labels']['TK'] as $tk_key => $tk_value) {
              		
       //        		$arry_TK=array();

       //        		 if($final_show['row_site']!="")
			  		// {
			    // 	foreach($final_show['row_site'] as $row_data)
			    // 	{
       //        		foreach($row_data[1] as $valuesdata)
       //    			{
       //    				$data_value=$valuesdata[$tk_value['col_name']];
       //                        if(!empty($data_value))
       //                        {
       //                           if(!empty($tk_value['Id_table']) && !empty($tk_value['fetch_columns']) && !empty($tk_value['fetch_value']) )
       //                           {
       //                              $result_data=$obj->dynamic_query_data($data_value,$tk_value['Id_table'],$tk_value['fetch_columns'],$tk_value['fetch_value']);
       //                             	$arry_TK=$tk_value['col_report_label'].':'.$result_data.'|';
       //                           }
       //                           else
       //                           {
       //                              $arry_TK=$tk_value['col_report_label'].':'.$data_value.'|';
       //                           }
       //                        }
                              
       //    			} 
       //    			}}
       //    			if(!empty($arry_TK))
       //    			{	
       //    				echo $arry_TK;
       //    			}
       //            }
       //  	}
        ?>
    	</p>
        </td>

        

      </tr>





       <tr>

        <td style="background:#e0ebeb;"></td>

         <?php

          if($final_show['col_name']!="")

          {

             foreach( $final_show['col_name'] as $col_name)

             {

              ?>

                <td style="background:#e0ebeb;"><?php echo ucfirst($col_name['col_report_label']);?></td>

              <?php

             }

         }

         ?>

      </tr>



    <?php



  if($final_show['row_site']!="")

  {

    foreach($final_show['row_site'] as $row_data)

    {

      ?>

         <?php
            foreach($row_data[1] as $f_data)

            {

              ?>
                 
                  <?php 
                        if(!empty($f_data))
                        {
                          ?>
                          <tr>
                          <td><?php echo $row_data[0];?></td>
                          <?php
                            foreach ($f_data as $col_key=>$col_value) {
                            ?>
                              
                                <?php 

                                ?>
                                            <td>
                                            <?php

                                  //echo $col_value;
                                  // add by ample 12-03-20
                                  $data_value=$col_value;
                                  if(!empty($data_value))
                                  {

                                    $match_col_data=array();
                                      foreach ($final_show['col_name'] as $value_data) {

                                          if($value_data['col_name']==$col_key)
                                          {

                                          	
                                          	
                                            $match_col_data=$value_data;
                                            if(!empty($match_col_data['Id_table']) && !empty($match_col_data['fetch_columns']) && !empty($match_col_data['fetch_value']) )
		                                     {
		                                         echo $result_data=$obj->dynamic_query_data($data_value,$match_col_data['Id_table'],$match_col_data['fetch_columns'],$match_col_data['fetch_value']);
		                                     }
		                                     else
		                                     {
		                                        echo $data_value;
		                                     }
		                                     
                                          }

                                         

                                      }
                                     
                                  }

                                   ?>
                                      </td>
                                         <?php

                                ?>
                            <?php
                          } //dfsf
                          ?>
                          </tr>
                          <?php
                          $no_data=false;
                        }
                        else
                        {
                          $no_data=true;
                        }

                  ?>
            
              <?php

            }
             if($no_data==true)
              {
                ?>
                <tr>
                   <td><?php echo $row_data[0];?></td>
                  <!-- <td colspan="<?=count($row_data[1]);?>">&nbsp;</td> -->
                    <?php 
                      for ($i=0; $i < count($row_data[1]); $i++) { 
                        echo "<td></td>";
                      }
                    ?>
                </tr>
                <?php
              }

         ?>

      <?php

    }

  }

   
 

    ?>

  </table>

  <?php

   }

   elseif($final_show[0]=='single_date' || $final_show[0]=='month_wise' || $final_show[0]=='days_of_week' || $final_show[0]=='days_of_month')

   {

     $count=count($final_show['col_name'])+1;

     ?>

      <!-- <table class="table table-bordered">

         <tr>

              <td colspan="<?php echo $count;?>"><p><?php echo $values[0];?></p></td>

           </tr>

      </table> -->

   <?php

    foreach($final_show['row_site'] as $values)

    {

    ?>



    <table class="table table-bordered">

       <tr> 

        <!-- comment by ample -->
        <!-- <td colspan="<?php echo $count;?>"><p><b><?php echo $values[0];?></b></p></td> -->

        <td colspan="<?php echo $count;?>"><p><b><?php echo $values[0];?></b></p>

        <?php

        // if(!empty($final_show['other_labels']['TK']))
        // {   
        //    foreach ($final_show['other_labels']['TK'] as $tk_key => $tk_value) {
              		
        //       		$arry_TK=array();
        //       		foreach($values[1] as $valuesdata)
        //   			{
        //   				$data_value=$valuesdata[$tk_value['col_name']];
        //                       if(!empty($data_value))
        //                       {
        //                          if(!empty($tk_value['Id_table']) && !empty($tk_value['fetch_columns']) && !empty($tk_value['fetch_value']) )
        //                          {
        //                             $result_data=$obj->dynamic_query_data($data_value,$tk_value['Id_table'],$tk_value['fetch_columns'],$tk_value['fetch_value']);
        //                            	$arry_TK=$tk_value['col_report_label'].':'.$result_data.'|';
        //                          }
        //                          else
        //                          {
        //                             $arry_TK=$tk_value['col_report_label'].':'.$data_value.'|';
        //                          }
        //                       }
                              
        //   			} 

        //   			if(!empty($arry_TK))
        //   			{	

        //   				echo $arry_TK;
        //   			}
                    
        //           }
              
        // }

        ?>
        </td>

      </tr>

       <tr>

         <?php

          if($final_show['col_name']!="")

          {

             foreach( $final_show['col_name'] as $col_name)

             {

              ?>

                <td style="background:#e0ebeb;"><?php echo ucfirst($col_name['col_report_label']);?></td>

              <?php

             }

         }

         ?>

      </tr>

        <?php

          foreach($values[1] as $valuesdata)

          { 
            ?>

             <tr>

                 <?php

                  if($final_show['col_name']!="")

                  {

                     foreach( $final_show['col_name'] as $col_name)

                     {
                      ?>

                        <td>

                          <?php //echo $valuesdata[$col_name['col_report_label']];
                              //echo $valuesdata[$col_name['col_name']]; // update by ample 11-03-20
                              $data_value=$valuesdata[$col_name['col_name']];
                              if(!empty($data_value))
                              {
                                 if(!empty($col_name['Id_table']) && !empty($col_name['fetch_columns']) && !empty($col_name['fetch_value']) )
                                 {
                                     echo $result_data=$obj->dynamic_query_data($data_value,$col_name['Id_table'],$col_name['fetch_columns'],$col_name['fetch_value']);
                                 }
                                 else
                                 {
                                    echo $data_value;
                                 }
                              }
                          ?>
                        </td>

                      <?php

                     }

                 }
                 else
                 {
                   ?>
                   <td colspan="<?php echo $count;?>"> &nbsp;</td>
                   <?php
                 }

                 ?>

            </tr>



            <?php

          }

        ?>

    



    </table>

    <?php

    }

   }

 }



?>



</div>

</div>

</div>           




<!-- Modal -->
<div id="actionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=empty($DLY['level_title'])? 'My Action' : $DLY['level_title']; ?></h4>
      </div>
      <div class="modal-body">
          <!-- <?php 
            echo '<pre>';
          print_r($DLY);
          echo '</pre>';
          ?> -->
          <form action="" method="post">
        <div class="form-group">
          <label ><?=$DLY['level_title_heading'];?></label> <br>
          <select class="input-text-box input-half-width" name="action_title" required="true">
              <option value="">Select</option>
              <!-- <?=$final_dropdown;?> -->
              <?php 
                if(!empty($final_dropdown))
                {
                  foreach ($final_dropdown as $key => $value) {
                    ?>
                    <option value="<?=$value;?>"><?=$value;?></option>
                    <?php
                  }
                }
              ?>
          </select>
        </div>
        <?php 
          $outputstr = '';
          $tr_days_of_month = 'none';
          $tr_single_date = 'none';
          $tr_date_range = 'none';
          $tr_month_date = 'none';
          $tr_days_of_week = 'none';
          for ($l = 1;$l <= 11;$l++) {

                    //update by ample 10-01-20 in ramakant code (common/both)
                if ($DLY['location_order_show'] == $l && ($DLY['location_show'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="location_main" id="location_main" title="' . $DLY['location_heading'] . '">

                                     <option value="">' . $DLY['location_heading'] . '</option>

                                     ' . $obj->getFavCategoryRamakant($DLY['location_fav_cat'], '') . '

                                 </select> 

                                 <br><br>';
                }
                if ($DLY['user_date_order_show'] == $l && ($DLY['user_date_show'] !=0)) {
                    $outputstr.= '<span class="">

                                      <!--<b>Date Selection:</b>-->

                                     <select name="listing_date_type" id="listing_date_type" class="input-text-box input-quarter-width" onchange="toggleDateSelectionType(\'listing_date_type\')"  title="' . $DLY['user_date_heading'] . '">

                                        <option value="">Select Date Type</option>

                                         <option value="days_of_month">Days of Month</option>

                                         <option value="single_date">Single Date</option>

                                         <option value="date_range">Date Range</option>

                                         <option value="month_wise">Month Wise</option>

                                         <option value="days_of_week">Days of Week</option>



                                     </select>

                                  </span>

                             <span>

                                 <table style="margin-top:5px;">

                                 <tr id="tr_days_of_month" style="margin-top:10px; display:' . $tr_days_of_month . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="days_of_month_main" name="days_of_month_main[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">';
                    $arr_days_of_month = array();
                    for ($i = 1;$i <= 31;$i++) {
                        $outputstr.= '<option value="' . $i . '"';
                        if (in_array($i, $arr_days_of_month)) {
                            $outputstr.= 'selected="selected"';
                        }
                        $outputstr.= '>' . $i . '</option>';
                    }
                    $outputstr.= '</select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>

                                    

                                     <tr id="tr_single_date" style="margin-top:10px; display:' . $tr_single_date . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <input name="single_date_main" id="single_date_main" type="text" value="' . $single_date . '" class="input-text-box input-full-width" style="margin-top:20px;" placeholder="Select Date" />



                                             <script>$("#single_date_main").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>



                                         </td>



                                     </tr>



                                     <tr id="tr_date_range" style="margin-top:10px; display:' . $tr_date_range . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <input name="start_date_main" id="start_date_main" type="text" value="' . $start_date . '" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="Start Date"  /> - <input name="end_date_main" id="end_date_main" type="text" value="' . $end_date . '" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="End Date" />



                                             <script>$("#start_date_main").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"});$("#end_date_main").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>



                                         </td>



                                     </tr>



                                     <tr id="tr_days_of_week" style="margin-top:10px; display:' . $tr_days_of_week . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="days_of_week_main" name="days_of_week_main[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">



                                             ' . $obj->getDayOfWeekOptionsMultiple($arr_days_of_week) . '



                                             </select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>



                                     <tr id="tr_month_date" style="margin-top:10px; display:' . $tr_month_date . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="months_main" name="months_main[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">



                                             ' . $obj->getMonthsOptionsMultiple($arr_month) . ' 



                                             </select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>

                                    </table>

                             </span>

                             <br><br>';
                }
                if ($DLY['time_order_show'] == $l && ($DLY['time_show'] !=0)) {

                        $outputstr.= '<input type="time" class="input-text-box input-quarter-width" name="bes_time_main"  id="bes_time_main"  placeholder="' . $DLY['time_heading'] . '" title="' . $DLY['time_heading'] . '" />
                        <span class="text-danger" id="time_note_main" style="font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red; text-decoration: underline;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></span>
                        <br><br>';
                }
                if ($DLY['duration_order_show'] == $l && ($DLY['duration_show'] !=0)) {
                    $outputstr.= '<input type="text" title="' . $DLY['duration_heading'] . '" name="duration_main" id="duration_main" onKeyPress="return isNumberKey(event);" placeholder="' . $DLY['duration_heading'] . '" class="input-text-box input-sml-width" autocomplete="false">
                        <select  class="input-text-box input-quarter-width" name="unit_main" id="unit_main" title="Duration Type">
                                                <option value="">Select Unit</option>
                                                    '.$obj->getFavCategoryRamakant('82','').'
                                                </select>
                             <br><br>';
                }
                if ($DLY['like_dislike_order_show'] == $l && ($DLY['User_view'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_view_main" id="User_view_main" title="' . $DLY['like_dislike_heading'] . '">

                                     <option value="">' . $DLY['like_dislike_heading'] . '</option>

                                     ' . $obj->getFavCategoryRamakant($DLY['user_response_fav_cat'], '') . '

                                 </select>

                                 <br><br>';
                }
                if ($DLY['set_goals_order_show'] == $l && ($DLY['User_Interaction'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_Interaction_main" id="User_Interaction_main" title="' . $DLY['set_goals_heading'] . '">

                                         <option value="">' . $DLY['set_goals_heading'] . '</option>

                                         ' . $obj->getFavCategoryRamakant($DLY['user_what_fav_cat'], '') . '

                                     </select>

                                     <br><br>';
                }
                if ($DLY['scale_order_show'] == $l && ($DLY['scale_show'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="scale_main" id="scale_main" title="' . $DLY['scale_heading'] . '">

                                         <option value="">' . $DLY['scale_heading'] . '</option>

                                         <option value="1">1</option>

                                         <option value="2">2</option>

                                         <option value="3">3</option>

                                         <option value="4">4</option>

                                         <option value="5">5</option>

                                         <option value="6">6</option>

                                         <option value="7">7</option>

                                         <option value="8">8</option>

                                         <option value="9">9</option>

                                         <option value="10">10</option>

                                     </select>

                                     <br><br>';
                }
                if ($DLY['reminder_order_show'] == $l && ($DLY['alert_show'] !=0)) {
                    $outputstr.= '<select class="input-text-box input-half-width" name="alert_main" id="alert_main" title="' . $DLY['reminder_heading'] . '">

                                         <option value="">' . $DLY['reminder_heading'] . '</option>

                                         ' . $obj->getFavCategoryRamakant($DLY['alerts_fav_cat'], '') . '

                                     </select>

                                     <br><br>';
                }
                if ($DLY['comment_order_show'] == $l && ($DLY['comment_show'] !=0)) {
                    $outputstr.= '<textarea name="comment_main" title="' . $DLY['comments_heading'] . '" id="comment_main" rowspan="3" class="input-text-box input-half-width" autocomplete="false" placeholder="' . $DLY['comments_heading'] . '" ></textarea>

                                     <br><br>';
                                 }
            }
            echo $outputstr;
        ?>
        <input type="hidden" name="keyword_data" id="keyword_data">
        <input type="hidden" name="user_id" id="user_id" value="<?=$user_id;?>">
        <button type="submit" name="action_save" class="btn btn-default">Submit</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>





<?php include_once('footer.php');?>

<!--  Footer-->

<div id="page_loading_bg" class="page_loading_bg" style="display:none;">

<div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>

</div> 

</div>	

</div>



<!-- <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>        -->



</body>



</html>





<script type="text/javascript">


  $('#single_date_main').datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
    $('#start_date_main').datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
 
    $('#end_date_main').datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'}); 

$(".formData").submit(function(e) {

   e.preventDefault();
   var formData = $(this).serialize();

   $.ajax({
           type: "POST",
           url: 'remote.php',
           data: formData,    
           dataType: "json",       
           success: function(response)
           {
               //alert(response); // show response from the php script.
               //console.log(response.status);
               if(response.status==true)
               {
                  window.open(response.url, '_blank');
               }
               else
               {
                  alert('SORRY No matching Data Now')
               }
           }
         });

});

//add by ample 23-07-20
function action_popup(keyword)
{ 

  $('#keyword_data').val(keyword);
  jQuery.noConflict();
  $('#actionModal').modal('show');
}



         function toggleDateSelectionType(id_val)
         
         
         
         {
         
         // alert(id_val);
         
         // console.log(id_val);
         
            var sc_listing_date_type = document.getElementById(id_val).value;
         
            if (sc_listing_date_type == "days_of_month") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = '';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "single_date") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = '';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "date_range") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = '';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "days_of_week") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = '';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "month_wise") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = '';
         
            }
         
            else
         
            {   
         
         
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
         }

</script>