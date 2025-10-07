<?php

include_once('../../classes/config.php');

require_once('../../classes/vendor.php');

$obj = new Vendor();

/*

if(!$obj->isVendorLoggedIn())

{

	exit(0);

}

*/



$error = false;

$err_msg = '';

$action = $_REQUEST['action'];

if($action == 'getstate')

{

	$country_id = $_REQUEST['country'];

    $state_id = $_REQUEST['state'];

    $data = $obj->GetState($state_id,$country_id);

    

    echo $data;

    exit(0);

}

elseif($action == 'getcity')

{

	$country_id = $_REQUEST['country'];

    $state_id = $_REQUEST['state'];

	$city_id = $_REQUEST['city'];

    $data = $obj->GetCity($state_id,$country_id,$city_id);

    

    echo $data;

    exit(0);

}

elseif($action == 'getsubcat')

{

	$cat_id = $_REQUEST['cat_id'];

    $sub_cat = $_REQUEST['sub_cat'];

    $data = $obj->GetCategories($sub_cat,$cat_id);

    

    echo $data;

    exit(0);

}

elseif($action == 'getsubcats')

{

	$cat_id = $_REQUEST['cat_id'];

    $sub_cat = $_REQUEST['sub_cat'];

    $data = $obj->GetCategoriesById($cat_id,$sub_cat);

    

    echo $data;

    exit(0);

}

elseif($action == 'getvendorlocationoption')

{

	$vendor_id = trim($_REQUEST['vendor_id']);

	if(isset($_REQUEST['type']))

	{

		$type = trim($_REQUEST['type']);

	}

	else

	{

		$type = '';	

	}

	

	if(isset($_REQUEST['multiple']))

	{

		$multiple = trim($_REQUEST['multiple']);

	}

	else

	{

		$multiple = '';	

	}

    $vloc_id = '';

	$data = $obj->getVendorLocationOption($vendor_id,$vloc_id,$type,$multiple);

    echo $data;

}

elseif($action == 'getmaincategoryoption')

{

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

	if(isset($_REQUEST['type']))

	{

		$type = trim($_REQUEST['type']);

	}

	else

	{

		$type = '';	

	}

	

	if(isset($_REQUEST['multiple']))

	{

		$multiple = trim($_REQUEST['multiple']);

	}

	else

	{

		$multiple = '';	

	}

	

	if($multiple == '1')

	{

		$strpos_pc = strpos($parent_cat_id,',');

		if($strpos_pc === false)

		{

			$arr_parent_cat_id = array($parent_cat_id);

		}

		else

		{

			$arr_parent_cat_id = explode(',',$parent_cat_id);		

		}

		$cat_id = array();

	}

	else

	{

		$arr_parent_cat_id = $parent_cat_id;

		$cat_id = '';

	}

	

	if(isset($_REQUEST['default_cat_id']))

	{

		$default_cat_id = trim($_REQUEST['default_cat_id']);

	}

	else

	{

		$default_cat_id = '';	

	}

    

	$data = $obj->getMainCategoryOption($arr_parent_cat_id,$cat_id,$type,$multiple,$default_cat_id);

    echo $data;

}

elseif($action == 'getstateoption')

{

	$country_id = trim($_REQUEST['country_id']);

	$state_id = trim($_REQUEST['state_id']);

	if(isset($_REQUEST['type']))

	{

		$type = trim($_REQUEST['type']);

	}

	else

	{

		$type = '';	

	}

	

	if(isset($_REQUEST['multiple']))

	{

		$multiple = trim($_REQUEST['multiple']);

	}

	else

	{

		$multiple = '';	

	}

	

	if($multiple == '1')

	{

		$arr_country_id = explode(',',$country_id);

		$arr_state_id = explode(',',$state_id);

	}

	else

	{

		$arr_country_id = $country_id;

		$arr_state_id = $state_id;

	}

	

    

	$data = $obj->getStateOption($arr_country_id,$arr_state_id,$type,$multiple);

    echo $data;

}

elseif($action == 'getcityoption')

{

	$country_id = trim($_REQUEST['country_id']);

	$state_id = trim($_REQUEST['state_id']);

	$city_id = trim($_REQUEST['city_id']);

	if(isset($_REQUEST['type']))

	{

		$type = trim($_REQUEST['type']);

	}

	else

	{

		$type = '';	

	}

	

	if(isset($_REQUEST['multiple']))

	{

		$multiple = trim($_REQUEST['multiple']);

	}

	else

	{

		$multiple = '';	

	}

	

	if($multiple == '1')

	{

		$arr_country_id = explode(',',$country_id);

		$arr_state_id = explode(',',$state_id);

		$arr_city_id = explode(',',$city_id);

	}

	else

	{

		$arr_country_id = $country_id;

		$arr_state_id = $state_id;

		$arr_city_id = $city_id;

	}

	

    

	$data = $obj->getCityOption($arr_country_id,$arr_state_id,$arr_city_id,$type,$multiple);

    echo $data;

}

elseif($action == 'getareaoption')

{

	$country_id = trim($_REQUEST['country_id']);

	$state_id = trim($_REQUEST['state_id']);

	$city_id = trim($_REQUEST['city_id']);

	$area_id = trim($_REQUEST['area_id']);

	if(isset($_REQUEST['type']))

	{

		$type = trim($_REQUEST['type']);

	}

	else

	{

		$type = '';	

	}

	

	if(isset($_REQUEST['multiple']))

	{

		$multiple = trim($_REQUEST['multiple']);

	}

	else

	{

		$multiple = '';	

	}

	

	if($multiple == '1')

	{

		$arr_country_id = explode(',',$country_id);

		$arr_state_id = explode(',',$state_id);

		$arr_city_id = explode(',',$city_id);

		$arr_area_id = explode(',',$area_id);

	}

	else

	{

		$arr_country_id = $country_id;

		$arr_state_id = $state_id;

		$arr_city_id = $city_id;

		$arr_area_id = $area_id;

	}

	

    

	$data = $obj->getAreaOption($arr_country_id,$arr_state_id,$arr_city_id,$arr_area_id,$type,$multiple);

    echo $data;

}

elseif($action=='cusineslist')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

		$txtsearch = trim($_POST['txtsearch']);

	}

	

	$status = '';

	if(isset($_POST['status']) && trim($_POST['status']) != '')

	{

		$status = trim($_POST['status']);

	}

	

	$cucat_parent_cat_id = '';

	if(isset($_POST['cucat_parent_cat_id']) && trim($_POST['cucat_parent_cat_id']) != '')

	{

		$cucat_parent_cat_id = trim($_POST['cucat_parent_cat_id']);

	}

	

	$cucat_cat_id = '';

	if(isset($_POST['cucat_cat_id']) && trim($_POST['cucat_cat_id']) != '')

	{

		$cucat_cat_id = trim($_POST['cucat_cat_id']);

	}

	

	$vendor_id = $_SESSION['adm_vendor_id'];

	$added_by_admin = '';

	

	

	$added_date_type = '';

	if(isset($_POST['added_date_type']) && trim($_POST['added_date_type']) != '')

	{

		$added_date_type = trim($_POST['added_date_type']);

	}

	

	$added_days_of_month = '';

	if(isset($_POST['added_days_of_month']) && trim($_POST['added_days_of_month']) != '')

	{

		$added_days_of_month = trim($_POST['added_days_of_month']);

	}

	

	$added_days_of_week = '';

	if(isset($_POST['added_days_of_week']) && trim($_POST['added_days_of_week']) != '')

	{

		$added_days_of_week = trim($_POST['added_days_of_week']);

	}

	

	$added_single_date = '';

	if(isset($_POST['added_single_date']) && trim($_POST['added_single_date']) != '')

	{

		$added_single_date = trim($_POST['added_single_date']);

	}

	

	$added_start_date = '';

	if(isset($_POST['added_start_date']) && trim($_POST['added_start_date']) != '')

	{

		$added_start_date = trim($_POST['added_start_date']);

	}

	

	$added_end_date = '';

	if(isset($_POST['added_end_date']) && trim($_POST['added_end_date']) != '')

	{

		$added_end_date = trim($_POST['added_end_date']);

	}

	

	$country_id = '';

	if(isset($_POST['country_id']) && trim($_POST['country_id']) != '')

	{

		$country_id = trim($_POST['country_id']);

	}

	

	$state_id = '';

	if(isset($_POST['state_id']) && trim($_POST['state_id']) != '')

	{

		$state_id = trim($_POST['state_id']);

	}

	

	$city_id = '';

	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')

	{

		$city_id = trim($_POST['city_id']);

	}

	

	$area_id = '';

	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')

	{

		$area_id = trim($_POST['area_id']);

	}

	

	$delivery_date = '';

	if(isset($_POST['delivery_date']) && trim($_POST['delivery_date']) != '')

	{

		$delivery_date = trim($_POST['delivery_date']);

	}

	

	$item = $obj->getAllCusines($txtsearch,$status,$cucat_parent_cat_id,$cucat_cat_id,$vendor_id,$added_by_admin,$added_date_type,$added_days_of_month,$added_days_of_week,$added_single_date,$added_start_date,$added_end_date,$country_id,$state_id,$city_id,$area_id,$delivery_date);

   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

	$count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	

	$edit_action_id = '41';

	$delete_action_id = '42';	

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$edit_action_id))

	{

		$edit_action = true;

	}	

	else

	{

		$edit_action = false;

	}

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

	{

		$delete_action = true;

	}	

	else

	{

		$delete_action = false;

	}

	

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

							<tr>

								<th>Sr No</th>

								<th>Item Name</th>

								<th>Cusine Image</th>

								<th>Vendor</th>

								<th>Price</th>

								<th>Quantity</th>

								<th>Category</th>

								<th>Status</th>

								<th>Added Date</th>

								<th>Action</th>

								<th>';

	if($delete_action)

	{

	//$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultiplecusines();">';	

	}		

	

	

	$option.= '					</th>

							</tr>

						</thead>

						<tbody>';

					

	if(is_array($data) && count($data) > 0)

	{

		foreach($data as $record)

		{

            if($record['cusine_status'] == 1 )

			{

				$status = 'Active';

			}

			else

			{

				$status = 'InActive'; 

			}

			

			if($record['cusine_image'] != '' )

			{

				$cusine_image = '<img border="0" height="50" src="'.SITE_URL.'/uploads/'.$record['cusine_image'].'" />';

			}

			else

			{

				$cusine_image = ''; 

			}

			

			$option.='		<tr>

								<td>'.$i.'</td>

								<td>'.$record['item_name'].'</td>

								<td>'.$cusine_image.'</td>

								<td>'.$record['vendor_name'].'</td>

								<td>'.$record['cusine_price'].'</td>

								<td>'.$record['cusine_qty'].'</td>

								<td>'.$obj->getCategoryListingOfCusine($record['cusine_id']).'</td>

								<td>'.$status.'</td>

								<td>'.date('d-M-Y H:ia',strtotime($record['cusine_add_date'])).'</td>

								<td>';

			if($edit_action)

			{			

			$option.='				<a href="edit_cusine.php?token='.base64_encode($record['cusine_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';

			}

			

			

			

			$option.='			</td>

								<td>';

								

			if($delete_action)

			{

			//$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['cusine_id'].'">';

			}					

			

			$option.='			</td>

							</tr>';

			$i++;

		}

	}

	else

	{

		$option.='			<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

elseif($action=='orderslist')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

		$txtsearch = trim($_POST['txtsearch']);

	}

	

	$status = '';

	if(isset($_POST['status']) && trim($_POST['status']) != '')

	{

		$status = trim($_POST['status']);

	}

	

	$item_id = '';

	if(isset($_POST['item_id']) && trim($_POST['item_id']) != '')

	{

		$item_id = trim($_POST['item_id']);

	}

	

	$vendor_id = $_SESSION['adm_vendor_id'];

		

	$customer_id = '';

	if(isset($_POST['customer_id']) && trim($_POST['customer_id']) != '')

	{

		$customer_id = trim($_POST['customer_id']);

	}

	

	$added_date_type = '';

	if(isset($_POST['added_date_type']) && trim($_POST['added_date_type']) != '')

	{

		$added_date_type = trim($_POST['added_date_type']);

	}

	

	$added_days_of_month = '';

	if(isset($_POST['added_days_of_month']) && trim($_POST['added_days_of_month']) != '')

	{

		$added_days_of_month = trim($_POST['added_days_of_month']);

	}

	

	$added_days_of_week = '';

	if(isset($_POST['added_days_of_week']) && trim($_POST['added_days_of_week']) != '')

	{

		$added_days_of_week = trim($_POST['added_days_of_week']);

	}

	

	$added_single_date = '';

	if(isset($_POST['added_single_date']) && trim($_POST['added_single_date']) != '')

	{

		$added_single_date = trim($_POST['added_single_date']);

	}

	

	$added_start_date = '';

	if(isset($_POST['added_start_date']) && trim($_POST['added_start_date']) != '')

	{

		$added_start_date = trim($_POST['added_start_date']);

	}

	

	$added_end_date = '';

	if(isset($_POST['added_end_date']) && trim($_POST['added_end_date']) != '')

	{

		$added_end_date = trim($_POST['added_end_date']);

	}

	

	$delivery_date_type = '';

	if(isset($_POST['delivery_date_type']) && trim($_POST['delivery_date_type']) != '')

	{

		$delivery_date_type = trim($_POST['delivery_date_type']);

	}



	$delivery_days_of_month = '';

	if(isset($_POST['delivery_days_of_month']) && trim($_POST['delivery_days_of_month']) != '')

	{

		$delivery_days_of_month = trim($_POST['delivery_days_of_month']);

	}



	$delivery_days_of_week = '';

	if(isset($_POST['delivery_days_of_week']) && trim($_POST['delivery_days_of_week']) != '')

	{

		$delivery_days_of_week = trim($_POST['delivery_days_of_week']);

	}



	$delivery_single_date = '';

	if(isset($_POST['delivery_single_date']) && trim($_POST['delivery_single_date']) != '')

	{

		$delivery_single_date = trim($_POST['delivery_single_date']);

	}



	$delivery_start_date = '';

	if(isset($_POST['delivery_start_date']) && trim($_POST['delivery_start_date']) != '')

	{

		$delivery_start_date = trim($_POST['delivery_start_date']);

	}



	$delivery_end_date = '';

	if(isset($_POST['delivery_end_date']) && trim($_POST['delivery_end_date']) != '')

	{

		$delivery_end_date = trim($_POST['delivery_end_date']);

	}

	

	$country_id = '';

	if(isset($_POST['country_id']) && trim($_POST['country_id']) != '')

	{

		$country_id = trim($_POST['country_id']);

	}

	

	$state_id = '';

	if(isset($_POST['state_id']) && trim($_POST['state_id']) != '')

	{

		$state_id = trim($_POST['state_id']);

	}

	

	$city_id = '';

	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')

	{

		$city_id = trim($_POST['city_id']);

	}

	

	$area_id = '';

	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')

	{

		$area_id = trim($_POST['area_id']);

	}

	

	$payment_status = '';

	if(isset($_POST['payment_status']) && trim($_POST['payment_status']) != '')

	{

		$payment_status = trim($_POST['payment_status']);

	}

	

	$orders = $obj->getAllOrders($txtsearch,$status,$item_id,$vendor_id,$customer_id,$added_date_type,$added_days_of_month,$added_days_of_week,$added_single_date,$added_start_date,$added_end_date,$country_id,$state_id,$city_id,$area_id,$payment_status,$delivery_date_type,$delivery_days_of_month,$delivery_days_of_week,$delivery_single_date,$delivery_start_date,$delivery_end_date);

   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($orders, $start, $records_per_page);

	$count = count($orders);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	/*

	$edit_action_id = '49';

	$delete_action_id = '50';	

	

	if($obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))

	{

		$edit_action = true;

	}	

	else

	{

		$edit_action = false;

	}

	

	if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))

	{

		$delete_action = true;

	}	

	else

	{

		$delete_action = false;

	}

	*/

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

							<tr>

								<th>Sr No</th>

								<th>Invoice</th>

								<th>User Name</th>

								<th>Email</th>

								<th>Mobile</th>

								<th>Delivery Location</th>

								<th>Order Amount</th>

								<th>Order Status</th>

								<th>Payment Status</th>

								<th>Order Date</th>

								<th>Delivery Date</th>

								<th>Action</th>';

	/*

	if($delete_action)

	{

	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultiplebannersliders();">';	

	}		

	*/

	

	$option.= '					

							</tr>

						</thead>

						<tbody>';

					

	if(is_array($data) && count($data) > 0)

	{

		foreach($data as $record)

		{

			$status = $obj->getOrderStatusString($record['order_status']);

			$payment_status = $obj->getPaymentStatusString($record['payment_status']);

			

			$location = '';

			if($record['user_area_name'] != '')

			{

				$location .= $record['user_area_name'].', ';

			}

			

			if($record['user_city_name'] != '')

			{

				$location .= $record['user_city_name'].', ';

			}

			

			if($record['user_state_name'] != '')

			{

				$location .= $record['user_state_name'].', ';

			}

			

			if($record['user_country_name'] != '')

			{

				$location .= $record['user_country_name'].', ';

			}

			

			$location = substr($location,0,-2);

			

			if($record['order_delivery_date'] != '0000-00-00')

			{

				$delivery_date = date('d-M-Y',strtotime($record['order_delivery_date']));

			}

			else

			{

				$delivery_date = '';

			}

            

			$option.='		<tr>

								<td>'.$i.'</td>

								<td>'.$record['invoice'].'-'.$vendor_id.'</td>

								<td>'.$record['user_name'].'</td>

								<td>'.$record['user_email'].'</td>

								<td>'.$record['user_mobile_no'].'</td>

								<td>'.$location.'</td>

								<td>'.$record['order_total_amt'].'</td>

								<td>'.$status.'</td>

								<td>'.$payment_status.'</td>

								<td>'.date('d-M-Y H:ia',strtotime($record['order_add_date'])).'</td>

								<td>'.$delivery_date.'</td>

								<td>';

			//if($edit_action)

		//	{			

			$option.='				<a href="view_order.php?invoice='.$record['invoice'].'" title="View Order"><i class="fa fa-eye"></i></a>&nbsp;';

			//}

			

			

			

			$option.='			</td>';

								

			/*					

			if($delete_action)

			{

			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['banner_id'].'">';

			}					

			*/

			$option.='			

							</tr>';

			$i++;

		}

	}

	else

	{

		$option.='			<tr><td colspan="12" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

elseif($action == 'getvendoroptionbyitemid')

{

	$item_id = trim($_REQUEST['item_id']);

	$vendor_id = trim($_REQUEST['vendor_id']);

	if(isset($_REQUEST['type']))

	{

		$type = trim($_REQUEST['type']);

	}

	else

	{

		$type = '';	

	}

	

	if(isset($_REQUEST['multiple']))

	{

		$multiple = trim($_REQUEST['multiple']);

	}

	else

	{

		$multiple = '';	

	}

	

	if($multiple == '1')

	{

		$arr_item_id = explode(',',$item_id);

		$arr_vendor_id = explode(',',$vendor_id);

	}

	else

	{

		$arr_item_id = $item_id;

		$arr_vendor_id = $vendor_id;

	}

	

    

	$data = $obj->getVendorOptionByItemId($arr_item_id,$arr_vendor_id,$type,$multiple);

    echo $data;

}

elseif($action == 'getorderdeliverydate')

{

	$invoice = trim($_REQUEST['invoice']);

	$data = $obj->getOrderDeliveryDateByInvoice($invoice);

	if($data == '' || $data == '0000-00-00')

	{

		$data = '';

	}

	else

	{

		$data = date('d-m-Y',strtotime($data));

	}

    echo $data;

}

elseif($action == 'getordercartitemslistofinvoice')

{

	$invoice = trim($_REQUEST['invoice']);

	$str_order_cart_id = trim($_REQUEST['str_order_cart_id']);

	$mode = trim($_REQUEST['mode']);

	if($str_order_cart_id == '' || $str_order_cart_id == ',')

	{

		$arr_order_cart_id = array();

	}

	else

	{

		$arr_order_cart_id = explode(',',$str_order_cart_id);

	}

	

	if($mode == '')

	{

		$mode = '0';

	}

	

	$output = $obj->getOrderCartItemsListOfInvoice($invoice,$arr_order_cart_id,$mode);

	echo $output;

}

elseif($action == 'getlogisticpartneroption')

{

	$vendor_cat_id = trim($_REQUEST['vendor_cat_id']);

	$type = trim($_REQUEST['type']);

	$vendor_id = '';

	$data = $obj->getLogisticPartnerOption($vendor_cat_id,$vendor_id,$type);

    echo $data;

}

elseif($action=='orderdeliverylist')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

		$txtsearch = trim($_POST['txtsearch']);

	}

	

	$delivery_status = '';

	if(isset($_POST['delivery_status']) && trim($_POST['delivery_status']) != '')

	{

		$delivery_status = trim($_POST['delivery_status']);

	}

	

	$delivery_date = '';

	if(isset($_POST['delivery_date']) && trim($_POST['delivery_date']) != '')

	{

		$delivery_date = trim($_POST['delivery_date']);

	}

	

	$logistic_partner_type_cat_id = '';

	if(isset($_POST['logistic_partner_type_cat_id']) && trim($_POST['logistic_partner_type_cat_id']) != '')

	{

		$logistic_partner_type_cat_id = trim($_POST['logistic_partner_type_cat_id']);

	}

	

	

	$logistic_partner_id = '';

	if(isset($_POST['logistic_partner_type_id']) && trim($_POST['logistic_partner_type_id']) != '')

	{

		$logistic_partner_type_id = trim($_POST['logistic_partner_type_id']);

	}

	

	//$logistic_partner_id = $_SESSION['adm_vendor_id'];

	

	$added_by_admin = '';

	/*

	if(isset($_POST['added_by_admin']) && trim($_POST['added_by_admin']) != '')

	{

		$added_by_admin = trim($_POST['added_by_admin']);

	}

	*/

	

	$added_date_type = '';

	if(isset($_POST['added_date_type']) && trim($_POST['added_date_type']) != '')

	{

		$added_date_type = trim($_POST['added_date_type']);

	}

	

	$added_days_of_month = '';

	if(isset($_POST['added_days_of_month']) && trim($_POST['added_days_of_month']) != '')

	{

		$added_days_of_month = trim($_POST['added_days_of_month']);

	}

	

	$added_days_of_week = '';

	if(isset($_POST['added_days_of_week']) && trim($_POST['added_days_of_week']) != '')

	{

		$added_days_of_week = trim($_POST['added_days_of_week']);

	}

	

	$added_single_date = '';

	if(isset($_POST['added_single_date']) && trim($_POST['added_single_date']) != '')

	{

		$added_single_date = trim($_POST['added_single_date']);

	}

	

	$added_start_date = '';

	if(isset($_POST['added_start_date']) && trim($_POST['added_start_date']) != '')

	{

		$added_start_date = trim($_POST['added_start_date']);

	}

	

	$added_end_date = '';

	if(isset($_POST['added_end_date']) && trim($_POST['added_end_date']) != '')

	{

		$added_end_date = trim($_POST['added_end_date']);

	}

	

	$item = $obj->getAllOrderDelivery($txtsearch,$delivery_status,$delivery_date,$logistic_partner_type_cat_id,$logistic_partner_id,$added_by_admin,$added_date_type,$added_days_of_month,$added_days_of_week,$added_single_date,$added_start_date,$added_end_date,$adm_vendor_id);

   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

	$count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	

	$edit_action_id = '69';

	$delete_action_id = '70';	

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$edit_action_id))

	{

		$edit_action = true;

	}	

	else

	{

		$edit_action = false;

	}

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

	{

		$delete_action = true;

	}	

	else

	{

		$delete_action = false;

	}

	

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

							<tr>

								<th>Sr No</th>

								<th>Deliver Date</th>

								<th>Client Name</th>

								<th>Order No</th>

								<th>Order Date</th>

								<th>Order Value</th>

								<th>Logistic Partner Name</th>

								<th>Delivery Person Name</th>

								<th>Receiver Name</th>

								<th>Receiver Name(Others)</th>

								<th>Proof of Delivery</th>

								<th>Delivery Location</th>

								<th>Status</th>

								<th>Added Date</th>

								<th>Action</th>

								<th>';

	if($delete_action)

	{

	//$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultipleorderdelivery();">';	

	}		

	

	

	$option.= '					</th>

							</tr>

						</thead>

						<tbody>';

					

	if(is_array($data) && count($data) > 0)

	{

		$record_count = 0;

		foreach($data as $record)

		{

			//echo '<br><pre>';

			//print_r($record);

			//echo '<br></pre>';

           	$status = $obj->getOrderDeiveryStatusString($record['delivery_status']);

           	$arr_order_detail = $obj->getOrderDetailsByInvoice($record['invoice']);

			if(count($arr_order_detail) > 0)

			{

				$record_count++;

				//echo '<br><pre>';

				//print_r($arr_order_detail);

				//echo '<br></pre>';

				

				$logistic_partner_name = $obj->getVendorName($record['logistic_partner_id']);;

				if($record['logistic_partner_type'] == '158')

				{

					if($logistic_partner_name == '')

					{

						$logistic_partner_name = 'Internal Logistic';	

					}

				}

				

				$proof_of_delivery = '';

				if($record['proof_of_delivery'] != '')

				{

					$file4 = substr($record['proof_of_delivery'], -4, 4);

					if(strtolower($file4) == '.pdf')

					{

						$proof_of_delivery = '<a target="_blank" href="'.SITE_URL.'/uploads/'.$record['proof_of_delivery'].'" >Pdf File</a>';

					}

					else

					{

						$proof_of_delivery = '<img border="0" src="'.SITE_URL.'/uploads/'.$record['proof_of_delivery'].'" width="50" >';

					}

					

				}

				

				$location = '';

				if($arr_order_detail['user_area_name'] != '')

				{

					$location .= $arr_order_detail['user_area_name'].', ';

				}

				

				if($arr_order_detail['user_city_name'] != '')

				{

					$location .= $arr_order_detail['user_city_name'].', ';

				}

				

				if($arr_order_detail['user_state_name'] != '')

				{

					$location .= $arr_order_detail['user_state_name'].', ';

				}

				

				if($arr_order_detail['user_country_name'] != '')

				{

					$location .= $arr_order_detail['user_country_name'].', ';

				}

				

				$location = substr($location,0,-2);

					

				

				$option.='		<tr>

									<td>'.$i.'</td>

									<td>'.date('d-M-Y',strtotime($record['delivery_date'])).'</td>

									<td>'.$arr_order_detail['user_name'].'</td>

									<td>'.$record['invoice'].'-'.$record['order_item_id'].'</td>

									<td>'.date('d-M-Y',strtotime($arr_order_detail['order_add_date'])).'</td>

									<td>Rs. '.$arr_order_detail['order_total_amt'].'</td>

									<td>'.$logistic_partner_name.'</td>

									<td>'.$record['delivery_person_name'].'</td>

									<td>'.$record['reciever_name'].'</td>

									<td>'.$record['other_reciever_name'].'</td>

									<td>'.$proof_of_delivery.'</td>

									<td>'.$location.'</td>

									<td>'.$status.'</td>

									<td>'.date('d-M-Y H:ia',strtotime($record['delivery_add_date'])).'</td>

									<td>';

				if($edit_action)

				{			

				//$option.='				<a href="edit_order_delivery.php?token='.base64_encode($record['od_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';

				}

				

				

				

				$option.='			</td>

									<td>';

									

				if($delete_action)

				{

				//$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['od_id'].'">';

				}					

				

				$option.='			</td>

								</tr>';	

			}

			

			$i++;

		}

		

		if($record_count == 0)

		{

			$option.='			<tr><td colspan="16" style="color:red;text-align:center">No record</d></tr>';	

		}

	}

	else

	{

		$option.='			<tr><td colspan="17" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

elseif($action == 'getingredientsbyingrdienttype')

{

	$ingredient_type = trim($_REQUEST['ingredient_type']);

	$ingredient_id = trim($_REQUEST['ingredient_id']);

	

	$arr_ingredient_type = explode(',',$ingredient_type);

	$arr_ingredient_id = explode(',',$ingredient_id);

	    

	$data = $obj->getIngredientsByIngrdientType($arr_ingredient_type,$arr_ingredient_id);

    echo $data;

}

elseif($action == 'getshippingappliedonoption')

{

	$sp_type = trim($_REQUEST['sp_type']);

	$type = trim($_REQUEST['type']);

	$sp_applied_on = '';

	$data = $obj->getShippingAppliedOnOption($sp_type,$sp_applied_on,$type);

    echo $data;

}

elseif($action == 'getcancellationappliedonoption')

{

	$cp_type = trim($_REQUEST['cp_type']);

	$type = trim($_REQUEST['type']);

	$cp_applied_on = '';

	$data = $obj->getCancellationAppliedOnOption($cp_type,$cp_applied_on,$type);

    echo $data;

}

elseif($action == 'getdiscountcouponappliedonoption')

{

	$dc_type = trim($_REQUEST['dc_type']);

	$type = trim($_REQUEST['type']);

	$dc_applied_on = '';

	$data = $obj->getDiscountCouponAppliedOnOption($dc_type,$dc_applied_on,$type);

    echo $data;

}

elseif($action=='ordercancellationlist')

{

	$admin_id = $_SESSION['admin_id'];

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

		$txtsearch = trim($_POST['txtsearch']);

	}

	

	$item_id = '';

	if(isset($_POST['item_id']) && trim($_POST['item_id']) != '')

	{

		$item_id = trim($_POST['item_id']);

	}

	

	$vendor_id = '';

	if(isset($_POST['vendor_id']) && trim($_POST['vendor_id']) != '')

	{

		$vendor_id = trim($_POST['vendor_id']);

	}

	

	$customer_id = '';

	if(isset($_POST['customer_id']) && trim($_POST['customer_id']) != '')

	{

		$customer_id = trim($_POST['customer_id']);

	}

	

	

	$added_single_date = '';

	if(isset($_POST['added_single_date']) && trim($_POST['added_single_date']) != '')

	{

		$added_single_date = trim($_POST['added_single_date']);

	}

	

	$added_start_date = '';

	if(isset($_POST['added_start_date']) && trim($_POST['added_start_date']) != '')

	{

		$added_start_date = trim($_POST['added_start_date']);

	}

	

	$cancel_request_date = '';

	if(isset($_POST['cancel_request_date']) && trim($_POST['cancel_request_date']) != '')

	{

		$cancel_request_date = trim($_POST['cancel_request_date']);

	}

	

	$country_id = '';

	if(isset($_POST['country_id']) && trim($_POST['country_id']) != '')

	{

		$country_id = trim($_POST['country_id']);

	}

	

	$state_id = '';

	if(isset($_POST['state_id']) && trim($_POST['state_id']) != '')

	{

		$state_id = trim($_POST['state_id']);

	}

	

	$city_id = '';

	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')

	{

		$city_id = trim($_POST['city_id']);

	}

	

	$area_id = '';

	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')

	{

		$area_id = trim($_POST['area_id']);

	}

	

	$orders = $obj->getAllCancellationOrders($txtsearch,$item_id,$vendor_id,$customer_id,$cancel_request_date,$country_id,$state_id,$city_id,$area_id);

   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($orders, $start, $records_per_page);

	$count = count($orders);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	/*

	$edit_action_id = '49';

	$delete_action_id = '50';	

	

	if($obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))

	{

		$edit_action = true;

	}	

	else

	{

		$edit_action = false;

	}

	

	if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))

	{

		$delete_action = true;

	}	

	else

	{

		$delete_action = false;

	}

	*/

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

							<tr>

								<th>Sr No</th>

								<th>Invoice</th>

								<th>User Name</th>

								<th>Email</th>

								<th>Mobile</th>

								<th>Cancellation Request Date</th>

								<th>Cancellation Process Date</th>

								<th>Order Date</th>

								<th>Cancellation Request By</th>

								<th>Action</th>';

	/*

	if($delete_action)

	{

	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultiplebannersliders();">';	

	}		

	*/

	

	$option.= '					

							</tr>

						</thead>

						<tbody>';

					

	if(is_array($data) && count($data) > 0)

	{

		foreach($data as $record)

		{

			if($record['cancel_request_date'] != '0000-00-00')

			{

				$cancel_request_date = date('d-M-Y H:ia',strtotime($record['cancel_request_date']));

			}

			else

			{

				$cancel_request_date = '';

			}

			

			if($record['cancel_process_date'] != '0000-00-00' && $record['cancel_process_date'] != '')

			{

				$cancel_process_date = date('d-M-Y H:ia',strtotime($record['cancel_process_date']));

			}

			else

			{

				$cancel_process_date = '';

			}

			

			if($record['cancel_request_by_admin'] == '1' )

			{

				$cancel_request_by = 'Admin('.$obj->getAdminUsername($record['cancel_request_by_admin_id']).')';

			}

			else

			{

				$cancel_request_by = 'User';

			}

			            

			$option.='		<tr>

								<td>'.$i.'</td>

								<td>'.$record['invoice'].'</td>

								<td>'.$record['user_name'].'</td>

								<td>'.$record['user_email'].'</td>

								<td>'.$record['user_mobile_no'].'</td>

								<td>'.$cancel_request_date.'</td>

								<td>'.$cancel_process_date.'</td>

								<td>'.date('d-M-Y H:ia',strtotime($record['order_add_date'])).'</td>

								<td>'.$cancel_request_by.'</td>

								<td>';

			//if($edit_action)

		//	{			

			$option.='				<a href="edit_order_cancellation.php?invoice='.$record['invoice'].'" title="View Cancel Request"><i class="fa fa-eye"></i></a>&nbsp;';

			//}

			

			

			

			$option.='			</td>';

								

			/*					

			if($delete_action)

			{

			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['banner_id'].'">';

			}					

			*/

			$option.='			

							</tr>';

			$i++;

		}

	}

	else

	{

		$option.='			<tr><td colspan="13" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

elseif($action == 'calculateitemcancellationcharge')

{

	$prod_subtotal = trim($_REQUEST['prod_subtotal']);

	$order_cart_id = trim($_REQUEST['order_cart_id']);

	$invoice = trim($_REQUEST['invoice']);

	$cp_id = trim($_REQUEST['cp_id']);

	

	$data = '';

	$arr_cp_record = $obj->getCancellationPriceDetails($cp_id);

	if(count($arr_cp_record) > 0)

	{

		if($arr_cp_record['cp_type'] == '1' )

		{

			$data = $prod_subtotal * $arr_cp_record['cp_percentage'] / 100;	

		}

		else

		{

			$data = $arr_cp_record['cancellation_price'];	

		}

	}

    echo $data;

}

elseif($action == 'calculatefinalcancellationcharge')

{

	$prod_subtotal = trim($_REQUEST['prod_subtotal']);

	$order_cart_id = trim($_REQUEST['order_cart_id']);

	$invoice = trim($_REQUEST['invoice']);

	$cp_id = trim($_REQUEST['cp_id']);

	$cp_sp_amount = trim($_REQUEST['cp_sp_amount']);

	$cp_tax_amount = trim($_REQUEST['cp_tax_amount']);

	

	$data = 0.00;

	

	if($cp_sp_amount == '')

	{

		$cp_sp_amount = 0.00;

	}

	

	if($cp_tax_amount == '')

	{

		$cp_tax_amount = 0.00;

	}

	

	$cp_id = substr($cp_id,0,-1);

	$order_cart_id = substr($order_cart_id,0,-1);

	$prod_subtotal = substr($prod_subtotal,0,-1);

	

	$arr_cp_id = explode(',',$cp_id);

	$arr_order_cart_id = explode(',',$order_cart_id);

	$arr_prod_subtotal = explode(',',$prod_subtotal);

	

	for($i=0;$i<count($arr_cp_id);$i++)

	{

		$arr_cp_record = $obj->getCancellationPriceDetails($arr_cp_id[$i]);

		if(count($arr_cp_record) > 0)

		{

			if($arr_cp_record['cp_type'] == '1' )

			{

				$data += ($arr_prod_subtotal[$i] * $arr_cp_record['cp_percentage'] / 100);	

			}

			else

			{

				$data += $arr_cp_record['cancellation_price'];	

			}

		}	

	}

	

	$data += $cp_sp_amount + $cp_tax_amount;

	

	

    echo 'Rs '.$data;

}

elseif($action == 'docancellationorder')

{

	$prod_subtotal = trim($_REQUEST['prod_subtotal']);

	$order_cart_id = trim($_REQUEST['order_cart_id']);

	$invoice = trim($_REQUEST['invoice']);

	$cp_id = trim($_REQUEST['cp_id']);

	$cp_sp_amount = trim($_REQUEST['cp_sp_amount']);

	$cp_tax_amount = trim($_REQUEST['cp_tax_amount']);

	$cancellation_note = trim($_REQUEST['cancellation_note']);

	

	$data = 0.00;

	

	if($cp_sp_amount == '')

	{

		$cp_sp_amount = 0.00;

	}

	

	if($cp_tax_amount == '')

	{

		$cp_tax_amount = 0.00;

	}

	

	$cp_id = substr($cp_id,0,-1);

	$order_cart_id = substr($order_cart_id,0,-1);

	$prod_subtotal = substr($prod_subtotal,0,-1);

	

	$strpos_cp_id = strpos($cp_id,',');

	if ($strpos_cp_id === false) 

	{

		$arr_cp_id = array($cp_id);

	}

	else

	{

		$arr_cp_id = explode(',',$cp_id);	

	}

	

	$strpos_oc_id = strpos($order_cart_id,',');

	if ($strpos_oc_id === false) 

	{

		$arr_order_cart_id = array($order_cart_id);

	}

	else

	{

		$arr_order_cart_id = explode(',',$order_cart_id);	

	}

	

	$strpos_st_id = strpos($prod_subtotal,',');

	if ($strpos_st_id === false) 

	{

		$arr_prod_subtotal = array($prod_subtotal);

	}

	else

	{

		$arr_prod_subtotal = explode(',',$prod_subtotal);

	}

	

	$error = '0';

	$err_msg = '';

	$url = '';

	

	$temp_cp_cnt = 0;

	for($i=0;$i<count($arr_cp_id);$i++)

	{

		if($arr_cp_id[$i] != '')

		{

			$temp_cp_cnt++;

		}			

	}

	

	if($temp_cp_cnt == 0)

	{

		$error = '1';

		$err_msg = 'Please select cancellation method';

	}

	

	if($error == '0')

	{

		$admin_id = $_SESSION['admin_id'];

		for($i=0;$i<count($arr_cp_id);$i++)

		{

			$arr_cp_record = $obj->getCancellationPriceDetails($arr_cp_id[$i]);

			if((count($arr_cp_record) > 0) && $arr_order_cart_id[$i] != '')

			{

				if($arr_cp_record['cp_type'] == '1' )

				{

					$cp_amount = ($arr_prod_subtotal[$i] * $arr_cp_record['cp_percentage'] / 100);	

				}

				else

				{

					$cp_amount = $arr_cp_record['cancellation_price'];	

				}

				

				$tdata = array();

				$tdata['order_cart_id'] = $arr_order_cart_id[$i];

				$tdata['cp_id'] = $arr_cp_id[$i];

				$tdata['cancellation_note'] = $cancellation_note;

				$tdata['cp_sp_amount'] = $cp_sp_amount;

				$tdata['cp_tax_amount'] = $cp_tax_amount;

				$tdata['cp_amount'] = $cp_amount;

				$tdata['invoice'] = $invoice;

				$tdata['prod_cancel_subtotal'] = $cp_amount;

				$tdata['cancel_process_date'] = date('Y-m-d H:i:s');

				$tdata['cancel_process_by_admin'] = $admin_id;

				$tdata['cancel_process_done'] = 1;

				

				$obj->doCancelProcess($tdata);

				

				$data += $cp_amount;

			}	

			

			

		}

		

		$url = SITE_URL.'/admin/manage_order_cancellations.php';

		$data += $cp_sp_amount + $cp_tax_amount;	

	}

	

	echo ' '.'::::'.$error.'::::'.$err_msg.'::::'.$url;

}

elseif($action=='shippingpriceslist')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

		$txtsearch = trim($_POST['txtsearch']);

	}

	

	$status = '';

	if(isset($_POST['status']) && trim($_POST['status']) != '')

	{

		$status = trim($_POST['status']);

	}

	

	$added_by_admin = '0';

	/*if(isset($_POST['added_by_admin']) && trim($_POST['added_by_admin']) != '')

	{

		$added_by_admin = trim($_POST['added_by_admin']);

	}*/

	

	$added_date_type = '';

	if(isset($_POST['added_date_type']) && trim($_POST['added_date_type']) != '')

	{

		$added_date_type = trim($_POST['added_date_type']);

	}

	

	$added_days_of_month = '';

	if(isset($_POST['added_days_of_month']) && trim($_POST['added_days_of_month']) != '')

	{

		$added_days_of_month = trim($_POST['added_days_of_month']);

	}

	

	$added_days_of_week = '';

	if(isset($_POST['added_days_of_week']) && trim($_POST['added_days_of_week']) != '')

	{

		$added_days_of_week = trim($_POST['added_days_of_week']);

	}

	

	$added_single_date = '';

	if(isset($_POST['added_single_date']) && trim($_POST['added_single_date']) != '')

	{

		$added_single_date = trim($_POST['added_single_date']);

	}

	

	$added_start_date = '';

	if(isset($_POST['added_start_date']) && trim($_POST['added_start_date']) != '')

	{

		$added_start_date = trim($_POST['added_start_date']);

	}

	

	$added_end_date = '';

	if(isset($_POST['added_end_date']) && trim($_POST['added_end_date']) != '')

	{

		$added_end_date = trim($_POST['added_end_date']);

	}

	

	$country_id = '';

	if(isset($_POST['country_id']) && trim($_POST['country_id']) != '')

	{

		$country_id = trim($_POST['country_id']);

	}

	

	$state_id = '';

	if(isset($_POST['state_id']) && trim($_POST['state_id']) != '')

	{

		$state_id = trim($_POST['state_id']);

	}

	

	$city_id = '';

	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')

	{

		$city_id = trim($_POST['city_id']);

	}

	

	$area_id = '';

	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')

	{

		$area_id = trim($_POST['area_id']);

	}

	

	$sp_type = '';

	if(isset($_POST['sp_type']) && trim($_POST['sp_type']) != '')

	{

		$sp_type = trim($_POST['sp_type']);

	}

	

	$sp_applied_on = '';

	if(isset($_POST['sp_applied_on']) && trim($_POST['sp_applied_on']) != '')

	{

		$sp_applied_on = trim($_POST['sp_applied_on']);

	}

	

	$sp_effective_date = '';

	if(isset($_POST['sp_effective_date']) && trim($_POST['sp_effective_date']) != '')

	{

		$sp_effective_date = trim($_POST['sp_effective_date']);

	}

	

	$item = $obj->getAllShippingPrices($txtsearch,$status,$added_by_admin,$added_date_type,$added_days_of_month,$added_days_of_week,$added_single_date,$added_start_date,$added_end_date,$country_id,$state_id,$city_id,$area_id,$sp_type,$sp_applied_on,$sp_effective_date);

   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

	$count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	

	$edit_action_id = '59';

	$delete_action_id = '60';	

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$edit_action_id))

	{

		$edit_action = true;

	}	

	else

	{

		$edit_action = false;

	}

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

	{

		$delete_action = true;

	}	

	else

	{

		$delete_action = false;

	}

	

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

							<tr>

								<th>Sr No</th>

								<th>Shipping Type</th>

								<th>Shipping Applied On</th>

								<th>Shipping Price</th>

								<th>Min-Max Order Amount/Qty</th>

								<th>Location</th>

								<th>Status</th>

								<th>Added Date</th>

								<th>Effective Date</th>

								<th>Action</th>

								<th>';

	if($delete_action)

	{

	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultipleshippingprices();">';	

	}		

	

	

	$option.= '					</th>

							</tr>

						</thead>

						<tbody>';

					

	if(is_array($data) && count($data) > 0)

	{

		foreach($data as $record)

		{

            if($record['sp_status'] == 1 )

			{

				$status = 'Active';

			}

			else

			{

				$status = 'InActive'; 

			}

			

			if($record['sp_effective_date'] != '0000-00-00')

			{

				$str_sp_effective_date = date('d-M-Y',strtotime($record['sp_effective_date']));

			}

			else

			{

				$str_sp_effective_date = '';

			}

			

			if($record['sp_type'] == '2')

			{

				$str_min_max_value = $record['sp_min_qty_val'].' '.$obj->getCategoryName($record['sp_min_qty_id']).' - '.$record['sp_max_qty_val'].' '.$obj->getCategoryName($record['sp_max_qty_id']);

				$str_sp_price = 'Rs '.$record['shipping_price'];

			}

			elseif($record['sp_type'] == '3')

			{

				$str_min_max_value = '';

				$str_sp_price = '';

			}

			else

			{

				if($record['sp_type'] == '1')

				{

					$str_sp_price = $record['sp_percentage'].' %';

				}

				else

				{

					$str_sp_price = 'Rs '.$record['shipping_price'];

				}

				$str_min_max_value = 'Rs '.$record['min_order_amount'].' - Rs '.$record['max_order_amount'];

			}

			

			$option.='		<tr>

								<td>'.$i.'</td>

								<td>'.$obj->getShippingTypeString($record['sp_type']).'</td>

								<td>'.$obj->getShippingAppliedOnString($record['sp_type'],$record['sp_applied_on']).'</td>

								<td>'.$str_sp_price.'</td>

								<td>'.$str_min_max_value.'</td>

								<td>'.$obj->getLocationStr($record['sp_country_id'],$record['sp_state_id'],$record['sp_city_id'],$record['sp_area_id']).'</td>

								<td>'.$status.'</td>

								<td>'.date('d-M-Y H:ia',strtotime($record['sp_add_date'])).'</td>

								<td>'.$str_sp_effective_date.'</td>

								<td>';

			if($edit_action)

			{			

			$option.='				<a href="edit_shipping_price.php?token='.base64_encode($record['sp_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';

			}

			

			

			

			$option.='			</td>

								<td>';

								

			if($delete_action)

			{

			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['sp_id'].'">';

			}					

			

			$option.='			</td>

							</tr>';

			$i++;

		}

	}

	else

	{

		$option.='			<tr><td colspan="12" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

elseif($action == 'deletemultipleshippingprices')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	

	$chkbox_records = trim($_POST['chkbox_records']);

	

    if($chkbox_records!='')

    {

		$delete_action_id = '60';	

		if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

		{

			$return = false;

			$arr_sp_id = explode(',',$chkbox_records);

			for($i=0; $i<count($arr_sp_id); $i++)

			{

				$tdata = array();

				$tdata['sp_id'] = $arr_sp_id[$i];

				$tdata['vendor_id'] = $adm_vendor_id;

				$tdata['deleted_by_admin'] = 0;

				if($obj->deleteShippingPrice($tdata))

				{

					$return = true;

				}

			}

			

			if($return)

			{

				$tdata = array();

				$response = array('status'=>1);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}

			else

			{

				$tdata = array();

				$response = array('status'=>0,'msg'=>'Error while deleting try again latar.');

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);  

			}

		}	

		else

		{

			$tdata = array();

			$response = array('status'=>0,'msg'=>'Sorry you dont have access.');

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);  

		}

    }

	else

	{

		$tdata = array();

		$response = array('status'=>0,'msg'=>'Please select any record.');

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);  

	}

}

elseif($action == 'generatediscountcoupon')

{

	$data = $obj->generateDiscountCoupon();

    echo $data;

}

elseif($action=='discountcouponslist')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

		$txtsearch = trim($_POST['txtsearch']);

	}

	

	$status = '';

	if(isset($_POST['status']) && trim($_POST['status']) != '')

	{

		$status = trim($_POST['status']);

	}

	

	$added_by_admin = '';

	//if(isset($_POST['added_by_admin']) && trim($_POST['added_by_admin']) != '')

	//{

	//	$added_by_admin = trim($_POST['added_by_admin']);

	//}

	

	$added_date_type = '';

	if(isset($_POST['added_date_type']) && trim($_POST['added_date_type']) != '')

	{

		$added_date_type = trim($_POST['added_date_type']);

	}

	

	$added_days_of_month = '';

	if(isset($_POST['added_days_of_month']) && trim($_POST['added_days_of_month']) != '')

	{

		$added_days_of_month = trim($_POST['added_days_of_month']);

	}

	

	$added_days_of_week = '';

	if(isset($_POST['added_days_of_week']) && trim($_POST['added_days_of_week']) != '')

	{

		$added_days_of_week = trim($_POST['added_days_of_week']);

	}

	

	$added_single_date = '';

	if(isset($_POST['added_single_date']) && trim($_POST['added_single_date']) != '')

	{

		$added_single_date = trim($_POST['added_single_date']);

	}

	

	$added_start_date = '';

	if(isset($_POST['added_start_date']) && trim($_POST['added_start_date']) != '')

	{

		$added_start_date = trim($_POST['added_start_date']);

	}

	

	$added_end_date = '';

	if(isset($_POST['added_end_date']) && trim($_POST['added_end_date']) != '')

	{

		$added_end_date = trim($_POST['added_end_date']);

	}

	

	$country_id = '';

	if(isset($_POST['country_id']) && trim($_POST['country_id']) != '')

	{

		$country_id = trim($_POST['country_id']);

	}

	

	$state_id = '';

	if(isset($_POST['state_id']) && trim($_POST['state_id']) != '')

	{

		$state_id = trim($_POST['state_id']);

	}

	

	$city_id = '';

	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')

	{

		$city_id = trim($_POST['city_id']);

	}

	

	$area_id = '';

	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')

	{

		$area_id = trim($_POST['area_id']);

	}

	

	$dc_type = '';

	if(isset($_POST['dc_type']) && trim($_POST['dc_type']) != '')

	{

		$dc_type = trim($_POST['dc_type']);

	}

	

	$dc_applied_on = '';

	if(isset($_POST['dc_applied_on']) && trim($_POST['dc_applied_on']) != '')

	{

		$dc_applied_on = trim($_POST['dc_applied_on']);

	}

	

	$dc_effective_date = '';

	if(isset($_POST['dc_effective_date']) && trim($_POST['dc_effective_date']) != '')

	{

		$dc_effective_date = trim($_POST['dc_effective_date']);

	}

	

	$item = $obj->getAllDiscountCoupons($txtsearch,$status,$added_by_admin,$added_date_type,$added_days_of_month,$added_days_of_week,$added_single_date,$added_start_date,$added_end_date,$country_id,$state_id,$city_id,$area_id,$dc_type,$dc_applied_on,$dc_effective_date,$adm_vendor_id);

	

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

	$count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	

	$edit_action_id = '86';

	$delete_action_id = '87';	

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$edit_action_id))

	{

		$edit_action = true;

	}	

	else

	{

		$edit_action = false;

	}

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

	{

		$delete_action = true;

	}	

	else

	{

		$delete_action = false;

	}

	

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

							<tr>

								<th>Sr No</th>

								<th>Discount Coupon</th>

								<th>Discount Type</th>

								<th>Discount Applied On</th>

								<th>Discount Price</th>

								<th>Min-Max Order Amount/Qty</th>

								<th>Location</th>

								<th>Status</th>

								<th>Added Date</th>

								<th>Action</th>

								<th>';

	if($delete_action)

	{

	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultiplediscountcoupons();">';	

	}		

	

	

	$option.= '					</th>

							</tr>

						</thead>

						<tbody>';

					

	if(is_array($data) && count($data) > 0)

	{

		foreach($data as $record)

		{

            if($record['dc_status'] == 1 )

			{

				$status = 'Active';

			}

			else

			{

				$status = 'InActive'; 

			}

			/*

			if($record['dc_from_effective_date'] != '0000-00-00' && $record['dc_from_effective_date'] != '')

			{

				$str_dc_effective_date = date('d/M/Y',strtotime($record['dc_from_effective_date']));

				if($record['dc_to_effective_date'] != '0000-00-00' && $record['dc_to_effective_date'] != '')

				{

					$str_dc_effective_date .= ' - '.date('d/M/Y',strtotime($record['dc_to_effective_date']));

				}

			}

			else

			{

				$str_dc_effective_date = '';

			}

			*/

			

			if($record['dc_type'] == '2')

			{

				$str_min_max_value = $record['dc_min_qty_val'].' '.$obj->getCategoryName($record['dc_min_qty_id']).' - '.$record['dc_max_qty_val'].' '.$obj->getCategoryName($record['dc_max_qty_id']);

				$str_dc_price = 'Rs '.$record['discount_price'];

			}

			elseif($record['dc_type'] == '3')

			{

				$str_min_max_value = '';

				$str_dc_price = '';

			}

			else

			{

				if($record['dc_type'] == '1')

				{

					$str_dc_price = $record['dc_percentage'].' %';

				}

				else

				{

					$str_dc_price = 'Rs '.$record['discount_price'];

				}

				$str_min_max_value = 'Rs '.$record['min_order_amount'].' - Rs '.$record['max_order_amount'];

			}

			

			$option.='		<tr>

								<td>'.$i.'</td>

								<td>'.$record['discount_coupon'].'</td>

								<td>'.$obj->getDiscountCouponTypeString($record['dc_type']).'</td>

								<td>'.$obj->getDiscountCouponAppliedOnString($record['dc_type'],$record['dc_applied_on']).'</td>

								<td>'.$str_dc_price.'</td>

								<td>'.$str_min_max_value.'</td>

								<td>'.$obj->getLocationStr($record['dc_country_id'],$record['dc_state_id'],$record['dc_city_id'],$record['dc_area_id']).'</td>

								<td>'.$status.'</td>

								<td>'.date('d-M-Y H:ia',strtotime($record['dc_add_date'])).'</td>

								<td>';

			if($edit_action)

			{			

			$option.='				<a href="edit_discount_coupon.php?token='.base64_encode($record['dc_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';

			}

			

			

			

			$option.='			</td>

								<td>';

								

			if($delete_action)

			{

			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['dc_id'].'">';

			}					

			

			$option.='			</td>

							</tr>';

			$i++;

		}

	}

	else

	{

		$option.='			<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

elseif($action == 'deletemultiplediscountcoupons')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	$chkbox_records = trim($_POST['chkbox_records']);

	 

    if($chkbox_records!='')

    {

		$delete_action_id = '87';	

		if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

		{

			$return = false;

			$arr_dc_id = explode(',',$chkbox_records);

			for($i=0; $i<count($arr_dc_id); $i++)

			{

				$tdata = array();

				$tdata['dc_id'] = $arr_dc_id[$i];

				$tdata['vendor_id'] = $adm_vendor_id;

				$tdata['deleted_by_admin'] = 0;

				if($obj->deleteDiscountCoupon($tdata))

				{

					$return = true;

				}

			}

			

			if($return)

			{

				$tdata = array();

				$response = array('status'=>1);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}

			else

			{

				$tdata = array();

				$response = array('status'=>0,'msg'=>'Error while deleting try again latar.');

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);  

			}

		}	

		else

		{

			$tdata = array();

			$response = array('status'=>0,'msg'=>'Sorry you dont have access.');

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);  

		}

    }

	else

	{

		$tdata = array();

		$response = array('status'=>0,'msg'=>'Please select any record.');

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);  

	}

}

elseif($action == 'doopenpopupitemnotavailable')

{

	$data = '<div style="width:580px;height:300px;overflow:auto;">';

	$data .= '	<p id="err_popup"></p>';

	$data .= '	<div class="form-group">';

	$data .= '		<label class="col-lg-3 control-label">Item Name<span style="color:red">*</span></label>';

	$data .= '		<div class="col-lg-9">';

	//$data .= '			<div class="pull-left">';

	$data .= '				<input type="text" name="new_item_name" id="new_item_name" placeholder="Item Name" value="" class="form-control" >';

	//$data .= '			</div>';

	$data .= '		</div>';

	$data .= '	</div>';

	$data .= '	<p>&nbsp;</p>';

	$data .= '	<div class="form-group">';

	$data .= '		<div class="col-lg-offset-3 col-lg-9">';

	$data .= '			<div class="pull-left">';

	$data .= '				<button class="btn btn-primary rounded" type="submit" name="btnSubmitpopup" id="btnSubmitpopup" onclick="sendNewItemNotificationToAdmin()">Submit</button>';

	$data .= '			</div>';

	$data .= '		</div>';

	$data .= '	</div>';

	$data .= '</div>';

    echo $data;

}

elseif($action == 'sendnewitemnotificationtoadmin')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	$item_name = trim($_POST['new_item_name']);

	 

    if($item_name!='')

    {

		if($obj->chkItemNameExists($item_name))

		{

			echo '<span style="color:#ff0000;">This Item Name is Already Exists</span>';

		}

		else

		{

			$tdata = array();

			$tdata['item_name'] = $item_name;

			$tdata['vendor_name'] = $obj->getVendorName($adm_vendor_id);

			$obj->sendNewItemToAddEmailToAdmin($tdata);

			echo '<span style="color:#00ff00;">Notification sent succcessfully. We will get back tou you soon.</span>';

		}			

	}

	else

	{

		echo '<span style="color:#ff0000;">Please enter item name</span>';

	}

}

elseif($action == 'getlocation')

{

    

    $response=array();

    $signup_city=$_REQUEST['city']!='' ? $_REQUEST['city'] : '';

    $city_id = $obj->getCityIdbyName($signup_city);

    

    if($city_id!='')

        {

            $response['place_option'] = $obj->getPlaceOptions($city_id);

            $response['error'] = 0;

        }

    echo json_encode(array($response));

    exit(0);    

  

}

elseif($action=='eventlist')

{

	if(!$obj->isVendorLoggedIn())

	{

		echo '';

		exit(0);

	}

	

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

	

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

		$txtsearch = trim($_POST['txtsearch']);

	}

	

	$status = '';

	if(isset($_POST['status']) && trim($_POST['status']) != '')

	{

		$status = trim($_POST['status']);

	}

	

	$cucat_parent_cat_id = '';

	if(isset($_POST['cucat_parent_cat_id']) && trim($_POST['cucat_parent_cat_id']) != '')

	{

		$cucat_parent_cat_id = trim($_POST['cucat_parent_cat_id']);

	}

	

	$cucat_cat_id = '';

	if(isset($_POST['cucat_cat_id']) && trim($_POST['cucat_cat_id']) != '')

	{

		$cucat_cat_id = trim($_POST['cucat_cat_id']);

	}

	

	$vendor_id = $_SESSION['adm_vendor_id'];

	$added_by_admin = '';

	

	

	$added_date_type = '';

	if(isset($_POST['added_date_type']) && trim($_POST['added_date_type']) != '')

	{

		$added_date_type = trim($_POST['added_date_type']);

	}

	

	$added_days_of_month = '';

	if(isset($_POST['added_days_of_month']) && trim($_POST['added_days_of_month']) != '')

	{

		$added_days_of_month = trim($_POST['added_days_of_month']);

	}

	

	$added_days_of_week = '';

	if(isset($_POST['added_days_of_week']) && trim($_POST['added_days_of_week']) != '')

	{

		$added_days_of_week = trim($_POST['added_days_of_week']);

	}

	

	$added_single_date = '';

	if(isset($_POST['added_single_date']) && trim($_POST['added_single_date']) != '')

	{

		$added_single_date = trim($_POST['added_single_date']);

	}

	

	$added_start_date = '';

	if(isset($_POST['added_start_date']) && trim($_POST['added_start_date']) != '')

	{

		$added_start_date = trim($_POST['added_start_date']);

	}

	

	$added_end_date = '';

	if(isset($_POST['added_end_date']) && trim($_POST['added_end_date']) != '')

	{

		$added_end_date = trim($_POST['added_end_date']);

	}

	

	$country_id = '';

	if(isset($_POST['country_id']) && trim($_POST['country_id']) != '')

	{

		$country_id = trim($_POST['country_id']);

	}

	

	$state_id = '';

	if(isset($_POST['state_id']) && trim($_POST['state_id']) != '')

	{

		$state_id = trim($_POST['state_id']);

	}

	

	$city_id = '';

	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')

	{

		$city_id = trim($_POST['city_id']);

	}

	

	$area_id = '';

	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')

	{

		$area_id = trim($_POST['area_id']);

	}

	

	$delivery_date = '';

	if(isset($_POST['delivery_date']) && trim($_POST['delivery_date']) != '')

	{

		$delivery_date = trim($_POST['delivery_date']);

	}

	

	$item = $obj->getAllEvents($txtsearch,$status,$cucat_parent_cat_id,$cucat_cat_id,$vendor_id,$added_by_admin,$added_date_type,$added_days_of_month,$added_days_of_week,$added_single_date,$added_start_date,$added_end_date,$country_id,$state_id,$city_id,$area_id,$delivery_date);

   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

    $count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	

	$edit_action_id = '22';

	$delete_action_id = '26';	

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$edit_action_id))

	{

		$edit_action = true;

	}	

	else

	{

		$edit_action = false;

	}

	

	if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$delete_action_id))

	{

		$delete_action = true;

	}	

	else

	{

		$delete_action = false;

	}

	

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

							<tr>

								<th>Sr No</th>';

                                                                $option.= '<th>Added by</th>

								<th>Added Date</th>

                                                                <th>Status</th>

								<th>Action</th>';

                                                                if($delete_action)



                                                                {



                                                                $option.= '<th><input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultiplevendors();"></th>';	



                                                                }

								$option.= '<th>Event Name</th>

								<th>Event Ref Numer</th>

                                                                 <th>Event Details</th>

								<th>Prof Cat 1</th>

                                                                <th>Fav Cat 1</th>

                                                                <th>Prof Cat 2</th>

                                                                <th>Fav Cat 2</th>

                                                                <th>Prof Cat 3</th>

                                                                <th>Fav Cat 3</th>

                                                                <th>Prof Cat 4</th>

                                                                <th>Fav Cat 4</th>

                                                                <th>Prof Cat 5</th>

                                                                <th>Fav Cat 5</th>

								<th>Organiser</th>

								<th>Institution</th>

								<th>Sponsor</th>';

                                                   

	

                                        $option.= '</tr>

						</thead>

						<tbody>';

					

	if(is_array($data) && count($data) > 0)

	{

		foreach($data as $record)

		{

                if($record['status'] == 1 )



			{



				$status = 'Active';



			}



			else



			{



				$status = 'InActive'; 



			}



			$option.='		<tr>

								<td>'.$i.'</td>

                                                                <td>'.$obj->getVendorName($record['posted_by']).'</td>

								<td>'.date("d-m-Y",strtotime($record['add_date'])).'</td>



								<td>'.$status.'</td>';



                                                                if($edit_action)



                                                                {			



                                                                $option.='<td><a href="edit_events.php?token='.base64_encode($record['event_master_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';

                                                                $option.='<a href="manage_event_locations.php?event_master_id='.base64_encode($record['event_master_id']).'" title="View Actions"><i class="fa fa-eye"></i></a>&nbsp;</td>';

                                                                }

                                                                if($delete_action)



                                                                {



                                                                $option.='<td><input type="checkbox" name="chkbox_records[]" value="'.$record['vendor_id'].'"></td>';



                                                                }



                                                                $option.='</td>';

								$option.='<td>'.$record['event_name'].'</td>



								<td>'.$record['reference_number'].'</td>

                                                                <td>'.$record['event_contents'].'</td>

								<td>'.$obj->getProfileCategoryName($record['prof_cat_id_1']).'</td>



								<td>'.$obj->getIdByProfileFavCategoryName($record['fav_cat_id_1']).'</td>

                                                                <td>'.$obj->getProfileCategoryName($record['prof_cat_id_2']).'</td>

								<td>'.$obj->getIdByProfileFavCategoryName($record['fav_cat_id_2']).'</td>

                                                                   

                                                                <td>'.$obj->getProfileCategoryName($record['prof_cat_id_3']).'</td>



								<td>'.$obj->getIdByProfileFavCategoryName($record['fav_cat_id_3']).'</td>

                                                                    

                                                                <td>'.$obj->getProfileCategoryName($record['prof_cat_id_4']).'</td>



								<td>'.$obj->getIdByProfileFavCategoryName($record['fav_cat_id_4']).'</td>

                                                                    

                                                                <td>'.$obj->getProfileCategoryName($record['prof_cat_id_5']).'</td>



								<td>'.$obj->getIdByProfileFavCategoryName($record['fav_cat_id_5']).'</td>



								<td>'.$obj->getVendorName($record['organiser_id']).'</td>

                                                                <td>'.$obj->getVendorName($record['institution_id']).'</td>

                                                                <td>'.$obj->getVendorName($record['sponsor_id']).'</td>

                                                                

								<td>';



			$option.='			</td>



							</tr>';

			$i++;

		}

	}

	else

	{

		$option.='			<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

elseif($action == 'FavcategoryByprofCatEvent')



{



$parent_cat_id = $_POST['parent_cat_id'];

//$va_cat_id='';    

//echo $obj->getSelectFieldCode('va_cat_id','va_cat_id',$obj->getFavCatBYProfileId($parent_cat_id),'form-control','','','','1');

$id_no = $_REQUEST['id_no'];

$id=isset($_REQUEST['id']);

        if($id!='')

        {

           $ids=$_REQUEST['id'];

        }

        

$sub_cat_id1 = $obj->getSelectedSubCatbyidVivek($ids); 



$sub_cat_id1_explode=  explode(',', $sub_cat_id1);



$data = $obj->getAllCategoryChkeckboxEvent($id_no,$parent_cat_id,$sub_cat_id1_explode,'0','300','200');	



echo $data;

	



}

elseif($action=='eventlocationlistprice')



{

	$admin_id = $_SESSION['adm_vendor_id'];

        //$event_master_id = 1;

        //echo $event_master_id;

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

            $txtsearch = trim($_POST['txtsearch']);

	}

	$status = '';

	if(isset($_POST['status']) && trim($_POST['status']) != '')

	{

		$status = trim($_POST['status']);

	}

        

	$city_id = '';



	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')



	{



		$city_id = trim($_POST['city_id']);



	}



	$area_id = '';



	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')



	{



		$area_id = trim($_POST['area_id']);



	}



	



	$added_by_admin = '';



	if(isset($_POST['added_by_admin']) && trim($_POST['added_by_admin']) != '')



	{



		$added_by_admin = trim($_POST['added_by_admin']);



	}



	//$event = $obj->getAllEventLocation($txtsearch,$status,$city_id,$area_id,$event_master_id);



        $event = $obj->GetAllEventDetails($txtsearch,$status,$city_id,$area_id,$admin_id);

        

	$option='';



	//start pagination for notification



    



    $adjacents = 1;



    $records_per_page = 40;



    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);



    $page = ($page == 0 ? 1 : $page);



    $start = ($page-1) * $records_per_page;



    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.







    $data = array_slice($event, $start, $records_per_page);

    

    //echo count($data);

    

    //print_r($data);



     $count = count($event);



	



    $next = $page + 1;    



    $prev = $page - 1;



    $last_page = ceil($count/$records_per_page);



    $second_last = $last_page - 1; 



    $pagination = '';



    



    if($last_page > 1)



	{



        $pagination .= '<div class="pagination">';



		if($page > 1)



		{



			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';



		}



		else



		{



			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   



		}



			



		if($last_page < 7 + ($adjacents * 2))



		{   



			for ($counter = 1; $counter <= $last_page; $counter++)



			{



				if ($counter == $page)



				{



					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



				}



				else



				{



					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



				}



			}



		}



		elseif($last_page > 5 + ($adjacents * 2))



		{



			if($page < 1 + ($adjacents * 2))



			{



				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)



				{



					if($counter == $page)



					{



						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



					}



					else



					{



						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



					}



				}



				$pagination.= '...';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   



			}



			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))



			{



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';



				$pagination.= '...';



				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)



				{



					if($counter == $page)



					{



						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



					}



					else



					{



						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



					}



				}



				$pagination.= '..';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   



			}



			else



			{



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';



				$pagination.= '..';



				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)



				{



					if($counter == $page)



					{



						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



					}



					else



					{



						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



					}



				}



			}



		}



		



		if($page < $counter - 1)



		{



			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';



		}



		else



		{



			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';



		}



		$pagination.= '</div>';       



    } 



	



	$edit_action_id = '29';

	$delete_action_id = '30';

        $add_action_id= '28';

        

        if($obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))



	{



		$add_action = true;



	}	



	else



	{



		$add_action = false;



	}

        

	if($obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))



	{



		$edit_action = true;



	}	



	else



	{



		$edit_action = false;



	}



	



	if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))



	{



		$delete_action = true;



	}	



	else



	{



		$delete_action = false;



	}



	$option.= '	<div class="table-responsive">



					<table id="datatable" class="table table-hover" >



						<thead>



							<tr>

								<th>Sr No</th>';

                                                                if($delete_action)

                                                                {

                                                                $option.= '<th><input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultiplevendors();"></th>';	



                                                                }

                                                                if($add_action)

                                                                {

                                                                    $option.= '<th>Action</th>';	

                                                                }

								$option.= '<th>Ref Number</th>

                                                                <th>Event Name</th>

								<th>Organiser Name</th>

								<th>Institution Name</th>

                                                                <th>Vanue</th>

                                                                <th>City</th>

                                                                <th>Start date</th>

                                                                <th>Start time</th>

                                                                <th>End date</th>

                                                                <th>End time</th>

                                                                <th>Added by</th>

                                                                <th>Added Date</th>

								<th>';

                                                            $option.= '</th>

							</tr>

						</thead>

						<tbody>';



	if(is_array($data) && count($data) > 0)



	{



		foreach($data as $record)



		{



            if($record['event_status'] == 1 )



			{



				$status = 'Active';



			}



			else



			{



				$status = 'InActive'; 



			}



			



			$option.='		<tr>



								<td>'.$i.'</td>';

                                                                if($delete_action)



                                                                {



                                                                    $option.='<td><input type="checkbox" name="chkbox_records[]" value="'.$record['event_id'].'"></td>';



                                                                }

                                                                if($add_action)



                                                                {

                                                                    

                                                                    if($obj->EventPriceLocationAvailable($record['event_id']))

                                                                    {

                                                                     $option.='<td><a href="'.$obj->getAdminActionLink($edit_action_id).'?event_id='.base64_encode($record['event_id']).'" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="'.$obj->getAdminActionName($edit_action_id).'" data-original-title=""><i class="fa fa-pencil"></i></a></td>';      

                                                                    }

                                                                    else

                                                                    {

                                                                     $option.='<td><a href="'.$obj->getAdminActionLink($add_action_id).'?event_id='.base64_encode($record['event_id']).'" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="'.$obj->getAdminActionName($add_action_id).'" data-original-title=""><i class="fa fa-plus"></i></a></td>';   

                                                                    }

                                                                }

                                                                $option.='<td>'.$record['reference_number'].'</td>

								<td>'.$record['event_name'].'</td>

                                                                <td>'.$obj->getVendorName($record['organiser_id']).'</td>

                                                                <td>'.$obj->getVendorName($record['institution_id']).'</td>

                                                                <td>'.$record['venue_details'].'</td>

                                                                <td>'.$obj->GetCityName($record['city_id']).'</td>

                                                                <td>'.$record['start_date'].'</td>

                                                                <td>'.$record['start_time'].'</td>

                                                                <td>'.$record['end_date'].'</td>

                                                                <td>'.$record['end_time'].'</td>

                                                                <td>'.$obj->getVendorName($record['posted_by']).'</td>

                                                                <td>'.$record['event_add_date'].'</td>

								<td>';



			$option.='			</td>



							</tr>';



			$i++;



		}



	}



	else



	{



		$option.='			<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';



	}



	



	$option.='			</tbody>



					</table>



				</div>';



	



	if(count($data)>0 && !empty($data))



	{



	  $option.= $pagination;



	}



	echo $option;

  

}



elseif($action=='eventlocationlist')



{

	$admin_id = $_SESSION['adm_vendor_id'];

        $event_master_id = $_POST['event_master_id'];

        //echo $event_master_id;

        //print_r($_REQUEST);

	$txtsearch = '';

	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')

	{

            $txtsearch = trim($_POST['txtsearch']);

	}

	$status = '';

	if(isset($_POST['status']) && trim($_POST['status']) != '')

	{

		$status = trim($_POST['status']);

	}

        

	$city_id = '';



	if(isset($_POST['city_id']) && trim($_POST['city_id']) != '')



	{



		$city_id = trim($_POST['city_id']);



	}



	$area_id = '';



	if(isset($_POST['area_id']) && trim($_POST['area_id']) != '')



	{



		$area_id = trim($_POST['area_id']);



	}



	



	$added_by_admin = '';



	if(isset($_POST['added_by_admin']) && trim($_POST['added_by_admin']) != '')



	{



		$added_by_admin = trim($_POST['added_by_admin']);



	}



	$event = $obj->getAllEventLocation($txtsearch,$status,$city_id,$area_id,$event_master_id);



        //print_r($event);

        

	$option='';



	//start pagination for notification



    



    $adjacents = 1;



    $records_per_page = 40;



    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);



    $page = ($page == 0 ? 1 : $page);



    $start = ($page-1) * $records_per_page;



    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.







    $data = array_slice($event, $start, $records_per_page);



    // print_r($data);

     $count = count($event);



	



    $next = $page + 1;    



    $prev = $page - 1;



    $last_page = ceil($count/$records_per_page);



    $second_last = $last_page - 1; 



    $pagination = '';



    



    if($last_page > 1)



	{



        $pagination .= '<div class="pagination">';



		if($page > 1)



		{



			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';



		}



		else



		{



			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   



		}



			



		if($last_page < 7 + ($adjacents * 2))



		{   



			for ($counter = 1; $counter <= $last_page; $counter++)



			{



				if ($counter == $page)



				{



					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



				}



				else



				{



					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



				}



			}



		}



		elseif($last_page > 5 + ($adjacents * 2))



		{



			if($page < 1 + ($adjacents * 2))



			{



				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)



				{



					if($counter == $page)



					{



						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



					}



					else



					{



						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



					}



				}



				$pagination.= '...';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   



			}



			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))



			{



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';



				$pagination.= '...';



				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)



				{



					if($counter == $page)



					{



						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



					}



					else



					{



						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



					}



				}



				$pagination.= '..';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   



			}



			else



			{



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';



				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';



				$pagination.= '..';



				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)



				{



					if($counter == $page)



					{



						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';



					}



					else



					{



						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     



					}



				}



			}



		}



		



		if($page < $counter - 1)



		{



			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';



		}



		else



		{



			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';



		}



		$pagination.= '</div>';       



    } 



	



	$edit_action_id = '22';

	$delete_action_id = '26';

	if($obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))



	{



		$edit_action = true;



	}	



	else



	{



		$edit_action = false;



	}



	



	if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))



	{



		$delete_action = true;



	}	



	else



	{



		$delete_action = false;



	}



	$option.= '	<div class="table-responsive">



					<table id="datatable" class="table table-hover" >



						<thead>



							<tr>

								<th>Sr No</th>';

                                                                if($delete_action)

                                                                {

                                                                $option.= '<th><input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deletemultiplevendors();"></th>';	



                                                                }

								$option.= '<th>location Category</th>

								<th>location Sub Category</th>

								<th>City</th>

                                                                <th>Area</th>

                                                                <th>Venue</th>

                                                                <th>Start date</th>

                                                                <th>Start time</th>

                                                                <th>End date</th>

                                                                <th>End time</th>

                                                                <th>Time zone_id</th>

                                                                <th>No of groups</th>

                                                                <th>No of teams</th>

								<th>No of participants</th>

								<th>No of judges</th>

								<th>Participants Gender</th>

                                                                <th>Participants special remark</th>

                                                                <th>Participants from age group</th>

                                                                <th>Participants to age group</th>

                                                                <th>Participants height</th>

                                                                <th>Participants weight</th>

                                                                <th>Judge gender</th>

                                                                <th>Judge special remark</th>

                                                                <th>Organiser facebook page</th>

                                                                <th>Organiser twitter page</th>

                                                                <th>Organiser instagram page</th>

                                                                <th>Organiser youtube channel</th>

                                                                <th>Organiser gender</th>

                                                                <th>Organiser contact person</th>

                                                                <th>Organiser Email</th>

                                                                <th>Organiser Contact Number</th>

                                                                <th>Organiser Designation</th>

                                                                <th>Organiser Remarks</th>

                                                                <th>Event add date</th>

								<th>';



                                                    $option.= '</th>



							</tr>



						</thead>



						<tbody>';



					



	if(is_array($data) && count($data) > 0)



	{



		foreach($data as $record)



		{

//echo 'hiiii';

            if($record['event_status'] == 1 )



			{



				$status = 'Active';



			}



			else



			{



				$status = 'InActive'; 



			}



			



			$option.='		<tr>



								<td>'.$i.'</td>';

                                                               if($delete_action)



                                                                {



                                                                $option.='<td><input type="checkbox" name="chkbox_records[]" value="'.$record['vendor_id'].'"></td>';



                                                                }

                                                                $option.='<td>'.$obj->getProfileCategoryName($record['location_category']).'</td>

								<td>'.$obj->getFavCatNameById($record['location_sub_category']).'</td>

                                                                <td>'.$obj->GetCityName($record['city_id']).'</td>

                                                                <td>'.$obj->getAreaName($record['area_id']).'</td>

                                                                <td>'.$record['venue_details'].'</td>

                                                                <td>'.$record['start_date'].'</td>

                                                                <td>'.$record['start_time'].'</td>

                                                                <td>'.$record['end_date'].'</td>

                                                                <td>'.$record['end_time'].'</td>

                                                                <td>'.$obj->getFavCatNameById($record['time_zone_id']).'</td>

                                                                <td>'.$record['no_of_groups'].'</td>

                                                                <td>'.$record['no_of_teams'].'</td>

                                                                <td>'.$record['no_of_participants'].'</td>

                                                                <td>'.$record['no_of_judges'].'</td>

                                                                <td>'.$record['participants_gender'].'</td>

                                                                <td>'.$record['participants_special_remark'].'</td>

                                                                <td>'.$record['participants_from_age_group'].'</td>

                                                                <td>'.$record['participants_to_age_group'].'</td>

                                                                <td>'.$record['participants_height'].'</td>

                                                                <td>'.$record['participants_weight'].'</td>

                                                                <td>'.$record['judge_gender'].'</td>

                                                                <td>'.$record['judge_special_remark'].'</td>

                                                                <td>'.$record['organiser_facebook_page'].'</td>

                                                                <td>'.$record['organiser_twitter_page'].'</td>

                                                                <td>'.$record['organiser_instagram_page'].'</td>

                                                                <td>'.$record['organiser_youtube_channel'].'</td>

                                                                <td>'.$record['organiser_gender'].'</td>

                                                                <td>'.$record['organiser_contact_person'].'</td>

                                                                <td>'.$record['organiser_email'].'</td>

                                                                <td>'.$record['organiser_contact_number'].'</td>

                                                                <td>'.$obj->getFavCatNameById($record['organiser_designation']).'</td>

                                                                <td>'.$record['organiser_remarks'].'</td>

                                                                <td>'.$record['event_add_date'].'</td>

								<td>';



			$option.='			</td>



							</tr>';



			$i++;



		}



	}



	else



	{



		$option.='			<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';



	}



	



	$option.='			</tbody>



					</table>



				</div>';



	



	if(count($data)>0 && !empty($data))



	{



	  $option.= $pagination;



	}



	echo $option;



}

elseif($action == 'getmaincategoryoptionnew')

{



	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

        if(isset($_REQUEST['type']))



	{



		$type = trim($_REQUEST['type']);



	}



	else



	{



		$type = '';	



	}



	



	if(isset($_REQUEST['multiple']))



	{



		$multiple = trim($_REQUEST['multiple']);



	}



	else



	{



		$multiple = '';	



	}



	



	if($multiple == '1')



	{



		$strpos_pc = strpos($parent_cat_id,',');



		if($strpos_pc === false)



		{



			$arr_parent_cat_id = array($parent_cat_id);



		}



		else



		{



			$arr_parent_cat_id = explode(',',$parent_cat_id);		



		}



		$cat_id = array();



	}



	else



	{



		$arr_parent_cat_id = $parent_cat_id;



		$cat_id = '';



	}

	$data = $obj->getMainCategoryOption($arr_parent_cat_id,$cat_id,$type,$multiple);



    echo $data;



}

elseif($action == 'FavcategoryByprofCatEventSingle')



{



$parent_cat_id = $_POST['parent_cat_id'];

$id_no = $_REQUEST['id_no'];

$data = $obj->getAllCategoryOptionEvent($id_no,$parent_cat_id);	

echo $data;

	

}

elseif($action == 'getmaincategoryoptionloc')

{

	$parent_cat_id = trim($_REQUEST['parent_cat_id']);

	if(isset($_REQUEST['type']))

	{

		$type = trim($_REQUEST['type']);

	}

	else

	{

		$type = '';	

	}

	

	if(isset($_REQUEST['multiple']))

	{

		$multiple = trim($_REQUEST['multiple']);

	}

	else

	{

		$multiple = '';	

	}

	

	if($multiple == '1')

	{

		$strpos_pc = strpos($parent_cat_id,',');

		if($strpos_pc === false)

		{

			$arr_parent_cat_id = array($parent_cat_id);

		}

		else

		{

			$arr_parent_cat_id = explode(',',$parent_cat_id);		

		}

		$cat_id = array();

	}

	else

	{

		$arr_parent_cat_id = $parent_cat_id;

		$cat_id = '';

	}

	

	if(isset($_REQUEST['default_cat_id']))

	{

		$default_cat_id = trim($_REQUEST['default_cat_id']);

	}

	else

	{

		$default_cat_id = '';	

	}

    

	$data = $obj->getMainCategoryOptionLOC($arr_parent_cat_id,$cat_id,$type,$multiple,$default_cat_id);

    echo $data;

}

elseif($action=='myreferral')

{

	

if(isset($_POST['user_id']))	

{

	$user_id = strip_tags(trim($_POST['user_id']));

}

elseif(isset($_SESSION['user_ref_user_id']))	

{

	$user_id = $_SESSION['user_ref_user_id'];

}

else

{

	$user_id = '';

}



if(isset($_POST['status']))	

{

	$status = strip_tags(trim($_POST['status']));

}

elseif(isset($_SESSION['user_ref_status']))	

{

	$status = $_SESSION['user_ref_status'];

}

else

{

	$status = '';

}



if(isset($_POST['invite_start_date']))	

{

	$invite_start_date = strip_tags(trim($_POST['invite_start_date']));

}

elseif(isset($_SESSION['user_ref_invite_start_date']))	

{

	$invite_start_date = $_SESSION['user_ref_invite_start_date'];

}

else

{

	$invite_start_date = '';

}



if(isset($_POST['invite_end_date']))	

{

	$invite_end_date = strip_tags(trim($_POST['invite_end_date']));

}

elseif(isset($_SESSION['user_ref_invite_end_date']))	

{

	$invite_end_date = $_SESSION['user_ref_invite_end_date'];

}

else

{

	$invite_end_date = '';

}



if(isset($_POST['status_start_date']))	

{

	$status_start_date = strip_tags(trim($_POST['status_start_date']));

}

elseif(isset($_SESSION['user_ref_status_start_date']))	

{

	$status_start_date = $_SESSION['user_ref_status_start_date'];

}

else

{

	$status_start_date = '';

}



if(isset($_POST['status_end_date']))	

{

	$status_end_date = strip_tags(trim($_POST['status_end_date']));

}

elseif(isset($_SESSION['user_ref_status_end_date']))	

{

	$status_end_date = $_SESSION['user_ref_status_end_date'];

}

else

{

	$status_end_date = '';

}

    

	$pro_user_id = $_SESSION['adm_vendor_id'];

	

	$item = $obj->getAllAdviserUserReferrals($pro_user_id,$user_id,$status,$invite_start_date,$invite_end_date,$status_start_date,$status_end_date);

   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

    $count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	$edit_action_id = '22';

	$delete_action_id = '26';

	$option.= '	<div class="table-responsive">

					<table id="datatable" class="table table-hover" >

						<thead>

                                                    <tr>

                                                        <th>Sr No</th>';

                                                        $option.= '<th>Email id</th>

                                                        <th>Name</th>

                                                        <th>Message</th>

                                                        <th>Invitation Sent By</th>';

                                                        $option.= '<th>Invitation Sent Date</th>

                                                        <th>Accepted Date</th>

                                                        <th>Status</th>

                                                        <th>Action</th>';

                                        $option.= '</tr>

						</thead>

						<tbody>';

	if(is_array($data) && count($data) > 0)
        {
        $i=1;
        foreach($data as $record){
            if($record['last_status_updated_by_adviser'] == '1'){
                $status_by = ' By Me';
            }else{
                $status_by = ' By User';
            }
            $action_btn = '';
            if($record['invite_by_user'] == '1'){
                $invite_str = 'Sent By User';
                $email = $obj->getUserEmailById($record['user_id']);
                $name = $obj->getUserFullNameById($record['user_id']);
                $uid = $record['user_id'];
            }else{
                $invite_str = 'Sent By Me';
                $email = $record['user_email'];
                $name = $record['user_name'];
                $uid = $obj->getUserId($email);
            }
            if($record['new_user'] == '1'){
                if($record['referral_status'] == '1'){
                    if($record['request_status'] == '1'){
                            $temp_status = 'Accepted'.$status_by;
                            $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                        }
                    elseif($record['request_status'] == '2'){
                        $temp_status = 'Declined'.$status_by;
                        $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                    }
                    elseif($record['request_status'] == '3'){
						$temp_status = 'Deactivated'.$status_by;
						$action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';

					}else 
						{

                                                    $temp_status = 'Pending (User Registered)';

                                                    if($record['invite_by_user'] == '1')

                                                    {

                                                        $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="doAcceptUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';

                                                        $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';

                                                    }

                                                }



                                                $accept_date = $obj->getUserRegistrationDateByEmail($record['user_email']);

                                            }

                                            else 

                                            {

                                                $temp_status = 'Pending (User not Registered)';

                                                $accept_date = '';

                                                

                                                if($record['invite_by_user'] == '1')

                                                {

                                                    $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="doAcceptUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';

                                                    $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';

                                                }

                                            }

                                        }

                                        else

                                        {
                                        	
                                            if($record['request_status'] == '1')

                                            {

                                                $temp_status = 'Accepted'.$status_by;

                                                $time = strtotime($record['request_accept_date']);

                                                // $time = $time + 19800;

                                               

                                                $accept_date = date('d/m/Y h:i A',$time);

                                                 // echo "<pre>";print_r($accept_date);echo "</pre>";

                                                 // exit;

                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';

                                            }

                                            elseif($record['request_status'] == '2')

                                            {

                                                $temp_status = 'Declined'.$status_by;

                                                $time = strtotime($record['request_accept_date']);

                                                $time = $time + 19800;

                                                $accept_date = date('d/m/Y h:i A',$time);

                                                

                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';

                                            }

                                            elseif($record['request_status'] == '3')

                                            {

                                                $temp_status = 'Deactivated'.$status_by;

                                                $time = strtotime($record['request_accept_date']);

                                                $time = $time + 19800;

                                                $accept_date = date('d/m/Y h:i A',$time);

                                                

                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';

                                            }

                                            else 

                                            {

                                                $temp_status = 'Pending';

                                                $accept_date = '';

                                                

                                                if($record['invite_by_user'] == '1')

                                                {

                                                    $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="doAcceptUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';

                                                    $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';

                                                }

                                            }

                                        } 

                                        $option .= '<tr>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$i.'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$email.'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$name.'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$record['message'].'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$invite_str.'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.date('d/m/Y h:i:s A',strtotime($record['request_sent_date'])).'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$accept_date.'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$temp_status.'</td>

                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$action_btn.'</td>



                                        </tr>';

                                        $i++;  

                                    }

    }

	else

	{

		$option.='			<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}



elseif($action=='myuserquery')

{

	

if(isset($_POST['user_id']))	



{



	$user_id = strip_tags(trim($_POST['user_id']));



}



elseif(isset($_SESSION['user_query_user_id']))	



{



	$user_id = $_SESSION['user_query_user_id'];



}



else



{



	$user_id = '';



}







if(isset($_POST['pg_id']))	



{



	$pg_id = strip_tags(trim($_POST['pg_id']));



}



elseif(isset($_SESSION['user_query_pg_id']))	



{



	$pg_id = $_SESSION['user_query_pg_id'];



}



else



{



	$pg_id = '';



}







if(isset($_POST['start_date']))	



{



	$start_date = strip_tags(trim($_POST['start_date']));



}



elseif(isset($_SESSION['user_query_start_date']))	



{



	$start_date = $_SESSION['user_query_start_date'];



}



else



{



	$start_date = '';



}







if(isset($_POST['end_date']))	



{



	$end_date = strip_tags(trim($_POST['end_date']));



}



elseif(isset($_SESSION['user_query_end_date']))	



{



	$end_date = $_SESSION['user_query_end_date'];



}



else



{



	$end_date = '';



}







if(isset($_POST['search_keywords']))	



{



	$search_keywords = strip_tags(trim($_POST['search_keywords']));



}



elseif(isset($_SESSION['user_query_search_keywords']))	



{



	$search_keywords = $_SESSION['user_query_search_keywords'];



}



else



{



	$search_keywords = '';



}







$_SESSION['user_query_user_id'] = $user_id;



$_SESSION['user_query_pg_id'] = $pg_id;



$_SESSION['user_query_start_date'] = $start_date;



$_SESSION['user_query_end_date'] = $end_date;



$_SESSION['user_query_search_keywords'] = $search_keywords;







if($start_date == '' || $end_date == '')



{

    $start_date = '2019-02-01';

    $end_date ='2019-02-07';





}

    

	$pro_user_id = $_SESSION['adm_vendor_id'];

	

	$item = $obj->getAllAdviserUserQueries($pro_user_id,$user_id,$pg_id,$start_date,$end_date,$search_keywords);

        

//        echo '<pre>';

//        print_r($item);

//        echo '</pre>';

        

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

    $count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	$edit_action_id = '22';

	$delete_action_id = '26';

//	$option.= '	<div class="table-responsive">

//					<table id="datatable" class="table table-hover" >

//						<thead>

//                                                    <tr>

//                                                        <th>Sr No</th>';

//                                                        $option.= '<th>Email id</th>

//                                                        <th>Name</th>

//                                                        <th>Message</th>

//                                                        <th>Invitation Sent By</th>';

//                                                        $option.= '<th>Invitation Sent Date</th>

//                                                        <th>Accepted Date</th>

//                                                        <th>Status</th>

//                                                        <th>Action</th>';

//                                        $option.= '</tr>

//						</thead>

//						<tbody>';

	if(is_array($data) && count($data) > 0)

	{

            

         if(count($data) > 0)



                                            {



                                                    $arr_temp_user_id = array();



                                                    foreach($data as $record) 



                                                    {



                                                            array_push($arr_temp_user_id,$record['user_id']);



                                                    }



                                                    $arr_temp_user = array_unique($arr_temp_user_id);



                                                    $arr_temp_user = array_values($arr_temp_user);







                                                    for($k=0;$k<count($arr_temp_user);$k++)



                                                    {







                                                        $request_status = $obj->chkIfUserIsAdvisersReferrals($pro_user_id,$arr_temp_user[$k]);



                                                            if($request_status)



                                                            {



                                                                    $adviser_status = '<span class="Header_blue">Activated By User</span>';



                                                            }



                                                            else



                                                            {



                                                                    $adviser_status = '<span class="Header_red">Deactivated By User</span>';



                                                            }	



            $option.= '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                    <td width="20%" align="left" valign="middle"><strong>User Name: '.$obj->getUserFullNameById($arr_temp_user[$k]).'</strong></td>

                    <td width="20%" align="left" valign="middle"><strong>Status: '.$adviser_status.'</strong></td>

                </tr>

            </table>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                    <td height="30">&nbsp;</td>

                </tr>

            </table>



            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">



                <tr>



                    <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>



                    <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Query / Guidance ID</strong></td>



                    <td width="20%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Reference</strong></td>



                    <td width="45%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Queries & related Guidance</strong></td>



                    <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>



                    <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>&nbsp;</strong></td>



                </tr>';



            



            $i=1;



            foreach($data as $record) 



            {



                                                             if($record['user_id'] == $arr_temp_user[$k])



                                                             {



                                                                    $time = strtotime($record['aq_add_date']);



                                                                    $time = $time + 19800;



                                                                    $date = date('d-M-Y h:i A',$time);



                                                                    $pg_name = $obj->getReportTypeName($record['page_id']);







                                                                    if($record['page_id'] > 0)



                                                                    {



                                                                            if($record['permission_type'] == '1')



                                                                            {

                                                                                    $pg_name .= ' (Adviser Set)';	

                                                                            }



                                                                            else



                                                                            {

                                                                                    $pg_name .= ' (Standard Set)';

                                                                            }



                                                                    }







                                                                    if($record['pro_user_read'] == '1')



                                                                    {



                                                                            $td_class = 'qryread';



                                                                            $td_title = 'Make Unread';



                                                                            $toggle_action = 'unread';



                                                                    }



                                                                    else



                                                                    {



                                                                            $td_class = 'qryunread';



                                                                            $td_title = 'Make Read';



                                                                            $toggle_action = 'read';



                                                                    }







                 $option.= '<tr onmouseover="showRoundIcon('.$record['aq_id'].')" onmouseout="hideRoundIcon('.$record['aq_id'].')">



                    <td id="td1id_'.$record['aq_id'].'" height="30" align="center" valign="middle" class="'.$td_class.'">



                            <div style="float:left;width:70px;">



                            <div style="float:left;width:5px;">



                                    <input type="hidden" name="hdntoggle_action" id="hdntoggle_action_'.$record['aq_id'].'" value="'.$toggle_action.'"  />



                                <div style="display:none;" id="roundicon_'.$record['aq_id'].'" class="roundicon" title="'.$td_title.'" onclick="toggleReadUnreadQuery('.$record['aq_id'].')" ></div>



                            </div>    



                            <div style="float:right;width:60px;">'.$i.'</div>



                        </div>



                    </td>



                    <td id="td2id_'.$record['aq_id'].'" height="30" align="center" valign="middle" class="'.$td_class.'">'.$record['aq_user_unique_id'].'</td>



                    <td id="td3id_'.$record['aq_id'].'" height="30" align="center" valign="middle" class="'.$td_class.'">'.$pg_name.'</td>



                    <td id="td4id_'.$record['aq_id'].'" height="30" align="center" valign="middle" class="'.$td_class.'">'.$record['query'].'</td>



                    <td id="td5id_'.$record['aq_id'].'" height="30" align="center" valign="middle" class="'.$td_class.'">'.$date.'</td>



                    <td id="td6id_'.$record['aq_id'].'" height="30" align="center" valign="middle" class="'.$td_class.'">';

                 

                       if($record['from_user'] == '1'  && $request_status) {



                                                                    $option.= '<input class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showUserQueryPopup('.$record['aq_id'].' )"/>'; 

                                                                    

                       }

                                                                   $option.= ' </td>



                </tr>';



                                                   



                                                    $all_queries_data =	$obj->getAllAdviserQueriesByID($record['aq_id']);







                                                    if(count($all_queries_data) > 0)



                                                    { 



                                                            $l=1;



                                                            foreach($all_queries_data as $record2)



                                                            { 







                                                                    if($record2['aq_id'] != $record['aq_id'])



                                                                    {	











                                                                            $time = strtotime($record2['aq_add_date']);



                                                                            $time = $time + 19800;



                                                                            $date = date('d-M-Y h:i A',$time);











                                                                            $pg_name = $obj->getReportTypeName($record2['page_id']);



                                                                            if($record2['page_id'] > 0)



                                                                            {



                                                                                    if($record2['permission_type'] == '1')



                                                                                    {



                                                                                            $pg_name .= ' (Adviser Set)';	



                                                                                    }



                                                                                    else



                                                                                    {



                                                                                            $pg_name .= ' (Standard Set)';



                                                                                    }



                                                                            }



                                                                            if($record2['user_read'] == '1')



                                                                            {



                                                                                    $td_class = 'qryread';



                                                                                    $td_title = 'Make Unread';



                                                                                    $toggle_action = 'unread';



                                                                            }



                                                                            else



                                                                            {



                                                                                    $td_class = 'qryunread';



                                                                                    $td_title = 'Make Read';



                                                                                    $toggle_action = 'read';



                                                                            }



                                           $option.= ' <tr onmouseover="showRoundIcon('.$record2['aq_id'].')" onmouseout="hideRoundIcon('.$record2['aq_id'].')"> 



                                                    <td id="td1id_'.$record2['aq_id'].'"  align="center" valign="top" class="'.$td_class.'">



                                                            <div style="float:left;width:70px;">



                                                                    <div style="float:left;width:5px;">



                                                                            <input type="hidden" name="hdntoggle_action" id="hdntoggle_action_'.$record2['aq_id'].'" value="'.$toggle_action.'"  />



                                                                            <div style="display:none;" id="roundicon_'.$record2['aq_id'].'" class="roundicon" title="'.$td_title.'" onclick="toggleReadUnreadQuery('.$record2['aq_id'].')" ></div>



                                                                    </div>    



                                                                    <div style="float:right;width:60px;">&nbsp;</div>



                                                            </div>



                                                    </td>



                                                    <td id="td2id_'.$record2['aq_id'].'" align="center" valign="top" class="'.$td_class.'">'.$record2['aq_user_unique_id'].'</td>



                                                    <td id="td3id_'.$record2['aq_id'].'" align="center" valign="top" class="'.$td_class.'">'.$pg_name.'</td>



                                                    <td id="td4id_'.$record2['aq_id'].'" align="center" valign="top" class="'.$td_class.'">'.$record2['query'].'</td>



                                                    <td id="td5id_'.$record2['aq_id'].'" align="center" valign="top" class="'.$td_class.'">'.$date.'</td>

                                                    <td id="td6id_'.$record2['aq_id'].'" align="center" valign="top" class="'.$td_class.'">';

                                           if($record2['from_user'] == '1'  && $request_status) {



                                                                    $option.= '<input class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showUserQueryPopup('.$record2['aq_id'].' )"/>';

                                                                    

                                                                    

                                           }

                                                                    $option.= '</td>

                                            </tr>';



                                                                }



                                                            }



                                                            $l++;



                                                    } 



                                                            $i++;  



                                                            }	



                                                    } 



            $option.= '</table>



            <table width="100%" border="0" cellpadding="0" cellspacing="0">



                    <tr>



                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>



                    </tr>



            </table>';



         }	



        }    

            

        

	}

	else

	{

		$option.='<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}



elseif($action=='useraccesslog')

{
// print_r($_REQUEST);	


if(isset($_POST['user_id']))	

{

	$user_id = strip_tags(trim($_POST['user_id']));

}

elseif(isset($_REQUEST['id']))	

{

	$user_id = trim($_REQUEST['id']);

}

elseif(isset($_SESSION['user_invitation_user_id']))	

{

	$user_id = $_SESSION['user_invitation_user_id'];

}

else

{

	$user_id = '';

}





//$referral_data = getAllMyUserInvitations($user_email,$user_id);

    

	$pro_user_id = $_SESSION['adm_vendor_id'];

        

	//$user_email = $obj->getProUserEmailById($pro_user_id);

        

	$item = $obj->getAllMyUserInvitations($pro_user_id,$user_id);
    
   

	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item, $start, $records_per_page);

    $count = count($item);

	

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	$edit_action_id = '22';

	$delete_action_id = '26';

//	$option.= '	<div class="table-responsive">

//					<table id="datatable" class="table table-hover" >

//						<thead>

//                                                    <tr>

//                                                        <th>Sr No</th>';

//                                                        $option.= '<th>Email id</th>

//                                                        <th>Name</th>

//                                                        <th>Message</th>

//                                                        <th>Invitation Sent By</th>';

//                                                        $option.= '<th>Invitation Sent Date</th>

//                                                        <th>Accepted Date</th>

//                                                        <th>Status</th>

//                                                        <th>Action</th>';

//                                        $option.= '</tr>

//						</thead>

//						<tbody>';

	if(is_array($data) && count($data) > 0)

	{

            

         if(count($data) > 0)

         {

                                          

          foreach($data as $record) 

                                    {

                                        $i =1;

											

					if($record['last_status_updated_by_adviser'] == '1')

                                        {

                                            $status_by = 'By Me';

                                        }

                                        else

                                        {

                                            $status_by = 'By User';

                                        }

                                        

                                        if($record['invite_by_user'] == '1')

                                        {

                                            $uid = $record['user_id'];

                                        }

                                        else

                                        {

                                            $uid = $obj->getUserId($record['user_email']);

                                        }

											

                                        if($record['request_status'] == '1')

                                        {

                                                $temp_status = 'Accepted'.$status_by;

                                                $main_temp_status = 'Accepted'.$status_by;

                                                $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Deactivate" onclick="showDeactivateUserInvitationPopup(\''.$record['ar_id'].'\',\''.$uid.'\')">';





                                                $time = strtotime($record['request_accept_date']);

                                                $time = $time + 19800;

                                                $request_accept_date = date('d/m/Y h:i A',$time);

                                        }

                                        elseif($record['request_status'] == '2')

                                        {

                                                $temp_status = 'Declined'.$status_by;

                                                $main_temp_status = 'Declined'.$status_by;

                                                $action = '';

                                                $main_action = '';

                                                $action2 = '';





                                                $time = strtotime($record['request_accept_date']);

                                                $time = $time + 19800;

                                                $request_accept_date = date('d/m/Y h:i A',$time);

                                        }

                                        elseif($record['request_status'] == '3')

                                        {

                                                $temp_status = 'Deactivated'.$status_by;

                                                $main_temp_status = 'Deactivated'.$status_by;

                                                $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Activate" onclick="showActivateUserInvitationPopup(\''.$record['ar_id'].'\',\''.$uid.'\')">';





                                                $time = strtotime($record['request_accept_date']);

                                                $time = $time + 19800;

                                                $request_accept_date = date('d/m/Y h:i A',$time);



                                                // echo "<pre>";print_r($request_accept_date);echo "</pre>";

                                                // exit;

                                        }

                                        else 

                                        {

                                                $temp_status = 'Pending';

                                                $main_temp_status = 'Pending';

                                                $action2 = '';

                                                $request_accept_date = '';

                                        } 



                                        $time2 = strtotime($record['request_sent_date']);

                                        $time2 = $time2 + 19800;

                                        $request_sent_date = date('d/m/Y h:i A',$time2);

                                        

                                        



                                        $adviser_status_records = $obj->getAdviserStatusActivationsRecords($record['ar_id'],$uid,$pro_user_id);

                                        

                                    $option.= '<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">

                                            <tr>

                                                <td width="100%" height="30" align="left" valign="middle">&nbsp;</td>

                                            </tr>

                                        </table>

                                    	<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">

                                            <tr>

                                                <td width="75%" align="left" valign="middle"><strong>User Name: '.$record['name'].'</strong>&nbsp;&nbsp;&nbsp;<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Users Activity" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" ></td>

                                                <td width="25%" align="right" valign="middle">'.$action2.'</td>

                                            </tr>

                                        </table>

                                        

                                        

                                        

                                        <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">

                                            <tr>

                                                <td width="100%" height="30" align="left" valign="middle">&nbsp;</td>

                                            </tr>

                                        </table>

                                        <table width="760" border="1" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

                                            <tr>

                                                <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr.No.</strong></td>

                                                <td width="80%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Reports</strong></td>

                                                <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status Date</strong></td>

                                            </tr>';

                                        

                                        $arr_report_permission = $obj->getAdviserReportsPermissions($user_id,$uid,$record['ar_id']);

                                        if(count($arr_report_permission) > 0)

                                        { 

                                            $j =1;

                                            foreach($arr_report_permission as $report_record) 

                                            { 

                                                $time3 = strtotime($report_record['arp_add_date']);

                                                $time3 = $time3 + 19800;

                                                $arp_add_date = date('d/m/Y h:i A',$time3);

                                                

                                            $option.= '<tr>

                                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$j.'</td>

                                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$obj->getReportTypeNameString($report_record['report_id'],$report_record['permission_type']).



                                                '</td>

                                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$arp_add_date.'</td>

                                            </tr>';

                                           

                                                $j++;

                                            } 

                                            

                                        

                                            $i++;	

                                        }

                                        else

                                        { 

                                           $option.= ' <tr>

                                                <td colspan="3" height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="err_msg">No Records</td>

                                            </tr> ';

                                        

                                        } 

                                        $option.= '</table>';

                                       

                                        

                                    }  

        

	}

	else

	{

		$option.='<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

}



elseif($action=='myuser_activity')

{

	

if(isset($_POST['user_id']))	

{

	$user_id = strip_tags(trim($_POST['user_id']));

}

elseif(isset($_GET['id']))	

{

     $user_id = trim($_GET['id']);

}

elseif(isset($_SESSION['user_invitation_user_id']))	

{

	$user_id = $_SESSION['user_invitation_user_id'];

}

else

{

	$user_id = '';

}

    

 // echo $user_id ;



	$pro_user_id = $_SESSION['adm_vendor_id'];

        

	$user_email = $obj->getProUserEmailById($pro_user_id);

   

	

        

	// $item = $obj->getAllMyUserInvitations($user_email,$user_id);



	$item = $obj->getAllMyUserInvitations($pro_user_id,$user_id);



	$option='';

	//start pagination for notification

    

    $adjacents = 1;

    $records_per_page = 40;

    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    $page = ($page == 0 ? 1 : $page);

    $start = ($page-1) * $records_per_page;

    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.



    $data = array_slice($item,$start,$records_per_page);



// echo "<pre>";print_r($item);echo "</pre>";  



    $count = count($item);

    $next = $page + 1;    

    $prev = $page - 1;

    $last_page = ceil($count/$records_per_page);

    $second_last = $last_page - 1; 

    $pagination = '';

    

    if($last_page > 1)

	{

        $pagination .= '<div class="pagination">';

		if($page > 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   

		}

			

		if($last_page < 7 + ($adjacents * 2))

		{   

			for ($counter = 1; $counter <= $last_page; $counter++)

			{

				if ($counter == $page)

				{

					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

				}

				else

				{

					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

				}

			}

		}

		elseif($last_page > 5 + ($adjacents * 2))

		{

			if($page < 1 + ($adjacents * 2))

			{

				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '...';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '...';

				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

				$pagination.= '..';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   

			}

			else

			{

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';

				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';

				$pagination.= '..';

				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)

				{

					if($counter == $page)

					{

						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';

					}

					else

					{

						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     

					}

				}

			}

		}

		

		if($page < $counter - 1)

		{

			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';

		}

		else

		{

			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';

		}

		$pagination.= '</div>';       

    } 

	$edit_action_id = '22';

	$delete_action_id = '26';

//	$option.= '	<div class="table-responsive">

//					<table id="datatable" class="table table-hover" >

//						<thead>

//                                                    <tr>

//                                                        <th>Sr No</th>';

//                                                        $option.= '<th>Email id</th>

//                                                        <th>Name</th>

//                                                        <th>Message</th>

//                                                        <th>Invitation Sent By</th>';

//                                                        $option.= '<th>Invitation Sent Date</th>

//                                                        <th>Accepted Date</th>

//                                                        <th>Status</th>

//                                                        <th>Action</th>';

//                                        $option.= '</tr>

//						</thead>

//						<tbody>';

// echo "<pre>";print_r($data);echo "</pre>";

// exit;





	if(is_array($data) && count($data) > 0)

	{

            

         if(count($data) > 0)

         {

           //echo 'hiiiiii'; 



           // exit;                            

          foreach($data as $record) 

        {

            // echo "<pre>";print_r($record);echo "</pre>";

            



            $i =1;



            if($record['last_status_updated_by_adviser'] == '1')

            {

                $status_by = 'By Me';

            }

            else

            {

                $status_by = 'By User';

            }						



            if($record['request_status'] == '1')

            {

                    $temp_status = 'Accepted'.$status_by;

                    $main_temp_status = 'Accepted'.$status_by;

                    $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Deactivate" onclick="showDeactivateUserInvitationPopup(\''.$record['ar_id'].'\',\''.$record['user_id'].'\',\''.$record['vendor_id'].'\')">';





                    $time = strtotime($record['request_accept_date']);

                    $time = $time + 19800;

                    $request_accept_date = date('d/m/Y h:i A',$time);



                    // exit;

            }

            elseif($record['request_status'] == '2')

            {

                    $temp_status = 'Declined'.$status_by;

                    $main_temp_status = 'Declined'.$status_by;

                    $action = '';

                    $main_action = '';

                    $action2 = '';





                    $time = strtotime($record['request_accept_date']);

                    $time = $time + 19800;

                    $request_accept_date = date('d/m/Y h:i A',$time);

            }

            elseif($record['request_status'] == '3')

            {

                    $temp_status = 'Deactivated'.$status_by;

                    $main_temp_status = 'Deactivated'.$status_by;

                    $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Activate" onclick="showActivateUserInvitationPopup(\''.$record['ar_id'].'\',\''.$record['user_id'].'\',\''.$record['vendor_id'].'\')">';





                    $time = strtotime($record['request_accept_date']);

                    $time = $time + 19800;

                    $request_accept_date = date('d/m/Y h:i A',$time);

            }

            else 

            {

                    $temp_status = 'Pending';

                    $main_temp_status = 'Pending';

                    $action2 = '';

                    $request_accept_date = '';

            } 



            $time2 = strtotime($record['request_sent_date']);

            $time2 = $time2 + 19800;

            $request_sent_date = date('d/m/Y h:i A',$time2);



     

            $adviser_status_records = $obj->getAdviserStatusActivationsRecords($record['ar_id'],$record['user_id'],$record['vendor_id']);





          

            $option.= '<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                    <td width="75%" align="left" valign="middle"><strong>User Name:'.$obj->getUserFullNameById($record['user_id']).'</strong>&nbsp;&nbsp;&nbsp;<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Access Log" onclick="javascript:window.open(\'my_user_authorise_log.php?id='.$record['user_id'].'\', \'_blank\')" ></td>

                    <td width="25%" align="center" valign="middle">'.$action2.'</td>

                </tr>

            </table>

            <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                    <td width="100%" height="30" align="left" valign="middle">&nbsp;</td>

                </tr>

            </table>



            <table width="940" border="1" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

                <tr>

                    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr.No.</strong></td>

                    <td width="40%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation/Activation/Deactivation Message</strong></td>

                    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation Sent Date</strong></td>

                    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status</strong></td>

                    <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status Date</strong></td>

                    



                </tr>';



                if(count($adviser_status_records) > 0)

                { 



                   $temp_status = 'Accepted';

                

                    $l = 1;

                    $show_modify_button = true;

                    foreach($adviser_status_records as $record_as) 

                    { 

                    	

                       

                        if($record_as['aa_status_updated_by_adviser'] == '1')

                        {

                            $aa_status_by = ' By Me';

                        }

                        else

                        {

                            $aa_status_by = ' By User';

                        }







                            if($record_as['aa_status'] == '1')

                            {

                                    $temp_status = 'Activated'.$aa_status_by;

                                    //if($record['request_status'] == '1' && (( $l - 1) == count($adviser_status_records) ) )

                                    if($record['request_status'] == '1' &&  $show_modify_button)

                                    {

                                            $show_modify_button = false;

                                            $action = '';

                                    }	

                                    else

                                    {

                                            $action = '';

                                    }



                                    $time = strtotime($record_as['aa_add_date']);

                                    $time = $time + 19800;

                                    $request_accept_date = date('d/m/Y h:i A',$time);





                            }

                            elseif($record_as['aa_status'] == '2')

                            {

                                    $temp_status = 'Declined'.$aa_status_by;

                                    $action = '';

                                    $action2 = '';





                                    $time = strtotime($record_as['aa_add_date']);

                                    $time = $time + 19800;

                                    $request_accept_date = date('d/m/Y h:i A',$time);

                            }

                            elseif($record_as['aa_status'] == '3')

                            {

                                    $temp_status = 'Deactivated'.$aa_status_by;

                                    $action = '';

                                    $action2 = '';





                                    $time = strtotime($record_as['aa_add_date']);

                                    $time = $time + 19800;

                                    $request_accept_date = date('d/m/Y h:i A',$time);

                            }

                            else 

                            {

                                    $temp_status = 'Pending';

                                    $action = '';

                                    $action2 = '';

                                    $request_accept_date = '';

                            } 



                            $aa_message = $record_as['aa_status_reason'];



                $option.= '<tr>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$l.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$aa_message.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php //echo $request_sent_date; ?></td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$temp_status.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$request_accept_date.'</td>





                </tr>';



                $l++;

                }  

                $option.= '<tr>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$l.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$record['message'].'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$request_sent_date.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$main_temp_status.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$request_accept_date.'</td>





                </tr>';   

                 

            } 

            else

            { 

                $option.= '<tr>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$i.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$record['message'].'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$request_sent_date.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$temp_status.'</td>

                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$request_accept_date.'</td>





                </tr>';

                                                           

                 } 

            $option.= '</table>

            <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                    <td width="100%" height="30" align="left" valign="middle">&nbsp;</td>

                </tr>

            </table>';

           

                  $i++;	

                }

        //echo $i.'<br>';

	}

	else

	{

		$option.='<tr><td colspan="11" style="color:red;text-align:center">No record</d></tr>';

	}

	

	$option.='			</tbody>

					</table>

				</div>';

	

	if(count($data)>0 && !empty($data))

	{

	  $option.= $pagination;

	}

	echo $option;

}

}



elseif($action == 'showuserquerypopup')

{

	$parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);

        $page_id = stripslashes($_REQUEST['page_id']);

	$output = '';

	$pro_user_id = $_SESSION['adm_vendor_id'];

        $output = $obj->showUserQueryPopup($pro_user_id,$parent_aq_id);

		

	echo $output;

}

elseif($action == 'replyuserquery')

{

	$parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);

	$temp_user_id = stripslashes($_REQUEST['temp_user_id']);

	$temp_page_id = stripslashes($_REQUEST['temp_page_id']);

	$name = stripslashes($_REQUEST['name']);

	$email = stripslashes($_REQUEST['email']);

	$query = stripslashes($_REQUEST['query']);

	

	$error = '0';

	if($obj->isVendorLoggedIn())

	{

		$pro_user_id = $_SESSION['adm_vendor_id'];

		$from_user = '0';

		if($obj->addAdviserQuery($parent_aq_id,$temp_page_id,$temp_user_id,$name,$email,$pro_user_id,$from_user,$query))

		{

			$error = '2';

			$msg = 'Thank You For Your Query';

			$msg = 'Your Guidance has been forwarded to your Consult ('.$obj->getUserFullNameById($temp_user_id).')\'s Message Box.';

			$output = $error.'::'.$msg;

		}

		else

		{

			$error = '1';

			$msg = 'somthing went wrong';

			$output = $error.'::'.$msg;

		}

	}

	else

	{

		$error = '1';

		$msg = 'somthing went wrong!';

		$output = $error.'::'.$msg;

	}

	

	

	

	echo $output;

}



elseif($action == 'showactivateuserinvitationpopup')

{

	$ar_id = stripslashes($_REQUEST['ar_id']);

	$puid = stripslashes($_REQUEST['puid']);

	$error = '0';

	$err_msg = '';

	$output = '';

	$vendor = stripslashes($_REQUEST['vendor']);



	$output = $obj->showActivateUserInvitationPopup($ar_id,$puid,$vendor);

		

	echo $output;

}

elseif($action == 'showdeactivateuserinvitationpopup')

{

	$ar_id = stripslashes($_REQUEST['ar_id']);

	$puid = stripslashes($_REQUEST['puid']);

	$error = '0';

	$err_msg = '';

	$output = '';

	$vendor = stripslashes($_REQUEST['vendor']);

	

	$output = $obj->showDeactivateUserInvitationPopup($ar_id,$puid,$vendor);

		

	echo $output;

}



elseif($action == 'deactivateuserinvitation')

{

	$ar_id = stripslashes($_REQUEST['ar_id']);

	$user_id = $_SESSION['pro_user_id'];

	$puid = stripslashes($_REQUEST['puid']);

	$status_reason = stripslashes($_REQUEST['status_reason']);

	$error = '0';

	$err_msg = '';

	$output = '';

	$vendor = stripslashes($_REQUEST['vendor']);

	

	$output=$obj->deactivateUserInvitation($ar_id,$user_id,$puid,$status_reason,$vendor);

		

	echo $output;

}



elseif($action == 'activateuserinvitation')

{

	$ar_id = stripslashes($_REQUEST['ar_id']);

	$user_id = $_SESSION['pro_user_id'];

	$puid = stripslashes($_REQUEST['puid']);

	$status_reason = stripslashes($_REQUEST['status_reason']);

	$error = '0';

	$err_msg = '';

	$output = '';

	$vendor = stripslashes($_REQUEST['vendor']);



	

	$output=$obj->activateUserInvitation($ar_id,$user_id,$puid,$status_reason,$vendor);

		

	echo $output;

}

elseif($action == 'doacceptuserinvitation')
	{
    $ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['pro_user_id'];
    $puid = stripslashes($_REQUEST['puid']);
   

	$error = '0';

	$err_msg = '';

	$output = '';

	

	$output=$obj->doAcceptUserInvitation($ar_id,$user_id,$puid);





		

	echo $output;

}

elseif($action == 'showdeclineuserinvitation')

{

	$ar_id = stripslashes($_REQUEST['ar_id']);

	$puid = stripslashes($_REQUEST['puid']);

	$error = '0';

	$err_msg = '';

	$output = '';

	

	// echo "<pre>";print_r('hi');echo "</pre>";

	$output = $obj->showDeclineUserInvitation($ar_id,$puid);

		

	echo $output;

}

