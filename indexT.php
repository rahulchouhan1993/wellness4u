<?php 
require_once('classes/config.php');
require_once('classes/commonFunctions.php');

$obj = new commonFunctions();
$page_id = 1;
$arr_page_details = $obj->getFrontPageDetails($page_id);

if($obj->isUserLoggedIn())
{
	$user_id = $_SESSION['user_id'];
	$obj->updateUserOnlineTimestamp($user_id);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php');?>
</head>
<body>
<?php include_once('header.php');?>
<?php
$error = false;
$error_msg = '';

$arr_home_all_published_items = $obj->getHomePageAllPublishedItems($topcityid);
$arr_home_region_speciality = array();
$arr_home_dish_items = array();
$arr_home_featured_type = array();

if(count($arr_home_all_published_items) > 0)
{
	foreach($arr_home_all_published_items as $key => $val)
	{
		$arr_home_region_speciality[$val['region_category_id']] = $val['region_category'];
		$arr_home_dish_items[$val['item_id']] = $val['cusine_name'];
		
		if($val['is_featured_cusine'] == '1')
		{
			$arr_home_featured_type[$val['featured_type_id']] = $val['featured_type_name'];
		}
	}
}
else
{
	$error = true;
}

array_unique($arr_home_region_speciality, SORT_REGULAR);
asort($arr_home_region_speciality);

array_unique($arr_home_dish_items, SORT_REGULAR);
asort($arr_home_dish_items);

array_unique($arr_home_featured_type, SORT_REGULAR);
asort($arr_home_featured_type);

$_SESSION['arr_home_all_published_items'] = $arr_home_all_published_items;
$_SESSION['arr_home_region_speciality'] = $arr_home_region_speciality;
$_SESSION['arr_home_dish_items'] = $arr_home_dish_items;

?>
<?php
if(!$error)
{ ?>
<section id="booking">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-4 col-sm-4 date">	
				<?php
				if(!$error)
				{ ?>
					<select class="home_list_input" name="home_region_speciality" id="home_region_speciality" onchange="setHomeAllPublishedItemOptions();">
						<option value="">Select Regional Speciality</option>
					<?php
					foreach($arr_home_region_speciality as $r_key => $r_val)
					{ 
						$selected = '';
						?>
						<option value="<?php echo $r_key; ?>" <?php echo $selected;?> ><?php echo $r_val;?></option>
					<?php
					}	?>
					</select>
				<?php	
				} ?>
				</div>
				<div class="col-md-4 col-sm-4 date">
				<?php
				if(!$error)
				{ ?>
					<select class="home_list_input" name="home_dish_items" id="home_dish_items">
						<option value="">Select Dish</option>
					<?php
					foreach($arr_home_dish_items as $d_key => $d_val)
					{ 
						$selected = '';
						?>
						<option value="<?php echo $d_key; ?>" <?php echo $selected;?> ><?php echo $d_val;?></option>
					<?php
					}	?>
					</select>
				<?php
				} ?>	
				</div>
				<div class="col-md-4 col-sm-4 date">
				<?php
				if(!$error)
				{ ?>
					<button class="active" onclick="doSearchCusineExplore()">Explore</button>
				<?php
				} ?>		
				</div>	
			</div>
		</div>
	</div>
</section>
<?php
} ?>
<section id="dishes">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="home_page_content_box">
					<?php echo $arr_page_details['page_contents'];?>
				</div>	
			</div>
		</div>
		<div class="row">
		<?php
		if(count($arr_home_featured_type) > 0)
		{ ?>
			<?php
			foreach($arr_home_featured_type as $hf_k => $hf_v)
			{ 
			?>
			<div class="col-md-12 dish">
				<img src="images/icon6.png" alt="">
				<h2><?php echo $hf_v;?></h2>
			</div>
			<div class="col-md-12 my_silick">
				<?php
				$arr_cusine_records = $arr_home_all_published_items;
				for($j=0;$j<count($arr_cusine_records);$j++)
				{ 
					if($arr_cusine_records[$j]['featured_type_id'] == $hf_k)
					{ ?>
				<div class="silick">
					<div class="img col-md-12">
						<div class="row cusine_img_wrap">
							<img src="<?php echo SITE_URL.'/uploads/'.$arr_cusine_records[$j]['cusine_image'];?>" alt="image1.jpg" class="img-responsive">
							<p class="cusine_img_desc">
							<?php
							if($arr_cusine_records[$j]['cusine_desc_1'] != '' && $arr_cusine_records[$j]['cusine_desc_show_1'] == '1' )
							{
								echo stripslashes($arr_cusine_records[$j]['cusine_desc_1']);
							}
							elseif($arr_cusine_records[$j]['cusine_desc_2'] != '' && $arr_cusine_records[$j]['cusine_desc_show_2'] == '1' )
							{
								echo stripslashes($arr_cusine_records[$j]['cusine_desc_2']);
							}
							?>
							</p>
							
							<?php
							if($arr_cusine_records[$j]['cusine_default']['sold_qty_show'] == 1)
							{ ?>
							<h3><?php echo $arr_cusine_records[$j]['cusine_default']['sold_count'];?></h3>
							<?php
							} ?>
							
							<?php
							if($arr_cusine_records[$j]['cusine_default']['cusine_qty_show'] == 1)
							{ ?>
							<h4><?php echo $arr_cusine_records[$j]['cusine_default']['cusine_qty'];?></h4>
							<?php
							} ?>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-9"><h3><?php echo stripslashes($arr_cusine_records[$j]['cusine_name']);?></h3></div>
							<div class="col-md-3 vage"><?php echo $obj->getItemVegNonvegStr($arr_cusine_records[$j]['item_id']);?></div>
							<div class="col-md-12">
							<?php
							$temp_ing_str = $obj->getCommaSeperatedIngredientsOfItem($arr_cusine_records[$j]['item_id'],4);	
							$temp_cat_str = $obj->getCusineCategoriesString($arr_cusine_records[$j]['cusine_id']);	
							if($temp_ing_str != '')
							{ ?>
								<div class="cusine_cat_desc"><a href="#animatedModalIngredient" class="cls_ingredient_popup" onclick="openIngredientPopup('<?php echo $arr_cusine_records[$j]['item_id'];?>')"><?php echo $temp_ing_str?></a></div>
								<div class="cusine_cat_desc"><?php echo $temp_cat_str?></div>
							<?php		
							}
							else
							{ ?>
								<div class="cusine_cat_desc"><?php echo $temp_cat_str?></div>
								<div class="cusine_cat_desc"><?php echo $temp_ing_str?></div>
							<?php 	
							} ?>
							
							<?php
							if($arr_cusine_records[$j]['vendor_show'] == '1')
							{ ?>
								<div class="cusine_cat_desc"><strong>Food by :</strong> <?php echo $arr_cusine_records[$j]['vendor_name'];?></div>
							<?php
							}
							else
							{ ?>
								<div class="cusine_cat_desc"></div>
							<?php	
							} ?>
								
							<?php
							if($arr_cusine_records[$j]['delivery_time_show'] == '1')
							{ ?>
								<div class="cusine_cat_desc"><strong>Delivery Time :</strong> <?php echo $arr_cusine_records[$j]['delivery_time'];?></div>
							<?php	
							}
							else
							{ ?>
								<div class="cusine_cat_desc"></div>
							<?php	
							} ?>								
							</div>
							<div class="col-md-12 serving">
								<div class="col-md-12 pre">
									<p>
										<?php 
										echo $arr_cusine_records[$j]['cusine_default']['cat_name'];
										if(is_array($arr_cusine_records[$j]['cusine_weight']) && count($arr_cusine_records[$j]['cusine_weight']) > 0)
										{
											$cw_show_str = '';
											for($tmpcw=0;$tmpcw<count($arr_cusine_records[$j]['cusine_weight']);$tmpcw++)
											{
												if($arr_cusine_records[$j]['cusine_weight'][$tmpcw]['cw_show'] == '1')
												{
													$cw_show_str .= ', '.$obj->getCategoryName($arr_cusine_records[$j]['cusine_weight'][$tmpcw]['cw_qt_cat_id']).' : '.$arr_cusine_records[$j]['cusine_weight'][$tmpcw]['cw_quantity'].' '.$obj->getCategoryName($arr_cusine_records[$j]['cusine_weight'][$tmpcw]['cw_qu_cat_id']);
												}
											}
											echo $cw_show_str;
										}
										?>
									</p>
								</div>
							</div>
							<div class="col-md-12 serving">
								<div class="row">
									<div class="col-md-6  col-sm-12 pre2">
										<?php 
										$temp_cusine_area_arr = array();
										if($arr_cusine_records[$j]['cusine_area_id'] == '' || $arr_cusine_records[$j]['cusine_area_id'] == '-1')
										{
											$temp_cusine_locationstr = $obj->getCusineLocationStr($topcityid,'-1');
											$temp_cusine_area_arr = array('-1' => $temp_cusine_locationstr);	
										}
										else
										{
											$temp_cusine_area_arr_2 = explode(',',$arr_cusine_records[$j]['cusine_area_id']);
											if(count($temp_cusine_area_arr_2) > 0)
											{
												for($tt=0;$tt<count($temp_cusine_area_arr_2);$tt++)
												{
													$temp_cusine_locationstr = $obj->getCusineLocationStr($topcityid,$temp_cusine_area_arr_2[$tt]);
													//$temp_cusine_area_arr = array($temp_cusine_area_arr_2[$tt] => $temp_cusine_locationstr);	
													$temp_cusine_area_arr[$temp_cusine_area_arr_2[$tt]] = $temp_cusine_locationstr;	
												}	
											}
											else
											{
												$temp_cusine_locationstr = $obj->getCusineLocationStr($topcityid,'-1');
												$temp_cusine_area_arr = array('-1' => $temp_cusine_locationstr);	
											}
																						
										}
										?>
										<select name="cusine_area[]" id="cusine_area_<?php echo $j;?>" class="cusine_list_input cusine_area_<?php echo $j;?>" onchange="setValueToCloneSlider(this,<?php echo $j?>)" >
											<option value="">Select Area</option>
										<?php
										foreach($temp_cusine_area_arr as $cuar_k => $cuar_v)
										{ ?>
											<option value="<?php echo $cuar_k?>"><?php echo $cuar_v?></option>
										<?php		
										} ?>
										</select>
									</div>	
									<div class="col-md-6 col-sm-12 pre">
										<div style="float:right;">
										<?php
										$offer_item_flag = false;
										$today_day_of_month = date('j');
										$today_day_of_week = date('N');
										$today_single_date = date('Y-m-d');
										if($arr_cusine_records[$j]['cusine_default']['is_offer'] == '1')
										{
											if($arr_cusine_records[$j]['cusine_default']['offer_date_type'] == 'days_of_month')
											{
												if($arr_cusine_records[$j]['cusine_default']['offer_days_of_month'] == '-1')
												{
													$offer_item_flag = true;	
												}	
												else
												{
													$temp_ofr_dom = explode(',',$arr_cusine_records[$j]['cusine_default']['offer_days_of_month']);
													if(in_array($today_day_of_month,$temp_ofr_dom))
													{
														$offer_item_flag = true;		
													}
												}
											}
											elseif($arr_cusine_records[$j]['cusine_default']['offer_date_type'] == 'days_of_week')
											{
												if($arr_cusine_records[$j]['cusine_default']['offer_days_of_week'] == '-1')
												{
													$offer_item_flag = true;	
												}	
												else
												{
													$temp_ofr_dow = explode(',',$arr_cusine_records[$j]['cusine_default']['offer_days_of_week']);
													if(in_array($today_day_of_week,$temp_ofr_dow))
													{
														$offer_item_flag = true;		
													}
												}
											}
											elseif($arr_cusine_records[$j]['cusine_default']['offer_date_type'] == 'single_date')
											{
												if($arr_cusine_records[$j]['cusine_default']['offer_single_date'] == $today_single_date)
												{
													$offer_item_flag = true;	
												}	
											}
											elseif($arr_cusine_records[$j]['cusine_default']['offer_date_type'] == 'date_range')
											{
												$temp_ts_today = strtotime($today_single_date);
												$temp_ts_start = strtotime($arr_cusine_records[$j]['cusine_default']['offer_single_date']);
												$temp_ts_end = strtotime($arr_cusine_records[$j]['cusine_default']['offer_end_date']);
												if($temp_ts_start <= $temp_ts_today && $temp_ts_end >= $temp_ts_today)
												{
													$offer_item_flag = true;	
												}	
											}
										}
										
										if($arr_cusine_records[$j]['cusine_default']['currency_id'] == '1')
										{
											if($offer_item_flag)
											{ ?>
											<span class="rupi offer_strike">₹ <?php echo $arr_cusine_records[$j]['cusine_default']['cusine_price'];?></span>&nbsp;
											<span class="rupi">₹ <?php echo $arr_cusine_records[$j]['cusine_default']['offer_price'];?></span>
											<?php	
											}
											else
											{ ?>
											<span class="rupi">₹ <?php echo $arr_cusine_records[$j]['cusine_default']['cusine_price'];?></span>
											<?php	
											}
										}
										else
										{
											if($offer_item_flag)
											{ ?>
											<span class="rupi offer_strike">$ <?php echo $arr_cusine_records[$j]['cusine_default']['cusine_price'];?></span>&nbsp;
											<span class="rupi">$ <?php echo $arr_cusine_records[$j]['cusine_default']['offer_price'];?></span>
											<?php	
											}
											else
											{ ?>
											<span class="rupi">$ <?php echo $arr_cusine_records[$j]['cusine_default']['cusine_price'];?></span>
											<?php	
											}	
										} ?>  
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 serving">	
								<?php  /*<div class="col-md-12 pre">
									<div class="row">*/?>
									<?php
									if($arr_cusine_records[$j]['region_category_id'] == '164')
									{
										$order_button_label = 'ORDER';
									}
									else
									{
										$order_button_label = 'PRE-ORDER';
									}
									
									if($arr_cusine_records[$j]['actual_delivery_date'] != '')
									{
										$cusine_delivery_date = $arr_cusine_records[$j]['actual_delivery_date'];	
									}
									else
									{
										$cusine_delivery_date = date('Y-m-d');
									} ?>
									
									<?php
									
									if($arr_cusine_records[$j]['order_cutoff_time'] != '' )
									{
										$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
										$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
										//$current_showing_date_time = $current_showing_date. ' 23:00:00';
										$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
										$timestamp_csdt = strtotime($current_showing_date_time);
										
										$sec_cuttoff_time = $arr_cusine_records[$j]['order_cutoff_time'] * 3600;
										
										$final_compared_timestamp = $timestamp_csdt - $sec_cuttoff_time;
										$now = time();
										if($now < $final_compared_timestamp)
										{
											$flag_add_to_cart = true;
										}
										else
										{
											$flag_add_to_cart = false;
										}
									}
									else
									{
										$flag_add_to_cart = true;
									}
									
									if($flag_add_to_cart)
									{
										if($arr_cusine_records[$j]['cusine_default']['cusine_qty'] > 0)
										{ ?>
											<button onclick="addToCart('<?php echo $arr_cusine_records[$j]['cusine_id'];?>','1','<?php echo $j?>','<?php echo $cusine_delivery_date?>');"><?php echo $order_button_label;?></button>
										<?php	
										}
										else
										{ ?>
											<button class="btn_disabled_no_click">Stock Out</button>
										<?php	
										}
									}
									else
									{ ?>
										<button class="btn_disabled_no_click">Booking Closed</button>
									<?php	
									} ?>										
											
									<?php /*</div>
								</div> */ ?>
							</div>
						</div>
					</div>
				</div>
				<?php
					}
				} ?>
				
            </div>
		<?php
			}
		}
		else
		{ ?>
		<?php
		} ?>		
		</div>
	</div>
</section>
<?php include_once('footer.php');?>	
</body>
</html>