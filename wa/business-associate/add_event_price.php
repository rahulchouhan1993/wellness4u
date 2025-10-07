<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '12';

$view_action_id = '27';

$add_action_id = '28';

$edit_action_id = '29';

$delete_action_id = '30';

$obj = new Vendor();

if(!$obj->isVendorLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$vendor_id = $_SESSION['adm_vendor_id'];

}



if(!$obj->chkIfAccessOfMenu($vendor_id,$admin_main_menu_id))

{

	header("Location: invalid.php");

	exit(0);

}







if(isset($_GET['msg']) && $_GET['msg'] != '')

{

	$msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.urldecode($_GET['msg']).'</strong></div>';

}

else

{

	$msg = '';

}



$error = false;

$err_msg = "";

$msg = '';



$cat_cnt = 0;

$cat_total_cnt = 1;

$loc_cnt = 0;

$loc_total_cnt = 1;

$cw_cnt = 0;

$cw_total_cnt = 1;





$item_id = '';

$vendor_id = '';

$vendor_show = '';

$cusine_type_parent_id = '119';

$cusine_type_id = '';

$min_cart_price = '';

$arr_cucat_parent_cat_id = array('');

$arr_cucat_cat_id = array('');

$arr_cucat_show = array('');





$cw_qt_parent_cat_id = '197';

$cw_qu_parent_cat_id = '147';

$arr_cw_qt_parent_cat_id = array('197');

$arr_cw_qt_cat_id = array('');

$arr_cw_qu_parent_cat_id = array('147');

$arr_cw_qu_cat_id = array('');

$arr_cw_quantity = array('');

$arr_cw_show = array('');



$arr_vloc_id = array('');

$arr_ordering_type_id = array('');

$arr_ordering_size_id = array('');

$arr_ordering_size_show = array('');

$arr_max_order = array('');

$arr_min_order = array('');

$arr_cusine_qty = array('');

$arr_cusine_qty_show = array('');

$arr_sold_qty_show = array('');

$arr_currency_id = array('');

$arr_cusine_price = array('');

$arr_default_price = array('');



$arr_is_offer = array('');

$arr_offer_price = array('');

$arr_offer_date_type = array('');

$arr_offer_days_of_month = array(array('-1'));

$arr_offer_days_of_month_str = array('');

$arr_offer_days_of_week = array(array('-1'));

$arr_offer_days_of_week_str = array('');

$arr_offer_single_date = array('');

$arr_offer_start_date = array('');

$arr_offer_end_date = array('');



$arr_country_id = array('-1');

$arr_state_id = array('-1');

$arr_city_id = array('-1');

$arr_area_id = array('-1');



$publish_date_type = '';

$arr_publish_days_of_month = array('-1');

$arr_publish_days_of_week = array('-1');

$publish_single_date = '';

$publish_start_date = '';

$publish_end_date = '';



$delivery_date_type = '';

$arr_delivery_days_of_month = array('-1');

$arr_delivery_days_of_week = array('-1');

$delivery_single_date = '';

$delivery_start_date = '';

$delivery_end_date = '';



$order_cutoff_time = '';

$delivery_time = '';

$delivery_time_show = '';

$delivery_date_show = '';



$cancel_cutoff_time = '';

$cancel_cutoff_time_show = '';



$publish_show_days_of_month = 'none';

$publish_show_days_of_week = 'none';

$publish_show_single_date = 'none';

$publish_show_start_date = 'none';

$publish_show_end_date = 'none';

$delivery_show_days_of_month = 'none';

$delivery_show_days_of_week = 'none';

$delivery_show_single_date = 'none';

$delivery_show_start_date = 'none';

$delivery_show_end_date = 'none';



$arr_offer_show_days_of_month = array('none');

$arr_offer_show_days_of_week = array('none');

$arr_offer_show_single_date = array('none');

$arr_offer_show_start_date = array('none');

$arr_offer_show_end_date = array('none');

$arr_offer_show_price_label = array('none');

$arr_offer_show_price_value = array('none');

$arr_offer_show_date = array('none');



$arr_discount_show_days_of_month = array('none');

$arr_discount_show_days_of_week = array('none');

$arr_discount_show_single_date = array('none');

$arr_discount_show_start_date = array('none');

$arr_discount_show_end_date = array('none');

$arr_discount_show_price_label = array('none');

$arr_discount_show_price_value = array('none');

$arr_discount_show_date = array('none');



$show_for_complementry = 'none';





$cgst_tax_cat_id = '232';

$sgst_tax_cat_id = '233';

$cess_tax_cat_id = '234';

$gst_tax_cat_id = '231';



$cgst_tax = '';

$sgst_tax = '';

$cess_tax = '';

$gst_tax = '';



$currency_id = '';

$cusine_desc_show_1 = '';

$cusine_desc_show_2 = '';

$str='cucat';

$add_more_row_cat_str = '<div class="form-group" id="row_cat_\'+cat_cnt+\'"><label class="col-lg-2 control-label"></label><div class="col-lg-3"><select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_\'+cat_cnt+\'" onchange="getMainCategoryOptionAddMoreCommon(\'+cat_cnt+\')" class="form-control" required>'.$obj->getMainProfileOption('').'</select></div><div class="col-lg-3"><select name="cucat_cat_id[]" id="cucat_cat_id_\'+cat_cnt+\'" class="form-control" required>'.$obj->getMainCategoryOption('','').'</select></div><div class="col-lg-2"><select name="cucat_show[]" id="cucat_show_\'+cat_cnt+\'" class="form-control" required>'.$obj->getShowHideOption('').'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>';

$add_more_row_cw_str = '<div class="form-group" id="row_cw_\'+cw_cnt+\'"><div class="col-lg-3"><input type="hidden" name="cw_qt_parent_cat_id[]" id="cw_qt_parent_cat_id_\'+cw_cnt+\'" value="'.$cw_qt_parent_cat_id.'"><select name="cw_qt_cat_id[]" id="cw_qt_cat_id_\'+cw_cnt+\'" class="form-control">'.$obj->getMainCategoryOption($cw_qt_parent_cat_id,'').'</select></div><div class="col-lg-3"><input type="hidden" name="cw_qu_parent_cat_id[]" id="cw_qu_parent_cat_id_\'+cw_cnt+\'" value="'.$cw_qu_parent_cat_id.'"><select name="cw_qu_cat_id[]" id="cw_qu_cat_id_\'+cw_cnt+\'" class="form-control">'.$obj->getMainCategoryOption($cw_qu_parent_cat_id,'').'</select></div><div class="col-lg-2"><input type="text" name="cw_quantity[]" id="cw_quantity_\'+cw_cnt+\'" class="form-control" value=""></div><div class="col-lg-2"><select name="cw_show[]" id="cw_show_\'+cw_cnt+\'" class="form-control">'.$obj->getShowHideOption('').'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowWeight(\'+cw_cnt+\');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>';



$event_data = $obj->GETEVENTDETAILSBYID(base64_decode($_GET['event_id']));



//echo '<pre>';

//print_r($event_data);

//echo '</pre>';





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

		<div class="col-sm-12">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

                                            <div id="show_data"></div>

					</div>

					<hr>

					<center><div id="error_msg"></div></center>

					<form role="form" class="form-horizontal" id="add_event" name="add_event" method="post" > 

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

						<input type="hidden" name="loc_cnt" id="loc_cnt" value="<?php echo $loc_cnt;?>">

						<input type="hidden" name="loc_total_cnt" id="loc_total_cnt" value="<?php echo $loc_total_cnt;?>">

						<input type="hidden" name="cw_cnt" id="cw_cnt" value="<?php echo $cw_cnt;?>">

						<input type="hidden" name="cw_total_cnt" id="cw_total_cnt" value="<?php echo $cw_total_cnt;?>">

                                                <input type="hidden" name="hdnevent_id" id="hdnevent_id" value="<?php echo base64_decode($_GET['event_id']);?>">

						<div class="form-group">

                                                        <label class="col-lg-2 control-label"><b>Event Name :</b></label>

							<label class="col-lg-2 control-label"><?php echo $event_data['event_name']; ?></label>

							<label class="col-lg-2 control-label"><b>Event Ref No :</b></label>

							<label class="col-lg-2 control-label"><?php echo $event_data['reference_number']; ?></label>

                                                        <label class="col-lg-2 control-label"><b>Organiser Name :</b></label>

							<label class="col-lg-2 control-label"><?php echo $obj->getVendorName($event_data['organiser_id']); ?></label>

						</div>

						<div class="form-group">

							<label class="col-lg-2 control-label"><b>Institution Name :</b></label>

							<label class="col-lg-2 control-label"><?php echo $obj->getVendorName($event_data['institution_id']); ?></label>

							<label class="col-lg-2 control-label"><b>City  :</b></label>

							<label class="col-lg-2 control-label"><?php echo $obj->GetCityName($event_data['city_id']); ?></label>

                                                        <label class="col-lg-2 control-label"><b>Venue Details :</b></label>

							<label class="col-lg-2 control-label"><?php echo $event_data['venue_details']; ?></label>

						</div>

						<div class="form-group">

							<label class="col-lg-2 control-label"><b>Start Date/Time :</b></label>

							<label class="col-lg-2 control-label"><?php echo date("d-m-Y",strtotime($event_data['start_date'])).' '.$event_data['start_time']; ?></label>

							<label class="col-lg-2 control-label"><b>End Date/Time :</b></label>

							<label class="col-lg-2 control-label"><?php echo date("d-m-Y",strtotime($event_data['end_date'])).' '.$event_data['end_time']; ?></label>

                                                        

						</div>

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-4 control-label"><strong>Inventory and Price Details:</strong></label>

							</div>

						<?php 

						for($i=0;$i<$loc_total_cnt;$i++)

						{ ?>

							<div id="row_loc_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

								

								<div class="form-group">

									<label class="col-lg-2 control-label">Registration Type<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="registration_type_id[]" id="registration_type_id_<?php echo $i;?>" class="form-control" required>

											<?php echo $obj->getFavCategoryRamakant('67',''); ?>

										</select>

									</div>

								

									<label class="col-lg-2 control-label">Registration Currency <span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="reg_currency_id[]" id="reg_currency_id_<?php echo $i;?>" class="form-control" required>

											<?php echo $obj->getCurrencyOption($arr_currency_id[$i]); ?>

										</select>

									</div>

									

									<label class="col-lg-2 control-label">Registration Fees<span style="color:red">*</span></label>

									<div class="col-lg-2">

                                                                                <input type="text" name="registration_fees[]" id="registration_fees_<?php echo $i;?>" placeholder="Registration Fees" value="<?php echo $arr_reg_fees[$i];?>" class="form-control" required>										

									</div>

								</div>

                                                            

                                                                <div class="form-group">

									<label class="col-lg-2 control-label">Registration Criteria<span style="color:red">*</span></label>

									<div class="col-lg-6">

                                                                            <textarea required="" class="form-control" name="registration_criteria[]" id="registration_criteria_<?php echo $i;?>"></textarea>

									</div>

                                                                        <label class="col-lg-2 control-label">Show Registration<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="registration_show[]" id="registration_show_<?php echo $i;?>" class="form-control" required>

											<?php echo $obj->getShowHideOption($arr_registration_show[$i]); ?>

										</select>

									</div>

								</div>

                                                            

                                                                <div class="form-group">

									<label class="col-lg-2 control-label">Ticket Type<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="ordering_type_id[]" id="ordering_type_id_<?php echo $i;?>" class="form-control" required>

											<?php echo $obj->getFavCategoryRamakant('66',''); ?>

										</select>

									</div>

                                                                        <label class="col-lg-2 control-label">Ticket Name<span style="color:red">*</span></label>

                                                                        <div class="col-lg-2">

                                                                                <input type="text" name="ticket_name[]" id="ticket_name<?php echo $i;?>" placeholder="Ticket Name" value="<?php echo $arr_ticket_name[$i];?>" class="form-control" required>										

									</div>

								

<!--									<label class="col-lg-2 control-label">Ordering Size<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="ordering_size_id[]" id="ordering_size_id_<?php echo $i;?>" class="form-control" required>

											<?php //echo $obj->getServingSizeOption($arr_ordering_size_id[$i]); ?>

										</select>

									</div>

                                                                        <br><br>

									<label class="col-lg-2 control-label">Show Ordering Size<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="ordering_size_show[]" id="ordering_size_show_<?php echo $i;?>" class="form-control" required>

											<?php //echo $obj->getShowHideOption($arr_ordering_size_show[$i]); ?>

										</select>

									</div>-->

								</div>

								

								<div class="form-group">

                                                                        <label class="col-lg-2 control-label">Bulk booking allowed?<span style="color:red">*</span></label>

									<div class="col-lg-2">

                                                                            <select name="is_bulk_booking[]" id="is_bulk_booking_<?php echo $i?>" class="form-control" required="">

											<?php echo $obj->getYesNoOption($arr_is_offer[$i]); ?>

										</select>

									</div>

									<label class="col-lg-2 control-label">Max Order Quantity<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<input type="text" name="max_order[]" id="max_order_<?php echo $i;?>" placeholder="Max Order Quantity" value="<?php echo $arr_max_order[$i];?>" class="form-control" required>

									</div>

								

									<label class="col-lg-2 control-label">Min Order Quantity<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<input type="text" name="min_order[]" id="min_order_<?php echo $i;?>" placeholder="Min Order Quantity" value="<?php echo $arr_min_order[$i];?>" class="form-control" required>

									</div>

								</div>

								

								<div class="form-group">

									<label class="col-lg-2 control-label">Current Stock<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<input type="text" name="cusine_qty[]" id="cusine_qty_<?php echo $i;?>" placeholder="Total Stock Quantity" value="<?php echo $arr_cusine_qty[$i];?>" class="form-control" required>

									</div>

								

									<label class="col-lg-2 control-label">Show Current Stock<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="cusine_qty_show[]" id="cusine_qty_show_<?php echo $i;?>" class="form-control" required>

											<?php echo $obj->getShowHideOption($arr_cusine_qty_show[$i]); ?>

										</select>

									</div>

									

									<label class="col-lg-2 control-label">Show Sold Quantity<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="sold_qty_show[]" id="sold_qty_show_<?php echo $i;?>" class="form-control" required>

											<?php echo $obj->getShowHideOption($arr_sold_qty_show[$i]); ?>

										</select>

									</div>

								</div>

								

								<div class="form-group">

									<label class="col-lg-2 control-label">Currency<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="currency_id[]" id="currency_id_<?php echo $i?>" class="form-control" required>

											<?php echo $obj->getCurrencyOption($arr_currency_id[$i]); ?>

										</select>

									</div>

									

									<label class="col-lg-2 control-label">Price<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<input type="text" name="ticket_price[]" id="ticket_price_<?php echo $i;?>" placeholder="Price" value="<?php echo $arr_cusine_price[$i];?>" class="form-control" required>

									</div>

									

									<label class="col-lg-2 control-label">Default Price<span style="color:red">*</span></label>

									<div class="col-lg-2">

										<select name="default_price[]" id="default_price_<?php echo $i;?>" class="form-control" required>

											<?php echo $obj->getDefaultPriceOption($arr_default_price[$i]); ?>

										</select>

									</div>

								</div>

								<div class="form-group">

									<label class="col-lg-2 control-label">Is Offer Item?</label>

									<div class="col-lg-2">

										<select name="is_offer[]" id="is_offer_<?php echo $i?>" class="form-control" onchange="toggleOfferDetails('<?php echo $i;?>')">

											<?php echo $obj->getYesNoOption($arr_is_offer[$i]); ?>

										</select>

									</div>

									

									<label class="col-lg-2 control-label" id="offer_show_price_label_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_price_label[$i];?>">Offer Price<span style="color:red">*</span></label>

									<div class="col-lg-2" id="offer_show_price_value_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_price_value[$i];?>">

										<input type="text" name="offer_price[]" id="offer_price_<?php echo $i;?>" placeholder="Offer Price" value="<?php echo $arr_offer_price[$i];?>" class="form-control">

									</div>

								</div>

								<div class="form-group" id="offer_show_date_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_date[$i];?>">

									<label class="col-lg-2 control-label">Offer Date<span style="color:red">*</span></label>

									<div class="col-lg-4">

										<select name="offer_date_type[]" id="offer_date_type_<?php echo $i;?>" onchange="showHideDateDropdownsMulti('offer','<?php echo $i;?>')" class="form-control">

											<?php echo $obj->getDateTypeOption($arr_offer_date_type[$i]); ?>

										</select>

									</div>

									<div class="col-lg-3">

										<div id="offer_show_days_of_month_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_days_of_month[$i];?>">

											<input type="hidden" name="offer_days_of_month_str[]" id="offer_days_of_month_str_<?php echo $i;?>" value="<?php echo $arr_offer_days_of_month_str[$i];?>">

											<select name="offer_days_of_month[]" id="offer_days_of_month_<?php echo $i;?>" onchange="setDaysOfMonthStrMulti('<?php echo $i;?>')" multiple="multiple" class="form-control">

												<?php echo $obj->getDaysOfMonthOption($arr_offer_days_of_month[$i],'2','1'); ?>

											</select>

										</div>	

										<div id="offer_show_days_of_week_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_days_of_week[$i];?>">

											<input type="hidden" name="offer_days_of_week_str[]" id="offer_days_of_week_str_<?php echo $i;?>" value="<?php echo $arr_offer_days_of_week_str[$i];?>">

											<select name="offer_days_of_week[]" id="offer_days_of_week_<?php echo $i;?>" onchange="setDaysOfWeekStrMulti('<?php echo $i;?>')" multiple="multiple" class="form-control" >

												<?php echo $obj->getDaysOfWeekOption($arr_offer_days_of_week[$i],'2','1'); ?>

											</select>

										</div>	

										<div id="offer_show_single_date_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_single_date[$i];?>">

											<input type="text" name="offer_single_date[]" id="offer_single_date_<?php echo $i;?>" value="<?php echo $arr_offer_single_date[$i];?>" placeholder="Select Date" class="form-control clsdatepicker" >

										</div>	

										<div id="offer_show_start_date_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_start_date[$i];?>">

											<input type="text" name="offer_start_date[]" id="offer_start_date_<?php echo $i;?>" value="<?php echo $arr_offer_start_date[$i];?>" placeholder="Select Start Date" class="form-control clsdatepicker">  

										</div>	

									</div>

									<div class="col-lg-3">

										<div id="offer_show_end_date_<?php echo $i;?>" style="display:<?php echo $arr_offer_show_end_date[$i];?>">

											<input type="text" name="offer_end_date[]" id="offer_end_date_<?php echo $i;?>" value="<?php echo $arr_offer_end_date[$i];?>" placeholder="Select End Date" class="form-control clsdatepicker"> 

										</div>	

									</div>

								</div>

                                                            

                                                                <div class="form-group">

									<label class="col-lg-2 control-label">Is Discount Available?</label>

									<div class="col-lg-2">

										<select name="is_discount[]" id="is_discount_<?php echo $i?>" class="form-control" onchange="toggleDiscountDetails('<?php echo $i;?>')">

											<?php echo $obj->getYesNoOption($arr_is_discount[$i]); ?>

										</select>

									</div>

									

									<label class="col-lg-2 control-label" id="offer_show_price_label_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_price_label[$i];?>">Discount Code<span style="color:red">*</span></label>

									<div class="col-lg-4" id="discount_show_price_value_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_price_value[$i];?>">

										

                                                                                <select name="discount_code[]" id="discount_code_<?php echo $i?>" class="form-control" >

                                                                                    <option value="">Select Discount Code</option>    

                                                                                    <?php echo $obj->getCouponOptions($arr_discount_code[$i]); ?>

										</select>

									</div>

								</div>

								<div class="form-group" id="discount_show_date_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_date[$i];?>">

									<label class="col-lg-2 control-label">Discount Date<span style="color:red">*</span></label>

									<div class="col-lg-4">

										<select name="discount_date_type[]" id="discount_date_type_<?php echo $i;?>" onchange="showHideDateDropdownsMulti('discount','<?php echo $i;?>')" class="form-control">

											<?php echo $obj->getDateTypeOption($arr_discount_date_type[$i]); ?>

										</select>

									</div>

									<div class="col-lg-3">

										<div id="discount_show_days_of_month_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_days_of_month[$i];?>">

											<input type="hidden" name="discount_days_of_month_str[]" id="discount_days_of_month_str_<?php echo $i;?>" value="<?php echo $arr_discount_days_of_month_str[$i];?>">

											<select name="discount_days_of_month[]" id="discount_days_of_month_<?php echo $i;?>" onchange="setDaysOfMonthStrMulti('<?php echo $i;?>')" multiple="multiple" class="form-control">

												<?php echo $obj->getDaysOfMonthOption($arr_discount_days_of_month[$i],'2','1'); ?>

											</select>

										</div>	

										<div id="discount_show_days_of_week_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_days_of_week[$i];?>">

											<input type="hidden" name="discount_days_of_week_str[]" id="discount_days_of_week_str_<?php echo $i;?>" value="<?php echo $arr_discount_days_of_week_str[$i];?>">

											<select name="discount_days_of_week[]" id="discount_days_of_week_<?php echo $i;?>" onchange="setDaysOfWeekStrMulti('<?php echo $i;?>')" multiple="multiple" class="form-control" >

												<?php echo $obj->getDaysOfWeekOption($arr_discount_days_of_week[$i],'2','1'); ?>

											</select>

										</div>	

										<div id="discount_show_single_date_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_single_date[$i];?>">

											<input type="text" name="discount_single_date[]" id="offer_single_date_<?php echo $i;?>" value="<?php echo $arr_discount_single_date[$i];?>" placeholder="Select Date" class="form-control clsdatepicker" >

										</div>	

										<div id="discount_show_start_date_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_start_date[$i];?>">

											<input type="text" name="discount_start_date[]" id="discount_start_date_<?php echo $i;?>" value="<?php echo $arr_discount_start_date[$i];?>" placeholder="Select Start Date" class="form-control clsdatepicker">  

										</div>	

									</div>

									<div class="col-lg-3">

										<div id="discount_show_end_date_<?php echo $i;?>" style="display:<?php echo $arr_discount_show_end_date[$i];?>">

											<input type="text" name="discount_end_date[]" id="offer_end_date_<?php echo $i;?>" value="<?php echo $arr_discount_end_date[$i];?>" placeholder="Select End Date" class="form-control clsdatepicker"> 

										</div>	

									</div>

								</div>

								

								<div class="form-group">

									<div class="col-lg-2">

						<!-- 			<?php

									if($i == 0)

									{ ?>

										<a href="javascript:void(0);" onclick="addMoreRowLocation();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

									<?php  	

									}

									else

									{ ?>

										<a href="javascript:void(0);" onclick="removeRowLocation(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

									<?php	

									}

									?>	 -->

									</div>

								</div>

							</div>

						<?php 

						} ?>

							<button type="button" data-toggle="popover" data-placement="right" data-content="Available after submit event price" class="btn btn-success rounded">ADD More Pricing details</button> 

						</div>		

						

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-4 control-label"><strong>Category Details:</strong></label>

							</div>	

						<?php

						for($i=0;$i<$cat_total_cnt;$i++)

						{ ?>

							<div class="form-group" id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">

								<label class="col-lg-2 control-label"><?php if($i == 0) { ?><strong>Category</strong><span style="color:red">*</span><?php } ?></label>

							

								<div class="col-lg-3">

									<select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMoreCommon('cucat',<?php echo $i;?>);" class="form-control">

										<?php echo $obj->getMainProfileOption($arr_cucat_parent_cat_id[$i]); ?>

									</select>

								</div>

								<div class="col-lg-3">

									<select name="cucat_cat_id[]" id="cucat_cat_id_<?php echo $i;?>" class="form-control" >

										<?php echo $obj->getMainCategoryOption($arr_cucat_parent_cat_id[$i],$arr_cucat_cat_id[$i]); ?>

									</select>

								</div>

								<div class="col-lg-2">

									<select name="cucat_show[]" id="cucat_show_<?php echo $i;?>" class="form-control" >

										<?php echo $obj->getShowHideOption($arr_cucat_show[$i]); ?>

									</select>

								</div>

								<div class="col-lg-2">

								<?php

								if($i == 0)

								{ ?>

									<a href="javascript:void(0);" onclick="addMoreRowCategory();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

								<?php  	

								}

								else

								{ ?>

									<a href="javascript:void(0);" onclick="removeRowCategory(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

								<?php	

								}

								?>	

								</div>

							</div>

						<?php  	

						} ?>	

						</div>	

						

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-4 control-label"><strong>Publish and Delivery Date Details:</strong></label>

							</div>	

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>Date of Publish</strong><span style="color:red">*</span></label>

							

								<div class="col-lg-4">

									<select name="publish_date_type" id="publish_date_type" onchange="showHideDateDropdowns('publish')" class="form-control" required>

										<?php echo $obj->getDateTypeOption($publish_date_type); ?>

									</select>

								</div>

								<div class="col-lg-3">

									<div id="publish_show_days_of_month" style="display:<?php echo $publish_show_days_of_month;?>">

										<select name="publish_days_of_month" id="publish_days_of_month" multiple="multiple" class="form-control" required >

											<?php echo $obj->getDaysOfMonthOption($arr_publish_days_of_month,'2','1'); ?>

										</select>

									</div>	

									<div id="publish_show_days_of_week" style="display:<?php echo $publish_show_days_of_week;?>">

										<select name="publish_days_of_week" id="publish_days_of_week" multiple="multiple" class="form-control" required >

											<?php echo $obj->getDaysOfWeekOption($arr_publish_days_of_week,'2','1'); ?>

										</select>

									</div>	

									<div id="publish_show_single_date" style="display:<?php echo $publish_show_single_date;?>">

										<input type="text" name="publish_single_date" id="publish_single_date" placeholder="Select Date" class="form-control" required >

									</div>	

									<div id="publish_show_start_date" style="display:<?php echo $publish_show_start_date;?>">

										<input type="text" name="publish_start_date" id="publish_start_date" placeholder="Select Start Date" class="form-control" required >  

									</div>	

								</div>

								<div class="col-lg-3">

									<div id="publish_show_end_date" style="display:<?php echo $publish_show_end_date;?>">

										<input type="text" name="publish_end_date" id="publish_end_date" placeholder="Select End Date" class="form-control" required > 

									</div>	

								</div>

							</div>

							<div class="form-group">	

								<label class="col-lg-2 control-label"><strong>Registration Cut Off Time</strong><span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="registration_cutoff_time" id="registration_cutoff_time" class="form-control" required>

										<?php echo $obj->getCancellationCutOffTimeOption($cancel_cutoff_time); ?>

									</select><span>Base Time:  EVENT start time</span><br>

								</div>

                                                                <label class="col-lg-2 control-label"><strong>Show Registration Time</strong></label>

								<div class="col-lg-4">

                                                                    <select name="registration_time_show" id="registration_time_show" class="form-control" required="">

										<?php echo $obj->getShowHideOption($registration_time_show); ?>

									</select>

								</div>

								

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>Cancellation Cut Off Time</strong></label>

								<div class="col-lg-4">

									<select name="cancel_cutoff_time" id="cancel_cutoff_time" class="form-control" required>

										<?php echo $obj->getCancellationCutOffTimeOption($cancel_cutoff_time); ?>

									</select><span>Base Time:  EVENT start time </span><br>

								</div>

								

								<label class="col-lg-2 control-label"><strong>Show Cancellation Cut Off Time</strong></label>

								<div class="col-lg-4">

                                                                    <select name="cancel_cutoff_time_show" id="cancel_cutoff_time_show" class="form-control" required="">

										<?php echo $obj->getShowHideOption($cancel_cutoff_time_show); ?>

									</select>

								</div>

							</div>							

						</div>	

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Tax Details(GST/CGST/SGST/CESS):</strong></label>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>CGST Tax</strong></label>

								<div class="col-lg-4">

									<select name="cgst_tax" id="cgst_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($cgst_tax_cat_id,$cgst_tax); ?>

									</select>

								</div>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>SGST Tax</strong></label>

								<div class="col-lg-4">

									<select name="sgst_tax" id="sgst_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($sgst_tax_cat_id,$sgst_tax); ?>

									</select>

								</div>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>CESS Tax</strong></label>

								<div class="col-lg-4">

									<select name="cess_tax" id="cess_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($cess_tax_cat_id,$cess_tax); ?>

									</select>

								</div>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>GST Tax</strong></label>

								<div class="col-lg-4">

									<select name="gst_tax" id="gst_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($gst_tax_cat_id,$gst_tax); ?>

									</select>

								</div>

							</div>

						</div>	

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Other Details:</strong></label>

							</div>

							<div class="form-group"><label class="col-lg-2 control-label"><strong>Event Description 1</strong></label>

								<div class="col-lg-8">

									<textarea id="cusine_desc_1" name="cusine_desc_1" class="form-control"></textarea>

								</div>

								<div class="col-lg-2">

									<select name="cusine_desc_show_1" id="cusine_desc_show_1" class="form-control">

										<?php echo $obj->getShowHideOption($cusine_desc_show_1); ?>

									</select>

								</div>

							</div>

							

							<div class="form-group"><label class="col-lg-2 control-label"><strong>Event Description 2</strong></label>

								<div class="col-lg-8">

									<textarea id="cusine_desc_2" name="cusine_desc_2" class="form-control"></textarea>

								</div>

								<div class="col-lg-2">

									<select name="cusine_desc_show_2" id="cusine_desc_show_2" class="form-control">

										<?php echo $obj->getShowHideOption($cusine_desc_show_2); ?>

									</select>

								</div>

							</div>

						</div>	

						<hr>

						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>



									<a href="manage_cusines.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>



									<img border="0" class="image_load" src="<?php echo SITE_URL.'/images/loading.gif'?>" style="width: 6%; display: none; float: right; margin-right:75%;">

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

<script src="js/tokenize2.js"></script>

<script src="admin-js/add_event_price.js" type="text/javascript"></script>

<script>

$(document).ready(function()

{ 

	$('.clsdatepicker').datepicker();

	

	function getVendorOptionByItemId()

	{

		var item_id = $('#item_id').val();

		var vendor_id = $('#vendor_id').val();

		

		if(item_id == null)

		{

			item_id = '';

		}

		

		if(vendor_id == null)

		{

			vendor_id = '';

		}

		

		

		var dataString ='item_id='+item_id+'&vendor_id='+vendor_id+'&type=1&multiple=0&action=getvendoroptionbyitemid';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				//alert(result);

				$("#vendor_id").html(result);

				getVendorLocationOption();

			}

		});

	}



	$('#item_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Item'

	});

	

	$('#item_id').on('tokenize:tokens:add', getVendorOptionByItemId);

	$('#item_id').on('tokenize:tokens:remove', getVendorOptionByItemId);

	

	$('#publish_single_date').datepicker();

	$('#publish_start_date').datepicker();

	$('#publish_end_date').datepicker();

	

	$('#delivery_single_date').datepicker();

	$('#delivery_start_date').datepicker();

	$('#delivery_end_date').datepicker();

	

});



function addMoreRowLocation()

{

	

	var loc_cnt = parseInt($("#loc_cnt").val());

	loc_cnt = loc_cnt + 1;

	

	var new_row = 	'<div id="row_loc_'+loc_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

						

                                                        '<div class="form-group">'+

                                                                '<label class="col-lg-2 control-label">Registration Type<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<select name="registration_type_id[]" id="registration_type_id_'+loc_cnt+'" class="form-control" required>'+

                                                                                '<?php echo $obj->getFavCategoryRamakant('67',''); ?>'+

                                                                        '</select>'+

                                                                '</div>'+



                                                                '<label class="col-lg-2 control-label">Registration Currency <span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<select name="reg_currency_id[]" id="reg_currency_id_'+loc_cnt+'" class="form-control" required>'+

                                                                                '<?php echo $obj->getCurrencyOption(''); ?>'+

                                                                        '</select>'+

                                                                '</div>'+



                                                                '<label class="col-lg-2 control-label">Registration Fees<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<input type="text" name="registration_fees[]" id="registration_fees_'+loc_cnt+'" placeholder="Registration Fees" value="" class="form-control" required>'+										

                                                                '</div>'+

                                                        '</div>'+

                                                        '<div class="form-group">'+

                                                                '<label class="col-lg-2 control-label">Registration Criteria<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-6">'+

                                                                    '<textarea class="form-control" name="registration_criteria[]" id="registration_criteria_'+loc_cnt+'"></textarea>'+

                                                                '</div>'+

                                                                '<label class="col-lg-2 control-label">Show Registration<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<select name="registration_show[]" id="registration_show_'+loc_cnt+'" class="form-control" required>'+

                                                                                '<?php echo $obj->getShowHideOption(''); ?>'+

                                                                        '</select>'+

                                                                '</div>'+

                                                        '</div>'+

                                                

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Ticket Type<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="ordering_type_id[]" id="ordering_type_id_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getFavCategoryRamakant('66',''); ?>'+

								'</select>'+

							'</div>'+

						

                                                         '<label class="col-lg-2 control-label">Ticket Name<span style="color:red">*</span></label>'+

                                                                        '<div class="col-lg-2">'+

                                                                                '<input type="text" name="ticket_name[]" id="ticket_name_'+loc_cnt+'" placeholder="Registration Fees"  class="form-control">'+										

									'</div>'+

                                                

						'</div>'+

						

						'<div class="form-group">'+

                                                

                                                        '<label class="col-lg-2 control-label">Bulk booking allowed?<span style="color:red">*</span></label>'+

                                                            '<div class="col-lg-2">'+

                                                                    '<select name="is_bulk_booking[]" id="is_bulk_booking_'+loc_cnt+'" class="form-control">'+

                                                                            '<?php echo $obj->getYesNoOption(''); ?>'+

                                                                    '</select>'+

                                                            '</div>'+

                                                        

							'<label class="col-lg-2 control-label">Max Order Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="max_order[]" id="max_order_'+loc_cnt+'" placeholder="Max Order Quantity" value="" class="form-control" required>'+

							'</div>'+

						

							'<label class="col-lg-2 control-label">Min Order Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="min_order[]" id="min_order_'+loc_cnt+'" placeholder="Min Order Quantity" value="" class="form-control" required>'+

							'</div>'+

						'</div>'+

						

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Total Stock Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="cusine_qty[]" id="cusine_qty_'+loc_cnt+'" placeholder="Total Stock Quantity" value="" class="form-control" required>'+

							'</div>'+

						

							'<label class="col-lg-2 control-label">Show Current Stock<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="cusine_qty_show[]" id="cusine_qty_show_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getShowHideOption(''); ?>'+

								'</select>'+

							'</div>'+

							

							'<label class="col-lg-2 control-label">Show Sold Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="sold_qty_show[]" id="sold_qty_show_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getShowHideOption(''); ?>'+

								'</select>'+

							'</div>'+

						'</div>'+

						

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Currency<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="currency_id[]" id="currency_id_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getCurrencyOption(''); ?>'+

								'</select>'+

							'</div>'+

							

							'<label class="col-lg-2 control-label">Price<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="ticket_price[]" id="ticket_price_'+loc_cnt+'" placeholder="Price" value="" class="form-control" required>'+

							'</div>'+

							

							'<label class="col-lg-2 control-label">Default Price<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="default_price[]" id="default_price_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getDefaultPriceOption(''); ?>'+

								'</select>'+

							'</div>'+

						'</div>'+

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Is Offer Item?</label>'+

							'<div class="col-lg-2">'+

								'<select name="is_offer[]" id="is_offer_'+loc_cnt+'" class="form-control" onchange="toggleOfferDetails(\''+loc_cnt+'\')">'+

									'<?php echo $obj->getYesNoOption(''); ?>'+

								'</select>'+

							'</div>'+

							'<label class="col-lg-2 control-label" id="offer_show_price_label_'+loc_cnt+'" style="display:none;">Offer Price<span style="color:red">*</span></label>'+

							'<div class="col-lg-2" id="offer_show_price_value_'+loc_cnt+'" style="display:none;">'+

								'<input type="text" name="offer_price[]" id="offer_price_'+loc_cnt+'" placeholder="Offer Price" value="" class="form-control">'+

							'</div>'+

						'</div>'+

						'<div class="form-group" id="offer_show_date_'+loc_cnt+'" style="display:none;">'+

							'<label class="col-lg-2 control-label">Offer Date<span style="color:red">*</span></label>'+

							'<div class="col-lg-4">'+

								'<select name="offer_date_type[]" id="offer_date_type_'+loc_cnt+'" onchange="showHideDateDropdownsMulti(\'offer\',\''+loc_cnt+'\')" class="form-control">'+

									'<?php echo $obj->getDateTypeOption(''); ?>'+

								'</select>'+

							'</div>'+

							'<div class="col-lg-3">'+

								'<div id="offer_show_days_of_month_'+loc_cnt+'" style="display:none">'+

									'<input type="hidden" name="offer_days_of_month_str[]" id="offer_days_of_month_str_'+loc_cnt+'" value="">'+

									'<select name="offer_days_of_month[]" id="offer_days_of_month_'+loc_cnt+'" onchange="setDaysOfMonthStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control">'+

										'<?php echo $obj->getDaysOfMonthOption(array('-1'),'2','1'); ?>'+

									'</select>'+

								'</div>'+	

								'<div id="offer_show_days_of_week_'+loc_cnt+'" style="display:none;">'+

									'<input type="hidden" name="offer_days_of_week_str[]" id="offer_days_of_week_str_'+loc_cnt+'" value="">'+

									'<select name="offer_days_of_week[]" id="offer_days_of_week_'+loc_cnt+'" onchange="setDaysOfWeekStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control" >'+

										'<?php echo $obj->getDaysOfWeekOption(array('-1'),'2','1'); ?>'+

									'</select>'+

								'</div>	'+

								'<div id="offer_show_single_date_'+loc_cnt+'" style="display:none;">'+

									'<input type="text" name="offer_single_date[]" id="offer_single_date_'+loc_cnt+'" value="" placeholder="Select Date" class="form-control clsdatepicker" >'+

								'</div>'+	

								'<div id="offer_show_start_date_'+loc_cnt+'" style="display:none;">'+

									'<input type="text" name="offer_start_date[]" id="offer_start_date_'+loc_cnt+'" value="" placeholder="Select Start Date" class="form-control clsdatepicker">'+  

								'</div>'+	

							'</div>'+

							'<div class="col-lg-3">'+

								'<div id="offer_show_end_date_'+loc_cnt+'" style="display:none;">'+

									'<input type="text" name="offer_end_date[]" id="offer_end_date_'+loc_cnt+'" value="" placeholder="Select End Date" class="form-control clsdatepicker">'+ 

								'</div>'+	

							'</div>'+

						'</div>'+

                                                

                                                '<div class="form-group">'+

                                                        '<label class="col-lg-2 control-label">Is Discount Available?</label>'+

                                                        '<div class="col-lg-2">'+

                                                                '<select name="is_discount[]" id="is_discount_'+loc_cnt+'" class="form-control" onchange="toggleDiscountDetails(\''+loc_cnt+'\')">'+

                                                                        '<?php echo $obj->getYesNoOption(''); ?>'+

                                                                '</select>'+

                                                        '</div>'+



                                                        '<label class="col-lg-2 control-label" id="offer_show_price_label_'+loc_cnt+'" style="display:none;">Discount Code<span style="color:red">*</span></label>'+

                                                        '<div class="col-lg-4" id="discount_show_price_value_'+loc_cnt+'" style="display:none">'+



                                                                '<select name="discount_code[]" id="discount_code_'+loc_cnt+'" class="form-control" >'+

                                                                    '<option value="">Select Discount Code</option>'+   

                                                                    '<?php echo $obj->getCouponOptions(''); ?>'+

                                                                '</select>'+

                                                        '</div>'+

                                                '</div>'+

                                                

                                                

                                                '<div class="form-group" id="discount_show_date_'+loc_cnt+'" style="display:none;">'+

                                                        '<label class="col-lg-2 control-label">Discount Date<span style="color:red">*</span></label>'+

                                                        '<div class="col-lg-4">'+

                                                                '<select name="discount_date_type[]" id="discount_date_type_'+loc_cnt+'" onchange="showHideDateDropdownsMulti(\'discount\',\''+loc_cnt+'\')" class="form-control">'+

                                                                        '<?php echo $obj->getDateTypeOption(''); ?>'+

                                                                '</select>'+

                                                        '</div>'+

                                                        '<div class="col-lg-3">'+

                                                                '<div id="discount_show_days_of_month_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="hidden" name="discount_days_of_month_str[]" id="discount_days_of_month_str_'+loc_cnt+'" >'+

                                                                        '<select name="discount_days_of_month[]" id="discount_days_of_month_'+loc_cnt+'" onchange="setDaysOfMonthStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control">'+

                                                                               '<?php echo $obj->getDaysOfMonthOption(array('-1'),'2','1'); ?>'+

                                                                        '</select>'+

                                                                '</div>'+

                                                                '<div id="discount_show_days_of_week_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="hidden" name="discount_days_of_week_str[]" id="discount_days_of_week_str_'+loc_cnt+'" >'+

                                                                        '<select name="discount_days_of_week[]" id="discount_days_of_week_'+loc_cnt+'" onchange="setDaysOfWeekStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control" >'+

                                                                                '<?php echo $obj->getDaysOfWeekOption(array('-1'),'2','1'); ?>'+

                                                                        '</select>'+

                                                                '</div>'+

                                                                '<div id="discount_show_single_date_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="text" name="discount_single_date[]" id="offer_single_date_'+loc_cnt+'" placeholder="Select Date" class="form-control clsdatepicker" >'+

                                                                '</div>'+	

                                                                '<div id="discount_show_start_date_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="text" name="discount_start_date[]" id="discount_start_date_'+loc_cnt+'"  placeholder="Select Start Date" class="form-control clsdatepicker">'+ 

                                                                '</div>'+	

                                                        '</div>'+

                                                        '<div class="col-lg-3">'+

                                                                '<div id="discount_show_end_date_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="text" name="discount_end_date[]" id="offer_end_date_'+loc_cnt+'"  placeholder="Select End Date" class="form-control clsdatepicker">'+

                                                                '</div>'+	

                                                        '</div>'+

                                                '</div>'+

                                                

                                                

						'<div class="form-group">'+

							'<div class="col-lg-2">'+

								'<a href="javascript:void(0);" onclick="removeRowLocation('+loc_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

							'</div>'+

						'</div>'+

					'</div>';	

	

	$("#row_loc_first").after(new_row);

	getVendorLocationOption('1','0','0','vloc_id_'+loc_cnt);

	

	$("#loc_cnt").val(loc_cnt);

	

	var loc_total_cnt = parseInt($("#loc_total_cnt").val());

	loc_total_cnt = loc_total_cnt + 1;

	$("#loc_total_cnt").val(loc_total_cnt);

	

	$('.clsdatepicker').datepicker();

}



function removeRowLocation(idval)

{

	$("#row_loc_"+idval).remove();



	var loc_total_cnt = parseInt($("#loc_total_cnt").val());

	loc_total_cnt = loc_total_cnt - 1;

	$("#loc_total_cnt").val(loc_total_cnt);

}



function addMoreRowCategory()

{

	var cat_cnt = parseInt($("#cat_cnt").val());

	cat_cnt = cat_cnt + 1;

	//alert("cat_cnt"+cat_cnt);

	$("#row_cat_first").after('<div class="form-group" id="row_cat_'+cat_cnt+'"><label class="col-lg-2 control-label"></label><div class="col-lg-3"><select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_'+cat_cnt+'" onchange="getMainCategoryOptionAddMoreCommon(\'cucat\','+cat_cnt+')" class="form-control" required>'+'<?php echo $obj->getMainProfileOption(''); ?>'+'</select></div><div class="col-lg-3"><select name="cucat_cat_id[]" id="cucat_cat_id_'+cat_cnt+'" class="form-control" required>'+'<?php echo $obj->getMainCategoryOption('',''); ?>'+'</select></div><div class="col-lg-2"><select name="cucat_show[]" id="cucat_show_'+cat_cnt+'" class="form-control" required>'+'<?php echo $obj->getShowHideOption('');?>'+'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowCategory('+cat_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>');

	$("#cat_cnt").val(cat_cnt);

	

	var cat_total_cnt = parseInt($("#cat_total_cnt").val());

	cat_total_cnt = cat_total_cnt + 1;

	$("#cat_total_cnt").val(cat_total_cnt);

}



function removeRowCategory(idval)

{

	//alert("row_cat_"+idval);

	$("#row_cat_"+idval).remove();

	

	var cat_total_cnt = parseInt($("#cat_total_cnt").val());

	cat_total_cnt = cat_total_cnt - 1;

	$("#cat_total_cnt").val(cat_total_cnt);

}



function addMoreRowWeight()

{

	var cw_cnt = parseInt($("#cw_cnt").val());

	cw_cnt = cw_cnt + 1;

	//alert("cw_cnt"+cw_cnt);

	$("#row_cw_first").after('<?php echo $add_more_row_cw_str;?>');

	$("#cw_cnt").val(cw_cnt);

	

	var cw_total_cnt = parseInt($("#cw_total_cnt").val());

	cw_total_cnt = cw_total_cnt + 1;

	$("#cw_total_cnt").val(cw_total_cnt);

}



function removeRowWeight(idval)

{

	//alert("row_cw_"+idval);

	$("#row_cw_"+idval).remove();

	

	var cw_total_cnt = parseInt($("#cw_total_cnt").val());

	cw_total_cnt = cw_total_cnt - 1;

	$("#cw_total_cnt").val(cw_total_cnt);

}

</script>

</body>

</html>