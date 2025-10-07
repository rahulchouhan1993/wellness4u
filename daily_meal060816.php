<?php
include('config.php');
$page_id = '13';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode('daily_meal.php');
if(!isLoggedIn())
{
	header("Location: login.php?ref=".$ref);
	exit(0);
}
else
{
	$user_id = $_SESSION['user_id'];
	doUpdateOnline($_SESSION['user_id']);
}

$now = time();
$today_year = date("Y",$now);
$today_month = date("m",$now);
$today_day = date("j",$now); 

$yesterday = $now - 86400;
$yesterday_year = date("Y",$yesterday);
$yesterday_month = date("m",$yesterday);
$yesterday_day = date("j",$yesterday); 
//echo '<br>today_day = '.$today_day.' , today_month = '.$today_month.' , today_year = '.$today_year;
//echo '<br>yesterday_day = '.$yesterday_day.' , yesterday_month = '.$yesterday_month.' , yesterday_year = '.$yesterday_year;

$breakfast_start_time = '4';
$breakfast_end_time = '10';
$brunch_start_time = '10';
$brunch_end_time = '12';
$lunch_start_time = '12';
$lunch_end_time = '15';
$snacks_start_time = '15';
$snacks_end_time = '19';
$dinner_start_time = '19';
$dinner_end_time = '28';

$error = false;
$tr_err_meal_date = 'none';
$tr_err_breakfast_time = 'none';
$tr_err_breakfast = array();
$tr_err_brunch_time = 'none';
$tr_err_brunch = array();
$tr_err_lunch_time = 'none';
$tr_err_lunch = array();
$tr_err_snacks_time = 'none';
$tr_err_snacks = array();
$tr_err_dinner_time = 'none';
$tr_err_dinner = array();

$tr_breakfast_other_item = array();
$tr_brunch_other_item = array();
$tr_lunch_other_item = array();
$tr_snacks_other_item = array();
$tr_dinner_other_item = array();

$err_meal_date = '';
$err_breakfast_time = '';
$err_breakfast = array();
$err_brunch_time = '';
$err_brunch = array();
$err_lunch_time = '';
$err_lunch = array();
$err_snacks_time = '';
$err_snacks = array();
$err_dinner_time = '';
$err_dinner = array();

$breakfast_prefill_arr = array();
$brunch_prefill_arr = array();
$lunch_prefill_arr = array();
$snacks_prefill_arr = array();
$dinner_prefill_arr = array();

if(isset($_POST['btnSubmit']))	
{
	$day = trim($_POST['day']);
	$month = trim($_POST['month']);
	$year = trim($_POST['year']);
	$breakfast_cnt = trim($_POST['breakfast_cnt']);
	$breakfast_totalRow = trim($_POST['breakfast_totalRow']);
	$breakfast_time = trim($_POST['breakfast_time']);
	$brunch_cnt = trim($_POST['brunch_cnt']);
	$brunch_totalRow = trim($_POST['brunch_totalRow']);
	$brunch_time = trim($_POST['brunch_time']);
	$lunch_cnt = trim($_POST['lunch_cnt']);
	$lunch_totalRow = trim($_POST['lunch_totalRow']);
	$lunch_time = trim($_POST['lunch_time']);
	$snacks_cnt = trim($_POST['snacks_cnt']);
	$snacks_totalRow = trim($_POST['snacks_totalRow']);
	$snacks_time = trim($_POST['snacks_time']);
	$dinner_cnt = trim($_POST['dinner_cnt']);
	$dinner_totalRow = trim($_POST['dinner_totalRow']);
	$dinner_time = trim($_POST['dinner_time']);

	list($breakfast_other_item,$breakfast_other_item_add,$breakfast_other_item_rest,$breakfast_other_item_cnt,$breakfast_other_item_arr_rest,$breakfast_other_item_arr) = getMultipleFieldsValueByComma('breakfast_other_item');
	list($breakfast_meal_like,$breakfast_meal_like_add,$breakfast_meal_like_rest,$breakfast_meal_like_cnt,$breakfast_meal_like_arr_rest,$breakfast_meal_like_arr) = getMultipleFieldsValueByComma('breakfast_meal_like');
	list($breakfast_quantity,$breakfast_quantity_add,$breakfast_quantity_rest,$breakfast_quantity_cnt,$breakfast_quantity_arr_rest,$breakfast_quantity_arr) = getMultipleFieldsValueByComma('breakfast_quantity');
	list($breakfast_measure,$breakfast_measure_add,$breakfast_measure_rest,$breakfast_measure_cnt,$breakfast_measure_arr_rest,$breakfast_measure_arr) = getMultipleFieldsValueByComma('breakfast_measure');
	list($breakfast_consultant_remark,$breakfast_consultant_remark_add,$breakfast_consultant_remark_rest,$breakfast_consultant_remark_cnt,$breakfast_consultant_remark_arr_rest,$breakfast_consultant_remark_arr) = getMultipleFieldsValueBy('breakfast_consultant_remark');
	list($brunch_other_item,$brunch_other_item_add,$brunch_other_item_rest,$brunch_other_item_cnt,$brunch_other_item_arr_rest,$brunch_other_item_arr) = getMultipleFieldsValueByComma('brunch_other_item');
	list($brunch_meal_like,$brunch_meal_like_add,$brunch_meal_like_rest,$brunch_meal_like_cnt,$brunch_meal_like_arr_rest,$brunch_meal_like_arr) = getMultipleFieldsValueByComma('brunch_meal_like');
	list($brunch_quantity,$brunch_quantity_add,$brunch_quantity_rest,$brunch_quantity_cnt,$brunch_quantity_arr_rest,$brunch_quantity_arr) = getMultipleFieldsValueByComma('brunch_quantity');
	list($brunch_measure,$brunch_measure_add,$brunch_measure_rest,$brunch_measure_cnt,$brunch_measure_arr_rest,$brunch_measure_arr) = getMultipleFieldsValueByComma('brunch_measure');
	list($brunch_consultant_remark,$brunch_consultant_remark_add,$brunch_consultant_remark_rest,$brunch_consultant_remark_cnt,$brunch_consultant_remark_arr_rest,$brunch_consultant_remark_arr) = getMultipleFieldsValueBy('brunch_consultant_remark');
	list($lunch_other_item,$lunch_other_item_add,$lunch_other_item_rest,$lunch_other_item_cnt,$lunch_other_item_arr_rest,$lunch_other_item_arr) = getMultipleFieldsValueByComma('lunch_other_item');
	list($lunch_meal_like,$lunch_meal_like_add,$lunch_meal_like_rest,$lunch_meal_like_cnt,$lunch_meal_like_arr_rest,$lunch_meal_like_arr) = getMultipleFieldsValueByComma('lunch_meal_like');
	list($lunch_quantity,$lunch_quantity_add,$lunch_quantity_rest,$lunch_quantity_cnt,$lunch_quantity_arr_rest,$lunch_quantity_arr) = getMultipleFieldsValueByComma('lunch_quantity');
	list($lunch_measure,$lunch_measure_add,$lunch_measure_rest,$lunch_measure_cnt,$lunch_measure_arr_rest,$lunch_measure_arr) = getMultipleFieldsValueByComma('lunch_measure');
	list($lunch_consultant_remark,$lunch_consultant_remark_add,$lunch_consultant_remark_rest,$lunch_consultant_remark_cnt,$lunch_consultant_remark_arr_rest,$lunch_consultant_remark_arr) = getMultipleFieldsValueBy('lunch_consultant_remark');
	list($snacks_other_item,$snacks_other_item_add,$snacks_other_item_rest,$snacks_other_item_cnt,$snacks_other_item_arr_rest,$snacks_other_item_arr) = getMultipleFieldsValueByComma('snacks_other_item');
	list($snacks_meal_like,$snacks_meal_like_add,$snacks_meal_like_rest,$snacks_meal_like_cnt,$snacks_meal_like_arr_rest,$snacks_meal_like_arr) = getMultipleFieldsValueByComma('snacks_meal_like');
	list($snacks_quantity,$snacks_quantity_add,$snacks_quantity_rest,$snacks_quantity_cnt,$snacks_quantity_arr_rest,$snacks_quantity_arr) = getMultipleFieldsValueByComma('snacks_quantity');
	list($snacks_measure,$snacks_measure_add,$snacks_measure_rest,$snacks_measure_cnt,$snacks_measure_arr_rest,$snacks_measure_arr) = getMultipleFieldsValueByComma('snacks_measure');
	list($snacks_consultant_remark,$snacks_consultant_remark_add,$snacks_consultant_remark_rest,$snacks_consultant_remark_cnt,$snacks_consultant_remark_arr_rest,$snacks_consultant_remark_arr) = getMultipleFieldsValueBy('snacks_consultant_remark');
	list($dinner_other_item,$dinner_other_item_add,$dinner_other_item_rest,$dinner_other_item_cnt,$dinner_other_item_arr_rest,$dinner_other_item_arr) = getMultipleFieldsValueByComma('dinner_other_item');
	list($dinner_meal_like,$dinner_meal_like_add,$dinner_meal_like_rest,$dinner_meal_like_cnt,$dinner_meal_like_arr_rest,$dinner_meal_like_arr) = getMultipleFieldsValueByComma('dinner_meal_like');
	list($dinner_quantity,$dinner_quantity_add,$dinner_quantity_rest,$dinner_quantity_cnt,$dinner_quantity_arr_rest,$dinner_quantity_arr) = getMultipleFieldsValueByComma('dinner_quantity');
	list($dinner_measure,$dinner_measure_add,$dinner_measure_rest,$dinner_measure_cnt,$dinner_measure_arr_rest,$dinner_measure_arr) = getMultipleFieldsValueByComma('dinner_measure');
	list($dinner_consultant_remark,$dinner_consultant_remark_add,$dinner_consultant_remark_rest,$dinner_consultant_remark_cnt,$dinner_consultant_remark_arr_rest,$dinner_consultant_remark_arr) = getMultipleFieldsValueBy('dinner_consultant_remark');

        if( ($day == '') || ($month == '') || ($year == '') )
	{
		$error = true;
		$tr_err_meal_date = '';
		$err_meal_date = 'Please select date!';
	}
	elseif(!checkdate($month,$day,$year))
	{
		$error = true;
		$tr_err_meal_date = '';
		$err_meal_date = 'Please select valid date!';
	}
	elseif(mktime(0,0,0,$month,$day,$year) > $now)
	{
		$error = true;
		$tr_err_meal_date = '';
		$err_meal_date = 'Please select today or previous date!';
	}
	else
	{
		$meal_date = $year.'-'.$month.'-'.$day;
	}
	
	//Validations for breakfast - START	
	if($breakfast_time == '')
	{
		$breakfast_empty = true;
	}
	else
	{
		$breakfast_empty = false;
	}
	
	//echo'<br><pre>';
	//print_r($_POST);
	//echo'<br></pre>';
	
	$breakfast_item_id_arr = array();
	for($i=0;$i<$breakfast_totalRow;$i++)
	{
		$breakfast_item_id = strip_tags(trim($_POST['as_values_breakfast_item_'.$i]));
		$breakfast_item_id = str_replace(",", "", $breakfast_item_id);
		array_push($breakfast_item_id_arr,$breakfast_item_id);
		if($breakfast_item_id == '') 
		{
			array_push($breakfast_prefill_arr ,'{}');
		}
		else
		{ 
			$json = array();
			$json['value'] = $breakfast_item_id;
			$json['name'] = getDailyMealName($breakfast_item_id);
			array_push($breakfast_prefill_arr ,json_encode($json));
		}	

		$temp_err = '';
		$temp_tr_err = 'none';

		if($breakfast_item_id == '9999999999')
		{
			$breakfast_empty = false;
			$tr_breakfast_other_item[$i] = '';
			if($breakfast_other_item_arr[$i] == '')
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter breakfast food item(Other)!';
			}
		}
		else
		{
			$tr_breakfast_other_item[$i] = 'none';
			if( ($breakfast_item_id == '') && (!$breakfast_empty) )
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter breakfast food item!';
			}
			else
			{
				if($breakfast_item_id != '')
				{
					$breakfast_empty = false;
					if($breakfast_item_id == '')
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Please enter breakfast food item.';
					}
					elseif(!chkFoodItemExists($breakfast_item_id))
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Sorry this food item is not available.Please select food item from auto suggest list!';
					}
				}
			}
		}
		array_push($tr_err_breakfast , $temp_tr_err);
		array_push($err_breakfast , $temp_err);	
	}

	if(!$breakfast_empty)
	{
		if($breakfast_time == '')
		{
			$error = true;
			$tr_err_breakfast_time = '';
			$err_breakfast_time = 'Please select breakfast time!';
		}
	}	
	//Validations for breakfast - END	

	//Validations for brunch - START	
	if($brunch_time == '')
	{
		$brunch_empty = true;
	}
	else
	{
		$brunch_empty = false;
	}
	
	$brunch_item_id_arr = array();
	for($i=0;$i<$brunch_totalRow;$i++)
	{
		$brunch_item_id = strip_tags(trim($_POST['as_values_brunch_item_'.$i]));
		$brunch_item_id = str_replace(",", "", $brunch_item_id);
		array_push($brunch_item_id_arr,$brunch_item_id);

		if($brunch_item_id == '') 
		{
			array_push($brunch_prefill_arr ,'{}');
		}
		else
		{ 
			$json = array();
			$json['value'] = $brunch_item_id;
			$json['name'] = getDailyMealName($brunch_item_id);
			array_push($brunch_prefill_arr ,json_encode($json));
		}	
			
		$temp_err = '';
		$temp_tr_err = 'none';
		
		if($brunch_item_id == '9999999999')
		{
			$brunch_empty = false;
			$tr_brunch_other_item[$i] = '';
			if($brunch_other_item_arr[$i] == '')
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter brunch food item(Other)!';
			}
		}
		else
		{
			$tr_brunch_other_item[$i] = 'none';
			if( ($brunch_item_id == '') && (!$brunch_empty) )
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter brunch food item!';
			}
			else
			{
				if($brunch_item_id != '')
				{
					$brunch_empty = false;
					if($brunch_item_id == '')
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Please enter brunch food item.';
					}
					elseif(!chkFoodItemExists($brunch_item_id))
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Sorry this food item is not available.Please select food item from auto suggest list!';
					}
				}
			}
		}		
		array_push($tr_err_brunch , $temp_tr_err);
		array_push($err_brunch , $temp_err);	
	}
		
	if(!$brunch_empty)
	{
		if($brunch_time == '')
		{
			$error = true;
			$tr_err_brunch_time = '';
			$err_brunch_time = 'Please select brunch time!';
		}
	}	
	//Validations for brunch - END	

	//Validations for lunch - START	
	if($lunch_time == '')
	{
		$lunch_empty = true;
	}
	else
	{
		$lunch_empty = false;
	}

	$lunch_item_id_arr = array();
	for($i=0;$i<$lunch_totalRow;$i++)
	{
		$lunch_item_id = strip_tags(trim($_POST['as_values_lunch_item_'.$i]));
		$lunch_item_id = str_replace(",", "", $lunch_item_id);
		array_push($lunch_item_id_arr,$lunch_item_id);
		
		if($lunch_item_id == '') 
		{
			array_push($lunch_prefill_arr ,'{}');
		}
		else
		{ 
			$json = array();
			$json['value'] = $lunch_item_id;
			$json['name'] = getDailyMealName($lunch_item_id);
			array_push($lunch_prefill_arr ,json_encode($json));
		}	

		$temp_err = '';
		$temp_tr_err = 'none';
		
		if($lunch_item_id == '9999999999')
		{
			$lunch_empty = false;
			$tr_lunch_other_item[$i] = '';
			if($lunch_other_item_arr[$i] == '')
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter lunch food item(Other)!';
			}
		}
		else
		{
			$tr_lunch_other_item[$i] = 'none';
			if( ($lunch_item_id == '') && (!$lunch_empty) )
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter lunch food item!';
			}
			else
			{
				if($lunch_item_id != '')
				{
					$lunch_empty = false;
					if($lunch_item_id == '')
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Please enter lunch food item.';
					}
					elseif(!chkFoodItemExists($lunch_item_id))
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Sorry this food item is not available.Please select food item from auto suggest list!';
					}
				}
			}	
		}	
		array_push($tr_err_lunch , $temp_tr_err);
		array_push($err_lunch , $temp_err);	
	}

	if(!$lunch_empty)
	{
		if($lunch_time == '')
		{
			$error = true;
			$tr_err_lunch_time = '';
			$err_lunch_time = 'Please select lunch time!';
		}
	}	
	//Validations for lunch - END		

	//Validations for snacks - START	
	if($snacks_time == '')
	{
		$snacks_empty = true;
	}
	else
	{
		$snacks_empty = false;
	}
	$snacks_item_id_arr = array();

	for($i=0;$i<$snacks_totalRow;$i++)
	{
		$snacks_item_id = strip_tags(trim($_POST['as_values_snacks_item_'.$i]));
		$snacks_item_id = str_replace(",", "", $snacks_item_id);
		array_push($snacks_item_id_arr,$snacks_item_id);
		if($snacks_item_id == '') 
		{
			array_push($snacks_prefill_arr ,'{}');
		}
		else
		{ 
			$json = array();
			$json['value'] = $snacks_item_id;
			$json['name'] = getDailyMealName($snacks_item_id);
			array_push($snacks_prefill_arr ,json_encode($json));
		}	
			
		$temp_err = '';
		$temp_tr_err = 'none';
		
		if($snacks_item_id == '9999999999')
		{
			$snacks_empty = false;
			$tr_snacks_other_item[$i] = '';
			if($snacks_other_item_arr[$i] == '')
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter snacks food item(Other)!';
			}
		}
		else
		{
			$tr_snacks_other_item[$i] = 'none';
			if( ($snacks_item_id == '') && (!$snacks_empty) )
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter snacks food item!';
			}
			else
			{
				if($snacks_item_id != '')
				{
					$snacks_empty = false;
					if($snacks_item_id == '')
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Please enter snacks food item!';
					}
					elseif(!chkFoodItemExists($snacks_item_id))
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Sorry this food item is not available.Please select food item from auto suggest list!';
					}
				}
			}
		}		
		array_push($tr_err_snacks , $temp_tr_err);
		array_push($err_snacks , $temp_err);	
	}
		
	if(!$snacks_empty)
	{
		if($snacks_time == '')
		{
			$error = true;
			$tr_err_snacks_time = '';
			$err_snacks_time = 'Please select snacks time!';
		}
	}	
	//Validations for snacks - END	
	
	//Validations for dinner - START	
	if($dinner_time == '')
	{
		$dinner_empty = true;
	}
	else
	{
		$dinner_empty = false;
	}
	
	$dinner_item_id_arr = array();
	for($i=0;$i<$dinner_totalRow;$i++)
	{
		$dinner_item_id = strip_tags(trim($_POST['as_values_dinner_item_'.$i]));
		$dinner_item_id = str_replace(",", "", $dinner_item_id);
		array_push($dinner_item_id_arr,$dinner_item_id);
		
		if($dinner_item_id == '') 
		{
			array_push($dinner_prefill_arr ,'{}');
		}
		else
		{ 
			$json = array();
			$json['value'] = $dinner_item_id;
			$json['name'] = getDailyMealName($dinner_item_id);
			array_push($dinner_prefill_arr ,json_encode($json));
		}	
	
		$temp_err = '';
		$temp_tr_err = 'none';
		
		if($dinner_item_id == '9999999999')
		{
			$dinner_empty = false;
			$tr_dinner_other_item[$i] = '';
			if($dinner_other_item_arr[$i] == '')
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter dinner food item(Other)!';
			}
		}
		else
		{
			$tr_dinner_other_item[$i] = 'none';
			if( ($dinner_item_id == '') && (!$dinner_empty) )
			{
				$error = true;
				$temp_tr_err = '';
				$temp_err = 'Please enter dinner food item!';
			}
			else
			{
				if($dinner_item_id != '')
				{
					$dinner_empty = false;
					if($dinner_item_id == '')
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Please enter dinner food item!';
					}
					elseif(!chkFoodItemExists($dinner_item_id))
					{
						$error = true;
						$temp_tr_err = '';
						$temp_err = 'Sorry this food item is not available.Please select food item from auto suggest list!';
					}
				}
			}	
		}	
		array_push($tr_err_dinner , $temp_tr_err);
		array_push($err_dinner , $temp_err);	
	}
		
	if(!$dinner_empty)
	{
		if($dinner_time == '')
		{
			$error = true;
			$tr_err_dinner_time = '';
			$err_dinner_time = 'Please select dinner time!';
		}
	}	
	//Validations for dinner - END	
		
	if(!$error)
	{
		if( ($breakfast_empty == true) && ($brunch_empty == true) && ($lunch_empty == true) && ($snacks_empty == true) && ($dinner_empty == true) )
		{
			$error = true;
			$err_msg = 'Please enter meal details of atleast one time!';
		}
		else
		{
			$addUsersDailyMeal = addUsersDailyMeal($user_id,$meal_date,$breakfast_time,$breakfast_item_id_arr,$breakfast_other_item_arr,$breakfast_meal_like_arr,$breakfast_quantity_arr,$breakfast_measure_arr,$breakfast_consultant_remark_arr,$brunch_time,$brunch_item_id_arr,$brunch_other_item_arr,$brunch_meal_like_arr,$brunch_quantity_arr,$brunch_measure_arr,$brunch_consultant_remark_arr,$lunch_time,$lunch_item_id_arr,$lunch_other_item_arr,$lunch_meal_like_arr,$lunch_quantity_arr,$lunch_measure_arr,$lunch_consultant_remark_arr,$snacks_time,$snacks_item_id_arr,$snacks_other_item_arr,$snacks_meal_like_arr,$snacks_quantity_arr,$snacks_measure_arr,$snacks_consultant_remark_arr,$dinner_time,$dinner_item_id_arr,$dinner_other_item_arr,$dinner_meal_like_arr,$dinner_quantity_arr,$dinner_measure_arr,$dinner_consultant_remark_arr);

			if($addUsersDailyMeal)
			{
			header("Location: message.php?msg=14");	
/*
//header("Location: message.php?msg=14&gotopage=".$page_id); 
                                header("Location: my_wellness_solutions.php?mid=".$page_id."&date=".$meal_date); 
                                exit(0);
*/
			}
			else
			{
				$err_msg = 'There is some problem right now!Please try again later';
			}
		}	
	}
}
else
{
	$year = $today_year;
	$month = $today_month;
	$day = $today_day;
	
	$meal_date = $year.'-'.$month.'-'.$day;
	
	$prev_breakfast_record = false;
	$prev_brunch_record = false;
	$prev_lunch_record = false;
	$prev_snacks_record = false;
	$prev_dinner_record = false;
	
	list($arr_user_meal_id,$arr_meal_date,$arr_meal_time,$arr_meal_id,$arr_meal_others,$arr_meal_like,$arr_meal_quantity,$arr_meal_measure,$arr_meal_consultant_remark,$arr_meal_type) = getUsersDailyMealsDetails($user_id,$meal_date);

	if(count($arr_user_meal_id) > 0)
	{
		for($i=0;$i<count($arr_user_meal_id);$i++)
		{
			if($arr_meal_type[$i] == 'breakfast')
			{
				$prev_breakfast_record = true;
			}
			
			if($arr_meal_type[$i] == 'brunch')
			{
				$prev_brunch_record = true;
			}
			
			if($arr_meal_type[$i] == 'lunch')
			{
				$prev_lunch_record = true;
			}
			
			if($arr_meal_type[$i] == 'snacks')
			{
				$prev_snacks_record = true;
			}
			
			if($arr_meal_type[$i] == 'dinner')
			{
				$prev_dinner_record = true;
			}
		}
			
		if($prev_breakfast_record)
		{
			$breakfast_cnt = 0;
			$breakfast_totalRow = '0';
			$breakfast_item_id_arr = array();
			$breakfast_other_item_arr = array();
			$breakfast_quantity_arr = array();
			$breakfast_measure_arr = array();
			$breakfast_meal_like_arr = array();
			$breakfast_consultant_remark_arr = array();
			
			for($i=0;$i<count($arr_user_meal_id);$i++)
			{
				if($arr_meal_type[$i] == 'breakfast')
				{
					$breakfast_time = $arr_meal_time[$i];
					array_push($breakfast_item_id_arr,$arr_meal_id[$i]);
					array_push($breakfast_quantity_arr,$arr_meal_quantity[$i]);
					array_push($breakfast_measure_arr,$arr_meal_measure[$i]);
					array_push($breakfast_meal_like_arr,$arr_meal_like[$i]);
					array_push($breakfast_consultant_remark_arr,$arr_meal_consultant_remark[$i]);
					if($arr_meal_id[$i] == '') 
					{
						array_push($breakfast_prefill_arr ,'{}');
						array_push($breakfast_other_item_arr,'');
						array_push($tr_breakfast_other_item,'none');
					}
					elseif($arr_meal_id[$i] == '9999999999') 
					{
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($breakfast_prefill_arr ,json_encode($json));
						array_push($breakfast_other_item_arr,$arr_meal_others[$i]);
						array_push($tr_breakfast_other_item,'none');
					}
					else
					{ 
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($breakfast_prefill_arr ,json_encode($json));
						array_push($breakfast_other_item_arr,'');
						array_push($tr_breakfast_other_item,'none');
					}
					array_push($tr_err_breakfast,'none');
					array_push($err_breakfast,'');
					$breakfast_cnt++;
					$breakfast_totalRow++;
				}
			}
		}
		else
		{
			$breakfast_cnt = '1';
			$breakfast_totalRow = '1';
			$tr_err_breakfast[0] = 'none';
			$tr_breakfast_other_item[0] = 'none';
			$err_breakfast[0] = '';
			array_push($breakfast_prefill_arr ,'{}');
		}	
		
		if($prev_brunch_record)
		{
			$brunch_cnt = 0;
			$brunch_totalRow = '0';
			$brunch_item_id_arr = array();
			$brunch_other_item_arr = array();
			$brunch_quantity_arr = array();
			$brunch_measure_arr = array();
			$brunch_meal_like_arr = array();
			$brunch_consultant_remark_arr = array();
			
			for($i=0;$i<count($arr_user_meal_id);$i++)
			{
				if($arr_meal_type[$i] == 'brunch')
				{
					$brunch_time = $arr_meal_time[$i];
					array_push($brunch_item_id_arr,$arr_meal_id[$i]);
					array_push($brunch_quantity_arr,$arr_meal_quantity[$i]);
					array_push($brunch_measure_arr,$arr_meal_measure[$i]);
					array_push($brunch_meal_like_arr,$arr_meal_like[$i]);
					array_push($brunch_consultant_remark_arr,$arr_meal_consultant_remark[$i]);
					if($arr_meal_id[$i] == '') 
					{
						array_push($brunch_prefill_arr ,'{}');
						array_push($brunch_other_item_arr,'');
						array_push($tr_brunch_other_item,'none');
					}
					elseif($arr_meal_id[$i] == '9999999999') 
					{
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($brunch_prefill_arr ,json_encode($json));
						array_push($brunch_other_item_arr,$arr_meal_others[$i]);
						array_push($tr_brunch_other_item,'');
					}
					else
					{ 
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($brunch_prefill_arr ,json_encode($json));
						array_push($brunch_other_item_arr,'');
						array_push($tr_brunch_other_item,'none');
					}
					array_push($tr_err_brunch,'none');
					array_push($err_brunch,'');
					$brunch_cnt++;
					$brunch_totalRow++;
				}
			}
		}
		else
		{
			$brunch_cnt = '1';
			$brunch_totalRow = '1';
			$tr_err_brunch[0] = 'none';
			$tr_brunch_other_item[0] = 'none';
			$err_brunch[0] = '';
			array_push($brunch_prefill_arr ,'{}');
		}

		if($prev_lunch_record)
		{
			$lunch_cnt = 0;
			$lunch_totalRow = '0';
			$lunch_item_id_arr = array();
			$lunch_other_item_arr = array();
			$lunch_quantity_arr = array();
			$lunch_measure_arr = array();
			$lunch_meal_like_arr = array();
			$lunch_consultant_remark_arr = array();
			for($i=0;$i<count($arr_user_meal_id);$i++)
			{
				if($arr_meal_type[$i] == 'lunch')
				{
					$lunch_time = $arr_meal_time[$i];
					array_push($lunch_item_id_arr,$arr_meal_id[$i]);
					array_push($lunch_quantity_arr,$arr_meal_quantity[$i]);
					array_push($lunch_measure_arr,$arr_meal_measure[$i]);
					array_push($lunch_meal_like_arr,$arr_meal_like[$i]);
					array_push($lunch_consultant_remark_arr,$arr_meal_consultant_remark[$i]);
					if($arr_meal_id[$i] == '') 
					{
						array_push($lunch_prefill_arr ,'{}');
						array_push($lunch_other_item_arr,'');
						array_push($tr_lunch_other_item,'none');
					}
					elseif($arr_meal_id[$i] == '9999999999') 
					{
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($lunch_prefill_arr ,json_encode($json));
						array_push($lunch_other_item_arr,$arr_meal_others[$i]);
						array_push($tr_lunch_other_item,'');
					}
					else
					{ 
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($lunch_prefill_arr ,json_encode($json));
						array_push($lunch_other_item_arr,'');
						array_push($tr_lunch_other_item,'none');
					}
					array_push($tr_err_lunch,'none');
					array_push($err_lunch,'');
					
					$lunch_cnt++;
					$lunch_totalRow++;
				}
			}
		}
		else
		{
			$lunch_cnt = '1';
			$lunch_totalRow = '1';
			$tr_err_lunch[0] = 'none';
			$tr_lunch_other_item[0] = 'none';
			$err_lunch[0] = '';
			array_push($lunch_prefill_arr ,'{}');
		}
		
		if($prev_snacks_record)
		{
			$snacks_cnt = 0;
			$snacks_totalRow = '0';
			$snacks_item_id_arr = array();
			$snacks_other_item_arr = array();
			$snacks_quantity_arr = array();
			$snacks_measure_arr = array();
			$snacks_meal_like_arr = array();
			$snacks_consultant_remark_arr = array();
			
			for($i=0;$i<count($arr_user_meal_id);$i++)
			{
				if($arr_meal_type[$i] == 'snacks')
				{
					$snacks_time = $arr_meal_time[$i];
					array_push($snacks_item_id_arr,$arr_meal_id[$i]);
					array_push($snacks_quantity_arr,$arr_meal_quantity[$i]);
					array_push($snacks_measure_arr,$arr_meal_measure[$i]);
					array_push($snacks_meal_like_arr,$arr_meal_like[$i]);
					array_push($snacks_consultant_remark_arr,$arr_meal_consultant_remark[$i]);
					if($arr_meal_id[$i] == '') 
					{
						array_push($snacks_prefill_arr ,'{}');
						array_push($snacks_other_item_arr,'');
						array_push($tr_snacks_other_item,'none');
					}
					elseif($arr_meal_id[$i] == '9999999999') 
					{
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($snacks_prefill_arr ,json_encode($json));
						array_push($snacks_other_item_arr,$arr_meal_others[$i]);
						array_push($tr_snacks_other_item,'');
					}
					else
					{ 
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($snacks_prefill_arr ,json_encode($json));
						array_push($snacks_other_item_arr,'');
						array_push($tr_snacks_other_item,'none');
					}
					array_push($tr_err_snacks,'none');
					array_push($err_snacks,'');
					
					$snacks_cnt++;
					$snacks_totalRow++;
				}
			}
		}
		else
		{
			$snacks_cnt = '1';
			$snacks_totalRow = '1';
			$tr_err_snacks[0] = 'none';
			$tr_snacks_other_item[0] = 'none';
			$err_snacks[0] = '';
			array_push($snacks_prefill_arr ,'{}');
		}
		
		if($prev_dinner_record)
		{
			$dinner_cnt = 0;
			$dinner_totalRow = '0';
			$dinner_item_id_arr = array();
			$dinner_other_item_arr = array();
			$dinner_quantity_arr = array();
			$dinner_measure_arr = array();
			$dinner_meal_like_arr = array();
			$dinner_consultant_remark_arr = array();
			
			for($i=0;$i<count($arr_user_meal_id);$i++)
			{
				if($arr_meal_type[$i] == 'dinner')
				{
					$dinner_time = $arr_meal_time[$i];
					array_push($dinner_item_id_arr,$arr_meal_id[$i]);
					array_push($dinner_quantity_arr,$arr_meal_quantity[$i]);
					array_push($dinner_measure_arr,$arr_meal_measure[$i]);
					array_push($dinner_meal_like_arr,$arr_meal_like[$i]);
					array_push($dinner_consultant_remark_arr,$arr_meal_consultant_remark[$i]);
					if($arr_meal_id[$i] == '') 
					{
						array_push($dinner_prefill_arr ,'{}');
						array_push($dinner_other_item_arr,'');
						array_push($tr_dinner_other_item,'none');
					}
					elseif($arr_meal_id[$i] == '9999999999') 
					{
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($dinner_prefill_arr ,json_encode($json));
						array_push($dinner_other_item_arr,$arr_meal_others[$i]);
						array_push($tr_dinner_other_item,'');
					}
					else
					{ 
						$json = array();
						$json['value'] = $arr_meal_id[$i];
						$json['name'] = getDailyMealName($arr_meal_id[$i]);
						array_push($dinner_prefill_arr ,json_encode($json));
						array_push($dinner_other_item_arr,'');
						array_push($tr_dinner_other_item,'none');
					}
					array_push($tr_err_dinner,'none');
					array_push($err_dinner,'');
										
					$dinner_cnt++;
					$dinner_totalRow++;
				}
			}
		}
		else
		{
			$dinner_cnt = '1';
			$dinner_totalRow = '1';
			$tr_err_dinner[0] = 'none';
			$tr_dinner_other_item[0] = 'none';
			$err_dinner[0] = '';
			array_push($dinner_prefill_arr ,'{}');
		}

		//debug_array($tr_dinner_other_item);
	}
	else
	{	
		$breakfast_cnt = '1';
		$breakfast_totalRow = '1';
		$brunch_cnt = '1';
		$brunch_totalRow = '1';
		$lunch_cnt = '1';
		$lunch_totalRow = '1';
		$snacks_cnt = '1';
		$snacks_totalRow = '1';
		$dinner_cnt = '1';
		$dinner_totalRow = '1';

		$tr_err_breakfast[0] = 'none';
		$tr_err_brunch[0] = 'none';
		$tr_err_lunch[0] = 'none';
		$tr_err_snacks[0] = 'none';
		$tr_err_dinner[0] = 'none';
		$tr_breakfast_other_item[0] = 'none';
		$tr_brunch_other_item[0] = 'none';
		$tr_lunch_other_item[0] = 'none';
		$tr_snacks_other_item[0] = 'none';
		$tr_dinner_other_item[0] = 'none';
	
		$err_breakfast[0] = '';
		$err_brunch[0] = '';
		$err_lunch[0] = '';
		$err_snacks[0] = '';
		$err_dinner[0] = '';

		array_push($breakfast_prefill_arr ,'{}');
		array_push($brunch_prefill_arr ,'{}');
		array_push($lunch_prefill_arr ,'{}');
		array_push($snacks_prefill_arr ,'{}');
		array_push($dinner_prefill_arr ,'{}');
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
    <link href="cwri.css" rel="stylesheet" type="text/css" />
    	<link href="csswell/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
	  <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
    <?php /*?><script type="text/JavaScript" src="js/jquery-1.9.1.js"></script><?php */?>
    <script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script src="js/jquery-ui.js"></script>
    <script type="text/JavaScript" src="js/commonfn.js"></script>
    <script type="text/JavaScript" src="js/jquery.autoSuggest.js"></script>
    <link href="css/autoSuggest.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery.bxSlider.js"></script>
    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery.ticker.js" type="text/javascript"></script>
    
    <script type="text/javascript"> 
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

                $("ul.tabs li").click(function() {
                        $("ul.tabs li").removeClass("active");
                        $(this).addClass("active");
                        $(".tab_content").hide();
                        var activeTab = $(this).attr("rel"); 
                        $("#"+activeTab).fadeIn(); 
                });

                var breakfast_cnt = parseInt($('#breakfast_cnt').val());
                var breakfast_totalRow = parseInt($('#breakfast_totalRow').val());
                var data = {items:<?php echo getMealsAutoList($user_id); ?>};
                var breakfast_prefill_arr = new Array(<?php echo count($breakfast_prefill_arr);?>);
                <?php 
                for($m=0;$m<count($breakfast_prefill_arr);$m++)
                { ?>
                        breakfast_prefill_arr[<?php echo $m;?>] = <?php echo getPreFillList($breakfast_prefill_arr[$m]) ; ?>;
                <?php
                } ?>

                for(var i=0; i < breakfast_cnt; i++)
                {
                        $("#breakfast_item_"+i).autoSuggest(data.items, {asHtmlID:"breakfast_item_"+i, preFill: breakfast_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "breakfast_"+i });
                }	

                $('#addMoreBreakfast').click(function() {
                        var breakfast_cnt = parseInt($('#breakfast_cnt').val());
                        var breakfast_totalRow = parseInt($('#breakfast_totalRow').val());

                        $('#tblbreakfast tr[id="add_before_this_breakfast"]').before('<tr id="tr_breakfast_1_'+breakfast_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="breakfast_item[]" type="text" class="input" id="breakfast_item_'+breakfast_cnt+'" value="" /></td></tr><tr id="tr_breakfast_2_'+breakfast_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="breakfast_other_item[]" type="text" class="input" id="breakfast_other_item_'+breakfast_cnt+'" value="" /></td></tr><tr id="tr_breakfast_3_'+breakfast_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="breakfast_quantity[]" id="breakfast_quantity_'+breakfast_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_breakfast_'+breakfast_cnt+'"></span><input type="hidden" name="breakfast_measure[]" id="breakfast_measure_'+breakfast_cnt+'" value="" /></td></tr><tr id="tr_breakfast_4_'+breakfast_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="breakfast_meal_like[]" id="breakfast_meal_like_'+breakfast_cnt+'" onchange="toggleMealLikeIcon(\'breakfast\',\''+breakfast_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_breakfast_meal_like_icon_'+breakfast_cnt+'"></td></tr></table></td></tr><tr id="tr_breakfast_5_'+breakfast_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="breakfast_consultant_remark[]" id="breakfast_consultant_remark_'+breakfast_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_breakfast_6_'+breakfast_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_breakfast_7_'+breakfast_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_breakfast_8_'+breakfast_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'breakfast\','+breakfast_cnt+')"/></td></tr><tr id="tr_breakfast_9_'+breakfast_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');

                        $("#breakfast_item_"+breakfast_cnt).autoSuggest(data.items, {asHtmlID:"breakfast_item_"+breakfast_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "breakfast_"+breakfast_cnt});

                        breakfast_cnt = breakfast_cnt + 1;       
                        $('#breakfast_cnt').val(breakfast_cnt);
                        breakfast_totalRow = breakfast_totalRow + 1;       
                        $('#breakfast_totalRow').val(breakfast_totalRow);
                });


                var brunch_cnt = parseInt($('#brunch_cnt').val());
                var brunch_totalRow = parseInt($('#brunch_totalRow').val());
                var data = {items:<?php echo getMealsAutoList($user_id); ?>};
                var brunch_prefill_arr = new Array(<?php echo count($brunch_prefill_arr);?>);

                <?php 
                for($m=0;$m<count($brunch_prefill_arr);$m++)
                { ?>
                        brunch_prefill_arr[<?php echo $m;?>] = <?php echo getPreFillList($brunch_prefill_arr[$m]) ; ?>;
                <?php
                } ?>

                for(var i=0; i < brunch_cnt; i++)
                {
                        $("#brunch_item_"+i).autoSuggest(data.items, {asHtmlID:"brunch_item_"+i, preFill: brunch_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "brunch_"+i });
                }	

                $('#addMoreBrunch').click(function() {
                        var brunch_cnt = parseInt($('#brunch_cnt').val());
                        var brunch_totalRow = parseInt($('#brunch_totalRow').val());
                        $('#tblbrunch tr[id="add_before_this_brunch"]').before('<tr id="tr_brunch_1_'+brunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="brunch_item[]" type="text" class="input" id="brunch_item_'+brunch_cnt+'" value="" /></td></tr><tr id="tr_brunch_2_'+brunch_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="brunch_other_item[]" type="text" class="input" id="brunch_other_item_'+brunch_cnt+'" value="" /></td></tr><tr id="tr_brunch_3_'+brunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="brunch_quantity[]" id="brunch_quantity_'+brunch_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_brunch_'+brunch_cnt+'"></span><input type="hidden" name="brunch_measure[]" id="brunch_measure_'+brunch_cnt+'" value="" /></td><tr id="tr_brunch_4_'+brunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="brunch_meal_like[]" id="brunch_meal_like_'+brunch_cnt+'" onchange="toggleMealLikeIcon(\'brunch\',\''+brunch_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_brunch_meal_like_icon_'+brunch_cnt+'"></td></tr></table></td></tr><tr id="tr_brunch_5_'+brunch_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="brunch_consultant_remark[]" id="brunch_consultant_remark_'+brunch_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_brunch_6_'+brunch_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_brunch_7_'+brunch_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_brunch_8_'+brunch_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'brunch\','+brunch_cnt+')"/></td></tr><tr id="tr_brunch_9_'+brunch_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');

                        $("#brunch_item_"+brunch_cnt).autoSuggest(data.items, {asHtmlID:"brunch_item_"+brunch_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "brunch_"+brunch_cnt});
                        brunch_cnt = brunch_cnt + 1;       
                        $('#brunch_cnt').val(brunch_cnt);
                        brunch_totalRow = brunch_totalRow + 1;       
                        $('#brunch_totalRow').val(brunch_totalRow);
                });

                var lunch_cnt = parseInt($('#lunch_cnt').val());
                var lunch_totalRow = parseInt($('#lunch_totalRow').val());
                var data = {items:<?php echo getMealsAutoList($user_id); ?>};
                var lunch_prefill_arr = new Array(<?php echo count($lunch_prefill_arr);?>);

                <?php 
                for($m=0;$m<count($lunch_prefill_arr);$m++)
                { ?>
                        lunch_prefill_arr[<?php echo $m;?>] = <?php echo getPreFillList($lunch_prefill_arr[$m]) ; ?>;
                <?php
                } ?>

                for(var i=0; i < lunch_cnt; i++)
                {
                        $("#lunch_item_"+i).autoSuggest(data.items, {asHtmlID:"lunch_item_"+i, preFill: lunch_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "lunch_"+i });
                }	

                $('#addMoreLunch').click(function() {
                        var lunch_cnt = parseInt($('#lunch_cnt').val());
                        var lunch_totalRow = parseInt($('#lunch_totalRow').val());
                        $('#tbllunch tr[id="add_before_this_lunch"]').before('<tr id="tr_lunch_1_'+lunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="lunch_item[]" type="text" class="input" id="lunch_item_'+lunch_cnt+'" value="" /></td></tr><tr id="tr_lunch_2_'+lunch_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="lunch_other_item[]" type="text" class="input" id="lunch_other_item_'+lunch_cnt+'" value="" /></td></tr><tr id="tr_lunch_3_'+lunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="lunch_quantity[]" id="lunch_quantity_'+lunch_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_lunch_'+lunch_cnt+'"></span><input type="hidden" name="lunch_measure[]" id="lunch_measure_'+lunch_cnt+'" value="" /></td></tr><tr id="tr_lunch_4_'+lunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="lunch_meal_like[]" id="lunch_meal_like_'+lunch_cnt+'" onchange="toggleMealLikeIcon(\'lunch\',\''+lunch_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_lunch_meal_like_icon_'+lunch_cnt+'"></td></tr></table></td></tr><tr id="tr_lunch_5_'+lunch_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="lunch_consultant_remark[]" id="lunch_consultant_remark_'+lunch_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_lunch_6_'+lunch_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_lunch_7_'+lunch_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_lunch_8_'+lunch_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'lunch\','+lunch_cnt+')"/></td></tr><tr id="tr_lunch_9_'+lunch_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                        $("#lunch_item_"+lunch_cnt).autoSuggest(data.items, {asHtmlID:"lunch_item_"+lunch_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "lunch_"+lunch_cnt});
                        lunch_cnt = lunch_cnt + 1;       
                        $('#lunch_cnt').val(lunch_cnt);
                        lunch_totalRow = lunch_totalRow + 1;       
                        $('#lunch_totalRow').val(lunch_totalRow);
                });

                var snacks_cnt = parseInt($('#snacks_cnt').val());
                var snacks_totalRow = parseInt($('#snacks_totalRow').val());
                var data = {items:<?php echo getMealsAutoList($user_id); ?>};
                var snacks_prefill_arr = new Array(<?php echo count($snacks_prefill_arr);?>);
                <?php 
                for($m=0;$m<count($snacks_prefill_arr);$m++)
                { ?>
                        snacks_prefill_arr[<?php echo $m;?>] = <?php echo getPreFillList($snacks_prefill_arr[$m]) ; ?>;
                <?php
                } ?>

                for(var i=0; i < snacks_cnt; i++)
                {
                        $("#snacks_item_"+i).autoSuggest(data.items, {asHtmlID:"snacks_item_"+i, preFill: snacks_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "snacks_"+i });
                }	

                $('#addMoreSnacks').click(function() {
                        var snacks_cnt = parseInt($('#snacks_cnt').val());
                        var snacks_totalRow = parseInt($('#snacks_totalRow').val());
                        $('#tblsnacks tr[id="add_before_this_snacks"]').before('<tr id="tr_snacks_1_'+snacks_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="snacks_item[]" type="text" class="input" id="snacks_item_'+snacks_cnt+'" value="" /></td></tr><tr id="tr_snacks_2_'+snacks_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="snacks_other_item[]" type="text" class="input" id="snacks_other_item_'+snacks_cnt+'" value="" /></td></tr><tr id="tr_snacks_3_'+snacks_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="snacks_quantity[]" id="snacks_quantity_'+snacks_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_snacks_'+snacks_cnt+'"></span><input type="hidden" name="snacks_measure[]" id="snacks_measure_'+snacks_cnt+'" value="" /></td></tr><tr id="tr_snacks_4_'+snacks_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="snacks_meal_like[]" id="snacks_meal_like_'+snacks_cnt+'" onchange="toggleMealLikeIcon(\'snacks\',\''+snacks_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_snacks_meal_like_icon_'+snacks_cnt+'"></td></tr></table></td></tr><tr id="tr_snacks_5_'+snacks_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="snacks_consultant_remark[]" id="snacks_consultant_remark_'+snacks_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_snacks_6_'+snacks_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_snacks_7_'+snacks_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_snacks_8_'+snacks_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'snacks\','+snacks_cnt+')"/></td></tr><tr id="tr_snacks_9_'+snacks_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                        $("#snacks_item_"+snacks_cnt).autoSuggest(data.items, {asHtmlID:"snacks_item_"+snacks_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "snacks_"+snacks_cnt});
                        snacks_cnt = snacks_cnt + 1;       
                        $('#snacks_cnt').val(snacks_cnt);
                        snacks_totalRow = snacks_totalRow + 1;       
                        $('#snacks_totalRow').val(snacks_totalRow);
                });

                var dinner_cnt = parseInt($('#dinner_cnt').val());
                var dinner_totalRow = parseInt($('#dinner_totalRow').val());
                var data = {items:<?php echo getMealsAutoList($user_id); ?>};
                var dinner_prefill_arr = new Array(<?php echo count($dinner_prefill_arr);?>);

                <?php 
                for($m=0;$m<count($dinner_prefill_arr);$m++)
                { ?>
                    dinner_prefill_arr[<?php echo $m;?>] = <?php echo getPreFillList($dinner_prefill_arr[$m]) ; ?>;
                <?php
                } ?>

                for(var i=0; i < dinner_cnt; i++)
                {
                    $("#dinner_item_"+i).autoSuggest(data.items, {asHtmlID:"dinner_item_"+i, preFill: dinner_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "dinner_"+i });
                }	

                $('#addMoreDinner').click(function() {
                    var dinner_cnt = parseInt($('#dinner_cnt').val());
                    var dinner_totalRow = parseInt($('#dinner_totalRow').val());
                    $('#tbldinner tr[id="add_before_this_dinner"]').before('<tr id="tr_dinner_1_'+dinner_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="dinner_item[]" type="text" class="input" id="dinner_item_'+dinner_cnt+'" value="" /></td></tr><tr id="tr_dinner_2_'+dinner_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="dinner_other_item[]" type="text" class="input" id="dinner_other_item_'+dinner_cnt+'" value="" /></td></tr><tr id="tr_dinner_3_'+dinner_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="dinner_quantity[]" id="dinner_quantity_'+dinner_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_dinner_'+dinner_cnt+'"></span><input type="hidden" name="dinner_measure[]" id="dinner_measure_'+dinner_cnt+'" value="" /></td></tr><tr id="tr_dinner_4_'+dinner_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="dinner_meal_like[]" id="dinner_meal_like_'+dinner_cnt+'" onchange="toggleMealLikeIcon(\'dinner\',\''+dinner_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_dinner_meal_like_icon_'+dinner_cnt+'"></td></tr></table></td></tr><tr id="tr_dinner_5_'+dinner_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="dinner_consultant_remark[]" id="dinner_consultant_remark_'+dinner_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_dinner_6_'+dinner_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_dinner_7_'+dinner_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_dinner_8_'+dinner_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'dinner\','+dinner_cnt+')"/></td></tr><tr id="tr_dinner_9_'+dinner_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                    $("#dinner_item_"+dinner_cnt).autoSuggest(data.items, {asHtmlID:"dinner_item_"+dinner_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "dinner_"+dinner_cnt});
                    dinner_cnt = dinner_cnt + 1;       
                    $('#dinner_cnt').val(dinner_cnt);
                    dinner_totalRow = dinner_totalRow + 1;       
                    $('#dinner_totalRow').val(dinner_totalRow);
                });

                var getUsersDailyMealsDetails = function() {
                        var day = document.getElementById('day').value;
                        var month = document.getElementById('month').value;
                        var year = document.getElementById('year').value;
                        link='remote.php?action=getusersdailymealsdetails&day='+day+'&month='+month+'&year='+year;
                        var linkComp = link.split( "?");
                        var result;
                        var obj = new ajaxObject(linkComp[0], fin);
                        obj.update(linkComp[1],"POST");
                        obj.callback = function (responseTxt, responseStat) {
                                // we'll do something to process the data here.
                                result = responseTxt;
                                //alert(result);
                                temparr = result.split("####");
                                document.getElementById('divbreakfast').innerHTML = temparr[0];  
                                $('#breakfast_cnt').val(temparr[1]);
                                $('#breakfast_totalRow').val(temparr[1]);
                                var breakfast_cnt = parseInt($('#breakfast_cnt').val());
                                var new_breakfast_prefill_arr = new Array(breakfast_cnt);
                                if( (temparr[2] == '') || (temparr[2] == '{}') )
                                {

                                }
                                else
                                {
                                        new_breakfast_prefill_arr = temparr[2].split('***');
                                }

                                for(var i=0; i < breakfast_cnt; i++)
                                {
                                    if (new_breakfast_prefill_arr[i] == undefined)
                                    {
                                            new_breakfast_prefill_arr[i] = '{}';
                                    }	

                                    breakfast_prefill_arr[i] = JSON.parse(new_breakfast_prefill_arr[i]);
                                    $("#breakfast_item_"+i).autoSuggest(data.items, {asHtmlID:"breakfast_item_"+i, preFill: breakfast_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "breakfast_"+i });
                                }

                                $('#addMoreBreakfast').click(function() {
                                    var breakfast_cnt = parseInt($('#breakfast_cnt').val());
                                    var breakfast_totalRow = parseInt($('#breakfast_totalRow').val());
                                    $('#tblbreakfast tr[id="add_before_this_breakfast"]').before('<tr id="tr_breakfast_1_'+breakfast_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="breakfast_item[]" type="text" class="input" id="breakfast_item_'+breakfast_cnt+'" value="" /></td></tr><tr id="tr_breakfast_2_'+breakfast_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="breakfast_other_item[]" type="text" class="input" id="breakfast_other_item_'+breakfast_cnt+'" value="" /></td></tr><tr id="tr_breakfast_3_'+breakfast_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="breakfast_quantity[]" id="breakfast_quantity_'+breakfast_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_breakfast_'+breakfast_cnt+'"></span><input type="hidden" name="breakfast_measure[]" id="breakfast_measure_'+breakfast_cnt+'" value="" /></td></tr><tr id="tr_breakfast_4_'+breakfast_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="breakfast_meal_like[]" id="breakfast_meal_like_'+breakfast_cnt+'" onchange="toggleMealLikeIcon(\'breakfast\',\''+breakfast_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_breakfast_meal_like_icon_'+breakfast_cnt+'"></td></tr></table></td></tr><tr id="tr_breakfast_5_'+breakfast_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="breakfast_consultant_remark[]" id="breakfast_consultant_remark_'+breakfast_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_breakfast_6_'+breakfast_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_breakfast_7_'+breakfast_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_breakfast_8_'+breakfast_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'breakfast\','+breakfast_cnt+')"/></td></tr><tr id="tr_breakfast_9_'+breakfast_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                                    $("#breakfast_item_"+breakfast_cnt).autoSuggest(data.items, {asHtmlID:"breakfast_item_"+breakfast_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "breakfast_"+breakfast_cnt});
                                    breakfast_cnt = breakfast_cnt + 1;       
                                    $('#breakfast_cnt').val(breakfast_cnt);
                                    breakfast_totalRow = breakfast_totalRow + 1;       
                                    $('#breakfast_totalRow').val(breakfast_totalRow);
                                });

                                document.getElementById('divbrunch').innerHTML = temparr[3];  
                                $('#brunch_cnt').val(temparr[4]);
                                $('#brunch_totalRow').val(temparr[4]);
                                var brunch_cnt = parseInt($('#brunch_cnt').val());
                                var new_brunch_prefill_arr = new Array(brunch_cnt);
                                if( (temparr[5] == '') || (temparr[5] == '{}') )
                                {

                                }
                                else
                                {
                                        new_brunch_prefill_arr = temparr[5].split('***');
                                }

                                for(var i=0; i < brunch_cnt; i++)
                                {
                                        if (new_brunch_prefill_arr[i] == undefined)
                                        {
                                                new_brunch_prefill_arr[i] = '{}';
                                        }	
                                        brunch_prefill_arr[i] = JSON.parse(new_brunch_prefill_arr[i]);
                                        $("#brunch_item_"+i).autoSuggest(data.items, {asHtmlID:"brunch_item_"+i, preFill: brunch_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "brunch_"+i });
                                }

                                $('#addMoreBrunch').click(function() {
                                    var brunch_cnt = parseInt($('#brunch_cnt').val());
                                    var brunch_totalRow = parseInt($('#brunch_totalRow').val());
                                    $('#tblbrunch tr[id="add_before_this_brunch"]').before('<tr id="tr_brunch_1_'+brunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="brunch_item[]" type="text" class="input" id="brunch_item_'+brunch_cnt+'" value="" /></td></tr><tr id="tr_brunch_2_'+brunch_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="brunch_other_item[]" type="text" class="input" id="brunch_other_item_'+brunch_cnt+'" value="" /></td></tr><tr id="tr_brunch_3_'+brunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="brunch_quantity[]" id="brunch_quantity_'+brunch_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_brunch_'+brunch_cnt+'"></span><input type="hidden" name="brunch_measure[]" id="brunch_measure_'+brunch_cnt+'" value="" /></td></tr><tr id="tr_brunch_4_'+brunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="brunch_meal_like[]" id="brunch_meal_like_'+brunch_cnt+'" onchange="toggleMealLikeIcon(\'brunch\',\''+brunch_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_brunch_meal_like_icon_'+brunch_cnt+'"></td></tr></table></td></tr><tr id="tr_brunch_5_'+brunch_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="brunch_consultant_remark[]" id="brunch_consultant_remark_'+brunch_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_brunch_6_'+brunch_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_brunch_7_'+brunch_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_brunch_8_'+brunch_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'brunch\','+brunch_cnt+')"/></td></tr><tr id="tr_brunch_9_'+brunch_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                                    $("#brunch_item_"+brunch_cnt).autoSuggest(data.items, {asHtmlID:"brunch_item_"+brunch_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "brunch_"+brunch_cnt});
                                    brunch_cnt = brunch_cnt + 1;       
                                    $('#brunch_cnt').val(brunch_cnt);
                                    brunch_totalRow = brunch_totalRow + 1;       
                                    $('#brunch_totalRow').val(brunch_totalRow);
                                });

                                document.getElementById('divlunch').innerHTML = temparr[6];  
                                $('#lunch_cnt').val(temparr[7]);
                                $('#lunch_totalRow').val(temparr[7]);
                                var lunch_cnt = parseInt($('#lunch_cnt').val());
                                var new_lunch_prefill_arr = new Array(lunch_cnt);
                                if( (temparr[8] == '') || (temparr[8] == '{}') )
                                {

                                }
                                else
                                {
                                        new_lunch_prefill_arr = temparr[8].split('***');
                                }

                                for(var i=0; i < lunch_cnt; i++)
                                {
                                        if (new_lunch_prefill_arr[i] == undefined)
                                        {
                                                new_lunch_prefill_arr[i] = '{}';
                                        }	
                                        lunch_prefill_arr[i] = JSON.parse(new_lunch_prefill_arr[i]);
                                        $("#lunch_item_"+i).autoSuggest(data.items, {asHtmlID:"lunch_item_"+i, preFill: lunch_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "lunch_"+i });
                                }

                                $('#addMoreLunch').click(function() {
                                        var lunch_cnt = parseInt($('#lunch_cnt').val());
                                        var lunch_totalRow = parseInt($('#lunch_totalRow').val());
                                        $('#tbllunch tr[id="add_before_this_lunch"]').before('<tr id="tr_lunch_1_'+lunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="lunch_item[]" type="text" class="input" id="lunch_item_'+lunch_cnt+'" value="" /></td></tr><tr id="tr_lunch_2_'+lunch_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="lunch_other_item[]" type="text" class="input" id="lunch_other_item_'+lunch_cnt+'" value="" /></td></tr><tr id="tr_lunch_3_'+lunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="lunch_quantity[]" id="lunch_quantity_'+lunch_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_lunch_'+lunch_cnt+'"></span><input type="hidden" name="lunch_measure[]" id="lunch_measure_'+lunch_cnt+'" value="" /></td></tr><tr id="tr_lunch_4_'+lunch_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="lunch_meal_like[]" id="lunch_meal_like_'+lunch_cnt+'" onchange="toggleMealLikeIcon(\'lunch\',\''+lunch_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_lunch_meal_like_icon_'+lunch_cnt+'"></td></tr></table></td></tr><tr id="tr_lunch_5_'+lunch_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="lunch_consultant_remark[]" id="lunch_consultant_remark_'+lunch_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_lunch_6_'+lunch_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_lunch_7_'+lunch_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_lunch_8_'+lunch_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'lunch\','+lunch_cnt+')"/></td></tr><tr id="tr_lunch_9_'+lunch_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                                        $("#lunch_item_"+lunch_cnt).autoSuggest(data.items, {asHtmlID:"lunch_item_"+lunch_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "lunch_"+lunch_cnt});
                                        lunch_cnt = lunch_cnt + 1;       
                                        $('#lunch_cnt').val(lunch_cnt);
                                        lunch_totalRow = lunch_totalRow + 1;       
                                        $('#lunch_totalRow').val(lunch_totalRow);
                                });

                                document.getElementById('divsnacks').innerHTML = temparr[9];  
                                $('#snacks_cnt').val(temparr[10]);
                                $('#snacks_totalRow').val(temparr[10]);
                                var snacks_cnt = parseInt($('#snacks_cnt').val());
                                var new_snacks_prefill_arr = new Array(snacks_cnt);
                                if( (temparr[11] == '') || (temparr[11] == '{}') )
                                {

                                }
                                else
                                {
                                        new_snacks_prefill_arr = temparr[11].split('***');
                                }

                                for(var i=0; i < snacks_cnt; i++)
                                {
                                        if (new_snacks_prefill_arr[i] == undefined)
                                        {
                                                new_snacks_prefill_arr[i] = '{}';
                                        }	
                                        snacks_prefill_arr[i] = JSON.parse(new_snacks_prefill_arr[i]);
                                        $("#snacks_item_"+i).autoSuggest(data.items, {asHtmlID:"snacks_item_"+i, preFill: snacks_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "snacks_"+i });
                                }

                                $('#addMoreSnacks').click(function() {
                                        var snacks_cnt = parseInt($('#snacks_cnt').val());
                                        var snacks_totalRow = parseInt($('#snacks_totalRow').val());
                                        $('#tblsnacks tr[id="add_before_this_snacks"]').before('<tr id="tr_snacks_1_'+snacks_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="snacks_item[]" type="text" class="input" id="snacks_item_'+snacks_cnt+'" value="" /></td></tr><tr id="tr_snacks_2_'+snacks_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="snacks_other_item[]" type="text" class="input" id="snacks_other_item_'+snacks_cnt+'" value="" /></td></tr><tr id="tr_snacks_3_'+snacks_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="snacks_quantity[]" id="snacks_quantity_'+snacks_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_snacks_'+snacks_cnt+'"></span><input type="hidden" name="snacks_measure[]" id="snacks_measure_'+snacks_cnt+'" value="" /></td></tr><tr id="tr_snacks_4_'+snacks_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="snacks_meal_like[]" id="snacks_meal_like_'+snacks_cnt+'" onchange="toggleMealLikeIcon(\'snacks\',\''+snacks_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_snacks_meal_like_icon_'+snacks_cnt+'"></td></tr></table></td></tr><tr id="tr_snacks_5_'+snacks_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="snacks_consultant_remark[]" id="snacks_consultant_remark_'+snacks_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_snacks_6_'+snacks_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_snacks_7_'+snacks_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_snacks_8_'+snacks_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'snacks\','+snacks_cnt+')"/></td></tr><tr id="tr_snacks_9_'+snacks_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                                        $("#snacks_item_"+snacks_cnt).autoSuggest(data.items, {asHtmlID:"snacks_item_"+snacks_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "snacks_"+snacks_cnt});
                                        snacks_cnt = snacks_cnt + 1;       
                                        $('#snacks_cnt').val(snacks_cnt);
                                        snacks_totalRow = snacks_totalRow + 1;       
                                        $('#snacks_totalRow').val(snacks_totalRow);
                                });

                                document.getElementById('divdinner').innerHTML = temparr[12];  
                                $('#dinner_cnt').val(temparr[13]);
                                $('#dinner_totalRow').val(temparr[13]);
                                var dinner_cnt = parseInt($('#dinner_cnt').val());
                                var new_dinner_prefill_arr = new Array(dinner_cnt);
                                if( (temparr[14] == '') || (temparr[14] == '{}') )
                                {

                                }
                                else
                                {
                                        new_dinner_prefill_arr = temparr[14].split('***');
                                }

                                for(var i=0; i < dinner_cnt; i++)
                                {
                                        if (new_dinner_prefill_arr[i] == undefined)
                                        {
                                                new_dinner_prefill_arr[i] = '{}';
                                        }	
                                        dinner_prefill_arr[i] = JSON.parse(new_dinner_prefill_arr[i]);
                                        $("#dinner_item_"+i).autoSuggest(data.items, {asHtmlID:"dinner_item_"+i, preFill: dinner_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "dinner_"+i });
                                }

                                $('#addMoreDinner').click(function() {
                                        var dinner_cnt = parseInt($('#dinner_cnt').val());
                                        var dinner_totalRow = parseInt($('#dinner_totalRow').val());
                                        $('#tbldinner tr[id="add_before_this_dinner"]').before('<tr id="tr_dinner_1_'+dinner_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td><td width="400" height="35" align="left" valign="top"><input name="dinner_item[]" type="text" class="input" id="dinner_item_'+dinner_cnt+'" value="" /></td></tr><tr id="tr_dinner_2_'+dinner_cnt+'"  style="display:none;"><td height="35" align="left" valign="top">&nbsp;</td><td height="35" align="left" valign="top"><input name="dinner_other_item[]" type="text" class="input" id="dinner_other_item_'+dinner_cnt+'" value="" /></td></tr><tr id="tr_dinner_3_'+dinner_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td><td width="400" height="35" align="left" valign="top"><select name="dinner_quantity[]" id="dinner_quantity_'+dinner_cnt+'"><?php echo getMealQuantityOptions(''); ?></select>&nbsp;<span id="spn_dinner_'+dinner_cnt+'"></span><input type="hidden" name="dinner_measure[]" id="dinner_measure_'+dinner_cnt+'" value="" /></td></tr><tr id="tr_dinner_4_'+dinner_cnt+'"><td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td><td width="400" height="35" align="left" valign="top"><table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td width="50" height="35" align="left" valign="top"><select name="dinner_meal_like[]" id="dinner_meal_like_'+dinner_cnt+'" onchange="toggleMealLikeIcon(\'dinner\',\''+dinner_cnt+'\');"><?php echo getMealLikeOptions(''); ?></select></td><td width="300" height="35" align="left" valign="top" id="spn_dinner_meal_like_icon_'+dinner_cnt+'"></td></tr></table></td></tr><tr id="tr_dinner_5_'+dinner_cnt+'"><td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td><td width="400" align="left" valign="top"><textarea name="dinner_consultant_remark[]" id="dinner_consultant_remark_'+dinner_cnt+'" cols="25" rows="3"></textarea></td></tr><tr id="tr_dinner_6_'+dinner_cnt+'" style="display:none;" valign="top"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr><tr id="tr_dinner_7_'+dinner_cnt+'"><td align="left" colspan="2" valign="top"></td></tr><tr id="tr_dinner_8_'+dinner_cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'dinner\','+dinner_cnt+')"/></td></tr><tr id="tr_dinner_9_'+dinner_cnt+'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                                        $("#dinner_item_"+dinner_cnt).autoSuggest(data.items, {asHtmlID:"dinner_item_"+dinner_cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "dinner_"+dinner_cnt});
                                        dinner_cnt = dinner_cnt + 1;       
                                        $('#dinner_cnt').val(dinner_cnt);
                                        dinner_totalRow = dinner_totalRow + 1;       
                                        $('#dinner_totalRow').val(dinner_totalRow);
                                });	
                        }
                }

                $("#day").change(getUsersDailyMealsDetails);
                $("#month").change(getUsersDailyMealsDetails);
                $("#year").change(getUsersDailyMealsDetails);

                blinking($(".err_msg_blink"));
                function blinking(elm) {
                        timer = setInterval(blink, 100);
                        function blink() {
                                elm.fadeOut(500, function() {
                                elm.fadeIn(500);
                        });
                        }
                }

                $('#slider1').bxSlider();
                $('#slider2').bxSlider();
                $('#slider3').bxSlider();
                $('#slider4').bxSlider();
                $('#slider5').bxSlider();
                $('#slider6').bxSlider();

                $('#slider_main1').bxSlider();
                $('#slider_main2').bxSlider();
                $('#slider_main3').bxSlider();
                $('#slider_main4').bxSlider();
                $('#slider_main5').bxSlider();
                $('#slider_main6').bxSlider();	
        });
    </script>
    <link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
    <script type="text/javascript" src="js/ddsmoothmenu.js"></script>
    <script type="text/javascript">
        ddsmoothmenu.init({
        mainmenuid: "smoothmenu1", //menu DIV id
        orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
        classname: 'ddsmoothmenu', //class added to menu's outer DIV
        //customtheme: ["#1c5a80", "#18374a"],
        contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
        })
    </script>
</head>
<body>
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<!--header-->
<header> <?php include_once('header.php');?>
 <?php
                    if(isLoggedIn())
                    { 
                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
                    }
                    ?>
</header>
<!--header End -->    
<!--breadcrumb-->    
    <div class="breadcrumb">
                <div class="container">
                    <div class="row">
                    <div class="col-lg-12">	
                      <?php echo getBreadcrumbCode($page_id);?>  
                       </div>
                       </div>
                </div>
            </div>
<!--breadcrumb end --> 
<!--container-->
              <div class="container">
              <div class="row">
              <div class=" col-md-8">
              <table width="100%" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
                            <tr>
                                <td align="left" valign="top" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
                                    <form action="<?php echo SITE_URL.'/daily_meal.php';?>" id="frmdaily_meal" method="post" name="frmdaily_meal">
                                        <input type="hidden" name="breakfast_cnt" id="breakfast_cnt" value="<?php echo $breakfast_cnt;?>" />
                                        <input type="hidden" name="breakfast_totalRow" id="breakfast_totalRow" value="<?php echo $breakfast_totalRow;?>" />
                                        <input type="hidden" name="brunch_cnt" id="brunch_cnt" value="<?php echo $brunch_cnt;?>" />
                                        <input type="hidden" name="brunch_totalRow" id="brunch_totalRow" value="<?php echo $brunch_totalRow;?>" />
                                        <input type="hidden" name="lunch_cnt" id="lunch_cnt" value="<?php echo $lunch_cnt;?>" />
                                        <input type="hidden" name="lunch_totalRow" id="lunch_totalRow" value="<?php echo $lunch_totalRow;?>" />
                                        <input type="hidden" name="snacks_cnt" id="snacks_cnt" value="<?php echo $snacks_cnt;?>" />
                                        <input type="hidden" name="snacks_totalRow" id="snacks_totalRow" value="<?php echo $snacks_totalRow;?>" />
                                        <input type="hidden" name="dinner_cnt" id="dinner_cnt" value="<?php echo $dinner_cnt;?>" />
                                        <input type="hidden" name="dinner_totalRow" id="dinner_totalRow" value="<?php echo $dinner_totalRow;?>" />
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td height="50" align="left" valign="top" class="header_title"><?php echo getPageContents($page_id);?></td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="top">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="30%" height="50" align="left" valign="middle" class="Header_brown">Date:</td>
                                                            <td width="70%" height="50" align="left" valign="middle">
                                                                <select name="day" id="day">
                                                                    <option value="<?php echo $yesterday_day;?>" <?php if($day == $yesterday_day) { ?> selected="selected" <?php } ?>><?php echo $yesterday_day;?></option>
                                                                    <option value="<?php echo $today_day;?>" <?php if($day == $today_day) { ?> selected="selected" <?php } ?>><?php echo $today_day;?></option>
                                                                </select>
                                                                <select name="month" id="month">
                                                                    <?php echo getMonthOptions($month,$yesterday_month,$today_month); ?>
                                                                </select>
                                                                <select name="year" id="year">
                                                                <?php
                                                                for($i=$yesterday_year;$i<=$today_year;$i++)
                                                                { ?>
                                                                    <option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                                <?php
                                                                } ?>	
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr id="tr_err_meal_date" style="display:<?php echo $tr_err_meal_date;?>;" valign="top">
                                                            <td align="left" colspan="2" class="err_msg_blink" valign="top"><?php echo $err_meal_date;?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>        
                                            <tr>
                                                <td align="left" valign="top" class="err_msg_blink"><?php echo $err_msg;?></td>
                                            </tr>            
                                            <tr>
                                                <td align="left" valign="top">          
                                                    <div id="tabs_container">
                                                        <ul class="tabs"> 
                                                            <li class="active" rel="tab1">Breakfast</li>
                                                            <li rel="tab2">Brunch</li>
                                                            <li rel="tab3">Lunch</li>
                                                            <li rel="tab4">Snacks</li>
                                                            <li rel="tab5">Dinner</li>
                                                        </ul>
                                                        <div class="tab_container"> 
                                                            <div id="tab1" class="tab_content" style="display:block;"> 
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td align="left" valign="top">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td width="20%" height="50" align="left" valign="top"><img src="images/icon_breakfast.jpg" width="40" height="40" /></td>
                                                                                    <td width="40%" height="50" align="left" valign="middle" class="Header_brown">Breakfast</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle" class="Header_brown"></td>
                                                                                    <td width="20%" height="50" align="left" valign="middle"></td>
                                                                                </tr>
                                                                            </table>
                                                                            <div id="divbreakfast">                          
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblbreakfast">
                                                                                    <tr>
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <select name="breakfast_time" id="breakfast_time">
                                                                                                <option value="">Select Time</option>
                                                                                                <?php echo getTimeOptions($breakfast_start_time,$breakfast_end_time,$breakfast_time); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_time" style="display:<?php echo $tr_err_breakfast_time;?>;" valign="top">
                                                                                        <td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_breakfast_time;?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                for($i=0;$i<$breakfast_totalRow;$i++)
                                                                                { ?>
                                                                                    <tr id="tr_breakfast_1_<?php echo $i;?>">
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <input name="breakfast_item[]" type="text"  id="breakfast_item_<?php echo $i;?>" value="<?php echo $breakfast_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_2_<?php echo $i;?>"  style="display:<?php echo $tr_breakfast_other_item[$i];?>;">
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <input name="breakfast_other_item[]" type="text"  id="breakfast_other_item_<?php echo $i;?>" value="<?php echo $breakfast_other_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_3_<?php echo $i;?>">
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <select name="breakfast_quantity[]" id="breakfast_quantity_<?php echo $i;?>">
                                                                                                <?php echo getMealQuantityOptions($breakfast_quantity_arr[$i]); ?>
                                                                                            </select>
                                                                                            <span id="spn_breakfast_<?php echo $i;?>"><strong><?php echo $breakfast_measure_arr[$i]?></strong></span>
                                                                                            <input type="hidden" name="breakfast_measure[]" id="breakfast_measure_<?php echo $i;?>" value="<?php echo $breakfast_measure_arr[$i]?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_4_<?php echo $i;?>">
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <table width="40%" border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td width="20%" height="35" align="left" valign="top">
                                                                                                        <select name="breakfast_meal_like[]" id="breakfast_meal_like_<?php echo $i;?>" onchange="toggleMealLikeIcon('breakfast','<?php echo $i;?>');">
                                                                                                            <?php echo getMealLikeOptions($breakfast_meal_like_arr[$i]); ?>
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td width="40%" height="35" align="left" valign="top" id="spn_breakfast_meal_like_icon_<?php echo $i;?>"><?php echo getMealLikeIcon($breakfast_meal_like_arr[$i]); ?></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_5_<?php echo $i;?>">
                                                                                        <td width="30%" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>
                                                                                        <td width="70%" align="left" valign="top">
                                                                                            <textarea name="breakfast_consultant_remark[]" id="breakfast_consultant_remark_<?php echo $i; ?>" cols="25" rows="3"><?php echo $breakfast_consultant_remark_arr[$i];?></textarea>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_6_<?php echo $i;?>" style="display:<?php echo $tr_err_breakfast[$i];?>;" valign="top">
                                                                                        <td align="left" colspan="2" class="err_msg" valign="top"><?php echo $err_breakfast[$i];?></td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_7_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
																					<?php
                                                                                    if($i > 0)
                                                                                    { ?>
                                                                                    <tr id="tr_breakfast_8_<?php echo $i;?>">
                                                                                        <td align="right" colspan="2" valign="top">
                                                                                            <input type="button" value="Remove Item" onclick="removeMealRow('breakfast','<?php echo $i;?>')" class="btn btn-danger" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_breakfast_9_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
									            <?php
                                                                                    } 
                                                                                } ?>
                                                                                    <tr id="add_before_this_breakfast">
                                                                                        <td width="30%" height="30" align="left" valign="top">&nbsp;</td>
                                                                                        <td width="70%" height="30" align="left" valign="top">
                                                                                            <input type="button" value="add more" id="addMoreBreakfast" name="addMoreBreakfast" class="btn btn-success" />
                                                                                        </td>
                                                                                    </tr>	
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="25" align="left" valign="middle">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td height="1" bgcolor="#339900"><img src="images/spacer.gif" width="1" height="1" /></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div id="tab2" class="tab_content" > 
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td width="100%" height="50" align="left" valign="top">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td width="20%" height="50" align="left" valign="top"><img src="images/icon_brunch.jpg" width="40" height="40" /></td>
                                                                                    <td width="40%" height="50" align="left" valign="middle" class="Header_brown">Brunch</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                </tr>
                                                                            </table>

                                                                            <div id="divbrunch"> 
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblbrunch">
                                                                                    <tr>
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <select name="brunch_time" id="brunch_time">
                                                                                                <option value="">Select Time</option>
                                                                                                <?php echo getTimeOptions($brunch_start_time,$brunch_end_time,$brunch_time); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_time" style="display:<?php echo $tr_err_brunch_time;?>;" valign="top">
                                                                                        <td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_brunch_time;?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                for($i=0;$i<$brunch_totalRow;$i++)
                                                                                { ?>
                                                                                    <tr id="tr_brunch_1_<?php echo $i;?>">
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <input name="brunch_item[]" type="text"  id="brunch_item_<?php echo $i;?>" value="<?php echo $brunch_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_2_<?php echo $i;?>"  style="display:<?php echo $tr_brunch_other_item[$i];?>;">
                                                                                        <td  height="35" align="left" valign="top">&nbsp;</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <input name="brunch_other_item[]" type="text" id="brunch_other_item_<?php echo $i;?>" value="<?php echo $brunch_other_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_3_<?php echo $i;?>">
                                                                                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <select name="brunch_quantity[]" id="brunch_quantity_<?php echo $i;?>">
                                                                                                    <?php echo getMealQuantityOptions($brunch_quantity_arr[$i]); ?>
                                                                                            </select>
                                                                                            <span id="spn_brunch_<?php echo $i;?>"><strong><?php echo $brunch_measure_arr[$i]?></strong></span>
                                                                                            <input type="hidden" name="brunch_measure[]" id="brunch_measure_<?php echo $i;?>" value="<?php echo $brunch_measure_arr[$i]?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_4_<?php echo $i;?>">
                                                                                        <td  height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td width="30%" height="35" align="left" valign="top">
                                                                                                        <select name="brunch_meal_like[]" id="brunch_meal_like_<?php echo $i;?>" onchange="toggleMealLikeIcon('brunch','<?php echo $i;?>');">
                                                                                                            <?php echo getMealLikeOptions($brunch_meal_like_arr[$i]); ?>
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td width="%0" height="35" align="left" valign="top" id="spn_brunch_meal_like_icon_<?php echo $i;?>"><?php echo getMealLikeIcon($brunch_meal_like_arr[$i]); ?></td>
                                                                                               </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_5_<?php echo $i;?>">
                                                                                            <td  align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>
                                                                                            <td align="left" valign="top">
                                                                                                    <textarea name="brunch_consultant_remark[]" id="brunch_consultant_remark_<?php echo $i; ?>" cols="25" rows="3"><?php echo $brunch_consultant_remark_arr[$i];?></textarea>
                                                                                            </td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_6_<?php echo $i;?>" style="display:<?php echo $tr_err_brunch[$i];?>;" valign="top">
                                                                                            <td align="left" colspan="2" class="err_msg" valign="top"><?php echo $err_brunch[$i];?></td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_7_<?php echo $i;?>">
                                                                                            <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    if($i > 0)
                                                                                    { ?>
                                                                                    <tr id="tr_brunch_8_<?php echo $i;?>">
                                                                                        <td align="right" colspan="2" valign="top">
                                                                                            <input type="button" value="Remove Item" onclick="removeMealRow('brunch','<?php echo $i;?>')" class="btn btn-danger" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_brunch_9_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    } 
                                                                                } ?>
                                                                                    <tr id="add_before_this_brunch">
                                                                                        <td width="30%" height="30" align="left" valign="top">&nbsp;</td>
                                                                                        <td width="70%" height="30" align="left" valign="top">
                                                                                            <input type="button" value="add more" id="addMoreBrunch" name="addMoreBrunch" class="btn btn-success" />
                                                                                        </td>
                                                                                    </tr>	
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="25" align="left" valign="middle">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td height="1" bgcolor="#339900"><img src="images/spacer.gif" width="1" height="1" /></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>	
                                                            </div>
                                                            <div id="tab3" class="tab_content"> 
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td  height="50" align="left" valign="top">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td  width="20%" height="50" align="left" valign="top"><img src="images/icon_lunch.jpg" width="40" height="40" /></td>
                                                                                    <td width="40%" height="50" align="left" valign="middle" class="Header_brown">Lunch</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                            <div id="divlunch"> 
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbllunch">
                                                                                    <tr>
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <select name="lunch_time" id="lunch_time">
                                                                                                <option value="">Select Time</option>
                                                                                                <?php echo getTimeOptions($lunch_start_time,$lunch_end_time,$lunch_time); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_time" style="display:<?php echo $tr_err_lunch_time;?>;" valign="top">
                                                                                        <td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_lunch_time;?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                for($i=0;$i<$lunch_totalRow;$i++)
                                                                                { ?>
                                                                                    <tr id="tr_lunch_1_<?php echo $i;?>">
                                                                                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>
                                                                                        <td height="35" align="left" valign="top">
                                                                                            <input name="lunch_item[]" type="text" id="lunch_item_<?php echo $i;?>" value="<?php echo $lunch_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_2_<?php echo $i;?>"  style="display:<?php echo $tr_lunch_other_item[$i];?>;">
                                                                                        <td height="35" align="left" valign="top">&nbsp;</td>
                                                                                        <td height="35" align="left" valign="top">
                                                                                            <input name="lunch_other_item[]" type="text" id="lunch_other_item_<?php echo $i;?>" value="<?php echo $lunch_other_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_3_<?php echo $i;?>">
                                                                                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>
                                                                                        <td height="35" align="left" valign="top">
                                                                                            <select name="lunch_quantity[]" id="lunch_quantity_<?php echo $i;?>">
                                                                                                <?php echo getMealQuantityOptions($lunch_quantity_arr[$i]); ?>
                                                                                            </select>
                                                                                            <span id="spn_lunch_<?php echo $i;?>"><strong><?php echo $lunch_measure_arr[$i]?></strong></span>
                                                                                            <input type="hidden" name="lunch_measure[]" id="lunch_measure_<?php echo $i;?>" value="<?php echo $lunch_measure_arr[$i]?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_4_<?php echo $i;?>">
                                                                                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>
                                                                                        <td height="35" align="left" valign="top">
                                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td height="35" align="left" valign="top">
                                                                                                        <select name="lunch_meal_like[]" id="lunch_meal_like_<?php echo $i;?>" onchange="toggleMealLikeIcon('lunch','<?php echo $i;?>');">
                                                                                                            <?php echo getMealLikeOptions($lunch_meal_like_arr[$i]); ?>
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td height="35" align="left" valign="top" id="spn_lunch_meal_like_icon_<?php echo $i;?>"><?php echo getMealLikeIcon($lunch_meal_like_arr[$i]); ?></td>
                                                                                               </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_5_<?php echo $i;?>">
                                                                                        <td align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>
                                                                                        <td align="left" valign="top">
                                                                                            <textarea name="lunch_consultant_remark[]" id="lunch_consultant_remark_<?php echo $i; ?>" cols="25" rows="3"><?php echo $lunch_consultant_remark_arr[$i];?></textarea>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_6_<?php echo $i;?>" style="display:<?php echo $tr_err_lunch[$i];?>;" valign="top">
                                                                                        <td align="left" colspan="2" class="err_msg" valign="top"><?php echo $err_lunch[$i];?></td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_7_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    if($i > 0)
                                                                                    { ?>
                                                                                    <tr id="tr_lunch_8_<?php echo $i;?>">
                                                                                        <td align="right" colspan="2" valign="top">
                                                                                            <input type="button" value="Remove Item" onclick="removeMealRow('lunch','<?php echo $i;?>')" class="btn btn-danger" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_lunch_9_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    } 
                                                                                } ?>
                                                                                    <tr id="add_before_this_lunch">
                                                                                        <td height="30" align="left" valign="top">&nbsp;</td>
                                                                                        <td height="30" align="left" valign="top">
                                                                                            <input type="button" value="add more" id="addMoreLunch" name="addMoreLunch" class="btn btn-success" />
                                                                                        </td>
                                                                                    </tr>	
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="25" align="left" valign="middle">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td height="1" bgcolor="#339900"><img src="images/spacer.gif" width="1" height="1" /></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div id="tab4" class="tab_content"> 
                                                            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td  height="50" align="left" valign="top">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td width="20%" height="50" align="left" valign="top"><img src="images/icon_snacks.jpg" width="40" height="40" /></td>
                                                                                    <td width="40%" height="50" align="left" valign="middle" class="Header_brown">Snacks</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                            <div id="divsnacks"> 
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblsnacks">
                                                                                    <tr>
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <select name="snacks_time" id="snacks_time">
                                                                                                <option value="">Select Time</option>
                                                                                                <?php echo getTimeOptions($snacks_start_time,$snacks_end_time,$snacks_time); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_time" style="display:<?php echo $tr_err_snacks_time;?>;" valign="top">
                                                                                            <td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_snacks_time;?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                for($i=0;$i<$snacks_totalRow;$i++)
                                                                                { ?>
                                                                                    <tr id="tr_snacks_1_<?php echo $i;?>">
                                                                                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>
                                                                                        <td height="35" align="left" valign="top">
                                                                                            <input name="snacks_item[]" type="text" id="snacks_item_<?php echo $i;?>" value="<?php echo $snacks_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_2_<?php echo $i;?>"  style="display:<?php echo $tr_snacks_other_item[$i];?>;">
                                                                                        <td height="35" align="left" valign="top">&nbsp;</td>
                                                                                        <td height="35" align="left" valign="top">
                                                                                            <input name="snacks_other_item[]" type="text" id="snacks_other_item_<?php echo $i;?>" value="<?php echo $snacks_other_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_3_<?php echo $i;?>">
                                                                                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>
                                                                                        <td height="35" align="left" valign="top">
                                                                                            <select name="snacks_quantity[]" id="snacks_quantity_<?php echo $i;?>">
                                                                                                <?php echo getMealQuantityOptions($snacks_quantity_arr[$i]); ?>
                                                                                            </select>
                                                                                            <span id="spn_snacks_<?php echo $i;?>"><strong><?php echo $snacks_measure_arr[$i]?></strong></span>
                                                                                            <input type="hidden" name="snacks_measure[]" id="snacks_measure_<?php echo $i;?>" value="<?php echo $snacks_measure_arr[$i]?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_4_<?php echo $i;?>">
                                                                                        <td  height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td  height="35" align="left" valign="top">
                                                                                                        <select name="snacks_meal_like[]" id="snacks_meal_like_<?php echo $i;?>" onchange="toggleMealLikeIcon('snacks','<?php echo $i;?>');">
                                                                                                            <?php echo getMealLikeOptions($snacks_meal_like_arr[$i]); ?>
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td  height="35" align="left" valign="top" id="spn_snacks_meal_like_icon_<?php echo $i;?>"><?php echo getMealLikeIcon($snacks_meal_like_arr[$i]); ?></td>
                                                                                               </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_5_<?php echo $i;?>">
                                                                                        <td  align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>
                                                                                        <td  align="left" valign="top">
                                                                                            <textarea name="snacks_consultant_remark[]" id="snacks_consultant_remark_<?php echo $i; ?>" cols="25" rows="3"><?php echo $snacks_consultant_remark_arr[$i];?></textarea>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_6_<?php echo $i;?>" style="display:<?php echo $tr_err_snacks[$i];?>;" valign="top">
                                                                                        <td align="left" colspan="2" class="err_msg" valign="top"><?php echo $err_snacks[$i];?></td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_7_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    if($i > 0)
                                                                                    { ?>
                                                                                    <tr id="tr_snacks_8_<?php echo $i;?>">
                                                                                        <td align="right" colspan="2" valign="top">
                                                                                            <input type="button" value="Remove Item" onclick="removeMealRow('snacks','<?php echo $i;?>')" class="btn btn-danger" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_snacks_9_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    } 
                                                                                } ?>
                                                                                    <tr id="add_before_this_snacks">
                                                                                        <td height="30" align="left" valign="top">&nbsp;</td>
                                                                                        <td height="30" align="left" valign="top">
                                                                                            <input type="button" value="add more" id="addMoreSnacks" name="addMoreSnacks" class="btn btn-success" />
                                                                                        </td>
                                                                                    </tr>	
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="25" align="left" valign="middle">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td height="1" bgcolor="#339900"><img src="images/spacer.gif" width="1" height="1" /></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div id="tab5" class="tab_content"> 
                                                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td height="50" align="left" valign="top">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td width="20%" height="50" align="left" valign="top"><img src="images/icon_lunch.jpg" width="40" height="40" /></td>
                                                                                    <td width="40%" height="50" align="left" valign="middle" class="Header_brown">Dinner</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                    <td width="20%" height="50" align="left" valign="middle">&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                            <div id="divdinner"> 
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbldinner">
                                                                                    <tr>
                                                                                        <td width="30%" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>
                                                                                        <td width="70%" height="35" align="left" valign="top">
                                                                                            <select name="dinner_time" id="dinner_time">
                                                                                                <option value="">Select Time</option>
                                                                                                <?php echo getTimeOptions($dinner_start_time,$dinner_end_time,$dinner_time); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_time" style="display:<?php echo $tr_err_dinner_time;?>;" valign="top">
                                                                                        <td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_dinner_time;?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                for($i=0;$i<$dinner_totalRow;$i++)
                                                                                { ?>
                                                                                    <tr id="tr_dinner_1_<?php echo $i;?>">
                                                                                        <td  height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <input name="dinner_item[]" type="text" id="dinner_item_<?php echo $i;?>" value="<?php echo $dinner_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_2_<?php echo $i;?>"  style="display:<?php echo $tr_dinner_other_item[$i];?>;">
                                                                                        <td " height="35" align="left" valign="top">&nbsp;</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <input name="dinner_other_item[]" type="text" id="dinner_other_item_<?php echo $i;?>" value="<?php echo $dinner_other_item_arr[$i];?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_3_<?php echo $i;?>">
                                                                                        <td  height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <select name="dinner_quantity[]" id="dinner_quantity_<?php echo $i;?>">
                                                                                                <?php echo getMealQuantityOptions($dinner_quantity_arr[$i]); ?>
                                                                                            </select>
                                                                                            <span id="spn_dinner_<?php echo $i;?>"><strong><?php echo $dinner_measure_arr[$i]?></strong></span>
                                                                                            <input type="hidden" name="dinner_measure[]" id="dinner_measure_<?php echo $i;?>" value="<?php echo $dinner_measure_arr[$i]?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_4_<?php echo $i;?>">
                                                                                        <td  height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>
                                                                                        <td  height="35" align="left" valign="top">
                                                                                            <table  border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td  height="35" align="left" valign="top">
                                                                                                        <select name="dinner_meal_like[]" id="dinner_meal_like_<?php echo $i;?>" onchange="toggleMealLikeIcon('dinner','<?php echo $i;?>');">
                                                                                                            <?php echo getMealLikeOptions($dinner_meal_like_arr[$i]); ?>
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td width="300" height="35" align="left" valign="top" id="spn_dinner_meal_like_icon_<?php echo $i;?>"><?php echo getMealLikeIcon($dinner_meal_like_arr[$i]); ?></td>
                                                                                               </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_5_<?php echo $i;?>">
                                                                                        <td  align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>
                                                                                        <td  align="left" valign="top">
                                                                                            <textarea name="dinner_consultant_remark[]" id="dinner_consultant_remark_<?php echo $i; ?>" cols="25" rows="3"><?php echo $dinner_consultant_remark_arr[$i];?></textarea>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_6_<?php echo $i;?>" style="display:<?php echo $tr_err_dinner[$i];?>;" valign="top">
                                                                                        <td align="left" colspan="2" class="err_msg" valign="top"><?php echo $err_dinner[$i];?></td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_7_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    if($i > 0)
                                                                                    { ?>
                                                                                    <tr id="tr_dinner_8_<?php echo $i;?>">
                                                                                        <td align="right" colspan="2" valign="top">
                                                                                            <input type="button" value="Remove Item" onclick="removeMealRow('dinner','<?php echo $i;?>')" class="btn btn-danger" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="tr_dinner_9_<?php echo $i;?>">
                                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    } 
                                                                                } ?>
                                                                                    <tr id="add_before_this_dinner">
                                                                                        <td  height="30" align="left" valign="top">&nbsp;</td>
                                                                                        <td  height="30" align="left" valign="top">
                                                                                            <input type="button" value="add more" id="addMoreDinner" name="addMoreDinner" class="btn btn-success" />
                                                                                        </td>
                                                                                    </tr>	
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>       
                                                </td>
                                            </tr>
                                        </table>
                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <td colspan="2" width="100%">&nbsp;
                                        </td>
                                        </tr>
                                            <tr>
                                                <td width="30%" height="35" align="left" valign="top">&nbsp;</td>
                                                <td  width="70%" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary" /></td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                        </table>
              </div>
               
                        
                     
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>
               
                
                <!-- ad left_sidebar-->
                <div class=" col-md-2">
                 <?php include_once('left_sidebar.php'); ?>
              </div>
               <!-- ad left_sidebar end -->
                <!-- ad right_sidebar-->
               <div class=" col-md-2">
                <?php include_once('right_sidebar.php'); ?>
              </div>
               <!-- ad right_sidebar end -->
            </div>
            </div>
            <!--container end -->
    <!--footer -->         
              <footer>
    <div class="container">
                    <div class="row">
                    <div class="col-lg-12">	
     <?php include_once('footer.php');?>
    </div></div></div>
  </footer>    
      <!--footer end -->         
          
       
<!-- Bootstrap Core JavaScript -->
 <script type="text/JavaScript" src="csswell/bootstrap/js/bootstrap.js"></script>
<script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
</body>
</html>