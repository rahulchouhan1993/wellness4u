<?php
function getEachMealPerDayChart($user_id,$date)
{
	global $link;
	$return = false;
	$arr_date=array();
	$arr_meal_time = array();
	$arr_meal_item = array();
	$arr_meal_measure = array();
	$arr_meal_ml = array();
	$arr_weight = array();
	$arr_water = array();
	$arr_calories = array();
	$arr_protein = array();
	$arr_total_fat = array();
	$arr_saturated = array();
	$arr_monounsaturated = array();
	$arr_polyunsaturated = array();
	$arr_cholesterol = array();
	$arr_carbohydrate = array();
	$arr_total_dietary_fiber = array();
	$arr_calcium = array();
	$arr_iron = array();
	$arr_potassium = array();
	$arr_sodium = array();
	$arr_thiamin = array();
	$arr_riboflavin = array();
	$arr_niacin = array();
	$arr_pantothenic_acid = array();
	$arr_pyridoxine_hcl=array();
	$arr_cyanocobalamin=array();
	$arr_ascorbic_acid = array();
	$arr_calciferol= array();
	$arr_tocopherol = array();
	$arr_phylloquinone= array();
	$arr_sugar = array();
	$arr_polyunsaturated_linoleic = array();
	$arr_polyunsaturated_alphalinoleic = array();
	$arr_total_monosaccharide = array();
	$arr_glucose = array();
	$arr_fructose = array();
	$arr_galactose = array();
	$arr_disaccharide = array();
	$arr_maltose = array();
	$arr_lactose = array();
	$arr_sucrose = array();
	$arr_total_polysaccharide = array();
	$arr_starch = array();
	$arr_cellulose = array();
	$arr_glycogen = array();
	$arr_dextrins = array();
	$arr_total_vitamin = array();
	$arr_vitamin_a_acetate =array();
	$arr_vitamin_a_retinol=array();
	$arr_total_vitamin_b_complex =array();
 	$arr_folic_acid = array();
	$arr_biotin = array();
	$arr_alanine = array();
	$arr_arginine = array();
	$arr_aspartic_acid = array();
	$arr_cystine = array();
	$arr_giutamic_acid = array();
	$arr_glycine = array();
	$arr_histidine = array();
	$arr_hydroxy_glutamic_acid = array();
	$arr_hydroxy_proline = array();
	$arr_iodogorgoic_acid = array();
	$arr_isoleucine = array();
	$arr_leucine = array();
	$arr_lysine = array();
	$arr_methionine = array();
	$arr_norleucine = array();
	$arr_phenylalanine = array();
	$arr_proline = array();
	$arr_serine = array();
	$arr_threonine = array();
	$arr_thyroxine = array();
	$arr_tryptophane = array();
	$arr_tyrosine = array();
	$arr_valine = array();
	$arr_total_minerals = array();
	$arr_phosphorus = array();
	$arr_sulphur = array();
	$arr_chlorine = array();
	$arr_iodine = array();
	$arr_magnesium = array();
	$arr_zinc = array();
	$arr_copper = array();
	$arr_chromium = array();
	$arr_manganese = array();
	$arr_selenium = array();
	$arr_boron = array();
	$arr_molybdenum = array();
	$arr_caffeine = array();
	
	$sql = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$date."' ORDER BY `meal_date` ASC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			array_push($arr_date , $row['meal_date']);
			//array_push($start_date , $row['meal_date']);
			$temp_meal_time = '';
			$temp_meal_item = '';
			$temp_meal_measure = '';
			$temp_total_meal_ml = 0.00;	
			$temp_total_weight = 0.00;		
			$temp_total_water = 0.00;		
			$temp_total_calories = 0.00;	
			$temp_total_protein = 0.00;	
			$temp_total_total_fat = 0.00;	
			$temp_total_saturated = 0.00;	
			$temp_total_monounsaturated = 0.00;	
			$temp_total_polyunsaturated = 0.00;	
			$temp_total_cholesterol = 0.00;	
			$temp_total_carbohydrate = 0.00;	
			$temp_total_total_dietary_fiber = 0.00;	
			$temp_total_calcium = 0.00;	
			$temp_total_iron = 0.00;	
			$temp_total_potassium = 0.00;	
			$temp_total_sodium = 0.00;	
			$temp_total_thiamin = 0.00;	
			$temp_total_riboflavin = 0.00;	
			$temp_total_niacin = 0.00;
			$temp_total_pantothenic_acid = 0.00;	
			$temp_total_pyridoxine_hcl=0.00;	
			$temp_total_cyanocobalamin=0.00;	
			$temp_total_ascorbic_acid = 0.00;	
			$temp_total_sugar = 0.00;
			$temp_total_polyunsaturated_linoleic = 0.00;	
			$temp_total_polyunsaturated_alphalinoleic = 0.00;
			$temp_total_total_monosaccharide = 0.00;
			$temp_total_glucose = 0.00;
			$temp_total_fructose = 0.00;
			$temp_total_galactose = 0.00;
			$temp_total_disaccharide = 0.00;
			$temp_total_maltose = 0.00;
			$temp_total_lactose = 0.00;
			$temp_total_sucrose = 0.00;
			$temp_total_total_polysaccharide = 0.00; 
			$temp_total_starch = 0.00;
			$temp_total_cellulose = 0.00;
			$temp_total_glycogen = 0.00;
			$temp_total_dextrins = 0.00;
			$temp_total_total_vitamin = 0.00;
			$temp_total_vitamin_a_acetate = 0.00;
			$temp_total_vitamin_a_retinol=0.00;
			$temp_total_vitamin_b_complex =0.00;
			$temp_total_folic_acid = 0.00;
			$temp_total_biotin = 0.00;
			$temp_total_alanine = 0.00;
			$temp_total_arginine = 0.00;
			$temp_total_aspartic_acid = 0.00;
			$temp_total_cystine = 0.00;
			$temp_total_giutamic_acid = 0.00;
			$temp_total_glycine = 0.00;
			$temp_total_histidine = 0.00;
			$temp_total_hydroxy_glutamic_acid = 0.00;
			$temp_total_hydroxy_proline = 0.00;
			$temp_total_iodogorgoic_acid = 0.00;
			$temp_total_isoleucine = 0.00;
			$temp_total_leucine = 0.00;
			$temp_total_lysine = 0.00;
			$temp_total_methionine = 0.00;
			$temp_total_norleucine = 0.00;
			$temp_total_phenylalanine = 0.00;
			$temp_total_proline = 0.00;
			$temp_total_serine = 0.00;
			$temp_total_threonine = 0.00;
			$temp_total_thyroxine = 0.00;
			$temp_total_tryptophane = 0.00;
			$temp_total_tyrosine = 0.00;
			$temp_total_valine = 0.00;
			$temp_total_total_minerals = 0.00;
			$temp_total_iron = 0.00;
			$temp_total_potassium = 0.00;
			$temp_total_sodium = 0.00;
			$temp_total_phosphorus = 0.00;
			$temp_total_sulphur = 0.00;
			$temp_total_chlorine = 0.00;
			$temp_total_iodine = 0.00;
			$temp_total_magnesium = 0.00;
			$temp_total_zinc = 0.00;
			$temp_total_copper = 0.00;
			$temp_total_chromium = 0.00;
			$temp_total_manganese = 0.00;
			$temp_total_selenium = 0.00;
			$temp_total_boron = 0.00;
			$temp_total_molybdenum = 0.00;
			$temp_total_caffeine = 0.00;
			$temp_meal_id = $row['meal_id'];
			$temp_meal_quantity = $row['meal_quantity'];
			
			$sql3 = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$temp_meal_id."' ";
			//echo "<br>".$sql3;
			$result3 = mysql_query($sql3,$link);
			if( ($result3) && (mysql_num_rows($result3) > 0) )
			{
				$row3 = mysql_fetch_array($result3);
				$temp_meal_time = $row['meal_time'];
				$temp_meal_item = stripslashes($row3['meal_item']);
				//$temp_meal_measure = stripslashes($row3['meal_measure']);
				$temp_meal_measure = stripslashes($row['meal_quantity']).'('.stripslashes($row['meal_measure']).')';
				$temp_total_meal_ml = $temp_meal_quantity * ( ($row3['meal_ml'] == '') ? 0 : $row3['meal_ml']);
				$temp_total_weight = $temp_meal_quantity * ( ($row3['weight'] == '') ? 0 : $row3['weight']);
				$temp_total_water = $temp_meal_quantity * ( ($row3['water'] == '') ? 0 : $row3['water']);
				$temp_total_calories = $temp_meal_quantity * ( ($row3['calories'] == '') ? 0 : $row3['calories']);
				$temp_total_total_fat = $temp_meal_quantity * ( ($row3['total_fat'] == '') ? 0 : $row3['total_fat']);
				$temp_total_saturated = $temp_meal_quantity * ( ($row3['saturated'] == '') ? 0 : $row3['saturated']);
				$temp_total_monounsaturated = $temp_meal_quantity * ( ($row3['monounsaturated'] == '') ? 0 : $row3['monounsaturated']);
				$temp_total_polyunsaturated = $temp_meal_quantity * ( ($row3['total_polyunsaturated'] == '') ? 0 : $row3['total_polyunsaturated']);
				$temp_total_cholesterol = $temp_meal_quantity * ( ($row3['cholesterol'] == '') ? 0 : $row3['cholesterol']);
				$temp_total_carbohydrate = $temp_meal_quantity * ( ($row3['total_carbohydrate'] == '') ? 0 : $row3['total_carbohydrate']);
				$temp_total_total_dietary_fiber = $temp_meal_quantity * ( ($row3['total_dietary_fiber'] == '') ? 0 : $row3['total_dietary_fiber']);
				$temp_total_protein = $temp_meal_quantity * ( ($row3['protein'] == '') ? 0 : $row3['protein']);
				$temp_total_calcium = $temp_meal_quantity * ( ($row3['calcium'] == '') ? 0 : $row3['calcium']);
				$temp_total_iron = $temp_meal_quantity * ( ($row3['iron'] == '') ? 0 : $row3['iron']);
				$temp_total_potassium = $temp_meal_quantity * ( ($row3['potassium'] == '') ? 0 : $row3['potassium']);
				$temp_total_sodium = $temp_meal_quantity * ( ($row3['sodium'] == '') ? 0 : $row3['sodium']);
				$temp_total_thiamin = $temp_meal_quantity * ( ($row3['thiamin'] == '') ? 0 : $row3['thiamin']);
				$temp_total_riboflavin = $temp_meal_quantity * ( ($row3['riboflavin'] == '') ? 0 : $row3['riboflavin']);
				$temp_total_niacin = $temp_meal_quantity * ( ($row3['niacin'] == '') ? 0 : $row3['niacin']);
				$temp_total_ascorbic_acid = $temp_meal_quantity * ( ($row3['ascorbic_acid'] == '') ? 0 : $row3['ascorbic_acid']);
				$temp_total_sugar = $temp_meal_quantity * ( ($row3['sugar'] == '') ? 0 : $row3['sugar']);
				$temp_total_calciferol=$temp_meal_quantity * ( ($row3['calciferol'] == '') ? 0 : $row3['calciferol']);
				$temp_total_tocopherol=$temp_meal_quantity * ( ($row3['tocopherol'] == '') ? 0 : $row3['tocopherol']);
				$temp_total_phylloquinone=$temp_meal_quantity * ( ($row3['phylloquinone'] == '') ? 0 : $row3['phylloquinone']);
				$temp_total_pantothenic_acid =$temp_meal_quantity * ( ($row3['pantothenic_acid'] == '') ? 0 : $row3['pantothenic_acid']);
				$temp_total_pyridoxine_hcl=$temp_meal_quantity * ( ($row3['pyridoxine_hcl'] == '') ? 0 : $row3['pyridoxine_hcl']);
				$temp_total_cyanocobalamin=$temp_meal_quantity * ( ($row3['cyanocobalamin'] == '') ? 0 : $row3['cyanocobalamin']);
			$temp_total_polyunsaturated_linoleic = $temp_meal_quantity * ( ($row3['polyunsaturated_linoleic'] == '') ? 0 : $row3['polyunsaturated_linoleic']);
			$temp_total_polyunsaturated_alphalinoleic = $temp_meal_quantity * ( ($row3['polyunsaturated_alphalinoleic'] == '') ? 0 : $row3['polyunsaturated_alphalinoleic']);
			$temp_total_total_monosaccharide = $temp_meal_quantity * ( ($row3['total_monosaccharide'] == '') ? 0 : $row3['total_monosaccharide']);
			$temp_total_glucose =$temp_meal_quantity * ( ($row3['glucose'] == '') ? 0 : $row3['glucose']);
			$temp_total_fructose = $temp_meal_quantity * ( ($row3['fructose'] == '') ? 0 : $row3['fructose']);
			$temp_total_galactose = $temp_meal_quantity * ( ($row3['galactose'] == '') ? 0 : $row3['galactose']);
			$temp_total_total_disaccharide = $temp_meal_quantity * ( ($row3['total_disaccharide'] == '') ? 0 : $row3['total_disaccharide']);
			$temp_total_maltose = $temp_meal_quantity * ( ($row3['maltose'] == '') ? 0 : $row3['maltose']);
			$temp_total_lactose = $temp_meal_quantity * ( ($row3['lactose'] == '') ? 0 : $row3['lactose']);
			$temp_total_sucrose = $temp_meal_quantity * ( ($row3['sucrose'] == '') ? 0 : $row3['sucrose']);
			$temp_total_total_polysaccharide = $temp_meal_quantity * ( ($row3['total_polysaccharide'] == '') ? 0 : $row3['total_polysaccharide']);
			$temp_total_starch = $temp_meal_quantity * ( ($row3['starch'] == '') ? 0 : $row3['starch']);
			$temp_total_cellulose = $temp_meal_quantity * ( ($row3['cellulose'] == '') ? 0 : $row3['cellulose']);
			$temp_total_glycogen = $temp_meal_quantity * ( ($row3['glycogen'] == '') ? 0 : $row3['glycogen']);
			$temp_total_dextrins = $temp_meal_quantity * ( ($row3['dextrins'] == '') ? 0 : $row3['dextrins']);
			$temp_total_total_vitamin = $temp_meal_quantity * ( ($row3['total_vitamin'] == '') ? 0 : $row3['total_vitamin']);
			$temp_total_vitamin_a_acetate = $temp_meal_quantity * ( ($row3['vitamin_a'] == '') ? 0 : $row3['vitamin_a']);
			$temp_total_vitamin_a_retinol=$temp_meal_quantity * ( ($row3['re'] == '') ? 0 : $row3['re']);
			$temp_total_vitamin_b_complex =$temp_meal_quantity * ( ($row3['vitamin_b_complex'] == '') ? 0 : $row3['vitamin_b_complex']);
			
			$temp_total_folic_acid = $temp_meal_quantity * ( ($row3['folic_acid'] == '') ? 0 : $row3['folic_acid']);
			$temp_total_biotin = $temp_meal_quantity * ( ($row3['biotin'] == '') ? 0 : $row3['biotin']);
			$temp_total_alanine = $temp_meal_quantity * ( ($row3['alanine'] == '') ? 0 : $row3['alanine']);
			$temp_total_arginine = $temp_meal_quantity * ( ($row3['arginine'] == '') ? 0 : $row3['arginine']);
			$temp_total_aspartic_acid = $temp_meal_quantity * ( ($row3['aspartic_acid'] == '') ? 0 : $row3['aspartic_acid']);
			$temp_total_cystine = $temp_meal_quantity * ( ($row3['cystine'] == '') ? 0 : $row3['cystine']);
			$temp_total_giutamic_acid = $temp_meal_quantity * ( ($row3['giutamic_acid'] == '') ? 0 : $row3['giutamic_acid']);
			$temp_total_glycine = $temp_meal_quantity * ( ($row3['glycine'] == '') ? 0 : $row3['glycine']);
			$temp_total_histidine = $temp_meal_quantity * ( ($row3['histidine'] == '') ? 0 : $row3['histidine']);
			$temp_total_hydroxy_glutamic_acid = $temp_meal_quantity * ( ($row3['hydroxy_glutamic_acid'] == '') ? 0 : $row3['hydroxy_glutamic_acid']);
			$temp_total_hydroxy_proline = $temp_meal_quantity * ( ($row3['hydroxy_proline'] == '') ? 0 : $row3['hydroxy_proline']);
			
			$temp_total_iodogorgoic_acid = $temp_meal_quantity * ( ($row3['iodogorgoic_acid'] == '') ? 0 : $row3['iodogorgoic_acid']);
			$temp_total_isoleucine = $temp_meal_quantity * ( ($row3['isoleucine'] == '') ? 0 : $row3['isoleucine']);
			$temp_total_leucine = $temp_meal_quantity * ( ($row3['leucine'] == '') ? 0 : $row3['leucine']);
			$temp_total_lysine = $temp_meal_quantity * ( ($row3['lysine'] == '') ? 0 : $row3['lysine']);
			$temp_total_methionine = $temp_meal_quantity * ( ($row3['methionine'] == '') ? 0 : $row3['methionine']);
			$temp_total_norleucine = $temp_meal_quantity * ( ($row3['norleucine'] == '') ? 0 : $row3['norleucine']);
			$temp_total_phenylalanine = $temp_meal_quantity * ( ($row3['phenylalanine'] == '') ? 0 : $row3['phenylalanine']);
			$temp_total_proline = $temp_meal_quantity * ( ($row3['proline'] == '') ? 0 : $row3['proline']);
			$temp_total_serine = $temp_meal_quantity * ( ($row3['serine'] == '') ? 0 : $row3['serine']);
			$temp_total_threonine = $temp_meal_quantity * ( ($row3['threonine'] == '') ? 0 : $row3['threonine']);
			$temp_total_thyroxine = $temp_meal_quantity * ( ($row3['thyroxine'] == '') ? 0 : $row3['thyroxine']);
			$temp_total_tryptophane = $temp_meal_quantity * ( ($row3['tryptophane'] == '') ? 0 : $row3['tryptophane']);
			$temp_total_tyrosine = $temp_meal_quantity * ( ($row3['tyrosine'] == '') ? 0 : $row3['tyrosine']);
			$temp_total_valine = $temp_meal_quantity * ( ($row3['valine'] == '') ? 0 : $row3['valine']);
			$temp_total_total_minerals = $temp_meal_quantity * ( ($row3['total_minerals'] == '') ? 0 : $row3['total_minerals']);
			
			
			$temp_total_phosphorus =  $temp_meal_quantity * ( ($row3['phosphorus'] == '') ? 0 : $row3['phosphorus']);
			$temp_total_sulphur =  $temp_meal_quantity * ( ($row3['sulphur'] == '') ? 0 : $row3['sulphur']);
			$temp_total_chlorine =  $temp_meal_quantity * ( ($row3['chlorine'] == '') ? 0 : $row3['chlorine']);
			$temp_total_iodine =  $temp_meal_quantity * ( ($row3['iodine'] == '') ? 0 : $row3['iodine']);
			$temp_total_magnesium =  $temp_meal_quantity * ( ($row3['magnesium'] == '') ? 0 : $row3['magnesium']);
			$temp_total_zinc =  $temp_meal_quantity * ( ($row3['zinc'] == '') ? 0 : $row3['zinc']);
			$temp_total_copper =  $temp_meal_quantity * ( ($row3['copper'] == '') ? 0 : $row3['copper']);
			$temp_total_chromium =  $temp_meal_quantity * ( ($row3['chromium'] == '') ? 0 : $row3['chromium']);
			$temp_total_manganese =  $temp_meal_quantity * ( ($row3['manganese'] == '') ? 0 : $row3['manganese']);
			$temp_total_selenium =  $temp_meal_quantity * ( ($row3['selenium'] == '') ? 0 : $row3['selenium']);
			$temp_total_boron =  $temp_meal_quantity * ( ($row3['boron'] == '') ? 0 : $row3['boron']);
			$temp_total_molybdenum =  $temp_meal_quantity * ( ($row3['molybdenum'] == '') ? 0 : $row3['molybdenum']);
			$temp_total_caffeine =  $temp_meal_quantity * ( ($row3['caffeine'] == '') ? 0 : $row3['caffeine']);
				
			}
			
			$arr_meal_time[$row['meal_type']][] = $temp_meal_time;
			$arr_meal_item[$row['meal_type']][] = $temp_meal_item;	
			$arr_meal_measure[$row['meal_type']][] = $temp_meal_measure;	
			$arr_meal_ml[$row['meal_type']][] = $temp_total_meal_ml;	
			$arr_weight[$row['meal_type']][] = $temp_total_weight;
			$arr_water[$row['meal_type']][] = $temp_total_water;
			$arr_calories[$row['meal_type']][] = $temp_total_calories;	
			$arr_protein[$row['meal_type']][] = $temp_total_protein;	
			$arr_total_fat[$row['meal_type']][] = $temp_total_total_fat;	
			$arr_saturated[$row['meal_type']][] = $temp_total_saturated;	
			$arr_monounsaturated[$row['meal_type']][] = $temp_total_monounsaturated;	
			$arr_polyunsaturated[$row['meal_type']][] = $temp_total_polyunsaturated;	
			$arr_cholesterol[$row['meal_type']][] = $temp_total_cholesterol;	
			$arr_carbohydrate[$row['meal_type']][] = $temp_total_carbohydrate;	
			$arr_total_dietary_fiber[$row['meal_type']][] = $temp_total_total_dietary_fiber;	
			$arr_calcium[$row['meal_type']][] = $temp_total_calcium;	
			$arr_iron[$row['meal_type']][] = $temp_total_iron;	
			$arr_potassium[$row['meal_type']][] = $temp_total_potassium;	
			$arr_sodium[$row['meal_type']][] = $temp_total_sodium;	
			$arr_thiamin[$row['meal_type']][] = $temp_total_thiamin;	
			$arr_riboflavin[$row['meal_type']][] = $temp_total_riboflavin;	
			$arr_niacin[$row['meal_type']][] = $temp_total_niacin;	
			$arr_ascorbic_acid[$row['meal_type']][] = $temp_total_ascorbic_acid;	
			$arr_sugar[$row['meal_type']][] = $temp_total_sugar;
			
			$arr_vitamin_a_acetate[$row['meal_type']][]=$temp_total_vitamin_a_acetate;
			$arr_vitamin_a_retinol[$row['meal_type']][]=$temp_total_vitamin_a_retinol;
			$arr_vitamin_b_complex[$row['meal_type']][]=$temp_total_vitamin_b_complex;
			
			$arr_pantothenic_acid[$row['meal_type']][]=$temp_total_pantothenic_acid;
			$arr_pyridoxine_hcl[$row['meal_type']][]=$temp_total_pyridoxine_hcl;
			$arr_cyanocobalamin[$row['meal_type']][]=$temp_total_cyanocobalamin;
			
			
			$arr_polyunsaturated_linoleic[$row['meal_type']][]  = $temp_total_polyunsaturated_linoleic;
			$arr_polyunsaturated_alphalinoleic[$row['meal_type']][]  = $temp_total_polyunsaturated_alphalinoleic;
			$arr_total_monosaccharide[$row['meal_type']][]  = $temp_total_total_monosaccharide;
			$arr_glucose[$row['meal_type']][]  = $temp_total_glucose;
			$arr_fructose[$row['meal_type']][]  = $temp_total_pfructose;
			$arr_galactose[$row['meal_type']][]  = $temp_total_galactose;
			$arr_disaccharide[$row['meal_type']][]  = $temp_total_disaccharide;
			$arr_maltose[$row['meal_type']][]  = $temp_total_maltose;
			$arr_lactose[$row['meal_type']][]  = $temp_total_lactose;
			$arr_sucrose[$row['meal_type']][]  = $temp_total_sucrose;
			$arr_total_polysaccharide[$row['meal_type']][]  = $temp_total_total_polysaccharide;
			$arr_starch[$row['meal_type']][]  = $temp_total_starch;
			$arr_cellulose[$row['meal_type']][]  = $temp_cellulose;
			$arr_glycogen[$row['meal_type']][]  = $temp_total_glycogen;
			$arr_dextrins[$row['meal_type']][]  = $temp_total_dextrins;
			$arr_sugar[$row['meal_type']][]  = $temp_total_sugar;
			$arr_total_vitamin[$row['meal_type']][]  = $temp_total_total_vitamin;
			$arr_vitamin_a_acetate[$row['meal_type']][]  =$temp_total_vitamin_a_acetate;
			$arr_vitamin_a_retinol[$row['meal_type']][] =$temp_total_vitamin_a_retinol;
			$arr_total_vitamin_b_complex[$row['meal_type']][]  =$temp_total_vitamin_b_complex;
			$arr_folic_acid[$row['meal_type']][]  = $temp_total_folic_acid;
			$arr_biotin [$row['meal_type']][] = $temp_total_biotin;
			$arr_alanine[$row['meal_type']][]  = $temp_total_alanine;
			$arr_arginine[$row['meal_type']][]  = $temp_total_arginine;
			$arr_aspartic_acid[$row['meal_type']][] = $temp_total_aspartic_acid;
			$arr_cystine[$row['meal_type']][]  = $temp_total_cystine;
			$arr_giutamic_acid[$row['meal_type']][]  = $temp_total_giutamic_acid;
			$arr_glycine[$row['meal_type']][]  = $temp_total_glycine;
			$arr_histidine[$row['meal_type']][]  = $temp_total_histidine;
			$arr_hydroxy_glutamic_acid[$row['meal_type']][]  = $temp_total_hydroxy_glutamic_acid;
			$arr_hydroxy_proline[$row['meal_type']][]  = $temp_total_hydroxy_proline;
			$arr_iodogorgoic_acid[$row['meal_type']][]  = $temp_total_iodogorgoic_acid;
			$arr_isoleucine[$row['meal_type']][]  = $temp_total_isoleucine;
			$arr_leucine[$row['meal_type']][]  = $temp_total_leucine;
			$arr_lysine[$row['meal_type']][]  = $temp_total_lysine;
			$arr_methionine[$row['meal_type']][]  = $temp_total_methionine;
			$arr_norleucine[$row['meal_type']][]  = $temp_total_norleucine;
			$arr_phenylalanine[$row['meal_type']][]  = $temp_total_phenylalanine;
			$arr_proline[$row['meal_type']][]  =$temp_total_proline;
			$arr_serine[$row['meal_type']][]  = $temp_total_serine;
			$arr_threonine[$row['meal_type']][]  = $temp_total_threonine;
			$arr_thyroxine[$row['meal_type']][]  = $temp_total_thyroxine;
			$arr_tryptophane[$row['meal_type']][]  = $temp_total_tryptophane;
			$arr_tyrosine[$row['meal_type']][]  = $temp_total_tyrosine;
			$arr_valine[$row['meal_type']][]  = $temp_total_valine;
			$arr_total_minerals[$row['meal_type']][]  = $temp_total_total_minerals;
			$arr_phosphorus[$row['meal_type']][]  = $temp_total_phosphorus;
			$arr_sulphur[$row['meal_type']][]  = $temp_total_sulphur;
			$arr_chlorine[$row['meal_type']][]  = $temp_total_chlorine;
			$arr_iodine[$row['meal_type']][]  = $temp_total_iodine;
			$arr_magnesium[$row['meal_type']][]  = $temp_total_magnesium;
			$arr_zinc[$row['meal_type']][]  = $temp_total_zinc;
			$arr_copper[$row['meal_type']][]  = $temp_total_copper;
			$arr_chromium[$row['meal_type']][]  = $temp_total_chromium;
			$arr_manganese[$row['meal_type']][]  = $temp_total_manganese;
			$arr_selenium[$row['meal_type']][]  = $temp_total_selenium;
			$arr_boron[$row['meal_type']][]  = $temp_total_boron;
			$arr_molybdenum[$row['meal_type']][]  = $temp_total_molybdenum;
			$arr_caffeine[$row['meal_type']][]  = $temp_total_caffeine;
			
			$arr_calciferol[$row['meal_type']][]  = $temp_total_calciferol;
			$arr_tocopherol[$row['meal_type']][]  = $temp_total_tocopherol;
			$arr_phylloquinone[$row['meal_type']][]  = $temp_total_phylloquinone;
			
		}
	}
		
	return array($return,$arr_meal_time, $arr_meal_item, $arr_meal_measure, $arr_meal_ml, $arr_weight, $arr_water , $arr_calories , $arr_protein ,
	$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,
	$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,
	$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,
	$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,
	$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,
	$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,
	$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,
	$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,
	$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine , $arr_tryptophane ,
	$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine , $arr_magnesium , $arr_zinc ,
	$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine,$arr_date);	
}
 function getEachMealPerDayChartHTML($user_id,$date) 
	{
		global $link;
		$return = false;
		$output = '';
		list($return,$arr_meal_time, $arr_meal_item, $arr_meal_measure, $arr_meal_ml, $arr_weight, $arr_water , $arr_calories , $arr_protein ,
				$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,
				$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,
				$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,
				$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,
				$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,
				$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,
				$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,
				$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,
				$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine ,
				$arr_tryptophane ,$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine , 
				$arr_magnesium , $arr_zinc ,$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine,$arr_date,$total_meal_entry) = getEachMealPerDayChart($user_id,$date);
		if( ($return) && ( count($arr_date) > 0 ) )
		{
			$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="0">
					<tbody>
						<tr>	
							<td colspan="9" height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Each Meal Per Day Chart</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td width="150" height="30" align="left" valign="middle"><strong>For the Day </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong></strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong></strong></td>
							<td width="200" height="30" align="left" valign="middle"></td>
							<td width="200" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="140" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
						<td height="30" align="left" valign="middle"><strong>Name</strong></td>
						<td height="30" align="left" valign="middle"><strong>:</strong></td>
						<td height="30" align="left" valign="middle">'.getUserFullNameById($user_id).'</td>
						<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
						<td height="30" align="left" valign="middle"><strong>:</strong></td>
						<td height="30" align="left" valign="middle">'.getUserUniqueId($user_id).'</td>
						<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
					</tr>
					<tr>	
						<td height="30" align="left" valign="middle"><strong>Age</strong></td>
						<td height="30" align="left" valign="middle"><strong>:</strong></td>
						<td height="30" align="left" valign="middle">'.getAgeOfUser($user_id).'</td>
						<td height="30" align="left" valign="middle"><strong>Height</strong></td>
						<td height="30" align="left" valign="middle"><strong>:</strong></td>
						<td height="30" align="left" valign="middle">'.getHeightOfUser($user_id). ' cms</td>
						<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
						<td height="30" align="left" valign="middle"><strong>:</strong></td>
						<td height="30" align="left" valign="middle">'.getWeightOfUser($user_id). ' Kgs</td>
					</tr>
					<tr>	
						<td height="30" align="left" valign="middle"><strong>BMI</strong></td>
						<td height="30" align="left" valign="middle"><strong>:</strong></td>
						<td height="30" align="left" valign="middle">'.getBMIOfUser($user_id).'</td>
						<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>
						<td height="30" align="left" valign="middle"><strong>:</strong></td>
						<td height="30" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
						<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
					</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>	
							<td colspan="9" align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td colspan="9" align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>';
						$output .= '	<tr>	
							<td colspan="12" height="30" align="left" valign="middle">
								<table width="1150" border="1" cellpadding="5" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">';
								for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ 
																    if($arr_meal_time['breakfast'][$j] != '' )
																	{
							
								$output .='<tr>
								<td width="864" colspan="11" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Breakfast</strong></td>
								<td width="54" colspan="1" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
								</tr>
								<tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['breakfast'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$i.'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['breakfast'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_time['breakfast'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['breakfast'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_item['breakfast'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['breakfast'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_measure['breakfast'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_ml['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_meal_ml['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_weight['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_weight['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Water(%)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_water['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_water['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $water+=$arr_water['breakfast'][$i];
																	}
																	if($water!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$water.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';		
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calories</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calories['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calories['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $calories+=$arr_calories['breakfast'][$i];
																	}
																	if($calories!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calories.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total fat(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_fat['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_fat['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $fat+=$arr_total_fat['breakfast'][$i];
																	}
																	if($fat!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fat.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Saturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_saturated['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_saturated['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $saturated+=$arr_saturated['breakfast'][$i];
																	}
																	if($saturated!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$saturated.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Monounsaturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_monounsaturated['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_monounsaturated['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $monounsaturated+=$arr_monounsaturated['breakfast'][$i];
																	}
																	if($monounsaturated!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$monounsaturated.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Poly-unsaturated</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $polyunsaturated+=$arr_polyunsaturated['breakfast'][$i];
																	}
																	if($polyunsaturated!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_linoleic['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_linoleic['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $polyunsaturated_linoleic+=$arr_polyunsaturated_linoleic['breakfast'][$i];
																	}
																	if($polyunsaturated_linoleic!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_linoleic.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated alpha-Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_alphalinoleic['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_alphalinoleic['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $polyunsaturated_alphalinoleic+=$arr_polyunsaturated_alphalinoleic['breakfast'][$i];
																	}
																	if($polyunsaturated_alphalinoleic!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_alphalinoleic.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cholesterol(mg)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cholesterol['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cholesterol['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $cholesterol+=$arr_cholesterol['breakfast'][$i];
																	}
																	if($cholesterol!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cholesterol.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total dietary fiber(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_dietary_fiber['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_dietary_fiber['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $total_dietary_fiber+=$arr_total_dietary_fiber['breakfast'][$i];
																	}
																	if($total_dietary_fiber!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_dietary_fiber.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Carbohydrate</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_carbohydrate['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_carbohydrate['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $carbohydrate+=$arr_carbohydrate['breakfast'][$i];
																	}
																	if($carbohydrate!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$carbohydrate.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glucose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glucose['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glucose['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $glucose+=$arr_glucose['breakfast'][$i];
																	}
																	if($glucose!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glucose.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Fructose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_fructose['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_fructose['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $fructose+=$arr_fructose['breakfast'][$i];
																	}
																	if($fructose!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fructose.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Galactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_galactose['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_galactose['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $galactose+=$arr_galactose['breakfast'][$i];
																	}
																	if($galactose!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$galactose.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Disaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_disaccharide['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_disaccharide['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $disaccharide+=$arr_disaccharide['breakfast'][$i];
																	}
																	if($disaccharide!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$disaccharide.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Maltose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_maltose['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_maltose['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $maltose+=$arr_maltose['breakfast'][$i];
																	}
																	if($maltose!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$maltose.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lactose['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lactose['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $lactose+=$arr_lactose['breakfast'][$i];
																	}
																	if($lactose!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lactose.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sucrose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sucrose['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sucrose['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $sucrose+=$arr_sucrose['breakfast'][$i];
																	}
																	if($sucrose!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sucrose.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Polysaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_polysaccharide['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_polysaccharide['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $total_polysaccharide+=$arr_total_polysaccharide['breakfast'][$i];
																	}
																	if($total_polysaccharide!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_polysaccharide.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Starch</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)

																{ 
																
																 if($arr_starch['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_starch['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $starch+=$arr_starch['breakfast'][$i];
																	}
																	if($starch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$starch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cellulose(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cellulose['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cellulose['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $cellulose+=$arr_cellulose['breakfast'][$i];
																	}
																	if($cellulose!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cellulose.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycogen</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycogen['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycogen['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $glycogen+=$arr_glycogen['breakfast'][$i];
																	}
																	if($glycogen!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycogen.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Dextrins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_dextrins['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_dextrins['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $dextrins+=$arr_dextrins['breakfast'][$i];
																	}
																	if($dextrins!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$dextrins.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sugar</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sugar['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sugar['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $sugar+=$arr_sugar['breakfast'][$i];
																	}
																	if($sugar!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sugar.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $total_vitamin+=$arr_total_vitamin['breakfast'][$i];
																	}
																	if($total_vitamin!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitamin.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (As Acetate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_acetate['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_acetate['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $vitamin_a_acetate+=$arr_vitamin_a_acetate['breakfast'][$i];
																	}
																	if($vitamin_a_acetate!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_acetate.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Vitamin A (Retinol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_retinol['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_retinol['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $vitamin_a_retinol+=$arr_vitamin_a_retinol['breakfast'][$i];
																	}
																	if($vitamin_a_retinol!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_retinol.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamin B Complex</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin_b_complex['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin_b_complex['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $total_vitamin_b_complex+=$arr_total_vitamin_b_complex['breakfast'][$i];
																	}
																	if($total_vitamin_b_complex!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitamin_b_complex.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thiamin['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thiamin['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $thiamin+=$arr_thiamin['breakfast'][$i];
																	}
																	if($thiamin!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thiamin.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_riboflavin['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_riboflavin['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $riboflavin+=$arr_riboflavin['breakfast'][$i];
																	}
																	if($riboflavin!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$riboflavin.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin
 /Nicotonic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_niacin['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_niacin['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $niacin+=$arr_niacin['breakfast'][$i];
																	}
																	if($niacin!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$niacin.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pantothenic_acid['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pantothenic_acid['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $pantothenic_acid+=$arr_pantothenic_acid['breakfast'][$i];
																	}
																	if($pantothenic_acid!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pantothenic_acid.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pyridoxine_hcl['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pyridoxine_hcl['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $pyridoxine_hcl+=$arr_pyridoxine_hcl['breakfast'][$i];
																	}
																	if($pyridoxine_hcl!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pyridoxine_hcl.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cyanocobalamin['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cyanocobalamin['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $cyanocobalamin+=$arr_cyanocobalamin['breakfast'][$i];
																	}
																	if($cyanocobalamin!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cyanocobalamin.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Folic Acid (or Folate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_folic_acid['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_folic_acid['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $folic_acid+=$arr_folic_acid['breakfast'][$i];
																	}
																	if($folic_acid!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$folic_acid.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Biotin</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_biotin['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_biotin['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $biotin+=$arr_biotin['breakfast'][$i];
																	}
																	if($biotin!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$biotin.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_ascorbic_acid['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_ascorbic_acid['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $ascorbic_acid+=$arr_ascorbic_acid['breakfast'][$i];
																	}
																	if($ascorbic_acid!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ascorbic_acid.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin D (Calciferol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calciferol['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calciferol['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $calciferol+=$arr_calciferol['breakfast'][$i];
																	}
																	if($calciferol!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciferol.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tocopherol['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tocopherol['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $tocopherol+=$arr_tocopherol['breakfast'][$i];
																	}
																	if($tocopherol!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tocopherol.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phylloquinone['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phylloquinone['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $phylloquinone+=$arr_phylloquinone['breakfast'][$i];
																	}
																	if($phylloquinone!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phylloquinone.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Protein / Amino Acids</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_protein['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_protein['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $protein+=$arr_protein['breakfast'][$i];
																	}
																	if($protein!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$protein.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Alanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_alanine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_alanine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $alanine+=$arr_alanine['breakfast'][$i];
																	}
																	if($alanine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$alanine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Arginine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_arginine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_arginine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $arginine+=$arr_arginine['breakfast'][$i];
																	}
																	if($arginine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$arginine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Aspartic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_aspartic_acid['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_aspartic_acid['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $aspartic_acid+=$arr_aspartic_acid['breakfast'][$i];
																	}
																	if($aspartic_acid!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$aspartic_acid.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cystine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cystine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cystine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $cystine+=$arr_cystine['breakfast'][$i];
																	}
																	if($cystine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cystine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Giutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_giutamic_acid['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_giutamic_acid['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $giutamic_acid+=$arr_giutamic_acid['breakfast'][$i];
																	}
																	if($giutamic_acid!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$giutamic_acid.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $glycine+=$arr_glycine['breakfast'][$i];
																	}
																	if($glycine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Histidine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_histidine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_histidine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $histidine+=$arr_histidine['breakfast'][$i];
																	}
																	if($histidine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$histidine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy-glutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_glutamic_acid['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_glutamic_acid['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $hydroxy_glutamic_acid+=$arr_hydroxy_glutamic_acid['breakfast'][$i];
																	}
																	if($hydroxy_glutamic_acid!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_glutamic_acid.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_proline['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_proline['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $hydroxy_proline+=$arr_hydroxy_proline['breakfast'][$i];
																	}
																	if($hydroxy_proline!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_proline.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodogorgoic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodogorgoic_acid['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodogorgoic_acid['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $iodogorgoic_acid+=$arr_iodogorgoic_acid['breakfast'][$i];
																	}
																	if($iodogorgoic_acid!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodogorgoic_acid.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Isoleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_isoleucine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_isoleucine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $isoleucine+=$arr_isoleucine['breakfast'][$i];
																	}
																	if($isoleucine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$isoleucine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Leucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_leucine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_leucine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $leucine+=$arr_leucine['breakfast'][$i];
																	}
																	if($leucine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$leucine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lysine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lysine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lysine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $lysine+=$arr_lysine['breakfast'][$i];
																	}
																	if($lysine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lysine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Methionine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_methionine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_methionine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $methionine+=$arr_methionine['breakfast'][$i];
																	}
																	if($methionine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$methionine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Norleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_norleucine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_norleucine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $norleucine+=$arr_norleucine['breakfast'][$i];
																	}
																	if($norleucine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$norleucine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phenylalanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phenylalanine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phenylalanine['breakfast'][$j].'</td>';
																	}

																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $phenylalanine+=$arr_phenylalanine['breakfast'][$i];
																	}
																	if($phenylalanine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phenylalanine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_proline['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_proline['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $proline+=$arr_proline['breakfast'][$i];
																	}
																	if($proline!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$proline.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Serine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_serine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_serine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $serine+=$arr_serine['breakfast'][$i];
																	}
																	if($serine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$serine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Threonine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_threonine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_threonine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $threonine+=$arr_threonine['breakfast'][$i];
																	}
																	if($threonine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$threonine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Thyroxine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thyroxine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thyroxine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $thyroxine+=$arr_thyroxine['breakfast'][$i];
																	}
																	if($thyroxine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thyroxine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tryptophane</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tryptophane['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tryptophane['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $tryptophane+=$arr_tryptophane['breakfast'][$i];
																	}
																	if($tryptophane!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tryptophane.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tyrosine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tyrosine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tyrosine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $tyrosine+=$arr_tyrosine['breakfast'][$i];
																	}
																	if($tyrosine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tyrosine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Valine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_valine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_valine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $valine+=$arr_valine['breakfast'][$i];
																	}
																	if($valine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$valine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Minerals</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_minerals['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_minerals['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $total_minerals+=$arr_total_minerals['breakfast'][$i];
																	}
																	if($total_minerals!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_minerals.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calcium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calcium['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calcium['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $calcium+=$arr_calcium['breakfast'][$i];
																	}
																	if($calcium!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calcium.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iron['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iron['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $iron+=$arr_iron['breakfast'][$i];
																	}
																	if($iron!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iron.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Potassium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_potassium['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_potassium['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $potassium+=$arr_potassium['breakfast'][$i];
																	}
																	if($potassium!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$potassium.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sodium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sodium['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sodium['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $sodium+=$arr_sodium['breakfast'][$i];
																	}
																	if($sodium!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sodium.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phosphorus</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phosphorus['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phosphorus['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $phosphorus+=$arr_phosphorus['breakfast'][$i];
																	}
																	if($phosphorus!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phosphorus.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sulphur</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sulphur['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sulphur['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $sulphur+=$arr_sulphur['breakfast'][$i];
																	}
																	if($sulphur!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sulphur.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chlorine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chlorine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chlorine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $chlorine+=$arr_chlorine['breakfast'][$i];
																	}
																	if($chlorine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chlorine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $iodine+=$arr_iodine['breakfast'][$i];
																	}
																	if($iodine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Magnesium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_magnesium['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_magnesium['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $magnesium+=$arr_magnesium['breakfast'][$i];
																	}
																	if($magnesium!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$magnesium.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Zinc</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_zinc['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_zinc['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $zinc+=$arr_zinc['breakfast'][$i];
																	}
																	if($zinc!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$zinc.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Copper</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_copper['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_copper['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $copper+=$arr_copper['breakfast'][$i];
																	}
																	if($copper!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$copper.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chromium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chromium['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chromium['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $chromium+=$arr_chromium['breakfast'][$i];
																	}
																	if($chromium!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chromium.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Manganese</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_manganese['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_manganese['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $manganese+=$arr_manganese['breakfast'][$i];
																	}
																	if($manganese!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$manganese.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Selenium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_selenium['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_selenium['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $selenium+=$arr_selenium['breakfast'][$i];
																	}
																	if($selenium!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$selenium.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Boron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_boron['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_boron['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $boron+=$arr_boron['breakfast'][$i];
																	}
																	if($boron!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$boron.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Molybdenum</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_molybdenum['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_molybdenum['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $molybdenum+=$arr_molybdenum['breakfast'][$i];
																	}
																	if($molybdenum!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$molybdenum.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Caffeine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_caffeine['breakfast'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_caffeine['breakfast'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)
																	{
																	  $caffeine+=$arr_caffeine['breakfast'][$i];
																	}
																	if($caffeine!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caffeine.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<td width="54" colspan="12" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
									}
											else
											{
											$output.='<td>'.'&nbsp;'.'</td>';
											}
											}
											for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ 
																    if($arr_meal_time['brunch'][$j] != '' )
																	{
											
						$output .= '	<tr>	
							<td colspan="12" height="30" align="left" valign="middle">
								<table width="1150" border="1" cellpadding="5" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
								<td width="864" colspan="11" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>brunch</strong></td>
								<td width="54" colspan="1" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
								</tr>
								<tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['brunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$i.'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['brunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_time['brunch'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['brunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_item['brunch'][$j].'</td>';


																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['brunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_measure['brunch'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_ml['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_meal_ml['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_weight['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_weight['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Water(%)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_water['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_water['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $waterbrunch+=$arr_water['brunch'][$i];
																	}
																	if($waterbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$waterbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';		
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calories</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calories['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calories['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $caloriesbrunch+=$arr_calories['brunch'][$i];
																	}
																	if($caloriesbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caloriesbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total fat(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_fat['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_fat['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $fatbrunch+=$arr_total_fat['brunch'][$i];
																	}
																	if($fatbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fatbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Saturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_saturated['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_saturated['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $saturatedbrunch+=$arr_saturated['brunch'][$i];
																	}
																	if($saturatedbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$saturatedbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Monounsaturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_monounsaturated['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_monounsaturated['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $monounsaturatedbrunch+=$arr_monounsaturated['brunch'][$i];
																	}
																	if($monounsaturatedbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$monounsaturatedbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Poly-unsaturated</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $polyunsaturatedbrunch+=$arr_polyunsaturated['brunch'][$i];
																	}
																	if($polyunsaturatedbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturatedbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_linoleic['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_linoleic['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $polyunsaturated_linoleicbrunch+=$arr_polyunsaturated_linoleic['brunch'][$i];
																	}
																	if($polyunsaturated_linoleicbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_linoleicbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated alpha-Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_alphalinoleic['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_alphalinoleic['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $polyunsaturated_alphalinoleicbrunch+=$arr_polyunsaturated_alphalinoleic['brunch'][$i];
																	}
																	if($polyunsaturated_alphalinoleicbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_alphalinoleicbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cholesterol(mg)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cholesterol['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cholesterol['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $cholesterolbrunch+=$arr_cholesterol['brunch'][$i];
																	}
																	if($cholesterolbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cholesterolbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total dietary fiber(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_dietary_fiber['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_dietary_fiber['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $total_dietary_fiberbrunch+=$arr_total_dietary_fiber['brunch'][$i];
																	}
																	if($total_dietary_fiberbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_dietary_fiberbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Carbohydrate</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_carbohydrate['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_carbohydrate['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $carbohydratebrunch+=$arr_carbohydrate['brunch'][$i];
																	}
																	if($carbohydratebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$carbohydratebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glucose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glucose['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glucose['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $glucosebrunch+=$arr_glucose['brunch'][$i];
																	}
																	if($glucosebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glucosebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Fructose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_fructose['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_fructose['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $fructosebrunch+=$arr_fructose['brunch'][$i];
																	}
																	if($fructosebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fructosebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Galactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_galactose['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_galactose['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $galactosebrunch+=$arr_galactose['brunch'][$i];
																	}
																	if($galactosebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$galactosebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Disaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_disaccharide['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_disaccharide['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $disaccharidebrunch+=$arr_disaccharide['brunch'][$i];
																	}
																	if($disaccharidebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$disaccharidebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Maltose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_maltose['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_maltose['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $maltosebrunch+=$arr_maltose['brunch'][$i];
																	}
																	if($maltosebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$maltosebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lactose['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lactose['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $lactosebrunch+=$arr_lactose['brunch'][$i];
																	}
																	if($lactosebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lactosebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sucrose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sucrose['brunch'][$j] != '' )

																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sucrose['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $sucrosebrunch+=$arr_sucrose['brunch'][$i];
																	}
																	if($sucrosebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sucrosebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Polysaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_polysaccharide['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_polysaccharide['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $total_polysaccharidebrunch+=$arr_total_polysaccharide['brunch'][$i];
																	}
																	if($total_polysaccharidebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_polysaccharidebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Starch</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_starch['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_starch['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $starchbrunch+=$arr_starch['brunch'][$i];
																	}
																	if($starchbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$starchbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cellulose(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cellulose['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cellulose['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $cellulosebrunch+=$arr_cellulose['brunch'][$i];
																	}
																	if($cellulosebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cellulosebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycogen</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycogen['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycogen['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $glycogenbrunch+=$arr_glycogen['brunch'][$i];
																	}
																	if($glycogenbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycogenbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Dextrins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_dextrins['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_dextrins['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $dextrinsbrunch+=$arr_dextrins['brunch'][$i];
																	}
																	if($dextrinsbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$dextrinsbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sugar</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sugar['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sugar['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $sugarbrunch+=$arr_sugar['brunch'][$i];
																	}
																	if($sugarbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sugarbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $total_vitaminbrunch+=$arr_total_vitamin['brunch'][$i];
																	}
																	if($total_vitaminbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitaminbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (As Acetate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_acetate['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_acetate['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $vitamin_a_acetatebrunch+=$arr_vitamin_a_acetate['brunch'][$i];
																	}
																	if($vitamin_a_acetatebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_acetatebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Vitamin A (Retinol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_retinol['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_retinol['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $vitamin_a_retinolbrunch+=$arr_vitamin_a_retinol['brunch'][$i];
																	}
																	if($vitamin_a_retinolbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_retinolbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamin B Complex</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin_b_complex['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin_b_complex['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $total_vitamin_b_complexbrunch+=$arr_total_vitamin_b_complex['brunch'][$i];
																	}
																	if($total_vitamin_b_complexbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitamin_b_complexbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thiamin['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thiamin['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $thiaminbrunch+=$arr_thiamin['brunch'][$i];
																	}
																	if($thiaminbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thiaminbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_riboflavin['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_riboflavin['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $riboflavinbrunch+=$arr_riboflavin['brunch'][$i];
																	}
																	if($riboflavinbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$riboflavinbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin
 /Nicotonic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_niacin['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_niacin['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $niacinbrunch+=$arr_niacin['brunch'][$i];
																	}
																	if($niacinbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$niacinbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pantothenic_acid['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pantothenic_acid['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $pantothenic_acidbrunch+=$arr_pantothenic_acid['brunch'][$i];
																	}
																	if($pantothenic_acidbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pantothenic_acidbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pyridoxine_hcl['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pyridoxine_hcl['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $pyridoxine_hclbrunch+=$arr_pyridoxine_hcl['brunch'][$i];
																	}
																	if($pyridoxine_hclbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pyridoxine_hclbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cyanocobalamin['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cyanocobalamin['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $cyanocobalaminbrunch+=$arr_cyanocobalamin['brunch'][$i];
																	}
																	if($cyanocobalaminbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cyanocobalaminbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Folic Acid (or Folate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_folic_acid['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_folic_acid['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $folic_acidbrunch+=$arr_folic_acid['brunch'][$i];
																	}
																	if($folic_acidbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$folic_acidbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Biotin</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_biotin['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_biotin['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $biotinbrunch+=$arr_biotin['brunch'][$i];
																	}
																	if($biotinbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$biotinbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_ascorbic_acid['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_ascorbic_acid['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $ascorbic_acidbrunch+=$arr_ascorbic_acid['brunch'][$i];
																	}
																	if($ascorbic_acidbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ascorbic_acidbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin D (Calciferol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calciferol['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calciferol['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $calciferolbrunch+=$arr_calciferol['brunch'][$i];
																	}
																	if($calciferolbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciferolbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>';
																

																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tocopherol['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tocopherol['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $tocopherolbrunch+=$arr_tocopherol['brunch'][$i];
																	}
																	if($tocopherolbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tocopherolbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phylloquinone['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phylloquinone['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $phylloquinonebrunch+=$arr_phylloquinone['brunch'][$i];
																	}
																	if($phylloquinonebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phylloquinonebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Protein / Amino Acids</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_protein['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_protein['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $proteinbrunch+=$arr_protein['brunch'][$i];
																	}
																	if($proteinbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$proteinbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Alanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_alanine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_alanine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $alaninebrunch+=$arr_alanine['brunch'][$i];
																	}
																	if($alaninebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$alaninebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Arginine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_arginine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_arginine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $argininebrunch+=$arr_arginine['brunch'][$i];
																	}
																	if($argininebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$argininebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Aspartic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_aspartic_acid['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_aspartic_acid['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $aspartic_acidbrunch+=$arr_aspartic_acid['brunch'][$i];
																	}
																	if($aspartic_acidbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$aspartic_acidbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cystine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cystine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cystine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $cystinebrunch+=$arr_cystine['brunch'][$i];
																	}
																	if($cystinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cystinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Giutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_giutamic_acid['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_giutamic_acid['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $giutamic_acidbrunch+=$arr_giutamic_acid['brunch'][$i];
																	}
																	if($giutamic_acidbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$giutamic_acidbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $glycinebrunch+=$arr_glycine['brunch'][$i];
																	}
																	if($glycinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Histidine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_histidine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_histidine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $histidinebrunch+=$arr_histidine['brunch'][$i];
																	}
																	if($histidinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$histidinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy-glutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_glutamic_acid['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_glutamic_acid['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $hydroxy_glutamic_acidbrunch+=$arr_hydroxy_glutamic_acid['brunch'][$i];
																	}
																	if($hydroxy_glutamic_acidbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_glutamic_acidbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_proline['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_proline['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $hydroxy_prolinebrunch+=$arr_hydroxy_proline['brunch'][$i];
																	}
																	if($hydroxy_prolinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_prolinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodogorgoic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodogorgoic_acid['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodogorgoic_acid['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $iodogorgoic_acidbrunch+=$arr_iodogorgoic_acid['brunch'][$i];
																	}
																	if($iodogorgoic_acidbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodogorgoic_acidbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Isoleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_isoleucine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_isoleucine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $isoleucinebrunch+=$arr_isoleucine['brunch'][$i];
																	}
																	if($isoleucinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$isoleucinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Leucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_leucine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_leucine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $leucinebrunch+=$arr_leucine['brunch'][$i];
																	}
																	if($leucinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$leucinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lysine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lysine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lysine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $lysinebrunch+=$arr_lysine['brunch'][$i];
																	}
																	if($lysinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lysinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Methionine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_methionine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_methionine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $methioninebrunch+=$arr_methionine['brunch'][$i];
																	}
																	if($methioninebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$methioninebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Norleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_norleucine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_norleucine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $norleucinebrunch+=$arr_norleucine['brunch'][$i];
																	}
																	if($norleucinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$norleucinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phenylalanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phenylalanine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phenylalanine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $phenylalaninebrunch+=$arr_phenylalanine['brunch'][$i];
																	}
																	if($phenylalaninebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phenylalaninebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_proline['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_proline['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $prolinebrunch+=$arr_proline['brunch'][$i];
																	}
																	if($prolinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$prolinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Serine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_serine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_serine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $serinebrunch+=$arr_serine['brunch'][$i];
																	}
																	if($serinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$serinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Threonine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_threonine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_threonine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $threoninebrunch+=$arr_threonine['brunch'][$i];
																	}
																	if($threoninebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$threoninebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Thyroxine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thyroxine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thyroxine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $thyroxinebrunch+=$arr_thyroxine['brunch'][$i];
																	}
																	if($thyroxinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thyroxinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tryptophane</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tryptophane['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tryptophane['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $tryptophanebrunch+=$arr_tryptophane['brunch'][$i];
																	}
																	if($tryptophanebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tryptophanebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tyrosine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tyrosine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tyrosine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $tyrosinebrunch+=$arr_tyrosine['brunch'][$i];
																	}
																	if($tyrosinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tyrosinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Valine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_valine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_valine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $valinebrunch+=$arr_valine['brunch'][$i];
																	}
																	if($valinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$valinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Minerals</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_minerals['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_minerals['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $total_mineralsbrunch+=$arr_total_minerals['brunch'][$i];
																	}
																	if($total_mineralsbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_mineralsbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calcium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calcium['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calcium['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $calciumbrunch+=$arr_calcium['brunch'][$i];
																	}
																	if($calciumbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciumbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iron['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iron['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $ironbrunch+=$arr_iron['brunch'][$i];
																	}
																	if($ironbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ironbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Potassium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_potassium['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_potassium['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $potassiumbrunch +=$arr_potassium['brunch'][$i];
																	}
																	if($potassiumbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$potassiumbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sodium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sodium['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sodium['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $sodiumbrunch +=$arr_sodium['brunch'][$i];
																	}
																	if($sodiumbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sodiumbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phosphorus</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phosphorus['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phosphorus['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $phosphorusbrunch +=$arr_phosphorus['brunch'][$i];
																	}
																	if($phosphorusbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phosphorusbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sulphur</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sulphur['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sulphur['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $sulphurbrunch +=$arr_sulphur['brunch'][$i];
																	}
																	if($sulphurbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sulphurbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chlorine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chlorine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chlorine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $chlorinebrunch +=$arr_chlorine['brunch'][$i];
																	}
																	if($chlorinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chlorinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $iodinebrunch+=$arr_iodine['brunch'][$i];
																	}
																	if($iodinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Magnesium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_magnesium['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_magnesium['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $magnesiumbrunch+=$arr_magnesium['brunch'][$i];
																	}
																	if($magnesiumbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$magnesiumbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Zinc</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_zinc['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_zinc['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $zincbrunch+=$arr_zinc['brunch'][$i];
																	}
																	if($zincbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$zincbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Copper</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_copper['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_copper['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $copperbrunch+=$arr_copper['brunch'][$i];
																	}
																	if($copperbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$copperbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chromium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chromium['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chromium['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $chromiumbrunch+=$arr_chromium['brunch'][$i];
																	}
																	if($chromiumbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chromiumbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Manganese</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_manganese['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_manganese['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $manganesebrunch+=$arr_manganese['brunch'][$i];
																	}
																	if($manganesebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$manganesebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Selenium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_selenium['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_selenium['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $seleniumbrunch+=$arr_selenium['brunch'][$i];
																	}
																	if($seleniumbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$seleniumbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Boron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_boron['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_boron['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $boronbrunch+=$arr_boron['brunch'][$i];
																	}
																	if($boronbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$boronbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Molybdenum</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_molybdenum['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_molybdenum['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $molybdenumbrunch+=$arr_molybdenum['brunch'][$i];
																	}
																	if($molybdenumbrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$molybdenumbrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Caffeine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_caffeine['brunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_caffeine['brunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)
																	{
																	  $caffeinebrunch+=$arr_caffeine['brunch'][$i];
																	}
																	if($caffeinebrunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caffeinebrunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<td width="54" colspan="12" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						}
											else
											{
											$output.='<td>'.'&nbsp;'.'</td>';
											}
											}
											for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ 
																    if($arr_meal_time['lunch'][$j] != '' )
																	{
						$output .= '	<tr>	
							<td colspan="12" height="30" align="left" valign="middle">
								<table width="1150" border="1" cellpadding="5" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
								<td width="864" colspan="11" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>lunch</strong></td>
								<td width="54" colspan="1" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
								</tr>
								<tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['lunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$i.'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['lunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_time['lunch'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['lunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_item['lunch'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['lunch'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_measure['lunch'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_ml['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_meal_ml['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_weight['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_weight['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Water(%)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_water['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_water['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $waterlunch+=$arr_water['lunch'][$i];
																	}
																	if($waterlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$waterlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';		
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calories</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calories['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calories['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $calorieslunch+=$arr_calories['lunch'][$i];
																	}
																	if($calorieslunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calorieslunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total fat(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_fat['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_fat['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $fatlunch+=$arr_total_fat['lunch'][$i];
																	}
																	if($fatlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fatlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Saturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_saturated['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_saturated['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $saturatedlunch+=$arr_saturated['lunch'][$i];
																	}
																	if($saturatedlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$saturatedlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Monounsaturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_monounsaturated['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_monounsaturated['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $monounsaturatedlunch+=$arr_monounsaturated['lunch'][$i];
																	}
																	if($monounsaturatedlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$monounsaturatedlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Poly-unsaturated</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $polyunsaturatedlunch+=$arr_polyunsaturated['lunch'][$i];
																	}
																	if($polyunsaturatedlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturatedlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_linoleic['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_linoleic['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $polyunsaturated_linoleiclunch+=$arr_polyunsaturated_linoleic['lunch'][$i];
																	}
																	if($polyunsaturated_linoleiclunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_linoleiclunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated alpha-Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_alphalinoleic['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_alphalinoleic['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $polyunsaturated_alphalinoleiclunch+=$arr_polyunsaturated_alphalinoleic['lunch'][$i];
																	}
																	if($polyunsaturated_alphalinoleiclunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_alphalinoleiclunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cholesterol(mg)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cholesterol['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cholesterol['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $cholesterollunch+=$arr_cholesterol['lunch'][$i];
																	}
																	if($cholesterollunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cholesterollunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total dietary fiber(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_dietary_fiber['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_dietary_fiber['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $total_dietary_fiberlunch+=$arr_total_dietary_fiber['lunch'][$i];
																	}
																	if($total_dietary_fiberlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_dietary_fiberlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Carbohydrate</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_carbohydrate['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_carbohydrate['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $carbohydratelunch+=$arr_carbohydrate['lunch'][$i];
																	}
																	if($carbohydratelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$carbohydratelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glucose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glucose['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glucose['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $glucoselunch+=$arr_glucose['lunch'][$i];
																	}
																	if($glucoselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glucoselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Fructose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_fructose['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_fructose['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $fructoselunch+=$arr_fructose['lunch'][$i];
																	}
																	if($fructoselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fructoselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Galactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_galactose['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_galactose['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $galactoselunch+=$arr_galactose['lunch'][$i];
																	}
																	if($galactoselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$galactoselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Disaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 

																
																 if($arr_disaccharide['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_disaccharide['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $disaccharidelunch+=$arr_disaccharide['lunch'][$i];
																	}
																	if($disaccharidelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$disaccharidelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Maltose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_maltose['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_maltose['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $maltoselunch+=$arr_maltose['lunch'][$i];
																	}
																	if($maltoselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$maltoselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lactose['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lactose['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $lactoselunch+=$arr_lactose['lunch'][$i];
																	}
																	if($lactoselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lactoselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sucrose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sucrose['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sucrose['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $sucroselunch+=$arr_sucrose['lunch'][$i];
																	}
																	if($sucroselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sucroselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Polysaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_polysaccharide['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_polysaccharide['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $total_polysaccharidelunch+=$arr_total_polysaccharide['lunch'][$i];
																	}
																	if($total_polysaccharidelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_polysaccharidelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Starch</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_starch['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_starch['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $starchlunch+=$arr_starch['lunch'][$i];
																	}
																	if($starchlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$starchlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cellulose(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cellulose['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cellulose['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $celluloselunch+=$arr_cellulose['lunch'][$i];
																	}
																	if($celluloselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$celluloselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycogen</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycogen['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycogen['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $glycogenlunch+=$arr_glycogen['lunch'][$i];
																	}
																	if($glycogenlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycogenlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Dextrins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_dextrins['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_dextrins['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $dextrinslunch+=$arr_dextrins['lunch'][$i];
																	}
																	if($dextrinslunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$dextrinslunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sugar</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sugar['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sugar['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $sugarlunch+=$arr_sugar['lunch'][$i];
																	}
																	if($sugarlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sugarlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $total_vitaminlunch+=$arr_total_vitamin['lunch'][$i];
																	}
																	if($total_vitaminlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitaminlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (As Acetate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_acetate['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_acetate['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $vitamin_a_acetatelunch+=$arr_vitamin_a_acetate['lunch'][$i];
																	}
																	if($vitamin_a_acetatelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_acetatelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Vitamin A (Retinol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_retinol['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_retinol['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $vitamin_a_retinollunch+=$arr_vitamin_a_retinol['lunch'][$i];
																	}
																	if($vitamin_a_retinollunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_retinollunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamin B Complex</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin_b_complex['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin_b_complex['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $total_vitamin_b_complexlunch+=$arr_total_vitamin_b_complex['lunch'][$i];
																	}
																	if($total_vitamin_b_complexlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitamin_b_complexlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thiamin['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thiamin['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $thiaminlunch+=$arr_thiamin['lunch'][$i];
																	}
																	if($thiaminlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thiaminlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_riboflavin['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_riboflavin['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $riboflavinlunch+=$arr_riboflavin['lunch'][$i];
																	}
																	if($riboflavinlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$riboflavinlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin
 /Nicotonic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_niacin['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_niacin['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $niacinlunch+=$arr_niacin['lunch'][$i];
																	}
																	if($niacinlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$niacinlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pantothenic_acid['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pantothenic_acid['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $pantothenic_acidlunch+=$arr_pantothenic_acid['lunch'][$i];
																	}
																	if($pantothenic_acidlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pantothenic_acidlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pyridoxine_hcl['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pyridoxine_hcl['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $pyridoxine_hcllunch+=$arr_pyridoxine_hcl['lunch'][$i];
																	}
																	if($pyridoxine_hcllunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pyridoxine_hcllunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cyanocobalamin['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cyanocobalamin['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $cyanocobalaminlunch+=$arr_cyanocobalamin['lunch'][$i];
																	}
																	if($cyanocobalaminlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cyanocobalaminlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Folic Acid (or Folate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_folic_acid['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_folic_acid['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $folic_acidlunch+=$arr_folic_acid['lunch'][$i];
																	}
																	if($folic_acidlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$folic_acidlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Biotin</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_biotin['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_biotin['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $biotinlunch+=$arr_biotin['lunch'][$i];
																	}
																	if($biotinlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$biotinlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_ascorbic_acid['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_ascorbic_acid['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $ascorbic_acidlunch+=$arr_ascorbic_acid['lunch'][$i];
																	}
																	if($ascorbic_acidlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ascorbic_acidlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin D (Calciferol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calciferol['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calciferol['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $calciferollunch+=$arr_calciferol['lunch'][$i];
																	}
																	if($calciferollunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciferollunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tocopherol['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tocopherol['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $tocopherollunch+=$arr_tocopherol['lunch'][$i];
																	}
																	if($tocopherollunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tocopherollunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phylloquinone['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phylloquinone['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $phylloquinonelunch+=$arr_phylloquinone['lunch'][$i];
																	}
																	if($phylloquinonelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phylloquinonelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Protein / Amino Acids</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_protein['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_protein['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $proteinlunch+=$arr_protein['lunch'][$i];
																	}
																	if($proteinlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$proteinlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Alanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_alanine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_alanine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $alaninelunch+=$arr_alanine['lunch'][$i];
																	}
																	if($alaninelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$alaninelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Arginine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_arginine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_arginine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $argininelunch+=$arr_arginine['lunch'][$i];
																	}
																	if($argininelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$argininelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Aspartic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_aspartic_acid['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_aspartic_acid['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $aspartic_acidlunch+=$arr_aspartic_acid['lunch'][$i];
																	}
																	if($aspartic_acidlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$aspartic_acidlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cystine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cystine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cystine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $cystinelunch+=$arr_cystine['lunch'][$i];
																	}
																	if($cystinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cystinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Giutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_giutamic_acid['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_giutamic_acid['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $giutamic_acidlunch+=$arr_giutamic_acid['lunch'][$i];
																	}
																	if($giutamic_acidlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$giutamic_acidlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $glycinelunch+=$arr_glycine['lunch'][$i];
																	}
																	if($glycinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Histidine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_histidine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_histidine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $histidinelunch+=$arr_histidine['lunch'][$i];
																	}
																	if($histidinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$histidinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy-glutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_glutamic_acid['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_glutamic_acid['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $hydroxy_glutamic_acidlunch+=$arr_hydroxy_glutamic_acid['lunch'][$i];
																	}
																	if($hydroxy_glutamic_acidlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_glutamic_acidlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_proline['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_proline['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $hydroxy_prolinelunch+=$arr_hydroxy_proline['lunch'][$i];
																	}
																	if($hydroxy_prolinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_prolinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodogorgoic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodogorgoic_acid['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodogorgoic_acid['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $iodogorgoic_acidlunch+=$arr_iodogorgoic_acid['lunch'][$i];
																	}
																	if($iodogorgoic_acidlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodogorgoic_acidlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Isoleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_isoleucine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_isoleucine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $isoleucinelunch+=$arr_isoleucine['lunch'][$i];
																	}
																	if($isoleucinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$isoleucinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Leucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_leucine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_leucine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $leucinelunch+=$arr_leucine['lunch'][$i];
																	}
																	if($leucinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$leucinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lysine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lysine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lysine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $lysinelunch+=$arr_lysine['lunch'][$i];
																	}
																	if($lysinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lysinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Methionine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_methionine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_methionine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $methioninelunch+=$arr_methionine['lunch'][$i];
																	}
																	if($methioninelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$methioninelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Norleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_norleucine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_norleucine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $norleucinelunch+=$arr_norleucine['lunch'][$i];
																	}
																	if($norleucinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$norleucinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phenylalanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phenylalanine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phenylalanine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $phenylalaninelunch+=$arr_phenylalanine['lunch'][$i];
																	}
																	if($phenylalaninelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phenylalaninelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_proline['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_proline['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $prolinelunch+=$arr_proline['lunch'][$i];
																	}
																	if($prolinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$prolinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Serine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_serine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_serine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $serinelunch+=$arr_serine['lunch'][$i];
																	}
																	if($serinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$serinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Threonine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_threonine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_threonine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $threoninelunch+=$arr_threonine['lunch'][$i];
																	}
																	if($threoninelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$threoninelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Thyroxine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thyroxine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thyroxine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $thyroxinelunch+=$arr_thyroxine['lunch'][$i];
																	}
																	if($thyroxinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thyroxinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tryptophane</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tryptophane['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tryptophane['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $tryptophanelunch+=$arr_tryptophane['lunch'][$i];
																	}
																	if($tryptophanelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tryptophanelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tyrosine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tyrosine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tyrosine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $tyrosinelunch+=$arr_tyrosine['lunch'][$i];
																	}
																	if($tyrosinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tyrosinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Valine</td>';
																

																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_valine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_valine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $valinelunch+=$arr_valine['lunch'][$i];
																	}
																	if($valinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$valinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Minerals</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_minerals['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_minerals['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $total_mineralslunch+=$arr_total_minerals['lunch'][$i];
																	}
																	if($total_mineralslunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_mineralslunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calcium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calcium['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calcium['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $calciumlunch+=$arr_calcium['lunch'][$i];
																	}
																	if($calciumlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciumlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iron['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iron['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $ironlunch+=$arr_iron['lunch'][$i];
																	}
																	if($ironlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ironlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Potassium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_potassium['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_potassium['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $potassiumlunch +=$arr_potassium['lunch'][$i];
																	}
																	if($potassiumlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$potassiumlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sodium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sodium['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sodium['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $sodiumlunch +=$arr_sodium['lunch'][$i];
																	}
																	if($sodiumlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sodiumlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phosphorus</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phosphorus['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phosphorus['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $phosphoruslunch +=$arr_phosphorus['lunch'][$i];
																	}
																	if($phosphoruslunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phosphoruslunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sulphur</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sulphur['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sulphur['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $sulphurlunch +=$arr_sulphur['lunch'][$i];
																	}
																	if($sulphurlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sulphurlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chlorine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chlorine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chlorine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $chlorinelunch +=$arr_chlorine['lunch'][$i];
																	}
																	if($chlorinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chlorinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $iodinelunch+=$arr_iodine['lunch'][$i];
																	}
																	if($iodinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Magnesium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_magnesium['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_magnesium['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $magnesiumlunch+=$arr_magnesium['lunch'][$i];
																	}
																	if($magnesiumlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$magnesiumlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Zinc</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_zinc['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_zinc['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $zinclunch+=$arr_zinc['lunch'][$i];
																	}
																	if($zinclunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$zinclunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Copper</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_copper['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_copper['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $copperlunch+=$arr_copper['lunch'][$i];
																	}
																	if($copperlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$copperlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chromium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chromium['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chromium['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $chromiumlunch+=$arr_chromium['lunch'][$i];
																	}
																	if($chromiumlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chromiumlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Manganese</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_manganese['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_manganese['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $manganeselunch+=$arr_manganese['lunch'][$i];
																	}
																	if($manganeselunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$manganeselunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Selenium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_selenium['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_selenium['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $seleniumlunch+=$arr_selenium['lunch'][$i];
																	}
																	if($seleniumlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$seleniumlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Boron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_boron['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_boron['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $boronlunch+=$arr_boron['lunch'][$i];
																	}
																	if($boronlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$boronlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Molybdenum</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_molybdenum['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_molybdenum['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $molybdenumlunch+=$arr_molybdenum['lunch'][$i];
																	}
																	if($molybdenumlunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$molybdenumlunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Caffeine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_caffeine['lunch'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_caffeine['lunch'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)
																	{
																	  $caffeinelunch+=$arr_caffeine['lunch'][$i];
																	}
																	if($caffeinelunch!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caffeinelunch.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<td width="54" colspan="12" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						}
											else
											{
											$output.='<td>'.'&nbsp;'.'</td>';
											}
											}
											for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ 
																    if($arr_meal_time['snacks'][$j] != '' )
																	{

						$output .= '	<tr>	
							<td colspan="12" height="30" align="left" valign="middle">
								<table width="1150" border="1" cellpadding="5" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
								<td width="864" colspan="11" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>snacks</strong></td>
								<td width="54" colspan="1" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
								</tr>
								<tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['snacks'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$i.'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['snacks'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_time['snacks'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['snacks'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_item['snacks'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['snacks'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_measure['snacks'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_ml['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_meal_ml['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_weight['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_weight['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Water(%)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_water['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_water['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $watersnacks+=$arr_water['snacks'][$i];
																	}
																	if($watersnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$watersnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';		
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calories</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calories['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calories['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $caloriessnacks+=$arr_calories['snacks'][$i];
																	}
																	if($caloriessnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caloriessnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total fat(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_fat['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_fat['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $fatsnacks+=$arr_total_fat['snacks'][$i];
																	}
																	if($fatsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fatsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Saturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_saturated['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_saturated['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $saturatedsnacks+=$arr_saturated['snacks'][$i];
																	}
																	if($saturatedsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$saturatedsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Monounsaturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_monounsaturated['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_monounsaturated['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $monounsaturatedsnacks+=$arr_monounsaturated['snacks'][$i];
																	}
																	if($monounsaturatedsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$monounsaturatedsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Poly-unsaturated</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $polyunsaturatedsnacks+=$arr_polyunsaturated['snacks'][$i];
																	}
																	if($polyunsaturatedsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturatedsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_linoleic['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_linoleic['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $polyunsaturated_linoleicsnacks+=$arr_polyunsaturated_linoleic['snacks'][$i];
																	}
																	if($polyunsaturated_linoleicsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_linoleicsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated alpha-Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_alphalinoleic['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_alphalinoleic['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $polyunsaturated_alphalinoleicsnacks+=$arr_polyunsaturated_alphalinoleic['snacks'][$i];
																	}
																	if($polyunsaturated_alphalinoleicsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_alphalinoleicsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cholesterol(mg)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cholesterol['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cholesterol['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $cholesterolsnacks+=$arr_cholesterol['snacks'][$i];
																	}
																	if($cholesterolsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cholesterolsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total dietary fiber(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_dietary_fiber['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_dietary_fiber['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $total_dietary_fibersnacks+=$arr_total_dietary_fiber['snacks'][$i];
																	}
																	if($total_dietary_fibersnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_dietary_fibersnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Carbohydrate</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_carbohydrate['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_carbohydrate['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $carbohydratesnacks+=$arr_carbohydrate['snacks'][$i];
																	}
																	if($carbohydratesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$carbohydratesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glucose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glucose['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glucose['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $glucosesnacks+=$arr_glucose['snacks'][$i];
																	}
																	if($glucosesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glucosesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Fructose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_fructose['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_fructose['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $fructosesnacks+=$arr_fructose['snacks'][$i];
																	}
																	if($fructosesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fructosesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Galactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_galactose['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_galactose['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $galactosesnacks+=$arr_galactose['snacks'][$i];
																	}
																	if($galactosesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$galactosesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Disaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_disaccharide['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_disaccharide['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $disaccharidesnacks+=$arr_disaccharide['snacks'][$i];
																	}
																	if($disaccharidesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$disaccharidesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Maltose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_maltose['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_maltose['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $maltosesnacks+=$arr_maltose['snacks'][$i];
																	}
																	if($maltosesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$maltosesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lactose['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lactose['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $lactosesnacks+=$arr_lactose['snacks'][$i];
																	}
																	if($lactosesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lactosesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sucrose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sucrose['snacks'][$j] != '' )

																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sucrose['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $sucrosesnacks+=$arr_sucrose['snacks'][$i];
																	}
																	if($sucrosesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sucrosesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Polysaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_polysaccharide['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_polysaccharide['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $total_polysaccharidesnacks+=$arr_total_polysaccharide['snacks'][$i];
																	}
																	if($total_polysaccharidesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_polysaccharidesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Starch</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_starch['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_starch['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $starchsnacks+=$arr_starch['snacks'][$i];
																	}
																	if($starchsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$starchsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cellulose(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cellulose['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cellulose['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $cellulosesnacks+=$arr_cellulose['snacks'][$i];
																	}
																	if($cellulosesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cellulosesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycogen</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycogen['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycogen['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $glycogensnacks+=$arr_glycogen['snacks'][$i];
																	}
																	if($glycogensnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycogensnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Dextrins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_dextrins['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_dextrins['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $dextrinssnacks+=$arr_dextrins['snacks'][$i];
																	}
																	if($dextrinssnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$dextrinssnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sugar</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sugar['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sugar['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $sugarsnacks+=$arr_sugar['snacks'][$i];
																	}
																	if($sugarsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sugarsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $total_vitaminsnacks+=$arr_total_vitamin['snacks'][$i];
																	}
																	if($total_vitaminsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitaminsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (As Acetate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_acetate['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_acetate['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $vitamin_a_acetatesnacks+=$arr_vitamin_a_acetate['snacks'][$i];
																	}
																	if($vitamin_a_acetatesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_acetatesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Vitamin A (Retinol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_retinol['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_retinol['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $vitamin_a_retinolsnacks+=$arr_vitamin_a_retinol['snacks'][$i];
																	}
																	if($vitamin_a_retinolsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_retinolsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamin B Complex</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin_b_complex['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin_b_complex['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $total_vitamin_b_complexsnacks+=$arr_total_vitamin_b_complex['snacks'][$i];
																	}
																	if($total_vitamin_b_complexsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitamin_b_complexsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thiamin['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thiamin['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $thiaminsnacks+=$arr_thiamin['snacks'][$i];
																	}
																	if($thiaminsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thiaminsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_riboflavin['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_riboflavin['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $riboflavinsnacks+=$arr_riboflavin['snacks'][$i];
																	}
																	if($riboflavinsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$riboflavinsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin
 /Nicotonic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_niacin['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_niacin['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $niacinsnacks+=$arr_niacin['snacks'][$i];
																	}
																	if($niacinsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$niacinsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pantothenic_acid['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pantothenic_acid['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $pantothenic_acidsnacks+=$arr_pantothenic_acid['snacks'][$i];
																	}
																	if($pantothenic_acidsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pantothenic_acidsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pyridoxine_hcl['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pyridoxine_hcl['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $pyridoxine_hclsnacks+=$arr_pyridoxine_hcl['snacks'][$i];
																	}
																	if($pyridoxine_hclsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pyridoxine_hclsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cyanocobalamin['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cyanocobalamin['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $cyanocobalaminsnacks+=$arr_cyanocobalamin['snacks'][$i];
																	}
																	if($cyanocobalaminsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cyanocobalaminsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Folic Acid (or Folate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_folic_acid['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_folic_acid['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $folic_acidsnacks+=$arr_folic_acid['snacks'][$i];
																	}
																	if($folic_acidsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$folic_acidsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Biotin</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_biotin['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_biotin['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $biotinsnacks+=$arr_biotin['snacks'][$i];
																	}
																	if($biotinsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$biotinsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_ascorbic_acid['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_ascorbic_acid['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $ascorbic_acidsnacks+=$arr_ascorbic_acid['snacks'][$i];
																	}
																	if($ascorbic_acidsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ascorbic_acidsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin D (Calciferol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calciferol['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calciferol['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $calciferolsnacks+=$arr_calciferol['snacks'][$i];
																	}
																	if($calciferolsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciferolsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tocopherol['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tocopherol['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $tocopherolsnacks+=$arr_tocopherol['snacks'][$i];
																	}
																	if($tocopherolsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tocopherolsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phylloquinone['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phylloquinone['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $phylloquinonesnacks+=$arr_phylloquinone['snacks'][$i];
																	}
																	if($phylloquinonesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phylloquinonesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Protein / Amino Acids</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_protein['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_protein['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $proteinsnacks+=$arr_protein['snacks'][$i];
																	}
																	if($proteinsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$proteinsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Alanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_alanine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_alanine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $alaninesnacks+=$arr_alanine['snacks'][$i];
																	}
																	if($alaninesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$alaninesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Arginine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_arginine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_arginine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $argininesnacks+=$arr_arginine['snacks'][$i];
																	}
																	if($argininesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$argininesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Aspartic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_aspartic_acid['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_aspartic_acid['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $aspartic_acidsnacks+=$arr_aspartic_acid['snacks'][$i];
																	}
																	if($aspartic_acidsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$aspartic_acidsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cystine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cystine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cystine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $cystinesnacks+=$arr_cystine['snacks'][$i];
																	}
																	if($cystinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cystinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Giutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_giutamic_acid['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_giutamic_acid['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $giutamic_acidsnacks+=$arr_giutamic_acid['snacks'][$i];
																	}
																	if($giutamic_acidsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$giutamic_acidsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $glycinesnacks+=$arr_glycine['snacks'][$i];
																	}
																	if($glycinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Histidine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_histidine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_histidine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $histidinesnacks+=$arr_histidine['snacks'][$i];
																	}
																	if($histidinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$histidinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy-glutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_glutamic_acid['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_glutamic_acid['snacks'][$j].'</td>';
																	}
																	else

																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $hydroxy_glutamic_acidsnacks+=$arr_hydroxy_glutamic_acid['snacks'][$i];
																	}
																	if($hydroxy_glutamic_acidsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_glutamic_acidsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_proline['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_proline['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $hydroxy_prolinesnacks+=$arr_hydroxy_proline['snacks'][$i];
																	}
																	if($hydroxy_prolinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_prolinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodogorgoic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodogorgoic_acid['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodogorgoic_acid['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $iodogorgoic_acidsnacks+=$arr_iodogorgoic_acid['snacks'][$i];
																	}
																	if($iodogorgoic_acidsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodogorgoic_acidsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Isoleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_isoleucine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_isoleucine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $isoleucinesnacks+=$arr_isoleucine['snacks'][$i];
																	}
																	if($isoleucinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$isoleucinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Leucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_leucine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_leucine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $leucinesnacks+=$arr_leucine['snacks'][$i];
																	}
																	if($leucinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$leucinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lysine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lysine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lysine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $lysinesnacks+=$arr_lysine['snacks'][$i];
																	}
																	if($lysinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lysinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Methionine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_methionine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_methionine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $methioninesnacks+=$arr_methionine['snacks'][$i];
																	}
																	if($methioninesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$methioninesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Norleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_norleucine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_norleucine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $norleucinesnacks+=$arr_norleucine['snacks'][$i];
																	}
																	if($norleucinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$norleucinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phenylalanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phenylalanine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phenylalanine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $phenylalaninesnacks+=$arr_phenylalanine['snacks'][$i];
																	}
																	if($phenylalaninesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phenylalaninesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_proline['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_proline['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $prolinesnacks+=$arr_proline['snacks'][$i];
																	}
																	if($prolinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$prolinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Serine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_serine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_serine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $serinesnacks+=$arr_serine['snacks'][$i];
																	}
																	if($serinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$serinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Threonine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_threonine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_threonine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $threoninesnacks+=$arr_threonine['snacks'][$i];
																	}
																	if($threoninesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$threoninesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Thyroxine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thyroxine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thyroxine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $thyroxinesnacks+=$arr_thyroxine['snacks'][$i];
																	}
																	if($thyroxinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thyroxinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tryptophane</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tryptophane['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tryptophane['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $tryptophanesnacks+=$arr_tryptophane['snacks'][$i];
																	}
																	if($tryptophanesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tryptophanesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tyrosine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tyrosine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tyrosine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $tyrosinesnacks+=$arr_tyrosine['snacks'][$i];
																	}
																	if($tyrosinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tyrosinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Valine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_valine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_valine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $valinesnacks+=$arr_valine['snacks'][$i];
																	}
																	if($valinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$valinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Minerals</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_minerals['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_minerals['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $total_mineralssnacks+=$arr_total_minerals['snacks'][$i];
																	}
																	if($total_mineralssnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_mineralssnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calcium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calcium['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calcium['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $calciumsnacks+=$arr_calcium['snacks'][$i];
																	}
																	if($calciumsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciumsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iron['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iron['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $ironsnacks+=$arr_iron['snacks'][$i];
																	}
																	if($ironsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ironsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Potassium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_potassium['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_potassium['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $potassiumsnacks +=$arr_potassium['snacks'][$i];
																	}
																	if($potassiumsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$potassiumsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sodium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sodium['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sodium['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $sodiumsnacks +=$arr_sodium['snacks'][$i];
																	}
																	if($sodiumsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sodiumsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phosphorus</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phosphorus['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phosphorus['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $phosphorussnacks +=$arr_phosphorus['snacks'][$i];
																	}
																	if($phosphorussnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phosphorussnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sulphur</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sulphur['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sulphur['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $sulphursnacks +=$arr_sulphur['snacks'][$i];
																	}
																	if($sulphursnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sulphursnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chlorine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chlorine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chlorine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $chlorinesnacks +=$arr_chlorine['snacks'][$i];
																	}
																	if($chlorinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chlorinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $iodinesnacks+=$arr_iodine['snacks'][$i];
																	}
																	if($iodinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Magnesium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_magnesium['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_magnesium['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $magnesiumsnacks+=$arr_magnesium['snacks'][$i];
																	}
																	if($magnesiumsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$magnesiumsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Zinc</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_zinc['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_zinc['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $zincsnacks+=$arr_zinc['snacks'][$i];
																	}
																	if($zincsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$zincsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Copper</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_copper['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_copper['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $coppersnacks+=$arr_copper['snacks'][$i];
																	}
																	if($coppersnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$coppersnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chromium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chromium['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chromium['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $chromiumsnacks+=$arr_chromium['snacks'][$i];
																	}
																	if($chromiumsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chromiumsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Manganese</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_manganese['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_manganese['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $manganesesnacks+=$arr_manganese['snacks'][$i];
																	}
																	if($manganesesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$manganesesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Selenium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_selenium['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_selenium['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $seleniumsnacks+=$arr_selenium['snacks'][$i];
																	}
																	if($seleniumsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$seleniumsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Boron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_boron['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_boron['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $boronsnacks+=$arr_boron['snacks'][$i];
																	}
																	if($boronsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$boronsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Molybdenum</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_molybdenum['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_molybdenum['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $molybdenumsnacks+=$arr_molybdenum['snacks'][$i];
																	}
																	if($molybdenumsnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$molybdenumsnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Caffeine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_caffeine['snacks'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_caffeine['snacks'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)
																	{
																	  $caffeinesnacks+=$arr_caffeine['snacks'][$i];
																	}
																	if($caffeinesnacks!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caffeinesnacks.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<td width="54" colspan="12" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						}
											else
											{
											$output.='<td>'.'&nbsp;'.'</td>';
											}
											}
											for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ 
																    if($arr_meal_time['dinner'][$j] != '' )
																	{

						$output .= '	<tr>	
							<td colspan="12" height="30" align="left" valign="middle">
								<table width="1150" border="1" cellpadding="5" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
								<td width="864" colspan="11" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>dinner</strong></td>
								<td width="54" colspan="1" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
								</tr>
								<tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['dinner'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$i.'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['dinner'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_time['dinner'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																} 
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179"   align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['dinner'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_item['dinner'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_time['dinner'][$j] != '' )
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'. $arr_meal_measure['dinner'][$j].'</td>';
																	}
																	else
																	{
																		$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																
																}
																$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_meal_ml['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_meal_ml['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						$output.='</tr>
								<td width="179" height="50" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>';
								for($j=0,$i=1;$j<10;$j++,$i++)
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_weight['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" align="center" bgcolor="#FFFFFF" valign="middle">'.$arr_weight['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																	
																}
								   $output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>'; 
						$output.='</tr>';
						
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Water(%)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_water['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_water['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $waterdinner+=$arr_water['dinner'][$i];
																	}
																	if($waterdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$waterdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';		
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calories</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calories['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calories['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $caloriesdinner+=$arr_calories['dinner'][$i];
																	}
																	if($caloriesdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caloriesdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total fat(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_fat['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_fat['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $fatdinner+=$arr_total_fat['dinner'][$i];
																	}
																	if($fatdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fatdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Saturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_saturated['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_saturated['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $saturateddinner+=$arr_saturated['dinner'][$i];
																	}
																	if($saturateddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$saturateddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Monounsaturated(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_monounsaturated['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_monounsaturated['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $monounsaturateddinner+=$arr_monounsaturated['dinner'][$i];
																	}
																	if($monounsaturateddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$monounsaturateddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Poly-unsaturated</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $polyunsaturateddinner+=$arr_polyunsaturated['dinner'][$i];
																	}
																	if($polyunsaturateddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturateddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_linoleic['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_linoleic['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $polyunsaturated_linoleicdinner+=$arr_polyunsaturated_linoleic['dinner'][$i];
																	}
																	if($polyunsaturated_linoleicdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_linoleicdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated alpha-Linoleic</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_polyunsaturated_alphalinoleic['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_polyunsaturated_alphalinoleic['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $polyunsaturated_alphalinoleicdinner+=$arr_polyunsaturated_alphalinoleic['dinner'][$i];
																	}
																	if($polyunsaturated_alphalinoleicdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$polyunsaturated_alphalinoleicdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cholesterol(mg)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cholesterol['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cholesterol['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $cholesteroldinner+=$arr_cholesterol['dinner'][$i];
																	}
																	if($cholesteroldinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cholesteroldinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total dietary fiber(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_dietary_fiber['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_dietary_fiber['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $total_dietary_fiberdinner+=$arr_total_dietary_fiber['dinner'][$i];
																	}
																	if($total_dietary_fiberdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_dietary_fiberdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Carbohydrate</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_carbohydrate['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_carbohydrate['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $carbohydratedinner+=$arr_carbohydrate['dinner'][$i];
																	}
																	if($carbohydratedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$carbohydratedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glucose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glucose['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glucose['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $glucosedinner+=$arr_glucose['dinner'][$i];
																	}
																	if($glucosedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glucosedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Fructose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_fructose['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_fructose['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $fructosedinner+=$arr_fructose['dinner'][$i];
																	}
																	if($fructosedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$fructosedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Galactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_galactose['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_galactose['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $galactosedinner+=$arr_galactose['dinner'][$i];
																	}
																	if($galactosedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$galactosedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Disaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_disaccharide['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_disaccharide['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $disaccharidedinner+=$arr_disaccharide['dinner'][$i];
																	}
																	if($disaccharidedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$disaccharidedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Maltose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_maltose['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_maltose['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $maltosedinner+=$arr_maltose['dinner'][$i];
																	}
																	if($maltosedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$maltosedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lactose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lactose['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lactose['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $lactosedinner+=$arr_lactose['dinner'][$i];
																	}
																	if($lactosedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lactosedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sucrose</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sucrose['dinner'][$j] != '' )

																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sucrose['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $sucrosedinner+=$arr_sucrose['dinner'][$i];
																	}
																	if($sucrosedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sucrosedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Polysaccharide</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_polysaccharide['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_polysaccharide['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $total_polysaccharidedinner+=$arr_total_polysaccharide['dinner'][$i];
																	}
																	if($total_polysaccharidedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_polysaccharidedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Starch</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_starch['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_starch['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $starchdinner+=$arr_starch['dinner'][$i];
																	}
																	if($starchdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$starchdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cellulose(g)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cellulose['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cellulose['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $cellulosedinner+=$arr_cellulose['dinner'][$i];
																	}
																	if($cellulosedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cellulosedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycogen</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycogen['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycogen['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $glycogendinner+=$arr_glycogen['dinner'][$i];
																	}
																	if($glycogendinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycogendinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Dextrins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_dextrins['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_dextrins['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $dextrinsdinner+=$arr_dextrins['dinner'][$i];
																	}
																	if($dextrinsdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$dextrinsdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sugar</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sugar['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sugar['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $sugardinner+=$arr_sugar['dinner'][$i];
																	}
																	if($sugardinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sugardinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamins</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $total_vitamindinner+=$arr_total_vitamin['dinner'][$i];
																	}
																	if($total_vitamindinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitamindinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (As Acetate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_acetate['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_acetate['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $vitamin_a_acetatedinner+=$arr_vitamin_a_acetate['dinner'][$i];
																	}
																	if($vitamin_a_acetatedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_acetatedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Vitamin A (Retinol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_vitamin_a_retinol['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_vitamin_a_retinol['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $vitamin_a_retinoldinner+=$arr_vitamin_a_retinol['dinner'][$i];
																	}
																	if($vitamin_a_retinoldinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$vitamin_a_retinoldinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamin B Complex</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_vitamin_b_complex['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_vitamin_b_complex['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $total_vitamin_b_complexdinner+=$arr_total_vitamin_b_complex['dinner'][$i];
																	}
																	if($total_vitamin_b_complexdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_vitamin_b_complexdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thiamin['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thiamin['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $thiamindinner+=$arr_thiamin['dinner'][$i];
																	}
																	if($thiamindinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thiamindinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_riboflavin['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_riboflavin['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{

																	  $riboflavindinner+=$arr_riboflavin['dinner'][$i];
																	}
																	if($riboflavindinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$riboflavindinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin
 /Nicotonic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_niacin['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_niacin['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $niacindinner+=$arr_niacin['dinner'][$i];
																	}
																	if($niacindinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$niacindinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pantothenic_acid['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pantothenic_acid['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $pantothenic_aciddinner+=$arr_pantothenic_acid['dinner'][$i];
																	}
																	if($pantothenic_aciddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pantothenic_aciddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_pyridoxine_hcl['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_pyridoxine_hcl['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $pyridoxine_hcldinner+=$arr_pyridoxine_hcl['dinner'][$i];
																	}
																	if($pyridoxine_hcldinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$pyridoxine_hcldinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cyanocobalamin['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cyanocobalamin['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $cyanocobalamindinner+=$arr_cyanocobalamin['dinner'][$i];
																	}
																	if($cyanocobalamindinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cyanocobalamindinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp; Folic Acid (or Folate)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_folic_acid['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_folic_acid['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $folic_aciddinner+=$arr_folic_acid['dinner'][$i];
																	}
																	if($folic_aciddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$folic_aciddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Biotin</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_biotin['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_biotin['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $biotindinner+=$arr_biotin['dinner'][$i];
																	}
																	if($biotindinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$biotindinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_ascorbic_acid['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_ascorbic_acid['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $ascorbic_aciddinner+=$arr_ascorbic_acid['dinner'][$i];
																	}
																	if($ascorbic_aciddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$ascorbic_aciddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin D (Calciferol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calciferol['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calciferol['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $calciferoldinner+=$arr_calciferol['dinner'][$i];
																	}
																	if($calciferoldinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciferoldinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tocopherol['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tocopherol['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $tocopheroldinner+=$arr_tocopherol['dinner'][$i];
																	}
																	if($tocopheroldinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tocopheroldinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phylloquinone['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phylloquinone['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $phylloquinonedinner+=$arr_phylloquinone['dinner'][$i];
																	}
																	if($phylloquinonedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phylloquinonedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Protein / Amino Acids</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_protein['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_protein['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $proteindinner+=$arr_protein['dinner'][$i];
																	}
																	if($proteindinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$proteindinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Alanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_alanine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_alanine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $alaninedinner+=$arr_alanine['dinner'][$i];
																	}
																	if($alaninedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$alaninedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Arginine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_arginine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_arginine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $argininedinner+=$arr_arginine['dinner'][$i];
																	}
																	if($argininedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$argininedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Aspartic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_aspartic_acid['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_aspartic_acid['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $aspartic_aciddinner+=$arr_aspartic_acid['dinner'][$i];
																	}
																	if($aspartic_aciddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$aspartic_aciddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cystine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_cystine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_cystine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $cystinedinner+=$arr_cystine['dinner'][$i];
																	}
																	if($cystinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$cystinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Giutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_giutamic_acid['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_giutamic_acid['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $giutamic_aciddinner+=$arr_giutamic_acid['dinner'][$i];
																	}
																	if($giutamic_aciddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$giutamic_aciddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_glycine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_glycine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $glycinedinner+=$arr_glycine['dinner'][$i];
																	}
																	if($glycinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$glycinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Histidine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_histidine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_histidine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $histidinedinner+=$arr_histidine['dinner'][$i];
																	}
																	if($histidinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$histidinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy-glutamic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_glutamic_acid['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_glutamic_acid['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $hydroxy_glutamic_aciddinner+=$arr_hydroxy_glutamic_acid['dinner'][$i];
																	}
																	if($hydroxy_glutamic_aciddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_glutamic_aciddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_hydroxy_proline['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_hydroxy_proline['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $hydroxy_prolinedinner+=$arr_hydroxy_proline['dinner'][$i];
																	}
																	if($hydroxy_prolinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$hydroxy_prolinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodogorgoic acid</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodogorgoic_acid['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodogorgoic_acid['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $iodogorgoic_aciddinner+=$arr_iodogorgoic_acid['dinner'][$i];
																	}
																	if($iodogorgoic_aciddinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodogorgoic_aciddinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Isoleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_isoleucine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_isoleucine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $isoleucinedinner+=$arr_isoleucine['dinner'][$i];
																	}
																	if($isoleucinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$isoleucinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Leucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_leucine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_leucine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $leucinedinner+=$arr_leucine['dinner'][$i];
																	}
																	if($leucinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$leucinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lysine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_lysine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_lysine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $lysinedinner+=$arr_lysine['dinner'][$i];
																	}
																	if($lysinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$lysinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Methionine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_methionine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_methionine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $methioninedinner+=$arr_methionine['dinner'][$i];
																	}
																	if($methioninedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$methioninedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Norleucine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_norleucine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_norleucine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $norleucinedinner+=$arr_norleucine['dinner'][$i];
																	}
																	if($norleucinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$norleucinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phenylalanine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phenylalanine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phenylalanine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $phenylalaninedinner+=$arr_phenylalanine['dinner'][$i];
																	}
																	if($phenylalaninedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phenylalaninedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Proline</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_proline['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_proline['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $prolinedinner+=$arr_proline['dinner'][$i];
																	}
																	if($prolinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$prolinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Serine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_serine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_serine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $serinedinner+=$arr_serine['dinner'][$i];
																	}
																	if($serinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$serinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Threonine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_threonine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_threonine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $threoninedinner+=$arr_threonine['dinner'][$i];
																	}
																	if($threoninedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$threoninedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Thyroxine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_thyroxine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_thyroxine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $thyroxinedinner+=$arr_thyroxine['dinner'][$i];
																	}
																	if($thyroxinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$thyroxinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tryptophane</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tryptophane['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tryptophane['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $tryptophanedinner+=$arr_tryptophane['dinner'][$i];
																	}
																	if($tryptophanedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tryptophanedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tyrosine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_tyrosine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_tyrosine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $tyrosinedinner+=$arr_tyrosine['dinner'][$i];
																	}
																	if($tyrosinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$tyrosinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Valine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_valine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_valine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $valinedinner+=$arr_valine['dinner'][$i];
																	}
																	if($valinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$valinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Minerals</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_total_minerals['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_total_minerals['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $total_mineralsdinner+=$arr_total_minerals['dinner'][$i];
																	}
																	if($total_mineralsdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$total_mineralsdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calcium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_calcium['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_calcium['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $calciumdinner+=$arr_calcium['dinner'][$i];
																	}
																	if($calciumdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$calciumdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iron['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iron['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $irondinner+=$arr_iron['dinner'][$i];
																	}
																	if($irondinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$irondinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Potassium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_potassium['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_potassium['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $potassiumdinner +=$arr_potassium['dinner'][$i];
																	}
																	if($potassiumdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$potassiumdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sodium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sodium['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sodium['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $sodiumdinner +=$arr_sodium['dinner'][$i];
																	}
																	if($sodiumdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sodiumdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phosphorus</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_phosphorus['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_phosphorus['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $phosphorusdinner +=$arr_phosphorus['dinner'][$i];
																	}
																	if($phosphorusdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$phosphorusdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sulphur</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_sulphur['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_sulphur['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $sulphurdinner +=$arr_sulphur['dinner'][$i];
																	}
																	if($sulphurdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$sulphurdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chlorine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chlorine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chlorine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $chlorinedinner +=$arr_chlorine['dinner'][$i];
																	}
																	if($chlorinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chlorinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_iodine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_iodine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $iodinedinner+=$arr_iodine['dinner'][$i];
																	}
																	if($iodinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$iodinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Magnesium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_magnesium['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_magnesium['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $magnesiumdinner+=$arr_magnesium['dinner'][$i];
																	}
																	if($magnesiumdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$magnesiumdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Zinc</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_zinc['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_zinc['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $zincdinner+=$arr_zinc['dinner'][$i];
																	}
																	if($zincdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$zincdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Copper</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_copper['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_copper['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $copperdinner+=$arr_copper['dinner'][$i];
																	}
																	if($copperdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$copperdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chromium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_chromium['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_chromium['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $chromiumdinner+=$arr_chromium['dinner'][$i];
																	}
																	if($chromiumdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$chromiumdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Manganese</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_manganese['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_manganese['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $manganesedinner+=$arr_manganese['dinner'][$i];
																	}
																	if($manganesedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$manganesedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Selenium</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_selenium['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_selenium['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $seleniumdinner+=$arr_selenium['dinner'][$i];
																	}
																	if($seleniumdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$seleniumdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Boron</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_boron['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_boron['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $borondinner+=$arr_boron['dinner'][$i];
																	}
																	if($borondinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$borondinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Molybdenum</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_molybdenum['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_molybdenum['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $molybdenumdinner+=$arr_molybdenum['dinner'][$i];
																	}
																	if($molybdenumdinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$molybdenumdinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';	
						$output.='<tr>
								<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Caffeine</td>';
																
																for($j=0,$i=1;$j<10;$j++,$i++)
																{ 
																
																 if($arr_caffeine['dinner'][$j] != '' )
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.$arr_caffeine['dinner'][$j].'</td>';
																	}
																	else
																	{
														$output.='<td colspan="1" height="30" bgcolor="#FFFFFF" align="center" valign="middle">'.'&nbsp;'.'</td>';
																			
																	}
																
																}
																
																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)
																	{
																	  $caffeinedinner+=$arr_caffeine['dinner'][$i];
																	}
																	if($caffeinedinner!='0')
														$output.='<td width="54" height="30" colspan="1" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;'.$caffeinedinner.'</td>';
																	else
																	$output.='<td width="54" colspan="1" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						$output.='</tr>';
						$output.='<td width="54" colspan="12" height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.'&nbsp;'.'</td>';
						}
											else
											{
											$output.='<td>'.'&nbsp;'.'</td>';
											}
											}
						$output .= '<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
	
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
	
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">	
							<td colspan="12" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>';				
								'</table>						
								</td>
								</tr>
						</tbody>
						</table>';
						
						
			}
			return $output;
		}	
?>