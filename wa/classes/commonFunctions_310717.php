<?php
require_once 'config.php';
//require_once ('class.phpmailer.php');
class commonFunctions
{
    function __construct() 
    {
    }
	
	public function debuglog($stringData)
    {
        $logFile = SITE_PATH."/logs/debuglog_commonfunctions_".date("Y-m-d").".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
        fclose($fh);	
    }
	
	public function debuglogpayment($stringData)
    {
        $logFile = SITE_PATH."/logs/debuglog_payment_".date("Y-m-d").".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
        fclose($fh);	
    }
	
	public function debuglogsms($stringData)
    {
        $logFile = SITE_PATH."/logs/debuglog_sms_".date("Y-m-d").".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
        fclose($fh);	
    }
	
	public function sendSMS($tdata)
    {
        $return = false;
        
        $sendurl = SMS_URL."sendsms/sendsms.php?username=".SMS_USERNAME."&password=".SMS_PASSWORD."&type=TEXT&sender=".SMS_SENDERID."&mobile=".$tdata['mobile_no']."&message=".urlencode($tdata['sms_message']);
        $this->debuglogsms('[sendSMS] sendurl:'.$sendurl);
        try {
			
			$ch = curl_init($sendurl);
			curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
			curl_setopt($ch,CURLOPT_HEADER, 0);
			curl_setopt ($ch, CURLOPT_URL, $sendurl);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);  
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			if ( ! $response = curl_exec($ch) )
			{
				$stringData = '[sendSMS] Error:'.curl_error($ch).' , sendurl:'.$sendurl.', response:'.$response;
				$this->debuglogsms($stringData);
			}
			curl_close ($ch);
			
			
			//$response = file_get_contents($sendurl);		
			$this->debuglogsms('[sendSMS] sendurl:'.$sendurl.', response:'.$response);
			return true;
		} catch (Exception $e) {
			$stringData = '[sendSMS] Catch Error:'.$e->getMessage().' , sendurl:'.$sendurl.', response:'.$response;
			$this->debuglogsms($stringData);
            return $return;
        }
		
        return $return;
    }
	
	public function getOTPSmsText($tdata)
    {
        $return = $tdata['user_otp']." is your otp";
        return $return;
    }
	
	public function getOrderSmsText($tdata)
    {
		if($tdata['ebs_response_code'] == '0')
		{
			$return = "Your Order Successfully Completed. Your invoice no is ".$tdata['invoice'];
		}
		else
		{
			$return = "Your payment is failed. Your ref no is ".$tdata['invoice'];
		}			
        return $return;
    }
    
    public function getMonthOptions($month,$start_month='1',$end_month='12')
    {
        $arr_month = array (
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
        );

        $option_str = '';
        foreach($arr_month as $k => $v )
        {
            if( ($k >= $start_month) && ($k <= $end_month) )
            {
                if($k == $month)
                {
                    $selected = ' selected ';
                }
                else
                {
                    $selected = '';
                }
                $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';
            }	
        }	
        return $option_str;
    }
	
	public function getFrontPageDetails($page_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `page_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
			foreach($r as $key => $val)
			{
				$arr_record[$key] = stripslashes($val);	
			}
            //$arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getLinkOfPage($page_id)
    {
		$DBH = new DatabaseHandler();
        $page_link = '#';
        
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `page_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
			
			if($r['link_enable'] == '1' )
			{
				$page_link = SITE_URL.'/'.$r['page_link'];
			}
			else
			{
				$page_link = SITE_URL.'/pages.php?id='.$r['page_id'];
			}
            
        }	

        return $page_link;
    }
	
	public function getAllLocationsOption($area_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $area_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Locations</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Locations</option>';
			}
			
		}
		else
		{
			$output .= '<option value="" >Select Location</option>';
		}
		
		
		try {
			/*	
			$sql = "SELECT TAR.area_id,TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblarea` AS TAR
					LEFT JOIN `tblcities` AS TCT ON TAR.city_id = TCT.city_id 
					LEFT JOIN `tblstates` AS TST ON TAR.state_id = TST.state_id 
					LEFT JOIN `tblcountry` AS TCN ON TAR.country_id = TCN.country_id 
					WHERE TAR.area_deleted = '0' AND TAR.area_status = '1' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";	
			*/		
			
			$sql = "SELECT TAR.city_id AS area_id,TAR.city_name AS area_name,TST.state_name,TCN.country_name FROM `tblcities` AS TAR
					LEFT JOIN `tblstates` AS TST ON TAR.state_id = TST.state_id 
					LEFT JOIN `tblcountry` AS TCN ON TAR.country_id = TCN.country_id 
					WHERE TAR.city_deleted = '0' AND TAR.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TAR.city_name ASC, TST.state_name ASC, TCN.country_name ASC";			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(is_array($area_id) && in_array($r['area_id'], $area_id))
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					else
					{
						if($r['area_id'] == $area_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					//$output .= '<option value="'.$r['area_id'].'" '.$selected.'>'.stripslashes($r['area_name']).', '.stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']).'</option>';
					$output .= '<option value="'.$r['area_id'].'" '.$selected.'>'.stripslashes($r['area_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getAllLocationsOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function getTopAreaOption($city_id,$area_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $area_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Areas</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Areas</option>';
			}
			
		}
		else
		{
			$output .= '<option value="" >Select Area</option>';
		}
		
		if($city_id != '')
		{
			try {
				$sql = "SELECT TAR.area_id,TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblarea` AS TAR
						LEFT JOIN `tblcities` AS TCT ON TAR.city_id = TCT.city_id 
						LEFT JOIN `tblstates` AS TST ON TAR.state_id = TST.state_id 
						LEFT JOIN `tblcountry` AS TCN ON TAR.country_id = TCN.country_id 
						WHERE TAR.city_id = '".$city_id."' AND TAR.area_deleted = '0' AND TAR.area_status = '1' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";	
				
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($area_id) && in_array($r['area_id'], $area_id))
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						else
						{
							if($r['area_id'] == $area_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						$output .= '<option value="'.$r['area_id'].'" '.$selected.'>'.stripslashes($r['area_name']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getTopAreaOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}
		}	
		return $output;
	}
	
	public function chkIfValidCityId($city_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		try {
			$sql = "SELECT * FROM `tblcities` WHERE `city_id` = '".$city_id."' AND `city_status` = '1' AND `city_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;	
			}
		} catch (Exception $e) {
			$stringData = '[chkIfValidCityId] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }	
        return $return;
    }
	
	public function chkIfValidAreaId($area_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		try {
			$sql = "SELECT * FROM `tblarea` WHERE `area_id` = '".$area_id."' AND `area_status` = '1' AND `area_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;	
			}
		} catch (Exception $e) {
			$stringData = '[chkIfValidAreaId] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }	
        return $return;
    }
	
	public function getTopLocationStr($city_id,$area_id='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT TCT.city_name,TST.state_name,TCN.country_name FROM `tblcities` AS TCT
					LEFT JOIN `tblstates` AS TST ON TCT.state_id = TST.state_id 
					LEFT JOIN `tblcountry` AS TCN ON TCT.country_id = TCN.country_id 
					WHERE TCT.city_id = '".$city_id."' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";	
			}
			else
			{
				$sql = "SELECT TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblarea` AS TAR
					LEFT JOIN `tblcities` AS TCT ON TAR.city_id = TCT.city_id 
					LEFT JOIN `tblstates` AS TST ON TAR.state_id = TST.state_id 
					LEFT JOIN `tblcountry` AS TCN ON TAR.country_id = TCN.country_id 
					WHERE TAR.area_id = '".$area_id."' AND TAR.area_deleted = '0' AND TAR.area_status = '1' AND TCT.city_id = '".$city_id."' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";	
			}
						
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($area_id == '' || $area_id == '-1' || $area_id == '0')
					{
						//$output = stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);
						$output = stripslashes($r['city_name']);
					}
					else
					{
						//$output = stripslashes($r['area_name']).', '.stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);	
						$output = stripslashes($r['area_name']).', '.stripslashes($r['city_name']);	
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[getTopLocationStr] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function getCusineLocationStr($city_id,$area_id='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT TCT.city_name,TST.state_name,TCN.country_name FROM `tblcities` AS TCT
					LEFT JOIN `tblstates` AS TST ON TCT.state_id = TST.state_id 
					LEFT JOIN `tblcountry` AS TCN ON TCT.country_id = TCN.country_id 
					WHERE TCT.city_id = '".$city_id."' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";	
			}
			else
			{
				$sql = "SELECT TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblarea` AS TAR
					LEFT JOIN `tblcities` AS TCT ON TAR.city_id = TCT.city_id 
					LEFT JOIN `tblstates` AS TST ON TAR.state_id = TST.state_id 
					LEFT JOIN `tblcountry` AS TCN ON TAR.country_id = TCN.country_id 
					WHERE TAR.area_id = '".$area_id."' AND TAR.area_deleted = '0' AND TAR.area_status = '1' AND TCT.city_id = '".$city_id."' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";	
			}
						
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($area_id == '' || $area_id == '-1' || $area_id == '0')
					{
						//$output = stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);
						$output = 'All Areas, '.stripslashes($r['city_name']);
					}
					else
					{
						//$output = stripslashes($r['area_name']).', '.stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);	
						$output = stripslashes($r['area_name']).', '.stripslashes($r['city_name']);	
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[getCusineLocationStr] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function getStateIdOfCityId($city_id)
	{
		$DBH = new DatabaseHandler();
		$state_id = 0;
		
		try {
			
			$sql = "SELECT state_id FROM `tblcities` WHERE city_id = '".$city_id."' ";			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$state_id = $r['state_id'];
			}
		} catch (Exception $e) {
			$stringData = '[getStateIdOfCityId] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $state_id;
		}	
		return $state_id;
	}
	
	public function getCountryIdOfCityId($city_id)
	{
		$DBH = new DatabaseHandler();
		$country_id = 0;
		
		try {
			
			$sql = "SELECT country_id FROM `tblcities` WHERE city_id = '".$city_id."' ";			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$country_id = $r['country_id'];
			}
		} catch (Exception $e) {
			$stringData = '[getCountryIdOfCityId] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $country_id;
		}	
		return $country_id;
	}
	
	public function getWeekDayName($day_of_week)
	{
		$output = '';
		
		$arr_day = array( 	"1" => "Monday",
							"2" => "Tuesday",
							"3" => "Wednesday",
							"4" => "Thursday",
							"5" => "Friday",
							"6" => "Saturday",
							"7" => "Sunday"
						);
		if($day_of_week != '')
		{
			$output = $arr_day[$day_of_week];	
		}			
		
		return $output;
	}
	
	public function createDateRangeArray($strDateFrom,$strDateTo)
	{
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

		if ($iDateTo>=$iDateFrom)
		{
			array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
			while ($iDateFrom<$iDateTo)
			{
				$iDateFrom+=86400; // add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}
	
	public function date_sort($a, $b) {
		return strtotime($a) - strtotime($b);
	}
	
	public function getLatestDeliveryDatesOfLocation($city_id,$area_id='',$date_count='',$home_list_region_id='',$home_list_item_id='')
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		if($date_count == '')
		{
			$date_count = 5;
		}
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		$today_day_of_month = date('j');
		$today_day_of_week = date('N');
		$today_single_date = date('Y-m-d');
		
		$cnt = 0;
		try {
			
			if($home_list_region_id == '')
			{
				$sql_str_region = "";
			}
			else
			{
				$sql_str_region = " AND item_id IN (SELECT DISTINCT(item_id) FROM tblitemcategory WHERE ic_cat_id = '".$home_list_region_id."' AND ic_deleted = '0' ) ";
			}
			
			if($home_list_item_id == '')
			{
				$sql_str_item = "";
			}
			else
			{
				$sql_str_item = " AND item_id = '".$home_list_item_id."' ";
			}
			
			if($area_id == '' || $area_id == '-1')
			{
				$sql = "SELECT * FROM `tblcusines` 
					WHERE ( 
						( cusine_city_id = '".$city_id."' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 ) OR
						( cusine_city_id = '-1' AND cusine_state_id = '".$state_id."' ) OR 
						( cusine_city_id = '-1' AND FIND_IN_SET(".$state_id.", cusine_state_id) > 0 ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '".$country_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND FIND_IN_SET(".$country_id.", cusine_country_id) > 0  ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '-1' )  
					) AND cusine_deleted = '0' AND cusine_status = '1' AND cusine_type_id = '120' ".$sql_str_region." ".$sql_str_item;				
			}
			else
			{
				$sql = "SELECT * FROM `tblcusines` 
					WHERE ( 
						( cusine_city_id = '".$city_id."' AND cusine_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND cusine_area_id = '".$area_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '".$area_id."' ) OR 
						( cusine_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( cusine_city_id = '-1' AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( cusine_city_id = '".$city_id."' AND cusine_area_id = '-1' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND cusine_area_id = '-1'  ) OR
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '".$state_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND FIND_IN_SET(".$state_id.", cusine_state_id) > 0 ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '".$country_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND FIND_IN_SET(".$country_id.", cusine_country_id) > 0  ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '-1' )
						
					) AND cusine_deleted = '0' AND cusine_status = '1' AND cusine_type_id = '120' ".$sql_str_region." ".$sql_str_item;			
			}
			//$this->debuglog('[getLatestDeliveryDatesOfLocation] sql:'.$sql);
			//echo '<br><br>sql:'.$sql.'<br>';
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$temp_date = date('Y-m-d');
					$go_ahead = false;
					//echo '<br>'.$r['publish_date_type'];
					//echo '<br>'.$r['delivery_date_type'];
					if($r['publish_date_type'] == 'days_of_month')
					{
						if($r['publish_days_of_month'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_month'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_month = explode(',',$r['publish_days_of_month']);
							if(in_array($today_day_of_month,$temp_arr_publish_days_of_month))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'days_of_week')
					{
						if($r['publish_days_of_week'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_week'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_week = explode(',',$r['publish_days_of_week']);
							if(in_array($today_day_of_week,$temp_arr_publish_days_of_week))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'single_date')
					{
						if(strtotime($r['publish_single_date']) <= strtotime($today_single_date))
						{
							//echo '<br>'.$r['publish_single_date'].'<br>';
							$go_ahead = true;
						}
						
					}
					elseif($r['publish_date_type'] == 'date_range')
					{
						if( (strtotime($r['publish_start_date']) <= strtotime($today_single_date)) && (strtotime($r['publish_end_date']) >= strtotime($today_single_date)) )
						{
							$go_ahead = true;
						}
						
					}
					
					if($go_ahead)
					{
						if($r['delivery_date_type'] == 'days_of_month')
						{
							//echo'<br>value:'.$r['delivery_days_of_month'];
							if($r['delivery_days_of_month'] == '-1')
							{
								for($i=0;$i<$date_count;$i++)
								{
									//echo '<br>delivery_days_of_month[-1] = '.$temp_date.'<br>';
									array_push($output,$temp_date);
									$temp_date = date('Y-m-d', strtotime($temp_date . ' +1 day'));	
								}
							}
							elseif($r['delivery_days_of_month'] == '')
							{
								
							}
							else
							{
								$strpos_ddm = strpos($r['delivery_days_of_month'],',');
								if ($strpos_ddm === false) 
								{
									$temp_arr_delivery_days_of_month = array($r['delivery_days_of_month']);
								}
								else
								{
									$temp_arr_delivery_days_of_month = explode(',',$r['delivery_days_of_month']);	
								}
								
								//echo'<br><pre>';	
								//print_r($temp_arr_delivery_days_of_month);
								//echo'<br></pre>';	
								
								$temp_today_date2 = date('Y-m-d');
								$got_delivery_date = false;
								/*First part for day greater than current day of current month - start */
								for($i=0;$i<count($temp_arr_delivery_days_of_month);$i++)
								{
									if(strlen($temp_arr_delivery_days_of_month[$i]) == 1)
									{
										$temp_arr_delivery_days_of_month[$i] = '0'.$temp_arr_delivery_days_of_month[$i];
									}
									//echo '<br>';
									$temp_d_date = date('Y-m-'.$temp_arr_delivery_days_of_month[$i]);
									if($this->chkIfValidDate($temp_d_date))
									{
										if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
										{
											//echo '<br>delivery_days_of_month[,First] = '.$temp_date.'<br>';
											array_push($output,$temp_d_date);	
										}	
									}
								}
								/*First part for day greater than current day of current month - end */
								
								/*Second part for day less than current day of next month - start */
								$year_month_of_next_month = date('Y-m-', strtotime('first day of next month'));
								for($i=0;$i<count($temp_arr_delivery_days_of_month);$i++)
								{
									if(strlen($temp_arr_delivery_days_of_month[$i]) == 1)
									{
										$temp_arr_delivery_days_of_month[$i] = '0'.$temp_arr_delivery_days_of_month[$i];
									}
									
									$temp_d_date = date($year_month_of_next_month.$temp_arr_delivery_days_of_month[$i]);
									if($this->chkIfValidDate($temp_d_date))
									{
										if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
										{
											//echo '<br>delivery_days_of_month[,Second] = '.$temp_date.'<br>';
											array_push($output,$temp_d_date);												
										}	
									}
								}
								/*Second part for day less than current day of next month - end */
							}
						}
						elseif($r['delivery_date_type'] == 'days_of_week')
						{
							//echo'<br>222222222222222';
							if($r['delivery_days_of_week'] == '-1')
							{
								for($i=0;$i<$date_count;$i++)
								{
									array_push($output,$temp_date);
									date('Y-m-d', strtotime($temp_date . ' +1 day'));	
								}
							}
							elseif($r['delivery_days_of_week'] == '')
							{
								
							}
							else
							{
								$strpos_ddw = strpos($r['delivery_days_of_week'],',');
								if ($strpos_ddw === false) 
								{
									$temp_arr_delivery_days_of_week_old = array($r['delivery_days_of_week']);
								}
								else
								{
									$temp_arr_delivery_days_of_week_old = explode(',',$r['delivery_days_of_week']);	
								}
								
								$temp_today_day_of_week = date('N');
								
								//echo '<br>today_day_of_week:'.$temp_today_day_of_week;
								//echo '<br><pre>';
								//print_r($temp_arr_delivery_days_of_week_old);
								//echo '<br></pre>';
								
								$temp_arr_delivery_days_of_week = array();
								for($i=0;$i<count($temp_arr_delivery_days_of_week_old);$i++)
								{
									if($temp_today_day_of_week < $temp_arr_delivery_days_of_week_old[$i])
									{
										array_push($temp_arr_delivery_days_of_week,$temp_arr_delivery_days_of_week_old[$i]);
									}
								}
								
								if(count($temp_arr_delivery_days_of_week_old) != count($temp_arr_delivery_days_of_week))
								{
									for($i=0;$i<count($temp_arr_delivery_days_of_week_old);$i++)
									{
										if(!in_array($temp_arr_delivery_days_of_week_old[$i],$temp_arr_delivery_days_of_week))
										{
											array_push($temp_arr_delivery_days_of_week,$temp_arr_delivery_days_of_week_old[$i]);
										}
									}	
								}
								//echo '<br><pre>';
								//print_r($temp_arr_delivery_days_of_week);
								//echo '<br></pre>';
								
								$temp_today_date2 = date('Y-m-d');
								for($i=0;$i<count($temp_arr_delivery_days_of_week);$i++)
								{
									$obj_wd = new commonFunctions();
									$week_day_str = $obj_wd->getWeekDayName($temp_arr_delivery_days_of_week[$i]);
									
									$temp_d_date = date('Y-m-d',strtotime('next '.strtolower($week_day_str)));
									//echo'<br>temp_d_date[days_of_week]:'.$temp_d_date;
									if($this->chkIfValidDate($temp_d_date))
									{
										if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
										{
											array_push($output,$temp_d_date);	
										}	
									}
								}
								
							}
						}
						elseif($r['delivery_date_type'] == 'single_date')
						{
							if($r['delivery_single_date'] != '0000-00-00')
							{
								$temp_today_date2 = date('Y-m-d');
								$temp_d_date = $r['delivery_single_date'];
								//echo'<br>temp_d_date[single_date]:'.$temp_d_date;
								if($this->chkIfValidDate($temp_d_date))
								{
									if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
									{
										array_push($output,$temp_d_date);	
									}	
								}
							}
						}
						elseif($r['delivery_date_type'] == 'date_range')
						{
							if($r['delivery_start_date'] != '0000-00-00' && $r['delivery_start_date'] != '')
							{
								if($r['delivery_end_date'] != '0000-00-00' && $r['delivery_end_date'] != '')
								{
									$obj_wr = new commonFunctions();
									$arr_date_range = $obj_wr->createDateRangeArray($r['delivery_start_date'],$r['delivery_end_date']);
									
									$temp_today_date2 = date('Y-m-d');
									for($i=0;$i<count($arr_date_range);$i++)
									{
										$temp_d_date = $arr_date_range[$i];
										//echo'<br>temp_d_date[date_range]:'.$temp_d_date;
										if($this->chkIfValidDate($temp_d_date))
										{
											if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
											{
												array_push($output,$temp_d_date);	
											}	
										}
									}
								}
							}
						}	
					}
				}
			}
			
			//echo '<br><pre>';
			//print_r($output);
			//echo '<br></pre>';
			
			$output = array_unique($output);
			$output = array_values($output);
			usort($output,array($this,'date_sort'));
			
			//echo '<br><pre>';
			//print_r($output);
			//echo '<br></pre>';
			
			$output = array_slice($output, 0, $date_count); 
			
			//echo '<br><pre>';
			//print_r($output);
			//echo '<br></pre>';
			return $output;	
		} catch (Exception $e) {
			$stringData = '[getLatestDeliveryDatesOfLocation] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		
	}
	
	public function chkIfFeaturedCusine($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcusinecategory` WHERE `cusine_id` = '".$cusine_id."' AND `cucat_parent_cat_id` = '201' AND `cucat_cat_id` > 0 AND `cucat_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function getCusineFeaturedTypeId($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $return = 0;

        $sql = "SELECT * FROM `tblcusinecategory` WHERE `cusine_id` = '".$cusine_id."' AND `cucat_parent_cat_id` = '201' AND `cucat_cat_id` > 0 AND `cucat_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			$r = $STH->fetch(PDO::FETCH_ASSOC);
            $return = $r['cucat_cat_id'];
        }
        return $return;
    }
	
	public function getCusineFeaturedTypeName($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $return = '';

        $sql = "SELECT * FROM `tblcusinecategory` WHERE `cusine_id` = '".$cusine_id."' AND `cucat_parent_cat_id` = '201' AND `cucat_cat_id` > 0 AND `cucat_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			$r = $STH->fetch(PDO::FETCH_ASSOC);
            $return = $this->getCategoryName($r['cucat_cat_id']);
        }
        return $return;
    }
	
	public function chkIfValidDate($date)
	{
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') === $date;
	}
	
	public function getHomePageAllPublishedItems($city_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		$today_day_of_month = date('j');
		$today_day_of_week = date('N');
		$today_single_date = date('Y-m-d');
		
		$cnt = 0;
		try {
			
			$sql_delivery_date_str = " AND ( 
								( publish_date_type = 'days_of_month' AND ( publish_days_of_month = '-1' OR publish_days_of_month = '".$today_day_of_month."' OR  FIND_IN_SET(".$today_day_of_month.", publish_days_of_month) > 0 ) ) OR
								( publish_date_type = 'days_of_week' AND ( publish_days_of_week = '-1' OR publish_days_of_week = '".$today_day_of_week."' OR  FIND_IN_SET(".$today_day_of_week.", publish_days_of_week) > 0 ) ) OR
								( publish_date_type = 'single_date' AND ( publish_single_date <= '".$today_single_date."' ) ) OR
								( publish_date_type = 'date_range' AND ( publish_start_date <= '".$today_single_date."' AND publish_end_date >= '".$today_single_date."' ) ) 
								) ";
			
			$sql = "SELECT * FROM `tblcusines` 
				WHERE ( 
					( cusine_city_id = '".$city_id."' ) OR 
					( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 ) OR
					( cusine_city_id = '-1' AND cusine_state_id = '".$state_id."' ) OR 
					( cusine_city_id = '-1' AND FIND_IN_SET(".$state_id.", cusine_state_id) > 0 ) OR 
					( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '".$country_id."' ) OR 
					( cusine_city_id = '-1' AND cusine_state_id = '-1' AND FIND_IN_SET(".$country_id.", cusine_country_id) > 0  ) OR 
					( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '-1' )  
				) AND cusine_deleted = '0' AND cusine_status = '1' AND cusine_type_id = '120' ".$sql_delivery_date_str;				
		
			
			//$this->debuglog('[getHomePageAllPublishedItems] sql:'.$sql);
			//echo '<br><br>sql:'.$sql.'<br>';
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$temp_date = date('Y-m-d');
					$go_ahead = false;
					//echo '<br>'.$r['publish_date_type'];
					//echo '<br>'.$r['delivery_date_type'];
					if($r['publish_date_type'] == 'days_of_month')
					{
						if($r['publish_days_of_month'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_month'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_month = explode(',',$r['publish_days_of_month']);
							if(in_array($today_day_of_month,$temp_arr_publish_days_of_month))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'days_of_week')
					{
						if($r['publish_days_of_week'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_week'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_week = explode(',',$r['publish_days_of_week']);
							if(in_array($today_day_of_week,$temp_arr_publish_days_of_week))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'single_date')
					{
						if(strtotime($r['publish_single_date']) <= strtotime($today_single_date))
						{
							//echo '<br>'.$r['publish_single_date'].'<br>';
							$go_ahead = true;
						}
						
					}
					elseif($r['publish_date_type'] == 'date_range')
					{
						if( (strtotime($r['publish_start_date']) <= strtotime($today_single_date)) && (strtotime($r['publish_end_date']) >= strtotime($today_single_date)) )
						{
							$go_ahead = true;
						}
						
					}
					
					if($go_ahead)
					{
						$go_ahead = false;
						$r['actual_delivery_date'] = '';
						if($r['delivery_date_type'] == 'days_of_month')
						{
							//echo'<br>value:'.$r['delivery_days_of_month'];
							if($r['delivery_days_of_month'] == '-1')
							{
								$go_ahead = true;
								$date = date( 'Y-m-d');
								$r['actual_delivery_date'] = date( 'Y-m-d', strtotime( $date . ' +5 days' ) );
							}
							elseif($r['delivery_days_of_month'] == '')
							{
								
							}
							else
							{
								$go_ahead = true;
								$strpos_ddm = strpos($r['delivery_days_of_month'],',');
								if ($strpos_ddm === false) 
								{
									$temp_arr_delivery_days_of_month = array($r['delivery_days_of_month']);
								}
								else
								{
									$temp_arr_delivery_days_of_month = explode(',',$r['delivery_days_of_month']);	
								}
								
								//echo'<br><pre>';	
								//print_r($temp_arr_delivery_days_of_month);
								//echo'<br></pre>';	
								
								$temp_today_date2 = date('Y-m-d');
								$got_delivery_date = false;
								for($i=0;$i<count($temp_arr_delivery_days_of_month);$i++)
								{
									if(strlen($temp_arr_delivery_days_of_month[$i]) == 1)
									{
										$temp_arr_delivery_days_of_month[$i] = '0'.$temp_arr_delivery_days_of_month[$i];
									}
									//echo '<br>';
									$temp_d_date = date('Y-m-'.$temp_arr_delivery_days_of_month[$i]);
									if($this->chkIfValidDate($temp_d_date))
									{
										if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
										{
											//echo '<br>temp_d_date:'.$temp_d_date.', strtotime(temp_d_date):'.strtotime($temp_d_date);
											if($r['order_cutoff_time'] != '' )
											{
												//$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
												$date = date('Y-m-d', strtotime( $temp_d_date ) );
												$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
												//$current_showing_date_time = $current_showing_date. ' 23:00:00';
												$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
												$timestamp_csdt = strtotime($current_showing_date_time);
												
												$sec_cuttoff_time = $r['order_cutoff_time'] * 3600;
												
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
												$r['actual_delivery_date'] = $temp_d_date;
												$got_delivery_date = true;
												break;											
											}											
										}	
									}
								}
								
								if(!$got_delivery_date)
								{
									$temp_today_date2 = date('Y-m-d');
									$year_month_of_next_month = date('Y-m-', strtotime('first day of next month'));
									$got_delivery_date = false;
									for($i=0;$i<count($temp_arr_delivery_days_of_month);$i++)
									{
										if(strlen($temp_arr_delivery_days_of_month[$i]) == 1)
										{
											$temp_arr_delivery_days_of_month[$i] = '0'.$temp_arr_delivery_days_of_month[$i];
										}
										//echo '<br>';
										$temp_d_date = date($year_month_of_next_month.$temp_arr_delivery_days_of_month[$i]);
										if($this->chkIfValidDate($temp_d_date))
										{
											if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
											{
												//echo '<br>temp_d_date:'.$temp_d_date.', strtotime(temp_d_date):'.strtotime($temp_d_date);
												if($r['order_cutoff_time'] != '' )
												{
													//$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
													$date = date('Y-m-d', strtotime( $temp_d_date ) );
													$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
													//$current_showing_date_time = $current_showing_date. ' 23:00:00';
													$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
													$timestamp_csdt = strtotime($current_showing_date_time);
													
													$sec_cuttoff_time = $r['order_cutoff_time'] * 3600;
													
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
													$r['actual_delivery_date'] = $temp_d_date;
													$got_delivery_date = true;
													break;											
												}											
											}	
										}
									}
								}
							}
						}
						elseif($r['delivery_date_type'] == 'days_of_week')
						{
							if($r['delivery_days_of_week'] == '-1')
							{
								$go_ahead = true;
								$date = date( 'Y-m-d');
								$r['actual_delivery_date'] = date( 'Y-m-d', strtotime( $date . ' +5 days' ) );
							}
							elseif($r['delivery_days_of_week'] == '')
							{
								
							}
							else
							{
								$go_ahead = true;
								$strpos_ddw = strpos($r['delivery_days_of_week'],',');
								if ($strpos_ddw === false) 
								{
									$temp_arr_delivery_days_of_week_old = array($r['delivery_days_of_week']);
								}
								else
								{
									$temp_arr_delivery_days_of_week_old = explode(',',$r['delivery_days_of_week']);	
								}
								
								$temp_today_day_of_week = date('N');
								
								//echo '<br>today_day_of_week:'.$temp_today_day_of_week;
								//echo '<br><pre>';
								//print_r($temp_arr_delivery_days_of_week_old);
								//echo '<br></pre>';
								
								$temp_arr_delivery_days_of_week = array();
								for($i=0;$i<count($temp_arr_delivery_days_of_week_old);$i++)
								{
									if($temp_today_day_of_week < $temp_arr_delivery_days_of_week_old[$i])
									{
										array_push($temp_arr_delivery_days_of_week,$temp_arr_delivery_days_of_week_old[$i]);
									}
								}
								
								if(count($temp_arr_delivery_days_of_week_old) != count($temp_arr_delivery_days_of_week))
								{
									for($i=0;$i<count($temp_arr_delivery_days_of_week_old);$i++)
									{
										if(!in_array($temp_arr_delivery_days_of_week_old[$i],$temp_arr_delivery_days_of_week))
										{
											array_push($temp_arr_delivery_days_of_week,$temp_arr_delivery_days_of_week_old[$i]);
										}
									}	
								}
								//echo '<br><pre>';
								//print_r($temp_arr_delivery_days_of_week);
								//echo '<br></pre>';
								
								$temp_today_date2 = date('Y-m-d');
								for($i=0;$i<count($temp_arr_delivery_days_of_week);$i++)
								{
									$obj_wd = new commonFunctions();
									//echo'<br>';
									$week_day_str = $obj_wd->getWeekDayName($temp_arr_delivery_days_of_week[$i]);
									//echo'<br>';
									$temp_d_date = date('Y-m-d',strtotime('next '.strtolower($week_day_str)));
									//echo'<br>temp_d_date:'.$temp_d_date;
									if($this->chkIfValidDate($temp_d_date))
									{
										if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
										{
											if($r['order_cutoff_time'] != '' )
											{
												//$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
												$date = date('Y-m-d', strtotime( $temp_d_date ) );
												$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
												//$current_showing_date_time = $current_showing_date. ' 23:00:00';
												$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
												$timestamp_csdt = strtotime($current_showing_date_time);
												
												$sec_cuttoff_time = $r['order_cutoff_time'] * 3600;
												
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
												$r['actual_delivery_date'] = $temp_d_date;
												break;		
											}
										}	
									}
								}
							}
						}
						elseif($r['delivery_date_type'] == 'single_date')
						{
							if($r['delivery_single_date'] != '0000-00-00')
							{
								//echo '<br>';
								$temp_d_date = $r['delivery_single_date'];
								//echo '<br>';
								$temp_today_date2 = date('Y-m-d');
								if(strtotime($temp_d_date) >= strtotime($temp_today_date2))
								{
									if($r['order_cutoff_time'] != '' )
									{
										//$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
										$date = date('Y-m-d', strtotime( $temp_d_date ) );
										$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
										//$current_showing_date_time = $current_showing_date. ' 23:00:00';
										$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
										$timestamp_csdt = strtotime($current_showing_date_time);
										
										$sec_cuttoff_time = $r['order_cutoff_time'] * 3600;
										
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
										$go_ahead = true;
										$r['actual_delivery_date'] = $temp_d_date;
									}	
								}
							}
						}
						elseif($r['delivery_date_type'] == 'date_range')
						{
							if($r['delivery_start_date'] != '0000-00-00')
							{
								if($r['delivery_end_date'] != '0000-00-00')
								{
									$obj_wr = new commonFunctions();
									$arr_date_range = $obj_wr->createDateRangeArray($r['delivery_start_date'],$r['delivery_end_date']);
									
									$temp_today_date2 = date('Y-m-d');
									for($i=0;$i<count($arr_date_range);$i++)
									{
										$temp_d_date = $arr_date_range[$i];
										if(strtotime($temp_d_date) >= strtotime($temp_today_date2) )
										{
											$go_ahead = true;

											if($r['order_cutoff_time'] != '' )
											{
												//$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
												$date = date('Y-m-d', strtotime( $temp_d_date ) );
												$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
												//$current_showing_date_time = $current_showing_date. ' 23:00:00';
												$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
												$timestamp_csdt = strtotime($current_showing_date_time);
												
												$sec_cuttoff_time = $r['order_cutoff_time'] * 3600;
												
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
												$r['actual_delivery_date'] = $temp_d_date;
												break;
											}	
										}
									}
								}
							}
						}	
					}
					
					if($go_ahead)
					{
						$obj_r = new commonFunctions();
						$r['region_category'] = $obj_r->getRegionCategoryNameOfItem($r['item_id']);
						$r['region_category_id'] = $obj_r->getRegionCategoryIdOfItem($r['item_id']);
						$r['cusine_name'] = $obj_r->getItemName($r['item_id']);
						$r['cusine_default'] = $obj_r->getCusineDefaultPriceAndStock($r['cusine_id']);
						$r['vendor_name'] = $obj_r->getVendorName($r['vendor_id']);
						$r['cusine_weight'] = $obj_r->getCusineAllWeight($r['cusine_id']);
						
						if($obj_r->chkIfFeaturedCusine($r['cusine_id']))
						{
							$r['is_featured_cusine'] = 1;
							$r['featured_type_id'] = $obj_r->getCusineFeaturedTypeId($r['cusine_id']);
							$r['featured_type_name'] = $obj_r->getCusineFeaturedTypeName($r['cusine_id']);
						}
						else
						{
							$r['is_featured_cusine'] = 0;
							$r['featured_type_id'] = 0;
							$r['featured_type_name'] = '';
						}
												
						/* Check if Booking Closed - Start */		
						/*
						if($r['region_category_id'] == '164')
						{
							$date_cc = date( 'Y-m-d');
							$cusine_delivery_date = date( 'Y-m-d', strtotime( $date_cc . ' +5 days' ) );
						}
						else
						{
							$cusine_delivery_date = date('Y-m-d', strtotime( $current_showing_date ) );	
						}*/
						
						if($r['actual_delivery_date'] != '')
						{
							$cusine_delivery_date = $r['actual_delivery_date'];	
						}
						else
						{
							$cusine_delivery_date = date('Y-m-d');
						}
						
						if($r['order_cutoff_time'] != '' )
						{
							$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
							$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
							//$current_showing_date_time = $current_showing_date. ' 23:00:00';
							$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
							$timestamp_csdt = strtotime($current_showing_date_time);
							
							$sec_cuttoff_time = $r['order_cutoff_time'] * 3600;
							
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
						/* Check if Booking Closed - End */
						if($flag_add_to_cart)
						{
							//foreach($r as $key1 => $val1)
							//{
								//$r[$key1] = stripslashes($val1);
							//}	
							//$output[] = $r;
						}	
						
						$output[] = $r;
					}
				}
			}
			
			//echo '<br><pre>';
			//print_r($output);
			//echo '<br></pre>';
			
			//echo '<br><pre>';
			//print_r($output);
			//echo '<br></pre>';
			return $output;	
		} catch (Exception $e) {
			$stringData = '[getHomePageAllPublishedItems] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		
	}
	
	public function getRegionCategoryNameOfItem($item_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			//echo'<br>';
			$sql = "SELECT TBC.cat_name FROM `tblitemcategory` AS TIC
					LEFT JOIN `tblcategories` AS TBC ON TIC.ic_cat_id = TBC.cat_id 
					WHERE TIC.item_id = '".$item_id."' AND TIC.ic_cat_parent_id = '1' AND TIC.ic_deleted = '0' AND TIC.ic_status = '1' ";			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$output = $r['cat_name'];
				}
			}	
			return $output;
		} catch (Exception $e) {
			$stringData = '[getRegionCategoryNameOfItem] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getRegionCategoryIdOfItem($item_id)
	{
		$DBH = new DatabaseHandler();
		$output = 0;
		
		try {
			//echo'<br>';
			$sql = "SELECT ic_cat_id FROM `tblitemcategory` AS TIC
					WHERE TIC.item_id = '".$item_id."' AND TIC.ic_cat_parent_id = '1' AND TIC.ic_deleted = '0' AND TIC.ic_status = '1' ";			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$output = $r['ic_cat_id'];
				}
			}	
			return $output;
		} catch (Exception $e) {
			$stringData = '[getRegionCategoryIdOfItem] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getItemName($item_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			$sql = "SELECT `item_name` FROM `tblitems` WHERE `item_id`= '".$item_id."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$output = $r['item_name'];
			}	
			return $output;
		} catch (Exception $e) {
			$stringData = '[getItemName] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineDefaultPriceAndStock($cusine_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		try {
			$sql = "SELECT TCL.max_order,TCL.min_order,TCL.cusine_qty,TCL.currency_id,TCL.cusine_price,TCL.ordering_size_show,TCL.cusine_qty_show,
					TCL.sold_qty_show,TCL.is_offer,TCL.offer_price,TCL.offer_date_type,TCL.offer_days_of_month,TCL.offer_days_of_week,TCL.offer_single_date,
					TCL.offer_start_date,TCL.offer_end_date,TBC.cat_id,TBC.cat_name 
					FROM `tblcusinelocations` AS TCL 
					LEFT JOIN `tblcategories` AS TBC ON TCL.ordering_size_id = TBC.cat_id
					WHERE TCL.cusine_id= '".$cusine_id."' AND TCL.default_price = '1' AND TCL.culoc_status = '1' AND TCL.culoc_deleted = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$r['sold_count'] = 0;
					$output = $r;	
				}
				
			}	
			return $output;
		} catch (Exception $e) {
			$stringData = '[getCusineDefaultPriceAndStock] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineCurrentStockQty($cusine_id)
	{
		$DBH = new DatabaseHandler();
		$output = 0;
		
		try {
			$sql = "SELECT TCL.cusine_qty FROM `tblcusinelocations` AS TCL 
					WHERE TCL.cusine_id= '".$cusine_id."' AND TCL.default_price = '1' AND TCL.culoc_status = '1' AND TCL.culoc_deleted = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$output = $r['cusine_qty'];	
				}
				
			}	
			return $output;
		} catch (Exception $e) {
			$stringData = '[getCusineCurrentStockQty] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getItemVegNonvegStr($item_id)
	{
		$DBH = new DatabaseHandler();
		//$output = '<img src="images/icon7.png" alt="" class="img-responsive"><span>Veg.</span>';
		$output = '';
		
		try {
			$sql = "SELECT * FROM `tblitemcategory` WHERE item_id= '".$item_id."' AND ic_cat_parent_id = '10' AND ic_show = '1' AND ic_status = '1' AND ic_deleted = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['ic_cat_id'] == '37')
					{
						$output = '<span>Veg.</span><img src="images/icon7.png" alt="" class="img-responsive">';
					}
					elseif($r['ic_cat_id'] == '39')
					{
						$output = '<span>Non-Veg.</span><img src="images/icon8.png" alt="" class="img-responsive">';
					}
				}
				
			}	
			return $output;
		} catch (Exception $e) {
			$stringData = '[getItemVegNonvegStr] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function chkIfShowIngredientsOfItem($item_id)
	{
		$DBH = new DatabaseHandler();
		$output = false;
		
		try {
			$sql = "SELECT ingredient_show FROM `tblitems` WHERE `item_id` = '".$item_id."' AND `item_deleted` = '0' ";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				if($r['ingredient_show'] == 1)
				{
					$output = true;
				}
			}
		} catch (Exception $e) {
			$stringData = '[chkIfShowIngredientsOfItem] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function getCommaSeperatedIngredientsOfItem($item_id,$count='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
	
		$cnt = 0;
		if($this->chkIfShowIngredientsOfItem($item_id))
		{
			try {
				$sql = "SELECT ingredient_id FROM `tblitemingredients` WHERE `item_id` = '".$item_id."' AND `iig_deleted` = '0' ORDER BY iig_add_date ASC, iig_id ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($count != '' && $cnt >= $count)
						{
							break;
						}
						$output .= stripslashes($this->getItemName($r['ingredient_id'])).', ';
						
						$cnt++;
					}
					$output = substr($output,0,-2);
				}
			} catch (Exception $e) {
				$stringData = '[getCommaSeperatedIngredientsOfItem] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}	
		}
					
		return $output;
	}
	
	public function getCusineCategoriesString($cusine_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			$sql = "SELECT TBC.cat_name FROM `tblcusinecategory` AS TCC 
					LEFT JOIN `tblcategories` AS TBC ON TCC.cucat_cat_id = TBC.cat_id 
 					WHERE TCC.cusine_id = '".$cusine_id."' AND TCC.cucat_parent_cat_id != '10' AND TCC.cucat_show = '1'  AND TCC.cucat_status = '1' AND TCC.cucat_deleted = '0' ORDER BY TCC.cucat_add_date ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$output .= stripslashes($r['cat_name']).' - ';
				}
				$output = substr($output,0,-3);
			}
		} catch (Exception $e) {
			$stringData = '[getCusineCategoriesString] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function getAllPublishedCusines($city_id,$area_id='',$current_showing_date='',$home_list_region_id='',$item_id='')
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		if($current_showing_date == '')
		{
			$current_showing_date = date('Y-m-d');
		}
		
		$today_day_of_month = date('j',strtotime($current_showing_date));
		$today_day_of_week = date('N',strtotime($current_showing_date));
		$today_single_date = date('Y-m-d',strtotime($current_showing_date));
		
		$cnt = 0;
		try {
			
			if($home_list_region_id == '')
			{
				$sql_str_region = "";
			}
			else
			{
				if($home_list_region_id == '164')
				{
					$sql_str_region = " AND item_id IN (SELECT DISTINCT(item_id) FROM tblitemcategory WHERE ic_cat_parent_id = '1' AND ic_cat_id = '".$home_list_region_id."' AND ic_deleted = '0' ) ";	
				}
				else
				{
					$sql_str_region = " AND item_id IN (SELECT DISTINCT(item_id) FROM tblitemcategory WHERE ic_cat_parent_id = '1' AND ic_cat_id != '164' AND ic_deleted = '0' ) ";	
				}
				
			}
			
			if($area_id == '' || $area_id == '-1')
			{
				$sql = "SELECT * FROM `tblcusines` 
					WHERE ( 
						( cusine_city_id = '".$city_id."' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 ) OR
						( cusine_city_id = '-1' AND cusine_state_id = '".$state_id."' ) OR 
						( cusine_city_id = '-1' AND FIND_IN_SET(".$state_id.", cusine_state_id) > 0 ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '".$country_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND FIND_IN_SET(".$country_id.", cusine_country_id) > 0  ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '-1' ) 
					) AND cusine_deleted = '0' AND cusine_status = '1' AND cusine_type_id = '120' ".$sql_str_region;				
			}
			else
			{
				$sql = "SELECT * FROM `tblcusines` 
					WHERE ( 
						( cusine_city_id = '".$city_id."' AND cusine_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND cusine_area_id = '".$area_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '".$area_id."' ) OR 
						( cusine_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( cusine_city_id = '-1' AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( cusine_city_id = '".$city_id."' AND cusine_area_id = '-1' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND cusine_area_id = '-1'  ) OR
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '".$state_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND FIND_IN_SET(".$state_id.", cusine_state_id) > 0 ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '".$country_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND FIND_IN_SET(".$country_id.", cusine_country_id) > 0  ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '-1' )
						
					) AND cusine_deleted = '0' AND cusine_status = '1' AND cusine_type_id = '120' ".$sql_str_region;			
			}
			//echo'<br>'.$sql.'<br>';
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$temp_date = date('Y-m-d');
					$go_ahead = false;
					if($r['publish_date_type'] == 'days_of_month')
					{
						if($r['publish_days_of_month'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_month'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_month = explode(',',$r['publish_days_of_month']);
							if(in_array($today_day_of_month,$temp_arr_publish_days_of_month))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'days_of_week')
					{
						if($r['publish_days_of_week'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_week'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_week = explode(',',$r['publish_days_of_week']);
							if(in_array($today_day_of_week,$temp_arr_publish_days_of_week))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'single_date')
					{
						//echo '<br>'.$r['publish_single_date'];
						//echo '<br>'.$today_single_date;
						if(strtotime($r['publish_single_date']) <= strtotime($today_single_date))
						{
							$go_ahead = true;
						}
						
					}
					elseif($r['publish_date_type'] == 'date_range')
					{
						if( (strtotime($r['publish_start_date']) <= strtotime($today_single_date)) && (strtotime($r['publish_end_date']) >= strtotime($today_single_date)) )
						{
							$go_ahead = true;
						}
						
					}
					
					if($go_ahead)
					{
						$go_ahead = false;
						if($r['delivery_date_type'] == 'days_of_month')
						{
							if($r['delivery_days_of_month'] == '-1')
							{
								$go_ahead = true;
							}
							elseif($r['delivery_days_of_month'] == '')
							{
								
							}
							else
							{
								$temp_arr_delivery_days_of_month = explode(',',$r['delivery_days_of_month']);
								if(in_array($today_day_of_month,$temp_arr_delivery_days_of_month))
								{
									$go_ahead = true;	
								}
							}
						}
						elseif($r['delivery_date_type'] == 'days_of_week')
						{
							//echo'<br>222222222222222';
							if($r['delivery_days_of_week'] == '-1')
							{
								$go_ahead = true;
							}
							elseif($r['delivery_days_of_week'] == '')
							{
								
							}
							else
							{
								$temp_arr_delivery_days_of_week = explode(',',$r['delivery_days_of_week']);
								if(in_array($today_day_of_week,$temp_arr_delivery_days_of_week))
								{
									$go_ahead = true;	
								}
							}
						}
						elseif($r['delivery_date_type'] == 'single_date')
						{
							//echo'<br>'.$r['delivery_single_date'];
							//echo'<br>'.$current_showing_date;
							if($r['delivery_single_date'] == $current_showing_date)
							{
								$go_ahead = true;	
							}
						}
						elseif($r['delivery_date_type'] == 'date_range')
						{
							if($r['delivery_start_date'] != '0000-00-00')
							{
								if($r['delivery_end_date'] != '0000-00-00')
								{
									if( (strtotime($current_showing_date) >= strtotime($r['delivery_start_date']) ) && (strtotime($current_showing_date) <= strtotime($r['delivery_end_date']) ) )
									{
										$go_ahead = true;
									}
								}
							}
						}	
					}
					
					if($go_ahead)
					{
						$obj_r = new commonFunctions();
						$r['region_category'] = $obj_r->getRegionCategoryNameOfItem($r['item_id']);
						$r['region_category_id'] = $obj_r->getRegionCategoryIdOfItem($r['item_id']);
						$r['cusine_name'] = $obj_r->getItemName($r['item_id']);
						$r['cusine_default'] = $obj_r->getCusineDefaultPriceAndStock($r['cusine_id']);
						$r['vendor_name'] = $obj_r->getVendorName($r['vendor_id']);
						$r['cusine_weight'] = $obj_r->getCusineAllWeight($r['cusine_id']);
												
						/* Check if Booking Closed - Start */		
						
						if($r['region_category_id'] == '164')
						{
							$date_cc = date( 'Y-m-d');
							$cusine_delivery_date = date( 'Y-m-d', strtotime( $date_cc . ' +5 days' ) );
						}
						else
						{
							$cusine_delivery_date = date('Y-m-d', strtotime( $current_showing_date ) );	
						}
						
						if($r['order_cutoff_time'] != '' )
						{
							$date = date('Y-m-d', strtotime( $cusine_delivery_date ) );
							$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
							//$current_showing_date_time = $current_showing_date. ' 23:00:00';
							$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
							$timestamp_csdt = strtotime($current_showing_date_time);
							
							$sec_cuttoff_time = $r['order_cutoff_time'] * 3600;
							
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
						/* Check if Booking Closed - End */
						
						if($flag_add_to_cart)
						{
							//foreach($r as $key1 => $val1)
							//{
								//$r[$key1] = stripslashes($val1);
							//}
							//$output[] = $r;		
						}
						$output[] = $r;		
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[getAllPublishedCusines] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function getVendorName($vendor_id)
    {
        $DBH = new DatabaseHandler();
        $vendor_name = '';
        
        $sql = "SELECT vendor_name FROM `tblvendors` WHERE `vendor_id` = '".$vendor_id."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vendor_name = stripslashes($r['vendor_name']);
        }	

        return $vendor_name;
    }
	
	public function getAllPublishedComplementryCusines($city_id,$area_id='',$current_showing_date='')
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		if($current_showing_date == '')
		{
			$current_showing_date =date('Y-m-d');
		}
		
		$today_day_of_month = date('j',strtotime($current_showing_date));
		$today_day_of_week = date('N',strtotime($current_showing_date));
		$today_single_date = date('Y-m-d',strtotime($current_showing_date));
		
		$cnt = 0;
		try {
			
			if($area_id == '' || $area_id == '-1')
			{
				$sql = "SELECT * FROM `tblcusines` 
					WHERE ( 
						( cusine_city_id = '".$city_id."' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 ) OR
						( cusine_city_id = '-1' AND cusine_state_id = '".$state_id."' ) OR 
						( cusine_city_id = '-1' AND FIND_IN_SET(".$state_id.", cusine_state_id) > 0 ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '".$country_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND FIND_IN_SET(".$country_id.", cusine_country_id) > 0  ) OR 
						( cusine_city_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '-1' ) 
					) AND cusine_deleted = '0' AND cusine_status = '1' AND cusine_type_id = '122' ";				
			}
			else
			{
				$sql = "SELECT * FROM `tblcusines` 
					WHERE ( 
						( cusine_city_id = '".$city_id."' AND cusine_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND cusine_area_id = '".$area_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '".$area_id."' ) OR 
						( cusine_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( cusine_city_id = '-1' AND FIND_IN_SET(".$area_id.", cusine_area_id) > 0  ) OR 
						( cusine_city_id = '".$city_id."' AND cusine_area_id = '-1' ) OR 
						( FIND_IN_SET(".$city_id.", cusine_city_id) > 0 AND cusine_area_id = '-1'  ) OR
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '".$state_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND FIND_IN_SET(".$state_id.", cusine_state_id) > 0 ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '".$country_id."' ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND FIND_IN_SET(".$country_id.", cusine_country_id) > 0  ) OR 
						( cusine_city_id = '-1' AND cusine_area_id = '-1' AND cusine_state_id = '-1' AND cusine_country_id = '-1' )
						
					) AND cusine_deleted = '0' AND cusine_status = '1' AND cusine_type_id = '122' ";			
			}
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$temp_date = date('Y-m-d');
					$go_ahead = false;
					if($r['publish_date_type'] == 'days_of_month')
					{
						if($r['publish_days_of_month'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_month'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_month = explode(',',$r['publish_days_of_month']);
							if(in_array($today_day_of_month,$temp_arr_publish_days_of_month))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'days_of_week')
					{
						if($r['publish_days_of_week'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['publish_days_of_week'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_week = explode(',',$r['publish_days_of_week']);
							if(in_array($today_day_of_week,$temp_arr_publish_days_of_week))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['publish_date_type'] == 'single_date')
					{
						//echo '<br>'.$r['publish_single_date'];
						//echo '<br>'.$today_single_date;
						if(strtotime($r['publish_single_date']) <= strtotime($today_single_date))
						{
							$go_ahead = true;
						}
						
					}
					elseif($r['publish_date_type'] == 'date_range')
					{
						if( (strtotime($r['publish_start_date']) <= strtotime($today_single_date)) && (strtotime($r['publish_end_date']) >= strtotime($today_single_date)) )
						{
							$go_ahead = true;
						}
						
					}
					
					if($go_ahead)
					{
						$go_ahead = false;
						if($r['delivery_date_type'] == 'days_of_month')
						{
							if($r['delivery_days_of_month'] == '-1')
							{
								$go_ahead = true;
							}
							elseif($r['delivery_days_of_month'] == '')
							{
								
							}
							else
							{
								$temp_arr_delivery_days_of_month = explode(',',$r['delivery_days_of_month']);
								if(in_array($today_day_of_month,$temp_arr_delivery_days_of_month))
								{
									$go_ahead = true;	
								}
							}
						}
						elseif($r['delivery_date_type'] == 'days_of_week')
						{
							//echo'<br>222222222222222';
							if($r['delivery_days_of_week'] == '-1')
							{
								$go_ahead = true;
							}
							elseif($r['delivery_days_of_week'] == '')
							{
								
							}
							else
							{
								$temp_arr_delivery_days_of_week = explode(',',$r['delivery_days_of_week']);
								if(in_array($today_day_of_week,$temp_arr_delivery_days_of_week))
								{
									$go_ahead = true;	
								}
							}
						}
						elseif($r['delivery_date_type'] == 'single_date')
						{
							//echo'<br>'.$r['delivery_single_date'];
							//echo'<br>'.$current_showing_date;
							if($r['delivery_single_date'] == $current_showing_date)
							{
								$go_ahead = true;	
							}
						}
						elseif($r['delivery_date_type'] == 'date_range')
						{
							if($r['delivery_start_date'] != '0000-00-00')
							{
								if($r['delivery_end_date'] != '0000-00-00')
								{
									if( (strtotime($current_showing_date) >= strtotime($r['delivery_start_date']) ) && (strtotime($current_showing_date) <= strtotime($r['delivery_end_date']) ) )
									{
										$go_ahead = true;
									}
								}
							}
						}	
					}
					
					if($go_ahead)
					{
						$obj_r = new commonFunctions();
						$r['region_category'] = $obj_r->getRegionCategoryNameOfItem($r['item_id']);
						$r['cusine_name'] = $obj_r->getItemName($r['item_id']);
						$r['cusine_default'] = $obj_r->getCusineDefaultPriceAndStock($r['cusine_id']);
						//foreach($r as $key1 => $val1)
						//{
							//$r[$key1] = stripslashes($val1);
						//}
						$output[] = $r;
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[getAllPublishedComplementryCusines] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function chkIfCusineQtyAvailable($cusine_id,$qty)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblcusinelocations` WHERE `cusine_id` = '".$cusine_id."' AND `default_price` = '1' AND `culoc_status` = '1' AND `culoc_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$cusine_qty = $r['cusine_qty'];
				
				if($cusine_qty > 0 && $qty > 0 && $cusine_qty >= $qty)
				{
					$return = true;
				}
			}
		} catch (Exception $e) {
			$stringData = '[chkIfCusineQtyAvailable] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}
        return $return;
    }
	
	public function getCusineDetailsForCart($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
		try {
			$sql = "SELECT TBC.*,TCL.* FROM `tblcusines` AS TBC
					LEFT JOIN `tblcusinelocations` AS TCL ON TBC.cusine_id = TCL.cusine_id
					WHERE TBC.cusine_id = '".$cusine_id."' AND TBC.cusine_deleted = '0' AND TCL.culoc_deleted = '0' AND TCL.default_price = '1' ";
			$STH = $DBH->query($sql);
			if($STH->rowCount() > 0)
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$arr_record = $r;
			}	
		} catch (Exception $e) {
			$stringData = '[getCusineDetailsForCart] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return $arr_record;
		}	

        return $arr_record;
    }
	
	public function chkIfOfferCusine($cusine_id)
    {
        $arr_cusine_records = $this->getCusineDetailsForCart($cusine_id);

		$offer_item_flag = false;
		$today_day_of_month = date('j');
		$today_day_of_week = date('N');
		$today_single_date = date('Y-m-d');
		if($arr_cusine_records['is_offer'] == '1')
		{
			if($arr_cusine_records['offer_date_type'] == 'days_of_month')
			{
				if($arr_cusine_records['offer_days_of_month'] == '-1')
				{
					$offer_item_flag = true;	
				}	
				else
				{
					$temp_ofr_dom = explode(',',$arr_cusine_records['offer_days_of_month']);
					if(in_array($today_day_of_month,$temp_ofr_dom))
					{
						$offer_item_flag = true;		
					}
				}
			}
			elseif($arr_cusine_records['offer_date_type'] == 'days_of_week')
			{
				if($arr_cusine_records['offer_days_of_week'] == '-1')
				{
					$offer_item_flag = true;	
				}	
				else
				{
					$temp_ofr_dow = explode(',',$arr_cusine_records['offer_days_of_week']);
					if(in_array($today_day_of_week,$temp_ofr_dow))
					{
						$offer_item_flag = true;		
					}
				}
			}
			elseif($arr_cusine_records['offer_date_type'] == 'single_date')
			{
				if($arr_cusine_records['offer_single_date'] == $today_single_date)
				{
					$offer_item_flag = true;	
				}	
			}
			elseif($arr_cusine_records['offer_date_type'] == 'date_range')
			{
				$temp_ts_today = strtotime($today_single_date);
				$temp_ts_start = strtotime($arr_cusine_records['offer_single_date']);
				$temp_ts_end = strtotime($arr_cusine_records['offer_end_date']);
				if($temp_ts_start <= $temp_ts_today && $temp_ts_end >= $temp_ts_today)
				{
					$offer_item_flag = true;	
				}	
			}
		}
        return $offer_item_flag;
    }
	
	public function getCusineAllWeight($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
		try {
			$sql = "SELECT * FROM `tblcusineweight` WHERE `cusine_id` = '".$cusine_id."' AND `cw_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if($STH->rowCount() > 0)
			{
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{
					$arr_record[] = $r;	
				}
				
			}
		} catch (Exception $e) {
			$stringData = '[getCusineAllWeight] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return $arr_record;
		}	

        return $arr_record;
    }
	
	public function addToCart($cusine_id,$qty,$cart_area_id='0',$cart_delivery_date='')
    {
		$my_DBH = new DatabaseHandler();
        $return = false;
		$cart_session_id = session_id();
		
		if($cart_area_id == '' || $cart_area_id == '-1')
		{
			$cart_area_id = '0';
		}
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}

		if($this->chkIfCusineQtyAvailable($cusine_id,$qty))
		{
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
						
			$arr_cusine_details = $this->getCusineDetailsForCart($cusine_id);
			
			if($this->chkIfOfferCusine($cusine_id))
			{
				$is_offer = 1;
				$offer_price = $arr_cusine_details['offer_price'];
			}
			else
			{
				$is_offer = 0;
				$offer_price = '';
			}
			/*
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cusine_id` = '".$cusine_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cusine_id` = '".$cusine_id."' AND 
					`cart_delivery_date` = '".$cart_delivery_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			$STH = $my_DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$old_qty = $r['qty'];
				$qty = $qty + $old_qty;
		
				if($this->chkIfCusineQtyAvailable($cusine_id,$qty))
				{
					$DBH = $my_DBH->raw_handle();
					$DBH->beginTransaction();	
					
					$price = $arr_cusine_details['cusine_price'];
					if($is_offer == '1')
					{
						$subtotal = $offer_price * $qty;
					}
					else
					{
						$subtotal = $price * $qty;	
					}
					
					
					try {
						$sql = "UPDATE `tblcart` SET 
								`qty` = :qty,
								`price` = :price,
								`subtotal` = :subtotal,
								`is_offer` = :is_offer,
								`offer_price` = :offer_price,
								`cart_add_date` = :cart_add_date
								WHERE 		
								`cart_session_id` = :cart_session_id AND 
								`cart_delivery_date` = :cart_delivery_date AND 
								`cart_city_id` = :cart_city_id AND 
								`cusine_id` = :cusine_id ";
						$STH = $DBH->prepare($sql);
						$STH->execute(array(
							':qty' => addslashes($qty),
							':price' => addslashes($price),
							':subtotal' => addslashes($subtotal),
							':is_offer' => addslashes($is_offer),
							':offer_price' => addslashes($offer_price),
							':cart_add_date' => date('Y-m-d H:i:s'),
							':cart_session_id' => addslashes($cart_session_id),
							':cart_delivery_date' => addslashes($cart_delivery_date),
							':cart_city_id' => addslashes($topcityid),
							':cusine_id' => addslashes($cusine_id)
							
						));
						$DBH->commit();
						$return = true;
					} catch (Exception $e) {
						$stringData = '[addToCart] Catch Error:'.$e->getMessage().', sql:'.$sql;
						$this->debuglog($stringData);
						return false;
					}
				}	
			}
			else
			{
				$DBH = $my_DBH->raw_handle();
				$DBH->beginTransaction();	
				
				$price = $arr_cusine_details['cusine_price'];
				
				if($qty < $arr_cusine_details['min_order'])
				{
					$qty = $arr_cusine_details['min_order'];
				}
				elseif($qty > $arr_cusine_details['max_order'])
				{
					$qty = $arr_cusine_details['max_order'];
				}
				
				if($this->chkIfCusineQtyAvailable($cusine_id,$qty))
				{
					if($is_offer == '1')
					{
						$subtotal = $offer_price * $qty;
					}
					else
					{
						$subtotal = $price * $qty;	
					}
					
					try {
						$sql = "INSERT INTO `tblcart` (`cart_session_id`,`cusine_id`,`user_id`,`qty`,`price`,`subtotal`,`currency_id`,`ordering_type_id`,
								`ordering_size_id`,`cart_status`,`cart_add_date`,`cart_delivery_date`,`cart_city_id`,`cart_area_id`,`is_offer`,`offer_price`) 
								VALUES (:cart_session_id,:cusine_id,:user_id,:qty,:price,:subtotal,:currency_id,:ordering_type_id,
								:ordering_size_id,:cart_status,:cart_add_date,:cart_delivery_date,:cart_city_id,:cart_area_id,:is_offer,:offer_price)";
						$STH = $DBH->prepare($sql);
						$STH->execute(array(
							':cart_session_id' => addslashes($cart_session_id),
							':cusine_id' => addslashes($cusine_id),
							':user_id' => addslashes($user_id),
							':qty' => addslashes($qty),
							':price' => addslashes($price),
							':subtotal' => addslashes($subtotal),
							':currency_id' => addslashes($arr_cusine_details['currency_id']),
							':ordering_type_id' => addslashes($arr_cusine_details['ordering_type_id']),
							':ordering_size_id' => addslashes($arr_cusine_details['ordering_size_id']),
							':cart_status' => 0,
							':cart_add_date' => date('Y-m-d H:i:s'),
							':cart_delivery_date' => addslashes($cart_delivery_date),
							':cart_city_id' => addslashes($topcityid),
							':cart_area_id' => addslashes($cart_area_id),
							':is_offer' => addslashes($is_offer),
							':offer_price' => addslashes($offer_price)
						));
						$cart_id = $DBH->lastInsertId();
						//$this->debuglog('[addToCart] lastInsertId'.$cart_id);
						$DBH->commit();
						
						//if($cart_id > 0)
						//{
							$return = true;
						//}
						
					} catch (Exception $e) {
						$stringData = '[addToCart] Catch Error:'.$e->getMessage().', sql:'.$sql;
						$this->debuglog($stringData);
						return false;
					}
				}	
			}	
		}
        
        return $return;
    }
	
	public function updateCartSingleItem($cusine_id,$qty,$cart_delivery_date)
    {
		$my_DBH = new DatabaseHandler();
        $return = false;
		$cart_session_id = session_id();
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}

		if($this->chkIfCusineQtyAvailable($cusine_id,$qty))
		{
			//echo '11111111111111111111111';
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
			
			$arr_cusine_details = $this->getCusineDetailsForCart($cusine_id);
			
			if($this->chkIfOfferCusine($cusine_id))
			{
				$is_offer = 1;
				$offer_price = $arr_cusine_details['offer_price'];
			}
			else
			{
				$is_offer = 0;
				$offer_price = '';
			}
			
			/*
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cusine_id` = '".$cusine_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cusine_id` = '".$cusine_id."' AND 
					`cart_delivery_date` = '".$cart_delivery_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			$STH = $my_DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				//echo '2222222222222';
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				
				$DBH = $my_DBH->raw_handle();
				$DBH->beginTransaction();	
				
				$price = $arr_cusine_details['cusine_price'];
				
				if($is_offer == '1')
				{
					$subtotal = $offer_price * $qty;
				}
				else
				{
					$subtotal = $price * $qty;	
				}
				
				try {
					$sql = "UPDATE `tblcart` SET 
							`qty` = :qty,
							`price` = :price,
							`subtotal` = :subtotal,
							`is_offer` = :is_offer,
							`offer_price` = :offer_price,
							`cart_add_date` = :cart_add_date
							WHERE 		
							`cart_session_id` = :cart_session_id AND 
							`cart_delivery_date` = :cart_delivery_date AND 
							`cart_city_id` = :cart_city_id AND 
							`cusine_id` = :cusine_id ";
					$STH = $DBH->prepare($sql);
					$STH->execute(array(
						':qty' => addslashes($qty),
						':price' => addslashes($price),
						':subtotal' => addslashes($subtotal),
						':is_offer' => addslashes($is_offer),
						':offer_price' => addslashes($offer_price),
						':cart_add_date' => date('Y-m-d H:i:s'),
						':cart_session_id' => addslashes($cart_session_id),
						':cart_delivery_date' => addslashes($cart_delivery_date),
						':cart_city_id' => addslashes($topcityid),
						':cusine_id' => addslashes($cusine_id)
						
					));
					$DBH->commit();
					$return = true;
				} catch (Exception $e) {
					$stringData = '[updateCartSingleItem] Catch Error:'.$e->getMessage().', sql:'.$sql;
					$this->debuglog($stringData);
					return false;
				}
			}
		}
        
        return $return;
    }
	
	public function getDiscountCouponDetailsByCoupon($discount_coupon)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tbldiscountcoupons` WHERE `discount_coupon` = '".$discount_coupon."' AND `dc_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function doApplyDiscountCoupon($discount_coupon)
    {
		$my_DBH = new DatabaseHandler();
        $return = false;
		$cart_session_id = session_id();
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}

		if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
		{
			$current_showing_date = $_SESSION['current_showing_date'];
		}
		else
		{
			$current_showing_date = '';
		}
		
		if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
		{
			$topcityid = $_SESSION['topcityid'];
		}
		else
		{
			$topcityid = '0';
		}
		
		if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
		{
			$topareaid = $_SESSION['topareaid'];
		}
		else
		{
			$topareaid = '0';
		}
					
		$arr_coupon_details = $this->getDiscountCouponDetailsByCoupon($discount_coupon);
		/*
		$sql = "SELECT * FROM `tblcart` WHERE 
				`cart_session_id` = '".$cart_session_id."' AND 
				`cusine_id` = '".$cusine_id."' AND 
				`cart_delivery_date` = '".$current_showing_date."' AND 
				`cart_city_id` = '".$topcityid."' AND 
				`cart_area_id` = '".$topareaid."' AND 
				`cart_status` = '0' AND 
				`cart_deleted` = '0' ";
		*/
		$sql = "SELECT * FROM `tblcart` 
				WHERE 
				`cart_session_id` = '".$cart_session_id."' AND 
				`cart_city_id` = '".$topcityid."' AND 
				`cart_status` = '0' AND 
				`cart_deleted` = '0' ";
		$STH = $my_DBH->query($sql);
		if( $STH->rowCount() > 0 )
		{
			$DBH = $my_DBH->raw_handle();
			$DBH->beginTransaction();	
			
			try {
				$sql = "UPDATE `tblcart` SET 
						`discount_coupon` = :discount_coupon
						WHERE 		
						`cart_session_id` = :cart_session_id AND 
						`cart_city_id` = :cart_city_id AND 
						`cart_status` = '0' AND `cart_deleted` = '0' ";
				$STH = $DBH->prepare($sql);
				$STH->execute(array(
					':discount_coupon' => addslashes($discount_coupon),
					':cart_session_id' => addslashes($cart_session_id),
					':cart_city_id' => addslashes($topcityid)
				));
				$DBH->commit();
				$return = true;
			} catch (Exception $e) {
				$stringData = '[doApplyDiscountCoupon] Catch Error:'.$e->getMessage().', sql:'.$sql;
				$this->debuglog($stringData);
				return false;
			}
		}
        return $return;
    }
	
	public function removeFromCart($cart_id)
    {
		$my_DBH = new DatabaseHandler();
        $return = false;
		$cart_session_id = session_id();
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}

		if($cart_id != '')
		{
			$sql = "SELECT * FROM `tblcart` WHERE `cart_session_id` = '".$cart_session_id."' AND `cart_id` = '".$cart_id."' AND `cart_status` = '0' AND `cart_deleted` = '0' ";
			$STH = $my_DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$DBH = $my_DBH->raw_handle();
				$DBH->beginTransaction();	
				
				try {
					$sql = "UPDATE `tblcart` SET 
							`cart_deleted` = :cart_deleted,
							`cart_add_date` = :cart_add_date
							WHERE 		
							`cart_session_id` = :cart_session_id AND 
							`cart_id` = :cart_id ";
					$STH = $DBH->prepare($sql);
					$STH->execute(array(
						':cart_deleted' => 1,
						':cart_add_date' => date('Y-m-d H:i:s'),
						':cart_session_id' => addslashes($cart_session_id),
						':cart_id' => addslashes($cart_id)
						
					));
					$DBH->commit();
					$return = true;
				} catch (Exception $e) {
					$stringData = '[removeFromCart] Catch Error:'.$e->getMessage().', sql:'.$sql;
					$this->debuglog($stringData);
					return false;
				}
			}
		}
        
        return $return;
    }
	
	public function chkIfComplementryAlreadyAddedToCart($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$cart_session_id = session_id();
		try {
			
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
					
			/*			
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cusine_id` = '".$cusine_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cusine_id` = '".$cusine_id."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;	
			}
		} catch (Exception $e) {
			$stringData = '[chkIfComplementryAlreadyAddedToCart] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }	
        return $return;
    }
	
	public function chkIfAnyComplementryAlreadyAddedToCart()
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$cart_session_id = session_id();
		try {
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
					
			/*			
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$obj_temp = new commonFunctions();
					$arr_cusine_details = $obj_temp->getCusineDetailsForCart($r['cusine_id']);
					if($arr_cusine_details['cusine_type_id'] == '122')
					{
						$return = true;	
						break;
					}	
				}	
			}
		} catch (Exception $e) {
			$stringData = '[chkIfAnyComplementryAlreadyAddedToCart] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }	
        return $return;
    }
	
	public function getSideCartComplementrySlider($subtotal)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$cart_session_id = session_id();
		
		$topcityid = $_SESSION['topcityid'];
		$topareaid = $_SESSION['topareaid'];
		$current_showing_date = $_SESSION['current_showing_date'];	
		
		if($this->chkIfAnyComplementryAlreadyAddedToCart())
		{
			$output .= '<div class="complementry_box">
							<h3>You have selected complimentry item</h3>
						</div>';	
						
		}
		else
		{
			$arr_cusine_records_temp = $this->getAllPublishedComplementryCusines($topcityid,$topareaid,$current_showing_date); 
	
			if($this->isUserLoggedIn())
			{
				$user_id = $_SESSION['user_id'];
			}
			else
			{
				$user_id = 0;
			}
			
			$arr_cusine_records = array();
			if(count($arr_cusine_records_temp) > 0)
			{
				foreach($arr_cusine_records_temp as $cnt => $r)
				{
					$obj_temp = new commonFunctions();
					$arr_cusine_details = $obj_temp->getCusineDetailsForCart($r['cusine_id']);
					//echo '<br><pre>';
					//print_r($arr_cusine_details);
					//echo '<br></pre>';
					if($arr_cusine_details['cusine_type_id'] == '122')
					{
						if(!$obj_temp->chkIfComplementryAlreadyAddedToCart($r['cusine_id']))
						{
							if($arr_cusine_details['min_cart_price'] == '')
							{
								$arr_cusine_details['min_cart_price'] = 0;
							}
							
							if($arr_cusine_details['min_cart_price'] <= $subtotal)
							{
								//foreach($r as $key1 => $val1)
								//{
									//$r[$key1] = stripslashes($val1);
								//}
								$arr_cusine_records[] = $r;
							}
						}	
					}
					else
					{
						//foreach($r as $key1 => $val1)
						//{
							//$r[$key1] = stripslashes($val1);
						//}
						$arr_cusine_records[] = $r;
					}
					
				}
			}	
					
			if(count($arr_cusine_records) > 0)
			{
				$output .= '<div class="complementry_box">
								<h3>Please select any complimentry Item</h3>
								<div class="my_silick_complementry">';
				foreach($arr_cusine_records as $cnt => $r)
				{
					$output .= '	<div class="silick item">
										<div class="image" style="background-image: url(&quot;'.SITE_URL.'/uploads/'.$r['cusine_image'].'&quot;);"></div>
										<div class="info">
											<h4>'.$r['cusine_name'].'</h4>
											<div class="actions">
												<div class="qty"></div>
												<span class="price">
													<span>₹ '.$r['cusine_default']['cusine_price'].'</span>
												</span>
											</div>
											<button class="button_complementry" onclick="addToCart(\''.$r['cusine_id'].'\',\'1	\');">Add to Cart</button>
										</div>
									</div>';
				}
				$output .= '	</div>
							</div>';
			}	
		}
		
		
		return $output;
	}
	
	public function getSideCartBox()
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$output .= '<div class="side-cart-header">
						<h4>Your Cart</h4>
						<div class="back cart-box-toggle" id="cart-box-toggle" onclick="closeCartPopup()">close</div>
					</div>';	
		$output .= '<div class="side-cart-body">
						<div class="cart">';
		
		$cart_session_id = session_id();
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}
		
		try {
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
			
			/*	
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ORDER BY cart_add_date DESC";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$subtotal = 0;
				$cnt = 0;
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{
					$obj_temp = new commonFunctions();
					$arr_cusine_details = $obj_temp->getCusineDetailsForCart($r['cusine_id']);
					//echo '<br><pre>';
					//print_r($arr_cusine_details);
					//echo '<br></pre>';
					$output .= '<div class="item ng-scope">
									<div class="image" style="background-image: url(&quot;'.SITE_URL.'/uploads/'.$arr_cusine_details['cusine_image'].'&quot;);"></div>
									<div class="info">
										<div class="close" onclick="removeFromCart('.$r['cart_id'].');">×</div>
										<h4>'.$obj_temp->getItemName($arr_cusine_details['item_id']).'</h4>
										<p class="cart_small_text">Delivery Date : '.date('jS F',strtotime($r['cart_delivery_date'])).'</p>
										<p class="cart_small_text">Delivery Area : '.$obj_temp->getCusineLocationStr($r['cart_city_id'],$r['cart_area_id']).'</p>
										<div class="actions">
											<div class="qty">
												<input type="hidden" name="hdncartcusine_id" id="hdncartcusine_id_'.$cnt.'" value="'.$r['cusine_id'].'">
												<input type="hidden" name="hdncartdelivery_date" id="hdncartdelivery_date_'.$cnt.'" value="'.$r['cart_delivery_date'].'">
												<select name="cart_qty" id="cart_qty_'.$cnt.'" onchange="updateCartSingleItem('.$cnt.')">';
												
												if(isset($arr_cusine_details['min_order']) && $arr_cusine_details['min_order'] != '' )
												{
													$min_order = $arr_cusine_details['min_order'];
												}
												else
												{
													$min_order = 1;
												}
												
												if(isset($arr_cusine_details['max_order']) && $arr_cusine_details['max_order'] != '' )
												{
													$max_order = $arr_cusine_details['max_order'];
												}
												else
												{
													$max_order = 10;
												}
												
												if($arr_cusine_details['cusine_type_id'] == '122')
												{
													$output .= '<option value="'.$min_order.'" '.$str_sel.'>'.$min_order.'</option>';
												}
												else
												{
													for($i=$min_order;$i<=$max_order;$i++)
													{
														if($r['qty'] == $i)
														{
															$str_sel = ' selected ';
														}
														else
														{
															$str_sel = '';
														}
														$output .= '<option value="'.$i.'" '.$str_sel.'>'.$i.'</option>';
													}	
												}
												
													
				$output .= '					</select>
											</div>
											<span class="price">
												<span class="ng-binding">₹ '.$r['subtotal'].'</span>
											</span>
										</div>
									</div>
								</div>';	
					$subtotal = $subtotal + $r['subtotal'];			
					$cnt++;
				}
				$subtotal_str = '<label>SUBTOTAL</label>₹ '.$subtotal;
				$btn_proceed_str = '<button onclick="javascipt:window.location.href=\'checkout.php\'">Proceed to Checkout</button>';
				
				$output .= '	</div>
					</div>';
					
				$output .= 	$this->getSideCartComplementrySlider($subtotal);
			}
			else
			{
				$output .= '<div class="empty">
								<h3>Your cart is empty.</h3>
								<h4>Add some delicious food available on our menu to checkout.</h4>
            				</div>';
				$subtotal_str = '';
				$btn_proceed_str = '<button>Proceed to Checkout</button>';
				
				$output .= '	</div>
					</div>';
			}
		
					
		
		$output .= '<div class="secondary">
						<div class="total">
							'.$subtotal_str.'
						</div>
					</div>
					<div class="footer" style="padding: 18px;">
						'.$btn_proceed_str.'
					</div>';
		} catch (Exception $e) {
			$stringData = '[getSideCartBox] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
		return $output;
	}
	
	public function getSideCartBoxCheckout()
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$output .= '<div class="checkout-cart-body">
						<div class="cart">';
		
		$cart_session_id = session_id();
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}
		
		try {
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
					
			/*			
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ORDER BY cart_add_date DESC";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$subtotal = 0;
				$cnt = 0;
				$cgst_amount = 0.00;
				$sgst_amount = 0.00;
				$cess_amount = 0.00;
				$gst_amount = 0.00;
				
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{
					$obj_temp = new commonFunctions();
					$arr_cusine_details = $obj_temp->getCusineDetailsForCart($r['cusine_id']);
					//echo '<br><pre>';
					//print_r($arr_cusine_details);
					//echo '<br></pre>';
					if(isset($arr_cusine_details['cgst_tax']) && $arr_cusine_details['cgst_tax'] != '')
					{
						$tax_calculated_amt_cgst = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['cgst_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_cgst = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_cgst = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						$cgst_amount = $cgst_amount + $tax_calculated_amt_cgst;
					}
					
					if(isset($arr_cusine_details['sgst_tax']) && $arr_cusine_details['sgst_tax'] != '')
					{
						$tax_calculated_amt_sgst = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['sgst_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_sgst = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_sgst = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						$sgst_amount = $sgst_amount + $tax_calculated_amt_sgst;
					}
					
					if(isset($arr_cusine_details['cess_tax']) && $arr_cusine_details['cess_tax'] != '')
					{
						$tax_calculated_amt_cess = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['cess_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_cess = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_cess = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						$cess_amount = $cess_amount + $tax_calculated_amt_cess;
					}
					
					if(isset($arr_cusine_details['gst_tax']) && $arr_cusine_details['gst_tax'] != '')
					{
						$tax_calculated_amt_gst = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['gst_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_gst = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_gst = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						$gst_amount = $gst_amount + $tax_calculated_amt_gst;
					}
					
					$output .= '<div class="item ng-scope">
									<div class="image" style="background-image: url(&quot;'.SITE_URL.'/uploads/'.$arr_cusine_details['cusine_image'].'&quot;);"></div>
									<div class="info">
										<div class="close" onclick="removeFromCartCheckout('.$r['cart_id'].');">×</div>
										<h4>'.$obj_temp->getItemName($arr_cusine_details['item_id']).'</h4>
										<p class="cart_small_text">Delivery Date : '.date('jS F',strtotime($r['cart_delivery_date'])).'</p>
										<p class="cart_small_text">Delivery Area : '.$obj_temp->getCusineLocationStr($r['cart_city_id'],$r['cart_area_id']).'</p>
										<div class="actions">
											<div class="qty">
												<input type="hidden" name="hdncartcusine_id" id="hdncartcusine_id_'.$cnt.'" value="'.$r['cusine_id'].'">
												<input type="hidden" name="hdncartdelivery_date" id="hdncartdelivery_date'.$cnt.'" value="'.$r['cart_delivery_date'].'">
												<select name="cart_qty" id="cart_qty_'.$cnt.'" onchange="updateCartSingleItemCheckout('.$cnt.')">';
												
												if(isset($arr_cusine_details['min_order']) && $arr_cusine_details['min_order'] != '' )
												{
													$min_order = $arr_cusine_details['min_order'];
												}
												else
												{
													$min_order = 1;
												}
												
												if(isset($arr_cusine_details['max_order']) && $arr_cusine_details['max_order'] != '' )
												{
													$max_order = $arr_cusine_details['max_order'];
												}
												else
												{
													$max_order = 10;
												}
												
												if($arr_cusine_details['cusine_type_id'] == '122')
												{
													$output .= '<option value="'.$min_order.'" '.$str_sel.'>'.$min_order.'</option>';
												}
												else
												{
													for($i=$min_order;$i<=$max_order;$i++)
													{
														if($r['qty'] == $i)
														{
															$str_sel = ' selected ';
														}
														else
														{
															$str_sel = '';
														}
														$output .= '<option value="'.$i.'" '.$str_sel.'>'.$i.'</option>';
													}
												}	
													
				$output .= '					</select>
											</div>
											<span class="price">
												<span class="ng-binding">₹ '.$r['subtotal'].'</span>
											</span>
										</div>
									</div>
								</div>';	
					$subtotal = $subtotal + $r['subtotal'];			
					$discount_coupon = stripslashes($r['discount_coupon']);
					$cnt++;
				}
				
				$trade_discount = $this->getTradeDiscountPrice($subtotal,$topcityid);
				
				$discount_amount = 0.00;
				$discount_on_subtotal = false;
				$discount_on_final = false;
				$arr_coupon_details = $this->getDiscountCouponDetailsByCoupon($discount_coupon);
				if(is_array($arr_coupon_details) && count($arr_coupon_details) > 0)
				{
					if($arr_coupon_details['dc_type'] == '0')
					{
						if($arr_coupon_details['discount_price'] == '')
						{
							$calculated_discount_price = 0.00;
						}
						else
						{
							$calculated_discount_price = $arr_coupon_details['discount_price'];
						}
						
						$discount_amount = $calculated_discount_price; 
						if($arr_coupon_details['dc_applied_on'] == '0')
						{
							$discount_on_subtotal = true;			
						}	
						elseif($arr_coupon_details['dc_applied_on'] == '1')
						{
							$discount_on_final = true;
						}
					}
					elseif($arr_coupon_details['dc_type'] == '1')
					{
						if($arr_coupon_details['dc_percentage'] == '')
						{
							$calculated_discount_price = 0.00;
						}
						else
						{
							$calculated_discount_price = ( $subtotal * $arr_coupon_details['dc_percentage'] ) / 100;
							if($arr_coupon_details['dc_applied_on'] == '0')
							{
								$discount_on_subtotal = true;			
							}	
							elseif($arr_coupon_details['dc_applied_on'] == '1')
							{
								$discount_on_final = true;
							}
						}
						
						$discount_amount = $calculated_discount_price; 
					}
					elseif($arr_coupon_details['dc_type'] == '2')
					{
						
					}
				}
				
				
				
				//$shipping_price = $this->getShippingPrice($subtotal,$topcityid,$topareaid);
				$shipping_price = $this->getShippingPrice($subtotal,$topcityid);
				
				
				$tax_amount = 0.00;
				//$tax_amount = $cgst_amount + $sgst_amount + $cess_amount + $gst_amount;
				$tax_amount = $cgst_amount + $sgst_amount + $cess_amount;
				$tax_str = '';
				$tax_str_cgst = '';
				$tax_str_sgst = '';
				$tax_str_cess = '';
				$tax_str_gst = '';
				
				if($cgst_amount > 0)
				{
					$tax_str_cgst = '<div class="total"><label>CGST</label>₹ '.number_format((float)$cgst_amount, 2, '.', '').'</div>';	
				}
				
				if($sgst_amount > 0)
				{
					$tax_str_sgst = '<div class="total"><label>SGST</label>₹ '.number_format((float)$sgst_amount, 2, '.', '').'</div>';	
				}
				
				if($cess_amount > 0)
				{
					$tax_str_cess = '<div class="total"><label>CESS </label>₹ '.number_format((float)$cess_amount, 2, '.', '').'</div>';	
				}
				
				if($gst_amount > 0)
				{
					//$tax_str_gst = '<div class="total"><label>GST </label>₹ '.number_format((float)$gst_amount, 2, '.', '').'</div>';	
				}
				/*
				//Commentd - for deactivate common tax - Start
				$arr_tax_details = $this->getTaxDetails($topcityid,$topareaid);
				if(is_array($arr_tax_details) && count($arr_tax_details) > 0)
				{
					if($arr_tax_details['tax_type'] == '0')
					{
						if($arr_tax_details['tax_applied_on'] == '0')
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}
						elseif($arr_tax_details['tax_applied_on'] == '1')
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}
						elseif($arr_tax_details['tax_applied_on'] == '2' )
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}
						elseif($arr_tax_details['tax_applied_on'] == '3' )
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}	
						else
						{
							
						}
						
						if($tax_amount > 0)
						{
							$tax_str = '<label>'.$arr_tax_details['tax_name'].'( ₹ '.$arr_tax_details['tax_amount'].' )</label>₹ '.number_format((float)$tax_amount, 2, '.', '');
						}
					}
					elseif($arr_tax_details['tax_type'] == '1')
					{
						if($arr_tax_details['tax_applied_on'] == '0')
						{
							$tax_calculated_amt = ( $subtotal * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						elseif($arr_tax_details['tax_applied_on'] == '1')
						{
							$tax_calculated_amt = ( ( $subtotal - $discount_amount) * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						elseif($arr_tax_details['tax_applied_on'] == '2' )
						{
							$tax_calculated_amt = ( ( $subtotal - $discount_amount + $shipping_price) * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						elseif($arr_tax_details['tax_applied_on'] == '3' )
						{
							$tax_calculated_amt = ( ( $subtotal - $discount_amount + $shipping_price) * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						else
						{
							
						}

						if($tax_amount > 0)
						{
							$tax_str = '<label>'.$arr_tax_details['tax_name'].'('.$arr_tax_details['tax_percentage'].' % )</label>₹ '.number_format((float)$tax_amount, 2, '.', '');
						}	
					}
					elseif($arr_tax_details['tax_type'] == '2')
					{
						 	
					}
					elseif($arr_tax_details['tax_type'] == '3')
					{
						$tax_str = '<label>'.$arr_tax_details['tax_name'].'</label>₹ '.number_format((float)$tax_amount, 2, '.', '');
					}
				}
				//Commentd - for deactivate common tax - End
				*/
				$final_total = $subtotal - $trade_discount - $discount_amount + $shipping_price + $tax_amount;
				
				//if($trade_discount > 0)
				//{
					$trade_discount_str = '<label>Trade Discount Amount</label>₹ '.number_format((float)$trade_discount, 2, '.', '');	
				//}
				//else
				//{
				//	$trade_discount_str = '';
				//}
				
				$discountcouponbtn_str = '<div class="row"><div class="col-lg-7"><label class="dc_text">Do you have Discount Coupon?</label></div><div class="col-lg-5"><input class="dc_input" type="text" name="discount_coupon" id="discount_coupon" value="'.$discount_coupon.'" > </div> ';
				$discountcouponbtn_str .= '<div class="col-lg-8">&nbsp;</div><div class="col-lg-4"><a style="margin-bottom:16px;" class="btn-red-small" href="javascript:doApplyDiscountCoupon();">Redeem</a> </div> </div>';
				
				$subtotal_str = '<label>SUBTOTAL</label>₹ '.number_format((float)$subtotal, 2, '.', '');
				$discount_str = '<label>Promo Discount Amount</label>₹ '.number_format((float)$discount_amount, 2, '.', '');
				$shipping_str = '<label>Shipping/Handling Charges</label>₹ '.number_format((float)$shipping_price, 2, '.', '');
				$total_str = '<label>TOTAL</label>₹ '.number_format((float)$final_total, 2, '.', '');
				$btn_proceed_str = '';
			}
			else
			{
				$output .= '<div class="empty">
								<h3>Your cart is empty.</h3>
								<h4>Add some delicious food available on our menu to checkout.</h4>
            				</div>';
				$subtotal_str = '';
				$trade_discount_str = '';
				$discountcouponbtn_str = '';
				$discount_str = '';
				$shipping_str = '';
				$tax_str = '';
				$tax_str_cgst = '';
				$tax_str_sgst = '';
				$tax_str_cess = '';
				$tax_str_gst = '';
				$total_str = '';
				$btn_proceed_str = '';
			}
		$output .= '	</div>
					</div>
					<div class="secondary">
						<div class="total">
							'.$discountcouponbtn_str.'
						</div>
						<div class="total">
							'.$subtotal_str.'
						</div>';
						if($trade_discount_str != '')
						{
		$output .= '	<div class="total">
							'.$trade_discount_str.'
						</div>';	
						}
						
		$output .= '	<div class="total">
							'.$discount_str.'
						</div>
						<div class="total">
							'.$shipping_str.'
						</div>
						'.$tax_str_cgst.'
						'.$tax_str_sgst.'
						'.$tax_str_cess.'
						<div class="final_total">
							'.$total_str.'
						</div>
					</div>
					<div class="footer" style="padding: 18px;">
						'.$btn_proceed_str.'
					</div>';
		} catch (Exception $e) {
			$stringData = '[getSideCartBox] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
		return $output;
	}
	
	public function chkIfDiscountCouponAlreadyRedeamed($discount_coupon)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblorders` WHERE `order_discount_coupon` = '".addslashes($order_discount_coupon)."' AND `order_status` > 0 ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return = true;	
		}

        return $return;
    }
	
	public function chkIfValidDiscountCoupon($discount_coupon)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$effective_day_of_month = date('j');
		$effective_day_of_week = date('N');
		$effective_single_date = date('Y-m-d');
		
		$sql_dc_effective_date_str = " AND ( 
							( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '".$effective_day_of_month."' OR  FIND_IN_SET(".$effective_day_of_month.", dc_effective_days_of_month) > 0 ) ) OR
							( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '".$effective_day_of_week."' OR  FIND_IN_SET(".$effective_day_of_week.", dc_effective_days_of_week) > 0 ) ) OR
							( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '".$effective_single_date."' ) ) OR
							( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '".$effective_single_date."' AND dc_effective_end_date >= '".$effective_single_date."' ) ) 
							) ";

        $sql = "SELECT * FROM `tbldiscountcoupons` WHERE `discount_coupon` = '".addslashes($discount_coupon)."' AND `dc_status` = '1' AND `dc_deleted` = '0' ".$sql_dc_effective_date_str." ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$r = $STH->fetch(PDO::FETCH_ASSOC);
			$dc_multiuser = stripslashes($r['dc_multiuser']);
			if($dc_multiuser == '1')
			{
				$return = true;	
			}
			elseif(!$this->chkIfDiscountCouponAlreadyRedeamed($discount_coupon))
			{
				$return = true;	
			}
		}

        return $return;
    }
	
	public function getCurrencyName($currency_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			$sql = "SELECT currency FROM `tblcurrencies` WHERE `currency_id` = '".$currency_id."' AND `currency_deleted` = '0' ";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$output = stripslashes($r['currency']);
			}
		} catch (Exception $e) {
			$stringData = '[getCurrencyName] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getCategoryName($cat_id)
	{
		$DBH = new DatabaseHandler();
		$return = '';
		
		try 
		{
			$sql = "SELECT cat_name FROM `tblcategories`  WHERE  `cat_id` = '".$cat_id."' AND `cat_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{	
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$return = $r['cat_name'];
			}
			return $return;
		} 
		catch (Exception $e) 
		{
			$stringData = '[getCategoryName] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}
	}
	
	public function getCategoryImage($cat_id)
	{
		$DBH = new DatabaseHandler();
		$return = '';
		
		try 
		{
			$sql = "SELECT cat_image FROM `tblcategories`  WHERE  `cat_id` = '".$cat_id."' AND `cat_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{	
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$return = $r['cat_image'];
			}
			return $return;
		} 
		catch (Exception $e) 
		{
			$stringData = '[getCategoryImage] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}
	}
	
	public function getCartDetailsBySessId($cart_session_id)
	{
		$DBH = new DatabaseHandler();
		$arr_cart_records = array();
		$arr_cart_records['cart'] = array();
		$subtotal = 0;
		$discount_amount = 0;
		$tax_amount = 0;
		$shipping_price = 0;
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}
		
		try {
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
			
			/*	
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$subtotal = 0;
				$cnt = 0;
				
				$cgst_amount = 0.00;
				$sgst_amount = 0.00;
				$cess_amount = 0.00;
				$gst_amount = 0.00;
				
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{
					$obj_temp = new commonFunctions();
					$arr_cusine_details = $obj_temp->getCusineDetailsForCart($r['cusine_id']);
					//echo '<br><pre>';
					//print_r($arr_cusine_details);
					//echo '<br></pre>';
					
					if(isset($arr_cusine_details['cgst_tax']) && $arr_cusine_details['cgst_tax'] != '')
					{
						$tax_calculated_amt_cgst = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['cgst_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_cgst = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_cgst = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						
						if($tax_calculated_amt_cgst > 0)
						{
							$r['prod_cgst_tax_amount'] = $tax_calculated_amt_cgst;
							$r['prod_cgst_tax_percentage'] = $arr_temp_tax_details['tax_percentage'];
						}
						else
						{
							$r['prod_cgst_tax_amount'] = '';
							$r['prod_cgst_tax_percentage'] = '';
						}
						
						$cgst_amount = $cgst_amount + $tax_calculated_amt_cgst;
					}
					else
					{
						$r['prod_cgst_tax_amount'] = '';
						$r['prod_cgst_tax_percentage'] = '';
					}
					
					if(isset($arr_cusine_details['sgst_tax']) && $arr_cusine_details['sgst_tax'] != '')
					{
						$tax_calculated_amt_sgst = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['sgst_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_sgst = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_sgst = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						
						if($tax_calculated_amt_sgst > 0)
						{
							$r['prod_sgst_tax_amount'] = $tax_calculated_amt_sgst;
							$r['prod_sgst_tax_percentage'] = $arr_temp_tax_details['tax_percentage'];
						}
						else
						{
							$r['prod_sgst_tax_amount'] = '';
							$r['prod_sgst_tax_percentage'] = '';
						}
						
						$sgst_amount = $sgst_amount + $tax_calculated_amt_sgst;
					}
					else
					{
						$r['prod_sgst_tax_amount'] = '';
						$r['prod_sgst_tax_percentage'] = '';
					}
					
					if(isset($arr_cusine_details['cess_tax']) && $arr_cusine_details['cess_tax'] != '')
					{
						$tax_calculated_amt_cess = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['cess_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_cess = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_cess = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						
						if($tax_calculated_amt_cess > 0)
						{
							$r['prod_cess_tax_amount'] = $tax_calculated_amt_cess;
							$r['prod_cess_tax_percentage'] = $arr_temp_tax_details['tax_percentage'];
						}
						else
						{
							$r['prod_cess_tax_amount'] = '';
							$r['prod_cess_tax_percentage'] = '';
						}
						
						$cess_amount = $cess_amount + $tax_calculated_amt_cess;
					}
					else
					{
						$r['prod_cess_tax_amount'] = '';
						$r['prod_cess_tax_percentage'] = '';
					}
					
					if(isset($arr_cusine_details['gst_tax']) && $arr_cusine_details['gst_tax'] != '')
					{
						$tax_calculated_amt_gst = 0.00;
						$arr_temp_tax_details = $obj_temp->getTaxDetailsByTaxId($arr_cusine_details['gst_tax']);
						if(count($arr_temp_tax_details) > 0)
						{
							if($arr_temp_tax_details['tax_type'] == '0')
							{
								$tax_calculated_amt_gst = $arr_temp_tax_details['tax_amount'];
							}
							elseif($arr_temp_tax_details['tax_type'] == '1')
							{
								$tax_calculated_amt_gst = ( $r['subtotal'] * $arr_temp_tax_details['tax_percentage'] ) / 100;
							}
							elseif($arr_temp_tax_details['tax_type'] == '2')
							{
									
							}
							elseif($arr_temp_tax_details['tax_type'] == '3')
							{
								
							}
						}
						
						if($tax_calculated_amt_gst > 0)
						{
							$r['prod_gst_tax_amount'] = $tax_calculated_amt_gst;
							$r['prod_gst_tax_percentage'] = $arr_temp_tax_details['tax_percentage'];
						}
						else
						{
							$r['prod_gst_tax_amount'] = '';
							$r['prod_gst_tax_percentage'] = '';
						}
						
						$gst_amount = $gst_amount + $tax_calculated_amt_gst;
					}
					else
					{
						$r['prod_gst_tax_amount'] = '';
						$r['prod_gst_tax_percentage'] = '';
					}
					
					$temp_cart_records = array();

					$temp_cart_records['cart_session_id'] = $cart_session_id;	
					$temp_cart_records['user_id'] = $user_id;	
					$temp_cart_records['prod_id'] = $r['cusine_id'];	
					$temp_cart_records['prod_name'] = $obj_temp->getItemName($arr_cusine_details['item_id']);	
					$temp_cart_records['prod_image'] = $arr_cusine_details['cusine_image'];	
					$temp_cart_records['prod_qty'] = $r['qty'];	
					$temp_cart_records['prod_amt'] = $r['price'];	
					$temp_cart_records['prod_subtotal'] = $r['subtotal'];	
					$temp_cart_records['prod_currency_id'] = $r['currency_id'];	
					$temp_cart_records['prod_currency'] = $obj_temp->getCurrencyName($r['currency_id']);	
					$temp_cart_records['prod_ordering_type_id'] = $r['ordering_type_id'];	
					$temp_cart_records['prod_ordering_type'] = $obj_temp->getCategoryName($r['ordering_type_id']);	
					$temp_cart_records['prod_ordering_size_id'] = $r['ordering_size_id'];	
					$temp_cart_records['prod_ordering_size'] = $obj_temp->getCategoryName($r['ordering_size_id']);	
					$temp_cart_records['item_last_qty'] = $arr_cusine_details['cusine_qty'];
					$temp_cart_records['cart_delivery_date'] = $r['cart_delivery_date'];						
					$temp_cart_records['cart_city_id'] = $r['cart_city_id'];						
					$temp_cart_records['cart_area_id'] = $r['cart_area_id'];						
					$temp_cart_records['is_offer'] = $r['is_offer'];						
					$temp_cart_records['offer_price'] = $r['offer_price'];						
					$temp_cart_records['prod_cgst_tax_amount'] = $r['prod_cgst_tax_amount'];						
					$temp_cart_records['prod_cgst_tax_percentage'] = $r['prod_cgst_tax_percentage'];						
					$temp_cart_records['prod_sgst_tax_amount'] = $r['prod_sgst_tax_amount'];						
					$temp_cart_records['prod_sgst_tax_percentage'] = $r['prod_sgst_tax_percentage'];						
					$temp_cart_records['prod_cess_tax_amount'] = $r['prod_cess_tax_amount'];						
					$temp_cart_records['prod_cess_tax_percentage'] = $r['prod_cess_tax_percentage'];						
					$temp_cart_records['prod_gst_tax_amount'] = $r['prod_gst_tax_amount'];						
					$temp_cart_records['prod_gst_tax_percentage'] = $r['prod_gst_tax_percentage'];						
					
					$arr_cart_records['cart'][$cnt] = $temp_cart_records;			
								
					$subtotal = $subtotal + $r['subtotal'];			
					$discount_coupon = $r['discount_coupon'];			
					$cnt++;
				}
				
				$trade_discount = $this->getTradeDiscountPrice($subtotal,$topcityid);
				
				$discount_amount = 0.00;
				/* Calculate Discount amount - Start */
				
				$discount_amount = 0.00;
				$discount_on_subtotal = false;
				$discount_on_final = false;
				$arr_coupon_details = $this->getDiscountCouponDetailsByCoupon($discount_coupon);
				if(is_array($arr_coupon_details) && count($arr_coupon_details) > 0)
				{
					if($arr_coupon_details['dc_type'] == '0')
					{
						if($arr_coupon_details['discount_price'] == '')
						{
							$calculated_discount_price = 0.00;
						}
						else
						{
							$calculated_discount_price = $arr_coupon_details['discount_price'];
						}
						
						$discount_amount = $calculated_discount_price; 
						if($arr_coupon_details['dc_applied_on'] == '0')
						{
							$discount_on_subtotal = true;			
						}	
						elseif($arr_coupon_details['dc_applied_on'] == '1')
						{
							$discount_on_final = true;
						}
					}
					elseif($arr_coupon_details['dc_type'] == '1')
					{
						if($arr_coupon_details['dc_percentage'] == '')
						{
							$calculated_discount_price = 0.00;
						}
						else
						{
							$calculated_discount_price = ( $subtotal * $arr_coupon_details['dc_percentage'] ) / 100;
							if($arr_coupon_details['dc_applied_on'] == '0')
							{
								$discount_on_subtotal = true;			
							}	
							elseif($arr_coupon_details['dc_applied_on'] == '1')
							{
								$discount_on_final = true;
							}
						}
						
						$discount_amount = $calculated_discount_price; 
					}
					elseif($arr_coupon_details['dc_type'] == '2')
					{
						
					}
				}
				
				/* Calculate Discount amount - End */
				
				
				
				
				//$shipping_price = $this->getShippingPrice($subtotal,$topcityid,$topareaid);
				$shipping_price = $this->getShippingPrice($subtotal,$topcityid);
				
				$tax_amount = 0.00;
				//$tax_amount = $cgst_amount + $sgst_amount + $cess_amount + $gst_amount;
				$tax_amount = $cgst_amount + $sgst_amount + $cess_amount;
				
				/*
				//Commentd - for deactivate common tax - Start
				$arr_tax_details = $this->getTaxDetails($topcityid,$topareaid);
				if(is_array($arr_tax_details) && count($arr_tax_details) > 0)
				{
					if($arr_tax_details['tax_type'] == '0')
					{
						if($arr_tax_details['tax_applied_on'] == '0')
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}
						elseif($arr_tax_details['tax_applied_on'] == '1')
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}
						elseif($arr_tax_details['tax_applied_on'] == '2' )
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}
						elseif($arr_tax_details['tax_applied_on'] == '3' )
						{
							$tax_amount = $tax_amount +	$arr_tax_details['tax_amount'];
						}	
						else
						{
							
						}
					}
					elseif($arr_tax_details['tax_type'] == '1')
					{
						if($arr_tax_details['tax_applied_on'] == '0')
						{
							$tax_calculated_amt = ( $subtotal * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						elseif($arr_tax_details['tax_applied_on'] == '1')
						{
							$tax_calculated_amt = ( ( $subtotal - $discount_amount) * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						elseif($arr_tax_details['tax_applied_on'] == '2' )
						{
							$tax_calculated_amt = ( ( $subtotal - $discount_amount + $shipping_price) * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						elseif($arr_tax_details['tax_applied_on'] == '3' )
						{
							$tax_calculated_amt = ( ( $subtotal - $discount_amount + $shipping_price) * $arr_tax_details['tax_percentage'] ) / 100;
							$tax_amount = $tax_amount +	$tax_calculated_amt;
						}
						else
						{
							
						}
					}
					elseif($arr_tax_details['tax_type'] == '2')
					{
						 	
					}
					elseif($arr_tax_details['tax_type'] == '3')
					{
						
					}
				}
				//Commentd - for deactivate common tax - End
				*/
				$total_amt = $subtotal - $trade_discount - $discount_amount + $tax_amount + $shipping_price;
			}
			
			$subtotal = number_format((float)$subtotal, 2, '.', '');
			$discount_amount = number_format((float)$discount_amount, 2, '.', '');
			$tax_amount = number_format((float)$tax_amount, 2, '.', '');
			$cgst_amount = number_format((float)$cgst_amount, 2, '.', '');
			$sgst_amount = number_format((float)$sgst_amount, 2, '.', '');
			$cess_amount = number_format((float)$cess_amount, 2, '.', '');
			$gst_amount = number_format((float)$gst_amount, 2, '.', '');
			$shipping_price = number_format((float)$shipping_price, 2, '.', '');
			$total_amt = number_format((float)$total_amt, 2, '.', '');
			
			$arr_cart_records['order_subtotal'] = $subtotal;
			$arr_cart_records['order_discount_coupon'] = $discount_coupon;
			$arr_cart_records['order_discount'] = $discount_amount;
			$arr_cart_records['order_trade_discount'] = $trade_discount;
			$arr_cart_records['order_tax'] = $tax_amount;
			$arr_cart_records['order_shipping_amt'] = $shipping_price;
			$arr_cart_records['order_total_amt'] = $total_amt;
			$arr_cart_records['order_cgst_tax_amount'] = $cgst_amount;
			$arr_cart_records['order_sgst_tax_amount'] = $sgst_amount;
			$arr_cart_records['order_cess_tax_amount'] = $cess_amount;
			$arr_cart_records['order_gst_tax_amount'] = $gst_amount;
		
		} catch (Exception $e) {
			$stringData = '[getCartDetailsBySessId] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return $arr_cart_records;
		}
		return $arr_cart_records;
	}
	
	public function chkIfCartEmpty()
    {
        $DBH = new DatabaseHandler();
        $return = true;

		$cart_session_id = session_id();
		
		if($this->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}
		
		try {
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
			
			/*	
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_delivery_date` = '".$current_showing_date."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_area_id` = '".$topareaid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			*/
			$sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_city_id` = '".$topcityid."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = false;
			}
		} catch (Exception $e) {
			$stringData = '[chkIfCartEmpty] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return true;
		}	
        return $return;
    }

	public function chkEmailExists($email)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `user_deleted` = '0' AND `is_guest_user` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[chkEmailExists] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}	
        return $return;
    }
	
    public function chkEmailExists_Edit($email,$user_id)
    {
		$DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `user_id` != '".$user_id."' AND `user_deleted` = '0' AND `is_guest_user` = '0'  ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[chkEmailExists_Edit] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}	
        return $return;
    }	
	
	public function chkMobileNoExists($mobile_no)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `mobile_no` = '".$mobile_no."' AND `user_deleted` = '0' AND `is_guest_user` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[chkMobileNoExists] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}	
        return $return;
    }
	
	public function chkMobileNoExists_Edit($mobile_no,$user_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `mobile_no` = '".$mobile_no."' AND `user_id` != '".$user_id."' AND `user_deleted` = '0' AND `is_guest_user` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[chkMobileNoExists_Edit] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}	
        return $return;
    }
	
	public function doCheckoutSignUp($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
		
		try {
			$sql = "INSERT INTO `tblusers` (`first_name`,`last_name`,`email`,`password`,`mobile_no`,`user_status`,`user_add_date`,`is_guest_user`,`user_otp`) 
					VALUES (:first_name,:last_name,:email,:password,:mobile_no,:user_status,:user_add_date,:is_guest_user,:user_otp)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':first_name' => addslashes($tdata['first_name']),
				':last_name' => addslashes($tdata['last_name']),
				':email' => addslashes($tdata['email']),
				':password' => md5($tdata['password']),
				':mobile_no' => addslashes($tdata['mobile_no']),
				':user_status' => addslashes($tdata['user_status']),
				':user_add_date' => date('Y-m-d H:i:s'),
				':is_guest_user' => addslashes($tdata['is_guest_user']),
				':user_otp' => addslashes($tdata['user_otp'])
            ));
			$return = $DBH->lastInsertId();
			$DBH->commit();
		} catch (Exception $e) {
			$stringData = '[doCheckoutSignUp] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
	
	public function getUserId($email)
    {
        $DBH = new DatabaseHandler();
        $user_id = 0;

        $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `user_deleted` = '0' AND `is_guest_user` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
            $user_id = $r['user_id'];
        }
        return $user_id;
    }
	
	public function getUserFullNameById($user_id)
    {
        $DBH = new DatabaseHandler();
        $name = '';

        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' AND `is_guest_user` = '0'   ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
            $first_name = stripslashes($r['first_name']);
            $last_name = stripslashes($r['last_name']);
            $name = $first_name.' '.$last_name;
        }
        return $name;
    }
	
	public function getUserFirstNameById($user_id)
    {
        $DBH = new DatabaseHandler();
        $name = '';

        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' AND `is_guest_user` = '0'   ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
            $first_name = stripslashes($r['first_name']);
            $name = $first_name;
        }
        return $name;
    }
	
	public function getUserLastNameById($user_id)
    {
        $DBH = new DatabaseHandler();
        $name = '';

        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' AND `is_guest_user` = '0'   ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
            $first_name = stripslashes($r['last_name']);
            $name = $first_name;
        }
        return $name;
    }
	
	public function getUserEmail($user_id)
    {
        $DBH = new DatabaseHandler();
        $email = '';

        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' AND `is_guest_user` = '0'   ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
            $email = stripslashes($r['email']);
        }
        return $email;
    }
	
	public function getUserMobileNoById($user_id)
    {
        $DBH = new DatabaseHandler();
        $mobile_no = '';

        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' AND `is_guest_user` = '0'   ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
            $mobile_no = stripslashes($r['mobile_no']);
        }
        return $mobile_no;
    }
	
	public function doUserLogin($email)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $user_id = $this->getUserId($email);
        if($user_id > 0)
        {
			$user_fullname = $this->getUserFullNameById($user_id);
			$user_firstname = $this->getUserFirstNameById($user_id);
			$user_mobile_no = $this->getUserMobileNoById($user_id);
			
            $return = true;	
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $email; 
            $_SESSION['user_email'] = $email;
            $_SESSION['user_mobile_no'] = $user_mobile_no;
            $_SESSION['user_firstname'] = $user_firstname;
            $_SESSION['user_fullname'] = $user_fullname;
        }	
        return $return;
    }
	
	public function chkValidUserId($user_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_status` = '1'  AND `user_deleted` = '0' AND `is_guest_user` = '0' ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;	
        }
        return $return;
    }
	
	public function isUserLoggedIn()
    {
        $return = false;
        if( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) && ($_SESSION['user_id'] != '') )
        {
            $return = $this->chkValidUserId($_SESSION['user_id']);	
        }
        return $return;
    }
	
	public function updateUserOnlineTimestamp($user_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		$user_online_timestamp = date('Y-m-d H:i:s');

        try {
			$sql = "UPDATE `tblusers` SET 
					`user_online_timestamp` = :user_online_timestamp  
					WHERE `user_id` = :user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':user_online_timestamp' => $user_online_timestamp,
				':user_id' => $user_id
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateUserOnlineTimestamp] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
	}
	
	public function chkValidUserLogin($email,$password)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `password` = '".md5($password)."' AND `user_status` = '1' AND `user_deleted` = '0' AND `user_blocked` = '0' AND `is_guest_user` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function doUserLogout()
    {
        $return = true;	

        $_SESSION['user_id'] = '';
        $_SESSION['username'] = '';
        $_SESSION['user_email'] = '';
        $_SESSION['user_mobile_no'] = '';
        $_SESSION['user_fullname'] = '';
        $_SESSION['user_firstname'] = '';
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_mobile_no']);
        unset($_SESSION['user_fullname']);
        unset($_SESSION['user_firstname']);
		/*
        session_destroy();
        session_start();
        session_regenerate_id();
        $new_sessionid = session_id();
		*/
		$_SESSION = array();
        return $return;
    }
	
	public function getUserDetails($user_id)
    {
		$DBH = new DatabaseHandler();
		$arr_record = array();
		
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0'  ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
			$arr_record = $r;
        }
        return $arr_record;
    }
	
	public function updateUserAddressDetails($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`building_name` = :building_name,
					`floor_no` = :floor_no,
					`landmark` = :landmark,
					`address` = :address,  
					`country_id` = :country_id,  
					`state_id` = :state_id,  
					`city_id` = :city_id,  
					`area_id` = :area_id,  
					`delivery_mobile_no` = :delivery_mobile_no,
					`pincode` = :pincode,
					`billing_building_name` = :billing_building_name,
					`billing_floor_no` = :billing_floor_no,
					`billing_landmark` = :billing_landmark,
					`billing_address` = :billing_address,  
					`billing_country_id` = :billing_country_id,  
					`billing_state_id` = :billing_state_id,  
					`billing_city_id` = :billing_city_id,  
					`billing_area_id` = :billing_area_id,  
					`billing_mobile_no` = :billing_mobile_no,
					`billing_pincode` = :billing_pincode,
					`delivery_name` = :delivery_name,
					`billing_name` = :billing_name
					WHERE `user_id` = :user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':building_name' => addslashes($tdata['building_name']),
				':floor_no' => addslashes($tdata['floor_no']),
				':landmark' => addslashes($tdata['landmark']),
				':address' => addslashes($tdata['address']),
				':country_id' => addslashes($tdata['country_id']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':area_id' => addslashes($tdata['area_id']),
				':delivery_mobile_no' => addslashes($tdata['delivery_mobile_no']),
				':pincode' => addslashes($tdata['pincode']),
				':billing_building_name' => addslashes($tdata['billing_building_name']),
				':billing_floor_no' => addslashes($tdata['billing_floor_no']),
				':billing_landmark' => addslashes($tdata['billing_landmark']),
				':billing_address' => addslashes($tdata['billing_address']),
				':billing_country_id' => addslashes($tdata['billing_country_id']),
				':billing_state_id' => addslashes($tdata['billing_state_id']),
				':billing_city_id' => addslashes($tdata['billing_city_id']),
				':billing_area_id' => addslashes($tdata['billing_area_id']),
				':billing_mobile_no' => addslashes($tdata['billing_mobile_no']),
				':billing_pincode' => addslashes($tdata['billing_pincode']),
				':delivery_name' => addslashes($tdata['delivery_name']),
				':billing_name' => addslashes($tdata['billing_name']),
				':user_id' => $tdata['user_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateUserAddressDetails] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkValidOTP($tdata)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$tdata['email']."' AND `mobile_no` = '".$tdata['mobile_no']."' AND `user_otp` = '".$tdata['user_otp']."' AND `user_deleted` = '0' AND `is_guest_user` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[chkValidOTP] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}	
        return $return;
    }
	
	public function doVerifyOTPForgotPassword($tdata)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `mobile_no` = '".$tdata['mobile_no']."' AND `user_otp` = '".$tdata['user_otp']."' AND `user_deleted` = '0' AND `is_guest_user` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[doVerifyOTPForgotPassword] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}	
        return $return;
    }
	
	public function doVerifyOTP($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		if($this->chkValidOTP($tdata))
		{
			try {
				$sql = "UPDATE `tblusers` SET 
						`user_status` = :user_status,
						`user_modified_date` = :user_modified_date
						WHERE `mobile_no` = :mobile_no AND `user_deleted` = :user_deleted AND `email` = :email ";
				$STH = $DBH->prepare($sql);
				$STH->execute(array(
					':user_status' => 1,
					':user_modified_date' => date('Y-m-d H:i:s'),
					':mobile_no' => addslashes($tdata['mobile_no']),
					':user_deleted' => 0,
					':email' => addslashes($tdata['email'])
				));
				$DBH->commit();
				
				$return = true;
			} catch (Exception $e) {
				$stringData = '[doVerifyOTP] Catch Error:'.$e->getMessage();
				$this->debuglog($stringData);
				return false;
			}	
		}
		
		
        return $return;
    }
	
	public function reSendOTP($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`user_otp` = :user_otp
					WHERE `mobile_no` = :mobile_no AND `user_deleted` = :user_deleted ";
			$STH = $DBH->prepare($sql);
			$STH->execute(array(
				':user_otp' => addslashes($tdata['user_otp']),
				':mobile_no' => addslashes($tdata['mobile_no']),
				':user_deleted' => 0
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[reSendOTP] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
			return false;
		}	
		
        return $return;
    }
	
	public function genrateInvoiceNumber($user_id)
	{
		$invoice = '';
		
		if(strlen($user_id) == 1)
		{
			$user_id = '000'.$user_id;
		}
		elseif(strlen($user_id) == 2)
		{
			$user_id = '00'.$user_id;
		}
		elseif(strlen($user_id) == 3)
		{
			$user_id = '0'.$user_id;
		}
		else
		{
			$user_id = $user_id;
		}
		
		$invoice = 'TOS'.date('ymdHi').rand(100,999).$user_id;
		
		return $invoice;
	}
	
	public function getCountryName($country_id)
	{
		$DBH = new DatabaseHandler();
        $country_name = '';

		try {
			$sql = "SELECT `country_name` FROM `tblcountry` WHERE `country_id`= '".$country_id."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$country_name = stripslashes($r['country_name']);
			}
		} catch (Exception $e) {
			$stringData = '[getCountryName] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}	
        return $country_name;
	}
	
	public function getStateName($state_id)
	{
		$DBH = new DatabaseHandler();
        $state_name = '';

		try {
			$sql = "SELECT `state_name` FROM `tblstates` WHERE `state_id`= '".$state_id."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$state_name = stripslashes($r['state_name']);
			}
		} catch (Exception $e) {
			$stringData = '[getStateName] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}	
        return $state_name;
	}
	
	public function getCityName($city_id)
	{
		$DBH = new DatabaseHandler();
        $city_name = '';

		try {
			$sql = "SELECT `city_name` FROM `tblcities` WHERE `city_id`= '".$city_id."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$city_name = stripslashes($r['city_name']);
			}
		} catch (Exception $e) {
			$stringData = '[getCityName] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}	
        return $city_name;
	}
	
	public function getAreaName($area_id)
	{
		$DBH = new DatabaseHandler();
        $area_name = '';

		try {
			$sql = "SELECT `area_name` FROM `tblarea` WHERE `area_id`= '".$area_id."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$area_name = stripslashes($r['area_name']);
			}
		} catch (Exception $e) {
			$stringData = '[getAreaName] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}	
        return $area_name;
	}
	
	public function getPincodeOfArea($area_id)
	{
		$DBH = new DatabaseHandler();
        $area_pincode = '';

		try {
			$sql = "SELECT `area_pincode` FROM `tblarea` WHERE `area_id`= '".$area_id."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$area_pincode = stripslashes($r['area_pincode']);
			}
		} catch (Exception $e) {
			$stringData = '[getPincodeOfArea] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}	
        return $area_pincode;
	}
	
	public function addOrderCart($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblordercart` (`order_id`,`invoice`,`cart_session_id`,`order_status`,`payment_status`,`user_id`,`prod_id`,`prod_name`,
					`prod_image`,`prod_qty`,`prod_amt`,`prod_subtotal`,`prod_currency_id`,`prod_currency`,`prod_ordering_type_id`,`prod_ordering_type`,
					`prod_ordering_size_id`,`prod_ordering_size`,`item_last_qty`,`order_cart_add_date`,`order_cart_delivery_date`,`order_cart_city_id`,
					`order_cart_area_id`,`is_offer`,`offer_price`,`prod_cgst_tax_amount`,`prod_cgst_tax_percentage`,`prod_sgst_tax_amount`,`prod_sgst_tax_percentage`,`prod_cess_tax_amount`,`prod_cess_tax_percentage`,`prod_gst_tax_amount`,`prod_gst_tax_percentage`) 
					VALUES (:order_id,:invoice,:cart_session_id,:order_status,:payment_status,:user_id,:prod_id,:prod_name,
					:prod_image,:prod_qty,:prod_amt,:prod_subtotal,:prod_currency_id,:prod_currency,:prod_ordering_type_id,:prod_ordering_type,
					:prod_ordering_size_id,:prod_ordering_size,:item_last_qty,:order_cart_add_date,:order_cart_delivery_date,:order_cart_city_id,
					:order_cart_area_id,:is_offer,:offer_price,:prod_cgst_tax_amount,:prod_cgst_tax_percentage,:prod_sgst_tax_amount,:prod_sgst_tax_percentage,:prod_cess_tax_amount,:prod_cess_tax_percentage,:prod_gst_tax_amount,:prod_gst_tax_percentage)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':order_id' => addslashes($tdata['order_id']),
				':invoice' => addslashes($tdata['invoice']),
				':cart_session_id' => addslashes($tdata['cart_session_id']),
				':order_status' => addslashes($tdata['order_status']),
				':payment_status' => addslashes($tdata['payment_status']),
				':user_id' => addslashes($tdata['user_id']),
				':prod_id' => addslashes($tdata['prod_id']),
				':prod_name' => addslashes($tdata['prod_name']),
				':prod_image' => addslashes($tdata['prod_image']),
				':prod_qty' => addslashes($tdata['prod_qty']),
				':prod_amt' => addslashes($tdata['prod_amt']),
				':prod_subtotal' => addslashes($tdata['prod_subtotal']),
				':prod_currency_id' => addslashes($tdata['prod_currency_id']),
				':prod_currency' => addslashes($tdata['prod_currency']),
				':prod_ordering_type_id' => addslashes($tdata['prod_ordering_type_id']),
				':prod_ordering_type' => addslashes($tdata['prod_ordering_type']),
				':prod_ordering_size_id' => addslashes($tdata['prod_ordering_size_id']),
				':prod_ordering_size' => addslashes($tdata['prod_ordering_size']),
				':item_last_qty' => addslashes($tdata['item_last_qty']),
				':order_cart_add_date' => date('Y-m-d H:i:s'),
				':order_cart_delivery_date' => addslashes($tdata['order_cart_delivery_date']),
				':order_cart_city_id' => addslashes($tdata['order_cart_city_id']),
				':order_cart_area_id' => addslashes($tdata['order_cart_area_id']),
				':is_offer' => addslashes($tdata['is_offer']),
				':offer_price' => addslashes($tdata['offer_price']),
				':prod_cgst_tax_amount' => addslashes($tdata['prod_cgst_tax_amount']),
				':prod_cgst_tax_percentage' => addslashes($tdata['prod_cgst_tax_percentage']),
				':prod_sgst_tax_amount' => addslashes($tdata['prod_sgst_tax_amount']),
				':prod_sgst_tax_percentage' => addslashes($tdata['prod_sgst_tax_percentage']),
				':prod_cess_tax_amount' => addslashes($tdata['prod_cess_tax_amount']),
				':prod_cess_tax_percentage' => addslashes($tdata['prod_cess_tax_percentage']),
				':prod_gst_tax_amount' => addslashes($tdata['prod_gst_tax_amount']),
				':prod_gst_tax_percentage' => addslashes($tdata['prod_gst_tax_percentage'])
			));
			$order_cart_id = $DBH->lastInsertId();
			$DBH->commit();
			
			if($order_cart_id > 0)
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[addOrderCart] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function createOrder($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblorders` (`invoice`,`cart_session_id`,`order_status`,`payment_status`,`user_id`,`user_name`,`user_email`,`user_mobile_no`,
					`user_building_name`,`user_floor_no`,`user_address`,`user_landmark`,`user_country_id`,`user_country_name`,`user_state_id`,`user_state_name`,
					`user_city_id`,`user_city_name`,`user_area_id`,`user_area_name`,`user_delivery_mobile_no`,`user_pincode`,
					`billing_building_name`,`billing_floor_no`,`billing_address`,`billing_landmark`,`billing_country_id`,`billing_country_name`,`billing_state_id`,`billing_state_name`,
					`billing_city_id`,`billing_city_name`,`billing_area_id`,`billing_area_name`,`billing_mobile_no`,`billing_pincode`,
					`order_subtotal`,`order_trade_discount`,`order_discount`,`order_tax`,`order_shipping_amt`,`order_total_amt`,`order_add_date`,`order_delivery_date`,`order_city_id`,`order_area_id`,`order_discount_coupon`,`delivery_name`,`billing_name`,`order_cgst_tax_amount`,`order_sgst_tax_amount`,`order_cess_tax_amount`,`order_gst_tax_amount`) 
					VALUES (:invoice,:cart_session_id,:order_status,:payment_status,:user_id,:user_name,:user_email,:user_mobile_no,
					:user_building_name,:user_floor_no,:user_address,:user_landmark,:user_country_id,:user_country_name,:user_state_id,:user_state_name,
					:user_city_id,:user_city_name,:user_area_id,:user_area_name,:user_delivery_mobile_no,:user_pincode,
					:billing_building_name,:billing_floor_no,:billing_address,:billing_landmark,:billing_country_id,:billing_country_name,:billing_state_id,:billing_state_name,
					:billing_city_id,:billing_city_name,:billing_area_id,:billing_area_name,:billing_mobile_no,:billing_pincode,
					:order_subtotal,:order_trade_discount,:order_discount,:order_tax,:order_shipping_amt,:order_total_amt,:order_add_date,:order_delivery_date,:order_city_id,:order_area_id,:order_discount_coupon,:delivery_name,:billing_name,:order_cgst_tax_amount,:order_sgst_tax_amount,:order_cess_tax_amount,:order_gst_tax_amount)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':invoice' => addslashes($tdata['invoice']),
				':cart_session_id' => addslashes($tdata['cart_session_id']),
				':order_status' => addslashes($tdata['order_status']),
				':payment_status' => addslashes($tdata['payment_status']),
				':user_id' => addslashes($tdata['user_id']),
				':user_name' => addslashes($tdata['user_name']),
				':user_email' => addslashes($tdata['user_email']),
				':user_mobile_no' => addslashes($tdata['user_mobile_no']),
				':user_building_name' => addslashes($tdata['user_building_name']),
				':user_floor_no' => addslashes($tdata['user_floor_no']),
				':user_address' => addslashes($tdata['user_address']),
				':user_landmark' => addslashes($tdata['user_landmark']),
				':user_country_id' => addslashes($tdata['user_country_id']),
				':user_country_name' => addslashes($tdata['user_country_name']),
				':user_state_id' => addslashes($tdata['user_state_id']),
				':user_state_name' => addslashes($tdata['user_state_name']),
				':user_city_id' => addslashes($tdata['user_city_id']),
				':user_city_name' => addslashes($tdata['user_city_name']),
				':user_area_id' => addslashes($tdata['user_area_id']),
				':user_area_name' => addslashes($tdata['user_area_name']),
				':user_delivery_mobile_no' => addslashes($tdata['user_delivery_mobile_no']),
				':user_pincode' => addslashes($tdata['user_pincode']),
				':billing_building_name' => addslashes($tdata['billing_building_name']),
				':billing_floor_no' => addslashes($tdata['billing_floor_no']),
				':billing_address' => addslashes($tdata['billing_address']),
				':billing_landmark' => addslashes($tdata['billing_landmark']),
				':billing_country_id' => addslashes($tdata['billing_country_id']),
				':billing_country_name' => addslashes($tdata['billing_country_name']),
				':billing_state_id' => addslashes($tdata['billing_state_id']),
				':billing_state_name' => addslashes($tdata['billing_state_name']),
				':billing_city_id' => addslashes($tdata['billing_city_id']),
				':billing_city_name' => addslashes($tdata['billing_city_name']),
				':billing_area_id' => addslashes($tdata['billing_area_id']),
				':billing_area_name' => addslashes($tdata['billing_area_name']),
				':billing_mobile_no' => addslashes($tdata['billing_mobile_no']),
				':billing_pincode' => addslashes($tdata['billing_pincode']),
				':order_subtotal' => addslashes($tdata['order_subtotal']),
				':order_trade_discount' => addslashes($tdata['order_trade_discount']),
				':order_discount' => addslashes($tdata['order_discount']),
				':order_tax' => addslashes($tdata['order_tax']),
				':order_shipping_amt' => addslashes($tdata['order_shipping_amt']),
				':order_total_amt' => addslashes($tdata['order_total_amt']),
				':order_add_date' => date('Y-m-d H:i:s'),
				':order_delivery_date' => addslashes($tdata['cart'][0]['cart_delivery_date']),
				':order_city_id' => addslashes($tdata['cart'][0]['cart_city_id']),
				':order_area_id' => addslashes($tdata['cart'][0]['cart_area_id']),
				':order_discount_coupon' => addslashes($tdata['order_discount_coupon']),
				':delivery_name' => addslashes($tdata['delivery_name']),
				':billing_name' => addslashes($tdata['billing_name']),
				':order_cgst_tax_amount' => addslashes($tdata['order_cgst_tax_amount']),
				':order_sgst_tax_amount' => addslashes($tdata['order_sgst_tax_amount']),
				':order_cess_tax_amount' => addslashes($tdata['order_cess_tax_amount']),
				':order_gst_tax_amount' => addslashes($tdata['order_gst_tax_amount'])
			));
			$order_id = $DBH->lastInsertId();
			$DBH->commit();
			
			if($order_id > 0)
			{
				$return = true;
				if(count($tdata['cart']) > 0)
				{
					for($i=0;$i<count($tdata['cart']);$i++)
					{
						$tdata_cart = array();
						$tdata_cart['order_id'] = $order_id;
						$tdata_cart['invoice'] = $tdata['invoice'];
						$tdata_cart['cart_session_id'] = $tdata['cart_session_id'];
						$tdata_cart['order_status'] = $tdata['order_status'];
						$tdata_cart['payment_status'] = $tdata['payment_status'];
						$tdata_cart['user_id'] = $tdata['user_id'];
						$tdata_cart['prod_id'] = $tdata['cart'][$i]['prod_id'];
						$tdata_cart['prod_name'] = $tdata['cart'][$i]['prod_name'];
						$tdata_cart['prod_image'] = $tdata['cart'][$i]['prod_image'];
						$tdata_cart['prod_qty'] = $tdata['cart'][$i]['prod_qty'];
						$tdata_cart['prod_amt'] = $tdata['cart'][$i]['prod_amt'];
						$tdata_cart['prod_subtotal'] = $tdata['cart'][$i]['prod_subtotal'];
						$tdata_cart['prod_currency_id'] = $tdata['cart'][$i]['prod_currency_id'];
						$tdata_cart['prod_currency'] = $tdata['cart'][$i]['prod_currency'];
						$tdata_cart['prod_ordering_type_id'] = $tdata['cart'][$i]['prod_ordering_type_id'];
						$tdata_cart['prod_ordering_type'] = $tdata['cart'][$i]['prod_ordering_type'];
						$tdata_cart['prod_ordering_size_id'] = $tdata['cart'][$i]['prod_ordering_size_id'];
						$tdata_cart['prod_ordering_size'] = $tdata['cart'][$i]['prod_ordering_size'];
						$tdata_cart['item_last_qty'] = $tdata['cart'][$i]['item_last_qty'];
						$tdata_cart['order_cart_delivery_date'] = $tdata['cart'][$i]['cart_delivery_date'];
						$tdata_cart['order_cart_city_id'] = $tdata['cart'][$i]['cart_city_id'];
						$tdata_cart['order_cart_area_id'] = $tdata['cart'][$i]['cart_area_id'];
						$tdata_cart['is_offer'] = $tdata['cart'][$i]['is_offer'];
						$tdata_cart['offer_price'] = $tdata['cart'][$i]['offer_price'];
						$tdata_cart['prod_cgst_tax_amount'] = $tdata['cart'][$i]['prod_cgst_tax_amount'];
						$tdata_cart['prod_cgst_tax_percentage'] = $tdata['cart'][$i]['prod_cgst_tax_percentage'];
						$tdata_cart['prod_sgst_tax_amount'] = $tdata['cart'][$i]['prod_sgst_tax_amount'];
						$tdata_cart['prod_sgst_tax_percentage'] = $tdata['cart'][$i]['prod_sgst_tax_percentage'];
						$tdata_cart['prod_cess_tax_amount'] = $tdata['cart'][$i]['prod_cess_tax_amount'];
						$tdata_cart['prod_cess_tax_percentage'] = $tdata['cart'][$i]['prod_cess_tax_percentage'];
						$tdata_cart['prod_gst_tax_amount'] = $tdata['cart'][$i]['prod_gst_tax_amount'];
						$tdata_cart['prod_gst_tax_percentage'] = $tdata['cart'][$i]['prod_gst_tax_percentage'];
						$this->addOrderCart($tdata_cart);		
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[createOrder] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	
	public function getOrderDetailsByInvoice($invoice)
    {
        $DBH = new DatabaseHandler();
		$arr_record = array();

		try {	
			$sql = "SELECT * FROM `tblorders` WHERE `invoice` = '".$invoice."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$arr_record = $r;
			}
		} catch (Exception $e) {
			$stringData = '[getOrderDetailsByInvoice] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
	
	public function getOrderCartDetailsByInvoice($invoice)
    {
        $DBH = new DatabaseHandler();
		$arr_record = array();

		try {	
			$sql = "SELECT * FROM `tblordercart` WHERE `invoice` = '".$invoice."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{
					//foreach($r as $key1 => $val1)
					//{
						//$r[$key1] = stripslashes($val1);
					//}
					$arr_record[] = $r;	
				}
			}
		} catch (Exception $e) {
			$stringData = '[getOrderCartDetailsByInvoice] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
	
	public function updateOrderPaymentStatus($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblorders` SET 
					`order_status` = :order_status,
					`payment_status` = :payment_status,
					`ebs_trans_id` = :ebs_trans_id,
					`ebs_payment_id` = :ebs_payment_id,  
					`ebs_response_code` = :ebs_response_code,  
					`ebs_response_msg` = :ebs_response_msg,  
					`ebs_date` = :ebs_date,  
					`ebs_payment_method` = :ebs_payment_method,  
					`ebs_request_id` = :ebs_request_id,
					`ebs_secure_hash` = :ebs_secure_hash,
					`ebs_is_flagged` = :ebs_is_flagged,
					`order_payment_date` = :order_payment_date
					WHERE `invoice` = :invoice ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':order_status' => addslashes($tdata['order_status']),
				':payment_status' => addslashes($tdata['payment_status']),
				':ebs_trans_id' => addslashes($tdata['ebs_trans_id']),
				':ebs_payment_id' => addslashes($tdata['ebs_payment_id']),
				':ebs_response_code' => addslashes($tdata['ebs_response_code']),
				':ebs_response_msg' => addslashes($tdata['ebs_response_msg']),
				':ebs_date' => addslashes($tdata['ebs_date']),
				':ebs_payment_method' => addslashes($tdata['ebs_payment_method']),
				':ebs_request_id' => addslashes($tdata['ebs_request_id']),
				':ebs_secure_hash' => addslashes($tdata['ebs_secure_hash']),
				':ebs_is_flagged' => addslashes($tdata['ebs_is_flagged']),
				':order_payment_date' => date('Y-m-d H:i:s'),
				':invoice' => $tdata['invoice']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateOrderPaymentStatus] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function removeAllItemsFromCart()
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		$cart_session_id = session_id();
		
		try {
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
					
						
			$sql = "UPDATE `tblcart` SET 
					`cart_status` = :cart_status,
					`cart_deleted` = :cart_deleted,
					`cart_deleted_date` = :cart_deleted_date
					WHERE 
					`cart_session_id` = :cart_session_id  AND 
					`cart_city_id` = :cart_city_id  AND 
					`cart_deleted` = '0' ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cart_status' => '1',
				':cart_deleted' => '1',
				':cart_deleted_date' => date('Y-m-d H:i:s'),
				':cart_session_id' => $cart_session_id,
				':cart_city_id' => $topcityid
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[removeAllItemsFromCart] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function sendInvoiceEmailToCustomer($invoice)
	{
		$arr_order_details = $this->getOrderDetailsByInvoice($invoice);
		
		$from_email = 'support@tastes-of-states.com';
		$from_name = 'Tastes of States';
		$subject = "Order placed successfully for Invoice - ".$invoice;
					
		$emailHTML = $this->getOrderInvoiceHtml($invoice);
		
		$to_email  = $arr_order_details['user_email'];
		
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		$mail->Host = "batmobile.websitewelcome.com"; // SMTP server
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to_email);
		$mail->Subject = $subject;
		$mail->Body = $emailHTML;
		$mail->Send();
		$mail->ClearAddresses();	
	}
	
	public function sendSignUpEmailToCustomer($email)
	{
		$user_id = $this->getUserId($email);
        if($user_id > 0)
        {
			$fname = $this->getUserFirstNameById($user_id);
			
			$from_email = 'support@tastes-of-states.com';
			$from_name = 'Tastes of States';
			$subject = "Welcome to Tastes of States";
						
			$emailHTML = '';
			$emailHTML .= '<p>Dear '.$fname.'</p>';
			$emailHTML .= '<p>Your profile is successfully created at Tastes of states.</p>';
			$emailHTML .= '<p>Thanks and Regards</p>';
			$emailHTML .= '<p>Team Tastes of states</p>';
			
			$to_email  = $email;
			
			$mail = new PHPMailer();
			$mail->IsHTML(true);
			$mail->Host = "batmobile.websitewelcome.com"; // SMTP server
			$mail->From = $from_email;
			$mail->FromName = $from_name;
			$mail->AddAddress($to_email);
			$mail->Subject = $subject;
			$mail->Body = $emailHTML;
			$mail->Send();
			$mail->ClearAddresses();	
		}
		
		
	}
	
	public function sendContactUsEmailToCustomer($tdata)
	{
		$fname = $tdata['contactus_name'];
		$email = $tdata['contactus_email'];
		
		$from_email = 'support@tastes-of-states.com';
		$from_name = 'Tastes of States';
		$subject = "Thank you for your enquiry";
					
		$emailHTML = '';
		$emailHTML .= '<p>Dear '.$fname.'</p>';
		$emailHTML .= '<p>Thank you for your enquiry. We will get back to you soon.</p>';
		$emailHTML .= '<p>Thanks and Regards</p>';
		$emailHTML .= '<p>Team Tastes of states</p>';
		
		$to_email  = $email;
		
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		$mail->Host = "batmobile.websitewelcome.com"; // SMTP server
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to_email);
		$mail->Subject = $subject;
		$mail->Body = $emailHTML;
		$mail->Send();
		$mail->ClearAddresses();	
		
	}
	
	public function chkIfItemCaneBeCancelled($invoice,$prod_id,$cart_delivery_date)
	{
		$return = false;
		$arr_order_details = $this->getOrderDetailsByInvoice($invoice);
		//echo '<br>order_status:'.$arr_order_details['order_status'];
		if($arr_order_details['order_status'] == '1' || $arr_order_details['order_status'] == '2')
		{
			
			$arr_cusine_details = $this->getCusineDetailsForCart($prod_id);
			//echo'<br><pre>';
			//print_r($arr_cusine_details);
			//echo'<br></pre>';
			//echo '<br>cancel_cuttoff_time:'.$arr_cusine_details['cancel_cutoff_time'];
			if($arr_cusine_details['cancel_cutoff_time'] != '' && $arr_cusine_details['cancel_cutoff_time'] > 0)
			{
				if($cart_delivery_date != '' && $cart_delivery_date != '0000-00-00')
				{
					//echo '<br>cart_delivery_date:'.$cart_delivery_date;
					$date = date( 'Y-m-d', strtotime( $cart_delivery_date ) );
					$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
					$current_showing_date_time = $one_day_before_current_showing_date. ' 23:00:00';
					$timestamp_csdt = strtotime($current_showing_date_time);
					
					$sec_cuttoff_time = $arr_cusine_details['cancel_cutoff_time'] * 3600;
					
					$final_compared_timestamp = $timestamp_csdt - $sec_cuttoff_time;
					$now = time();
					if($now < $final_compared_timestamp)
					{
						$return = true;	
					}	
				}
			}
		}
		
		return $return;
	}
	
	public function getOrderInvoiceHtml($invoice,$show_cancel_btn_status='',$is_admin='')
	{
		$arr_order_details = $this->getOrderDetailsByInvoice($invoice);
		$arr_order_cart_details = $this->getOrderCartDetailsByInvoice($invoice);
		
		/*
		if($arr_order_details['order_delivery_date'] != '0000-00-00') 
		{
			$delivery_date = date('d/m/Y',strtotime($arr_order_details['order_delivery_date'])) ;
		}
		else
		{
			$delivery_date = '';
		}
		*/
		$emailHTML = '';
		$emailHTML .= '	<div  style="margin:0px auto; width: 800px; text-align: center;">
							<div style="text-align: center;" ><h2 style="font-weight: 700;text-transform: uppercase;margin-bottom: 5px;color: #000;font-size: 20px;letter-spacing: 0.09em;line-height: 27px;background-color: rgb(203, 202, 202);border-top: 1px solid #000; border-bottom: 2px solid #000;width:100%;">RETAIL INVOICE </h2></div>
							<div style="height: 50px; margin: 5px;width:100%;" >
								<div style="float: left;font-weight: 700; font-size: 15px;  width: 50%;text-align: -webkit-auto;">
									INVOICE NUMBER : '.$invoice.'
								</div> 
								
							</div>	
							<div style="height: 30px; margin: 5px;width:100%;" >	
								<div style="font-weight: 700;font-size: 15px;width:50%;float:left;text-align: -webkit-auto;">
									INVOICE DATE : '.date('d/m/Y',strtotime($arr_order_details['order_add_date'])).'
								</div>';
		/*						
		$emailHTML .= '			<div style="font-weight: 700;font-size: 15px;text-align: -webkit-auto;">
									DELIVERY DATE : '. $delivery_date .'
								</div>';
		*/	

		if($arr_order_details['delivery_name'] == '')
		{
			$delivery_name = stripslashes($arr_order_details['user_name']);		
		}
		else
		{
			$delivery_name = stripslashes($arr_order_details['delivery_name']);	
		}
		
		if($arr_order_details['billing_name'] == '')
		{
			$billing_name = $delivery_name;		
		}
		else
		{
			$billing_name = stripslashes($arr_order_details['billing_name']);	
		}
		
		$emailHTML .= '		</div>
							<table class="table " style="border-bottom:1px solid #000;border-top:1px solid #000;width:100%;">
								<tbody>
									<tr>
										<th  style="background-color: rgb(203, 202, 202);width:50%;font-size: 15px;font-weight: 700;">Billing Details</th>
										<th  style="background-color: rgb(203, 202, 202);width:50%;font-size: 15px;font-weight: 700;">Delivery Details</th>
									</tr>
									<tr>
										<td valign="top" style="valign:top;text-align:left;">
											 <b>Name : '.$billing_name.'</b><br>
												Email : '.$arr_order_details['user_email'].'<br>
												Address : '.$arr_order_details['billing_building_name'].' '.$arr_order_details['billing_floor_no'].' '. $arr_order_details['billing_address'].'<br>
												Area : '.$arr_order_details['billing_area_name'].' <br> 
												City : '.$arr_order_details['billing_city_name'].' <br> 
												State : '.$arr_order_details['billing_state_name'].'<br>
												Country : '.$arr_order_details['billing_country_name'].'<br>
												Pincode : '.$arr_order_details['billing_pincode'].'<br>
												MobileNo : '.$arr_order_details['billing_mobile_no'].'
										</td>
										<td valign="top" style="valign:top;text-align:left;">
											 <b>Name : '.$delivery_name.'</b><br>
												Email : '.$arr_order_details['user_email'].'<br>
												Address : '.$arr_order_details['user_building_name'].' '.$arr_order_details['user_floor_no'].' '. $arr_order_details['user_address'].'<br>
												Area : '.$arr_order_details['user_area_name'].' <br> 
												City : '.$arr_order_details['user_city_name'].' <br> 
												State : '.$arr_order_details['user_state_name'].'<br>
												Country : '.$arr_order_details['user_country_name'].'<br>
												Pincode : '.$arr_order_details['user_pincode'].'<br>
												MobileNo : '.$arr_order_details['user_mobile_no'].'
										</td>
									</tr>
								</tbody>
							</table>
						
							<div style="" >  
							<style>
							table {
								max-width: 100%;
								background-color: transparent;
							}
							th {
								text-align: left;
							}
							.table {
								width: 800px;
								margin-bottom: 20px;
							}
							.table thead > tr > th,
							.table tbody > tr > th,
							.table tfoot > tr > th,
							.table thead > tr > td,
							.table tbody > tr > td,
							.table tfoot > tr > td {
								padding: 8px;
								line-height: 1.428571429;
								vertical-align: top;
								border-top: 1px solid #dddddd;
							}
							.table thead > tr > th {
								vertical-align: bottom;
							}
							.table caption + thead tr:first-child th,
							.table colgroup + thead tr:first-child th,
							.table thead:first-child tr:first-child th,
							.table caption + thead tr:first-child td,
							.table colgroup + thead tr:first-child td,
							.table thead:first-child tr:first-child td {
								border-top: 0;
							}
							.table tbody + tbody {
								border-top: 2px solid #dddddd;
							}
							.table .table {
								background-color: #ffffff;
							}
							.table-condensed thead > tr > th,
							.table-condensed tbody > tr > th,
							.table-condensed tfoot > tr > th,
							.table-condensed thead > tr > td,
							.table-condensed tbody > tr > td,
							.table-condensed tfoot > tr > td {
								padding: 5px;
							}
							.table-bordered {
								border: 1px solid #dddddd;
							}
							.table-bordered > thead > tr > th,
							.table-bordered > tbody > tr > th,
							.table-bordered > tfoot > tr > th,
							.table-bordered > thead > tr > td,
							.table-bordered > tbody > tr > td,
							.table-bordered > tfoot > tr > td {
								border: 1px solid #dddddd;
							}
							.table-striped > tbody > tr:nth-child(odd) > td,
							.table-striped > tbody > tr:nth-child(odd) > th {
								background-color: #f9f9f9;
							}
							.table-hover > tbody > tr:hover > td,
							.table-hover > tbody > tr:hover > th {
								background-color: #f5f5f5;
							}
							table col[class^="col-"] {
								display: table-column;
								float: none;
							}
							table td[class^="col-"],
							table th[class^="col-"] {
								display: table-cell;
								float: none;
							}
							.table > thead > tr > td.active,
							.table > tbody > tr > td.active,
							.table > tfoot > tr > td.active,
							.table > thead > tr > th.active,
							.table > tbody > tr > th.active,
							.table > tfoot > tr > th.active,
							.table > thead > tr.active > td,
							.table > tbody > tr.active > td,
							.table > tfoot > tr.active > td,
							.table > thead > tr.active > th,
							.table > tbody > tr.active > th,
							.table > tfoot > tr.active > th {
								background-color: #f5f5f5;
							}
							.table > thead > tr > td.success,
							.table > tbody > tr > td.success,
							.table > tfoot > tr > td.success,
							.table > thead > tr > th.success,
							.table > tbody > tr > th.success,
							.table > tfoot > tr > th.success,
							.table > thead > tr.success > td,
							.table > tbody > tr.success > td,
							.table > tfoot > tr.success > td,
							.table > thead > tr.success > th,
							.table > tbody > tr.success > th,
							.table > tfoot > tr.success > th {
								background-color: #dff0d8;
								border-color: #d6e9c6;
							}
							.table > thead > tr > td.danger,
							.table > tbody > tr > td.danger,
							.table > tfoot > tr > td.danger,
							.table > thead > tr > th.danger,
							.table > tbody > tr > th.danger,
							.table > tfoot > tr > th.danger,
							.table > thead > tr.danger > td,
							.table > tbody > tr.danger > td,
							.table > tfoot > tr.danger > td,
							.table > thead > tr.danger > th,
							.table > tbody > tr.danger > th,
							.table > tfoot > tr.danger > th {
								background-color: #f2dede;
								border-color: #eed3d7;
							}

							.table > thead > tr > td.warning,
							.table > tbody > tr > td.warning,
							.table > tfoot > tr > td.warning,
							.table > thead > tr > th.warning,
							.table > tbody > tr > th.warning,
							.table > tfoot > tr > th.warning,
							.table > thead > tr.warning > td,
							.table > tbody > tr.warning > td,
							.table > tfoot > tr.warning > td,
							.table > thead > tr.warning > th,
							.table > tbody > tr.warning > th,
							.table > tfoot > tr.warning > th {
								background-color: #fcf8e3;
								border-color: #fbeed5;
							}
							.table-hover > tbody > tr > td.success:hover,
							.table-hover > tbody > tr > th.success:hover,
							.table-hover > tbody > tr.success:hover > td {
								background-color: #d0e9c6;
								border-color: #c9e2b3;
							}
							.table-hover > tbody > tr > td.danger:hover,
							.table-hover > tbody > tr > th.danger:hover,
							.table-hover > tbody > tr.danger:hover > td {
								background-color: #ebcccc;
								border-color: #e6c1c7;
							}
							.table-hover > tbody > tr > td.warning:hover,
							.table-hover > tbody > tr > th.warning:hover,
							.table-hover > tbody > tr.warning:hover > td {
								background-color: #faf2cc;
								border-color: #f8e5be;
							}
							</style>
							<table class="table table-bordered table-striped" style="width: 800px; max-width:100%;">
								<thead>
									<tr>
										<th width="5%">SrNO</th>
										<th width="20%">ITEM</th>
										<th width="10%">Delivery Date</th>
										<th width="10%">QTY</th>
										<th width="10%">UNIT PRICE</th>
										<th width="10%">CGST Amt(%)</th>
										<th width="10%">SGST Amt(%)</th>
										<th width="10%">CESS Amt(%)</th>
										<th width="15%">SUBTOTAL</th>
									</tr>
								</thead>
								<tbody>';
		if(count($arr_order_cart_details) > 0)
		{
			$i = 1; 
			$cnt_cancel_process_done = 0;
			foreach($arr_order_cart_details as $key => $list_records)
			{
				if($list_records['order_cart_delivery_date'] == '' || $list_records['order_cart_delivery_date'] == '0000-00-00')
				{
					$order_cart_delivery_date = '';
				}
				else
				{
					$order_cart_delivery_date =  date('d/m/Y',strtotime($list_records['order_cart_delivery_date']));
				}
				
				if($show_cancel_btn_status == '1')
				{
					if($list_records['cancel_request_sent'] == '1')
					{
						if($is_admin == '1')
						{
							if($list_records['cancel_process_done'] == '1')
							{
								$cnt_cancel_process_done++;
								$str_cancel_btn = '<br><br><a href="javascipt:void(0);" class="btn-green-small-disabled">Cancelled Successfully</a>';
							}
							else
							{
								$str_cancel_btn = '<br><br><a href="javascipt:void(0);" class="btn-green-small-disabled">Cancel Req Sent</a>';	
							}	
						}
						else
						{
							if($list_records['cancel_process_done'] == '1')
							{
								$cnt_cancel_process_done++;
								$str_cancel_btn = '<br><br><a href="javascipt:void(0);" class="btn-green-small-disabled">Cancelled Successfully</a>';
							}
							else
							{
								$str_cancel_btn = '<br><br><a href="javascipt:void(0);" class="btn-green-small-disabled">Cancel Req Sent</a>';	
							}	
						}
					}
					else
					{
						if($is_admin == '1')
						{
							$str_cancel_btn = '<br><br><a href="'.SITE_URL.'/admin/cancel_order.php?invoice='.$list_records['invoice'].'&ocid='.$list_records['order_cart_id'].'" class="btn btn-danger">Cancel Item</a>';	
						}
						else
						{
							if($this->chkIfItemCaneBeCancelled($list_records['invoice'],$list_records['prod_id'],$list_records['order_cart_delivery_date']))
							{
								$str_cancel_btn = '<br><br><a href="'.SITE_URL.'/cancel_order.php?invoice='.$list_records['invoice'].'&ocid='.$list_records['order_cart_id'].'" class="btn-red-small">Cancel Item</a>';	
							}
							else
							{
								$str_cancel_btn = '';	
							}	
						}
							
					}
				}
				else
				{
					if($list_records['cancel_process_done'] == '1')
					{
						$cnt_cancel_process_done++;
					}
					$str_cancel_btn = '';
				}
				
				if($list_records['is_offer'] == '1')
				{
					$price = $list_records['offer_price'];
				}
				else
				{
					$price = $list_records['prod_amt'];
				}
				
				if($list_records['prod_cgst_tax_amount'] != '' && $list_records['prod_cgst_tax_amount'] != '0.00')
				{
					$prod_cgst_tax_amount = 'Rs '.$list_records['prod_cgst_tax_amount'];
					if($list_records['prod_cgst_tax_percentage'] != '')
					{
						$prod_cgst_tax_percentage = $list_records['prod_cgst_tax_percentage'].'%';
						$prod_cgst_tax = $prod_cgst_tax_amount.'('.$prod_cgst_tax_percentage.')';
					}
					else
					{
						$prod_cgst_tax = $prod_cgst_tax_amount;
					}
				}
				else
				{
					$prod_cgst_tax = '';
				}
				
				
				
				if($list_records['prod_sgst_tax_amount'] != '' && $list_records['prod_sgst_tax_amount'] != '0.00')
				{
					$prod_sgst_tax_amount = 'Rs '.$list_records['prod_sgst_tax_amount'];
					if($list_records['prod_sgst_tax_percentage'] != '')
					{
						$prod_sgst_tax_percentage = $list_records['prod_sgst_tax_percentage'].'%';
						$prod_sgst_tax = $prod_sgst_tax_amount.'('.$prod_sgst_tax_percentage.')';
					}
					else
					{
						$prod_sgst_tax = $prod_sgst_tax_amount;
					}
				}
				else
				{
					$prod_sgst_tax = '';
				}
				
				
				
				if($list_records['prod_cess_tax_amount'] != '' && $list_records['prod_cess_tax_amount'] != '0.00')
				{
					$prod_cess_tax_amount = 'Rs '.$list_records['prod_cess_tax_amount'];
					if($list_records['prod_cess_tax_percentage'] != '')
					{
						$prod_cess_tax_percentage = $list_records['prod_cess_tax_percentage'].'%';
						$prod_cess_tax = $prod_cess_tax_amount.'('.$prod_cess_tax_percentage.')';
					}
					else
					{
						$prod_cess_tax_percentage = '';
						$prod_cess_tax = $prod_cess_tax_amount;
					}
				}
				else
				{
					$prod_cess_tax = '';
				}
				
				
				
				$emailHTML .= '     <tr>
										<td>'.$i .'</td>
										<td align="left"><img border="0" height="50" src="'.SITE_URL.'/uploads/'.$list_records['prod_image'].'" alt="'.$list_records['prod_name'].'" >&nbsp;'.$list_records['prod_name'].'</td>
										<td align="left">'.$order_cart_delivery_date.'</td>
										<td align="left">'.$list_records['prod_qty'].'('.$list_records['prod_ordering_size'].')</td>
										<td align="left">Rs '.$price.'</td>
										<td align="left">'.$prod_cgst_tax.'</td>
										<td align="left">'.$prod_sgst_tax.'</td>
										<td align="left">'.$prod_cess_tax.'</td>
										<td align="left">Rs '.$list_records['prod_subtotal'].' '.$str_cancel_btn.'</td>
									</tr>';
				$i++;
			}
		}
		else
		{ 
			$emailHTML .= '			<tr><td colspan="9">No Records Found</td></tr>   '; 
		} 
		$emailHTML .= '  		</tbody>
								<tfoot>
									<tr>
										<td colspan="6" align="right" class="text-right"><strong>Sub Total :</strong></td>
										<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_subtotal']), 2, ".", ",").'</td>
									</tr>';
							
		
			$emailHTML .= ' 	<td colspan="6" align="right" class="text-right"><strong>Shipping Charges :</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_shipping_amt']), 2, ".", ",").'</td>
							</tr>';
							
			
			//if($arr_order_details['order_trade_discount'] != '')
			//{
				$emailHTML .= '	<tr> 
								<td colspan="6" align="right" class="text-right"><strong>Trade Discount:</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_trade_discount']), 2, ".", ",").'</td>
							</tr>
							<tr>';
			//}
			
			
			$coupon_str = '';				
			if($arr_order_details['order_discount_coupon'] != '')
			{
				$coupon_str = ' (Coupon Redeemed: '.$arr_order_details['order_discount_coupon'].') ';
			}

				
							
			$emailHTML .= '	<tr> 
								<td colspan="6" align="right" class="text-right"><strong>Promo Discount'.$coupon_str.':</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_discount']), 2, ".", ",").'</td>
							</tr>
							<tr>';
							
			if($arr_order_details['order_cgst_tax_amount'] != '' && $arr_order_details['order_cgst_tax_amount'] != '0.00' && $arr_order_details['order_cgst_tax_amount'] != '0')
			{
				$emailHTML .= '	<tr> 
								<td colspan="6" align="right" class="text-right"><strong>CGST:</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_cgst_tax_amount']), 2, ".", ",").'</td>
							</tr>
							<tr>';
			}

			if($arr_order_details['order_sgst_tax_amount'] != '' && $arr_order_details['order_sgst_tax_amount'] != '0.00' && $arr_order_details['order_sgst_tax_amount'] != '0')
			{
				$emailHTML .= '	<tr> 
								<td colspan="6" align="right" class="text-right"><strong>SGST:</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_sgst_tax_amount']), 2, ".", ",").'</td>
							</tr>
							<tr>';
			}

			if($arr_order_details['order_cess_tax_amount'] != '' && $arr_order_details['order_cess_tax_amount'] != '0.00' &&$arr_order_details['order_cess_tax_amount'] != '0')
			{
				$emailHTML .= '	<tr> 
								<td colspan="6" align="right" class="text-right"><strong>CESS:</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_cess_tax_amount']), 2, ".", ",").'</td>
							</tr>
							<tr>';
			}	
			
			$emailHTML .= '	<tr> 
								<td colspan="6" align="right" class="text-right"><strong>Total Tax:</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_tax']), 2, ".", ",").'</td>
							</tr>
							<tr>';				
							
			$emailHTML .= ' 	<td colspan="6" align="right" class="text-right"><strong>Total :</strong></td>
								<td colspan="3" align="right" >'.'Rs. '.number_format(floatval($arr_order_details['order_total_amt']), 2, ".", ",").'</td>
							</tr>
						</tfoot>
					</table>
				</div>';
			
		
		if($cnt_cancel_process_done > 0)
		{
			
			$arr_cancel_order_cart_details = $this->getCancellationProcessedOrderCartDetailsByInvoice($invoice);						
			if(count($arr_cancel_order_cart_details) > 0)
			{
				$emailHTML .= '<p style="width: 800px;text-align:center; max-width:100%;font-size:16px;padding:10px 0px;font-weight:bold;">Credit Note</p>
							<p style="width: 800px;text-align:center; max-width:100%;font-size:16px;padding:10px 0px;font-weight:bold;">Credit Invoice No:'.$invoice.'-001</p>
							<table class="table table-bordered table-striped" style="width: 800px; max-width:100%;">
								<thead>
									<tr>
										<th width="5%">SrNO</th>
										<th width="30%">ITEM</th>
										<th width="20%">Cancellation Reason</th>
										<th width="15%">Cancellation Date</th>
										<th width="15%">Subtotal</th>
										<th width="15%">Cancellation Charge</th>
										<th width="15%">Refund Amount</th>
									</tr>
								</thead>
								<tbody>';
				$i = 1; 
				$total_refund_amount = 0.00;
				foreach($arr_cancel_order_cart_details as $key => $list_records)
				{
					
					$cancellation_reason_str = '';
					if($list_records['cancel_cat_id'] == '221')
					{
						$cancellation_reason_str = 'Other Reason: '.$list_records['cancel_cat_other'];	
					}
					else
					{
						$cancellation_reason_str = $this->getCategoryName($list_records['cancel_cat_id']);
					}
					
					if($list_records['cancel_comments'] != '')
					{
						$cancellation_reason_str .= '<br><br> Additional information: '.$list_records['cancel_comments'];	
					}
					
					if($list_records['cancel_process_date'] == '' || $list_records['cancel_process_date'] == '0000-00-00')
					{
						$cancel_process_date = '';
					}
					else
					{
						$cancel_process_date =  date('d/m/Y',strtotime($list_records['cancel_process_date']));
					}
					
					$refund_amount = $list_records['prod_subtotal'] - $list_records['prod_cancel_subtotal'];
					$total_refund_amount += $refund_amount;
					$emailHTML .= '     <tr>
											<td>'.$i .'</td>
											<td align="left"><img border="0" height="50" src="'.SITE_URL.'/uploads/'.$list_records['prod_image'].'" alt="'.$list_records['prod_name'].'" >&nbsp;'.$list_records['prod_name'].'</td>
											<td align="left">'.$cancellation_reason_str.'</td>
											<td align="left">'.$cancel_process_date.'</td>
											<td align="left">Rs '.$list_records['prod_subtotal'].'</td>
											<td align="left">Rs '.$list_records['prod_cancel_subtotal'].'</td>
											<td align="left">Rs '.$refund_amount.'</td>
										</tr>';
					$i++;
				}
				
				if($arr_cancel_order_cart_details[0]['cp_sp_amount'] == '')
				{
					$total_cp_sp_amount = 0.00;
				}
				else
				{
					$total_cp_sp_amount = 0.00 + $arr_cancel_order_cart_details[0]['cp_sp_amount'];
				}
				
				if($arr_cancel_order_cart_details[0]['cp_tax_amount'] == '')
				{
					$total_cp_tax_amount = 0.00;
				}
				else
				{
					$total_cp_tax_amount = 0.00 + $arr_cancel_order_cart_details[0]['cp_tax_amount'];
				}
				
				$final_refund_amount = $total_refund_amount + $total_cp_sp_amount + $total_cp_tax_amount;
				
				$emailHTML .= '  		</tbody>
									<tfoot>
										<tr>
											<td colspan="5" align="right" class="text-right"><strong>Sub Total :</strong></td>
											<td align="right" colspan="2" >'.'Rs. '.number_format(floatval($total_refund_amount), 2, ".", ",").'</td>
										</tr>';
								
		
				$emailHTML .= ' 	<td colspan="5" align="right" class="text-right"><strong>Shipping Charges :</strong></td>
								<td align="right" colspan="2" >'.'Rs. '.number_format(floatval($total_cp_sp_amount), 2, ".", ",").'</td>
							</tr>';
							
				$emailHTML .= '	<tr> 
								<td colspan="5" align="right" class="text-right"><strong>Tax:</strong></td>
								<td align="right" colspan="2" >'.'Rs. '.number_format(floatval($total_cp_tax_amount), 2, ".", ",").'</td>
							</tr>
							<tr>';				
							
				$emailHTML .= ' 	<td colspan="5" align="right" class="text-right"><strong>Total Refund:</strong></td>
								<td align="right" colspan="2" >'.'Rs. '.number_format(floatval($final_refund_amount), 2, ".", ",").'</td>
							</tr>
						</tfoot>
					</table>';
			}		
		}
		
		
		
		
		$emailHTML .= '<hr width="800px"/>
				<div style="height: 20px; margin: 5px;width:800px;">
					<div style="float: left; font-size: 15px;text-align: -webkit-auto;">
						<b>THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE SIGNATURE</b>
					</div> 
				</div> 
				<hr style="border-top-width: 4px;">
				<div style="height: 20px; margin: 5px;width:800px;">
					<div style="float: right; font-size: 15px;text-align: -webkit-auto;">
						ordered via <b style="font-size: 1.3em;"> www.tastes-of-states.com </b>
					</div> 
				</div>
			</div>';
			
					
			
		return $emailHTML;
	}
	
	public function getCancellationProcessedOrderCartDetailsByInvoice($invoice)
    {
        $DBH = new DatabaseHandler();
		$arr_record = array();

		try {	
			$sql = "SELECT * FROM `tblordercart` WHERE `invoice` = '".$invoice."' AND `cancel_request_sent` = '1'  AND `cancel_process_done` = '1' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{
					$arr_record[] = $r;	
				}
			}
		} catch (Exception $e) {
			$stringData = '[getCancellationProcessedOrderCartDetailsByInvoice] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
	
	public function updateProdQtyAfterOrderPlaced($invoice)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$arr_order_cart_details = $this->getOrderCartDetailsByInvoice($invoice);
		if(count($arr_order_cart_details) > 0)
		{
			for($i=0;$i<count($arr_order_cart_details);$i++)
			{
				$old_cusine_qty = $this->getCusineCurrentStockQty($arr_order_cart_details[$i]['prod_id']);
				$this->debuglog('[updateProdQtyAfterOrderPlaced] invoice:'.$invoice.', cusine_id:'.$arr_order_cart_details[$i]['prod_id'].', old_cusine_qty:'.$old_cusine_qty);
				if($old_cusine_qty > 0)
				{
					$cusine_qty = $old_cusine_qty - $arr_order_cart_details[$i]['prod_qty'];
					$this->debuglog('[updateProdQtyAfterOrderPlaced] invoice:'.$invoice.', cusine_id:'.$arr_order_cart_details[$i]['prod_id'].', old_cusine_qty:'.$old_cusine_qty.', prod_qty:'.$arr_order_cart_details[$i]['prod_qty']);
					try {
						$sql = "UPDATE `tblcusinelocations` SET cusine_qty = '".$cusine_qty."'  WHERE `cusine_id` = '".$arr_order_cart_details[$i]['prod_id']."' AND `default_price` = '1'  AND `culoc_deleted` = '0' ";
						$this->debuglog('[updateProdQtyAfterOrderPlaced] sql:'.$sql);
						$STH = $DBH->query($sql);
						if( $STH->rowCount() > 0 )
						{
							$return = true;
						}		
					} catch (Exception $e) {
						$stringData = '[updateProdQtyAfterOrderPlaced] Catch Error:'.$e->getMessage().', sql:'.$sql;
						$this->debuglog($stringData);
					}	
				}
					
			}
		}
		return $return;
    }
	
	public function getAllPublishedBannerSliders($city_id,$area_id='',$current_showing_date='')
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		if($current_showing_date == '')
		{
			$current_showing_date =date('Y-m-d');
		}
		
		$today_day_of_month = date('j',strtotime($current_showing_date));
		$today_day_of_week = date('N',strtotime($current_showing_date));
		$today_single_date = date('Y-m-d',strtotime($current_showing_date));
		
		$cnt = 0;
		try {
			
			if($area_id == '' || $area_id == '-1')
			{
				$sql = "SELECT * FROM `tblbanners` 
					WHERE ( 
						( banner_city_id = '".$city_id."' ) OR 
						( FIND_IN_SET(".$city_id.", banner_city_id) > 0 ) OR
						( banner_city_id = '-1' AND banner_state_id = '".$state_id."' ) OR 
						( banner_city_id = '-1' AND FIND_IN_SET(".$state_id.", banner_state_id) > 0 ) OR 
						( banner_city_id = '-1' AND banner_state_id = '-1' AND banner_country_id = '".$country_id."' ) OR 
						( banner_city_id = '-1' AND banner_state_id = '-1' AND FIND_IN_SET(".$country_id.", banner_country_id) > 0  ) OR 
						( banner_city_id = '-1' AND banner_state_id = '-1' AND banner_country_id = '-1' ) 
					) AND banner_deleted = '0' AND banner_status = '1' ORDER BY banner_order ASC ";				
			}
			else
			{
				$sql = "SELECT * FROM `tblbanners` 
					WHERE ( 
						( banner_city_id = '".$city_id."' AND banner_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", banner_city_id) > 0 AND banner_area_id = '".$area_id."' ) OR 
						( banner_city_id = '-1' AND banner_area_id = '".$area_id."' ) OR 
						( banner_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", banner_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", banner_city_id) > 0 AND FIND_IN_SET(".$area_id.", banner_area_id) > 0  ) OR 
						( banner_city_id = '-1' AND FIND_IN_SET(".$area_id.", banner_area_id) > 0  ) OR 
						( banner_city_id = '".$city_id."' AND banner_area_id = '-1' ) OR 
						( FIND_IN_SET(".$city_id.", banner_city_id) > 0 AND banner_area_id = '-1'  ) OR
						( banner_city_id = '-1' AND banner_area_id = '-1' AND banner_state_id = '".$state_id."' ) OR 
						( banner_city_id = '-1' AND banner_area_id = '-1' AND FIND_IN_SET(".$state_id.", banner_state_id) > 0 ) OR 
						( banner_city_id = '-1' AND banner_area_id = '-1' AND banner_state_id = '-1' AND banner_country_id = '".$country_id."' ) OR 
						( banner_city_id = '-1' AND banner_area_id = '-1' AND banner_state_id = '-1' AND FIND_IN_SET(".$country_id.", banner_country_id) > 0  ) OR 
						( banner_city_id = '-1' AND banner_area_id = '-1' AND banner_state_id = '-1' AND banner_country_id = '-1' )
						
					) AND banner_deleted = '0' AND banner_status = '1' ORDER BY banner_order ASC";			
			}
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$temp_date = date('Y-m-d');
					$go_ahead = false;
					if($r['banner_publish_date_type'] == 'days_of_month')
					{
						if($r['banner_publish_days_of_month'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['banner_publish_days_of_month'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_month = explode(',',$r['banner_publish_days_of_month']);
							if(in_array($today_day_of_month,$temp_arr_publish_days_of_month))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['banner_publish_date_type'] == 'days_of_week')
					{
						if($r['banner_publish_days_of_week'] == '-1')
						{
							$go_ahead = true;
						}
						elseif($r['banner_publish_days_of_week'] == '')
						{
							
						}
						else
						{
							$temp_arr_publish_days_of_week = explode(',',$r['banner_publish_days_of_week']);
							if(in_array($today_day_of_week,$temp_arr_publish_days_of_week))
							{
								$go_ahead = true;	
							}
						}
					}
					elseif($r['banner_publish_date_type'] == 'single_date')
					{
						//echo '<br>'.$r['publish_single_date'];
						//echo '<br>'.$today_single_date;
						if(strtotime($r['banner_publish_single_date']) <= strtotime($today_single_date))
						{
							$go_ahead = true;
						}
						
					}
					elseif($r['banner_publish_date_type'] == 'date_range')
					{
						if( (strtotime($r['banner_publish_start_date']) <= strtotime($today_single_date)) && (strtotime($r['banner_publish_end_date']) >= strtotime($today_single_date)) )
						{
							$go_ahead = true;
						}
						
					}
					
					if($go_ahead)
					{
						//foreach($r as $key1 => $val1)
						//{
							//$r[$key1] = stripslashes($val1);
						//}
						$output[] = $r;
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[getAllPublishedBannerSliders] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function updateUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`first_name` = :first_name,
					`last_name` = :last_name,
					`mobile_no` = :mobile_no
					WHERE `user_id` = :user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':first_name' => addslashes($tdata['first_name']),
				':last_name' => addslashes($tdata['last_name']),
				':mobile_no' => addslashes($tdata['mobile_no']),
				':user_id' => $tdata['user_id']
			));
			$DBH->commit();
			
			$return = true;
			
			$_SESSION['user_fullname'] = $tdata['first_name'].' '.$tdata['last_name'];
			$_SESSION['user_firstname'] = $tdata['first_name'];
			$_SESSION['user_mobile_no'] = $tdata['mobile_no'];
		} catch (Exception $e) {
			$stringData = '[updateUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getUsersAllOrders($user_id)
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		
		$sql = "SELECT * FROM `tblorders` WHERE user_id = '".$user_id."' AND `order_status` > 0 ORDER BY order_add_date DESC ";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				//foreach($r as $key1 => $val1)
				//{
					//$r[$key1] = stripslashes($val1);
				//}
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getOrderStatusString($status)
	{
		$output = '';
		
		$arr_order_status = array('Pending','Order Received','Shipped','Completed','Cancelled','Declined');
		
		if(array_key_exists($status,$arr_order_status))
		{
			$output = $arr_order_status[$status];
		}			
		return $output;
	}
	
	public function getOrderDetailsByInvoiceAndUserId($invoice,$user_id)
    {
        $DBH = new DatabaseHandler();
		$arr_record = array();

		try {	
			$sql = "SELECT * FROM `tblorders` WHERE `invoice` = '".$invoice."' AND `user_id` = '".$user_id."' AND `order_status` > 0 ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$arr_record = $r;
			}
		} catch (Exception $e) {
			$stringData = '[getOrderDetailsByInvoiceAndUserId] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
	
	public function getOrderCartDetailsByInvoiceAndUserId($invoice,$user_id,$order_cart_id)
    {
        $DBH = new DatabaseHandler();
		$arr_record = array();

		try {	
			$sql = "SELECT * FROM `tblordercart` WHERE `invoice` = '".$invoice."' AND `user_id` = '".$user_id."' AND `order_cart_id` = '".$order_cart_id."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$arr_record = $r;
			}
		} catch (Exception $e) {
			$stringData = '[getOrderCartDetailsByInvoiceAndUserId] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
	
	public function getSideLoggedinMenu($page_id)
    {
        $output = '';
		
		$my_account_active = '';
		if($page_id == '7')
		{
			$my_account_active = ' class="active" ';	
		}
		
		$edit_profile_active = '';
		if($page_id == '8')
		{
			$edit_profile_active = ' class="active" ';	
		}
		
		$my_orders_active = '';
		if($page_id == '9' || $page_id == '10')
		{
			$my_orders_active = ' class="active" ';	
		}
		
		$change_password_active = '';
		if($page_id == '21')
		{
			$change_password_active = ' class="active" ';	
		}
		
        $output .= '<div class="myaccount-menu"><a '.$my_account_active.' href="'.SITE_URL.'/my_account.php">My Account</a></div>
					<div class="myaccount-menu"><a '.$edit_profile_active.' href="'.SITE_URL.'/edit_profile.php">Edit Profile</a></div>
					<div class="myaccount-menu"><a '.$change_password_active.' href="'.SITE_URL.'/change_password.php">Change Password</a></div>
					<div class="myaccount-menu"><a '.$my_orders_active.' href="'.SITE_URL.'/my_orders.php">My Orders</a></div>
					<div class="myaccount-menu"><a href="#">Track Order</a></div>
					<div class="myaccount-menu"><a href="'.SITE_URL.'/logout.php">Logout</a></div>';
		return $output;
	}
	
	public function resetUserPasswordByMobile($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        try {
			$sql = "UPDATE `tblusers` SET  
					`password` = :password,  
					`user_status` = :user_status  
					WHERE `mobile_no` = :mobile_no AND user_deleted = :user_deleted ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':password' => md5($tdata['password']),
				':user_status' => '1',
				':mobile_no' => $tdata['mobile_no'],
				':user_deleted' => 0
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[resetUserPasswordByMobile] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getShippingPriceOld($subtotal,$city_id,$area_id='')
	{
		$DBH = new DatabaseHandler();
		$output = 0;
		
		if($subtotal == '' || $subtotal < 1)
		{
			return $output;
		}
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		$today = date('Y-m-d');
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						(sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						(sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 ) 
					) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";				
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output = stripslashes($r['shipping_price']);
					}
				}
				else
				{
					$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  
					) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";				
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r= $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output = stripslashes($r['shipping_price']);
						}
					}
					else
					{
						$sql = "SELECT * FROM `tblshippingprices` 
						WHERE ( 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) 
						) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";								
						$STH3 = $DBH->query($sql);
						if( $STH3->rowCount() > 0 )
						{
							while($r= $STH3->fetch(PDO::FETCH_ASSOC))
							{	
								$output = stripslashes($r['shipping_price']);
							}
						}
						else
						{
							$sql = "SELECT * FROM `tblshippingprices` 
							WHERE ( 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
							) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";								
							$STH4 = $DBH->query($sql);
							if( $STH4->rowCount() > 0 )
							{
								while($r= $STH4->fetch(PDO::FETCH_ASSOC))
								{	
									$output = stripslashes($r['shipping_price']);
								}
							}
						}	
					}	
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";							
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output = stripslashes($r['shipping_price']);
					}
				}	
				else
				{
					$sql = "SELECT * FROM `tblshippingprices` 
						WHERE ( 
							( sp_city_id = '".$city_id."' AND sp_area_id = '-1' ) OR 
							( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '-1'  ) 
						) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";							
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r= $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output = stripslashes($r['shipping_price']);
						}
					}	
					else
					{
						$sql = "SELECT * FROM `tblshippingprices` 
							WHERE ( 
								( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
								( sp_city_id = '-1' AND sp_area_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  
							) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";							
						$STH2 = $DBH->query($sql);
						if( $STH2->rowCount() > 0 )
						{
							while($r= $STH2->fetch(PDO::FETCH_ASSOC))
							{	
								$output = stripslashes($r['shipping_price']);
							}
						}	
						else
						{
							$sql = "SELECT * FROM `tblshippingprices` 
								WHERE ( 
									( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
									( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  )  
								) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";							
							$STH2 = $DBH->query($sql);
							if( $STH2->rowCount() > 0 )
							{
								while($r= $STH2->fetch(PDO::FETCH_ASSOC))
								{	
									$output = stripslashes($r['shipping_price']);
								}
							}	
							else
							{
								$sql = "SELECT * FROM `tblshippingprices` 
									WHERE ( 
										( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' )
									) AND shipping_price != '' AND shipping_price > 0  AND min_order_amount <= ".$subtotal." AND max_order_amount >= ".$subtotal." AND sp_deleted = '0' AND sp_status = '1' ORDER BY sp_add_date DESC LIMIT 1 ";							
								$STH2 = $DBH->query($sql);
								if( $STH2->rowCount() > 0 )
								{
									while($r= $STH2->fetch(PDO::FETCH_ASSOC))
									{	
										$output = stripslashes($r['shipping_price']);
									}
								}	
							}	
						}	
					}	
				}
			}
		} catch (Exception $e) {
			$stringData = '[getShippingPriceOld] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function getShippingPriceSPTypewise($city_id,$area_id='',$sp_type='')
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		$today = date('Y-m-d');
		
		if($sp_type == '')
		{
			$sp_type = '0';
		}
		
		$sql_sp_type_str = " AND sp_type = '".$sp_type."' ";
		$sql_common_str = "";
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						(sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						(sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 ) 
					) AND shipping_price != '' AND shipping_price > 0 ".$sql_sp_type_str."  AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";				
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  
					) AND shipping_price != '' AND shipping_price > 0 ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";				
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r2;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tblshippingprices` 
						WHERE ( 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) 
						) AND shipping_price != '' AND shipping_price > 0 ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";								
						$STH3 = $DBH->query($sql);
						if( $STH3->rowCount() > 0 )
						{
							while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r3;
							}
						}
						else
						{
							$sql = "SELECT * FROM `tblshippingprices` 
							WHERE ( 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
							) AND shipping_price != '' AND shipping_price > 0 ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";								
							$STH4 = $DBH->query($sql);
							if( $STH4->rowCount() > 0 )
							{
								while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
								{	
									$output[] = $r4;
								}
							}
						}	
					}	
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) AND shipping_price != '' AND shipping_price > 0  ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";															
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}	
				else
				{
					$sql = "SELECT * FROM `tblshippingprices` 
						WHERE ( 
							( sp_city_id = '".$city_id."' AND sp_area_id = '-1' ) OR 
							( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '-1'  ) 
						) AND shipping_price != '' AND shipping_price > 0 ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";							
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r2;
						}
					}	
					else
					{
						$sql = "SELECT * FROM `tblshippingprices` 
							WHERE ( 
								( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
								( sp_city_id = '-1' AND sp_area_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  
							) AND shipping_price != '' AND shipping_price > 0  ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";							
						$STH3 = $DBH->query($sql);
						if( $STH3->rowCount() > 0 )
						{
							while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r3;
							}
						}	
						else
						{
							$sql = "SELECT * FROM `tblshippingprices` 
								WHERE ( 
									( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
									( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  )  
								) AND shipping_price != '' AND shipping_price > 0  ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";							
							$STH4 = $DBH->query($sql);
							if( $STH4->rowCount() > 0 )
							{
								while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
								{	
									$output[] = $r4;
								}
							}	
							else
							{
								$sql = "SELECT * FROM `tblshippingprices` 
									WHERE ( 
										( sp_city_id = '-1' AND sp_area_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' )
									) AND shipping_price != '' AND shipping_price > 0  ".$sql_sp_type_str." AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_add_date DESC ";							
								$STH5 = $DBH->query($sql);
								if( $STH5->rowCount() > 0 )
								{
									while($r5 = $STH5->fetch(PDO::FETCH_ASSOC))
									{	
										$output[] = $r5;
									}
								}	
							}	
						}	
					}	
				}
			}
		} catch (Exception $e) {
			$stringData = '[getShippingPriceSPTypewise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function chkIfCusineHasQuantityWiseShippingPrice($city_id,$area_id,$sp_applied_on,$sp_min_qty_id)
	{
		$DBH = new DatabaseHandler();
		$output = false;
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$sql_common_str = " AND sp_applied_on = '".$sp_applied_on."' AND sp_min_qty_id = '".$sp_min_qty_id."' AND shipping_price != '' AND sp_type = '2' AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_effective_date DESC, sp_add_date DESC LIMIT 1";
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						( sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 ) OR
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  OR
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) OR
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
					) ".$sql_common_str;
				$this->debuglog('[chkIfCusineHasQuantityWiseShippingPrice] sql:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					$output = true;
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) ".$sql_common_str;
				$this->debuglog('[chkIfCusineHasQuantityWiseShippingPrice] sql:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					$output = true;
				}
			}

			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[chkIfCusineHasQuantityWiseShippingPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineShippingPriceQuantityWise($city_id,$area_id,$sp_applied_on,$sp_min_qty_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$sql_common_str = " AND sp_applied_on = '".$sp_applied_on."' AND sp_min_qty_id = '".$sp_min_qty_id."' AND shipping_price != '' AND sp_type = '2' AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_effective_date DESC, sp_add_date DESC ";
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						( sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 )  
					) ".$sql_common_str;
				$this->debuglog('[getCusineShippingPriceQuantityWise] sql:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tblshippingprices` 
						WHERE ( 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  
						) ".$sql_common_str;
					$this->debuglog('[getCusineShippingPriceQuantityWise] sql2:'.$sql);	
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r2;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tblshippingprices` 
							WHERE ( 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) 
							) ".$sql_common_str;
						$this->debuglog('[getCusineShippingPriceQuantityWise] sql3:'.$sql);	
						$STH3 = $DBH->query($sql);
						if( $STH3->rowCount() > 0 )
						{
							while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r3;
							}
						}
						else
						{
							$sql = "SELECT * FROM `tblshippingprices` 
								WHERE ( 
									( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
								) ".$sql_common_str;
							$this->debuglog('[getCusineShippingPriceQuantityWise] sql4:'.$sql);	
							$STH4 = $DBH->query($sql);
							if( $STH4->rowCount() > 0 )
							{
								while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
								{	
									$output[] = $r4;
								}
							}
						}
					}
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) ".$sql_common_str;
				$this->debuglog('[getCusineShippingPriceQuantityWise] sql5:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}
			}

			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[getCusineShippingPriceQuantityWise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function chkIfCusineHasQuantityWiseTradeDiscountPrice($city_id,$area_id,$dc_applied_on,$dc_min_qty_id)
	{
		$DBH = new DatabaseHandler();
		$output = false;
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$effective_day_of_month = date('j');
		$effective_day_of_week = date('N');
		$effective_single_date = date('Y-m-d');
		
		$sql_dc_effective_date_str = " AND ( 
							( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '".$effective_day_of_month."' OR  FIND_IN_SET(".$effective_day_of_month.", dc_effective_days_of_month) > 0 ) ) OR
							( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '".$effective_day_of_week."' OR  FIND_IN_SET(".$effective_day_of_week.", dc_effective_days_of_week) > 0 ) ) OR
							( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '".$effective_single_date."' ) ) OR
							( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '".$effective_single_date."' AND dc_effective_end_date >= '".$effective_single_date."' ) ) 
							) ";

		$sql_common_str = " AND dc_trade_discount = '1' AND dc_applied_on = '".$dc_applied_on."' AND dc_min_qty_id = '".$dc_min_qty_id."' AND discount_price != '' AND dc_type = '2' AND dc_deleted = '0' AND dc_status = '1' ".$sql_dc_effective_date_str." ORDER BY dc_add_date DESC LIMIT 1";
		
		try {
			
			$sql = "SELECT * FROM `tbldiscountcoupons` 
				WHERE ( 
					( dc_city_id = '".$city_id."' ) OR 
					( FIND_IN_SET(".$city_id.", dc_city_id) > 0 ) OR
					( dc_city_id = '-1' AND dc_state_id = '".$state_id."' ) OR 
					( dc_city_id = '-1' AND FIND_IN_SET(".$state_id.", dc_state_id) > 0 )  OR
					( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '".$country_id."' ) OR 
					( dc_city_id = '-1' AND dc_state_id = '-1' AND FIND_IN_SET(".$country_id.", dc_country_id) > 0  ) OR
					( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '-1' ) 
				) ".$sql_common_str;
			$this->debuglog('[chkIfCusineHasQuantityWiseTradeDiscountPrice] sql:'.$sql);	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$output = true;
			}

			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[chkIfCusineHasQuantityWiseTradeDiscountPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineTradeDiscountPriceQuantityWise($city_id,$area_id,$dc_applied_on,$dc_min_qty_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$effective_day_of_month = date('j');
		$effective_day_of_week = date('N');
		$effective_single_date = date('Y-m-d');
		
		$sql_dc_effective_date_str = " AND ( 
							( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '".$effective_day_of_month."' OR  FIND_IN_SET(".$effective_day_of_month.", dc_effective_days_of_month) > 0 ) ) OR
							( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '".$effective_day_of_week."' OR  FIND_IN_SET(".$effective_day_of_week.", dc_effective_days_of_week) > 0 ) ) OR
							( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '".$effective_single_date."' ) ) OR
							( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '".$effective_single_date."' AND dc_effective_end_date >= '".$effective_single_date."' ) ) 
							) ";

		$sql_common_str = " AND dc_trade_discount = '1' AND dc_applied_on = '".$dc_applied_on."' AND dc_min_qty_id = '".$dc_min_qty_id."' AND discount_price != '' AND dc_type = '2' AND dc_deleted = '0' AND dc_status = '1' ".$sql_dc_effective_date_str." ORDER BY dc_add_date DESC ";
		
		try {
			
			$sql = "SELECT * FROM `tbldiscountcoupons` 
				WHERE ( 
					( dc_city_id = '".$city_id."' ) OR 
					( FIND_IN_SET(".$city_id.", dc_city_id) > 0 )  
				) ".$sql_common_str;
			$this->debuglog('[getCusineTradeDiscountPriceQuantityWise] sql:'.$sql);	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{	
					$output[] = $r;
				}
			}
			else
			{
				$sql = "SELECT * FROM `tbldiscountcoupons` 
					WHERE ( 
						( dc_city_id = '-1' AND dc_state_id = '".$state_id."' ) OR 
						( dc_city_id = '-1' AND FIND_IN_SET(".$state_id.", dc_state_id) > 0 )  
					) ".$sql_common_str;
				$this->debuglog('[getCusineTradeDiscountPriceQuantityWise] sql2:'.$sql);	
				$STH2 = $DBH->query($sql);
				if( $STH2->rowCount() > 0 )
				{
					while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r2;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tbldiscountcoupons` 
						WHERE ( 
							( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '".$country_id."' ) OR 
							( dc_city_id = '-1' AND dc_state_id = '-1' AND FIND_IN_SET(".$country_id.", dc_country_id) > 0  ) 
						) ".$sql_common_str;
					$this->debuglog('[getCusineTradeDiscountPriceQuantityWise] sql3:'.$sql);	
					$STH3 = $DBH->query($sql);
					if( $STH3->rowCount() > 0 )
					{
						while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r3;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tbldiscountcoupons` 
							WHERE ( 
								( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '-1' ) 
							) ".$sql_common_str;
						$this->debuglog('[getCusineTradeDiscountPriceQuantityWise] sql4:'.$sql);	
						$STH4 = $DBH->query($sql);
						if( $STH4->rowCount() > 0 )
						{
							while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r4;
							}
						}
					}
				}
			}
			
			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[getCusineTradeDiscountPriceQuantityWise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	
	public function chkIfCusineHasAmountWiseShippingPrice($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = false;
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$sql_common_str = " AND shipping_price != '' AND sp_type = '0' AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_effective_date DESC, sp_add_date DESC LIMIT 1";
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						( sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 ) OR
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) OR
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
					) ".$sql_common_str;
				$this->debuglog('[chkIfCusineHasAmountWiseShippingPrice] sql:'.$sql);		
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					$output = true;
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) ".$sql_common_str;
				$this->debuglog('[chkIfCusineHasAmountWiseShippingPrice] sql:'.$sql);		
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					$output = true;
				}
			}				
			
			return $output;
			
		} catch (Exception $e) {
			$stringData = '[chkIfCusineHasAmountWiseShippingPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineShippingPriceAmountWise($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$sql_common_str = " AND shipping_price != '' AND sp_type = '0' AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_effective_date DESC, sp_add_date DESC ";
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						( sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 )  
					) ".$sql_common_str;
				$this->debuglog('[getCusineShippingPriceAmountWise] sql:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tblshippingprices` 
						WHERE ( 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  
						) ".$sql_common_str;
					$this->debuglog('[getCusineShippingPriceAmountWise] sql2:'.$sql);	
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r2;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tblshippingprices` 
							WHERE ( 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) 
							) ".$sql_common_str;
						$this->debuglog('[getCusineShippingPriceAmountWise] sql3:'.$sql);	
						$STH3 = $DBH->query($sql);
						if( $STH3->rowCount() > 0 )
						{
							while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r3;
							}
						}
						else
						{
							$sql = "SELECT * FROM `tblshippingprices` 
								WHERE ( 
									( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
								) ".$sql_common_str;
							$this->debuglog('[getCusineShippingPriceAmountWise] sql4:'.$sql);	
							$STH4 = $DBH->query($sql);
							if( $STH4->rowCount() > 0 )
							{
								while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
								{	
									$output[] = $r4;
								}
							}
						}
					}
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) ".$sql_common_str;
				$this->debuglog('[getCusineShippingPriceAmountWise] sql5:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}
			}

			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[getCusineShippingPriceAmountWise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function chkIfCusineHasAmountWiseTradeDiscountPrice($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = false;
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$effective_day_of_month = date('j');
		$effective_day_of_week = date('N');
		$effective_single_date = date('Y-m-d');
		
		$sql_dc_effective_date_str = " AND ( 
							( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '".$effective_day_of_month."' OR  FIND_IN_SET(".$effective_day_of_month.", dc_effective_days_of_month) > 0 ) ) OR
							( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '".$effective_day_of_week."' OR  FIND_IN_SET(".$effective_day_of_week.", dc_effective_days_of_week) > 0 ) ) OR
							( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '".$effective_single_date."' ) ) OR
							( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '".$effective_single_date."' AND dc_effective_end_date >= '".$effective_single_date."' ) ) 
							) ";

		$sql_common_str = " AND dc_trade_discount = '1' AND discount_price != '' AND dc_type = '0' AND dc_deleted = '0' AND dc_status = '1' ".$sql_dc_effective_date_str." ORDER BY dc_add_date DESC LIMIT 1";

		
		try {
			
			$sql = "SELECT * FROM `tbldiscountcoupons` 
				WHERE ( 
					( dc_city_id = '".$city_id."' ) OR 
					( FIND_IN_SET(".$city_id.", dc_city_id) > 0 ) OR
					( dc_city_id = '-1' AND dc_state_id = '".$state_id."' ) OR 
					( dc_city_id = '-1' AND FIND_IN_SET(".$state_id.", dc_state_id) > 0 )  OR
					( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '".$country_id."' ) OR 
					( dc_city_id = '-1' AND dc_state_id = '-1' AND FIND_IN_SET(".$country_id.", dc_country_id) > 0  ) OR
					( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '-1' ) 
				) ".$sql_common_str;
			$this->debuglog('[chkIfCusineHasAmountWiseTradeDiscountPrice] sql:'.$sql);		
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$output = true;
			}
			
			return $output;
			
		} catch (Exception $e) {
			$stringData = '[chkIfCusineHasAmountWiseTradeDiscountPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineTradeDiscountPriceAmountWise($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$effective_day_of_month = date('j');
		$effective_day_of_week = date('N');
		$effective_single_date = date('Y-m-d');
		
		$sql_dc_effective_date_str = " AND ( 
							( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '".$effective_day_of_month."' OR  FIND_IN_SET(".$effective_day_of_month.", dc_effective_days_of_month) > 0 ) ) OR
							( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '".$effective_day_of_week."' OR  FIND_IN_SET(".$effective_day_of_week.", dc_effective_days_of_week) > 0 ) ) OR
							( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '".$effective_single_date."' ) ) OR
							( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '".$effective_single_date."' AND dc_effective_end_date >= '".$effective_single_date."' ) ) 
							) ";

		$sql_common_str = " AND dc_trade_discount = '1' AND discount_price != '' AND dc_type = '0' AND dc_deleted = '0' AND dc_status = '1' ".$sql_dc_effective_date_str." ORDER BY dc_add_date DESC ";
		
		try {
			
			$sql = "SELECT * FROM `tbldiscountcoupons` 
				WHERE ( 
					( dc_city_id = '".$city_id."' ) OR 
					( FIND_IN_SET(".$city_id.", dc_city_id) > 0 )  
				) ".$sql_common_str;
			$this->debuglog('[getCusineTradeDiscountPriceAmountWise] sql:'.$sql);	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{	
					$output[] = $r;
				}
			}
			else
			{
				$sql = "SELECT * FROM `tbldiscountcoupons` 
					WHERE ( 
						( dc_city_id = '-1' AND dc_state_id = '".$state_id."' ) OR 
						( dc_city_id = '-1' AND FIND_IN_SET(".$state_id.", dc_state_id) > 0 )  
					) ".$sql_common_str;
				$this->debuglog('[getCusineTradeDiscountPriceAmountWise] sql2:'.$sql);	
				$STH2 = $DBH->query($sql);
				if( $STH2->rowCount() > 0 )
				{
					while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r2;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tbldiscountcoupons` 
						WHERE ( 
							( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '".$country_id."' ) OR 
							( dc_city_id = '-1' AND dc_state_id = '-1' AND FIND_IN_SET(".$country_id.", dc_country_id) > 0  ) 
						) ".$sql_common_str;
					$this->debuglog('[getCusineTradeDiscountPriceAmountWise] sql3:'.$sql);	
					$STH3 = $DBH->query($sql);
					if( $STH3->rowCount() > 0 )
					{
						while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r3;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tbldiscountcoupons` 
							WHERE ( 
								( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '-1' ) 
							) ".$sql_common_str;
						$this->debuglog('[getCusineTradeDiscountPriceAmountWise] sql4:'.$sql);	
						$STH4 = $DBH->query($sql);
						if( $STH4->rowCount() > 0 )
						{
							while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r4;
							}
						}
					}
				}
			}
			
			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[getCusineTradeDiscountPriceAmountWise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineShippingPricePercentWise($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$sql_common_str = " AND sp_type = '1' AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_effective_date DESC, sp_add_date DESC ";
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						( sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 )  
					) ".$sql_common_str;
				$this->debuglog('[getCusineShippingPricePercentWise] sql:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tblshippingprices` 
						WHERE ( 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
							( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 )  
						) ".$sql_common_str;
					$this->debuglog('[getCusineShippingPricePercentWise] sql2:'.$sql);	
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r2;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tblshippingprices` 
							WHERE ( 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
								( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) 
							) ".$sql_common_str;
						$this->debuglog('[getCusineShippingPricePercentWise] sql3:'.$sql);	
						$STH3 = $DBH->query($sql);
						if( $STH3->rowCount() > 0 )
						{
							while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r3;
							}
						}
						else
						{
							$sql = "SELECT * FROM `tblshippingprices` 
								WHERE ( 
									( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
								) ".$sql_common_str;
							$this->debuglog('[getCusineShippingPricePercentWise] sql4:'.$sql);	
							$STH4 = $DBH->query($sql);
							if( $STH4->rowCount() > 0 )
							{
								while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
								{	
									$output[] = $r4;
								}
							}
						}
					}
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) ".$sql_common_str;
				$this->debuglog('[getCusineShippingPricePercentWise] sql5:'.$sql);	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r = $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r;
					}
				}
			}

			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[getCusineShippingPricePercentWise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function chkIfCusineHasPercentWiseShippingPrice($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = false;
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$sql_common_str = " AND sp_type = '1' AND sp_deleted = '0' AND sp_status = '1' AND sp_effective_date <= '".$today."' ORDER BY sp_effective_date DESC, sp_add_date DESC LIMIT 1";
		
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_area_id = '-1' AND sp_city_id = '".$city_id."' ) OR 
						( sp_area_id = '-1' AND FIND_IN_SET(".$city_id.", sp_city_id) > 0 ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '".$state_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND FIND_IN_SET(".$state_id.", sp_state_id) > 0 ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '".$country_id."' ) OR 
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND FIND_IN_SET(".$country_id.", sp_country_id) > 0  ) OR
						( sp_area_id = '-1' AND sp_city_id = '-1' AND sp_state_id = '-1' AND sp_country_id = '-1' ) 
					) ".$sql_common_str;
				$this->debuglog('[chkIfCusineHasPercentWiseShippingPrice] sql:'.$sql);			
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					$output = true;
				}
			}
			else
			{
				$sql = "SELECT * FROM `tblshippingprices` 
					WHERE ( 
						( sp_city_id = '".$city_id."' AND sp_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '-1' AND sp_area_id = '".$area_id."' ) OR 
						( sp_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", sp_city_id) > 0 AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) OR 
						( sp_city_id = '-1' AND FIND_IN_SET(".$area_id.", sp_area_id) > 0  ) 
					) ".$sql_common_str;
				$this->debuglog('[chkIfCusineHasPercentWiseShippingPrice] sql:'.$sql);			
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					$output = true;
				}
			}				
			
			return $output;
				
		} catch (Exception $e) {
			$stringData = '[chkIfCusineHasPercentWiseShippingPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function chkIfCusineHasPercentWiseTradeDiscountPrice($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = false;
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$effective_day_of_month = date('j');
		$effective_day_of_week = date('N');
		$effective_single_date = date('Y-m-d');
		
		$sql_dc_effective_date_str = " AND ( 
							( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '".$effective_day_of_month."' OR  FIND_IN_SET(".$effective_day_of_month.", dc_effective_days_of_month) > 0 ) ) OR
							( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '".$effective_day_of_week."' OR  FIND_IN_SET(".$effective_day_of_week.", dc_effective_days_of_week) > 0 ) ) OR
							( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '".$effective_single_date."' ) ) OR
							( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '".$effective_single_date."' AND dc_effective_end_date >= '".$effective_single_date."' ) ) 
							) ";

		$sql_common_str = " AND dc_trade_discount = '1' AND dc_type = '1' AND dc_deleted = '0' AND dc_status = '1' ".$sql_dc_effective_date_str." ORDER BY dc_add_date DESC LIMIT 1";

		
		try {
			
			$sql = "SELECT * FROM `tbldiscountcoupons` 
				WHERE ( 
					( dc_city_id = '".$city_id."' ) OR 
					( FIND_IN_SET(".$city_id.", dc_city_id) > 0 ) OR
					( dc_city_id = '-1' AND dc_state_id = '".$state_id."' ) OR 
					( dc_city_id = '-1' AND FIND_IN_SET(".$state_id.", dc_state_id) > 0 )  OR
					( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '".$country_id."' ) OR 
					( dc_city_id = '-1' AND dc_state_id = '-1' AND FIND_IN_SET(".$country_id.", dc_country_id) > 0  ) OR
					( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '-1' ) 
				) ".$sql_common_str;
			$this->debuglog('[chkIfCusineHasPercentWiseTradeDiscountPrice] sql:'.$sql);		
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$output = true;
			}
			
			return $output;
			
		} catch (Exception $e) {
			$stringData = '[chkIfCusineHasPercentWiseTradeDiscountPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getCusineTradeDiscountPricePercentWise($city_id,$area_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		$today = date('Y-m-d');
		
		$effective_day_of_month = date('j');
		$effective_day_of_week = date('N');
		$effective_single_date = date('Y-m-d');
		
		$sql_dc_effective_date_str = " AND ( 
							( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '".$effective_day_of_month."' OR  FIND_IN_SET(".$effective_day_of_month.", dc_effective_days_of_month) > 0 ) ) OR
							( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '".$effective_day_of_week."' OR  FIND_IN_SET(".$effective_day_of_week.", dc_effective_days_of_week) > 0 ) ) OR
							( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '".$effective_single_date."' ) ) OR
							( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '".$effective_single_date."' AND dc_effective_end_date >= '".$effective_single_date."' ) ) 
							) ";

		$sql_common_str = " AND dc_trade_discount = '1' AND dc_type = '1' AND dc_deleted = '0' AND dc_status = '1' ".$sql_dc_effective_date_str." ORDER BY dc_add_date DESC ";
		
		try {
			
			$sql = "SELECT * FROM `tbldiscountcoupons` 
				WHERE ( 
					( dc_city_id = '".$city_id."' ) OR 
					( FIND_IN_SET(".$city_id.", dc_city_id) > 0 )  
				) ".$sql_common_str;
			$this->debuglog('[getCusineTradeDiscountPricePercentWise] sql:'.$sql);	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{	
					$output[] = $r;
				}
			}
			else
			{
				$sql = "SELECT * FROM `tbldiscountcoupons` 
					WHERE ( 
						( dc_city_id = '-1' AND dc_state_id = '".$state_id."' ) OR 
						( dc_city_id = '-1' AND FIND_IN_SET(".$state_id.", dc_state_id) > 0 )  
					) ".$sql_common_str;
				$this->debuglog('[getCusineTradeDiscountPricePercentWise] sql2:'.$sql);	
				$STH2 = $DBH->query($sql);
				if( $STH2->rowCount() > 0 )
				{
					while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
					{	
						$output[] = $r2;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tbldiscountcoupons` 
						WHERE ( 
							( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '".$country_id."' ) OR 
							( dc_city_id = '-1' AND dc_state_id = '-1' AND FIND_IN_SET(".$country_id.", dc_country_id) > 0  ) 
						) ".$sql_common_str;
					$this->debuglog('[getCusineTradeDiscountPricePercentWise] sql3:'.$sql);	
					$STH3 = $DBH->query($sql);
					if( $STH3->rowCount() > 0 )
					{
						while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
						{	
							$output[] = $r3;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tbldiscountcoupons` 
							WHERE ( 
								( dc_city_id = '-1' AND dc_state_id = '-1' AND dc_country_id = '-1' ) 
							) ".$sql_common_str;
						$this->debuglog('[getCusineTradeDiscountPricePercentWise] sql4:'.$sql);	
						$STH4 = $DBH->query($sql);
						if( $STH4->rowCount() > 0 )
						{
							while($r4 = $STH4->fetch(PDO::FETCH_ASSOC))
							{	
								$output[] = $r4;
							}
						}
					}
				}
			}
			
			return $output;	
				
		} catch (Exception $e) {
			$stringData = '[getCusineTradeDiscountPricePercentWise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}
	}
	
	public function getShippingPrice($subtotal,$city_id,$area_id='')
	{
		$DBH = new DatabaseHandler();
		$output = 0;
		
		if($subtotal == '' || $subtotal < 1)
		{
			return $output;
		}
		
		$today = date('Y-m-d');
		
		$total_shipping_price = 0;
		$qty_shipping_price = 0;
		$amt_shipping_price = 0;
		$per_shipping_price = 0;

		$arr_wt_qty = array();
		$arr_wt_min_qty = array();
		$arr_wt_max_qty = array();
		$arr_wt_shipping_price = array();
		
		$arr_amt_subtotal = array();
		$arr_amt_min_order_amt = array();
		$arr_amt_max_order_amt = array();
		$arr_amt_shipping_price = array();
		
		$arr_per_subtotal = array();
		$arr_per_min_order_amt = array();
		$arr_per_max_order_amt = array();
		$arr_per_sp_percentage = array();
		
		$obj_temp = new commonFunctions();
		try {
			
			$cart_session_id = session_id();
			$sql = "SELECT DISTINCT(cart_delivery_date) FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_city_id` = '".$city_id."' AND 
					`cart_delivery_date` != '0000-00-00' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
			$this->debuglog('[getShippingPrice]sql:'.$sql);		
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r = $STH->fetch(PDO::FETCH_ASSOC))
				{
					$arr_wt_qty = array();
					$arr_wt_min_qty = array();
					$arr_wt_max_qty = array();
					$arr_wt_shipping_price = array();
					
					$arr_amt_subtotal = array();
					$arr_amt_min_order_amt = array();
					$arr_amt_max_order_amt = array();
					$arr_amt_shipping_price = array();
					
					$arr_per_subtotal = array();
					$arr_per_min_order_amt = array();
					$arr_per_max_order_amt = array();
					$arr_per_sp_percentage = array();
					
					
					$sql2 = "SELECT DISTINCT(cart_area_id) FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cart_city_id` = '".$city_id."' AND 
					`cart_delivery_date` = '".$r['cart_delivery_date']."' AND 
					`cart_status` = '0' AND 
					`cart_deleted` = '0' ";
					$this->debuglog('[getShippingPrice]sql2:'.$sql2);		
					$STH2 = $DBH->query($sql2);
					if( $STH2->rowCount() > 0 )
					{
						while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$arr_shipping_inclusive_details = $obj_temp->getShippingPriceSPTypewise($city_id,$r2['cart_area_id'],3);
							$this->debuglog('[getShippingPrice] sp_type:3, city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_shipping_inclusive_details:<pre>'.print_r($arr_shipping_inclusive_details,1).'</pre>');		
							if(count($arr_shipping_inclusive_details) > 0 )
							{
								
							}
							else
							{
								/*
								$arr_shipping_qty_details = $obj_temp->getShippingPriceSPTypewise($city_id,$r2['cart_area_id'],2);
								$this->debuglog('[getShippingPrice] sp_type:2, city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_shipping_qty_details:<pre>'.print_r($arr_shipping_qty_details,1).'</pre>');		
								//echo'<br><pre>';
								//print_r($arr_shipping_qty_details);
								//echo'<br></pre>';
								if(count($arr_shipping_qty_details) > 0 )
								{
									for($wq=0;$wq<count($arr_shipping_qty_details);$wq++)
									{
										$arr_wt_qty[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id'].'_'.$arr_shipping_qty_details[$wq]['sp_applied_on'].'_'.$arr_shipping_qty_details[$wq]['sp_min_qty_id']] = 0;
										$arr_wt_min_qty[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id'].'_'.$arr_shipping_qty_details[$wq]['sp_applied_on'].'_'.$arr_shipping_qty_details[$wq]['sp_min_qty_id']] = $arr_shipping_qty_details[$wq]['sp_min_qty_val'];
										$arr_wt_max_qty[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id'].'_'.$arr_shipping_qty_details[$wq]['sp_applied_on'].'_'.$arr_shipping_qty_details[$wq]['sp_min_qty_id']] = $arr_shipping_qty_details[$wq]['sp_max_qty_val'];
										$arr_wt_shipping_price[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id'].'_'.$arr_shipping_qty_details[$wq]['sp_applied_on'].'_'.$arr_shipping_qty_details[$wq]['sp_min_qty_id']] = $arr_shipping_qty_details[$wq]['shipping_price'];
									}
								}	
								
								$this->debuglog('[getShippingPrice] Before shipping amt details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_wt_qty:<pre>'.print_r($arr_wt_qty,1).'</pre>');		
								$this->debuglog('[getShippingPrice] Before shipping amt details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_wt_min_qty:<pre>'.print_r($arr_wt_min_qty,1).'</pre>');		
								$this->debuglog('[getShippingPrice] Before shipping amt details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_wt_max_qty:<pre>'.print_r($arr_wt_max_qty,1).'</pre>');		
								$this->debuglog('[getShippingPrice] Before shipping amt details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_wt_shipping_price:<pre>'.print_r($arr_wt_shipping_price,1).'</pre>');		
								
								$arr_shipping_amt_details = $obj_temp->getShippingPriceSPTypewise($city_id,$r2['cart_area_id'],0);
								$this->debuglog('[getShippingPrice] sp_type:0, city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_shipping_amt_details:<pre>'.print_r($arr_shipping_amt_details,1).'</pre>');		
								//echo'<br><pre>';
								//print_r($arr_shipping_amt_details);
								//echo'<br></pre>';
								if(count($arr_shipping_amt_details) > 0 )
								{
									for($shpamt=0;$shpamt<count($arr_shipping_amt_details);$shpamt++)
									{
										$arr_amt_subtotal[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = 0;
										$arr_amt_min_order_amt[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = $arr_shipping_amt_details[$shpamt]['min_order_amount'];
										$arr_amt_max_order_amt[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = $arr_shipping_amt_details[$shpamt]['max_order_amount'];
										$arr_amt_shipping_price[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = $arr_shipping_amt_details[$shpamt]['shipping_price'];
									}
								}

								$this->debuglog('[getShippingPrice] Before shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_amt_subtotal:<pre>'.print_r($arr_amt_subtotal,1).'</pre>');		
								$this->debuglog('[getShippingPrice] Before shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_amt_min_order_amt:<pre>'.print_r($arr_amt_min_order_amt,1).'</pre>');		
								$this->debuglog('[getShippingPrice] Before shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_amt_max_order_amt:<pre>'.print_r($arr_amt_max_order_amt,1).'</pre>');		
								$this->debuglog('[getShippingPrice] Before shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_amt_shipping_price:<pre>'.print_r($arr_amt_shipping_price,1).'</pre>');			
								
								$arr_shipping_per_details = $obj_temp->getShippingPriceSPTypewise($city_id,$r2['cart_area_id'],1);
								$this->debuglog('[getShippingPrice] sp_type:1, city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_shipping_per_details:<pre>'.print_r($arr_shipping_per_details,1).'</pre>');		
								//echo'<br><pre>';
								//print_r($arr_shipping_per_details);
								//echo'<br></pre>';
								if(count($arr_shipping_per_details) > 0 )
								{
									for($shpper=0;$shpper<count($arr_shipping_per_details);$shpper++)
									{
										$arr_per_subtotal[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = 0;
										$arr_per_min_order_amt[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = $arr_shipping_per_details[$shpper]['min_order_amount'];
										$arr_per_max_order_amt[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = $arr_shipping_per_details[$shpper]['max_order_amount'];
										$arr_per_sp_percentage[$r['cart_delivery_date'].'_'.$city_id.'_'.$r2['cart_area_id']] = $arr_shipping_per_details[$shpper]['sp_percentage'];
									}
								}
								
								$this->debuglog('[getShippingPrice] After shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_per_subtotal:<pre>'.print_r($arr_per_subtotal,1).'</pre>');		
								$this->debuglog('[getShippingPrice] After shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_per_min_order_amt:<pre>'.print_r($arr_per_min_order_amt,1).'</pre>');		
								$this->debuglog('[getShippingPrice] After shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_per_max_order_amt:<pre>'.print_r($arr_per_max_order_amt,1).'</pre>');		
								$this->debuglog('[getShippingPrice] After shipping per details city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_per_sp_percentage:<pre>'.print_r($arr_per_sp_percentage,1).'</pre>');			
								*/
								
								$sql3 = "SELECT * FROM `tblcart` WHERE 
								`cart_session_id` = '".$cart_session_id."' AND 
								`cart_city_id` = '".$city_id."' AND 
								`cart_delivery_date` = '".$r['cart_delivery_date']."' AND 
								`cart_area_id` = '".$r2['cart_area_id']."' AND 
								`cart_status` = '0' AND 
								`cart_deleted` = '0' ";
								$this->debuglog('[getShippingPrice] sql3:'.$sql3);
								$STH3 = $DBH->query($sql3);
								if( $STH3->rowCount() > 0 )
								{
									$subtotal = 0;
									$cnt = 0;
									while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
									{	
										//$arr_cusine_details = $obj_temp->getCusineDetailsForCart($r3['cusine_id']);
										$arr_cusine_weight = $obj_temp->getCusineAllWeight($r3['cusine_id']);
										$this->debuglog('[getShippingPrice]arr_cusine_weight cusine_id:'.$r3['cusine_id'].', city_id:'.$city_id.', cart_area_id:'.$r2['cart_area_id'].', arr_cusine_weight:<pre>'.print_r($arr_cusine_weight,1).'</pre>');		
										$temp_cwsp_count = 0;
										if(count($arr_cusine_weight) > 0 )
										{
											$arr_temp_cwsp = array();
											$arr_temp_cwqty = array();
											for($wq=0;$wq<count($arr_cusine_weight);$wq++)
											{
												$temp_wq_key = $r['cart_delivery_date'].'_'.$city_id.'_'.$r3['cart_area_id'].'_'.$arr_cusine_weight[$wq]['cw_qt_cat_id'].'_'.$arr_cusine_weight[$wq]['cw_qu_cat_id'];
												$this->debuglog('[getShippingPrice]arr_cusine_weight cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
												if($obj_temp->chkIfCusineHasQuantityWiseShippingPrice($city_id,$r3['cart_area_id'],$arr_cusine_weight[$wq]['cw_qt_cat_id'],$arr_cusine_weight[$wq]['cw_qu_cat_id']))
												{
													$temp_wq_qty_val =  $arr_cusine_weight[$wq]['cw_quantity'] * $r3['qty'];
													$this->debuglog('[getShippingPrice]chkIfCusineHasQuantityWiseShippingPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
													$temp_cwsp_count++;
													$arr_temp_cwsp[] = $temp_wq_key;
													$arr_temp_cwqty[] = $temp_wq_qty_val;
												}
												else
												{
													$this->debuglog('[getShippingPrice]chkIfCusineHasQuantityWiseShippingPrice:No  cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
												}													
											}
											if($temp_cwsp_count >= 1)
											{
												if(array_key_exists($arr_temp_cwsp[0],$arr_wt_qty))
												{
													$arr_wt_qty[$arr_temp_cwsp[0]] += $arr_temp_cwqty[0];
													$this->debuglog('[getShippingPrice]temp_cwsp_count >= 1 array_key_exists arr_wt_qty:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_cwsp[0]:'.$arr_temp_cwsp[0].', arr_temp_cwqty[0]:'.$arr_temp_cwqty[0]);		
												}
												else
												{
													$arr_wt_qty[$arr_temp_cwsp[0]] = $arr_temp_cwqty[0];
													$this->debuglog('[getShippingPrice]temp_cwsp_count >= 1 array_key_not_exists arr_wt_qty:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_cwsp[0]:'.$arr_temp_cwsp[0].', arr_temp_cwqty[0]:'.$arr_temp_cwqty[0]);		
												}
											}
											else
											{
												if($r3['cart_area_id'] > 0)
												{
													$temp_cwsp_count = 0;
													$arr_temp_cwsp = array();
													$arr_temp_cwqty = array();
													for($wq=0;$wq<count($arr_cusine_weight);$wq++)
													{
														$temp_wq_key = $r['cart_delivery_date'].'_'.$city_id.'_0_'.$arr_cusine_weight[$wq]['cw_qt_cat_id'].'_'.$arr_cusine_weight[$wq]['cw_qu_cat_id'];
														$this->debuglog('[getShippingPrice]cart_area_id=0 arr_cusine_weight cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
														if($obj_temp->chkIfCusineHasQuantityWiseShippingPrice($city_id,0,$arr_cusine_weight[$wq]['cw_qt_cat_id'],$arr_cusine_weight[$wq]['cw_qu_cat_id']))
														{
															$temp_wq_qty_val =  $arr_cusine_weight[$wq]['cw_quantity'] * $r3['qty'];
															$this->debuglog('[getShippingPrice]cart_area_id=0 chkIfCusineHasQuantityWiseShippingPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
															$temp_cwsp_count++;
															$arr_temp_cwsp[] = $temp_wq_key;
															$arr_temp_cwqty[] = $temp_wq_qty_val;
														}
														else
														{
															$this->debuglog('[getShippingPrice]cart_area_id=0 chkIfCusineHasQuantityWiseShippingPrice:No  cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
														}													
													}
													if($temp_cwsp_count >= 1)
													{
														if(array_key_exists($arr_temp_cwsp[0],$arr_wt_qty))
														{
															$arr_wt_qty[$arr_temp_cwsp[0]] += $arr_temp_cwqty[0];
															$this->debuglog('[getShippingPrice]cart_area_id=0 temp_cwsp_count >= 1 array_key_exists arr_wt_qty:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_cwsp[0]:'.$arr_temp_cwsp[0].', arr_temp_cwqty[0]:'.$arr_temp_cwqty[0]);		
														}
														else
														{
															$arr_wt_qty[$arr_temp_cwsp[0]] = $arr_temp_cwqty[0];
															$this->debuglog('[getShippingPrice]cart_area_id=0 temp_cwsp_count >= 1 array_key_not_exists arr_wt_qty:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_cwsp[0]:'.$arr_temp_cwsp[0].', arr_temp_cwqty[0]:'.$arr_temp_cwqty[0]);		
														}
													}	
												}
											}
										}
										
										$temp_amt_count = 0;
										$arr_temp_amtk = array();
										$arr_temp_amts = array();
										if($temp_cwsp_count == 0)
										{
											$temp_amt_key = $r['cart_delivery_date'].'_'.$city_id.'_'.$r3['cart_area_id'];
											$this->debuglog('[getShippingPrice]arr_amt_subtotal cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
											if($obj_temp->chkIfCusineHasAmountWiseShippingPrice($city_id,$r3['cart_area_id']))
											{
												$temp_amt_subtotal =  $r3['subtotal'];
												$this->debuglog('[getShippingPrice]chkIfCusineHasAmountWiseShippingPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
												$temp_amt_count++;
												$arr_temp_amtk[] = $temp_amt_key;
												$arr_temp_amts[] = $temp_amt_subtotal;
											}
											else
											{
												$this->debuglog('[getShippingPrice]chkIfCusineHasAmountWiseShippingPrice:No  cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
											}
											
											if($temp_amt_count > 0)
											{
												if(array_key_exists($arr_temp_amtk[0],$arr_amt_subtotal))
												{
													$arr_amt_subtotal[$arr_temp_amtk[0]] += $arr_temp_amts[0];
													$this->debuglog('[getShippingPrice]temp_amt_count > 0 array_key_exists arr_amt_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_amtk[0]:'.$arr_temp_amtk[0].', arr_temp_amts[0]:'.$arr_temp_amts[0]);		
												}
												else
												{
													$arr_amt_subtotal[$arr_temp_amtk[0]] = $arr_temp_amts[0];
													$this->debuglog('[getShippingPrice]temp_amt_count > 0 array_key_not_exists arr_amt_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_amtk[0]:'.$arr_temp_amtk[0].', arr_temp_amts[0]:'.$arr_temp_amts[0]);		
												}
											}
											else
											{
												if($r3['cart_area_id'] > 0)
												{
													$temp_amt_count = 0;
													$arr_temp_amtk = array();
													$arr_temp_amts = array();
													$temp_amt_key = $r['cart_delivery_date'].'_'.$city_id.'_0';
													$this->debuglog('[getShippingPrice]cart_area_id=0 arr_amt_subtotal cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
													if($obj_temp->chkIfCusineHasAmountWiseShippingPrice($city_id,0))
													{
														$temp_amt_subtotal =  $r3['subtotal'];
														$this->debuglog('[getShippingPrice]cart_area_id=0 chkIfCusineHasAmountWiseShippingPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
														$temp_amt_count++;
														$arr_temp_amtk[] = $temp_amt_key;
														$arr_temp_amts[] = $temp_amt_subtotal;
													}
													else
													{
														$this->debuglog('[getShippingPrice]cart_area_id=0 chkIfCusineHasAmountWiseShippingPrice:No  cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
													}
													
													if($temp_amt_count > 0)
													{
														if(array_key_exists($arr_temp_amtk[0],$arr_amt_subtotal))
														{
															$arr_amt_subtotal[$arr_temp_amtk[0]] += $arr_temp_amts[0];
															$this->debuglog('[getShippingPrice]cart_area_id=0 temp_amt_count > 0 array_key_exists arr_amt_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_amtk[0]:'.$arr_temp_amtk[0].', arr_temp_amts[0]:'.$arr_temp_amts[0]);		
														}
														else
														{
															$arr_amt_subtotal[$arr_temp_amtk[0]] = $arr_temp_amts[0];
															$this->debuglog('[getShippingPrice]cart_area_id=0 temp_amt_count > 0 array_key_not_exists arr_amt_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_amtk[0]:'.$arr_temp_amtk[0].', arr_temp_amts[0]:'.$arr_temp_amts[0]);		
														}
													}
												}
											}
										}
										
										$temp_per_count = 0;
										$arr_temp_perk = array();
										$arr_temp_pers = array();
										if($temp_cwsp_count == 0 && $temp_amt_count == 0)
										{
											$temp_per_key = $r['cart_delivery_date'].'_'.$city_id.'_'.$r3['cart_area_id'];
											$this->debuglog('[getShippingPrice]arr_per_subtotal cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
											if($obj_temp->chkIfCusineHasPercentWiseShippingPrice($city_id,$r3['cart_area_id']))
											{
												$temp_per_subtotal =  $r3['subtotal'];
												$this->debuglog('[getShippingPrice]chkIfCusineHasPercentWiseShippingPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
												$temp_per_count++;
												$arr_temp_perk[] = $temp_per_key;
												$arr_temp_pers[] = $temp_per_subtotal;
											}
											else
											{
												$this->debuglog('[getShippingPrice]chkIfCusineHasPercentWiseShippingPrice:No  cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
											}
											
											if($temp_per_count > 0)
											{
												if(array_key_exists($arr_temp_perk[0],$arr_per_subtotal))
												{
													$arr_per_subtotal[$arr_temp_perk[0]] += $arr_temp_pers[0];
													$this->debuglog('[getShippingPrice]temp_per_count > 0 array_key_exists arr_per_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_perk[0]:'.$arr_temp_perk[0].', arr_temp_pers[0]:'.$arr_temp_pers[0]);		
												}
												else
												{
													$arr_per_subtotal[$arr_temp_perk[0]] = $arr_temp_pers[0];
													$this->debuglog('[getShippingPrice]temp_per_count > 0 array_key_not_exists arr_per_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_perk[0]:'.$arr_temp_perk[0].', arr_temp_pers[0]:'.$arr_temp_pers[0]);		
												}
											}
											else
											{
												if($r3['cart_area_id'] > 0)
												{
													$temp_per_count = 0;
													$arr_temp_perk = array();
													$arr_temp_pers = array();
													$temp_per_key = $r['cart_delivery_date'].'_'.$city_id.'_0';
													$this->debuglog('[getShippingPrice]cart_area_id=0 arr_per_subtotal cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
													if($obj_temp->chkIfCusineHasPercentWiseShippingPrice($city_id,0))
													{
														$temp_amt_subtotal =  $r3['subtotal'];
														$this->debuglog('[getShippingPrice]cart_area_id=0 chkIfCusineHasPercentWiseShippingPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
														$temp_per_count++;
														$arr_temp_perk[] = $temp_per_key;
														$arr_temp_pers[] = $temp_per_subtotal;
													}
													else
													{
														$this->debuglog('[getShippingPrice]cart_area_id=0 chkIfCusineHasPercentageWiseShippingPrice:No  cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
													}
													
													if($temp_per_count > 0)
													{
														if(array_key_exists($arr_temp_perk[0],$arr_per_subtotal))
														{
															$arr_per_subtotal[$arr_temp_perk[0]] += $arr_temp_pers[0];
															$this->debuglog('[getShippingPrice]cart_area_id=0 temp_per_count > 0 array_key_exists arr_per_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_perk[0]:'.$arr_temp_perk[0].', arr_temp_pers[0]:'.$arr_temp_pers[0]);		
														}
														else
														{
															$arr_per_subtotal[$arr_temp_perk[0]] = $arr_temp_pers[0];
															$this->debuglog('[getShippingPrice]cart_area_id=0 temp_per_count > 0 array_key_not_exists arr_per_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_perk[0]:'.$arr_temp_perk[0].', arr_temp_pers[0]:'.$arr_temp_pers[0]);		
														}
													}
												}
											}
											/*
											if(count($arr_amt_subtotal) > 0 )
											{
												$temp_amt_key = $r['cart_delivery_date'].'_'.$city_id.'_'.$r3['cart_area_id'];
												$this->debuglog('[getShippingPrice]arr_amt_subtotal cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
												//echo '<br>temp_amt_key:'.$temp_amt_key;
												if(array_key_exists($temp_amt_key,$arr_amt_subtotal))
												{
													$temp_amt_subtotal =  $r3['subtotal'];
													$this->debuglog('[getShippingPrice]arr_amt_subtotal array_key_exists cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key.', temp_amt_subtotal:'.$temp_amt_subtotal);		
													//echo '<br>temp_amt_subtotal:'.$temp_amt_subtotal;
													$arr_amt_subtotal[$temp_amt_key] += $temp_amt_subtotal;
												}
												else
												{
													$this->debuglog('[getShippingPrice]arr_amt_subtotal array_key_not_exists cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
												}
											}
											else
											{
												if(count($arr_per_subtotal) > 0 )
												{
													$temp_per_key = $r['cart_delivery_date'].'_'.$city_id.'_'.$r3['cart_area_id'];
													$this->debuglog('[getShippingPrice]arr_per_subtotal cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
													//echo '<br>temp_per_key:'.$temp_per_key;
													if(array_key_exists($temp_per_key,$arr_per_subtotal))
													{
														$temp_per_subtotal =  $r3['subtotal'];
														$this->debuglog('[getShippingPrice]arr_per_subtotal array_key_exists cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key.', temp_per_subtotal:'.$temp_per_subtotal);		
														//echo '<br>temp_per_subtotal:'.$temp_per_subtotal;
														$arr_per_subtotal[$temp_per_key] += $temp_per_subtotal;
													}
													else
													{
														$this->debuglog('[getShippingPrice]arr_per_subtotal array_key_not_exists cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
													}
												}	
												
											}
											*/											
										}
										$cnt++;
									}	
								}	
							}
						}	
					}
					/*
					echo '<br><pre>';
					print_r($arr_wt_qty);
					echo '<br></pre>';
					
					echo '<br><pre>';
					print_r($arr_amt_subtotal);
					echo '<br></pre>';
					
					echo '<br><pre>';
					print_r($arr_per_subtotal);
					echo '<br></pre>';
					*/
					
					$this->debuglog('[getShippingPrice]arr_wt_qty :'.print_r($arr_wt_qty,1));		
					if(count($arr_wt_qty) > 0 )
					{
						foreach($arr_wt_qty as $tt_wt_qty_k => $tt_wt_qty_v)
						{
							$this->debuglog('[getShippingPrice]arr_wt_qty tt_wt_qty_k:'.$tt_wt_qty_k.', tt_wt_qty_v:'.$tt_wt_qty_v);		
							if($tt_wt_qty_v > 0 )
							{
								$temp_arr_chk_cwsp = explode('_',$tt_wt_qty_k);
								if(is_array($temp_arr_chk_cwsp) && count($temp_arr_chk_cwsp) > 0)
								{
									$temp_city_id_chk_cwsp = $temp_arr_chk_cwsp[1];	
									$temp_area_id_chk_cwsp = $temp_arr_chk_cwsp[2];	
									$temp_applied_on_chk_cwsp = $temp_arr_chk_cwsp[3];	
									$temp_qty_unit_chk_cwsp = $temp_arr_chk_cwsp[4];

									$arr_cwsp_exact_match_values = array();
									$arr_cwsp_exact_match_values = $obj_temp->getCusineShippingPriceQuantityWise($temp_city_id_chk_cwsp,$temp_area_id_chk_cwsp,$temp_applied_on_chk_cwsp,$temp_qty_unit_chk_cwsp);
									if(count($arr_cwsp_exact_match_values) > 0 )
									{
										$this->debuglog('[getShippingPrice]arr_wt_qty arr_cwsp_exact_match_values:'.print_r($arr_cwsp_exact_match_values,1));
										for($em_cwsp=0;$em_cwsp<count($arr_cwsp_exact_match_values);$em_cwsp++)
										{
											if( ($tt_wt_qty_v >= $arr_cwsp_exact_match_values[$em_cwsp]['sp_min_qty_val']) && ($tt_wt_qty_v <= $arr_cwsp_exact_match_values[$em_cwsp]['sp_max_qty_val']) )
											{
												//echo '<br>tt_wt_qty_k:'.$tt_wt_qty_k;
												$qty_shipping_price += $arr_cwsp_exact_match_values[$em_cwsp]['shipping_price'];	
												$this->debuglog('[getShippingPrice]arr_wt_qty min max match qty_shipping_price:'.$qty_shipping_price.', arr_cwsp_exact_match_values[$em_cwsp][shipping_price]:'.$arr_cwsp_exact_match_values[$em_cwsp]['shipping_price'].', sp_id:'.$arr_cwsp_exact_match_values[$em_cwsp]['sp_id']);		
												break;
											}	
											else
											{
												$this->debuglog('[getShippingPrice]arr_wt_qty min max not match arr_cwsp_exact_match_values[$em_cwsp][sp_min_qty_val]:'.$arr_cwsp_exact_match_values[$em_cwsp]['sp_min_qty_val'].', arr_cwsp_exact_match_values[$em_cwsp][sp_max_qty_val]:'.$arr_cwsp_exact_match_values[$em_cwsp]['sp_max_qty_val'].', sp_id:'.$arr_cwsp_exact_match_values[$em_cwsp]['sp_id']);			
											}
										}											
									}
									else
									{
										$this->debuglog('[getShippingPrice]arr_wt_qty arr_cwsp_exact_match_values:No records');		
									}
									/*
									if(array_key_exists($tt_wt_qty_k,$arr_wt_min_qty) && array_key_exists($tt_wt_qty_k,$arr_wt_max_qty) && array_key_exists($tt_wt_qty_k,$arr_wt_shipping_price) )
									{
										$this->debuglog('[getShippingPrice]arr_wt_qty array_key_exists tt_wt_qty_k:'.$tt_wt_qty_k.', tt_wt_qty_v:'.$tt_wt_qty_v);		
										if( ($tt_wt_qty_v >= $arr_wt_min_qty[$tt_wt_qty_k]) && ($tt_wt_qty_v <= $arr_wt_max_qty[$tt_wt_qty_k]) )
										{
											//echo '<br>tt_wt_qty_k:'.$tt_wt_qty_k;
											$qty_shipping_price += $arr_wt_shipping_price[$tt_wt_qty_k];	
											$this->debuglog('[getShippingPrice]arr_wt_qty min max match qty_shipping_price:'.$qty_shipping_price.', arr_wt_shipping_price[$tt_wt_qty_k]:'.$arr_wt_shipping_price[$tt_wt_qty_k]);		
										}
									}
									else
									{
										$this->debuglog('[getShippingPrice]arr_wt_qty array_key_not_exists tt_wt_qty_k:'.$tt_wt_qty_k.', tt_wt_qty_v:'.$tt_wt_qty_v);		
									}
									*/									
								}
								else
								{
									$this->debuglog('[getShippingPrice]arr_wt_qty invalid key tt_wt_qty_k:'.$tt_wt_qty_k.', tt_wt_qty_v:'.$tt_wt_qty_v);		
								}
							}
						}
					}
					
					
					$this->debuglog('[getShippingPrice]arr_amt_subtotal :'.print_r($arr_amt_subtotal,1));		
					if(count($arr_amt_subtotal) > 0 )
					{
						foreach($arr_amt_subtotal as $tt_amt_qty_k => $tt_amt_qty_v)
						{
							$this->debuglog('[getShippingPrice]arr_amt_subtotal tt_amt_qty_k:'.$tt_amt_qty_k.', tt_amt_qty_v:'.$tt_amt_qty_v);		
							if($tt_amt_qty_v > 0 )
							{
								$temp_arr_chk_amt = explode('_',$tt_amt_qty_k);
								if(is_array($temp_arr_chk_amt) && count($temp_arr_chk_amt) > 0)
								{
									$temp_city_id_chk_amt = $temp_arr_chk_amt[1];	
									$temp_area_id_chk_amt = $temp_arr_chk_amt[2];	
									
									$arr_amt_exact_match_values = array();
									$arr_amt_exact_match_values = $obj_temp->getCusineShippingPriceAmountWise($temp_city_id_chk_amt,$temp_area_id_chk_amt);
									if(count($arr_amt_exact_match_values) > 0 )
									{
										$this->debuglog('[getShippingPrice]arr_amt_subtotal arr_amt_exact_match_values:'.print_r($arr_amt_exact_match_values,1));
										for($em_amt=0;$em_amt<count($arr_amt_exact_match_values);$em_amt++)
										{
											if( ($tt_amt_qty_v >= $arr_amt_exact_match_values[$em_amt]['min_order_amount']) && ($tt_amt_qty_v <= $arr_amt_exact_match_values[$em_amt]['max_order_amount']) )
											{
												//echo '<br>tt_amt_qty_k:'.$tt_amt_qty_k;
												$amt_shipping_price += $arr_amt_exact_match_values[$em_amt]['shipping_price'];	
												$this->debuglog('[getShippingPrice]arr_amt_subtotal min max match amt_shipping_price:'.$amt_shipping_price.', arr_amt_exact_match_values[$em_amt][shipping_price]:'.$arr_amt_exact_match_values[$em_amt]['shipping_price'].', sp_id:'.$arr_amt_exact_match_values[$em_amt]['sp_id']);		
												break;
											}	
											else
											{
												$this->debuglog('[getShippingPrice]arr_amt_subtotal min max not match arr_amt_exact_match_values[$em_amt][min_order_amount]:'.$arr_amt_exact_match_values[$em_amt]['min_order_amount'].', arr_amt_exact_match_values[$em_amt][max_order_amount]:'.$arr_amt_exact_match_values[$em_amt]['max_order_amount'].', sp_id:'.$arr_amt_exact_match_values[$em_amt]['sp_id']);			
											}
										}											
									}
									else
									{
										$this->debuglog('[getShippingPrice]arr_amt_qty arr_amt_exact_match_values:No records');		
									}
									/*
									//echo '<br>tt_amt_qty_k:'.$tt_amt_qty_k;
									if(array_key_exists($tt_amt_qty_k,$arr_amt_min_order_amt) && array_key_exists($tt_amt_qty_k,$arr_amt_max_order_amt) && array_key_exists($tt_amt_qty_k,$arr_amt_shipping_price) )
									{
										$this->debuglog('[getShippingPrice]arr_amt_subtotal array_key_exists tt_amt_qty_k:'.$tt_amt_qty_k.', tt_amt_qty_v:'.$tt_wt_qty_v);		
										if( ($tt_amt_qty_v >= $arr_amt_min_order_amt[$tt_amt_qty_k]) && ($tt_amt_qty_v <= $arr_amt_max_order_amt[$tt_amt_qty_k]) )
										{
											//echo '<br>tt_amt_qty_k:'.$tt_amt_qty_k;
											$amt_shipping_price += $arr_amt_shipping_price[$tt_amt_qty_k];	
											$this->debuglog('[getShippingPrice]arr_amt_subtotal min max match amt_shipping_price:'.$amt_shipping_price.', arr_amt_shipping_price[$tt_amt_qty_k]:'.$arr_amt_shipping_price[$tt_amt_qty_k]);		
										}
									}
									else
									{
										$this->debuglog('[getShippingPrice]arr_amt_subtotal array_key_not_exists tt_amt_qty_k:'.$tt_amt_qty_k.', tt_amt_qty_v:'.$tt_wt_qty_v);		
									}
									*/									
								}
								else
								{
									$this->debuglog('[getShippingPrice]arr_amt_subtotal invalid key tt_amt_qty_k:'.$tt_amt_qty_k.', tt_amt_qty_v:'.$tt_amt_qty_v);		
								}
							}
						}
					}
					
					$this->debuglog('[getShippingPrice]arr_per_subtotal :'.print_r($arr_per_subtotal,1));		
					if(count($arr_per_subtotal) > 0 )
					{
						foreach($arr_per_subtotal as $tt_per_qty_k => $tt_per_qty_v)
						{
							$this->debuglog('[getShippingPrice]arr_per_subtotal tt_per_qty_k:'.$tt_per_qty_k.', tt_per_qty_v:'.$tt_per_qty_v);		
							if($tt_per_qty_v > 0 )
							{
								$temp_arr_chk_per = explode('_',$tt_per_qty_k);
								if(is_array($temp_arr_chk_per) && count($temp_arr_chk_per) > 0)
								{
									$temp_city_id_chk_per = $temp_arr_chk_per[1];	
									$temp_area_id_chk_per = $temp_arr_chk_per[2];	
									
									$arr_per_exact_match_values = array();
									$arr_per_exact_match_values = $obj_temp->getCusineShippingPricePercentWise($temp_city_id_chk_per,$temp_area_id_chk_per);
									if(count($arr_per_exact_match_values) > 0 )
									{
										$this->debuglog('[getShippingPrice]arr_per_subtotal arr_per_exact_match_values:'.print_r($arr_per_exact_match_values,1));
										for($em_per=0;$em_per<count($arr_per_exact_match_values);$em_per++)
										{
											if( ($tt_per_qty_v >= $arr_per_exact_match_values[$em_per]['min_order_amount']) && ($tt_per_qty_v <= $arr_per_exact_match_values[$em_per]['max_order_amount']) )
											{
												//echo '<br>tt_per_qty_k:'.$tt_per_qty_k;
												$temp_per_val = $tt_per_qty_v * $arr_per_exact_match_values[$em_per]['sp_percentage'] / 100;
												$per_shipping_price += $temp_per_val;	
												$this->debuglog('[getShippingPrice]arr_per_subtotal min max match per_shipping_price:'.$per_shipping_price.', arr_per_exact_match_values[$em_per][sp_percentage]:'.$arr_per_exact_match_values[$em_per]['sp_percentage'].', sp_id:'.$arr_per_exact_match_values[$em_per]['sp_id']);		
												break;
											}	
											else
											{
												$this->debuglog('[getShippingPrice]arr_per_subtotal min max not match arr_per_exact_match_values[$em_per][min_order_amount]:'.$arr_per_exact_match_values[$em_per]['min_order_amount'].', arr_per_exact_match_values[$em_per][max_order_amount]:'.$arr_per_exact_match_values[$em_per]['max_order_amount'].', sp_id:'.$arr_per_exact_match_values[$em_per]['sp_id']);			
											}
										}											
									}
									else
									{
										$this->debuglog('[getShippingPrice]arr_per_qty arr_per_exact_match_values:No records');		
									}
									/*
									//echo '<br>tt_per_qty_k:'.$tt_per_qty_k;
									if(array_key_exists($tt_per_qty_k,$arr_per_min_order_amt) && array_key_exists($tt_per_qty_k,$arr_per_max_order_amt) && array_key_exists($tt_per_qty_k,$arr_per_sp_percentage) )
									{
										$this->debuglog('[getShippingPrice]arr_per_subtotal array_key_exists tt_per_qty_k:'.$tt_per_qty_k.', tt_per_qty_v:'.$tt_per_qty_v);		
										if( ($tt_per_qty_v >= $arr_per_min_order_amt[$tt_per_qty_k]) && ($tt_per_qty_v <= $arr_per_max_order_amt[$tt_per_qty_k]) )
										{
											//echo '<br>tt_per_qty_k:'.$tt_per_qty_k;
											$temp_per_val = $tt_per_qty_v * $arr_per_sp_percentage[$tt_per_qty_k] / 100;
											$per_shipping_price += $temp_per_val;	
											$this->debuglog('[getShippingPrice]arr_per_subtotal min max match per_shipping_price:'.$per_shipping_price.', arr_per_sp_percentage[$tt_per_qty_k]:'.$arr_per_sp_percentage[$tt_per_qty_k].', tt_per_qty_v:'.$tt_per_qty_v.', temp_per_val:'.$temp_per_val);		
										}
									}
									else
									{
										$this->debuglog('[getShippingPrice]arr_per_subtotal array_key_not_exists tt_per_qty_k:'.$tt_per_qty_k.', tt_per_qty_v:'.$tt_per_qty_v);		
									}
									*/									
								}
								else
								{
									$this->debuglog('[getShippingPrice]arr_per_subtotal invalid key tt_per_qty_k:'.$tt_per_qty_k.', tt_per_qty_v:'.$tt_per_qty_v);		
								}
							}
						}
					}
				}
			}		
			
			$total_shipping_price = $qty_shipping_price + $amt_shipping_price + $per_shipping_price;
			$this->debuglog('[getShippingPrice]qty_shipping_price:'.$qty_shipping_price);
			$this->debuglog('[getShippingPrice]amt_shipping_price:'.$amt_shipping_price);
			$this->debuglog('[getShippingPrice]per_shipping_price:'.$per_shipping_price);
			$this->debuglog('[getShippingPrice]total_shipping_price:'.$total_shipping_price);
			
		} catch (Exception $e) {
			$stringData = '[getShippingPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $total_shipping_price;
		}	
		return $total_shipping_price;
	}
	
	public function getTradeDiscountPrice($subtotal,$city_id,$area_id='')
	{
		$DBH = new DatabaseHandler();
		$output = 0;
		
		if($subtotal == '' || $subtotal < 1)
		{
			return $output;
		}
		
		$today = date('Y-m-d');
		
		$total_discount_price = 0;
		$qty_discount_price = 0;
		$amt_discount_price = 0;
		$per_discount_price = 0;

		$arr_wt_qty = array();
		$arr_wt_min_qty = array();
		$arr_wt_max_qty = array();
		$arr_wt_discount_price = array();
		
		$arr_amt_subtotal = array();
		$arr_amt_min_order_amt = array();
		$arr_amt_max_order_amt = array();
		$arr_amt_discount_price = array();
		
		$arr_per_subtotal = array();
		$arr_per_min_order_amt = array();
		$arr_per_max_order_amt = array();
		$arr_per_sp_percentage = array();
		
		$obj_temp = new commonFunctions();
		try {
			
			$cart_session_id = session_id();
			$sql = "SELECT * FROM `tblcart` WHERE 
			`cart_session_id` = '".$cart_session_id."' AND 
			`cart_city_id` = '".$city_id."' AND 
			`cart_status` = '0' AND 
			`cart_deleted` = '0' ";
			$this->debuglog('[getTradeDiscountPrice] sql:'.$sql);
			$STH3 = $DBH->query($sql);
			if( $STH3->rowCount() > 0 )
			{
				$subtotal = 0;
				$cnt = 0;
				while($r3 = $STH3->fetch(PDO::FETCH_ASSOC))
				{	
					//$arr_cusine_details = $obj_temp->getCusineDetailsForCart($r3['cusine_id']);
					$arr_cusine_weight = $obj_temp->getCusineAllWeight($r3['cusine_id']);
					$this->debuglog('[getTradeDiscountPrice]arr_cusine_weight cusine_id:'.$r3['cusine_id'].', city_id:'.$city_id.', arr_cusine_weight:<pre>'.print_r($arr_cusine_weight,1).'</pre>');		
					$temp_cwsp_count = 0;
					if(count($arr_cusine_weight) > 0 )
					{
						$arr_temp_cwsp = array();
						$arr_temp_cwqty = array();
						for($wq=0;$wq<count($arr_cusine_weight);$wq++)
						{
							$temp_wq_key = $city_id.'_'.$arr_cusine_weight[$wq]['cw_qt_cat_id'].'_'.$arr_cusine_weight[$wq]['cw_qu_cat_id'];
							$this->debuglog('[getTradeDiscountPrice]arr_cusine_weight cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
							if($obj_temp->chkIfCusineHasQuantityWiseTradeDiscountPrice($city_id,$r3['cart_area_id'],$arr_cusine_weight[$wq]['cw_qt_cat_id'],$arr_cusine_weight[$wq]['cw_qu_cat_id']))
							{
								$temp_wq_qty_val =  $arr_cusine_weight[$wq]['cw_quantity'] * $r3['qty'];
								$this->debuglog('[getTradeDiscountPrice]chkIfCusineHasQuantityWiseTradeDiscountPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
								$temp_cwsp_count++;
								$arr_temp_cwsp[] = $temp_wq_key;
								$arr_temp_cwqty[] = $temp_wq_qty_val;
							}
							else
							{
								$this->debuglog('[getTradeDiscountPrice]chkIfCusineHasQuantityWiseTradeDiscountPrice:No  cusine_id:'.$r3['cusine_id'].', temp_wq_key:'.$temp_wq_key);		
							}													
						}
						if($temp_cwsp_count >= 1)
						{
							if(array_key_exists($arr_temp_cwsp[0],$arr_wt_qty))
							{
								$arr_wt_qty[$arr_temp_cwsp[0]] += $arr_temp_cwqty[0];
								$this->debuglog('[getTradeDiscountPrice]temp_cwsp_count >= 1 array_key_exists arr_wt_qty:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_cwsp[0]:'.$arr_temp_cwsp[0].', arr_temp_cwqty[0]:'.$arr_temp_cwqty[0]);		
							}
							else
							{
								$arr_wt_qty[$arr_temp_cwsp[0]] = $arr_temp_cwqty[0];
								$this->debuglog('[getTradeDiscountPrice]temp_cwsp_count >= 1 array_key_not_exists arr_wt_qty:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_cwsp[0]:'.$arr_temp_cwsp[0].', arr_temp_cwqty[0]:'.$arr_temp_cwqty[0]);		
							}
						}
					}
					
					$temp_amt_count = 0;
					$arr_temp_amtk = array();
					$arr_temp_amts = array();
					if($temp_cwsp_count == 0)
					{
						$temp_amt_key = $city_id;
						$this->debuglog('[getTradeDiscountPrice]arr_amt_subtotal cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
						if($obj_temp->chkIfCusineHasAmountWiseTradeDiscountPrice($city_id,$r3['cart_area_id']))
						{
							$temp_amt_subtotal =  $r3['subtotal'];
							$this->debuglog('[getTradeDiscountPrice]chkIfCusineHasAmountWiseTradeDiscountPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
							$temp_amt_count++;
							$arr_temp_amtk[] = $temp_amt_key;
							$arr_temp_amts[] = $temp_amt_subtotal;
						}
						else
						{
							$this->debuglog('[getTradeDiscountPrice]chkIfCusineHasAmountWiseTradeDiscountPrice:No  cusine_id:'.$r3['cusine_id'].', temp_amt_key:'.$temp_amt_key);		
						}
						
						if($temp_amt_count > 0)
						{
							if(array_key_exists($arr_temp_amtk[0],$arr_amt_subtotal))
							{
								$arr_amt_subtotal[$arr_temp_amtk[0]] += $arr_temp_amts[0];
								$this->debuglog('[getTradeDiscountPrice]temp_amt_count > 0 array_key_exists arr_amt_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_amtk[0]:'.$arr_temp_amtk[0].', arr_temp_amts[0]:'.$arr_temp_amts[0]);		
							}
							else
							{
								$arr_amt_subtotal[$arr_temp_amtk[0]] = $arr_temp_amts[0];
								$this->debuglog('[getTradeDiscountPrice]temp_amt_count > 0 array_key_not_exists arr_amt_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_amtk[0]:'.$arr_temp_amtk[0].', arr_temp_amts[0]:'.$arr_temp_amts[0]);		
							}
						}
					}
					
					$temp_per_count = 0;
					$arr_temp_perk = array();
					$arr_temp_pers = array();
					if($temp_cwsp_count == 0 && $temp_amt_count == 0)
					{
						$temp_per_key = $city_id;
						$this->debuglog('[getTradeDiscountPrice]arr_per_subtotal cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
						if($obj_temp->chkIfCusineHasPercentWiseTradeDiscountPrice($city_id,$r3['cart_area_id']))
						{
							$temp_per_subtotal =  $r3['subtotal'];
							$this->debuglog('[getTradeDiscountPrice]chkIfCusineHasPercentWiseTradeDiscountPrice:Yes  cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
							$temp_per_count++;
							$arr_temp_perk[] = $temp_per_key;
							$arr_temp_pers[] = $temp_per_subtotal;
						}
						else
						{
							$this->debuglog('[getTradeDiscountPrice]chkIfCusineHasPercentWiseTradeDiscountPrice:No  cusine_id:'.$r3['cusine_id'].', temp_per_key:'.$temp_per_key);		
						}
						
						if($temp_per_count > 0)
						{
							if(array_key_exists($arr_temp_perk[0],$arr_per_subtotal))
							{
								$arr_per_subtotal[$arr_temp_perk[0]] += $arr_temp_pers[0];
								$this->debuglog('[getTradeDiscountPrice]temp_per_count > 0 array_key_exists arr_per_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_perk[0]:'.$arr_temp_perk[0].', arr_temp_pers[0]:'.$arr_temp_pers[0]);		
							}
							else
							{
								$arr_per_subtotal[$arr_temp_perk[0]] = $arr_temp_pers[0];
								$this->debuglog('[getTradeDiscountPrice]temp_per_count > 0 array_key_not_exists arr_per_subtotal:Yes  cusine_id:'.$r3['cusine_id'].', arr_temp_perk[0]:'.$arr_temp_perk[0].', arr_temp_pers[0]:'.$arr_temp_pers[0]);		
							}
						}
					}
					$cnt++;
				}	
			}	
							
			/*
			echo '<br><pre>';
			print_r($arr_wt_qty);
			echo '<br></pre>';
			
			echo '<br><pre>';
			print_r($arr_amt_subtotal);
			echo '<br></pre>';
			
			echo '<br><pre>';
			print_r($arr_per_subtotal);
			echo '<br></pre>';
			*/
			
			$this->debuglog('[getTradeDiscountPrice]arr_wt_qty :'.print_r($arr_wt_qty,1));		
			if(count($arr_wt_qty) > 0 )
			{
				foreach($arr_wt_qty as $tt_wt_qty_k => $tt_wt_qty_v)
				{
					$this->debuglog('[getTradeDiscountPrice]arr_wt_qty tt_wt_qty_k:'.$tt_wt_qty_k.', tt_wt_qty_v:'.$tt_wt_qty_v);		
					if($tt_wt_qty_v > 0 )
					{
						$temp_arr_chk_cwsp = explode('_',$tt_wt_qty_k);
						if(is_array($temp_arr_chk_cwsp) && count($temp_arr_chk_cwsp) > 0)
						{
							$temp_city_id_chk_cwsp = $temp_arr_chk_cwsp[0];	
							$temp_area_id_chk_cwsp = '';	
							$temp_applied_on_chk_cwsp = $temp_arr_chk_cwsp[1];	
							$temp_qty_unit_chk_cwsp = $temp_arr_chk_cwsp[2];

							$arr_cwsp_exact_match_values = array();
							$arr_cwsp_exact_match_values = $obj_temp->getCusineTradeDiscountPriceQuantityWise($temp_city_id_chk_cwsp,$temp_area_id_chk_cwsp,$temp_applied_on_chk_cwsp,$temp_qty_unit_chk_cwsp);
							if(count($arr_cwsp_exact_match_values) > 0 )
							{
								$this->debuglog('[getTradeDiscountPrice]arr_wt_qty arr_cwsp_exact_match_values:'.print_r($arr_cwsp_exact_match_values,1));
								for($em_cwsp=0;$em_cwsp<count($arr_cwsp_exact_match_values);$em_cwsp++)
								{
									if( ($tt_wt_qty_v >= $arr_cwsp_exact_match_values[$em_cwsp]['dc_min_qty_val']) && ($tt_wt_qty_v <= $arr_cwsp_exact_match_values[$em_cwsp]['dc_max_qty_val']) )
									{
										//echo '<br>tt_wt_qty_k:'.$tt_wt_qty_k;
										$qty_discount_price += $arr_cwsp_exact_match_values[$em_cwsp]['discount_price'];	
										$this->debuglog('[getTradeDiscountPrice]arr_wt_qty min max match qty_discount_price:'.$qty_discount_price.', arr_cwsp_exact_match_values[$em_cwsp][discount_price]:'.$arr_cwsp_exact_match_values[$em_cwsp]['discount_price'].', dc_id:'.$arr_cwsp_exact_match_values[$em_cwsp]['dc_id']);		
										break;
									}	
									else
									{
										$this->debuglog('[getTradeDiscountPrice]arr_wt_qty min max not match arr_cwsp_exact_match_values[$em_cwsp][dc_min_qty_val]:'.$arr_cwsp_exact_match_values[$em_cwsp]['dc_min_qty_val'].', arr_cwsp_exact_match_values[$em_cwsp][dc_max_qty_val]:'.$arr_cwsp_exact_match_values[$em_cwsp]['dc_max_qty_val'].', dc_id:'.$arr_cwsp_exact_match_values[$em_cwsp]['dc_id']);			
									}
								}											
							}
							else
							{
								$this->debuglog('[getTradeDiscountPrice]arr_wt_qty arr_cwsp_exact_match_values:No records');		
							}
																
						}
						else
						{
							$this->debuglog('[getTradeDiscountPrice]arr_wt_qty invalid key tt_wt_qty_k:'.$tt_wt_qty_k.', tt_wt_qty_v:'.$tt_wt_qty_v);		
						}
					}
				}
			}
			
			if($qty_discount_price == 0)
			{
				$this->debuglog('[getTradeDiscountPrice]arr_amt_subtotal :'.print_r($arr_amt_subtotal,1));		
				if(count($arr_amt_subtotal) > 0 )
				{
					foreach($arr_amt_subtotal as $tt_amt_qty_k => $tt_amt_qty_v)
					{
						$this->debuglog('[getTradeDiscountPrice]arr_amt_subtotal tt_amt_qty_k:'.$tt_amt_qty_k.', tt_amt_qty_v:'.$tt_amt_qty_v);		
						if($tt_amt_qty_v > 0 )
						{
							$temp_city_id_chk_amt = $tt_amt_qty_k;	
							$temp_area_id_chk_amt = '';	
							
							$arr_amt_exact_match_values = array();
							$arr_amt_exact_match_values = $obj_temp->getCusineTradeDiscountPriceAmountWise($temp_city_id_chk_amt,$temp_area_id_chk_amt);
							if(count($arr_amt_exact_match_values) > 0 )
							{
								$this->debuglog('[getTradeDiscountPrice]arr_amt_subtotal arr_amt_exact_match_values:'.print_r($arr_amt_exact_match_values,1));
								for($em_amt=0;$em_amt<count($arr_amt_exact_match_values);$em_amt++)
								{
									if( ($tt_amt_qty_v >= $arr_amt_exact_match_values[$em_amt]['min_order_amount']) && ($tt_amt_qty_v <= $arr_amt_exact_match_values[$em_amt]['max_order_amount']) )
									{
										//echo '<br>tt_amt_qty_k:'.$tt_amt_qty_k;
										$amt_discount_price += $arr_amt_exact_match_values[$em_amt]['discount_price'];	
										$this->debuglog('[getTradeDiscountPrice]arr_amt_subtotal min max match amt_discount_price:'.$amt_discount_price.', arr_amt_exact_match_values[$em_amt][discount_price]:'.$arr_amt_exact_match_values[$em_amt]['discount_price'].', dc_id:'.$arr_amt_exact_match_values[$em_amt]['dc_id']);		
										break;
									}	
									else
									{
										$this->debuglog('[getTradeDiscountPrice]arr_amt_subtotal min max not match arr_amt_exact_match_values[$em_amt][min_order_amount]:'.$arr_amt_exact_match_values[$em_amt]['min_order_amount'].', arr_amt_exact_match_values[$em_amt][max_order_amount]:'.$arr_amt_exact_match_values[$em_amt]['max_order_amount'].', dc_id:'.$arr_amt_exact_match_values[$em_amt]['dc_id']);			
									}
								}											
							}
							else
							{
								$this->debuglog('[getTradeDiscountPrice]arr_amt_qty arr_amt_exact_match_values:No records');		
							}
						}
					}
				}
				
				if($amt_discount_price == 0)
				{
					$this->debuglog('[getTradeDiscountPrice]arr_per_subtotal :'.print_r($arr_per_subtotal,1));		
					if(count($arr_per_subtotal) > 0 )
					{
						foreach($arr_per_subtotal as $tt_per_qty_k => $tt_per_qty_v)
						{
							$this->debuglog('[getTradeDiscountPrice]arr_per_subtotal tt_per_qty_k:'.$tt_per_qty_k.', tt_per_qty_v:'.$tt_per_qty_v);		
							if($tt_per_qty_v > 0 )
							{
								$temp_city_id_chk_per = $tt_per_qty_k;	
								$temp_area_id_chk_per = '';	
								
								$arr_per_exact_match_values = array();
								$arr_per_exact_match_values = $obj_temp->getCusineTradeDiscountPricePercentWise($temp_city_id_chk_per,$temp_area_id_chk_per);
								if(count($arr_per_exact_match_values) > 0 )
								{
									$this->debuglog('[getTradeDiscountPrice]arr_per_subtotal arr_per_exact_match_values:'.print_r($arr_per_exact_match_values,1));
									for($em_per=0;$em_per<count($arr_per_exact_match_values);$em_per++)
									{
										if( ($tt_per_qty_v >= $arr_per_exact_match_values[$em_per]['min_order_amount']) && ($tt_per_qty_v <= $arr_per_exact_match_values[$em_per]['max_order_amount']) )
										{
											//echo '<br>tt_per_qty_k:'.$tt_per_qty_k;
											$temp_per_val = $tt_per_qty_v * $arr_per_exact_match_values[$em_per]['dc_percentage'] / 100;
											$per_discount_price += $temp_per_val;	
											$this->debuglog('[getTradeDiscountPrice]arr_per_subtotal min max match per_discount_price:'.$per_discount_price.', arr_per_exact_match_values[$em_per][dc_percentage]:'.$arr_per_exact_match_values[$em_per]['dc_percentage'].', dc_id:'.$arr_per_exact_match_values[$em_per]['dc_id']);		
											break;
										}	
										else
										{
											$this->debuglog('[getTradeDiscountPrice]arr_per_subtotal min max not match arr_per_exact_match_values[$em_per][min_order_amount]:'.$arr_per_exact_match_values[$em_per]['min_order_amount'].', arr_per_exact_match_values[$em_per][max_order_amount]:'.$arr_per_exact_match_values[$em_per]['max_order_amount'].', dc_id:'.$arr_per_exact_match_values[$em_per]['dc_id']);			
										}
									}											
								}
								else
								{
									$this->debuglog('[getTradeDiscountPrice]arr_per_qty arr_per_exact_match_values:No records');		
								}
							}
						}
					}	
				}
					
			}
			
					
			
			$total_discount_price = $qty_discount_price + $amt_discount_price + $per_discount_price;
			$this->debuglog('[getTradeDiscountPrice]qty_discount_price:'.$qty_discount_price);
			$this->debuglog('[getTradeDiscountPrice]amt_discount_price:'.$amt_discount_price);
			$this->debuglog('[getTradeDiscountPrice]per_discount_price:'.$per_discount_price);
			$this->debuglog('[getTradeDiscountPrice]total_discount_price:'.$total_discount_price);
			
		} catch (Exception $e) {
			$stringData = '[getTradeDiscountPrice] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $total_discount_price;
		}	
		return $total_discount_price;
	}
	
	public function getTaxDetailsByTaxId($tax_id)
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
		$today = date('Y-m-d');
		try {
			
			$sql = "SELECT * FROM `tbltaxes` WHERE tax_id = '".$tax_id."' AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1'  ";				
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{	
					$output = $r;
				}
			}
			
		} catch (Exception $e) {
			$stringData = '[getTaxDetailsByTaxId] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}	
	
	public function getTaxDetails($city_id,$area_id='')
	{
		$DBH = new DatabaseHandler();
		$output = array();
		
				
		$state_id = $this->getStateIdOfCityId($city_id);
		$country_id = $this->getCountryIdOfCityId($city_id);
		
		$today = date('Y-m-d');
		try {
			
			if($area_id == '' || $area_id == '-1' || $area_id == '0')
			{
				$sql = "SELECT * FROM `tbltaxes` 
					WHERE ( 
						(tax_area_id = '-1' AND tax_city_id = '".$city_id."' ) OR 
						(tax_area_id = '-1' AND FIND_IN_SET(".$city_id.", tax_city_id) > 0 ) 
					) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";				
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output = $r;
					}
				}
				else
				{
					$sql = "SELECT * FROM `tbltaxes` 
					WHERE ( 
						( tax_area_id = '-1' AND tax_city_id = '-1' AND tax_state_id = '".$state_id."' ) OR 
						( tax_area_id = '-1' AND tax_city_id = '-1' AND FIND_IN_SET(".$state_id.", tax_state_id) > 0 )  
					) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";				
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r= $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output = $r;
						}
					}
					else
					{
						$sql = "SELECT * FROM `tbltaxes` 
						WHERE ( 
							( tax_area_id = '-1' AND tax_city_id = '-1' AND tax_state_id = '-1' AND tax_country_id = '".$country_id."' ) OR 
							( tax_area_id = '-1' AND tax_city_id = '-1' AND tax_state_id = '-1' AND FIND_IN_SET(".$country_id.", tax_country_id) > 0  ) 
						) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";								
						$STH3 = $DBH->query($sql);
						if( $STH3->rowCount() > 0 )
						{
							while($r= $STH3->fetch(PDO::FETCH_ASSOC))
							{	
								$output = $r;
							}
						}
						else
						{
							$sql = "SELECT * FROM `tbltaxes` 
							WHERE ( 
								( tax_area_id = '-1' AND tax_city_id = '-1' AND tax_state_id = '-1' AND tax_country_id = '-1' ) 
							) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";								
							$STH4 = $DBH->query($sql);
							if( $STH4->rowCount() > 0 )
							{
								while($r= $STH4->fetch(PDO::FETCH_ASSOC))
								{	
									$output = $r;
								}
							}
						}	
					}	
				}
			}
			else
			{
				$sql = "SELECT * FROM `tbltaxes` 
					WHERE ( 
						( tax_city_id = '".$city_id."' AND tax_area_id = '".$area_id."' ) OR 
						( FIND_IN_SET(".$city_id.", tax_city_id) > 0 AND tax_area_id = '".$area_id."' ) OR 
						( tax_city_id = '-1' AND tax_area_id = '".$area_id."' ) OR 
						( tax_city_id = '".$city_id."' AND FIND_IN_SET(".$area_id.", tax_area_id) > 0  ) OR 
						( FIND_IN_SET(".$city_id.", tax_city_id) > 0 AND FIND_IN_SET(".$area_id.", tax_area_id) > 0  ) OR 
						( tax_city_id = '-1' AND FIND_IN_SET(".$area_id.", tax_area_id) > 0  ) 
					) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";							
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{	
						$output = $r;
					}
				}	
				else
				{
					$sql = "SELECT * FROM `tbltaxes` 
						WHERE ( 
							( tax_city_id = '".$city_id."' AND tax_area_id = '-1' ) OR 
							( FIND_IN_SET(".$city_id.", tax_city_id) > 0 AND tax_area_id = '-1'  ) 
						) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";							
					$STH2 = $DBH->query($sql);
					if( $STH2->rowCount() > 0 )
					{
						while($r= $STH2->fetch(PDO::FETCH_ASSOC))
						{	
							$output = $r;
						}
					}	
					else
					{
						$sql = "SELECT * FROM `tbltaxes` 
							WHERE ( 
								( tax_city_id = '-1' AND tax_area_id = '-1' AND tax_state_id = '".$state_id."' ) OR 
								( tax_city_id = '-1' AND tax_area_id = '-1' AND FIND_IN_SET(".$state_id.", tax_state_id) > 0 )  
							) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";							
						$STH2 = $DBH->query($sql);
						if( $STH2->rowCount() > 0 )
						{
							while($r= $STH2->fetch(PDO::FETCH_ASSOC))
							{	
								$output = $r;
							}
						}	
						else
						{
							$sql = "SELECT * FROM `tbltaxes` 
								WHERE ( 
									( tax_city_id = '-1' AND tax_area_id = '-1' AND tax_state_id = '-1' AND tax_country_id = '".$country_id."' ) OR 
									( tax_city_id = '-1' AND tax_area_id = '-1' AND tax_state_id = '-1' AND FIND_IN_SET(".$country_id.", tax_country_id) > 0  )  
								) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";							
							$STH2 = $DBH->query($sql);
							if( $STH2->rowCount() > 0 )
							{
								while($r= $STH2->fetch(PDO::FETCH_ASSOC))
								{	
									$output = $r;
								}
							}	
							else
							{
								$sql = "SELECT * FROM `tbltaxes` 
									WHERE ( 
										( tax_city_id = '-1' AND tax_area_id = '-1' AND tax_state_id = '-1' AND tax_country_id = '-1' )
									) AND tax_effective_date <= '".$today."' AND tax_deleted = '0' AND tax_status = '1' ORDER BY tax_effective_date DESC LIMIT 1 ";							
								$STH2 = $DBH->query($sql);
								if( $STH2->rowCount() > 0 )
								{
									while($r= $STH2->fetch(PDO::FETCH_ASSOC))
									{	
										$output = $r;
									}
								}	
							}	
						}	
					}	
				}
			}
		} catch (Exception $e) {
			$stringData = '[getTaxDetails] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		return $output;
	}
	
	public function getContactUsParentCategoryOption($cat_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql_cat_id_str = " AND cat_id IN (11,150,151,152,157,163)";
		
		if($type == '2')
		{
			$output .= '<option value="" >All Options</option>';
		}
		else
		{
			$output .= '<option value="" >Select Option</option>';
		}
		
		try {
			$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '0' AND `cat_deleted` = '0' ".$sql_cat_id_str." ORDER BY cat_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['cat_id'] == $cat_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getContactUsParentCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getContactUsCategoryOption($parent_cat_id,$cat_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Options</option>';
		}
		else
		{
			$output .= '<option value="" >Select Option</option>';
		}
		
		if($parent_cat_id == '' || $parent_cat_id == '0')
		{
			return $output;	
		}
		
		try {
			$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['cat_id'] == $cat_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getContactUsCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getCancelReasonCategoryOption($parent_cat_id,$cat_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Reasone</option>';
		}
		else
		{
			$output .= '<option value="" >Select Reason</option>';
		}
		
		if($parent_cat_id == '' || $parent_cat_id == '0')
		{
			return $output;	
		}
		
		try {
			$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['cat_id'] == $cat_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getCancelReasonCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getContactUsSpecialityOption($cat_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$parent_cat_id = "1";
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $cat_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Specialities</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Specialities</option>';
			}
			
		}
		else
		{
			if($multiple == '1')
			{
				if(in_array('', $cat_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="" '.$selected.' >Select Speciality</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >Select Speciality</option>';
			}
		}
		
		try {
			$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(in_array($r['cat_id'], $cat_id))
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					else
					{
						if($r['cat_id'] == $cat_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					
					$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';
				}
			}
			
			if($multiple == '1')
			{
				if(in_array('999999999', $cat_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			else
			{
				if('999999999' == $cat_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			$output .= '<option value="999999999" '.$selected.'>Others</option>';
		} catch (Exception $e) {
			$stringData = '[getContactUsSpecialityOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getItemOption($item_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $item_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Items</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Items</option>';
			}
		}
		else
		{
			if($multiple == '1')
			{
				if(in_array('', $item_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="" '.$selected.' >Select Item</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >Select Item</option>';
			}
		}
		
		try {
			$sql = "SELECT item_id,item_name FROM `tblitems` WHERE `item_deleted` = '0' AND `item_id` NOT IN (SELECT DISTINCT(item_id) FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `ic_cat_id` = '54' ) ORDER BY item_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(in_array($r['item_id'], $item_id))
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					else
					{
						if($r['item_id'] == $item_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					$output .= '<option value="'.$r['item_id'].'" '.$selected.'>'.stripslashes($r['item_name']).'</option>';
				}
			}
			if($multiple == '1')
			{
				if(in_array('999999999', $item_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			else
			{
				if('999999999' == $item_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			$output .= '<option value="999999999" '.$selected.'>Others</option>';
		} catch (Exception $e) {
			$stringData = '[getItemOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function getItemOptionSpecialityWise($speciality,$item_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $item_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Items</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Items</option>';
			}
		}
		else
		{
			if($multiple == '1')
			{
				if(in_array('', $item_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="" '.$selected.' >Select Item</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >Select Item</option>';
			}
		}
		
		$sql_speciality_str = '';
		if(is_array($speciality) && count($speciality) > 0)
		{
			if($speciality[0] == '')
			{
				
			}
			else
			{
				$temp_str = implode(',',$speciality);
				if($temp_str != '')
				{
					$sql_speciality_str = " AND `item_id` IN (SELECT DISTINCT(item_id) FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `ic_cat_id` IN (".$temp_str.") ) ";	
				}	
			}
			
		}
		
		try {
			$sql = "SELECT item_id,item_name FROM `tblitems` WHERE `item_deleted` = '0' AND `item_id` NOT IN (SELECT DISTINCT(item_id) FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `ic_cat_id` = '54' ) ".$sql_speciality_str." ORDER BY item_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(in_array($r['item_id'], $item_id))
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					else
					{
						if($r['item_id'] == $item_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					$output .= '<option value="'.$r['item_id'].'" '.$selected.'>'.stripslashes($r['item_name']).'</option>';
				}
			}
			if($multiple == '1')
			{
				if(in_array('999999999', $item_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			else
			{
				if('999999999' == $item_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			$output .= '<option value="999999999" '.$selected.'>Others</option>';
		} catch (Exception $e) {
			$stringData = '[getItemOptionSpecialityWise] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function doContactUs($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
		
		try {
			$sql = "INSERT INTO `tblcontactus` (`contactus_city_id`,`contactus_area_id`,`contactus_name`,`contactus_email`,`contactus_contact_no`,
					`contactus_parent_cat_id`,`contactus_parent_cat_other`,`contactus_cat_id`,`contactus_cat_other`,`contactus_speciality_id`,
					`contactus_speciality_other`,`contactus_item_id`,`contactus_item_other`,`contactus_no_of_people`,`contactus_comments`,`user_id`,`cu_status`,`cu_add_date`) 
					VALUES (:contactus_city_id,:contactus_area_id,:contactus_name,:contactus_email,:contactus_contact_no,
					:contactus_parent_cat_id,:contactus_parent_cat_other,:contactus_cat_id,:contactus_cat_other,:contactus_speciality_id,
					:contactus_speciality_other,:contactus_item_id,:contactus_item_other,:contactus_no_of_people,:contactus_comments,:user_id,:cu_status,:cu_add_date)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':contactus_city_id' => addslashes($tdata['contactus_city_id']),
				':contactus_area_id' => addslashes($tdata['contactus_area_id']),
				':contactus_name' => addslashes($tdata['contactus_name']),
				':contactus_email' => addslashes($tdata['contactus_email']),
				':contactus_contact_no' => addslashes($tdata['contactus_contact_no']),
				':contactus_parent_cat_id' => addslashes($tdata['contactus_parent_cat_id']),
				':contactus_parent_cat_other' => addslashes($tdata['contactus_parent_cat_other']),
				':contactus_cat_id' => addslashes($tdata['contactus_cat_id']),
				':contactus_cat_other' => addslashes($tdata['contactus_cat_other']),
				':contactus_speciality_id' => addslashes($tdata['contactus_speciality_id']),
				':contactus_speciality_other' => addslashes($tdata['contactus_speciality_other']),
				':contactus_item_id' => addslashes($tdata['contactus_item_id']),
				':contactus_item_other' => addslashes($tdata['contactus_item_other']),
				':contactus_no_of_people' => addslashes($tdata['contactus_no_of_people']),
				':contactus_comments' => addslashes($tdata['contactus_comments']),
				':user_id' => addslashes($tdata['user_id']),
				':cu_status' => addslashes($tdata['cu_status']),
				':cu_add_date' => date('Y-m-d H:i:s'),
            ));
			$return = $DBH->lastInsertId();
			$DBH->commit();
		} catch (Exception $e) {
			$stringData = '[doContactUs] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
	
	public function changeUserPassword($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        try {
			$sql = "UPDATE `tblusers` SET 
					`password` = :password  
					WHERE `user_id` = :user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':password' => md5($tdata['password']),
				':user_id' => $tdata['user_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[changeUserPassword] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function doCancelItem($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblordercart` SET 
					`cancel_request_sent` = :cancel_request_sent,
					`cancel_request_date` = :cancel_request_date,
					`cancel_cat_id` = :cancel_cat_id,
					`cancel_cat_other` = :cancel_cat_other,
					`cancel_comments` = :cancel_comments,
					`cancel_request_by_admin` = :cancel_request_by_admin,
					`cancel_request_by_admin_id` = :cancel_request_by_admin_id
					WHERE `invoice` = :invoice AND `order_cart_id` = :order_cart_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cancel_request_sent' => addslashes($tdata['cancel_request_sent']),
				':cancel_request_date' => date('Y-m-d H:i:s'),
				':cancel_cat_id' => addslashes($tdata['cancel_cat_id']),
				':cancel_cat_other' => addslashes($tdata['cancel_cat_other']),
				':cancel_comments' => addslashes($tdata['cancel_comments']),
				':cancel_request_by_admin' => addslashes($tdata['cancel_request_by_admin']),
				':cancel_request_by_admin_id' => addslashes($tdata['cancel_request_by_admin_id']),
				':invoice' => $tdata['invoice'],
				':order_cart_id' => $tdata['order_cart_id']
			));
			$DBH->commit();
			
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[doCancelItem] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getVendorAccessCategoryOption($cat_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		
		$selected = '';	
		$output .= '<option value="" '.$selected.' >Select Catgeory</option>';
			
		
		try {
			$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `cat_id` IN (SELECT DISTINCT va_cat_id FROM tblvendoraccess WHERE va_status = '1' AND va_deleted = '0' ) AND `cat_deleted` = '0' ORDER BY cat_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{

					if($r['cat_id'] == $cat_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					
					$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getVendorAccessCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getVAIDFromVACATID($va_cat_id)
    {
        $DBH = new DatabaseHandler();
        $va_id = 0;

        $sql = "SELECT va_id FROM `tblvendoraccess` WHERE `va_cat_id` = '".$va_cat_id."' AND `va_status` = '1' AND `va_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $va_id = $r['va_id'];
        }
        return $va_id;
    }
	
	/////////////////////////////Old Functions//////////////////////////////////////////////////////////////////////////// 	
	
	
	
	
	
	
	
	
	
		
	public function getUserFullDetails($user_id)
    {
        $DBH = new DatabaseHandler();
		$arr_record = array();
		
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
			$arr_record = $r;
        }
		
        return $arr_record;
    }
	
	
    
    
	
    public function doValiadteUser($email)
    {
        global $link;
        $return = false;
        $user_update_date = date('Y-m-d H:i:s');

        $sql = "UPDATE `tblusers` SET `status` = '1', `user_update_date` = '".addslashes($user_update_date)."' WHERE `email` = '".$email."'";
        $result = mysql_query($sql,$link);
        if($result)
        {
            $return = true;	
        }
        return $return;
    }
	
    public function chkValidUserPassLogin($email,$password)
    {
        global $link;
        $return = false;

        $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `password` = '".md5($password)."' AND `deleted` = '0' ";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
        }
        return $return;
    }
	
    public function chkValidEmail($email)
    {
        global $link;
        $return = false;

        $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `deleted` = '0' ";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
        }
        return $return;
    }
	
	
}
?>