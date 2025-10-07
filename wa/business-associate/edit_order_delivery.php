<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '23';
$edit_action_id = '69';

$obj = new Admin();
$obj2 = new commonFunctions();
if(!$obj->isAdminLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$admin_id = $_SESSION['admin_id'];
}

if(!$obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))
{
	header("Location: invalid.php");
	exit(0);
}

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	header("Location: invalid.php");
	exit(0);
}

$error = false;
$err_msg = "";
$msg = '';

if(isset($_GET['token']) && $_GET['token'] != '')
{
	$od_id = base64_decode($_GET['token']);
	$arr_record = $obj->getOrderDeliveryDetails($od_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_order_delivery.php");
		exit(0);
	}
	
	$invoice = $arr_record['invoice'];
	
	$arr_order_cart_id = array($arr_record['order_item_id']);
	$str_order_cart_id = $arr_record['order_item_id'];
	
	$delivery_date = date('d-m-Y',strtotime($arr_record['delivery_date']));
	$logistic_partner_type_parent_cat_id = 151; 
	$logistic_partner_type_cat_id = $arr_record['logistic_partner_type']; 
	$logistic_partner_id = $arr_record['logistic_partner_id']; 
	$delivery_person_name = $arr_record['delivery_person_name']; 
	$delivery_person_contact_no = $arr_record['delivery_person_contact_no']; 
	$reciever_name = $arr_record['reciever_name']; 
	$reciever_contact_no = $arr_record['reciever_contact_no']; 
	$other_reciever_name = $arr_record['other_reciever_name']; 
	$other_reciever_contact_no = $arr_record['other_reciever_contact_no']; 
	$delivery_status = $arr_record['delivery_status']; 
	$consignment_note = $arr_record['consignment_note']; 
	$other_comments = $arr_record['other_comments']; 
	$proof_of_delivery = $arr_record['proof_of_delivery']; 
}	
else
{
	header("Location: manage_order_delivery.php");
	exit(0);
}	
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Admin</title>
	<?php require_once 'head.php'; ?>
	<link href="assets/css/tokenize2.css" rel="stylesheet" />
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
<?php include_once('header.php');?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="edit_order_delivery" name="edit_order_delivery" method="post"> 
						<input type="hidden" name="hdnstr_order_cart_id" id="hdnstr_order_cart_id" value="<?php  echo $str_order_cart_id?>" >
						<input type="hidden" name="hdnod_id" id="hdnod_id" value="<?php echo $od_id;?>" >
						<input type="hidden" name="hdnproof_of_delivery" id="hdnproof_of_delivery" value="<?php echo $proof_of_delivery;?>" >
						<div class="form-group">
							<label class="col-lg-2 control-label">Order Invoice:</label>
							<label class="col-lg-4 control-label"><strong><?php echo $obj->getInvoiceStrWithNameAnddate($invoice);?></strong></label>
							<input type="hidden" name="invoice" id="invoice" value="<?php echo $invoice;?>">
							<?php
							/*
							<div class="col-lg-4">
								<select name="invoice" id="invoice" class="form-control" required onchange="getOrderDeliveryDate()">
									<?php echo $obj->getOrderInvoiceOption($invoice); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Delivery Date<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="delivery_date" name="delivery_date" value="<?php echo $delivery_date;?>" class="form-control"  required>
							</div>
							*/ ?>
						</div>
						<div class="form-group" >
							<div class="col-lg-1"></div>
							<div class="col-lg-10" id="od_items_list">
								<?php echo $obj->getOrderCartItemsListOfInvoice($invoice,$arr_order_cart_id,'1'); ?>
							</div>
							<div class="col-lg-1"></div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Logistic Partner Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="logistic_partner_type_cat_id" id="logistic_partner_type_cat_id" onchange="getLogisticPartnerOption('1')" class="form-control" required>
									<?php echo $obj->getMainCategoryOption($logistic_partner_type_parent_cat_id,$logistic_partner_type_cat_id); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Logistic Partner</label>
							<div class="col-lg-4">
								<select name="logistic_partner_id" id="logistic_partner_id" class="form-control">
									<?php echo $obj->getLogisticPartnerOption($logistic_partner_type_cat_id,$logistic_partner_id); ?>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Consignment Note</label>
							<div class="col-lg-10">
								<textarea id="consignment_note" name="consignment_note" class="form-control"><?php echo $consignment_note?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Delivery Person Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="delivery_person_name" name="delivery_person_name" value="<?php echo $delivery_person_name;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Delivery Person Contact No</label>
							<div class="col-lg-4">
								<input type="text" id="delivery_person_contact_no" name="delivery_person_contact_no" value="<?php echo $delivery_person_contact_no;?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Receiver Name</label>
							<div class="col-lg-4">
								<input type="text" id="reciever_name" name="reciever_name" value="<?php echo $reciever_name;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Receiver Contact No</label>
							<div class="col-lg-4">
								<input type="text" id="reciever_contact_no" name="reciever_contact_no" value="<?php echo $reciever_contact_no;?>" class="form-control">
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Other Receiver Name</label>
							<div class="col-lg-4">
								<input type="text" id="other_reciever_name" name="other_reciever_name" value="<?php echo $other_reciever_name;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Other Receiver Contact No</label>
							<div class="col-lg-4">
								<input type="text" id="other_reciever_contact_no" name="other_reciever_contact_no" value="<?php echo $other_reciever_contact_no;?>" class="form-control">
							</div>
						</div>			
						<div class="form-group">
							<label class="col-lg-2 control-label">Delivery Status<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="delivery_status" id="delivery_status" class="form-control" required>
									<?php echo $obj->getOrderDeiveryStatusOption($delivery_status); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Proof of Delivery</label>
							<div class="col-lg-4">
							<?php
							if($proof_of_delivery != '')
							{ ?>
								<?php
								$file4 = substr($proof_of_delivery, -4, 4);
								if(strtolower($file4) == '.pdf')
								{ ?>
									<a title="<?php echo $proof_of_delivery;?>" href="<?php echo SITE_URL.'/uploads/'.$proof_of_delivery;?>" target="_blank">View Pdf</a>
								<?php	
								}	
								else
								{ ?>
									<img title="<?php echo $proof_of_delivery;?>" alt="<?php echo $proof_of_delivery;?>" border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$proof_of_delivery;?>" />
								<?php		
								} ?>
									<a href="javascript:void(0);" onclick="removeFileOfRow('proof_of_delivery');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" style="margin-bottom:10px;" data-original-title=""><i class="fa fa-remove"></i></a>
							<?php	
							} ?>
								<input type="file" id="proof_of_delivery" name="proof_of_delivery" class="form-control">
							</div>
						</div>			
						<div class="form-group">
							<label class="col-lg-2 control-label">Other Comments</label>
							<div class="col-lg-10">
								<textarea id="other_comments" name="other_comments" class="form-control"><?php echo $other_comments?></textarea>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_order_delivery.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
								</div>
							</div>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php');?>
<!--Common plugins-->
<?php require_once('script.php'); ?>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="admin-js/edit-order-delivery-validator.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{
	$('#delivery_date').datepicker();
	
	function removeFileOfRow(idval)
	{
		$("#divid_"+idval).remove();
		$("#hdn"+idval).val('');
		
	}
	
	function getStateOption()
	{
		var country_id = $('#country_id').val();
		var state_id = $('#state_id').val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
		
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&type=2&multiple=1&action=getstateoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#state_id").html(result);
				getCityOption();
			}
		});
	}
	
	function getCityOption()
	{
		var country_id = $('#country_id').val();
		var state_id = $('#state_id').val();
		var city_id = $('#city_id').val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
				
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		if(city_id == null)
		{
			city_id = '-1';
		}
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&type=2&multiple=1&action=getcityoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#city_id").html(result);
				getAreaOption();
			}
		});
	}
	
	function getAreaOption()
	{
		var country_id = $('#country_id').val();
		var state_id = $('#state_id').val();
		var city_id = $('#city_id').val();
		var area_id = $('#area_id').val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
				
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		if(city_id == null)
		{
			city_id = '-1';
		}
		
		if(area_id == null)
		{
			area_id = '-1';
		}
				
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&type=2&multiple=1&action=getareaoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#area_id").html(result);
			}
		});
	}
	
	$('#country_id').on('change', function() {
		getStateOption();
	});
	
	$('#state_id').on('change', function() {
		getCityOption();
	});
	
	$('#city_id').on('change', function() {
		getAreaOption();
	});
	
});


</script>
</body>
</html>