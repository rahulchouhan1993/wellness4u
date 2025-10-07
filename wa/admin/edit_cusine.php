<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '27';
$edit_action_id = '108';

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

$show_for_complementry = 'none';

$cgst_tax_cat_id = '232';
$sgst_tax_cat_id = '233';
$cess_tax_cat_id = '234';
$gst_tax_cat_id = '231';

if(isset($_GET['token']) && $_GET['token'] != '')
{
	$cusine_id = base64_decode($_GET['token']);
	$arr_record = $obj->getCusineDetails($cusine_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_cusines.php");
		exit(0);
	}
	
	$item_id = $arr_record['item_id'];
	$cusine_image = $arr_record['cusine_image'];
	$vendor_id = $arr_record['vendor_id']; 
	$vendor_show = $arr_record['vendor_show']; 
	$cusine_type_parent_id = $arr_record['cusine_type_parent_id']; 
	$cusine_type_id = $arr_record['cusine_type_id']; 
	$min_cart_price = $arr_record['min_cart_price']; 
	$order_cutoff_time = $arr_record['order_cutoff_time']; 
	$delivery_time = $arr_record['delivery_time']; 
	$delivery_time_show = $arr_record['delivery_time_show']; 
	$delivery_date_show = $arr_record['delivery_date_show']; 
	$cancel_cutoff_time = $arr_record['cancel_cutoff_time']; 
	$cancel_cutoff_time_show = $arr_record['cancel_cutoff_time_show']; 
	
	$cgst_tax = $arr_record['cgst_tax']; 
	$sgst_tax = $arr_record['sgst_tax']; 
	$cess_tax = $arr_record['cess_tax']; 
	$gst_tax = $arr_record['gst_tax']; 
	
	
	if($cusine_type_id == '122')
	{
		$show_for_complementry = '';
	}
	
	$arr_vloc_id = array();
	$arr_ordering_type_id = array();
	$arr_ordering_size_id = array();
	$arr_ordering_size_show = array();
	$arr_max_order = array();
	$arr_min_order = array();
	$arr_cusine_qty = array();
	$arr_cusine_qty_show = array();
	$arr_sold_qty_show = array();
	$arr_currency_id = array();
	$arr_cusine_price = array();
	$arr_default_price = array();

	$arr_is_offer = array();
	$arr_offer_price = array();
	$arr_offer_date_type = array();
	$arr_offer_days_of_month = array();
	$arr_offer_days_of_month_str = array();
	$arr_offer_days_of_week = array();
	$arr_offer_days_of_week_str = array();
	$arr_offer_single_date = array();
	$arr_offer_start_date = array();
	$arr_offer_end_date = array();

	$arr_offer_show_days_of_month = array();
	$arr_offer_show_days_of_week = array();
	$arr_offer_show_single_date = array();
	$arr_offer_show_start_date = array();
	$arr_offer_show_end_date = array();
	$arr_offer_show_price_label = array();
	$arr_offer_show_price_value = array();
	$arr_offer_show_date = array();

	
	$arr_loc_record = $obj->getCusineAllLocation($cusine_id);
	if(count($arr_loc_record)>0)
	{
		for($i=0;$i<count($arr_loc_record);$i++)
		{
			array_push($arr_vloc_id , $arr_loc_record[$i]['vloc_id']);
			array_push($arr_ordering_type_id , $arr_loc_record[$i]['ordering_type_id']);
			array_push($arr_ordering_size_id , $arr_loc_record[$i]['ordering_size_id']);
			array_push($arr_ordering_size_show , $arr_loc_record[$i]['ordering_size_show']);
			array_push($arr_max_order , $arr_loc_record[$i]['max_order']);
			array_push($arr_min_order , $arr_loc_record[$i]['min_order']);
			array_push($arr_cusine_qty , $arr_loc_record[$i]['cusine_qty']); 
			array_push($arr_cusine_qty_show , $arr_loc_record[$i]['cusine_qty_show']); 
			array_push($arr_sold_qty_show , $arr_loc_record[$i]['sold_qty_show']); 
			array_push($arr_currency_id , $arr_loc_record[$i]['currency_id']); 
			array_push($arr_cusine_price , $arr_loc_record[$i]['cusine_price']); 
			array_push($arr_default_price , $arr_loc_record[$i]['default_price']); 
			
			array_push($arr_is_offer , $arr_loc_record[$i]['is_offer']); 
			if($arr_loc_record[$i]['is_offer'] == '1')
			{
				array_push($arr_offer_show_price_label , ''); 	
				array_push($arr_offer_show_price_value , ''); 	
				array_push($arr_offer_show_date , ''); 	
			}
			else
			{
				array_push($arr_offer_show_price_label , 'none'); 	
				array_push($arr_offer_show_price_value , 'none'); 	
				array_push($arr_offer_show_date , 'none'); 	
			}
			
			array_push($arr_offer_price , $arr_loc_record[$i]['offer_price']); 
			array_push($arr_offer_date_type , $arr_loc_record[$i]['offer_date_type']);
			
			
			$arr_offer_days_of_month[$i] = array();	
			$arr_offer_days_of_week[$i] = array();	
			
			if($arr_loc_record[$i]['offer_date_type'] == 'days_of_month')
			{
				if($arr_loc_record[$i]['offer_days_of_month'] == '-1' || $arr_loc_record[$i]['offer_days_of_month'] == '')
				{
					$arr_offer_days_of_month[$i] = array('-1');	
					array_push($arr_offer_days_of_month_str , '-1');
				}
				else
				{
					$arr_offer_days_of_month[$i] = explode(',',$arr_loc_record[$i]['offer_days_of_month']);	
					array_push($arr_offer_days_of_month_str , $arr_loc_record[$i]['offer_days_of_month']);
				}
				
				$arr_offer_days_of_week[$i] = array('-1');
				array_push($arr_offer_days_of_week_str , '-1');
				array_push($arr_offer_single_date , '');
				array_push($arr_offer_start_date , '');
				array_push($arr_offer_end_date , '');
				
				array_push($arr_offer_show_days_of_month , '');
				array_push($arr_offer_show_days_of_week , 'none');
				array_push($arr_offer_show_single_date , 'none');
				array_push($arr_offer_show_start_date , 'none');
				array_push($arr_offer_show_end_date , 'none');
			}
			elseif($arr_loc_record[$i]['offer_date_type'] == 'days_of_week')
			{
				//echo '<br>'.$arr_loc_record[$i]['offer_days_of_week'];
				if($arr_loc_record[$i]['offer_days_of_week'] == '-1' || $arr_loc_record[$i]['offer_days_of_week'] == '')
				{
					$arr_offer_days_of_week[$i] = array('-1');	
					array_push($arr_offer_days_of_week_str , '-1');
				}
				else
				{
					$arr_offer_days_of_week[$i] = explode(',',$arr_loc_record[$i]['offer_days_of_week']);	
					array_push($arr_offer_days_of_week_str , $arr_loc_record[$i]['offer_days_of_week']);
				}
				
				//echo'<br><pre>';
				//print_r($arr_offer_days_of_week[$i]);
				//echo'<br></pre>';
				
				$arr_offer_days_of_month[$i] = array('-1');
				array_push($arr_offer_days_of_month_str , '-1');
				array_push($arr_offer_single_date , '');
				array_push($arr_offer_start_date , '');
				array_push($arr_offer_end_date , '');
				
				array_push($arr_offer_show_days_of_month , 'none');
				array_push($arr_offer_show_days_of_week , '');
				array_push($arr_offer_show_single_date , 'none');
				array_push($arr_offer_show_start_date , 'none');
				array_push($arr_offer_show_end_date , 'none');
			}
			elseif($arr_loc_record[$i]['offer_date_type'] == 'single_date')
			{
				array_push($arr_offer_single_date , date('d-m-Y',strtotime($arr_loc_record[$i]['offer_single_date'])));
				
				$arr_offer_days_of_month[$i] = array('-1');
				array_push($arr_offer_days_of_month_str , '-1');
				$arr_offer_days_of_week[$i] = array('-1');
				array_push($arr_offer_days_of_week_str , '-1');
				array_push($arr_offer_start_date , '');
				array_push($arr_offer_end_date , '');
				
				array_push($arr_offer_show_days_of_month , 'none');
				array_push($arr_offer_show_days_of_week , 'none');
				array_push($arr_offer_show_single_date , '');
				array_push($arr_offer_show_start_date , 'none');
				array_push($arr_offer_show_end_date , 'none');
			}
			elseif($arr_loc_record[$i]['offer_date_type'] == 'date_range')
			{
				array_push($arr_offer_start_date , date('d-m-Y',strtotime($arr_loc_record[$i]['offer_start_date'])));
				array_push($arr_offer_end_date , date('d-m-Y',strtotime($arr_loc_record[$i]['offer_end_date'])));
				
				$arr_offer_days_of_month[$i] = array('-1');
				array_push($arr_offer_days_of_month_str , '-1');
				$arr_offer_days_of_week[$i] = array('-1');
				array_push($arr_offer_days_of_week_str , '-1');
				array_push($arr_offer_single_date , '');
				
				array_push($arr_offer_show_days_of_month , 'none');
				array_push($arr_offer_show_days_of_week , 'none');
				array_push($arr_offer_show_single_date , 'none');
				array_push($arr_offer_show_start_date , '');
				array_push($arr_offer_show_end_date , '');
			}
			else
			{
				$arr_offer_days_of_month[$i] = array('-1');
				array_push($arr_offer_days_of_month_str , '-1');
				$arr_offer_days_of_week[$i] = array('-1');
				array_push($arr_offer_days_of_week_str , '-1');
				array_push($arr_offer_single_date , '');
				array_push($arr_offer_start_date , '');
				array_push($arr_offer_end_date , '');
				
				array_push($arr_offer_show_days_of_month , 'none');
				array_push($arr_offer_show_days_of_week , 'none');
				array_push($arr_offer_show_single_date , 'none');
				array_push($arr_offer_show_start_date , 'none');
				array_push($arr_offer_show_end_date , 'none');
			}	
		}
		$loc_total_cnt = count($arr_loc_record);
		$loc_cnt = $loc_total_cnt - 1;
		
	}
	else
	{
		$loc_cnt = 0;
		$loc_total_cnt = 1;
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
		
		$arr_offer_days_of_month[$i] = array('-1');
		array_push($arr_offer_days_of_month_str , '-1');
		$arr_offer_days_of_week[$i] = array('-1');
		array_push($arr_offer_days_of_week_str , '-1');
		array_push($arr_offer_single_date , '');
		array_push($arr_offer_start_date , '');
		array_push($arr_offer_end_date , '');
		
		array_push($arr_offer_show_days_of_month , 'none');
		array_push($arr_offer_show_days_of_week , 'none');
		array_push($arr_offer_show_single_date , 'none');
		array_push($arr_offer_show_start_date , 'none');
		array_push($arr_offer_show_end_date , 'none');
	}
	
	
	
	$arr_cat_record = $obj->getCusineAllCategory($cusine_id);
	$arr_cucat_parent_cat_id = array();
	$arr_cucat_cat_id = array();
	$arr_cucat_show = array();
	if(count($arr_cat_record)>0)
	{
		for($i=0;$i<count($arr_cat_record);$i++)
		{
			array_push($arr_cucat_parent_cat_id, $arr_cat_record[$i]['cucat_parent_cat_id']);
			array_push($arr_cucat_cat_id, $arr_cat_record[$i]['cucat_cat_id']);
			array_push($arr_cucat_show, $arr_cat_record[$i]['cucat_show']);
		}
		$cat_total_cnt = count($arr_cat_record);
		$cat_cnt = $cat_total_cnt - 1;
		
	}
	else
	{
		$cat_cnt = 0;
		$cat_total_cnt = 1;
		$arr_cucat_parent_cat_id = array('');
		$arr_cucat_cat_id = array('');
		$arr_cucat_show = array('');	
	}
	
	$cw_qt_parent_cat_id = '197';
	$cw_qu_parent_cat_id = '147';
	$arr_cw_record = $obj->getCusineAllWeight($cusine_id);
	$arr_cw_qt_parent_cat_id = array();
	$arr_cw_qt_cat_id = array();
	$arr_cw_qu_parent_cat_id = array();
	$arr_cw_qu_cat_id = array();
	$arr_cw_quantity = array();
	$arr_cw_show = array();
	if(count($arr_cw_record)>0)
	{
		for($i=0;$i<count($arr_cw_record);$i++)
		{
			array_push($arr_cw_qt_parent_cat_id, $arr_cw_record[$i]['cw_qt_parent_cat_id']);
			array_push($arr_cw_qt_cat_id, $arr_cw_record[$i]['cw_qt_cat_id']);
			array_push($arr_cw_qu_parent_cat_id, $arr_cw_record[$i]['cw_qu_parent_cat_id']);
			array_push($arr_cw_qu_cat_id, $arr_cw_record[$i]['cw_qu_cat_id']);
			array_push($arr_cw_quantity, $arr_cw_record[$i]['cw_quantity']);
			array_push($arr_cw_show, $arr_cw_record[$i]['cw_show']);
		}
		$cw_total_cnt = count($arr_cw_record);
		$cw_cnt = $cw_total_cnt - 1;
		
	}
	else
	{
		$cw_cnt = 0;
		$cw_total_cnt = 1;
		
		$arr_cw_qt_parent_cat_id = array('197');
		$arr_cw_qt_cat_id = array('');
		$arr_cw_qu_parent_cat_id = array('147');
		$arr_cw_qu_cat_id = array('');
		$arr_cw_quantity = array('');
		$arr_cw_show = array('');
	}
	
	
	$cusine_country_id = $arr_record['cusine_country_id'];
	if($cusine_country_id == '-1' || $cusine_country_id == '')
	{
		$arr_country_id = array('-1');	
	}
	else
	{
		$arr_country_id = explode(',',$cusine_country_id);	
	}
	
	$cusine_state_id = $arr_record['cusine_state_id'];
	if($cusine_state_id == '-1' || $cusine_state_id == '')
	{
		$arr_state_id = array('-1');	
	}
	else
	{
		$arr_state_id = explode(',',$cusine_state_id);	
	}
	
	$cusine_city_id = $arr_record['cusine_city_id'];
	if($cusine_city_id == '-1' || $cusine_city_id == '')
	{
		$arr_city_id = array('-1');	
	}
	else
	{
		$arr_city_id = explode(',',$cusine_city_id);	
	}
	
	$cusine_area_id = $arr_record['cusine_area_id'];
	if($cusine_area_id == '-1' || $cusine_area_id == '')
	{
		$arr_area_id = array('-1');	
	}
	else
	{
		$arr_area_id = explode(',',$cusine_area_id);	
	}
	
	$cusine_status = $arr_record['cusine_status'];
	
	$publish_date_type = $arr_record['publish_date_type'];
	$publish_days_of_month = $arr_record['publish_days_of_month'];
	$publish_days_of_week = $arr_record['publish_days_of_week'];
	$publish_single_date = $arr_record['publish_single_date'];
	$publish_start_date = $arr_record['publish_start_date'];
	$publish_end_date = $arr_record['publish_end_date'];
	
	$delivery_date_type = $arr_record['delivery_date_type'];
	$delivery_days_of_month = $arr_record['delivery_days_of_month'];
	$delivery_days_of_week = $arr_record['delivery_days_of_week'];
	$delivery_single_date = $arr_record['delivery_single_date'];
	$delivery_start_date = $arr_record['delivery_start_date'];
	$delivery_end_date = $arr_record['delivery_end_date'];
	
	$cusine_desc_1 = $arr_record['cusine_desc_1'];
	$cusine_desc_show_1 = $arr_record['cusine_desc_show_1'];
	$cusine_desc_2 = $arr_record['cusine_desc_2'];
	$cusine_desc_show_2 = $arr_record['cusine_desc_show_2'];
	
	if($publish_date_type == 'days_of_month')
	{
		if($publish_days_of_month == '-1' || $publish_days_of_month == '')
		{
			$arr_publish_days_of_month = array('-1');	
		}
		else
		{
			$arr_publish_days_of_month = explode(',',$publish_days_of_month);	
		}
		
		$arr_publish_days_of_week = array('-1');
		$publish_single_date = '';
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = '';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = 'none';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	elseif($publish_date_type == 'days_of_week')
	{
		if($publish_days_of_week == '-1' || $publish_days_of_week == '')
		{
			$arr_publish_days_of_week = array('-1');	
		}
		else
		{
			$arr_publish_days_of_week = explode(',',$publish_days_of_week);	
		}
		
		$arr_publish_days_of_month = array('-1');
		$publish_single_date = '';
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = '';
		$publish_show_single_date = 'none';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	elseif($publish_date_type == 'single_date')
	{
		$publish_single_date = date('d-m-Y',strtotime($publish_single_date));
		
		$arr_publish_days_of_month = array('-1');
		$arr_publish_days_of_week = array('-1');
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = '';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	elseif($publish_date_type == 'date_range')
	{
		$publish_start_date = date('d-m-Y',strtotime($publish_start_date));
		$publish_end_date = date('d-m-Y',strtotime($publish_end_date));
		
		$arr_publish_days_of_month = array('-1');
		$arr_publish_days_of_week = array('-1');
		$publish_single_date = '';
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = 'none';
		$publish_show_start_date = '';
		$publish_show_end_date = '';
	}
	else
	{
		$arr_publish_days_of_month = array('-1');
		$arr_publish_days_of_week = array('-1');
		$publish_single_date = '';
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = 'none';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	
	if($delivery_date_type == 'days_of_month')
	{
		if($delivery_days_of_month == '-1' || $delivery_days_of_month == '')
		{
			$arr_delivery_days_of_month = array('-1');	
		}
		else
		{
			$arr_delivery_days_of_month = explode(',',$delivery_days_of_month);	
		}
		
		$arr_delivery_days_of_week = array('-1');
		$delivery_single_date = '';
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = '';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}
	elseif($delivery_date_type == 'days_of_week')
	{
		if($delivery_days_of_week == '-1' || $delivery_days_of_week == '')
		{
			$arr_delivery_days_of_week = array('-1');	
		}
		else
		{
			$arr_delivery_days_of_week = explode(',',$delivery_days_of_week);	
		}
		
		$arr_delivery_days_of_month = array('-1');
		$delivery_single_date = '';
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = '';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}
	elseif($delivery_date_type == 'single_date')
	{
		$delivery_single_date = date('d-m-Y',strtotime($delivery_single_date));
		
		$arr_delivery_days_of_month = array('-1');
		$arr_delivery_days_of_week = array('-1');
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = '';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}
	elseif($delivery_date_type == 'date_range')
	{
		$delivery_start_date = date('d-m-Y',strtotime($delivery_start_date));
		$delivery_end_date = date('d-m-Y',strtotime($delivery_end_date));
		
		$arr_delivery_days_of_month = array('-1');
		$arr_delivery_days_of_week = array('-1');
		$delivery_single_date = '';
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = '';
		$delivery_show_end_date = '';
	}
	else
	{
		$arr_delivery_days_of_month = array('-1');
		$arr_delivery_days_of_week = array('-1');
		$delivery_single_date = '';
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}

}	
else
{
	header("Location: manage_cusines.php");
	exit(0);
}	

$add_more_row_cat_str = '<div class="form-group" id="row_cat_\'+cat_cnt+\'"><label class="col-lg-2 control-label"></label><div class="col-lg-3"><select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_\'+cat_cnt+\'" onchange="getMainCategoryOptionAddMore(\'+cat_cnt+\')" class="form-control" required>'.$obj->getMainProfileOption('').'</select></div><div class="col-lg-3"><select name="cucat_cat_id[]" id="cucat_cat_id_\'+cat_cnt+\'" class="form-control" required>'.$obj->getMainCategoryOption('','').'</select></div><div class="col-lg-2"><select name="cucat_show[]" id="cucat_show_\'+cat_cnt+\'" class="form-control" required>'.$obj->getShowHideOption('').'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>';
$add_more_row_cw_str = '<div class="form-group" id="row_cw_\'+cw_cnt+\'"><div class="col-lg-3"><input type="hidden" name="cw_qt_parent_cat_id[]" id="cw_qt_parent_cat_id_\'+cw_cnt+\'" value="'.$cw_qt_parent_cat_id.'"><select name="cw_qt_cat_id[]" id="cw_qt_cat_id_\'+cw_cnt+\'" class="form-control">'.$obj->getMainCategoryOption($cw_qt_parent_cat_id,'').'</select></div><div class="col-lg-3"><input type="hidden" name="cw_qu_parent_cat_id[]" id="cw_qu_parent_cat_id_\'+cw_cnt+\'" value="'.$cw_qu_parent_cat_id.'"><select name="cw_qu_cat_id[]" id="cw_qu_cat_id_\'+cw_cnt+\'" class="form-control">'.$obj->getMainCategoryOption($cw_qu_parent_cat_id,'').'</select></div><div class="col-lg-2"><input type="text" name="cw_quantity[]" id="cw_quantity_\'+cw_cnt+\'" class="form-control" value=""></div><div class="col-lg-2"><select name="cw_show[]" id="cw_show_\'+cw_cnt+\'" class="form-control">'.$obj->getShowHideOption('').'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowWeight(\'+cw_cnt+\');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>';

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
					<form role="form" class="form-horizontal" id="edit_cusine" name="edit_cusine" method="post"> 
						<input type="hidden" name="hdncusine_id" id="hdncusine_id" value="<?php echo $cusine_id;?>" >
						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">
						<input type="hidden" name="loc_cnt" id="loc_cnt" value="<?php echo $loc_cnt;?>">
						<input type="hidden" name="loc_total_cnt" id="loc_total_cnt" value="<?php echo $loc_total_cnt;?>">
						<input type="hidden" name="hdncusine_image" id="hdncusine_image" value="<?php echo $cusine_image;?>">
						<input type="hidden" name="cw_cnt" id="cw_cnt" value="<?php echo $cw_cnt;?>">
						<input type="hidden" name="cw_total_cnt" id="cw_total_cnt" value="<?php echo $cw_total_cnt;?>">
						<div class="form-group">
							<label class="col-lg-2 control-label">Item<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="item_id" id="item_id" class="form-control" required>
									<?php echo $obj->getItemOption($item_id); ?>
								</select>
							</div>
							
							<label class="col-lg-2 control-label">Cusine Image<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<?php
								if($cusine_image != '')
								{ ?>
									<img border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$cusine_image;?>" title="<?php echo $cusine_image;?>" alt="<?php echo $cusine_image;?>" />
								<?php	
								}
								?>
								<input type="file" name="cusine_image" id="cusine_image" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label"><?php echo $obj->getCategoryName($cusine_type_parent_id);?><span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="hidden" name="cusine_type_parent_id" id="cusine_type_parent_id" value="<?php echo $cusine_type_parent_id;?>">
								<select name="cusine_type_id" id="cusine_type_id" class="form-control" onchange="toggleCusionTypeValues();" required>
									<?php echo $obj->getMainCategoryOption($cusine_type_parent_id,$cusine_type_id); ?>
								</select>
							</div>
							
							<label class="col-lg-2 control-label "><span style="display:<?php echo $show_for_complementry;?>;" class="show_for_complementry">Min Cart Price<span style="color:red">*</span></span></label>
							<div class="col-lg-4">
								<span style="display:<?php echo $show_for_complementry;?>;" class="show_for_complementry">
									<input type="text" name="min_cart_price" id="min_cart_price" value="<?php echo $min_cart_price;?>" class="form-control" >
								</span>	
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Vendor<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vendor_id" id="vendor_id" class="form-control" onchange="getVendorLocationOption('1','1');" required>
									<?php echo $obj->getVendorOptionByItemId($item_id,$vendor_id); ?>
								</select>
							</div>
							
							<label class="col-lg-2 control-label">Show Vendor details<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vendor_show" id="vendor_show" class="form-control" required>
									<?php echo $obj->getShowHideOption($vendor_show); ?>
								</select>
							</div>

						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cusine_status" id="cusine_status" class="form-control">
									<option value="1" <?php if($cusine_status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($cusine_status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>

						</div>
						
						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<div class="form-group left-label">
								<label class="col-lg-4 control-label"><strong>Vendor Location, Inventory and Price Details:</strong></label>
							</div>
						<?php 
						for($i=0;$i<$loc_total_cnt;$i++)
						{ ?>
							<div id="row_loc_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<div class="form-group">
									<label class="col-lg-2 control-label">Vendor Location<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="vloc_id[]" id="vloc_id_<?php echo $i;?>" class="form-control vloc_box" required>
											<?php echo $obj->getVendorLocationOption($vendor_id,$arr_vloc_id[$i]); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Ordering Type<span style="color:red">*</span></label>
									<div class="col-lg-2">
										<select name="ordering_type_id[]" id="ordering_type_id_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getServingTypeOption($arr_ordering_type_id[$i]); ?>
										</select>
									</div>
								
									<label class="col-lg-2 control-label">Ordering Size<span style="color:red">*</span></label>
									<div class="col-lg-2">
										<select name="ordering_size_id[]" id="ordering_size_id_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getServingSizeOption($arr_ordering_size_id[$i]); ?>
										</select>
									</div>
									
									<label class="col-lg-2 control-label">Show Ordering Size<span style="color:red">*</span></label>
									<div class="col-lg-2">
										<select name="ordering_size_show[]" id="ordering_size_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption($arr_ordering_size_show[$i]); ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
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
										<input type="text" name="cusine_price[]" id="cusine_price" placeholder="Price" value="<?php echo $arr_cusine_price[$i];?>" class="form-control" required>
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
									<div class="col-lg-2">
									<?php
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
									?>	
									</div>
								</div>
							</div>
						<?php 
						} ?>	
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
									<select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMore(<?php echo $i;?>)" class="form-control" required>
										<?php echo $obj->getMainProfileOption($arr_cucat_parent_cat_id[$i]); ?>
									</select>
								</div>
								<div class="col-lg-3">
									<select name="cucat_cat_id[]" id="cucat_cat_id_<?php echo $i;?>" class="form-control" required>
										<?php echo $obj->getMainCategoryOption($arr_cucat_parent_cat_id[$i],$arr_cucat_cat_id[$i]); ?>
									</select>
								</div>
								<div class="col-lg-2">
									<select name="cucat_show[]" id="cucat_show_<?php echo $i;?>" class="form-control" required>
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
								<label class="col-lg-4 control-label"><strong>Package Weight Details:</strong></label>
							</div>	
							<div class="form-group">
								<label class="col-lg-3"><strong>Quantity Type</strong><span style="color:red">*</span></label>
								<label class="col-lg-3"><strong>Quantity Unit</strong><span style="color:red">*</span></label>
								<label class="col-lg-3"><strong>Quantity</strong><span style="color:red">*</span></label>
								<div class="col-lg-3"></div>
							</div>
						<?php
						for($i=0;$i<$cw_total_cnt;$i++)
						{ ?>
							<div class="form-group" id="row_cw_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
								<div class="col-lg-3">
									<input type="hidden" name="cw_qt_parent_cat_id[]" id="cw_qt_parent_cat_id_<?php echo $i;?>" value="<?php echo $arr_cw_qt_parent_cat_id[$i];?>">
									<select name="cw_qt_cat_id[]" id="cw_qt_cat_id_<?php echo $i;?>" class="form-control">
										<?php echo $obj->getMainCategoryOption($arr_cw_qt_parent_cat_id[$i],$arr_cw_qt_cat_id[$i]); ?>
									</select>
								</div>
								<div class="col-lg-3">
									<input type="hidden" name="cw_qu_parent_cat_id[]" id="cw_qu_parent_cat_id_<?php echo $i;?>" value="<?php echo $arr_cw_qu_parent_cat_id[$i];?>">
									<select name="cw_qu_cat_id[]" id="cw_qu_cat_id_<?php echo $i;?>" class="form-control">
										<?php echo $obj->getMainCategoryOption($arr_cw_qu_parent_cat_id[$i],$arr_cw_qu_cat_id[$i]); ?>
									</select>
								</div>
								<div class="col-lg-2">
									<input type="text" name="cw_quantity[]" id="cw_quantity_<?php echo $i;?>" class="form-control" value="<?php echo $arr_cw_quantity[$i];?>">
								</div>
								<div class="col-lg-2">
									<select name="cw_show[]" id="cw_show_<?php echo $i;?>" class="form-control">
										<?php echo $obj->getShowHideOption($arr_cw_show[$i]); ?>
									</select>
								</div>
								<div class="col-lg-2">
								<?php
								if($i == 0)
								{ ?>
									<a href="javascript:void(0);" onclick="addMoreRowWeight();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
								<?php  	
								}
								else
								{ ?>
									<a href="javascript:void(0);" onclick="removeRowWeight(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
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
								<label class="col-lg-4 control-label"><strong>Delivery Location Details:</strong></label>
							</div>	
							<div class="form-group" >	
								<div class="col-sm-3"><strong>Country:</strong>&nbsp;<br>
									<select name="country_id" id="country_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getCountryOption($arr_country_id,'2','1'); ?>
									</select>
								</div>
								<div class="col-sm-3"><strong>State:</strong>&nbsp;<br>
									<select name="state_id" id="state_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getStateOption($arr_country_id,$arr_state_id,'2','1'); ?>
									</select>
								</div>
								<div class="col-sm-3"><strong>City:</strong>&nbsp;<br>
									<select name="city_id" id="city_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getCityOption($arr_country_id,$arr_state_id,$arr_city_id,'2','1'); ?>
									</select>
								</div>
								<div class="col-sm-3"><strong>Area:</strong>&nbsp;<br>
									<select name="area_id" id="area_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getAreaOption($arr_country_id,$arr_state_id,$arr_city_id,$arr_area_id,'2','1'); ?>
									</select>
								</div>
							</div>
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
										<input type="text" name="publish_single_date" id="publish_single_date" placeholder="Select Date" class="form-control" value="<?php echo $publish_single_date;?>" required >
									</div>	
									<div id="publish_show_start_date" style="display:<?php echo $publish_show_start_date;?>">
										<input type="text" name="publish_start_date" id="publish_start_date" placeholder="Select Start Date" class="form-control" value="<?php echo $publish_start_date;?>" required >  
									</div>	
								</div>
								<div class="col-lg-3">
									<div id="publish_show_end_date" style="display:<?php echo $publish_show_end_date;?>">
										<input type="text" name="publish_end_date" id="publish_end_date" placeholder="Select End Date" class="form-control" value="<?php echo $publish_end_date;?>" required > 
									</div>	
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><strong>Date of Delivery</strong><span style="color:red">*</span></label>
							
								<div class="col-lg-4">
									<select name="delivery_date_type" id="delivery_date_type" onchange="showHideDateDropdowns('delivery')" class="form-control" required>
										<?php echo $obj->getDateTypeOption($delivery_date_type); ?>
									</select>
								</div>
								<div class="col-lg-3">
									<div id="delivery_show_days_of_month" style="display:<?php echo $delivery_show_days_of_month;?>">
										<select name="delivery_days_of_month" id="delivery_days_of_month" multiple="multiple" class="form-control" required >
											<?php echo $obj->getDaysOfMonthOption($arr_delivery_days_of_month,'2','1'); ?>
										</select>
									</div>	
									<div id="delivery_show_days_of_week" style="display:<?php echo $delivery_show_days_of_week;?>">
										<select name="delivery_days_of_week" id="delivery_days_of_week" multiple="multiple" class="form-control" required >
											<?php echo $obj->getDaysOfWeekOption($arr_delivery_days_of_week,'2','1'); ?>
										</select>
									</div>	
									<div id="delivery_show_single_date" style="display:<?php echo $delivery_show_single_date;?>">
										<input type="text" name="delivery_single_date" id="delivery_single_date" placeholder="Select Date" class="form-control" value="<?php echo $delivery_single_date;?>" required >
									</div>	
									<div id="delivery_show_start_date" style="display:<?php echo $delivery_show_start_date;?>">
										<input type="text" name="delivery_start_date" id="delivery_start_date" placeholder="Select Start Date" class="form-control" value="<?php echo $delivery_start_date;?>" required >  
									</div>	
								</div>
								<div class="col-lg-3">
									<div id="delivery_show_end_date" style="display:<?php echo $delivery_show_end_date;?>">
										<input type="text" name="delivery_end_date" id="delivery_end_date" placeholder="Select End Date" class="form-control" value="<?php echo $delivery_end_date;?>" required > 
									</div>	
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><strong>Show Delivery Date</strong></label>
								<div class="col-lg-4">
									<select name="delivery_date_show" id="delivery_date_show" class="form-control">
										<?php echo $obj->getShowHideOption($delivery_date_show); ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><strong>Cut Off Time</strong><span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="order_cutoff_time" id="order_cutoff_time" class="form-control" required>
										<?php echo $obj->getCutOffTimeOption($order_cutoff_time); ?>
									</select><span>Base Time: 11PM of day before of delivery date</span><br>
								</div>
								
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><strong>Delivery Time</strong></label>
								<div class="col-lg-4">
									<input type="text" name="delivery_time" id="delivery_time" class="form-control" value="<?php echo $delivery_time;?>">
								</div>
								
								<label class="col-lg-2 control-label"><strong>Show Delivery Time</strong></label>
								<div class="col-lg-4">
									<select name="delivery_time_show" id="delivery_time_show" class="form-control">
										<?php echo $obj->getShowHideOption($delivery_time_show); ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-2 control-label"><strong>Cancellation Cut Off Time</strong></label>
								<div class="col-lg-4">
									<select name="cancel_cutoff_time" id="cancel_cutoff_time" class="form-control" required>
										<?php echo $obj->getCancellationCutOffTimeOption($cancel_cutoff_time); ?>
									</select><span>Base Time: 11PM of day before of delivery date</span><br>
								</div>
								
								<label class="col-lg-2 control-label"><strong>Show Cancellation Cut Off Time</strong></label>
								<div class="col-lg-4">
									<select name="cancel_cutoff_time_show" id="cancel_cutoff_time_show" class="form-control">
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
							<div class="form-group"><label class="col-lg-2 control-label"><strong>Cusine Description 1</strong></label>
								<div class="col-lg-8">
									<textarea id="cusine_desc_1" name="cusine_desc_1" class="form-control"><?php echo stripslashes($cusine_desc_1);?></textarea>
								</div>
								<div class="col-lg-2">
									<select name="cusine_desc_show_1" id="cusine_desc_show_1" class="form-control">
										<?php echo $obj->getShowHideOption($cusine_desc_show_1); ?>
									</select>
								</div>
							</div>
							
							<div class="form-group"><label class="col-lg-2 control-label"><strong>Cusine Description 2</strong></label>
								<div class="col-lg-8">
									<textarea id="cusine_desc_2" name="cusine_desc_2" class="form-control"><?php echo stripslashes($cusine_desc_2);?></textarea>
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
<script src="admin-js/edit-cusine-validator.js" type="text/javascript"></script>
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
							'<label class="col-lg-2 control-label">Vendor Location<span style="color:red">*</span></label>'+
							'<div class="col-lg-4">'+
								'<select name="vloc_id[]" id="vloc_id_'+loc_cnt+'" class="form-control vloc_box" required>'+
									'<?php echo $obj->getVendorLocationOption($vendor_id,''); ?>'+
								'</select>'+
							'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="col-lg-2 control-label">Ordering Type<span style="color:red">*</span></label>'+
							'<div class="col-lg-4">'+
								'<select name="ordering_type_id[]" id="ordering_type_id_'+loc_cnt+'" class="form-control" required>'+
									'<?php echo $obj->getServingTypeOption(''); ?>'+
								'</select>'+
							'</div>'+
						
							'<label class="col-lg-2 control-label">Ordering Size<span style="color:red">*</span></label>'+
							'<div class="col-lg-4">'+
								'<select name="ordering_size_id[]" id="ordering_size_id_'+loc_cnt+'" class="form-control" required>'+
									'<?php echo $obj->getServingSizeOption(''); ?>'+
								'</select>'+
							'</div>'+
							
							'<label class="col-lg-2 control-label">Show Ordering Size<span style="color:red">*</span></label>'+
							'<div class="col-lg-2">'+
								'<select name="ordering_size_show[]" id="ordering_size_show_'+loc_cnt+'" class="form-control" required>'+
									'<?php echo $obj->getShowHideOption(''); ?>'+
								'</select>'+
							'</div>'+
						'</div>'+
						
						'<div class="form-group">'+
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
								'<input type="text" name="cusine_price[]" id="cusine_price_'+loc_cnt+'" placeholder="Price" value="" class="form-control" required>'+
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
	$("#row_cat_first").after('<?php echo $add_more_row_cat_str;?>');
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