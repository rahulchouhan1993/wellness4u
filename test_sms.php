<?php
define('SMS_URL', 'http://www.webpostservice.com/');
define('SMS_USERNAME', 'one9world');
define('SMS_PASSWORD', '679354');
//define('SMS_SENDERID', 'TESTIN');
define('SMS_SENDERID', 'TASTES');

 function sendSMS($tdata)
    {
        $return = false;
        
        $sendurl = SMS_URL."sendsms/sendsms.php?username=".SMS_USERNAME."&password=".SMS_PASSWORD."&type=TEXT&sender=".SMS_SENDERID."&mobile=".$tdata['mobile_no']."&message=".urlencode($tdata['sms_message']);
        //$this->debuglogsms('[sendSMS] sendurl:'.$sendurl);
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
				//$this->debuglogsms($stringData);
			}
			curl_close ($ch);
			
			//echo 
			//$response = file_get_contents($sendurl);		
			//$this->debuglogsms('[sendSMS] sendurl:'.$sendurl.', response:'.$response);
			return true;
		} catch (Exception $e) {
			$stringData = '[sendSMS] Catch Error:'.$e->getMessage().' , sendurl:'.$sendurl.', response:'.$response;
			echo $e->getMessage();
                        //$this->debuglogsms($stringData);
            return $return;
        }
		
        return $return;
    }
   
$tdata_sms = array();
$tdata_sms['mobile_no'] = '8692991037';
$tdata_sms['sms_message'] = 'Dear Ramakant, Your profile is successfully created at Tastes of states.';
sendSMS($tdata_sms);  
    
    ?>