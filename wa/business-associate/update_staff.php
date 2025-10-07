<?php

require_once('../classes/config.php');
require_once('../classes/vendor.php');

$page_id=0;
$admin_main_menu_id = '';
$view_action_id = '';
$add_action_id = '';
$edit_action_id = '';
$delete_action_id = '';

$obj = new Vendor();
if(!$obj->isVendorLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$adm_vendor_id = $_SESSION['adm_vendor_id'];
}

// if(!$obj->chkIfAccessOfMenu($adm_vendor_id,$admin_main_menu_id))
// {
// 	header("Location: invalid.php");
// 	exit(0);
// }

if(isset($_GET['msg']) && $_GET['msg'] != '')
{
	$msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.urldecode($_GET['msg']).'</strong></div>';
}
else
{
	$msg = '';
}

 $id = $_GET['SID'];

   $data = $obj->get_vendor_contact_info($id,$adm_vendor_id);

   // echo "<pre>";

   // print_r($data);

   // die('---');

   $arr_record = $obj->getVendorDetails($adm_vendor_id);


   if(empty($data))
   {
      echo "<script>window.location.href='edit_profile.php'</script>";

      exit(0);  
   }
   else
   {
        
         $arr_cert_total_cnt=0;

         if(!empty($data['certificate']))
         {     
            $arr_cert_total_cnt=count($data['certificate']);
         }
   }

   $speciality_offered = explode(',', $data['speciality_offered']);
   //add by ample 05-09-20
   $tag_level_3=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($arr_record['vendor_cat_id'],39,3);

   // echo '<pre>';

   // print_r($tag_level_3);

   // die('-ss');


   if(isset($_POST['btnUpdate']) && !empty($_POST) )
   {
      //  echo "<pre>";

      // print_r($_POST);

      // print_r($_FILES);

      // die('---');

         $data=array(
            'contact_person_title' =>$_POST['contact_person_title'],
            'contact_person' => $_POST['contact_person'],
            'contact_email' => $_POST['contact_email'],
            'contact_number'=>$_POST['contact_number'],
            'contact_designation'=>$_POST['contact_designation'],
            'contact_remark'=>$_POST['contact_remark'],
            'speciality_offered'=>implode(',',$_POST['speciality_offered']),
            );


         $res=$obj->update_vendor_contacts($id,$data);

         if($res==true)
         {  

               $new_data=array();
               $old_data=array();
               $count_row=count($_POST['vc_cert_id']);
               $targetFolder = SITE_PATH . '/uploads';
               $filename="";
              
               for ($i=0; $i < $count_row; $i++) 
               { 

                  if($_POST['vc_cert_id'][$i]==0)
                  {

                      if(isset($_FILES['vc_cert_scan_file']['name'][$i]))
                      {
                        $file_name = date('dmYHis') . '_' . $_FILES['vc_cert_scan_file']['name'][$i];
                        $file_name = str_replace(' ', '-', $file_name);
                        $file_tmp =$_FILES['vc_cert_scan_file']['tmp_name'][$i];

                        $targetPath = $targetFolder;
                        $target_file = rtrim($targetPath, '/') . '/' . $file_name;
               
                        if (move_uploaded_file($file_tmp, $target_file))
                        {
                           $filename=$file_name;
                        }
                     }


                     $new_data[] = array( 'vc_cert_id' =>$_POST['vc_cert_id'][$i] ,
                                 'vc_cert_type_id' =>$_POST['vc_cert_type_id'][$i] ,
                                 'vc_cert_name' =>trim($_POST['vc_cert_name'][$i]) ,
                                 'vc_cert_no' =>trim($_POST['vc_cert_no'][$i]) ,
                                 'vc_cert_issued_by' =>$_POST['vc_cert_issued_by'][$i] ,
                                 'vc_cert_reg_date' =>date('Y-m-d',strtotime($_POST['vc_cert_reg_date'][$i])) ,
                                 'vc_cert_validity_date' =>date('Y-m-d',strtotime($_POST['vc_cert_validity_date'][$i])) ,
                                 'vc_cert_scan_file'=>$filename
                        ); 

                  }
                  else
                  {  

                     if(isset($_FILES['vc_cert_scan_file']['name'][$i]))
                     {
                        $file_name = date('dmYHis') . '_' . $_FILES['vc_cert_scan_file']['name'][$i];
                        $file_name = str_replace(' ', '-', $file_name);
                        $file_tmp =$_FILES['vc_cert_scan_file']['tmp_name'][$i];

                        $targetPath = $targetFolder;
                        $target_file = rtrim($targetPath, '/') . '/' . $file_name;
               
                        if (move_uploaded_file($file_tmp, $target_file))
                        {
                           $filename=$file_name;
                        }
                        else
                        {
                           
                           $filename=$_POST['hdnvc_cert_scan_file_'.$i];
                        }
                     }

                     $old_data[] = array( 'vc_cert_id' =>$_POST['vc_cert_id'][$i] ,
                                 'vc_cert_type_id' =>$_POST['vc_cert_type_id'][$i] ,
                                 'vc_cert_name' =>trim($_POST['vc_cert_name'][$i]) ,
                                 'vc_cert_no' =>trim($_POST['vc_cert_no'][$i]) ,
                                 'vc_cert_issued_by' =>$_POST['vc_cert_issued_by'][$i] ,
                                 'vc_cert_reg_date' =>date('Y-m-d',strtotime($_POST['vc_cert_reg_date'][$i])) ,
                                 'vc_cert_validity_date' =>date('Y-m-d',strtotime($_POST['vc_cert_validity_date'][$i])) ,
                                 'vc_cert_scan_file'=>$filename
                        ); 

                  }
                  
               }

               //  echo "<pre>";

               // print_r($new_data);

               // print_r($old_data);

               // die('---');

               if(!empty($new_data))
               {
                  $obj->add_vendor_staff_certificate($adm_vendor_id,$new_data,$id);
               }
               if(!empty($old_data))
               {
                  $obj->edit_vendor_staff_certificate($old_data);
               }
               
            $_SESSION['success_msg']='Staff update successfully!';
         }
         else
         {
            $_SESSION['error_msg']='Something wrong, try later!';
         }

         header("Location: update_staff.php?SID=".$id);
         exit(0);

   }



?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Business Associates</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-12">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>  

					<div class="row ">

						<div class="col-md-12">

							<center><div id="error_msg" style="color: red;"><?php if($error) { echo $err_msg; } ?></div></center>

                                        <?php echo $obj->getPageContents($page_id);  ?>
						</div>

					</div>  


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
                       
                        <form role="form" class="form-horizontal" method="post" enctype='multipart/form-data'>
                           <div class="form-group">
                              <label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>
                              <div class="col-lg-4">
                                 <select name="contact_person_title" id="contact_person_title" class="form-control" required>
                                    <?php echo $obj->getPersonTitleOption($data['contact_person_title']);?>
                                 </select>
                              </div>
                              <label class="col-lg-2 control-label">Contact Person<span style="color:red">*</span></label>
                              <div class="col-lg-4">
                                 <input type="text" name="contact_person" id="contact_person" value="<?php echo $data['contact_person']?>" placeholder="Contact Person" class="form-control" required>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>
                              <div class="col-lg-4">
                                 <input type="text" name="contact_email" id="contact_email" value="<?php echo $data['contact_email']?>" placeholder="Contact Email" class="form-control" required>
                              </div>
                              <label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>
                              <div class="col-lg-4">
                                 <input type="text" name="contact_number" id="contact_number" value="<?php echo $data['contact_number']?>" placeholder="Contact Number" class="form-control" required>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-lg-2 control-label">Contact Designation</label>
                              <div class="col-lg-4">
                                 <select name="contact_designation" id="contact_designation" class="form-control">
                                    <?php echo $obj->getFavCategoryRamakant('44',$data['contact_designation']); ?>
                                 </select>
                              </div>
                              <label class="col-lg-2 control-label">Remark</label>
                              <div class="col-lg-4">
                                 <textarea name="contact_remark" id="contact_remark" class="form-control"><?php echo $data['contact_remark']?></textarea>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-lg-2 control-label"><?=($tag_level_3['tag_heading'])? $tag_level_3['tag_heading'] : 'Speciality';?></label>
                              <div class="col-lg-10">
                                 <select name="speciality_offered[]" id="speciality_offered" multiple="multiple" class="form-control vloc_speciality_offered" >
                                            <?php 
                                            // echo $obj->getFavCategoryVendorEdit('13,53,42,64',$data['speciality_offered']);

                                            if(!empty($tag_level_3['tag_data']))
                                             {
                                                foreach ($tag_level_3['tag_data'] as $key => $value) {
                                                   $sel="";
                                                   if (in_array($value, $speciality_offered))
                                                     {
                                                      $sel="selected";
                                                     }
                                                   ?>
                                                   <option value="<?=$value;?>" <?=$sel?> ><?=$value;?></option>
                                                   <?php
                                                }
                                             }

                                             ?>
                                 </select>
                              </div>
                           </div>  

                           <div class="form-group left-label">

                        <label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>

                     </div>

                     <input type="hidden" name="cert_cnt" id="cert_cnt" value="<?php echo $arr_cert_total_cnt;?>">

                     <?php 
                     if(!empty($data['certificate']))
                     {
                        foreach ($data['certificate'] as $k => $value) 
                        {
                           ?>
                              <div id="row_cert_<?php if($k == 0){ echo 'first';}else{ echo $k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

                              <input type="hidden" name="vc_cert_id[]" id="vc_cert_id_<?php echo $k;?>" value="<?php echo $value['vc_cert_id'];?>">

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>

                                 <div class="col-lg-5">

                                    <select name="vc_cert_type_id[]" id="vc_cert_type_id_<?php echo $k;?>" class="form-control" required>

                                          <?php echo $obj->getFavCategoryRamakant('47',$value['vc_cert_type_id']); ?>

                                    </select>

                                 </div>

                                 <label class="col-lg-1 control-label">Name</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_name[]" id="vc_cert_name_<?php echo $k;?>" value="<?php echo $value['vc_cert_name'];?>" placeholder="Name" class="form-control">

                                 </div>

                              </div>   

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Number</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_no[]" id="vc_cert_no_<?php echo $k;?>" value="<?php echo $value['vc_cert_no'];?>" placeholder="Number" class="form-control">

                                 </div>

                                 

                                 <label class="col-lg-1 control-label">Issued By</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_issued_by[]" id="vc_cert_issued_by_<?php echo $k;?>" value="<?php echo $value['vc_cert_issued_by'];?>" placeholder="Issued By" class="form-control">

                                 </div>

                              </div>   

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Issued Date</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_reg_date[]" id="vc_cert_reg_date_<?php echo $k;?>" value="<?php echo $value['vc_cert_reg_date'];?>" placeholder="Issued Date" class="form-control clsdatepicker2">

                                 </div>

                                 

                                 <label class="col-lg-1 control-label">Vaidity Date</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_validity_date[]" id="vc_cert_validity_date_<?php echo $k;?>" value="<?php echo $value['vc_cert_validity_date'];?>" placeholder="Validity Date" class="form-control clsdatepicker">

                                 </div>

                              </div>

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Scan Image</label>

                                 <div class="col-lg-5">

                                 <?php

                                 if($value['vc_cert_scan_file'] != '')

                                 { ?>

                                    <div id="divid_vc_cert_scan_file_<?php echo $k;?>">

                                    <?php 

                                    $file4 = substr($data['vc_cert_scan_file'], -4, 4);

                                    if(strtolower($file4) == '.pdf')

                                    { ?>

                                       <a title="<?php echo $value['vc_cert_scan_file'];?>" href="<?php echo SITE_URL.'/uploads/'.$value['vc_cert_scan_file'];?>" target="_blank">View Pdf</a>

                                    <?php 

                                    }  

                                    else

                                    { ?>

                                       <img title="<?php echo $value['vc_cert_scan_file'];?>" alt="<?php echo $value['vc_cert_scan_file'];?>" border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$value['vc_cert_scan_file'];?>" />

                                    <?php    

                                    }?>

                                       <a href="javascript:void(0);" onclick="removeFileOfRow('vc_cert_scan_file_<?php echo $k;?>');" class="btn btn-default btn-sm" title="Remove it" style="margin-bottom:10px;" ><i class="fa fa-remove"></i></a><br>

                                    </div>

                                 <?php 

                                 }

                                 ?> 

                                    <input type="file" name="vc_cert_scan_file[]" accept="image/*,.pdf" id="vc_cert_scan_file_<?php echo $k;?>" class="form-control" >

                                    <input type="hidden" name="hdnvc_cert_scan_file_<?php echo $k;?>" id="hdnvc_cert_scan_file_<?php echo $k;?>" value="<?php echo $value['vc_cert_scan_file'];?>">

                                 </div>

                              </div>

                              <div class="form-group">

                                 <div class="col-lg-2">

                                 <?php

                                 if($k == 0)

                                 { ?>

                                    <a href="javascript:void(0);" onclick="addMoreRowCertificate();" class="btn btn-default btn-sm" title="Add More" ><i class="fa fa-plus"></i></a>

                                 <?php    

                                 }

                                 else

                                 { ?>

                                    <a href="javascript:void(0);" onclick="removeRowCertificate('<?php echo $k;?>');" class="btn btn-default btn-sm" title="Remove it"><i class="fa fa-minus"></i></a>

                                 <?php 

                                 }

                                 ?> 

                                 </div>

                              </div>

                           </div> 
                           <?php
                        }
                     }
                     else
                     {
                        ?>
                        <div id="row_cert_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

                              <input type="hidden" name="vc_cert_id[]" id="vc_cert_id_0" value="0">

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>

                                 <div class="col-lg-5">

                                    <select name="vc_cert_type_id[]" id="vc_cert_type_id_0" class="form-control" required>

                                          <?php echo $obj->getFavCategoryRamakant('47',''); ?>

                                    </select>

                                 </div>

                                 <label class="col-lg-1 control-label">Name</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_name[]" id="vc_cert_name_0" value="" placeholder="Name" class="form-control">

                                 </div>

                              </div>   

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Number</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_no[]" id="vc_cert_no_0" value="" placeholder="Number" class="form-control">

                                 </div>

                                 

                                 <label class="col-lg-1 control-label">Issued By</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_issued_by[]" id="vc_cert_issued_by_0" value="" placeholder="Issued By" class="form-control">

                                 </div>

                              </div>   

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Issued Date</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_reg_date[]" id="vc_cert_reg_date_0" value="" placeholder="Issued Date" class="form-control clsdatepicker2">

                                 </div>

                                 

                                 <label class="col-lg-1 control-label">Vaidity Date</label>

                                 <div class="col-lg-5">

                                    <input type="text" name="vc_cert_validity_date[]" id="vc_cert_validity_date_0" value="" placeholder="Validity Date" class="form-control clsdatepicker">

                                 </div>

                              </div>

                              <div class="form-group small-title">

                                 <label class="col-lg-1 control-label">Scan Image</label>

                                 <div class="col-lg-5">

                                 <input type="file" name="vc_cert_scan_file[]" accept="image/*,.pdf" id="vc_cert_scan_file_0" class="form-control" >

                                 </div>

                              </div>

                              <div class="form-group">

                                 <div class="col-lg-2">

                                    <a href="javascript:void(0);" onclick="addMoreRowCertificate();" class="btn btn-default btn-sm" title="Add More" ><i class="fa fa-plus"></i></a>

                                 </div>

                              </div>
                           </div>
                        <?php
                     }
                     ?>

                     <div class="form-group text-center">

                        <button class="btn btn-primary rounded" type="submit" name="btnUpdate" id="btnUpdate">Update</button>

                     </div>

                        </form>
                        
                     </div>
                  </div>          
                                
			</div>

		</div>

	</div>

</div>





<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="js/tokenize2.js"></script>

<script src="admin-js/edit-vendor-validator.js" type="text/javascript"></script>
<script type="text/javascript">

   $(document).ready(function()
   {
      $('.vloc_speciality_offered').tokenize2();

      $('.clsdatepicker').datepicker();

      $('.clsdatepicker2').datepicker({endDate: new Date});

                $("input[name^='city_id']").attr('autocomplete', 'off');

                $("input[name^='vc_cert_reg_date']").attr('autocomplete', 'off');

                $("input[id^='capitals']").attr('autocomplete', 'off');

                $("input[id^='vc_cert_validity_date']").attr('autocomplete', 'off');

   }); 

   function addMoreRowCertificate()
   {
   
      var cert_cnt = parseInt($("#cert_cnt").val());

      cert_cnt = cert_cnt + 1;

      var new_row = '   <div id="row_cert_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

                     '<input type="hidden" name="vc_cert_id[]" id="vc_cert_id_'+cert_cnt+'" value="0">'+

                     '<div class="form-group small-title">'+

                        '<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+

                        '<div class="col-lg-5">'+

                           '<select name="vc_cert_type_id[]" id="vc_cert_type_id_'+cert_cnt+'" class="form-control" required>'+

                              '<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

                           '</select>'+

                        '</div>'+

                        '<label class="col-lg-1 control-label">Name</label>'+

                        '<div class="col-lg-5">'+

                           '<input type="text" name="vc_cert_name[]" id="vc_cert_name_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

                        '</div>'+

                     '</div>'+   

                     '<div class="form-group small-title">'+

                        '<label class="col-lg-1 control-label">Number</label>'+

                        '<div class="col-lg-5">'+

                           '<input type="text" name="vc_cert_no[]" id="vc_cert_no_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

                        '</div>'+

                        

                        '<label class="col-lg-1 control-label">Issued By</label>'+

                        '<div class="col-lg-5">'+

                           '<input type="text" name="vc_cert_issued_by[]" id="vc_cert_issued_by_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

                        '</div>'+

                     '</div>'+   

                     '<div class="form-group small-title">'+

                        '<label class="col-lg-1 control-label">Issued Date</label>'+

                        '<div class="col-lg-5">'+

                           '<input type="text" name="vc_cert_reg_date[]" id="vc_cert_reg_date_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

                        '</div>'+

                        

                        '<label class="col-lg-1 control-label">Vaidity Date</label>'+

                        '<div class="col-lg-5">'+

                           '<input type="text" name="vc_cert_validity_date[]" id="vc_cert_validity_date_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

                        '</div>'+

                     '</div>'+

                     '<div class="form-group small-title">'+

                           '<label class="col-lg-1 control-label">Scan Image</label>'+

                           '<div class="col-lg-5">'+

                              '<input type="file" name="vc_cert_scan_file[]" accept="image/*,.pdf" id="vc_cert_scan_file_'+cert_cnt+'" class="form-control" >'+

                           '</div>'+

                        '</div>'+

                     '<div class="form-group">'+

                        '<div class="col-lg-2">'+

                           '<a href="javascript:void(0);" onclick="removeRowCertificate('+cert_cnt+');" class="btn btn-default btn-sm" title="Remove it"><i class="fa fa-minus"></i></a>'+

                        '</div>'+

                     '</div>'+

                  '</div>';

      $("#row_cert_"+"first").after(new_row);

      $("#cert_cnt").val(cert_cnt);

      $('.clsdatepicker').datepicker();

      $('.clsdatepicker2').datepicker({endDate: new Date});

   }


   function removeRowCertificate(cert_cnt)
   {    

      $("#row_cert_"+cert_cnt).remove();

      var cert_total_cnt = parseInt($("#cert_cnt").val());

      cert_total_cnt = cert_total_cnt - 1;

      $("#cert_cnt").val(cert_total_cnt);

   }  

   function removeFileOfRow(idval)
   {

      $("#divid_"+idval).remove();

      $("#hdn"+idval).val('');

   }

</script>