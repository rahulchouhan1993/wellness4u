<?php
require_once('../config.php');
$page_id = '89';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode($menu_link);

if(!isLoggedInPro())
{
	header("Location: ".SITE_URL."/prof_login.php?ref=".$ref);
	exit(0);
}
else
{
	doUpdateOnlinePro($_SESSION['pro_user_id']);
	$pro_user_id = $_SESSION['pro_user_id'];
}

if(get_magic_quotes_gpc())
{
	foreach($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes($_POST[$k]);
	}
}

$error = false;
$tr_err_name = 'none';
$tr_err_email = 'none';
$tr_err_dob = 'none';
$tr_err_sex = 'none';
$tr_err_mobile = 'none';
$tr_err_address = 'none';
$tr_err_country_id = 'none';
$tr_err_state_id = 'none';
$tr_err_city_id = 'none';
$tr_err_place_id = 'none';
$tr_err_reg_no = 'none';
$tr_err_issued_by = 'none';  
$tr_err_scan_image = 'none';  
$tr_err_membership = 'none';    
$tr_err_services = 'none';
$tr_err_qualification = 'none';
$tr_err_university = 'none';
$tr_err_year = 'none';
$tr_err_catagory_id = 'none';
$tr_err_expertise_id = 'none';
$tr_err_referred_by = 'none';
$tr_err_ref_name = 'none';
$tr_err_specify = 'none';
$tr_err_div_ref_name = 'none';
$tr_err_div_specify = 'none';


$div_ref_name = '';
$div_specify = '';

$err_name = '';
$err_email = '';
$err_dob = '';
$err_sex = '';
$err_mobile = '';
$err_address = '';
$err_country_id = '';
$err_state_id = '';
$err_city_id = '';
$err_place_id = '';
$err_reg_no = '';
$err_issued_by = '';  
$err_scan_image = '';  
$err_referred_by = '';
$err_ref_name = '';
$err_specify = '';
$err_div_ref_name = '';
$err_div_specify = '';


$arr_membership = array();
$arr_err_membership = array();
$arr_tr_err_membership = array();
$arr_membership_no = array();
$arr_membership_image = array();

$arr_service_clinic_name = array();
$arr_service_location = array();
$arr_service_location_country_id = array();
$arr_service_location_state_id = array();
$arr_service_location_city_id = array();
$arr_service_location_place_id = array();
$arr_service_rendered = array();
$arr_service_notes = array();

$row_cnt = '1';
$row_totalRow = '1';

$row_cnt2 = '1';
$row_totalRow2 = '1';

if(isset($_POST['btnSubmit']))	
{
	$row_totalRow = trim($_POST['hdnrow_totalRow']);  
	$row_cnt = trim($_POST['hdnrow_cnt']);
	$row_totalRow2 = trim($_POST['hdnrow_totalRow2']);  
	$row_cnt2 = trim($_POST['hdnrow_cnt2']);
	$name = strip_tags(trim($_POST['name']));
	$dob = strip_tags(trim($_POST['dob']));
	$sex = strip_tags(trim($_POST['sex']));
	$mobile = strip_tags(trim($_POST['mobile']));
	$address = strip_tags(trim($_POST['address']));
	$country_id = strip_tags(trim($_POST['country_id']));
	$state_id = strip_tags(trim($_POST['state_id']));
	$city_id = strip_tags(trim($_POST['city_id']));
	$place_id = strip_tags(trim($_POST['place_id']));
	$reg_no   = strip_tags(trim($_POST['reg_no']));
	$issued_by = strip_tags(trim($_POST['issued_by']));    
	
	foreach ($_POST['membership'] as $key => $value) 
	{
		array_push($arr_membership,$value);
		array_push($arr_tr_err_membership,'none');
		array_push($arr_err_membership,'');
	}
	
	foreach ($_POST['membership_no'] as $key => $value) 
	{
		array_push($arr_membership_no,$value);
	}
	
	foreach ($_POST['service_clinic_name'] as $key => $value) 
	{
		array_push($arr_service_clinic_name,$value);
	}
	
	foreach ($_POST['service_location'] as $key => $value) 
	{
		array_push($arr_service_location,$value);
	}
	
	foreach ($_POST['hdncountry_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_country_id,$value);
	}
	
	foreach ($_POST['hdnstate_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_state_id,$value);
	}
	
	foreach ($_POST['hdncity_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_city_id,$value);
	}
	
	foreach ($_POST['hdnplace_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_place_id,$value);
	}
	
	foreach ($_POST['service_rendered'] as $key => $value) 
	{
		array_push($arr_service_rendered,$value);
	}
	
	foreach ($_POST['service_notes'] as $key => $value) 
	{
		array_push($arr_service_notes,$value);
	}
	
	$referred_by = strip_tags(trim($_POST['referred_by']));
	$ref_name = strip_tags(trim($_POST['ref_name']));
	$specify = strip_tags(trim($_POST['specify']));
	
	if($name == '')
	{
		$error = true;
		$tr_err_name = '';
		$err_name = 'Please enter your name';
	}
	
	if($dob == '')
	{
		$error = true;
		$tr_err_dob = '';
		$err_dob = 'Please enter your dob';
	}

	if($sex == '')
	{
		$error = true;
		$tr_err_sex = '';
		$err_sex = 'Please select your sex';
	}
	
	if($mobile == '')
	{
		$error = true;
		$tr_err_mobile = '';
		$err_mobile = 'Please enter your mobile no';
	}
	
	if($address == '')
	{
		$error = true;
		$tr_err_address = '';
		$err_address = 'Please enter your address';
	}
	
	if($country_id == '')
	{
		$error = true;
		$tr_err_country_id = '';
		$err_country_id = 'Please select your country';
	}
	
	if($state_id == '')
	{
		$error = true;
		$tr_err_state_id = '';
		$err_state_id = 'Please select your state';
	}
	
	if($city_id == '')
	{
		$error = true;
		$tr_err_city_id = '';
		$err_city_id = 'Please select your city';
	}
	
	if($place_id == '')
	{
		$error = true;
		$tr_err_place_id = '';
		$err_place_id = 'Please select your place';
	}
	
	if($reg_no == '')
	{
		$error = true;
		$tr_err_reg_no = '';
		$err_reg_no = 'Please enter your registration no.';
	}
	
	if($issued_by == '')
	{
		$error = true;
		$tr_err_issued_by = '';
		$err_issued_by = 'Please enter issued by details';
	}
	
	if(count($arr_membership) > 1)
	{
		for($i=0;$i<count($arr_membership);$i++)
		{
			if(trim($arr_membership[$i]) == '' && trim($arr_membership_no[$i]) == '')
			{
				$error = true;
				$arr_tr_err_membership[$i] = '';
				$arr_err_membership[$i] = 'Please enter membership details';
			}
			
			if(isset($_FILES['membership_image']['tmp_name'][$i]) && $_FILES['membership_image']['tmp_name'][$i] != '')
			{
				$membership_image = $_FILES['membership_image']['name'][$i];
				
				$file4 = substr($membership_image, -4, 4);
				 
				if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
				{
					$error = true;
					//$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for membership scan image';
					$arr_tr_err_membership[$i] = '';
					$arr_err_membership[$i] .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for membership scan image';
				}	 
				elseif( $_FILES['membership_image']['type'][$i] != 'image/jpeg' and $_FILES['membership_image']['type'][$i] != 'image/pjpeg'  and $_FILES['membership_image']['type'][$i] != 'image/gif' and $_FILES['membership_image']['type'][$i] != 'image/png' )
				{
					$error = true;
					//$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for membership scan image!';
					$arr_tr_err_membership[$i] = '';
					$arr_err_membership[$i] .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for membership scan image!';
				}
			
				if(!$error)
				{	
					$membership_image = time()."_".$membership_image;
					$temp_dir = SITE_PATH.'/uploads/';
					$temp_file = $temp_dir.$membership_image;
			
					if(!move_uploaded_file($_FILES['membership_image']['tmp_name'][$i], $temp_file)) 
					{
						if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
						$error = true;
						//$err_msg .= '<br>Couldn\'t Upload membership scan image.';
						$arr_tr_err_membership[$i] = '';
						$arr_err_membership[$i] = 'Couldn\'t Upload membership scan image.';
						$membership_image = $_POST['hdnmembership_image_'.$i];
					}
					$arr_membership_image[$i] = $membership_image;
				}
				else
				{	
					$arr_membership_image[$i] = $_POST['hdnmembership_image_'.$i];;
				}
			}  
			else
			{	
				$arr_membership_image[$i] = $_POST['hdnmembership_image_'.$i];;
			}
			
		}
	}	
	
	if($referred_by == '')
	{
		//$error = true;
		//$tr_err_referred_by = '';
		//$err_referred_by = 'Please select referred by option';
	}
	else
	{
		if($ref_name =='' )
		{
			$error = true;
			$tr_err_ref_name = '';
			$err_ref_name = 'Please enter name';
		}
	}
	if(!$error)
	{
		if(isset($_FILES['scan_image']['tmp_name']) && $_FILES['scan_image']['tmp_name'] != '')
		{
			$scan_image = $_FILES['scan_image']['name'];
			$file4 = substr($scan_image, -4, 4);
			
			if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
			{
				$error = true;
				$tr_scan_image = '';
				$err_scan_image = 'Please Upload Only(jpg/gif/jpeg/png) files for scan image';
			}	 
			elseif( $_FILES['scan_image']['type'] != 'image/jpeg' and $_FILES['scan_image']['type'] != 'image/pjpeg'  and $_FILES['scan_image']['type'] != 'image/gif' and $_FILES['scan_image']['type'] != 'image/png' )
			{
				$error = true;
				$tr_scan_image = '';
				$err_scan_image = 'Please Upload Only(jpg/gif/jpeg/png) files for scan image';
			}
			
			
			if(!$error)
			{	
				
				$scan_image = time()."_".$scan_image;
				$temp_dir = SITE_PATH.'/uploads/';
				$temp_file = $temp_dir.$scan_image;
		
				if(!move_uploaded_file($_FILES['scan_image']['tmp_name'], $temp_file)) 
				{
					if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
					$error = true;
					$tr_scan_image = '';
					$err_scan_image = 'Couldn\'t Upload scan image';
					$scan_image = $_POST['hdnscan_image'];
				}
			}
			else
			{
				$scan_image = $_POST['hdnscan_image'];
			}
		}  
		else
		{
			$scan_image = $_POST['hdnscan_image'];
		}
		
		if(!$error)
		{
		
			$dob = date('Y-m-d',strtotime($dob));
			
			$membership = implode('::',$arr_membership);
			$membership_no = implode('::',$arr_membership_no);
			$membership_image = implode('::',$arr_membership_image);
			$service_clinic_name = implode('::',$arr_service_clinic_name);
			$service_location = implode('::',$arr_service_location);
			$service_location_country_id = implode('::',$arr_service_location_country_id);
			$service_location_state_id = implode('::',$arr_service_location_state_id);
			$service_location_city_id = implode('::',$arr_service_location_city_id);
			$service_location_place_id = implode('::',$arr_service_location_place_id);
			$service_rendered = implode('::',$arr_service_rendered);
			$service_notes = implode('::',$arr_service_notes);
	
			if(updateUserPro($name,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify,$pro_user_id))
			{
				$_SESSION['pro_name'] = $name;
				header("Location: message.php?msg=2"); 
			}
			else
			{
				$err_msg = 'There is some problem right now!Please try again later';
			}
		}	
	}
	else
	{
		$scan_image = $_POST['hdnscan_image'];
	}
}
else
{
	list($return,$name,$email,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify) = getUserDetailsPro($pro_user_id);

	if(!$return)
	{
		header("Location: message.php");
		exit(0);
	}
	else
	{
		if($membership != '')
		{
			$arr_membership = explode('::',$membership);
			$arr_membership_no = explode('::',$membership_no);
			$arr_membership_image = explode('::',$membership_image);
			
			if(count($arr_membership) > 0)
			{
				$row_cnt = count($arr_membership);
				$row_totalRow = count($arr_membership);
			}
		}		
		
		
		if($service_clinic_name != '')
		{
			$arr_service_clinic_name = explode('::',$service_clinic_name);
			$arr_service_location = explode('::',$service_location);
			$arr_service_location_country_id = explode('::',$service_location_country_id);
			$arr_service_location_state_id = explode('::',$service_location_state_id);
			$arr_service_location_city_id = explode('::',$service_location_city_id);
			$arr_service_location_place_id = explode('::',$service_location_place_id);
			$arr_service_rendered = explode('::',$service_rendered);
			$arr_service_notes = explode('::',$service_notes);
			
			if(count($arr_service_clinic_name) > 0)
			{	
				$row_cnt2 = count($arr_service_clinic_name);
				$row_totalRow2 = count($arr_service_clinic_name);
			}
		}	
		
		
	}
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
     <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="../csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
	<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="../js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
    
    <style type="text/css">@import "../css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="../js/jquery.datepick.js"></script>
    
    <link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery.ticker.js" type="text/javascript"></script>
    
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
		
			$(".QTPopup").css('display','none')

			$(".feedback").click(function(){
				$(".QTPopup").animate({width: 'show'}, 'slow');
			});	

			$(".closeBtn").click(function(){			
				$(".QTPopup").css('display', 'none');
			});
			
			$('#addMoreMembershipRows').click(function() {
		
				var row_cnt = parseInt($('#hdnrow_cnt').val());
				var row_totalRow = parseInt($('#hdnrow_totalRow').val());
				
				$('#tblrow tr:#add_before_this_row').before('<tr class="row_id_membership_'+row_cnt+'"><td height="50" align="left" valign="top">Memberships: &nbsp;</td><td height="50" align="left" valign="top"><input name="membership[]" type="text" class="form-control" id="membership_'+row_cnt+'" size="45" value="" /></td></tr><tr class="row_id_membership_'+row_cnt+'"><td height="50" align="left" valign="top">Memberships No: &nbsp;</td><td height="50" align="left" valign="top"><input name="membership_no[]" type="text" class="form-control" id="membership_no_'+row_cnt+'" size="45" value="" /></td></tr><tr class="row_id_membership_'+row_cnt+'"><td height="50" align="left" valign="top">Scan Copy: &nbsp;</td><td height="50" align="left" valign="top"><input name="membership_image[]" type="file" id="membership_image_'+row_cnt+'" />&nbsp;<input type="button" value="Remove Item" id="tr_row_'+row_cnt+'" name="tr_row_'+row_cnt+'" onclick="removeMultipleRows(\'row_id_membership_'+row_cnt+'\',\'hdnrow_totalRow\')" /></td></tr><tr class="row_id_membership_'+row_cnt+'" id="tr_err_membership_'+row_cnt+'" style="display:none;"><td align="right">&nbsp; </td><td valign="top" align="left" class="err_msg" id="err_membership_'+row_cnt+'"></td></tr><tr class="row_id_membership_'+row_cnt+'"><td height="50" align="left" valign="top">&nbsp;</td><td height="50" align="left" valign="top">&nbsp;</td></tr>');	
					
				row_cnt = row_cnt + 1;       
				$('#hdnrow_cnt').val(row_cnt);
				var row_cnt = $('#hdnrow_cnt').val();
				row_totalRow = row_totalRow + 1;       
				$('#hdnrow_totalRow').val(row_totalRow);
							
			});
			
			$('#addMoreServiceRows').click(function() {
		
				var row_cnt2 = parseInt($('#hdnrow_cnt2').val());
				var tempcnt = row_cnt2 + 1;
				var row_totalRow2 = parseInt($('#hdnrow_totalRow2').val());
				
				$('#tblrow2 tr:#add_before_this_row2').before('<tr class="row_id_service_'+row_cnt2+'"><td height="50" align="left" valign="top">'+tempcnt+'</td><td height="50" align="left" valign="top"><input name="service_clinic_name[]" type="text" class="form-control" id="service_clinic_name_'+row_cnt2+'" size="25" value="" style="width:120px;" /></td><td height="50" align="left" valign="top"><input name="service_location[]" type="text" class="form-control" id="service_location_sl_'+row_cnt2+'" size="25" value="" style="width:120px;" readonly="readonly" onfocus="showLocationPopup(\'sl_'+row_cnt2+'\')" /><input type="hidden" name="hdncountry_id_sl[]" id="hdncountry_id_sl_'+row_cnt2+'" value="" /><input type="hidden" name="hdnstate_id_sl[]" id="hdnstate_id_sl_'+row_cnt2+'" value="" /><input type="hidden" name="hdncity_id_sl[]" id="hdncity_id_sl_'+row_cnt2+'" value="" /><input type="hidden" name="hdnplace_id_sl[]" id="hdnplace_id_sl_'+row_cnt2+'" value="" /></td><td height="50" align="left" valign="top"><input name="service_rendered[]" type="text" class="form-control" id="service_rendered_'+row_cnt2+'" size="25" value="" style="width:120px;" /></td><td height="50" align="left" valign="top"><input name="service_notes[]" type="text" class="form-control" id="service_notes_'+row_cnt2+'" size="25" value="" style="width:120px;" /></td><td height="50" align="left" valign="top"><input type="button" value="Remove" id="tr_row2_'+row_cnt2+'" name="tr_row2_'+row_cnt2+'" onclick="removeMultipleRows(\'row_id_service_'+row_cnt2+'\',\'hdnrow_totalRow2\')" /></td></tr>');	
					
				row_cnt2 = row_cnt2 + 1;       
				$('#hdnrow_cnt2').val(row_cnt2);
				var row_cnt2 = $('#hdnrow_cnt2').val();
				row_totalRow2 = row_totalRow2 + 1;       
				$('#hdnrow_totalRow2').val(row_totalRow2);
							
			});
		});			
	</script>
</head>
<body id="boxed">
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<div class="boxed-wrapper">
<!--header-->
<header>
 <?php include 'topbar.php'; ?>
<?php include_once('header.php');?>
</header>
<!--header End --> 			
<!--breadcrumb--> 
  
 <div class="container"> 
    <div class="breadcrumb">
               
                    <div class="row">
                    <div class="col-md-8">	
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                         <div class="col-md-4">
                         <?php

                    if(isLoggedIn())

                    { 

                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

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
<div class="col-md-8">	

						 
						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
							<tr>
								<td align="center" valign="middle" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
									<form action="#" name="frmedit_profile" id="frmedit_profile" method="post" enctype="multipart/form-data"> 
                                    	<input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
                                        <input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
                                        <input type="hidden" name="hdnrow_cnt2" id="hdnrow_cnt2" value="<?php echo $row_cnt2;?>" />
                                        <input type="hidden" name="hdnrow_totalRow2" id="hdnrow_totalRow2" value="<?php echo $row_totalRow2;?>" />
                                        <input type="hidden" name="hdnscan_image" id="hdnscan_image" value="<?php echo $scan_image;?>" />
										<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblrow">
											<tr>
												<td height="35" colspan="2" align="left" valign="top" class="Header_brown"><?php echo getPageTitle($page_id);?></td>
											</tr>
											<tr>
												<td colspan="2" align="left" class="err_msg"><?php echo $err_msg;?></td>
											</tr>
											<tr>
                                                <td width="30%" height="50" align="left" valign="top">Name:</td>
                                                <td width="70%" height="50" align="left" valign="top"><input name="name" type="text" class="form-control" id="name" size="45"  value="<?php echo $name; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_name" style="display:<?php echo $tr_err_name;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_name"><?php echo $err_name;?></td>
                                            </tr>
                                            <tr>
												<td height="50" align="left" valign="top">DOB:</td>
												<td height="50" align="left" valign="top">
													<input name="dob" class="form-control" id="dob" type="text" value="<?php echo $dob;?>" />
                                    				<script>$('#dob').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                               	</td>
											</tr>
											<tr id="tr_err_dob" style="display:<?php echo $tr_err_dob;?>;">
												<td align="right">&nbsp; </td>
												<td valign="top" align="left" class="err_msg" id="err_dob"><?php echo $err_dob;?></td>
											</tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Sex:</td>
                                                <td height="50" align="left" valign="top">
                                                    <input type="radio" name="sex" id="sex" value="Male" <?php if($sex == "Male") { ?> checked="checked" <?php } ?> />
                                                    Male 
                                                    <input type="radio" name="sex" id="sex" value="Female" <?php if($sex == "Female") { ?> checked="checked" <?php } ?> />
                                                    Female	
                                                </td>
                                            </tr>
                                            <tr id="tr_err_sex" style="display:<?php echo $tr_err_sex;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_sex"><?php echo $err_sex;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Mobile No:</td>
                                                <td height="50" align="left" valign="top"><input name="mobile" type="text" class="form-control" id="mobile" size="45" value="<?php echo $mobile; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_mobile" style="display:<?php echo $tr_err_mobile;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_mobile"><?php echo $err_mobile;?></td>
                                            </tr>
                                            <tr>
                                                <td height="65" align="left" valign="top">Address:</td>
                                                <td height="65" align="left" valign="top"><textarea name="address" id="address" class="form-control" rows="3"><?php echo $address; ?></textarea></td>
                                            </tr>
                                            <tr id="tr_err_address" style="display:<?php echo $tr_err_address;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_address"><?php echo $err_address;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Country:</td>
                                                <td height="50" align="left" valign="top">
                                                    <select class="form-control" name="country_id" id="country_id" onchange="getStateOptions('<?php echo $state_id;?>')">
                                                        <option value="">Select Country</option>
                                                        <?php echo getCountryOptions($country_id);?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_country_id" style="display:<?php echo $tr_err_country_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_country_id"><?php echo $err_country_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">State:</td>
                                                <td height="50" align="left" valign="top" id="tdstate">
                                                    <select class="form-control" name="state_id" id="state_id" onchange="getCityOptions('<?php echo $city_id;?>');">
                                                        <option value="">Select State</option>
                                                        <?php echo getStateOptions($country_id,$state_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_state_id" style="display:<?php echo $tr_err_state_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_state_id"><?php echo $err_state_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">City:</td>
                                                <td height="50" align="left" valign="top" id="tdcity">
                                                    <select class="form-control" name="city_id" id="city_id" onchange="getPlaceOptions('<?php echo $place_id;?>');">
                                                        <option value="">Select City</option>
                                                        <?php echo getCityOptions($state_id,$city_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_city_id" style="display:<?php echo $tr_err_city_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_city_id"><?php echo $err_city_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Place:</td>
                                                <td height="50" align="left" valign="top" id="tdplace">
                                                    <select class="form-control" name="place_id" id="place_id">
                                                        <option value="">Select Place</option>
                                                        <?php echo getPlaceOptions($state_id,$city_id,$place_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_place_id" style="display:<?php echo $tr_err_place_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_place_id"><?php echo $err_place_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Practitioner Registration Number:</td>
                                                <td height="50" align="left" valign="top"><input name="reg_no" type="text" class="form-control" id="reg_no" size="45" value="<?php echo $reg_no ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_reg_no" style="display:<?php echo $tr_err_reg_no;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_reg_no"><?php echo $err_reg_no;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Issued by:</td>
                                                <td height="50" align="left" valign="top"><input name="issued_by" type="text" class="form-control" id="issued_by" size="45" value="<?php echo $issued_by; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_issued_by" style="display:<?php echo $tr_err_issued_by;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_issued_by"><?php echo $err_issued_by;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Scan Copy:</td>
                                                <td height="50" align="left" valign="top">
                                                	<?php
													if($scan_image != '')
													{ ?>
                                                    <img border="0" width="100" src="<?php echo SITE_URL.'/uploads/'.$scan_image;?>"  /><br /><br />
                                                    <?php
													} ?>
                                                    <input class="form-control" name="scan_image" type="file" id="scan_image" />
                                                </td>
                                            </tr>
                                            <tr id="tr_err_scan_image" style="display:<?php echo $tr_err_scan_image;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_scan_image"><?php echo $err_scan_image;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                            </tr>
										<?php
                                        for($i=0;$i<$row_totalRow;$i++)
                                        {  ?>
                                            <tr class="row_id_membership_<?php echo $i; ?>">
                                                <td height="50" align="left" valign="top">Memberships: &nbsp;</td>
                                                <td height="50" align="left" valign="top">
                                                	<input name="membership[]" type="text" class="form-control" id="membership_<?php echo $i; ?>" size="45" value="<?php echo $arr_membership[$i]; ?>" />
                                                </td>
                                            </tr>
                                            <tr class="row_id_membership_<?php echo $i; ?>">
                                                <td height="50" align="left" valign="top">Memberships No: &nbsp;</td>
                                                <td height="50" align="left" valign="top">
                                                	<input name="membership_no[]" type="text" class="form-control" id="membership_no_<?php echo $i; ?>" size="45" value="<?php echo $arr_membership_no[$i]; ?>" />
                                                    
                                                </td>
                                            </tr>
                                            <tr class="row_id_membership_<?php echo $i; ?>">
                                                <td height="50" align="left" valign="top">Scan Copy: &nbsp;</td>
                                                <td height="50" align="left" valign="top">
                                                	<?php
													if($arr_membership_image[$i] != '')
													{ ?>
                                                    <img border="0" width="100" src="<?php echo SITE_URL.'/uploads/'.$arr_membership_image[$i];?>"  /><br /><br />
                                                    <?php
													} ?>
                                                
                                                	<input type="hidden" name="hdnmembership_image_<?php echo $i;?>" id="hdnmembership_image_<?php echo $i;?>" value="<?php echo $arr_membership_image[$i];?>"  />
                                                	<input class="form-control" name="membership_image[]" type="file" id="membership_image_<?php echo $i; ?>" />
                                                    <?php
													if($i > 0)
													{ ?>
														&nbsp;&nbsp;<input type="button" value="Remove Item" id="tr_row_<?php echo $i; ?>" name="tr_row_<?php echo $i; ?>" onclick="removeMultipleRows('row_id_membership_<?php echo $i; ?>','hdnrow_totalRow')" />
													<?php } ?>
                                                </td>
                                            </tr>
                                            <tr class="row_id_membership_<?php echo $i; ?>" id="tr_err_membership_<?php echo $i; ?>" style="display:<?php echo $arr_tr_err_membership[$i];?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_membership_<?php echo $i; ?>"><?php echo $arr_err_membership[$i];?></td>
                                            </tr>
                                            <tr class="row_id_membership_<?php echo $i; ?>">
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                            </tr> 
                                        <?php
										} ?>
                                        	<tr id="add_before_this_row">
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreMembershipRows">Add More Membership</a></td>
                                            </tr> 
                                        	<tr>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                            </tr>  
                                            <tr>
                                                <td height="40" colspan="2" align="left" valign="top"><strong>Currently providing Services at:</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" valign="top">
                                                	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow2">
                                                    	<tr>
                                                        	<td width="10%" height="50" align="left" valign="top"><strong>SrNo</strong></td>
                                                            <td width="20%" height="50" align="left" valign="top"><strong>Name of Facility /Clinic</strong></td>
                                                            <td width="20%" height="50" align="left" valign="top"><strong>Location</strong></td>
                                                            <td width="20%" height="50" align="left" valign="top"><strong>Wellness Services rendered</strong></td>
                                                            <td width="20%" height="50" align="left" valign="top"><strong>Notes</strong></td>
                                                            <td width="10%" height="50" align="left" valign="top"><strong></strong></td>
                                                		</tr>
													<?php
                                                    for($i=0,$j=1;$i<$row_totalRow2;$i++,$j++)
                                                    {  ?>
                                                        <tr class="row_id_service_<?php echo $i; ?>">
                                                            <td height="50" align="left" valign="top"><?php echo $j; ?></td>
                                                            <td height="50" align="left" valign="top">
                                                                <input name="service_clinic_name[]" type="text" class="form-control" id="service_clinic_name_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_clinic_name[$i]; ?>" style="width:120px;" />
                                                            </td>
                                                            <td height="50" align="left" valign="top">
                                                                <input name="service_location[]" type="text" class="form-control" id="service_location_sl_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_location[$i]; ?>" style="width:120px;" readonly="readonly" onfocus="showLocationPopup('sl_<?php echo $i; ?>')" />
                                                                <input type="hidden" name="hdncountry_id_sl[]" id="hdncountry_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_country_id[$i]; ?>"  />
                                                                <input type="hidden" name="hdnstate_id_sl[]" id="hdnstate_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_state_id[$i]; ?>"  />
                                                                <input type="hidden" name="hdncity_id_sl[]" id="hdncity_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_city_id[$i]; ?>"  />
                                                                <input type="hidden" name="hdnplace_id_sl[]" id="hdnplace_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_place_id[$i]; ?>"  />
                                                            </td>
                                                            <td height="50" align="left" valign="top">
                                                                <input name="service_rendered[]" type="text" class="form-control" id="service_rendered_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_rendered[$i]; ?>" style="width:120px;" />
                                                            </td>
                                                            <td height="50" align="left" valign="top">
                                                                <input name="service_notes[]" type="text" class="form-control" id="service_notes_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_notes[$i]; ?>" style="width:120px;" />
                                                            </td>
                                                            <td height="50" align="left" valign="top">
                                                               <?php
																if($i > 0)
																{ ?>
														<input type="button" value="Remove" id="tr_row2_<?php echo $i; ?>" name="tr_row2_<?php echo $i; ?>" onclick="removeMultipleRows('row_id_service_<?php echo $i; ?>','hdnrow_totalRow2')" />
													<?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>    
                                                        <tr id="add_before_this_row2">
                                                            <td colspan="6" height="50" align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreServiceRows">Add More Service</a></td>
                                                        </tr> 
                                                        <tr>
                                                            <td colspan="6" height="50" align="left" valign="top">&nbsp;</td>
                                                        </tr>  
													
                                                	</table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" height="50" align="left" valign="top">
                                                
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="50"><strong>Referred by:  </strong></td>
    <td><select class="form-control" name="referred_by" id="referred_by">
                                                        <option value="">Select </option>
                                                        <option value="user" <?php if($referred_by == 'user') {?> selected="selected" <?php } ?>>User</option>
                                                        <option value="practitioner" <?php if($referred_by == 'practitioner') {?> selected="selected" <?php } ?>>Practitioner</option>
                                                        <option value="others" <?php if($referred_by == 'others') {?> selected="selected" <?php } ?>>Other Medium</option>
                                                    </select></td>
  </tr>
  <tr>
    <td width="30%" height="50"><strong>Name:</strong></td>
    <td width="70%"><input class="form-control" type="text" id="ref_name"  name="ref_name" value="<?php echo $ref_name; ?>"/></td>
  </tr>
  <tr>
    <td height="50"><strong>Specify:</strong></td>
    <td><input class="form-control" type="text" id="specify" name="specify" value="<?php echo $specify; ?>"/></td>
  </tr>
</table>             </td>
                                            </tr>
                                            <tr id="tr_err_referred_by" style="display:<?php echo $tr_err_referred_by;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_referred_by"><?php echo $err_referred_by;?></td>
                                            </tr>
                                            <tr id="tr_err_ref_name" style="display:<?php echo $tr_err_ref_name;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_ref_name"><?php echo $err_ref_name;?></td>
                                            </tr>
                                            <tr id="tr_err_specify" style="display:<?php echo $tr_err_specify;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_specify"><?php echo $err_specify;?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" align="left" valign="top">&nbsp;</td>
                                                <td height="20" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            
											<tr>
												<td height="40" align="left" valign="middle">&nbsp;</td>
												<td height="40" align="left" valign="bottom"><input name="btnSubmit" type="submit" class="btn btn-primary" id="btnSubmit" value="Submit" /></td>
											</tr>
                                             <tr>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                                <td height="50" align="left" valign="top">&nbsp;</td>
                                            </tr>
							</table>			
									</form>	
								</td>
							</tr>
						</table>

    </div>
</div>
</div>

<!--container-->                   <!--  Footer-->
  <footer> 
   <div class="container">
   <div class="row">
   <div class="col-md-12">	
   <?php include_once('footer.php');?>            
  </div>
  </div>
  </div>
  </footer>
  <!--  Footer-->
            <!--default footer end here-->
</div><!--box wrapper end-->
        
        <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <!--<script src="../csswell/js/jquery.min.js"></script>  -->      
        <!--bootstrap js plugin-->
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <!--easing plugin for smooth scroll-->
        <script src="../csswell/js/jquery.easing.1.3.min.js" type="text/javascript"></script>
     

    </body>

</html>