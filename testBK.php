<?php
function get_clean_br_string($string)
{ 
	$output = '';
	//echo '<br><br>string = '.$string;
	$string = trim($string);
	if($string != '')
	{
		$pos = strpos($string, ' ');
		if($pos !== FALSE)
		{	
			$temp_arr = explode(' ',$string);
			echo'<br><br><pre>';
			print_r($temp_arr);
			echo'<br><br></pre>';
			foreach($temp_arr as $key => $val)
			{
				$temp_len = strlen($val);
				if($temp_len > 20)
				{
					//$str = substr($val, 0, 10) . ' ' . substr($val, 10);
					$str = substr($val, 0, 10) . ' ' ;
					$temp_str2 =  substr($val, 10);
					if( strlen($temp_str2)> 10)
					{
						//echo '<br>test : '.$temp_str2;
						$temp_str2 = get_clean_br_string($temp_str2);
					}
					$str .= $temp_str2;	
				}
				else
				{
					$str = $val;
				}
				echo '<br>Test str = '.$str;
				$output .= $str. ' ';
			}
		}
		else
		{
			$temp_len = strlen($string);
			if($temp_len > 15)
			{
				//$str = substr($val, 0, 10) . ' ' . substr($val, 10);
				$str = substr($string, 0, 15) . ' ' ;
				$temp_str2 =  substr($string, 15);
				if( strlen($temp_str2)> 15)
				{
					//echo '<br>test : '.$temp_str2;
					$temp_str2 = get_clean_br_string($temp_str2);
				}
				$str .= $temp_str2;	
			}
			else
			{
				$str = $string;
			}
			$output .= $str. ' ';
		}		
	}	
	
	return $output;
}
$sc_content = 'tt dhdhdhdhdhdhhdhdhdhdhhdhdhdhhdhdhdhdddddddddddddddddddddddd ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddeeeeeeeeeeeeeeeeeeee fffffffffffffffffffffffffffff';
$sc_content = 'tEST aa 1,erwerew ';
echo '<br><br>Org sc_content = '.$sc_content;
$sc_content = get_clean_br_string($sc_content);
echo '<br><br>Final sc_content = '.$sc_content;
/*
$start    = new DateTime('2010-12-02');
$start->modify('first day of this month');
$end      = new DateTime('2012-05-06');
$end->modify('first day of next month');
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start, $interval, $end);

foreach ($period as $dt)
{
    echo $dt->format("Y-m-d") . " - ".$dt->format("Y-m-t")."<br>\n";
}
*/
/*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>
<script type="text/javascript"><!--
   google_ad_client = "pub-2911253224693209";
   google_ad_width = 336;
   google_ad_height = 280;
   google_ad_format = "336x280_as";
   google_ad_type = "text";
   google_ad_channel ="2621593367";
   google_color_border = "FFFFFF";
   google_color_bg = "FFFFFF";
   google_color_link = "0000CC";
   google_color_url = "FFCC00";
   google_color_text = "000000";
   //--></script>
   <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
   </script> 
</body>
</html>
*/
?>
