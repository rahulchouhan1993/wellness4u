<?php
function getEachMealPerDayChartHTMLAdviser($user_id,$date) 
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
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Each Meal Per Day Chart</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($date)).'</td>
							<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($date)).'</td>
							<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
							<td height="30" align="left" valign="middle"><strong><strong>No of days</strong></strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.count($arr_date).'</td>
							<td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_meal_entry.'</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		if( is_array($arr_meal_time['breakfast']) && count($arr_meal_time['breakfast']) > 0)
		{			
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
						<tr>
							<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Breakfast</strong></td>
							<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
						<tr>
							<td width="179" align="left" valign="top">
								<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
									></tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
									</tr>
								</table>
							</td>
							<td colspan="10" align="left" valign="top">
								<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_meal_time['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$i.'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_meal_time['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_time['breakfast'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_meal_item['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_item['breakfast'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_meal_measure['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_measure['breakfast'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_meal_ml['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_ml['breakfast'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_weight['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_weight['breakfast'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									$water = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_water['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_water['breakfast'][$j].'</td>';								
											$water+=$arr_water['breakfast'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($water > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$water.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$calories = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_calories['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_calories['breakfast'][$j].'</td>';								
											$calories+=$arr_calories['breakfast'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($calories > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$calories.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
																		$fat = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										if($arr_fat['breakfast'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_fat['breakfast'][$j].'</td>';								
											$fat+=$arr_fat['breakfast'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($fat > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$fat.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$saturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
		$output .= '								<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_saturated['breakfast'][$j] != '' )
										{
											$output .=  $arr_saturated['breakfast'][$j];
											$saturated+=$arr_saturated['breakfast'][$j];
										}
										else
										{
											$output .=  '&nbsp;';
										}
		$output .= '								</td>';
									}
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($saturated > 0)
											$output .= $saturated;
										else
											$output .= '&nbsp;';
		$output .= '								
										</td>
									</tr>
									<tr>';
									
									$monounsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
		$output .= '						<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_monounsaturated['breakfast'][$j] != '' )
										{
											$output .= $arr_monounsaturated['breakfast'][$j];
											$monounsaturated+=$arr_monounsaturated['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
		$output .= '								</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($monounsaturated > 0)
											$output .= $monounsaturated;
										else
											$output .= '&nbsp;';
										
		$output .= '						</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										
										if($arr_polyunsaturated['breakfast'][$j] != '' )
										{
											$output .= $arr_polyunsaturated['breakfast'][$j];
											$polyunsaturated+=$arr_polyunsaturated['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_linoleic['breakfast'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_linoleic['breakfast'][$j];
											$polyunsaturated+=$arr_polyunsaturated_linoleic['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$alphalinoleic = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_alphalinoleic['breakfast'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_alphalinoleic['breakfast'][$j];
											$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alphalinoleic > 0)
											$output .= $alphalinoleic;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cholesterol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_cholesterol['breakfast'][$j] != '' )
										{
											$output .= $arr_cholesterol['breakfast'][$j];
											$cholesterol+=$arr_cholesterol['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cholesterol > 0)
											$output .= $cholesterol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dietary_fiber = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_dietary_fiber['breakfast'][$j] != '' )
										{
											$output .= $arr_total_dietary_fiber['breakfast'][$j];
											$dietary_fiber+=$arr_total_dietary_fiber['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dietary_fiber > 0)
											$output .= $dietary_fiber;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$carbohydrate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_carbohydrate['breakfast'][$j] != '' )
										{
											$output .= $arr_carbohydrate['breakfast'][$j];
											$carbohydrate+=$arr_carbohydrate['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($carbohydrate > 0)
											$output .= $carbohydrate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glucose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_glucose['breakfast'][$j] != '' )
										{
											$output .= $arr_glucose['breakfast'][$j];
											$glucose+=$arr_glucose['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glucose > 0)
											$output .= $glucose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$fructose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_fructose['breakfast'][$j] != '' )
										{
											$output .= $arr_fructose['breakfast'][$j];
											$fructose+=$arr_fructose['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($fructose > 0)
											$output .= $fructose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$galactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_galactose['breakfast'][$j] != '' )
										{
											$output .= $arr_galactose['breakfast'][$j];
											$galactose+=$arr_galactose['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($galactose > 0)
											$output .= $galactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$disaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_disaccharide['breakfast'][$j] != '' )
										{
											$output .= $arr_disaccharide['breakfast'][$j];
											$disaccharide+=$arr_disaccharide['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($disaccharide > 0)
											$output .= $disaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$maltose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_maltose['breakfast'][$j] != '' )
										{
											$output .= $arr_maltose['breakfast'][$j];
											$maltose+=$arr_maltose['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($maltose > 0)
											$output .= $maltose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_lactose['breakfast'][$j] != '' )
										{
											$output .= $arr_lactose['breakfast'][$j];
											$lactose+=$arr_lactose['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lactose > 0)
											$output .= $lactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sucrose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_sucrose['breakfast'][$j] != '' )
										{
											$output .= $arr_sucrose['breakfast'][$j];
											$sucrose+=$arr_sucrose['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sucrose > 0)
											$output .= $sucrose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$polysaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_polysaccharide['breakfast'][$j] != '' )
										{
											$output .= $arr_total_polysaccharide['breakfast'][$j];
											$polysaccharide+=$arr_total_polysaccharide['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polysaccharide > 0)
											$output .= $polysaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$starch = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_starch['breakfast'][$j] != '' )
										{
											$output .= $arr_starch['breakfast'][$j];
											$starch+=$arr_starch['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($starch > 0)
											$output .= $starch;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cellulose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cellulose['breakfast'][$j] != '' )
										{
											$output .= $arr_cellulose['breakfast'][$j];
											$cellulose+=$arr_cellulose['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cellulose > 0)
											$output .= $cellulose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycogen = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycogen['breakfast'][$j] != '' )
										{
											$output .= $arr_glycogen['breakfast'][$j];
											$glycogen+=$arr_glycogen['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycogen > 0)
											$output .= $glycogen;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dextrins = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_dextrins['breakfast'][$j] != '' )
										{
											$output .= $arr_dextrins['breakfast'][$j];
											$dextrins+=$arr_dextrins['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dextrins > 0)
											$output .= $dextrins;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sugar = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sugar['breakfast'][$j] != '' )
										{
											$output .= $arr_sugar['breakfast'][$j];
											$sugar+=$arr_sugar['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sugar > 0)
											$output .= $sugar;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin['breakfast'][$j] != '' )
										{
											$output .= $arr_total_vitamin['breakfast'][$j];
											$total_vitamin+=$arr_total_vitamin['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin > 0)
											$output .= $total_vitamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_acetate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_acetate['breakfast'][$j] != '' )
										{
											$output .= $arr_vitamin_a_acetate['breakfast'][$j];
											$vitamin_a_acetate+=$arr_vitamin_a_acetate['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_acetate > 0)
											$output .= $vitamin_a_acetate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_retinol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_retinol['breakfast'][$j] != '' )
										{
											$output .= $arr_vitamin_a_retinol['breakfast'][$j];
											$vitamin_a_retinol+=$arr_vitamin_a_retinol['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_retinol > 0)
											$output .= $vitamin_a_retinol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin_b_complex = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin_b_complex['breakfast'][$j] != '' )
										{
											$output .= $arr_total_vitamin_b_complex['breakfast'][$j];
											$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin_b_complex > 0)
											$output .= $total_vitamin_b_complex;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thiamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thiamin['breakfast'][$j] != '' )
										{
											$output .= $arr_thiamin['breakfast'][$j];
											$thiamin+=$arr_thiamin['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thiamin > 0)
											$output .= $thiamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$riboflavin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_riboflavin['breakfast'][$j] != '' )
										{
											$output .= $arr_riboflavin['breakfast'][$j];
											$riboflavin+=$arr_riboflavin['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($riboflavin > 0)
											$output .= $riboflavin;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
									<tr>';
									
									$niacin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="middle" bgcolor="#FFFFFF">';
										if($arr_niacin['breakfast'][$j] != '' )
										{
											$output .= $arr_niacin['breakfast'][$j];
											$niacin+=$$arr_niacin['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($niacin > 0)
											$output .= $niacin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pantothenic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pantothenic_acid['breakfast'][$j] != '' )
										{
											$output .= $arr_pantothenic_acid['breakfast'][$j];
											$pantothenic_acid+=$arr_pantothenic_acid['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pantothenic_acid > 0)
											$output .= $pantothenic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pyridoxine_hcl = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pyridoxine_hcl['breakfast'][$j] != '' )
										{
											$output .= $arr_pyridoxine_hcl['breakfast'][$j];
											$pyridoxine_hcl+=$arr_pyridoxine_hcl['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pyridoxine_hcl > 0)
											$output .= $pyridoxine_hcl;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cyanocobalamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cyanocobalamin['breakfast'][$j] != '' )
										{
											$output .= $arr_cyanocobalamin['breakfast'][$j];
											$cyanocobalamin+=$arr_cyanocobalamin['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cyanocobalamin > 0)
											$output .= $cyanocobalamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$folic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_folic_acid['breakfast'][$j] != '' )
										{
											$output .= $arr_folic_acid['breakfast'][$j];
											$folic_acid+=$arr_folic_acid['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($folic_acid > 0)
											$output .= $folic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$biotin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_biotin['breakfast'][$j] != '' )
										{
											$output .= $arr_biotin['breakfast'][$j];
											$biotin+=$arr_biotin['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($biotin > 0)
											$output .= $biotin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$ascorbic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_ascorbic_acid['breakfast'][$j] != '' )
										{
											$output .= $arr_ascorbic_acid['breakfast'][$j];
											$ascorbic_acid+=$arr_ascorbic_acid['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($ascorbic_acid > 0)
											$output .= $ascorbic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calciferol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calciferol['breakfast'][$j] != '' )
										{
											$output .= $arr_calciferol['breakfast'][$j];
											$calciferol+=$arr_calciferol['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calciferol > 0)
											$output .= $calciferol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tocopherol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tocopherol['breakfast'][$j] != '' )
										{
											$output .= $arr_tocopherol['breakfast'][$j];
											$tocopherol+=$arr_tocopherol['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tocopherol > 0)
											$output .= $tocopherol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phylloquinone = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phylloquinone['breakfast'][$j] != '' )
										{
											$output .= $arr_phylloquinone['breakfast'][$j];
											$phylloquinone+=$arr_phylloquinone['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phylloquinone > 0)
											$output .= $phylloquinone;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$protein = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_protein['breakfast'][$j] != '' )
										{
											$output .= $arr_protein['breakfast'][$j];
											$protein+=$arr_protein['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($protein > 0)
											$output .= $protein;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$alanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_alanine['breakfast'][$j] != '' )
										{
											$output .= $arr_alanine['breakfast'][$j];
											$alanine+=$arr_alanine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alanine > 0)
											$output .= $alanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$arginine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_arginine['breakfast'][$j] != '' )
										{
											$output .= $arr_arginine['breakfast'][$j];
											$arginine+=$arr_arginine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($arginine > 0)
											$output .= $arginine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$aspartic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_aspartic_acid['breakfast'][$j] != '' )
										{
											$output .= $arr_aspartic_acid['breakfast'][$j];
											$aspartic_acid+=$arr_aspartic_acid['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($aspartic_acid > 0)
											$output .= $aspartic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cystine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cystine['breakfast'][$j] != '' )
										{
											$output .= $arr_cystine['breakfast'][$j];
											$cystine+=$arr_cystine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cystine > 0)
											$output .= $cystine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$giutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_giutamic_acid['breakfast'][$j] != '' )
										{
											$output .= $arr_giutamic_acid['breakfast'][$j];
											$giutamic_acid+=$arr_giutamic_acid['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($giutamic_acid > 0)
											$output .= $giutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycine['breakfast'][$j] != '' )
										{
											$output .= $arr_glycine['breakfast'][$j];
											$glycine+=$arr_glycine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycine > 0)
											$output .= $glycine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$histidine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_histidine['breakfast'][$j] != '' )
										{
											$output .= $arr_histidine['breakfast'][$j];
											$histidine+=$arr_histidine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($histidine > 0)
											$output .= $histidine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_glutamic_acid['breakfast'][$j] != '' )
										{
											$output .= $arr_hydroxy_glutamic_acid['breakfast'][$j];
											$glutamic_acid+=$arr_hydroxy_glutamic_acid['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glutamic_acid > 0)
											$output .= $glutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$hydroxy_proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_proline['breakfast'][$j] != '' )
										{
											$output .= $arr_hydroxy_proline['breakfast'][$j];
											$hydroxy_proline+=$arr_hydroxy_proline['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($hydroxy_proline > 0)
											$output .= $hydroxy_proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodogorgoic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodogorgoic_acid['breakfast'][$j] != '' )
										{
											$output .= $arr_iodogorgoic_acid['breakfast'][$j];
											$iodogorgoic_acid+=$arr_iodogorgoic_acid['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodogorgoic_acid > 0)
											$output .= $iodogorgoic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$isoleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_isoleucine['breakfast'][$j] != '' )
										{
											$output .= $arr_isoleucine['breakfast'][$j];
											$isoleucine+=$arr_isoleucine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($isoleucine > 0)
											$output .= $isoleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$leucine= 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_leucine['breakfast'][$j] != '' )
										{
											$output .= $arr_leucine['breakfast'][$j];
											$leucine+=$arr_leucine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($leucine > 0)
											$output .= $leucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lysine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_lysine['breakfast'][$j] != '' )
										{
											$output .= $arr_lysine['breakfast'][$j];
											$lysine+=$arr_lysine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lysine > 0)
											$output .= $lysine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$methionine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_methionine['breakfast'][$j] != '' )
										{
											$output .= $arr_methionine['breakfast'][$j];
											$methionine+=$arr_methionine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($methionine > 0)
											$output .= $methionine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$norleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_norleucine['breakfast'][$j] != '' )
										{
											$output .= $arr_norleucine['breakfast'][$j];
											$norleucine+=$arr_norleucine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($norleucine > 0)
											$output .= $norleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phenylalanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phenylalanine['breakfast'][$j] != '' )
										{
											$output .= $arr_phenylalanine['breakfast'][$j];
											$phenylalanine+=$arr_phenylalanine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phenylalanine > 0)
											$output .= $phenylalanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_proline['breakfast'][$j] != '' )
										{
											$output .= $arr_proline['breakfast'][$j];
											$proline+=$arr_proline['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($proline > 0)
											$output .= $proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$serine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_serine['breakfast'][$j] != '' )
										{
											$output .= $arr_serine['breakfast'][$j];
											$serine+=$arr_serine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($serine > 0)
											$output .= $serine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$threonine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_threonine['breakfast'][$j] != '' )
										{
											$output .= $arr_threonine['breakfast'][$j];
											$threonine+=$arr_threonine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($threonine > 0)
											$output .= $threonine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thyroxine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thyroxine['breakfast'][$j] != '' )
										{
											$output .= $arr_thyroxine['breakfast'][$j];
											$thyroxine+=$arr_thyroxine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thyroxine > 0)
											$output .= $thyroxine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tryptophane = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tryptophane['breakfast'][$j] != '' )
										{
											$output .= $arr_tryptophane['breakfast'][$j];
											$tryptophane+=$arr_tryptophane['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tryptophane > 0)
											$output .= $tryptophane;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tyrosine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tyrosine['breakfast'][$j] != '' )
										{
											$output .= $arr_tyrosine['breakfast'][$j];
											$tyrosine+=$arr_tyrosine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tyrosine > 0)
											$output .= $tyrosine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$valine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_valine['breakfast'][$j] != '' )
										{
											$output .= $arr_valine['breakfast'][$j];
											$valine+=$arr_valine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($valine > 0)
											$output .= $valine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_minerals = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_minerals['breakfast'][$j] != '' )
										{
											$output .= $arr_total_minerals['breakfast'][$j];
											$total_minerals+=$arr_total_minerals['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_minerals > 0)
											$output .= $total_minerals;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calcium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calcium['breakfast'][$j] != '' )
										{
											$output .= $arr_calcium['breakfast'][$j];
											$calcium+=$arr_calcium['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calcium > 0)
											$output .= $calcium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iron['breakfast'][$j] != '' )
										{
											$output .= $arr_iron['breakfast'][$j];
											$iron+=$arr_iron['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iron > 0)
											$output .= $iron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$potassium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_potassium['breakfast'][$j] != '' )
										{
											$output .= $arr_potassium['breakfast'][$j];
											$potassium+=$arr_potassium['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($potassium > 0)
											$output .= $potassium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sodium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sodium['breakfast'][$j] != '' )
										{
											$output .= $arr_sodium['breakfast'][$j];
											$sodium+=$arr_sodium['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sodium > 0)
											$output .= $sodium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phosphorus = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phosphorus['breakfast'][$j] != '' )
										{
											$output .= $arr_phosphorus['breakfast'][$j];
											$phosphorus+=$arr_phosphorus['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phosphorus > 0)
											$output .= $phosphorus;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sulphur = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sulphur['breakfast'][$j] != '' )
										{
											$output .= $arr_sulphur['breakfast'][$j];
											$sulphur+=$arr_sulphur['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sulphur > 0)
											$output .= $sulphur;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chlorine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chlorine['breakfast'][$j] != '' )
										{
											$output .= $arr_chlorine['breakfast'][$j];
											$chlorine+=$arr_chlorine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chlorine > 0)
											$output .= $chlorine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodine['breakfast'][$j] != '' )
										{
											$output .= $arr_iodine['breakfast'][$j];
											$iodine+=$arr_iodine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodine > 0)
											$output .= $iodine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$magnesium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_magnesium['breakfast'][$j] != '' )
										{
											$output .= $arr_magnesium['breakfast'][$j];
											$magnesium+=$arr_magnesium['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($magnesium > 0)
											$output .= $magnesium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$zinc = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_zinc['breakfast'][$j] != '' )
										{
											$output .= $arr_zinc['breakfast'][$j];
											$zinc+=$arr_zinc['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($zinc > 0)
											$output .= $zinc;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$copper = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_copper['breakfast'][$j] != '' )
										{
											$output .= $arr_copper['breakfast'][$j];
											$copper+=$arr_copper['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($copper > 0)
											$output .= $copper;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chromium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chromium['breakfast'][$j] != '' )
										{
											$output .= $arr_chromium['breakfast'][$j];
											$chromium+=$arr_chromium['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chromium > 0)
											$output .= $chromium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$manganese = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_manganese['breakfast'][$j] != '' )
										{
											$output .= $arr_manganese['breakfast'][$j];
											$manganese+=$arr_manganese['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($manganese > 0)
											$output .= $manganese;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$selenium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_selenium['breakfast'][$j] != '' )
										{
											$output .= $arr_selenium['breakfast'][$j];
											$selenium+=$arr_selenium['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($selenium > 0)
											$output .= $selenium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$boron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_boron['breakfast'][$j] != '' )
										{
											$output .= $arr_boron['breakfast'][$j];
											$boron+=$arr_boron['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($boron > 0)
											$output .= $boron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$molybdenum = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_molybdenum['breakfast'][$j] != '' )
										{
											$output .= $arr_molybdenum['breakfast'][$j];
											$molybdenum+=$arr_molybdenum['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($molybdenum > 0)
											$output .= $molybdenum;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$caffeine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_caffeine['breakfast'][$j] != '' )
										{
											$output .= $arr_caffeine['breakfast'][$j];
											$caffeine+=$arr_caffeine['breakfast'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($caffeine > 0)
											$output .= $caffeine;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>';
		}
		
		if( is_array($arr_meal_time['brunch']) && count($arr_meal_time['brunch']) > 0)
		{			
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
						<tr>
							<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>brunch</strong></td>
							<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
						<tr>
							<td width="179" align="left" valign="top">
								<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
									></tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>

									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
									</tr>
								</table>
							</td>
							<td colspan="10" align="left" valign="top">
								<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_meal_time['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$i.'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_meal_time['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_time['brunch'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_meal_item['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_item['brunch'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_meal_measure['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_measure['brunch'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_meal_ml['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_ml['brunch'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_weight['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_weight['brunch'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									$water = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_water['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_water['brunch'][$j].'</td>';								
											$water+=$arr_water['brunch'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($water > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$water.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$calories = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_calories['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_calories['brunch'][$j].'</td>';								
											$calories+=$arr_calories['brunch'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($calories > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$calories.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
																		$fat = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										if($arr_fat['brunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_fat['brunch'][$j].'</td>';								
											$fat+=$arr_fat['brunch'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($fat > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$fat.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$saturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
		$output .= '								<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_saturated['brunch'][$j] != '' )
										{
											$output .=  $arr_saturated['brunch'][$j];
											$saturated+=$arr_saturated['brunch'][$j];
										}
										else
										{
											$output .=  '&nbsp;';
										}
		$output .= '								</td>';
									}
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($saturated > 0)
											$output .= $saturated;
										else
											$output .= '&nbsp;';
		$output .= '								
										</td>
									</tr>
									<tr>';
									
									$monounsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
		$output .= '						<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_monounsaturated['brunch'][$j] != '' )
										{
											$output .= $arr_monounsaturated['brunch'][$j];
											$monounsaturated+=$arr_monounsaturated['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
		$output .= '								</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($monounsaturated > 0)
											$output .= $monounsaturated;
										else
											$output .= '&nbsp;';
										
		$output .= '						</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										
										if($arr_polyunsaturated['brunch'][$j] != '' )
										{
											$output .= $arr_polyunsaturated['brunch'][$j];
											$polyunsaturated+=$arr_polyunsaturated['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_linoleic['brunch'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_linoleic['brunch'][$j];
											$polyunsaturated+=$arr_polyunsaturated_linoleic['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$alphalinoleic = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_alphalinoleic['brunch'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_alphalinoleic['brunch'][$j];
											$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alphalinoleic > 0)
											$output .= $alphalinoleic;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cholesterol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_cholesterol['brunch'][$j] != '' )
										{
											$output .= $arr_cholesterol['brunch'][$j];
											$cholesterol+=$arr_cholesterol['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cholesterol > 0)
											$output .= $cholesterol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dietary_fiber = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_dietary_fiber['brunch'][$j] != '' )
										{
											$output .= $arr_total_dietary_fiber['brunch'][$j];
											$dietary_fiber+=$arr_total_dietary_fiber['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dietary_fiber > 0)
											$output .= $dietary_fiber;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$carbohydrate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_carbohydrate['brunch'][$j] != '' )
										{
											$output .= $arr_carbohydrate['brunch'][$j];
											$carbohydrate+=$arr_carbohydrate['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($carbohydrate > 0)
											$output .= $carbohydrate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glucose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_glucose['brunch'][$j] != '' )
										{
											$output .= $arr_glucose['brunch'][$j];
											$glucose+=$arr_glucose['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glucose > 0)
											$output .= $glucose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$fructose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_fructose['brunch'][$j] != '' )
										{
											$output .= $arr_fructose['brunch'][$j];
											$fructose+=$arr_fructose['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($fructose > 0)
											$output .= $fructose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$galactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_galactose['brunch'][$j] != '' )
										{
											$output .= $arr_galactose['brunch'][$j];
											$galactose+=$arr_galactose['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($galactose > 0)
											$output .= $galactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$disaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_disaccharide['brunch'][$j] != '' )
										{
											$output .= $arr_disaccharide['brunch'][$j];
											$disaccharide+=$arr_disaccharide['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($disaccharide > 0)
											$output .= $disaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$maltose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_maltose['brunch'][$j] != '' )
										{
											$output .= $arr_maltose['brunch'][$j];
											$maltose+=$arr_maltose['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($maltose > 0)
											$output .= $maltose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_lactose['brunch'][$j] != '' )
										{
											$output .= $arr_lactose['brunch'][$j];
											$lactose+=$arr_lactose['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lactose > 0)
											$output .= $lactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sucrose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_sucrose['brunch'][$j] != '' )
										{
											$output .= $arr_sucrose['brunch'][$j];
											$sucrose+=$arr_sucrose['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sucrose > 0)
											$output .= $sucrose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$polysaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_polysaccharide['brunch'][$j] != '' )
										{
											$output .= $arr_total_polysaccharide['brunch'][$j];
											$polysaccharide+=$arr_total_polysaccharide['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polysaccharide > 0)
											$output .= $polysaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$starch = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_starch['brunch'][$j] != '' )
										{
											$output .= $arr_starch['brunch'][$j];
											$starch+=$arr_starch['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($starch > 0)
											$output .= $starch;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cellulose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cellulose['brunch'][$j] != '' )
										{
											$output .= $arr_cellulose['brunch'][$j];
											$cellulose+=$arr_cellulose['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cellulose > 0)
											$output .= $cellulose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycogen = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycogen['brunch'][$j] != '' )
										{
											$output .= $arr_glycogen['brunch'][$j];
											$glycogen+=$arr_glycogen['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycogen > 0)
											$output .= $glycogen;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dextrins = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_dextrins['brunch'][$j] != '' )
										{
											$output .= $arr_dextrins['brunch'][$j];
											$dextrins+=$arr_dextrins['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dextrins > 0)
											$output .= $dextrins;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sugar = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sugar['brunch'][$j] != '' )
										{
											$output .= $arr_sugar['brunch'][$j];
											$sugar+=$arr_sugar['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sugar > 0)
											$output .= $sugar;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin['brunch'][$j] != '' )
										{
											$output .= $arr_total_vitamin['brunch'][$j];
											$total_vitamin+=$arr_total_vitamin['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin > 0)
											$output .= $total_vitamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_acetate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_acetate['brunch'][$j] != '' )
										{
											$output .= $arr_vitamin_a_acetate['brunch'][$j];
											$vitamin_a_acetate+=$arr_vitamin_a_acetate['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_acetate > 0)
											$output .= $vitamin_a_acetate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_retinol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_retinol['brunch'][$j] != '' )
										{
											$output .= $arr_vitamin_a_retinol['brunch'][$j];
											$vitamin_a_retinol+=$arr_vitamin_a_retinol['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_retinol > 0)
											$output .= $vitamin_a_retinol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin_b_complex = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin_b_complex['brunch'][$j] != '' )
										{
											$output .= $arr_total_vitamin_b_complex['brunch'][$j];
											$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin_b_complex > 0)
											$output .= $total_vitamin_b_complex;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thiamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thiamin['brunch'][$j] != '' )
										{
											$output .= $arr_thiamin['brunch'][$j];
											$thiamin+=$arr_thiamin['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thiamin > 0)
											$output .= $thiamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$riboflavin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_riboflavin['brunch'][$j] != '' )
										{
											$output .= $arr_riboflavin['brunch'][$j];
											$riboflavin+=$arr_riboflavin['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($riboflavin > 0)
											$output .= $riboflavin;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
									<tr>';
									
									$niacin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="middle" bgcolor="#FFFFFF">';
										if($arr_niacin['brunch'][$j] != '' )
										{
											$output .= $arr_niacin['brunch'][$j];
											$niacin+=$$arr_niacin['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($niacin > 0)
											$output .= $niacin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pantothenic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pantothenic_acid['brunch'][$j] != '' )
										{
											$output .= $arr_pantothenic_acid['brunch'][$j];
											$pantothenic_acid+=$arr_pantothenic_acid['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pantothenic_acid > 0)
											$output .= $pantothenic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pyridoxine_hcl = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pyridoxine_hcl['brunch'][$j] != '' )
										{
											$output .= $arr_pyridoxine_hcl['brunch'][$j];
											$pyridoxine_hcl+=$arr_pyridoxine_hcl['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pyridoxine_hcl > 0)
											$output .= $pyridoxine_hcl;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cyanocobalamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cyanocobalamin['brunch'][$j] != '' )
										{
											$output .= $arr_cyanocobalamin['brunch'][$j];
											$cyanocobalamin+=$arr_cyanocobalamin['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cyanocobalamin > 0)
											$output .= $cyanocobalamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$folic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_folic_acid['brunch'][$j] != '' )
										{
											$output .= $arr_folic_acid['brunch'][$j];
											$folic_acid+=$arr_folic_acid['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($folic_acid > 0)
											$output .= $folic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$biotin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_biotin['brunch'][$j] != '' )
										{
											$output .= $arr_biotin['brunch'][$j];
											$biotin+=$arr_biotin['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($biotin > 0)
											$output .= $biotin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$ascorbic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_ascorbic_acid['brunch'][$j] != '' )
										{
											$output .= $arr_ascorbic_acid['brunch'][$j];
											$ascorbic_acid+=$arr_ascorbic_acid['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($ascorbic_acid > 0)
											$output .= $ascorbic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calciferol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calciferol['brunch'][$j] != '' )
										{
											$output .= $arr_calciferol['brunch'][$j];
											$calciferol+=$arr_calciferol['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calciferol > 0)
											$output .= $calciferol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tocopherol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tocopherol['brunch'][$j] != '' )
										{
											$output .= $arr_tocopherol['brunch'][$j];
											$tocopherol+=$arr_tocopherol['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tocopherol > 0)
											$output .= $tocopherol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phylloquinone = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phylloquinone['brunch'][$j] != '' )
										{
											$output .= $arr_phylloquinone['brunch'][$j];
											$phylloquinone+=$arr_phylloquinone['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phylloquinone > 0)
											$output .= $phylloquinone;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$protein = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_protein['brunch'][$j] != '' )
										{
											$output .= $arr_protein['brunch'][$j];
											$protein+=$arr_protein['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($protein > 0)
											$output .= $protein;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$alanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_alanine['brunch'][$j] != '' )
										{
											$output .= $arr_alanine['brunch'][$j];
											$alanine+=$arr_alanine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alanine > 0)
											$output .= $alanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$arginine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_arginine['brunch'][$j] != '' )
										{
											$output .= $arr_arginine['brunch'][$j];
											$arginine+=$arr_arginine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($arginine > 0)
											$output .= $arginine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$aspartic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_aspartic_acid['brunch'][$j] != '' )
										{
											$output .= $arr_aspartic_acid['brunch'][$j];
											$aspartic_acid+=$arr_aspartic_acid['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($aspartic_acid > 0)
											$output .= $aspartic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cystine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cystine['brunch'][$j] != '' )
										{
											$output .= $arr_cystine['brunch'][$j];
											$cystine+=$arr_cystine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cystine > 0)
											$output .= $cystine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$giutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_giutamic_acid['brunch'][$j] != '' )
										{
											$output .= $arr_giutamic_acid['brunch'][$j];
											$giutamic_acid+=$arr_giutamic_acid['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($giutamic_acid > 0)
											$output .= $giutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycine['brunch'][$j] != '' )
										{
											$output .= $arr_glycine['brunch'][$j];
											$glycine+=$arr_glycine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycine > 0)
											$output .= $glycine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$histidine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_histidine['brunch'][$j] != '' )
										{
											$output .= $arr_histidine['brunch'][$j];
											$histidine+=$arr_histidine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($histidine > 0)
											$output .= $histidine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_glutamic_acid['brunch'][$j] != '' )
										{
											$output .= $arr_hydroxy_glutamic_acid['brunch'][$j];
											$glutamic_acid+=$arr_hydroxy_glutamic_acid['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glutamic_acid > 0)
											$output .= $glutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$hydroxy_proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_proline['brunch'][$j] != '' )
										{
											$output .= $arr_hydroxy_proline['brunch'][$j];
											$hydroxy_proline+=$arr_hydroxy_proline['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($hydroxy_proline > 0)
											$output .= $hydroxy_proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodogorgoic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodogorgoic_acid['brunch'][$j] != '' )
										{
											$output .= $arr_iodogorgoic_acid['brunch'][$j];
											$iodogorgoic_acid+=$arr_iodogorgoic_acid['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodogorgoic_acid > 0)
											$output .= $iodogorgoic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$isoleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_isoleucine['brunch'][$j] != '' )
										{
											$output .= $arr_isoleucine['brunch'][$j];
											$isoleucine+=$arr_isoleucine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($isoleucine > 0)
											$output .= $isoleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$leucine= 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_leucine['brunch'][$j] != '' )
										{
											$output .= $arr_leucine['brunch'][$j];
											$leucine+=$arr_leucine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($leucine > 0)
											$output .= $leucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lysine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_lysine['brunch'][$j] != '' )
										{
											$output .= $arr_lysine['brunch'][$j];
											$lysine+=$arr_lysine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lysine > 0)
											$output .= $lysine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$methionine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_methionine['brunch'][$j] != '' )
										{
											$output .= $arr_methionine['brunch'][$j];
											$methionine+=$arr_methionine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($methionine > 0)
											$output .= $methionine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$norleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_norleucine['brunch'][$j] != '' )
										{
											$output .= $arr_norleucine['brunch'][$j];
											$norleucine+=$arr_norleucine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($norleucine > 0)
											$output .= $norleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phenylalanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phenylalanine['brunch'][$j] != '' )
										{
											$output .= $arr_phenylalanine['brunch'][$j];
											$phenylalanine+=$arr_phenylalanine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phenylalanine > 0)
											$output .= $phenylalanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_proline['brunch'][$j] != '' )
										{
											$output .= $arr_proline['brunch'][$j];
											$proline+=$arr_proline['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($proline > 0)
											$output .= $proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$serine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_serine['brunch'][$j] != '' )
										{
											$output .= $arr_serine['brunch'][$j];
											$serine+=$arr_serine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($serine > 0)
											$output .= $serine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$threonine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_threonine['brunch'][$j] != '' )
										{
											$output .= $arr_threonine['brunch'][$j];
											$threonine+=$arr_threonine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($threonine > 0)
											$output .= $threonine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thyroxine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thyroxine['brunch'][$j] != '' )
										{
											$output .= $arr_thyroxine['brunch'][$j];
											$thyroxine+=$arr_thyroxine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thyroxine > 0)
											$output .= $thyroxine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tryptophane = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tryptophane['brunch'][$j] != '' )
										{
											$output .= $arr_tryptophane['brunch'][$j];
											$tryptophane+=$arr_tryptophane['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tryptophane > 0)
											$output .= $tryptophane;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tyrosine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tyrosine['brunch'][$j] != '' )
										{
											$output .= $arr_tyrosine['brunch'][$j];
											$tyrosine+=$arr_tyrosine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tyrosine > 0)
											$output .= $tyrosine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$valine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_valine['brunch'][$j] != '' )
										{
											$output .= $arr_valine['brunch'][$j];
											$valine+=$arr_valine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($valine > 0)
											$output .= $valine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_minerals = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_minerals['brunch'][$j] != '' )
										{
											$output .= $arr_total_minerals['brunch'][$j];
											$total_minerals+=$arr_total_minerals['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_minerals > 0)
											$output .= $total_minerals;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calcium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calcium['brunch'][$j] != '' )
										{
											$output .= $arr_calcium['brunch'][$j];
											$calcium+=$arr_calcium['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calcium > 0)
											$output .= $calcium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iron['brunch'][$j] != '' )
										{
											$output .= $arr_iron['brunch'][$j];
											$iron+=$arr_iron['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iron > 0)
											$output .= $iron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$potassium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_potassium['brunch'][$j] != '' )
										{
											$output .= $arr_potassium['brunch'][$j];
											$potassium+=$arr_potassium['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($potassium > 0)
											$output .= $potassium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sodium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sodium['brunch'][$j] != '' )
										{
											$output .= $arr_sodium['brunch'][$j];
											$sodium+=$arr_sodium['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sodium > 0)
											$output .= $sodium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phosphorus = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phosphorus['brunch'][$j] != '' )
										{
											$output .= $arr_phosphorus['brunch'][$j];
											$phosphorus+=$arr_phosphorus['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phosphorus > 0)
											$output .= $phosphorus;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sulphur = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sulphur['brunch'][$j] != '' )
										{
											$output .= $arr_sulphur['brunch'][$j];
											$sulphur+=$arr_sulphur['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sulphur > 0)
											$output .= $sulphur;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chlorine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chlorine['brunch'][$j] != '' )
										{
											$output .= $arr_chlorine['brunch'][$j];
											$chlorine+=$arr_chlorine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chlorine > 0)
											$output .= $chlorine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodine['brunch'][$j] != '' )
										{
											$output .= $arr_iodine['brunch'][$j];
											$iodine+=$arr_iodine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodine > 0)
											$output .= $iodine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$magnesium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_magnesium['brunch'][$j] != '' )
										{
											$output .= $arr_magnesium['brunch'][$j];
											$magnesium+=$arr_magnesium['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($magnesium > 0)
											$output .= $magnesium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$zinc = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_zinc['brunch'][$j] != '' )
										{
											$output .= $arr_zinc['brunch'][$j];
											$zinc+=$arr_zinc['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($zinc > 0)
											$output .= $zinc;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$copper = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_copper['brunch'][$j] != '' )
										{
											$output .= $arr_copper['brunch'][$j];
											$copper+=$arr_copper['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($copper > 0)
											$output .= $copper;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chromium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chromium['brunch'][$j] != '' )
										{
											$output .= $arr_chromium['brunch'][$j];
											$chromium+=$arr_chromium['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chromium > 0)
											$output .= $chromium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$manganese = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_manganese['brunch'][$j] != '' )
										{
											$output .= $arr_manganese['brunch'][$j];
											$manganese+=$arr_manganese['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($manganese > 0)
											$output .= $manganese;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$selenium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_selenium['brunch'][$j] != '' )
										{
											$output .= $arr_selenium['brunch'][$j];
											$selenium+=$arr_selenium['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($selenium > 0)
											$output .= $selenium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$boron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_boron['brunch'][$j] != '' )
										{
											$output .= $arr_boron['brunch'][$j];
											$boron+=$arr_boron['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($boron > 0)
											$output .= $boron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$molybdenum = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_molybdenum['brunch'][$j] != '' )
										{
											$output .= $arr_molybdenum['brunch'][$j];
											$molybdenum+=$arr_molybdenum['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($molybdenum > 0)
											$output .= $molybdenum;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$caffeine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_caffeine['brunch'][$j] != '' )
										{
											$output .= $arr_caffeine['brunch'][$j];
											$caffeine+=$arr_caffeine['brunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($caffeine > 0)
											$output .= $caffeine;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>';
		}
		
		if( is_array($arr_meal_time['lunch']) && count($arr_meal_time['lunch']) > 0)
		{			
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
						<tr>
							<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>lunch</strong></td>
							<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
						<tr>
							<td width="179" align="left" valign="top">
								<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
									></tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>

									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
									</tr>
								</table>
							</td>
							<td colspan="10" align="left" valign="top">
								<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_meal_time['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$i.'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_meal_time['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_time['lunch'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_meal_item['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_item['lunch'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_meal_measure['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_measure['lunch'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_meal_ml['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_ml['lunch'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_weight['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_weight['lunch'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									$water = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_water['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_water['lunch'][$j].'</td>';								
											$water+=$arr_water['lunch'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($water > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$water.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$calories = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_calories['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_calories['lunch'][$j].'</td>';								
											$calories+=$arr_calories['lunch'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($calories > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$calories.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
																		$fat = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										if($arr_fat['lunch'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_fat['lunch'][$j].'</td>';								
											$fat+=$arr_fat['lunch'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($fat > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$fat.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$saturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
		$output .= '								<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_saturated['lunch'][$j] != '' )
										{
											$output .=  $arr_saturated['lunch'][$j];
											$saturated+=$arr_saturated['lunch'][$j];
										}
										else
										{
											$output .=  '&nbsp;';
										}
		$output .= '								</td>';
									}
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($saturated > 0)
											$output .= $saturated;
										else
											$output .= '&nbsp;';
		$output .= '								
										</td>
									</tr>
									<tr>';
									
									$monounsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
		$output .= '						<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_monounsaturated['lunch'][$j] != '' )
										{
											$output .= $arr_monounsaturated['lunch'][$j];
											$monounsaturated+=$arr_monounsaturated['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
		$output .= '								</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($monounsaturated > 0)
											$output .= $monounsaturated;
										else
											$output .= '&nbsp;';
										
		$output .= '						</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										
										if($arr_polyunsaturated['lunch'][$j] != '' )
										{
											$output .= $arr_polyunsaturated['lunch'][$j];
											$polyunsaturated+=$arr_polyunsaturated['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_linoleic['lunch'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_linoleic['lunch'][$j];
											$polyunsaturated+=$arr_polyunsaturated_linoleic['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$alphalinoleic = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_alphalinoleic['lunch'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_alphalinoleic['lunch'][$j];
											$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alphalinoleic > 0)
											$output .= $alphalinoleic;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cholesterol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_cholesterol['lunch'][$j] != '' )
										{
											$output .= $arr_cholesterol['lunch'][$j];
											$cholesterol+=$arr_cholesterol['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cholesterol > 0)
											$output .= $cholesterol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dietary_fiber = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_dietary_fiber['lunch'][$j] != '' )
										{
											$output .= $arr_total_dietary_fiber['lunch'][$j];
											$dietary_fiber+=$arr_total_dietary_fiber['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dietary_fiber > 0)
											$output .= $dietary_fiber;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$carbohydrate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_carbohydrate['lunch'][$j] != '' )
										{
											$output .= $arr_carbohydrate['lunch'][$j];
											$carbohydrate+=$arr_carbohydrate['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($carbohydrate > 0)
											$output .= $carbohydrate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glucose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_glucose['lunch'][$j] != '' )
										{
											$output .= $arr_glucose['lunch'][$j];
											$glucose+=$arr_glucose['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glucose > 0)
											$output .= $glucose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$fructose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_fructose['lunch'][$j] != '' )
										{
											$output .= $arr_fructose['lunch'][$j];
											$fructose+=$arr_fructose['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($fructose > 0)
											$output .= $fructose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$galactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_galactose['lunch'][$j] != '' )
										{
											$output .= $arr_galactose['lunch'][$j];
											$galactose+=$arr_galactose['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($galactose > 0)
											$output .= $galactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$disaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_disaccharide['lunch'][$j] != '' )
										{
											$output .= $arr_disaccharide['lunch'][$j];
											$disaccharide+=$arr_disaccharide['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($disaccharide > 0)
											$output .= $disaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$maltose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_maltose['lunch'][$j] != '' )
										{
											$output .= $arr_maltose['lunch'][$j];
											$maltose+=$arr_maltose['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($maltose > 0)
											$output .= $maltose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_lactose['lunch'][$j] != '' )
										{
											$output .= $arr_lactose['lunch'][$j];
											$lactose+=$arr_lactose['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lactose > 0)
											$output .= $lactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sucrose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_sucrose['lunch'][$j] != '' )
										{
											$output .= $arr_sucrose['lunch'][$j];
											$sucrose+=$arr_sucrose['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sucrose > 0)
											$output .= $sucrose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$polysaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_polysaccharide['lunch'][$j] != '' )
										{
											$output .= $arr_total_polysaccharide['lunch'][$j];
											$polysaccharide+=$arr_total_polysaccharide['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polysaccharide > 0)
											$output .= $polysaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$starch = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_starch['lunch'][$j] != '' )
										{
											$output .= $arr_starch['lunch'][$j];
											$starch+=$arr_starch['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($starch > 0)
											$output .= $starch;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cellulose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cellulose['lunch'][$j] != '' )
										{
											$output .= $arr_cellulose['lunch'][$j];
											$cellulose+=$arr_cellulose['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cellulose > 0)
											$output .= $cellulose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycogen = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycogen['lunch'][$j] != '' )
										{
											$output .= $arr_glycogen['lunch'][$j];
											$glycogen+=$arr_glycogen['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycogen > 0)
											$output .= $glycogen;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dextrins = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_dextrins['lunch'][$j] != '' )
										{
											$output .= $arr_dextrins['lunch'][$j];
											$dextrins+=$arr_dextrins['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dextrins > 0)
											$output .= $dextrins;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sugar = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sugar['lunch'][$j] != '' )
										{
											$output .= $arr_sugar['lunch'][$j];
											$sugar+=$arr_sugar['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sugar > 0)
											$output .= $sugar;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin['lunch'][$j] != '' )
										{
											$output .= $arr_total_vitamin['lunch'][$j];
											$total_vitamin+=$arr_total_vitamin['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin > 0)
											$output .= $total_vitamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_acetate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_acetate['lunch'][$j] != '' )
										{
											$output .= $arr_vitamin_a_acetate['lunch'][$j];
											$vitamin_a_acetate+=$arr_vitamin_a_acetate['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_acetate > 0)
											$output .= $vitamin_a_acetate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_retinol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_retinol['lunch'][$j] != '' )
										{
											$output .= $arr_vitamin_a_retinol['lunch'][$j];
											$vitamin_a_retinol+=$arr_vitamin_a_retinol['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_retinol > 0)
											$output .= $vitamin_a_retinol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin_b_complex = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin_b_complex['lunch'][$j] != '' )
										{
											$output .= $arr_total_vitamin_b_complex['lunch'][$j];
											$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin_b_complex > 0)
											$output .= $total_vitamin_b_complex;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thiamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thiamin['lunch'][$j] != '' )
										{
											$output .= $arr_thiamin['lunch'][$j];
											$thiamin+=$arr_thiamin['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thiamin > 0)
											$output .= $thiamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$riboflavin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_riboflavin['lunch'][$j] != '' )
										{
											$output .= $arr_riboflavin['lunch'][$j];
											$riboflavin+=$arr_riboflavin['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($riboflavin > 0)
											$output .= $riboflavin;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
									<tr>';
									
									$niacin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="middle" bgcolor="#FFFFFF">';
										if($arr_niacin['lunch'][$j] != '' )
										{
											$output .= $arr_niacin['lunch'][$j];
											$niacin+=$$arr_niacin['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($niacin > 0)
											$output .= $niacin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pantothenic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pantothenic_acid['lunch'][$j] != '' )
										{
											$output .= $arr_pantothenic_acid['lunch'][$j];
											$pantothenic_acid+=$arr_pantothenic_acid['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pantothenic_acid > 0)
											$output .= $pantothenic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pyridoxine_hcl = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pyridoxine_hcl['lunch'][$j] != '' )
										{
											$output .= $arr_pyridoxine_hcl['lunch'][$j];
											$pyridoxine_hcl+=$arr_pyridoxine_hcl['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pyridoxine_hcl > 0)
											$output .= $pyridoxine_hcl;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cyanocobalamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cyanocobalamin['lunch'][$j] != '' )
										{
											$output .= $arr_cyanocobalamin['lunch'][$j];
											$cyanocobalamin+=$arr_cyanocobalamin['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cyanocobalamin > 0)
											$output .= $cyanocobalamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$folic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_folic_acid['lunch'][$j] != '' )
										{
											$output .= $arr_folic_acid['lunch'][$j];
											$folic_acid+=$arr_folic_acid['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($folic_acid > 0)
											$output .= $folic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$biotin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_biotin['lunch'][$j] != '' )
										{
											$output .= $arr_biotin['lunch'][$j];
											$biotin+=$arr_biotin['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($biotin > 0)
											$output .= $biotin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$ascorbic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_ascorbic_acid['lunch'][$j] != '' )
										{
											$output .= $arr_ascorbic_acid['lunch'][$j];
											$ascorbic_acid+=$arr_ascorbic_acid['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($ascorbic_acid > 0)
											$output .= $ascorbic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calciferol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calciferol['lunch'][$j] != '' )
										{
											$output .= $arr_calciferol['lunch'][$j];
											$calciferol+=$arr_calciferol['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calciferol > 0)
											$output .= $calciferol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tocopherol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tocopherol['lunch'][$j] != '' )
										{
											$output .= $arr_tocopherol['lunch'][$j];
											$tocopherol+=$arr_tocopherol['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tocopherol > 0)
											$output .= $tocopherol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phylloquinone = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phylloquinone['lunch'][$j] != '' )
										{
											$output .= $arr_phylloquinone['lunch'][$j];
											$phylloquinone+=$arr_phylloquinone['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phylloquinone > 0)
											$output .= $phylloquinone;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$protein = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_protein['lunch'][$j] != '' )
										{
											$output .= $arr_protein['lunch'][$j];
											$protein+=$arr_protein['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($protein > 0)
											$output .= $protein;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$alanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_alanine['lunch'][$j] != '' )
										{
											$output .= $arr_alanine['lunch'][$j];
											$alanine+=$arr_alanine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alanine > 0)
											$output .= $alanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$arginine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_arginine['lunch'][$j] != '' )
										{
											$output .= $arr_arginine['lunch'][$j];
											$arginine+=$arr_arginine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($arginine > 0)
											$output .= $arginine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$aspartic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_aspartic_acid['lunch'][$j] != '' )
										{
											$output .= $arr_aspartic_acid['lunch'][$j];
											$aspartic_acid+=$arr_aspartic_acid['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($aspartic_acid > 0)
											$output .= $aspartic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cystine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cystine['lunch'][$j] != '' )
										{
											$output .= $arr_cystine['lunch'][$j];
											$cystine+=$arr_cystine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cystine > 0)
											$output .= $cystine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$giutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_giutamic_acid['lunch'][$j] != '' )
										{
											$output .= $arr_giutamic_acid['lunch'][$j];
											$giutamic_acid+=$arr_giutamic_acid['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($giutamic_acid > 0)
											$output .= $giutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycine['lunch'][$j] != '' )
										{
											$output .= $arr_glycine['lunch'][$j];
											$glycine+=$arr_glycine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycine > 0)
											$output .= $glycine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$histidine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_histidine['lunch'][$j] != '' )
										{
											$output .= $arr_histidine['lunch'][$j];
											$histidine+=$arr_histidine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($histidine > 0)
											$output .= $histidine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_glutamic_acid['lunch'][$j] != '' )
										{
											$output .= $arr_hydroxy_glutamic_acid['lunch'][$j];
											$glutamic_acid+=$arr_hydroxy_glutamic_acid['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glutamic_acid > 0)
											$output .= $glutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$hydroxy_proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_proline['lunch'][$j] != '' )
										{
											$output .= $arr_hydroxy_proline['lunch'][$j];
											$hydroxy_proline+=$arr_hydroxy_proline['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($hydroxy_proline > 0)
											$output .= $hydroxy_proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodogorgoic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodogorgoic_acid['lunch'][$j] != '' )
										{
											$output .= $arr_iodogorgoic_acid['lunch'][$j];
											$iodogorgoic_acid+=$arr_iodogorgoic_acid['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodogorgoic_acid > 0)
											$output .= $iodogorgoic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$isoleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_isoleucine['lunch'][$j] != '' )
										{
											$output .= $arr_isoleucine['lunch'][$j];
											$isoleucine+=$arr_isoleucine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($isoleucine > 0)
											$output .= $isoleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$leucine= 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_leucine['lunch'][$j] != '' )
										{
											$output .= $arr_leucine['lunch'][$j];
											$leucine+=$arr_leucine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($leucine > 0)
											$output .= $leucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lysine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_lysine['lunch'][$j] != '' )
										{
											$output .= $arr_lysine['lunch'][$j];
											$lysine+=$arr_lysine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lysine > 0)
											$output .= $lysine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$methionine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_methionine['lunch'][$j] != '' )
										{
											$output .= $arr_methionine['lunch'][$j];
											$methionine+=$arr_methionine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($methionine > 0)
											$output .= $methionine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$norleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_norleucine['lunch'][$j] != '' )
										{
											$output .= $arr_norleucine['lunch'][$j];
											$norleucine+=$arr_norleucine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($norleucine > 0)
											$output .= $norleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phenylalanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phenylalanine['lunch'][$j] != '' )
										{
											$output .= $arr_phenylalanine['lunch'][$j];
											$phenylalanine+=$arr_phenylalanine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phenylalanine > 0)
											$output .= $phenylalanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_proline['lunch'][$j] != '' )
										{
											$output .= $arr_proline['lunch'][$j];
											$proline+=$arr_proline['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($proline > 0)
											$output .= $proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$serine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_serine['lunch'][$j] != '' )
										{
											$output .= $arr_serine['lunch'][$j];
											$serine+=$arr_serine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($serine > 0)
											$output .= $serine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$threonine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_threonine['lunch'][$j] != '' )
										{
											$output .= $arr_threonine['lunch'][$j];
											$threonine+=$arr_threonine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($threonine > 0)
											$output .= $threonine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thyroxine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thyroxine['lunch'][$j] != '' )
										{
											$output .= $arr_thyroxine['lunch'][$j];
											$thyroxine+=$arr_thyroxine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thyroxine > 0)
											$output .= $thyroxine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tryptophane = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tryptophane['lunch'][$j] != '' )
										{
											$output .= $arr_tryptophane['lunch'][$j];
											$tryptophane+=$arr_tryptophane['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tryptophane > 0)
											$output .= $tryptophane;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tyrosine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tyrosine['lunch'][$j] != '' )
										{
											$output .= $arr_tyrosine['lunch'][$j];
											$tyrosine+=$arr_tyrosine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tyrosine > 0)
											$output .= $tyrosine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$valine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_valine['lunch'][$j] != '' )
										{
											$output .= $arr_valine['lunch'][$j];
											$valine+=$arr_valine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($valine > 0)
											$output .= $valine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_minerals = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_minerals['lunch'][$j] != '' )
										{
											$output .= $arr_total_minerals['lunch'][$j];
											$total_minerals+=$arr_total_minerals['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_minerals > 0)
											$output .= $total_minerals;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calcium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calcium['lunch'][$j] != '' )
										{
											$output .= $arr_calcium['lunch'][$j];
											$calcium+=$arr_calcium['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calcium > 0)
											$output .= $calcium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iron['lunch'][$j] != '' )
										{
											$output .= $arr_iron['lunch'][$j];
											$iron+=$arr_iron['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iron > 0)
											$output .= $iron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$potassium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_potassium['lunch'][$j] != '' )
										{
											$output .= $arr_potassium['lunch'][$j];
											$potassium+=$arr_potassium['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($potassium > 0)
											$output .= $potassium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sodium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sodium['lunch'][$j] != '' )
										{
											$output .= $arr_sodium['lunch'][$j];
											$sodium+=$arr_sodium['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sodium > 0)
											$output .= $sodium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phosphorus = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phosphorus['lunch'][$j] != '' )
										{
											$output .= $arr_phosphorus['lunch'][$j];
											$phosphorus+=$arr_phosphorus['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phosphorus > 0)
											$output .= $phosphorus;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sulphur = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sulphur['lunch'][$j] != '' )
										{
											$output .= $arr_sulphur['lunch'][$j];
											$sulphur+=$arr_sulphur['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sulphur > 0)
											$output .= $sulphur;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chlorine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chlorine['lunch'][$j] != '' )
										{
											$output .= $arr_chlorine['lunch'][$j];
											$chlorine+=$arr_chlorine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chlorine > 0)
											$output .= $chlorine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodine['lunch'][$j] != '' )
										{
											$output .= $arr_iodine['lunch'][$j];
											$iodine+=$arr_iodine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodine > 0)
											$output .= $iodine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$magnesium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_magnesium['lunch'][$j] != '' )
										{
											$output .= $arr_magnesium['lunch'][$j];
											$magnesium+=$arr_magnesium['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($magnesium > 0)
											$output .= $magnesium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$zinc = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_zinc['lunch'][$j] != '' )
										{
											$output .= $arr_zinc['lunch'][$j];
											$zinc+=$arr_zinc['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($zinc > 0)
											$output .= $zinc;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$copper = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_copper['lunch'][$j] != '' )
										{
											$output .= $arr_copper['lunch'][$j];
											$copper+=$arr_copper['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($copper > 0)
											$output .= $copper;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chromium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chromium['lunch'][$j] != '' )
										{
											$output .= $arr_chromium['lunch'][$j];
											$chromium+=$arr_chromium['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chromium > 0)
											$output .= $chromium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$manganese = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_manganese['lunch'][$j] != '' )
										{
											$output .= $arr_manganese['lunch'][$j];
											$manganese+=$arr_manganese['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($manganese > 0)
											$output .= $manganese;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$selenium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_selenium['lunch'][$j] != '' )
										{
											$output .= $arr_selenium['lunch'][$j];
											$selenium+=$arr_selenium['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($selenium > 0)
											$output .= $selenium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$boron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_boron['lunch'][$j] != '' )
										{
											$output .= $arr_boron['lunch'][$j];
											$boron+=$arr_boron['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($boron > 0)
											$output .= $boron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$molybdenum = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_molybdenum['lunch'][$j] != '' )
										{
											$output .= $arr_molybdenum['lunch'][$j];
											$molybdenum+=$arr_molybdenum['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($molybdenum > 0)
											$output .= $molybdenum;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$caffeine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_caffeine['lunch'][$j] != '' )
										{
											$output .= $arr_caffeine['lunch'][$j];
											$caffeine+=$arr_caffeine['lunch'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($caffeine > 0)
											$output .= $caffeine;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>';
		}
		
		if( is_array($arr_meal_time['snacks']) && count($arr_meal_time['snacks']) > 0)
		{			
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
						<tr>
							<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>snacks</strong></td>
							<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
						<tr>
							<td width="179" align="left" valign="top">
								<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
									></tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>

									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
									</tr>
								</table>
							</td>
							<td colspan="10" align="left" valign="top">
								<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_meal_time['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$i.'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_meal_time['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_time['snacks'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_meal_item['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_item['snacks'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_meal_measure['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_measure['snacks'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_meal_ml['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_ml['snacks'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_weight['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_weight['snacks'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									$water = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_water['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_water['snacks'][$j].'</td>';								
											$water+=$arr_water['snacks'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($water > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$water.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$calories = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_calories['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_calories['snacks'][$j].'</td>';								
											$calories+=$arr_calories['snacks'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($calories > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$calories.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
																		$fat = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										if($arr_fat['snacks'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_fat['snacks'][$j].'</td>';								
											$fat+=$arr_fat['snacks'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($fat > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$fat.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$saturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
		$output .= '								<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_saturated['snacks'][$j] != '' )
										{
											$output .=  $arr_saturated['snacks'][$j];
											$saturated+=$arr_saturated['snacks'][$j];
										}
										else
										{
											$output .=  '&nbsp;';
										}
		$output .= '								</td>';
									}
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($saturated > 0)
											$output .= $saturated;
										else
											$output .= '&nbsp;';
		$output .= '								
										</td>
									</tr>
									<tr>';
									
									$monounsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
		$output .= '						<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_monounsaturated['snacks'][$j] != '' )
										{
											$output .= $arr_monounsaturated['snacks'][$j];
											$monounsaturated+=$arr_monounsaturated['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
		$output .= '								</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($monounsaturated > 0)
											$output .= $monounsaturated;
										else
											$output .= '&nbsp;';
										
		$output .= '						</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										
										if($arr_polyunsaturated['snacks'][$j] != '' )
										{
											$output .= $arr_polyunsaturated['snacks'][$j];
											$polyunsaturated+=$arr_polyunsaturated['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_linoleic['snacks'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_linoleic['snacks'][$j];
											$polyunsaturated+=$arr_polyunsaturated_linoleic['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$alphalinoleic = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_alphalinoleic['snacks'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_alphalinoleic['snacks'][$j];
											$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alphalinoleic > 0)
											$output .= $alphalinoleic;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cholesterol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_cholesterol['snacks'][$j] != '' )
										{
											$output .= $arr_cholesterol['snacks'][$j];
											$cholesterol+=$arr_cholesterol['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cholesterol > 0)
											$output .= $cholesterol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dietary_fiber = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_dietary_fiber['snacks'][$j] != '' )
										{
											$output .= $arr_total_dietary_fiber['snacks'][$j];
											$dietary_fiber+=$arr_total_dietary_fiber['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dietary_fiber > 0)
											$output .= $dietary_fiber;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$carbohydrate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_carbohydrate['snacks'][$j] != '' )
										{
											$output .= $arr_carbohydrate['snacks'][$j];
											$carbohydrate+=$arr_carbohydrate['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($carbohydrate > 0)
											$output .= $carbohydrate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glucose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_glucose['snacks'][$j] != '' )
										{
											$output .= $arr_glucose['snacks'][$j];
											$glucose+=$arr_glucose['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glucose > 0)
											$output .= $glucose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$fructose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_fructose['snacks'][$j] != '' )
										{
											$output .= $arr_fructose['snacks'][$j];
											$fructose+=$arr_fructose['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($fructose > 0)
											$output .= $fructose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$galactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_galactose['snacks'][$j] != '' )
										{
											$output .= $arr_galactose['snacks'][$j];
											$galactose+=$arr_galactose['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($galactose > 0)
											$output .= $galactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$disaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_disaccharide['snacks'][$j] != '' )
										{
											$output .= $arr_disaccharide['snacks'][$j];
											$disaccharide+=$arr_disaccharide['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($disaccharide > 0)
											$output .= $disaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$maltose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_maltose['snacks'][$j] != '' )
										{
											$output .= $arr_maltose['snacks'][$j];
											$maltose+=$arr_maltose['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($maltose > 0)
											$output .= $maltose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_lactose['snacks'][$j] != '' )
										{
											$output .= $arr_lactose['snacks'][$j];
											$lactose+=$arr_lactose['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lactose > 0)
											$output .= $lactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sucrose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_sucrose['snacks'][$j] != '' )
										{
											$output .= $arr_sucrose['snacks'][$j];
											$sucrose+=$arr_sucrose['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sucrose > 0)
											$output .= $sucrose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$polysaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_polysaccharide['snacks'][$j] != '' )
										{
											$output .= $arr_total_polysaccharide['snacks'][$j];
											$polysaccharide+=$arr_total_polysaccharide['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polysaccharide > 0)
											$output .= $polysaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$starch = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_starch['snacks'][$j] != '' )
										{
											$output .= $arr_starch['snacks'][$j];
											$starch+=$arr_starch['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($starch > 0)
											$output .= $starch;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cellulose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cellulose['snacks'][$j] != '' )
										{
											$output .= $arr_cellulose['snacks'][$j];
											$cellulose+=$arr_cellulose['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cellulose > 0)
											$output .= $cellulose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycogen = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycogen['snacks'][$j] != '' )
										{
											$output .= $arr_glycogen['snacks'][$j];
											$glycogen+=$arr_glycogen['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycogen > 0)
											$output .= $glycogen;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dextrins = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_dextrins['snacks'][$j] != '' )
										{
											$output .= $arr_dextrins['snacks'][$j];
											$dextrins+=$arr_dextrins['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dextrins > 0)
											$output .= $dextrins;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sugar = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sugar['snacks'][$j] != '' )
										{
											$output .= $arr_sugar['snacks'][$j];
											$sugar+=$arr_sugar['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sugar > 0)
											$output .= $sugar;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin['snacks'][$j] != '' )
										{
											$output .= $arr_total_vitamin['snacks'][$j];
											$total_vitamin+=$arr_total_vitamin['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin > 0)
											$output .= $total_vitamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_acetate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_acetate['snacks'][$j] != '' )
										{
											$output .= $arr_vitamin_a_acetate['snacks'][$j];
											$vitamin_a_acetate+=$arr_vitamin_a_acetate['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_acetate > 0)
											$output .= $vitamin_a_acetate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_retinol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_retinol['snacks'][$j] != '' )
										{
											$output .= $arr_vitamin_a_retinol['snacks'][$j];
											$vitamin_a_retinol+=$arr_vitamin_a_retinol['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_retinol > 0)
											$output .= $vitamin_a_retinol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin_b_complex = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin_b_complex['snacks'][$j] != '' )
										{
											$output .= $arr_total_vitamin_b_complex['snacks'][$j];
											$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin_b_complex > 0)
											$output .= $total_vitamin_b_complex;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thiamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thiamin['snacks'][$j] != '' )
										{
											$output .= $arr_thiamin['snacks'][$j];
											$thiamin+=$arr_thiamin['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thiamin > 0)
											$output .= $thiamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$riboflavin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_riboflavin['snacks'][$j] != '' )
										{
											$output .= $arr_riboflavin['snacks'][$j];
											$riboflavin+=$arr_riboflavin['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($riboflavin > 0)
											$output .= $riboflavin;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
									<tr>';
									
									$niacin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="middle" bgcolor="#FFFFFF">';
										if($arr_niacin['snacks'][$j] != '' )
										{
											$output .= $arr_niacin['snacks'][$j];
											$niacin+=$$arr_niacin['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($niacin > 0)
											$output .= $niacin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pantothenic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pantothenic_acid['snacks'][$j] != '' )
										{
											$output .= $arr_pantothenic_acid['snacks'][$j];
											$pantothenic_acid+=$arr_pantothenic_acid['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pantothenic_acid > 0)
											$output .= $pantothenic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pyridoxine_hcl = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pyridoxine_hcl['snacks'][$j] != '' )
										{
											$output .= $arr_pyridoxine_hcl['snacks'][$j];
											$pyridoxine_hcl+=$arr_pyridoxine_hcl['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pyridoxine_hcl > 0)
											$output .= $pyridoxine_hcl;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cyanocobalamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cyanocobalamin['snacks'][$j] != '' )
										{
											$output .= $arr_cyanocobalamin['snacks'][$j];
											$cyanocobalamin+=$arr_cyanocobalamin['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cyanocobalamin > 0)
											$output .= $cyanocobalamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$folic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_folic_acid['snacks'][$j] != '' )
										{
											$output .= $arr_folic_acid['snacks'][$j];
											$folic_acid+=$arr_folic_acid['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($folic_acid > 0)
											$output .= $folic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$biotin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_biotin['snacks'][$j] != '' )
										{
											$output .= $arr_biotin['snacks'][$j];
											$biotin+=$arr_biotin['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($biotin > 0)
											$output .= $biotin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$ascorbic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_ascorbic_acid['snacks'][$j] != '' )
										{
											$output .= $arr_ascorbic_acid['snacks'][$j];
											$ascorbic_acid+=$arr_ascorbic_acid['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($ascorbic_acid > 0)
											$output .= $ascorbic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calciferol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calciferol['snacks'][$j] != '' )
										{
											$output .= $arr_calciferol['snacks'][$j];
											$calciferol+=$arr_calciferol['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calciferol > 0)
											$output .= $calciferol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tocopherol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tocopherol['snacks'][$j] != '' )
										{
											$output .= $arr_tocopherol['snacks'][$j];
											$tocopherol+=$arr_tocopherol['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tocopherol > 0)
											$output .= $tocopherol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phylloquinone = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phylloquinone['snacks'][$j] != '' )
										{
											$output .= $arr_phylloquinone['snacks'][$j];
											$phylloquinone+=$arr_phylloquinone['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phylloquinone > 0)
											$output .= $phylloquinone;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$protein = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_protein['snacks'][$j] != '' )
										{
											$output .= $arr_protein['snacks'][$j];
											$protein+=$arr_protein['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($protein > 0)
											$output .= $protein;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$alanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_alanine['snacks'][$j] != '' )
										{
											$output .= $arr_alanine['snacks'][$j];
											$alanine+=$arr_alanine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alanine > 0)
											$output .= $alanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$arginine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_arginine['snacks'][$j] != '' )
										{
											$output .= $arr_arginine['snacks'][$j];
											$arginine+=$arr_arginine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($arginine > 0)
											$output .= $arginine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$aspartic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_aspartic_acid['snacks'][$j] != '' )
										{
											$output .= $arr_aspartic_acid['snacks'][$j];
											$aspartic_acid+=$arr_aspartic_acid['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($aspartic_acid > 0)
											$output .= $aspartic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cystine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cystine['snacks'][$j] != '' )
										{
											$output .= $arr_cystine['snacks'][$j];
											$cystine+=$arr_cystine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cystine > 0)
											$output .= $cystine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$giutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_giutamic_acid['snacks'][$j] != '' )
										{
											$output .= $arr_giutamic_acid['snacks'][$j];
											$giutamic_acid+=$arr_giutamic_acid['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($giutamic_acid > 0)
											$output .= $giutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycine['snacks'][$j] != '' )
										{
											$output .= $arr_glycine['snacks'][$j];
											$glycine+=$arr_glycine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycine > 0)
											$output .= $glycine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$histidine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_histidine['snacks'][$j] != '' )
										{
											$output .= $arr_histidine['snacks'][$j];
											$histidine+=$arr_histidine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($histidine > 0)
											$output .= $histidine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_glutamic_acid['snacks'][$j] != '' )
										{
											$output .= $arr_hydroxy_glutamic_acid['snacks'][$j];
											$glutamic_acid+=$arr_hydroxy_glutamic_acid['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glutamic_acid > 0)
											$output .= $glutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$hydroxy_proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_proline['snacks'][$j] != '' )
										{
											$output .= $arr_hydroxy_proline['snacks'][$j];
											$hydroxy_proline+=$arr_hydroxy_proline['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($hydroxy_proline > 0)
											$output .= $hydroxy_proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodogorgoic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodogorgoic_acid['snacks'][$j] != '' )
										{
											$output .= $arr_iodogorgoic_acid['snacks'][$j];
											$iodogorgoic_acid+=$arr_iodogorgoic_acid['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodogorgoic_acid > 0)
											$output .= $iodogorgoic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$isoleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_isoleucine['snacks'][$j] != '' )
										{
											$output .= $arr_isoleucine['snacks'][$j];
											$isoleucine+=$arr_isoleucine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($isoleucine > 0)
											$output .= $isoleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$leucine= 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_leucine['snacks'][$j] != '' )
										{
											$output .= $arr_leucine['snacks'][$j];
											$leucine+=$arr_leucine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($leucine > 0)
											$output .= $leucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lysine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_lysine['snacks'][$j] != '' )
										{
											$output .= $arr_lysine['snacks'][$j];
											$lysine+=$arr_lysine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lysine > 0)
											$output .= $lysine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$methionine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_methionine['snacks'][$j] != '' )
										{
											$output .= $arr_methionine['snacks'][$j];
											$methionine+=$arr_methionine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($methionine > 0)
											$output .= $methionine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$norleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_norleucine['snacks'][$j] != '' )
										{
											$output .= $arr_norleucine['snacks'][$j];
											$norleucine+=$arr_norleucine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($norleucine > 0)
											$output .= $norleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phenylalanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phenylalanine['snacks'][$j] != '' )
										{
											$output .= $arr_phenylalanine['snacks'][$j];
											$phenylalanine+=$arr_phenylalanine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phenylalanine > 0)
											$output .= $phenylalanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_proline['snacks'][$j] != '' )
										{
											$output .= $arr_proline['snacks'][$j];
											$proline+=$arr_proline['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($proline > 0)
											$output .= $proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$serine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_serine['snacks'][$j] != '' )
										{
											$output .= $arr_serine['snacks'][$j];
											$serine+=$arr_serine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($serine > 0)
											$output .= $serine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$threonine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_threonine['snacks'][$j] != '' )
										{
											$output .= $arr_threonine['snacks'][$j];
											$threonine+=$arr_threonine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($threonine > 0)
											$output .= $threonine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thyroxine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thyroxine['snacks'][$j] != '' )
										{
											$output .= $arr_thyroxine['snacks'][$j];
											$thyroxine+=$arr_thyroxine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thyroxine > 0)
											$output .= $thyroxine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tryptophane = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tryptophane['snacks'][$j] != '' )
										{
											$output .= $arr_tryptophane['snacks'][$j];
											$tryptophane+=$arr_tryptophane['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tryptophane > 0)
											$output .= $tryptophane;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tyrosine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tyrosine['snacks'][$j] != '' )
										{
											$output .= $arr_tyrosine['snacks'][$j];
											$tyrosine+=$arr_tyrosine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tyrosine > 0)
											$output .= $tyrosine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$valine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_valine['snacks'][$j] != '' )
										{
											$output .= $arr_valine['snacks'][$j];
											$valine+=$arr_valine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($valine > 0)
											$output .= $valine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_minerals = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_minerals['snacks'][$j] != '' )
										{
											$output .= $arr_total_minerals['snacks'][$j];
											$total_minerals+=$arr_total_minerals['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_minerals > 0)
											$output .= $total_minerals;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calcium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calcium['snacks'][$j] != '' )
										{
											$output .= $arr_calcium['snacks'][$j];
											$calcium+=$arr_calcium['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calcium > 0)
											$output .= $calcium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iron['snacks'][$j] != '' )
										{
											$output .= $arr_iron['snacks'][$j];
											$iron+=$arr_iron['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iron > 0)
											$output .= $iron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$potassium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_potassium['snacks'][$j] != '' )
										{
											$output .= $arr_potassium['snacks'][$j];
											$potassium+=$arr_potassium['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($potassium > 0)
											$output .= $potassium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sodium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sodium['snacks'][$j] != '' )
										{
											$output .= $arr_sodium['snacks'][$j];
											$sodium+=$arr_sodium['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sodium > 0)
											$output .= $sodium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phosphorus = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phosphorus['snacks'][$j] != '' )
										{
											$output .= $arr_phosphorus['snacks'][$j];
											$phosphorus+=$arr_phosphorus['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phosphorus > 0)
											$output .= $phosphorus;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sulphur = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sulphur['snacks'][$j] != '' )
										{
											$output .= $arr_sulphur['snacks'][$j];
											$sulphur+=$arr_sulphur['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sulphur > 0)
											$output .= $sulphur;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chlorine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chlorine['snacks'][$j] != '' )
										{
											$output .= $arr_chlorine['snacks'][$j];
											$chlorine+=$arr_chlorine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chlorine > 0)
											$output .= $chlorine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodine['snacks'][$j] != '' )
										{
											$output .= $arr_iodine['snacks'][$j];
											$iodine+=$arr_iodine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodine > 0)
											$output .= $iodine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$magnesium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_magnesium['snacks'][$j] != '' )
										{
											$output .= $arr_magnesium['snacks'][$j];
											$magnesium+=$arr_magnesium['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($magnesium > 0)
											$output .= $magnesium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$zinc = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_zinc['snacks'][$j] != '' )
										{
											$output .= $arr_zinc['snacks'][$j];
											$zinc+=$arr_zinc['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($zinc > 0)
											$output .= $zinc;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$copper = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_copper['snacks'][$j] != '' )
										{
											$output .= $arr_copper['snacks'][$j];
											$copper+=$arr_copper['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($copper > 0)
											$output .= $copper;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chromium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chromium['snacks'][$j] != '' )
										{
											$output .= $arr_chromium['snacks'][$j];
											$chromium+=$arr_chromium['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chromium > 0)
											$output .= $chromium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$manganese = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_manganese['snacks'][$j] != '' )
										{
											$output .= $arr_manganese['snacks'][$j];
											$manganese+=$arr_manganese['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($manganese > 0)
											$output .= $manganese;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$selenium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_selenium['snacks'][$j] != '' )
										{
											$output .= $arr_selenium['snacks'][$j];
											$selenium+=$arr_selenium['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($selenium > 0)
											$output .= $selenium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$boron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_boron['snacks'][$j] != '' )
										{
											$output .= $arr_boron['snacks'][$j];
											$boron+=$arr_boron['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($boron > 0)
											$output .= $boron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$molybdenum = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_molybdenum['snacks'][$j] != '' )
										{
											$output .= $arr_molybdenum['snacks'][$j];
											$molybdenum+=$arr_molybdenum['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($molybdenum > 0)
											$output .= $molybdenum;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$caffeine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_caffeine['snacks'][$j] != '' )
										{
											$output .= $arr_caffeine['snacks'][$j];
											$caffeine+=$arr_caffeine['snacks'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($caffeine > 0)
											$output .= $caffeine;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>';
		}
		
		if( is_array($arr_meal_time['dinner']) && count($arr_meal_time['dinner']) > 0)
		{			
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
						<tr>
							<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>dinner</strong></td>
							<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
						<tr>
							<td width="179" align="left" valign="top">
								<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
									></tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>

									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
									</tr>
								</table>
								<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
									</tr>
								</table>
							</td>
							<td colspan="10" align="left" valign="top">
								<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_meal_time['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$i.'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_meal_time['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_time['dinner'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_meal_item['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_item['dinner'][$j].'</td>';
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_meal_measure['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_measure['dinner'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_meal_ml['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_meal_ml['dinner'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_weight['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_weight['dinner'][$j].'</td>';								
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}
									} 
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
									</tr>
									<tr>';
									$water = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_water['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_water['dinner'][$j].'</td>';								
											$water+=$arr_water['dinner'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($water > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$water.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$calories = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_calories['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_calories['dinner'][$j].'</td>';								
											$calories+=$arr_calories['dinner'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($calories > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$calories.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
																		$fat = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										if($arr_fat['dinner'][$j] != '' )
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">'.$arr_fat['dinner'][$j].'</td>';								
											$fat+=$arr_fat['dinner'][$j];
										}
										else
										{
		$output .= '					<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
										}																	
									} 
									if($fat > 0)
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;'.$fat.'</td>';
									}
									else
									{
		$output .= '					<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>';
									}
		$output .= '				</tr>
									<tr>';
									$saturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
		$output .= '								<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_saturated['dinner'][$j] != '' )
										{
											$output .=  $arr_saturated['dinner'][$j];
											$saturated+=$arr_saturated['dinner'][$j];
										}
										else
										{
											$output .=  '&nbsp;';
										}
		$output .= '								</td>';
									}
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($saturated > 0)
											$output .= $saturated;
										else
											$output .= '&nbsp;';
		$output .= '								
										</td>
									</tr>
									<tr>';
									
									$monounsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
		$output .= '						<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_monounsaturated['dinner'][$j] != '' )
										{
											$output .= $arr_monounsaturated['dinner'][$j];
											$monounsaturated+=$arr_monounsaturated['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
		$output .= '								</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($monounsaturated > 0)
											$output .= $monounsaturated;
										else
											$output .= '&nbsp;';
										
		$output .= '						</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										
										if($arr_polyunsaturated['dinner'][$j] != '' )
										{
											$output .= $arr_polyunsaturated['dinner'][$j];
											$polyunsaturated+=$arr_polyunsaturated['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$polyunsaturated = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
	$output .= '									<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_linoleic['dinner'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_linoleic['dinner'][$j];
											$polyunsaturated+=$arr_polyunsaturated_linoleic['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
	$output .= '									</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polyunsaturated > 0)
											$output .= $polyunsaturated;
										else
											$output .= '&nbsp;';
										
	$output .= '									</td>
									</tr>
									<tr>';
									
									$alphalinoleic = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_polyunsaturated_alphalinoleic['dinner'][$j] != '' )
										{
											$output .= $arr_polyunsaturated_alphalinoleic['dinner'][$j];
											$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alphalinoleic > 0)
											$output .= $alphalinoleic;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cholesterol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_cholesterol['dinner'][$j] != '' )
										{
											$output .= $arr_cholesterol['dinner'][$j];
											$cholesterol+=$arr_cholesterol['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cholesterol > 0)
											$output .= $cholesterol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dietary_fiber = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_dietary_fiber['dinner'][$j] != '' )
										{
											$output .= $arr_total_dietary_fiber['dinner'][$j];
											$dietary_fiber+=$arr_total_dietary_fiber['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dietary_fiber > 0)
											$output .= $dietary_fiber;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$carbohydrate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_carbohydrate['dinner'][$j] != '' )
										{
											$output .= $arr_carbohydrate['dinner'][$j];
											$carbohydrate+=$arr_carbohydrate['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($carbohydrate > 0)
											$output .= $carbohydrate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glucose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_glucose['dinner'][$j] != '' )
										{
											$output .= $arr_glucose['dinner'][$j];
											$glucose+=$arr_glucose['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glucose > 0)
											$output .= $glucose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$fructose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_fructose['dinner'][$j] != '' )
										{
											$output .= $arr_fructose['dinner'][$j];
											$fructose+=$arr_fructose['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($fructose > 0)
											$output .= $fructose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$galactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_galactose['dinner'][$j] != '' )
										{
											$output .= $arr_galactose['dinner'][$j];
											$galactose+=$arr_galactose['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($galactose > 0)
											$output .= $galactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$disaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_disaccharide['dinner'][$j] != '' )
										{
											$output .= $arr_disaccharide['dinner'][$j];
											$disaccharide+=$arr_disaccharide['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($disaccharide > 0)
											$output .= $disaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$maltose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_maltose['dinner'][$j] != '' )
										{
											$output .= $arr_maltose['dinner'][$j];
											$maltose+=$arr_maltose['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($maltose > 0)
											$output .= $maltose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lactose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_lactose['dinner'][$j] != '' )
										{
											$output .= $arr_lactose['dinner'][$j];
											$lactose+=$arr_lactose['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lactose > 0)
											$output .= $lactose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sucrose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_sucrose['dinner'][$j] != '' )
										{
											$output .= $arr_sucrose['dinner'][$j];
											$sucrose+=$arr_sucrose['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sucrose > 0)
											$output .= $sucrose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$polysaccharide = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_total_polysaccharide['dinner'][$j] != '' )
										{
											$output .= $arr_total_polysaccharide['dinner'][$j];
											$polysaccharide+=$arr_total_polysaccharide['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($polysaccharide > 0)
											$output .= $polysaccharide;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$starch = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										
										if($arr_starch['dinner'][$j] != '' )
										{
											$output .= $arr_starch['dinner'][$j];
											$starch+=$arr_starch['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($starch > 0)
											$output .= $starch;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cellulose = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cellulose['dinner'][$j] != '' )
										{
											$output .= $arr_cellulose['dinner'][$j];
											$cellulose+=$arr_cellulose['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cellulose > 0)
											$output .= $cellulose;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycogen = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycogen['dinner'][$j] != '' )
										{
											$output .= $arr_glycogen['dinner'][$j];
											$glycogen+=$arr_glycogen['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycogen > 0)
											$output .= $glycogen;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$dextrins = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_dextrins['dinner'][$j] != '' )
										{
											$output .= $arr_dextrins['dinner'][$j];
											$dextrins+=$arr_dextrins['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($dextrins > 0)
											$output .= $dextrins;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sugar = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sugar['dinner'][$j] != '' )
										{
											$output .= $arr_sugar['dinner'][$j];
											$sugar+=$arr_sugar['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sugar > 0)
											$output .= $sugar;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin['dinner'][$j] != '' )
										{
											$output .= $arr_total_vitamin['dinner'][$j];
											$total_vitamin+=$arr_total_vitamin['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin > 0)
											$output .= $total_vitamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_acetate = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_acetate['dinner'][$j] != '' )
										{
											$output .= $arr_vitamin_a_acetate['dinner'][$j];
											$vitamin_a_acetate+=$arr_vitamin_a_acetate['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_acetate > 0)
											$output .= $vitamin_a_acetate;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$vitamin_a_retinol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_vitamin_a_retinol['dinner'][$j] != '' )
										{
											$output .= $arr_vitamin_a_retinol['dinner'][$j];
											$vitamin_a_retinol+=$arr_vitamin_a_retinol['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($vitamin_a_retinol > 0)
											$output .= $vitamin_a_retinol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_vitamin_b_complex = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_vitamin_b_complex['dinner'][$j] != '' )
										{
											$output .= $arr_total_vitamin_b_complex['dinner'][$j];
											$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_vitamin_b_complex > 0)
											$output .= $total_vitamin_b_complex;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thiamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thiamin['dinner'][$j] != '' )
										{
											$output .= $arr_thiamin['dinner'][$j];
											$thiamin+=$arr_thiamin['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thiamin > 0)
											$output .= $thiamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$riboflavin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_riboflavin['dinner'][$j] != '' )
										{
											$output .= $arr_riboflavin['dinner'][$j];
											$riboflavin+=$arr_riboflavin['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($riboflavin > 0)
											$output .= $riboflavin;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
									<tr>';
									
									$niacin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="middle" bgcolor="#FFFFFF">';
										if($arr_niacin['dinner'][$j] != '' )
										{
											$output .= $arr_niacin['dinner'][$j];
											$niacin+=$$arr_niacin['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($niacin > 0)
											$output .= $niacin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pantothenic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pantothenic_acid['dinner'][$j] != '' )
										{
											$output .= $arr_pantothenic_acid['dinner'][$j];
											$pantothenic_acid+=$arr_pantothenic_acid['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pantothenic_acid > 0)
											$output .= $pantothenic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$pyridoxine_hcl = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_pyridoxine_hcl['dinner'][$j] != '' )
										{
											$output .= $arr_pyridoxine_hcl['dinner'][$j];
											$pyridoxine_hcl+=$arr_pyridoxine_hcl['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($pyridoxine_hcl > 0)
											$output .= $pyridoxine_hcl;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cyanocobalamin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cyanocobalamin['dinner'][$j] != '' )
										{
											$output .= $arr_cyanocobalamin['dinner'][$j];
											$cyanocobalamin+=$arr_cyanocobalamin['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cyanocobalamin > 0)
											$output .= $cyanocobalamin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$folic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_folic_acid['dinner'][$j] != '' )
										{
											$output .= $arr_folic_acid['dinner'][$j];
											$folic_acid+=$arr_folic_acid['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($folic_acid > 0)
											$output .= $folic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$biotin = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_biotin['dinner'][$j] != '' )
										{
											$output .= $arr_biotin['dinner'][$j];
											$biotin+=$arr_biotin['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($biotin > 0)
											$output .= $biotin;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$ascorbic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_ascorbic_acid['dinner'][$j] != '' )
										{
											$output .= $arr_ascorbic_acid['dinner'][$j];
											$ascorbic_acid+=$arr_ascorbic_acid['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($ascorbic_acid > 0)
											$output .= $ascorbic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calciferol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calciferol['dinner'][$j] != '' )
										{
											$output .= $arr_calciferol['dinner'][$j];
											$calciferol+=$arr_calciferol['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calciferol > 0)
											$output .= $calciferol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tocopherol = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tocopherol['dinner'][$j] != '' )
										{
											$output .= $arr_tocopherol['dinner'][$j];
											$tocopherol+=$arr_tocopherol['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tocopherol > 0)
											$output .= $tocopherol;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phylloquinone = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phylloquinone['dinner'][$j] != '' )
										{
											$output .= $arr_phylloquinone['dinner'][$j];
											$phylloquinone+=$arr_phylloquinone['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phylloquinone > 0)
											$output .= $phylloquinone;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$protein = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_protein['dinner'][$j] != '' )
										{
											$output .= $arr_protein['dinner'][$j];
											$protein+=$arr_protein['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($protein > 0)
											$output .= $protein;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$alanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_alanine['dinner'][$j] != '' )
										{
											$output .= $arr_alanine['dinner'][$j];
											$alanine+=$arr_alanine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($alanine > 0)
											$output .= $alanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$arginine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_arginine['dinner'][$j] != '' )
										{
											$output .= $arr_arginine['dinner'][$j];
											$arginine+=$arr_arginine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($arginine > 0)
											$output .= $arginine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$aspartic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_aspartic_acid['dinner'][$j] != '' )
										{
											$output .= $arr_aspartic_acid['dinner'][$j];
											$aspartic_acid+=$arr_aspartic_acid['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($aspartic_acid > 0)
											$output .= $aspartic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$cystine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_cystine['dinner'][$j] != '' )
										{
											$output .= $arr_cystine['dinner'][$j];
											$cystine+=$arr_cystine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($cystine > 0)
											$output .= $cystine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$giutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_giutamic_acid['dinner'][$j] != '' )
										{
											$output .= $arr_giutamic_acid['dinner'][$j];
											$giutamic_acid+=$arr_giutamic_acid['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($giutamic_acid > 0)
											$output .= $giutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glycine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_glycine['dinner'][$j] != '' )
										{
											$output .= $arr_glycine['dinner'][$j];
											$glycine+=$arr_glycine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glycine > 0)
											$output .= $glycine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$histidine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_histidine['dinner'][$j] != '' )
										{
											$output .= $arr_histidine['dinner'][$j];
											$histidine+=$arr_histidine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($histidine > 0)
											$output .= $histidine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$glutamic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_glutamic_acid['dinner'][$j] != '' )
										{
											$output .= $arr_hydroxy_glutamic_acid['dinner'][$j];
											$glutamic_acid+=$arr_hydroxy_glutamic_acid['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($glutamic_acid > 0)
											$output .= $glutamic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$hydroxy_proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_hydroxy_proline['dinner'][$j] != '' )
										{
											$output .= $arr_hydroxy_proline['dinner'][$j];
											$hydroxy_proline+=$arr_hydroxy_proline['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($hydroxy_proline > 0)
											$output .= $hydroxy_proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodogorgoic_acid = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodogorgoic_acid['dinner'][$j] != '' )
										{
											$output .= $arr_iodogorgoic_acid['dinner'][$j];
											$iodogorgoic_acid+=$arr_iodogorgoic_acid['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodogorgoic_acid > 0)
											$output .= $iodogorgoic_acid;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$isoleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_isoleucine['dinner'][$j] != '' )
										{
											$output .= $arr_isoleucine['dinner'][$j];
											$isoleucine+=$arr_isoleucine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($isoleucine > 0)
											$output .= $isoleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$leucine= 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_leucine['dinner'][$j] != '' )
										{
											$output .= $arr_leucine['dinner'][$j];
											$leucine+=$arr_leucine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($leucine > 0)
											$output .= $leucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$lysine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_lysine['dinner'][$j] != '' )
										{
											$output .= $arr_lysine['dinner'][$j];
											$lysine+=$arr_lysine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($lysine > 0)
											$output .= $lysine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$methionine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_methionine['dinner'][$j] != '' )
										{
											$output .= $arr_methionine['dinner'][$j];
											$methionine+=$arr_methionine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($methionine > 0)
											$output .= $methionine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$norleucine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_norleucine['dinner'][$j] != '' )
										{
											$output .= $arr_norleucine['dinner'][$j];
											$norleucine+=$arr_norleucine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($norleucine > 0)
											$output .= $norleucine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phenylalanine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phenylalanine['dinner'][$j] != '' )
										{
											$output .= $arr_phenylalanine['dinner'][$j];
											$phenylalanine+=$arr_phenylalanine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phenylalanine > 0)
											$output .= $phenylalanine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$proline = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_proline['dinner'][$j] != '' )
										{
											$output .= $arr_proline['dinner'][$j];
											$proline+=$arr_proline['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($proline > 0)
											$output .= $proline;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$serine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_serine['dinner'][$j] != '' )
										{
											$output .= $arr_serine['dinner'][$j];
											$serine+=$arr_serine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($serine > 0)
											$output .= $serine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$threonine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_threonine['dinner'][$j] != '' )
										{
											$output .= $arr_threonine['dinner'][$j];
											$threonine+=$arr_threonine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($threonine > 0)
											$output .= $threonine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$thyroxine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_thyroxine['dinner'][$j] != '' )
										{
											$output .= $arr_thyroxine['dinner'][$j];
											$thyroxine+=$arr_thyroxine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($thyroxine > 0)
											$output .= $thyroxine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tryptophane = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tryptophane['dinner'][$j] != '' )
										{
											$output .= $arr_tryptophane['dinner'][$j];
											$tryptophane+=$arr_tryptophane['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tryptophane > 0)
											$output .= $tryptophane;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$tyrosine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_tyrosine['dinner'][$j] != '' )
										{
											$output .= $arr_tyrosine['dinner'][$j];
											$tyrosine+=$arr_tyrosine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($tyrosine > 0)
											$output .= $tyrosine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$valine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_valine['dinner'][$j] != '' )
										{
											$output .= $arr_valine['dinner'][$j];
											$valine+=$arr_valine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($valine > 0)
											$output .= $valine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$total_minerals = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_total_minerals['dinner'][$j] != '' )
										{
											$output .= $arr_total_minerals['dinner'][$j];
											$total_minerals+=$arr_total_minerals['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($total_minerals > 0)
											$output .= $total_minerals;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$calcium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_calcium['dinner'][$j] != '' )
										{
											$output .= $arr_calcium['dinner'][$j];
											$calcium+=$arr_calcium['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($calcium > 0)
											$output .= $calcium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iron['dinner'][$j] != '' )
										{
											$output .= $arr_iron['dinner'][$j];
											$iron+=$arr_iron['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iron > 0)
											$output .= $iron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$potassium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_potassium['dinner'][$j] != '' )
										{
											$output .= $arr_potassium['dinner'][$j];
											$potassium+=$arr_potassium['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($potassium > 0)
											$output .= $potassium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sodium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sodium['dinner'][$j] != '' )
										{
											$output .= $arr_sodium['dinner'][$j];
											$sodium+=$arr_sodium['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sodium > 0)
											$output .= $sodium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$phosphorus = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_phosphorus['dinner'][$j] != '' )
										{
											$output .= $arr_phosphorus['dinner'][$j];
											$phosphorus+=$arr_phosphorus['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($phosphorus > 0)
											$output .= $phosphorus;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$sulphur = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_sulphur['dinner'][$j] != '' )
										{
											$output .= $arr_sulphur['dinner'][$j];
											$sulphur+=$arr_sulphur['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($sulphur > 0)
											$output .= $sulphur;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chlorine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chlorine['dinner'][$j] != '' )
										{
											$output .= $arr_chlorine['dinner'][$j];
											$chlorine+=$arr_chlorine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chlorine > 0)
											$output .= $chlorine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$iodine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_iodine['dinner'][$j] != '' )
										{
											$output .= $arr_iodine['dinner'][$j];
											$iodine+=$arr_iodine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($iodine > 0)
											$output .= $iodine;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$magnesium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_magnesium['dinner'][$j] != '' )
										{
											$output .= $arr_magnesium['dinner'][$j];
											$magnesium+=$arr_magnesium['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($magnesium > 0)
											$output .= $magnesium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$zinc = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_zinc['dinner'][$j] != '' )
										{
											$output .= $arr_zinc['dinner'][$j];
											$zinc+=$arr_zinc['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($zinc > 0)
											$output .= $zinc;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$copper = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_copper['dinner'][$j] != '' )
										{
											$output .= $arr_copper['dinner'][$j];
											$copper+=$arr_copper['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($copper > 0)
											$output .= $copper;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$chromium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_chromium['dinner'][$j] != '' )
										{
											$output .= $arr_chromium['dinner'][$j];
											$chromium+=$arr_chromium['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($chromium > 0)
											$output .= $chromium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$manganese = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_manganese['dinner'][$j] != '' )
										{
											$output .= $arr_manganese['dinner'][$j];
											$manganese+=$arr_manganese['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($manganese > 0)
											$output .= $manganese;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$selenium = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_selenium['dinner'][$j] != '' )
										{
											$output .= $arr_selenium['dinner'][$j];
											$selenium+=$arr_selenium['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($selenium > 0)
											$output .= $selenium;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$boron = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_boron['dinner'][$j] != '' )
										{
											$output .= $arr_boron['dinner'][$j];
											$boron+=$arr_boron['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($boron > 0)
											$output .= $boron;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$molybdenum = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_molybdenum['dinner'][$j] != '' )
										{
											$output .= $arr_molybdenum['dinner'][$j];
											$molybdenum+=$arr_molybdenum['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($molybdenum > 0)
											$output .= $molybdenum;
										else
											$output .= '&nbsp;';
										
										$output .= '</td>
									</tr>
									<tr>';
									
									$caffeine = 0;
									for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
									{ 
										$output .= '<td align="center" valign="top" bgcolor="#FFFFFF">';
										if($arr_caffeine['dinner'][$j] != '' )
										{
											$output .= $arr_caffeine['dinner'][$j];
											$caffeine+=$arr_caffeine['dinner'][$j];
										}
										else
										{
											$output .= '&nbsp;';
										}
										$output .= '</td>';
									
									} 
										$output .= '<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;';
										 
										if($caffeine > 0)
											$output .= $caffeine;
										else
											$output .= '&nbsp;';
										$output .= '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>';
		}
		
	}
			
	return $output;
}	
?>