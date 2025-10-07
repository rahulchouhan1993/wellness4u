<?php
class Vendor {
    function __construct() {
    }
    public function chkIfAccessOfMenu5($vendor_id, $admin_main_menu_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $va_id = $this->getVendorVAID($vendor_id);
        $sql = "SELECT TAM.* FROM `tbladminmenu` AS TAM WHERE TAM.status = '1' AND FIND_IN_SET('" . $admin_main_menu_id . "', ( SELECT va_am_id FROM `tblvendoraccess` WHERE va_id = '" . $va_id . "' AND `va_status` = '1' AND `va_deleted` = '0' )) > 0 ORDER BY TAM.menu_id ASC";
        $STH = $DBH->query($sql);
        // if($STH->rowCount() > 0 )
        // {
        $return = true;
        // echo $return;
        // exit;
        // }
        return $return;
    }
    public function debuglog($stringData) {
        $logFile = SITE_PATH . "/logs/debuglog_vendor_" . date("Y-m-d") . ".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: " . date("Y-m-d H:i:s") . "\n" . $stringData . "\nDEBUG_END - time: " . date("Y-m-d H:i:s") . "\n----------------------------------------------------\n\n");
        fclose($fh);
    }
    public function debuglogsms($stringData) {
        $logFile = SITE_PATH . "/logs/debuglog_sms_" . date("Y-m-d") . ".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: " . date("Y-m-d H:i:s") . "\n" . $stringData . "\nDEBUG_END - time: " . date("Y-m-d H:i:s") . "\n----------------------------------------------------\n\n");
        fclose($fh);
    }
    //update ample 13-07-20
    public function sendSMS($tdata) {

        $user = $tdata['SMS_USERNAME'];
        $password = $tdata['SMS_PASSWORD'];
        $sid = $tdata['SMS_SENDERID'];
        $url =$tdata['SMS_URL'];
        $msisdn = $tdata['mobile_no'];
        $msg = urlencode($tdata['sms_message']);
        $api_url=$url."?user=$user&password=$password&msisdn=$msisdn&sid=$sid&msg=$msg&fl=0&gwid=2"; //change by ample
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0); 
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0); // DO NOT RETURN HTTP HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN THE CONTENTS OF THE CALL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $return_val = curl_exec($ch);
        curl_close($ch); 

        //add by ample 11-07-20
         if(!$return_val){
           $return_val =  file_get_contents($api_url);  
        }
        if ($return_val == "") {
            $string = "Process Failed, Please check your connecting domain, username or password.$return_val" . curl_error($ch);
            //$this->debuglog($string);  
        } else {
            $string = "Message Id : $return_val" . curl_error($ch); //Returning the message id  :  Whenever you are sending an SMS our system will give a message id for each numbers, which can be saved into your database and in future by calling these message id's using correct API's you can update the delivery status.
            //$this->debuglog($string);
            // echo "<pre>";print_r($string);echo "</pre>";
            // exit;
            return true;
        }
        return true;
    }
    public function sendSMS_OLD($tdata) {
        $user = SMS_USERNAME;
        $password = SMS_PASSWORD;
        $msisdn = $tdata['mobile_no'];
        // $otp = $tdata['otp'];
        $sid = 'AIMSEL';
        $msg = urlencode($tdata['sms_message']);
        $url = "http://smpp.keepintouch.co.in/vendorsms/pushsms.aspx";
        $parameters = "user=$user&password=$password&msisdn=$msisdn&sid=$sid&msg=$msg&fl=0&gwid=2";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0); // DO NOT RETURN HTTP HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN THE CONTENTS OF THE CALL
        $return_val = curl_exec($ch);
        // echo "<pre>";print_r($return_val);echo "</pre>";
        if ($return_val == "") {
            $string = "Process Failed, Please check your connecting domain, username or password.$return_val" . curl_error($ch);
            //$this->debuglog($string);
            
        } else {
            $string = "Message Id : $return_val" . curl_error($ch); //Returning the message id  :  Whenever you are sending an SMS our system will give a message id for each numbers, which can be saved into your database and in future by calling these message id's using correct API's you can update the delivery status.
            //$this->debuglog($string);
            // echo "<pre>";print_r($string);echo "</pre>";
            // exit;
            return true;
        }
        return true;
    }
    // public function sendSMS($tdata)
    //    {
    //        $return = false;
    //        $sendurl = SMS_URL."sendsms/sendsms.php?username=".SMS_USERNAME."&password=".SMS_PASSWORD."&type=TEXT&sender=".SMS_SENDERID."&mobile=".$tdata['mobile_no']."&message=".urlencode($tdata['sms_message']);
    //        $this->debuglogsms('[sendSMS] sendurl:'.$sendurl);
    //        try {
    // 		$ch = curl_init($sendurl);
    // 		curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
    // 		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
    // 		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
    // 		curl_setopt($ch,CURLOPT_HEADER, 0);
    // 		curl_setopt ($ch, CURLOPT_URL, $sendurl);
    // 		curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
    // 		curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
    // 		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // 		if ( ! $response = curl_exec($ch) )
    // 		{
    // 			$stringData = '[sendSMS] Error:'.curl_error($ch).' , sendurl:'.$sendurl.', response:'.$response;
    // 			$this->debuglogsms($stringData);
    // 		}
    // 		curl_close ($ch);
    // 		////echo
    // 		////$response = file_get_contents($sendurl);
    // 		$this->debuglogsms('[sendSMS] sendurl:'.$sendurl.', response:'.$response);
    // 		return true;
    // 	} catch (Exception $e) {
    // 		$stringData = '[sendSMS] Catch Error:'.$e->getMessage().' , sendurl:'.$sendurl.', response:'.$response;
    // 		$this->debuglogsms($stringData);
    //            return $return;
    //        }
    //        return $return;
    //    }
    public function getInputFieldCode($name, $id, $value, $type = 'text', $placeholder = '', $class = '', $style = '', $required = '') {
        if ($type == 'hidden') {
            $output = '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" value="' . $value . '">';
        } else {
            if ($class == '') {
                $class_str = '';
            } else {
                $class_str = ' class="' . $class . '" ';
            }
            if ($style == '') {
                $style_str = '';
            } else {
                $style_str = ' style="' . $style . '" ';
            }
            if ($required == '1') {
                $required_str = ' required ';
            } else {
                $required_str = '';
            }
            $output = '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $class_str . ' ' . $style_str . ' ' . $required_str . ' >';
        }
        return $output;
    }
    public function getSelectFieldCode($name, $id, $value, $class = '', $style = '', $multiple = '', $onchange = '', $required) {
        if ($class == '') {
            $class_str = '';
        } else {
            $class_str = ' class="' . $class . '" ';
        }
        if ($style == '') {
            $style_str = '';
        } else {
            $style_str = ' style="' . $style . '" ';
        }
        if ($required == '1') {
            $required_str = ' required ';
        } else {
            $required_str = '';
        }
        if ($multiple == '1') {
            $multiple_str = ' multiple ';
        } else {
            $multiple_str = '';
        }
        if ($onchange != '') {
            $onchange_str = ' onchange=" ' . $onchange . ' " ';
        } else {
            $onchange_str = '';
        }
        $output = '<select name="' . $name . '" id="' . $id . '" ' . $class_str . ' ' . $style_str . ' ' . $multiple_str . ' ' . $onchange_str . ' ' . $required_str . '>';
        $output.= $value;
        $output.= '</select>';
        return $output;
    }
    public function addRecordCommon($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $str_insert = '';
        $str_values = '';
        $arr_execute_parameters = array();
        foreach ($tdata as $key => $val) {
            if ($key != 'tablename') {
                $str_insert.= '`' . $key . '`,';
                $str_values.= ':' . $key . ',';
                $arr_execute_parameters[':' . $key] = addslashes($val);
            }
        }
        $str_insert = substr($str_insert, 0, -1);
        $str_values = substr($str_values, 0, -1);
        try {
            $sql = "INSERT INTO `" . $tdata['tablename'] . "` (" . $str_insert . ") VALUES (" . $str_values . ")";
            $STH = $DBH->prepare($sql);
            $STH->execute($arr_execute_parameters);
            $add_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($add_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addRecordCommon] Catch Error:' . $e->getMessage() . ', sql:' . $sql . ', arr_execute_parameters:<pre>' . print_r($arr_execute_parameters, 1) . '</pre>, tdata:<pre>' . print_r($tdata, 1) . '</pre>';
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateRecordCommon($tdata, $arr_where, $debug = '') {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $str_update = '';
        $str_update_direct = '';
        $str_where = '';
        $str_where_direct = '';
        $arr_execute_parameters = array();
        foreach ($tdata as $key => $val) {
            if ($key != 'tablename') {
                $str_update.= '`' . $key . '` = :' . $key . ',';
                $str_update_direct.= "`" . $key . "` = '" . addslashes($val) . "',";
                $arr_execute_parameters[':' . $key] = addslashes($val);
            }
        }
        foreach ($arr_where as $key => $val) {
            $str_where.= ' `' . $key . '` = :' . $key . ' AND';
            $str_where_direct.= " `" . $key . "` = '" . addslashes($val) . "' AND";
            $arr_execute_parameters[':' . $key] = addslashes($val);
        }
        $str_update = substr($str_update, 0, -1);
        $str_update_direct = substr($str_update_direct, 0, -1);
        $str_where = substr($str_where, 0, -3);
        $str_where_direct = substr($str_where_direct, 0, -3);
        try {
            $sql = "UPDATE `" . $tdata['tablename'] . "` SET " . $str_update . " WHERE " . $str_where;
            $sql_direct = "UPDATE `" . $tdata['tablename'] . "` SET " . $str_update_direct . " WHERE " . $str_where_direct;
            if ($debug == '1') {
                $this->debuglog('[updateRecordCommon] sql_direct:' . $sql_direct . ', sql:' . $sql . ', arr_execute_parameters:<pre>' . print_r($arr_execute_parameters, 1) . '</pre>, tdata:<pre>' . print_r($tdata, 1) . '</pre>, arr_where:<pre>' . print_r($arr_where, 1) . '</pre>');
            }
            $STH = $DBH->prepare($sql);
            $STH->execute($arr_execute_parameters);
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateRecordCommon] Catch Error:' . $e->getMessage() . ', sql:' . $sql . ', arr_execute_parameters:<pre>' . print_r($arr_execute_parameters, 1) . '</pre>, tdata:<pre>' . print_r($tdata, 1) . '</pre>, arr_where:<pre>' . print_r($arr_where, 1) . '</pre>';
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getErrormsgString($err_msg) {
        $output = '<div id="message-red">

                        <table border="0" width="100%" cellpadding="0" cellspacing="0">

                        <tr>

                                <td class="red-left">Error. ' . $err_msg . '</td>

                                <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif"   alt="" /></a></td>

                        </tr>

                        </table>

					</div>';
        return $output;
    }
    public function chkValidVendor($vendor_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_status` = '1' AND `vendor_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkValidVendor] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function isVendorLoggedIn() {
        $return = false;
        if (isset($_SESSION['adm_vendor_id']) && ($_SESSION['adm_vendor_id'] > 0) && ($_SESSION['adm_vendor_id'] != '')) {
            $vendor_id = $_SESSION['adm_vendor_id'];
            if ($this->chkValidVendor($vendor_id)) {
                $return = true;
            }
        }
        return $return;
    }
    public function chkValidVendorLogin($username, $password) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '" . addslashes($username) . "' AND `vendor_password` = '" . md5($password) . "' AND `vendor_status` = '1' AND `vendor_deleted` = '0' ";
            //$this->debuglog('[chkValidVendorLogin] sql: '.$sql);
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkValidVendorLogin] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkValidVendorCurrentPassword($password, $vendor_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_password` = '" . md5($password) . "' AND `vendor_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkValidVendorCurrentPassword] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function doVendorLogin($username) {
        global $link;
        $return = false;
        $vendor_id = $this->getVendorId($username);
        $vendor_name = $this->getVendorNameByUsername($username);
        $vendor_email = $this->getVendorEmail($username);
        if ($vendor_id > 0) {
            $return = true;
            $_SESSION['adm_vendor_id'] = $vendor_id;
            $_SESSION['adm_vendor_username'] = $username;
            $_SESSION['adm_vendor_name'] = $vendor_name;
            $_SESSION['adm_vendor_email'] = $vendor_email;
        }
        return $return;
    }
    public function doVendorLogout() {
        global $link;
        $return = true;
        $_SESSION['adm_vendor_id'] = '';
        $_SESSION['adm_vendor_username'] = '';
        $_SESSION['adm_vendor_name'] = '';
        $_SESSION['adm_vendor_email'] = '';
        unset($_SESSION['adm_vendor_id']);
        unset($_SESSION['adm_vendor_username']);
        unset($_SESSION['adm_vendor_name']);
        unset($_SESSION['adm_vendor_email']);
        /*
        
        session_destroy();
        
        session_start();
        
        session_regenerate_id();
        
        $new_sessionid = session_id();
        
        */
        $_SESSION = array();
        return $return;
    }
    public function getVendorId($username) {
        $DBH = new DatabaseHandler();
        $vendor_id = 0;
        try {
            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '" . addslashes($username) . "' AND `vendor_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $vendor_id = $r['vendor_id'];
            }
        }
        catch(Exception $e) {
            $stringData = '[getVendorId] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return 0;
        }
        return $vendor_id;
    }
    public function getVendorNameByUsername($username) {
        $DBH = new DatabaseHandler();
        $fname = '';
        try {
            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '" . addslashes($username) . "' AND `vendor_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $fname = stripslashes($r['vendor_name']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getVendorNameByUsername] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $fname;
        }
        return $fname;
    }
    public function getVendorEmail($username) {
        $DBH = new DatabaseHandler();
        $email = '';
        try {
            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '" . addslashes($username) . "' AND `vendor_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $email = stripslashes($r['vendor_email']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getVendorEmail] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $email;
        }
        return $email;
    }
    public function geVendorEmailById($vendor_id) {
        $DBH = new DatabaseHandler();
        $email = '';
        $sql = "SELECT vendor_email FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $email = stripslashes($r['vendor_email']);
        }
        return $email;
    }
    public function getVendorEmailById($vendor_id) {
        $DBH = new DatabaseHandler();
        $email = '';
        $sql = "SELECT vendor_email FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $email = stripslashes($r['vendor_email']);
        }
        return $email;
    }
    public function getVendorUsername($vendor_id) {
        $DBH = new DatabaseHandler();
        $username = '';
        $sql = "SELECT vendor_username FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $username = stripslashes($r['vendor_username']);
        }
        return $username;
    }
    public function getVendorFullNameById($vendor_id) {
        $DBH = new DatabaseHandler();
        $name = '';
        $sql = "SELECT vendor_name FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $name = stripslashes($r['vendor_name']);
        }
        return $name;
    }
    public function getVendorUserDetails($vendor_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getVendorVAID($vendor_id) {
        $DBH = new DatabaseHandler();
        $va_id = 0;
        //$sql = "SELECT va_id FROM `tblvendors` WHERE `vendor_id` = '".$vendor_id."' AND `vendor_deleted` = '0' ";
        $sql = "SELECT va_id FROM `tblvendoraccess` WHERE `va_cat_id` = (SELECT vendor_parent_cat_id FROM tblvendors WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ) AND `va_sub_cat_id` = (SELECT vendor_cat_id FROM tblvendors WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ) AND `va_status` = '1' AND `va_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $va_id = $r['va_id'];
        }
        return $va_id;
    }
    public function getVendorFormVAID($vendor_id) {
        $DBH = new DatabaseHandler();
        $va_id = 0;
        //$sql = "SELECT va_id FROM `tblvendors` WHERE `vendor_id` = '".$vendor_id."' AND `vendor_deleted` = '0' ";
        $sql = "SELECT va_id FROM `tblvendoraccess` WHERE `va_cat_id` = (SELECT vendor_parent_cat_id FROM tblvendors WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ) AND `va_sub_cat_id` = (SELECT vendor_cat_id FROM tblvendors WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ) AND `va_status` = '1' AND `va_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $va_id = $r['va_id'];
        }
        return $va_id;
    }
    public function getVendorCurrentPassword($vendor_id) {
        $DBH = new DatabaseHandler();
        $password = '';
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $password = $r['vendor_password'];
        }
        return $password;
    }
    public function updateAdminUser($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbladmin` SET 

					`username` = :username,

					`email` = :email,

					`fname` = :fname,

					`lname` = :lname,

					`contact_no` = :contact_no,  

					`am_id` = :am_id,  

					`aa_id` = :aa_id,  

					`status` = :status  

					WHERE `admin_id` = :admin_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':username' => addslashes($tdata['username']), ':email' => addslashes($tdata['email']), ':fname' => addslashes($tdata['fname']), ':lname' => addslashes($tdata['lname']), ':contact_no' => addslashes($tdata['contact_no']), ':am_id' => addslashes($tdata['am_id']), ':aa_id' => addslashes($tdata['aa_id']), ':status' => addslashes($tdata['status']), ':admin_id' => $tdata['admin_id']));
            $DBH->commit();
            $return = true;
            if ($_SESSION['admin_id'] == $tdata['admin_id']) {
                $_SESSION['admin_username'] = $tdata['username'];
                $_SESSION['admin_fname'] = stripslashes($tdata['fname']);
                $_SESSION['admin_lname'] = stripslashes($tdata['lname']);
                $_SESSION['admin_email'] = $tdata['email'];
            }
        }
        catch(Exception $e) {
            $stringData = '[updateAdminUser] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateVendorPassword($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblvendors` SET `vendor_password` = :vendor_password WHERE `vendor_id` = :vendor_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vendor_password' => md5($tdata['vendor_password']), ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateVendorPassword] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAdminMenuCode($vendor_id, $admin_main_menu_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        $va_id = $this->getVendorFormVAID($vendor_id);
        //echo '<br>va_id:'.$va_id;
        $output.= '<ul class="nav panel-list">';
        if ($admin_main_menu_id == '1') {
            $li_class = ' class="active" ';
        } else {
            $li_class = '';
        }
        //index.php add in deshboard by ample 09-09-20
        $output.= '<li ' . $li_class . '>

                                    <a href="index.php">

                                            <i class="fa fa-home"></i>

                                            <span class="menu-text">Dashboard</span>

                                            <span class="selected"></span>

                                    </a>

                            </li>';
        $sql = "SELECT TAM.* FROM `tblwaadminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '0' AND FIND_IN_SET(TAM.am_id, ( SELECT va_am_id FROM `tblvendoraccess` WHERE va_id = '" . $va_id . "' AND `va_status` = '1' AND `va_deleted` = '0' )) > 0 ORDER BY TAM.am_order ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($r['am_id'] != '1' && $r['am_id'] != '16') {
                    $DBH2 = new DatabaseHandler();
                    $sql2 = "SELECT TAM.* FROM `tblwaadminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '" . $r['am_id'] . "' AND FIND_IN_SET(TAM.am_id, ( SELECT va_am_id FROM `tblvendoraccess` WHERE va_id = '" . $va_id . "' AND `va_status` = '1' AND `va_deleted` = '0' )) > 0 ORDER BY TAM.am_order ASC";
                    $STH2 = $DBH2->query($sql2);
                    if ($STH2->rowCount() > 0) {
                        if ($admin_main_menu_id == $r['am_id']) {
                            $li_class = ' class="hoe-has-menu active" ';
                        } else {
                            $li_class = ' class="hoe-has-menu" ';
                        }
                        $output.= '<li ' . $li_class . '>

                                                            <a href="javascript:void(0)">

                                                                    <i class="fa ' . $r['am_icon'] . '"></i>

                                                                    <span class="menu-text">' . $r['am_title'] . '</span>

                                                                    <span class="selected"></span>

                                                            </a>

                                                            <ul class="hoe-sub-menu">';
                        while ($r2 = $STH2->fetch(PDO::FETCH_ASSOC)) {
                            $output.= '<li>

                                                                <a href="' . $r2['am_link'] . '">

                                                                        <span class="menu-text">' . $r2['am_title'] . '</span>

                                                                <span class="selected"></span>

                                                                </a>

                                                        </li>';
                        }
                        $output.= '	</ul>

								</li>';
                    } else {
                        if ($admin_main_menu_id == $r['am_id']) {
                            $li_class = ' class="active" ';
                        } else {
                            $li_class = '';
                        }
                        $output.= '<li ' . $li_class . '>

                                                        <a href="' . $r['am_link'] . '">

                                                                <i class="fa ' . $r['am_icon'] . '"></i>

                                                                <span class="menu-text">' . $r['am_title'] . '</span>

                                                                <span class="selected"></span>

                                                        </a>

                                                </li>';
                    }
                }
            }
        }
        $output.= '</ul>';
        return $output;
    }
    public function chkIfAccessOfMenu($vendor_id, $admin_main_menu_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $va_id = $this->getVendorVAID($vendor_id);
        $sql = "SELECT TAM.* FROM `tblwaadminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '0' AND FIND_IN_SET('" . $admin_main_menu_id . "', ( SELECT va_am_id FROM `tblvendoraccess` WHERE va_id = '" . $va_id . "' AND `va_status` = '1' AND `va_deleted` = '0' )) > 0 ORDER BY TAM.am_order ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //  	public function chkIfAccessOfMenu3($vendor_id,$admin_main_menu_id)
    //   {
    //       $DBH = new DatabaseHandler();
    //       $return = false;
    // $va_id = $this->getVendorVAID($vendor_id);
    // $sql = "SELECT TAM.* FROM `tblwaadminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '0' AND FIND_IN_SET('".$admin_main_menu_id."', ( SELECT va_am_id FROM `tblvendoraccess` WHERE va_id = '".$va_id."' AND `va_status` = '1' AND `va_deleted` = '0' )) > 0 ORDER BY TAM.am_order ASC";
    //               $STH = $DBH->query($sql);
    // if( $STH->rowCount() > 0 )
    // {
    // 	$return = true;
    // }
    //       return $return;
    //   }
    public function chkIfAccessOfMenuAction($vendor_id, $action_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $va_id = $this->getVendorVAID($vendor_id);
        $sql = "SELECT TAA.* FROM `tblwaadminactions` AS TAA WHERE TAA.aa_status = '1' AND TAA.aa_deleted = '0' AND FIND_IN_SET('" . $action_id . "', ( SELECT va_aa_id FROM `tblvendoraccess` WHERE va_id = '" . $va_id . "' AND `va_status` = '1' AND `va_deleted` = '0' )) > 0 ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getAllSubadmins($txtsearch = '', $status = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        $sql_status_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND (`username` LIKE '%" . $txtsearch . "%' OR `email` LIKE '%" . $txtsearch . "%' OR `fname` LIKE '%" . $txtsearch . "%' OR `lname` LIKE '%" . $txtsearch . "%' )";
        }
        if ($status != '') {
            $sql_status_str = " AND `status` = '" . $status . "' ";
        }
        $sql = "SELECT * FROM `tbladmin` WHERE `super_admin` = '0' AND `deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " ORDER BY username ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllMenuAccess($am_vendor_menu = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        if ($am_vendor_menu == '1') {
            $sql_am_vendor_menu_str = " AND `am_vendor_menu` = '1' ";
        } else {
            $sql_am_vendor_menu_str = "";
        }
        $sql = "SELECT * FROM `tblwaadminmenu` WHERE `am_status` = '1' AND `am_deleted` = '0' " . $sql_am_vendor_menu_str . " ORDER BY am_order ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllMenuActionsAccess($am_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql = "SELECT * FROM `tblwaadminactions` WHERE `am_id` = '" . $am_id . "' AND `aa_status` = '1' AND `aa_deleted` = '0' ORDER BY aa_add_date ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    //category start
    public function DeleteCat($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblcategories` SET  `cat_deleted` = '1', `cat_modified_date` = '" . date('Y-m-d H:i:s') . "', `deleted_by_admin` = '" . $admin_id . "' WHERE `cat_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function GetAllCat($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `cat_name` LIKE '%" . $txtsearch . "%' ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND `cat_status` = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(cat_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(cat_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cat_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cat_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(cat_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblcategories` WHERE `cat_deleted` = '0' AND `parent_cat_id` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY `cat_name` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function chkCategoryExists($cat_name) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblcategories` WHERE `cat_name` = '" . $cat_name . "' AND `cat_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addCategory($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcategories` (`cat_name`,`added_by_admin`,`cat_status`,`cat_add_date`) 

					VALUES (:cat_name,:added_by_admin,:cat_status,:cat_add_date)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cat_name' => addslashes($tdata['cat_name']), ':added_by_admin' => $tdata['admin_id'], ':cat_status' => '1', ':cat_add_date' => date('Y-m-d H:i:s')));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCategory] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function GetCategory($id) {
        $return = array();
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblcategories`  where  `cat_id` = '" . $id . "' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r;
            }
            return $return;
        }
        catch(Exception $e) {
            $stringData = '[GetCategory] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
    }
    public function getCategoryName($id) {
        $DBH = new DatabaseHandler();
        $return = '';
        try {
            $sql = "SELECT cat_name FROM `tblcategories`  WHERE  `cat_id` = '" . $id . "' AND `cat_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r['cat_name'];
            }
            return $return;
        }
        catch(Exception $e) {
            $stringData = '[getCategoryName] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
    }
    public function chkCategoryExistsById($cat_name, $cid) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblcategories` WHERE `cat_name` = '" . $cat_name . "' AND `cat_deleted` = '0' AND `cat_id` != '" . $cid . "'";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
            return $return;
        }
        catch(Exception $ex) {
            $stringData = '[chkCategoryExistsById] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
    }
    public function editCategory($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcategories` SET `cat_name` = :cat_name , `cat_status` = :cat_status , `cat_modified_date` = :mdate , `modified_by_admin` = :modified_by_admin  WHERE `cat_id` = :cat_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cat_name' => addslashes($tdata['cat_name']), ':cat_id' => $tdata['cat_id'], ':cat_status' => $tdata['cat_status'], ':mdate' => $tdata['modify_date'], ':modified_by_admin' => $tdata['admin_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[editCategory] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //main category start
    public function GetAllMainCat($txtsearch = '', $parent_cat_id = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        $sql_parent_cat_id_str = "";
        $sql_status_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `cat_name` LIKE '%" . $txtsearch . "%' ";
        }
        if ($parent_cat_id != '') {
            $sql_parent_cat_id_str = " AND `parent_cat_id` = '" . $parent_cat_id . "' ";
        }
        if ($status != '') {
            $sql_status_str = " AND `cat_status` = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(cat_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(cat_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cat_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cat_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(cat_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblcategories` WHERE `cat_deleted` = '0' AND `parent_cat_id` != 0 " . $sql_search_str . " " . $sql_parent_cat_id_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY `cat_name` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function DeleteMainCat($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblcategories` SET  `cat_deleted` = '1', `cat_modified_date` = '" . date('Y-m-d H:i:s') . "', `deleted_by_admin` = '" . $admin_id . "' WHERE `cat_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function GetParentCategory($cat_id, $parent_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $sql = "SELECT * FROM `tblcategories` where `cat_deleted` = 0 AND `parent_cat_id` = '" . $parent_cat_id . "' ORDER BY cat_name ASC";
        $STH = $DBH->query($sql);
        //$option_str .= '<option value="">Select Parent Category</option>';
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['cat_id'] == $cat_id) {
                    $option_str.= '<option value="' . $row['cat_id'] . '" selected>' . $row['cat_name'] . '</option>';
                } else {
                    $option_str.= '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
            }
            return $option_str;
        } else {
            return $option_str;
        }
    }
    public function addMainCategory($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcategories` (`cat_name`,`added_by_admin`,`cat_status`,`parent_cat_id`,`cat_add_date`,`cat_image`) 

					VALUES (:cat_name,:added_by_admin,:cat_status,:parent_cat_id,:cat_add_date,:cat_image)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cat_name' => addslashes($tdata['cat_name']), ':added_by_admin' => $tdata['admin_id'], ':cat_status' => '1', ':parent_cat_id' => $tdata['parent_cat_id'], ':cat_add_date' => date('Y-m-d H:i:s'), ':cat_image' => addslashes($tdata['cat_image']),));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addMainCategory] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function editMainCategory($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcategories` SET `cat_name` = :cat_name , `cat_modified_date` = :mdate , `modified_by_admin` = :modified_by_admin , `parent_cat_id` = :parent_cat_id , `cat_status` = :cat_status, `cat_image` = :cat_image WHERE `cat_id` = :cat_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cat_name' => addslashes($tdata['cat_name']), ':cat_id' => $tdata['cat_id'], ':mdate' => $tdata['modify_date'], ':modified_by_admin' => $tdata['admin_id'], ':parent_cat_id' => $tdata['parent_cat_id'], ':cat_status' => $tdata['cat_status'], ':cat_image' => $tdata['cat_image']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[editMainCategory] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function GetCatName($cat_id) {
        $return = '';
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT `cat_name` FROM `tblcategories` where `cat_id`= '" . $cat_id . "' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r['cat_name'];
            }
            return $return;
        }
        catch(Exception $ex) {
            echo $e->getMessage();
        }
    }
    public function getAllAdminMenusList($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        $sql_status_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `am_title` LIKE '%" . $txtsearch . "%' ";
        }
        if ($status != '') {
            $sql_status_str = " AND `am_status` = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(am_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(am_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(am_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(am_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(am_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY am_order ASC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function deleteAdminMenu($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbladminmenu` SET 

					`am_deleted` = :am_deleted,

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `am_id` = :am_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':am_deleted' => '1', ':deleted_by_admin' => $tdata['deleted_by_admin'], ':am_id' => $tdata['am_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteAdminMenu] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkAdminMenuTitleExists($am_title) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_title` = '" . addslashes($am_title) . "' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkAdminMenuTitleExists_edit($am_title, $am_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_title` = '" . addslashes($am_title) . "' AND `am_id` != '" . $am_id . "' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addAdminMenu($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tbladminmenu` (`am_title`,`am_link`,`am_icon`,`am_order`,`am_status`,`added_by_admin`) 

					VALUES (:am_title,:am_link,:am_icon,:am_order,:am_status,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':am_title' => addslashes($tdata['am_title']), ':am_link' => addslashes($tdata['am_link']), ':am_icon' => addslashes($tdata['am_icon']), ':am_order' => addslashes($tdata['am_order']), ':am_status' => addslashes($tdata['am_status']), ':added_by_admin' => $tdata['added_by_admin'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addAdminMenu] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAdminMenuDetails($am_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_id` = '" . $am_id . "' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getAdminMenuName($am_id) {
        $DBH = new DatabaseHandler();
        $am_title = '';
        $sql = "SELECT * FROM `tblwaadminmenu` WHERE `am_id` = '" . $am_id . "' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $am_title = $r['am_title'];
        }
        return $am_title;
    }
    public function updateAdminMenu($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbladminmenu` SET 

					`am_title` = :am_title,

					`am_link` = :am_link,

					`am_order` = :am_order,

					`am_status` = :am_status,

					`am_modified_date` = :am_modified_date,  

					`modified_by_admin` = :modified_by_admin  

					WHERE `am_id` = :am_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':am_title' => addslashes($tdata['am_title']), ':am_link' => addslashes($tdata['am_link']), ':am_order' => addslashes($tdata['am_order']), ':am_status' => addslashes($tdata['am_status']), ':am_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':am_id' => $tdata['am_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateAdminMenu] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllAdminActionList($am_id, $txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        $sql_status_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `aa_title` LIKE '%" . $txtsearch . "%' ";
        }
        if ($status != '') {
            $sql_status_str = " AND `aa_status` = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(aa_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(aa_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(aa_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(aa_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(aa_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tbladminactions` WHERE `am_id` = '" . $am_id . "' AND `aa_deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY aa_add_date ASC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function deleteAdminAction($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbladminactions` SET 

					`aa_deleted` = :aa_deleted,

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `aa_id` = :aa_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':aa_deleted' => '1', ':deleted_by_admin' => $tdata['deleted_by_admin'], ':aa_id' => $tdata['aa_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteAdminAction] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkAdminActionTitleExists($aa_title, $am_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_title` = '" . addslashes($aa_title) . "' AND `am_id` = '" . $am_id . "' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkAdminActionTitleExists_edit($aa_title, $am_id, $aa_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_title` = '" . addslashes($aa_title) . "' AND `am_id` = '" . $am_id . "'  AND `aa_id` != '" . $aa_id . "' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addAdminAction($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tbladminactions` (`am_id`,`aa_title`,`aa_link`,`aa_status`,`added_by_admin`) 

					VALUES (:am_id,:aa_title,:aa_link,:aa_status,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':am_id' => addslashes($tdata['am_id']), ':aa_title' => addslashes($tdata['aa_title']), ':aa_link' => addslashes($tdata['aa_link']), ':aa_status' => addslashes($tdata['aa_status']), ':added_by_admin' => $tdata['added_by_admin'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addAdminAction] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAdminActionDetails($aa_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_id` = '" . $aa_id . "' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getAdminActionName($aa_id) {
        $DBH = new DatabaseHandler();
        $aa_title = '';
        $sql = "SELECT * FROM `tblwaadminactions` WHERE `aa_id` = '" . $aa_id . "' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $aa_title = $r['aa_title'];
        }
        return $aa_title;
    }
    public function getAdminActionLink($aa_id) {
        $DBH = new DatabaseHandler();
        $aa_link = '';
        $sql = "SELECT * FROM `tblwaadminactions` WHERE `aa_id` = '" . $aa_id . "' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $aa_link = $r['aa_link'];
        }
        return $aa_link;
    }
    public function updateAdminAction($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbladminactions` SET 

					`aa_title` = :aa_title,

					`aa_link` = :aa_link,

					`aa_status` = :aa_status,

					`aa_modified_date` = :aa_modified_date,  

					`modified_by_admin` = :modified_by_admin  

					WHERE `aa_id` = :aa_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':aa_title' => addslashes($tdata['aa_title']), ':aa_link' => addslashes($tdata['aa_link']), ':aa_status' => addslashes($tdata['aa_status']), ':aa_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':aa_id' => $tdata['aa_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateAdminAction] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //country start
    public function GetAllCountry($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `country_name` LIKE '%" . $txtsearch . "%' ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND `country_status` = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(country_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(country_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(country_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(country_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(country_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblcountry` WHERE `country_deleted` = '0'  " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY `country_name` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function chkCountryNameExists($country_name) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblcountry` WHERE `country_name` = '" . $country_name . "' AND `country_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addCountry($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcountry` (`country_name`,`country_status`,`added_by_admin`) 

					VALUES (:country_name,:country_status,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_name' => addslashes($tdata['country_name']), ':country_status' => '1', ':added_by_admin' => addslashes($tdata['admin_id']),));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCountry] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function DeleteCountry($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblcountry` SET  `country_deleted` = '1', `country_modified_date` = '" . date('Y-m-d H:i:s') . "' , `deleted_by_admin` = '" . $admin_id . "' WHERE `country_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getCountryDetails($country_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcountry` WHERE `country_id` = '" . $country_id . "' AND `country_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function chkCountryNameExists_edit($country_name, $country_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblcountry` WHERE `country_name` = '" . $country_name . "' AND `country_id` != '" . $country_id . "' AND `country_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function updateCountry($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcountry` SET 

					`country_name` = :country_name,

					`modified_by_admin` = :modified_by_admin,

					`country_status` = :status  ,

					`country_modified_date` = '" . date('Y-m-d H:i:s') . "' 

					WHERE `country_id` = :country_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_name' => addslashes($tdata['country_name']), ':modified_by_admin' => $tdata['admin_id'], ':status' => $tdata['status'], ':country_id' => $tdata['country_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateCountry] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //states start
    public function GetAllStates($txtsearch = '', $status = '', $country_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `state_name` LIKE '%" . $txtsearch . "%' ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND `state_status` = '" . $status . "' ";
        }
        $sql_country_str = "";
        if ($country_id != '') {
            $sql_country_str = " AND `country_id` = '" . $country_id . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(state_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(state_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(state_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(state_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(state_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblstates` WHERE `state_deleted` = '0'  " . $sql_search_str . " " . $sql_status_str . " " . $sql_country_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY `state_name` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function DeleteState($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblstates` SET  `state_deleted` = '1', `state_modified_date` = '" . date('Y-m-d H:i:s') . "' `deleted_by_admin` = '" . $admin_id . "' WHERE `state_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function GetCountryName($country_id) {
        $return = '';
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT `country_name` FROM `tblcountry` where `country_id`= '" . $country_id . "' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r['country_name'];
            }
            return $return;
        }
        catch(Exception $ex) {
            echo $e->getMessage();
        }
    }
    public function GetCountry($country_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $sql = "SELECT * FROM `tblcountry` WHERE `country_deleted` = '0' ORDER BY `country_name` ASC  ";
        $STH = $DBH->query($sql);
        //$option_str .= '<option value="">Select Parent Category</option>';
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['country_id'] == $country_id) {
                    $option_str.= '<option value="' . $row['country_id'] . '" selected>' . $row['country_name'] . '</option>';
                } else {
                    $option_str.= '<option value="' . $row['country_id'] . '">' . $row['country_name'] . '</option>';
                }
            }
            return $option_str;
        } else {
            return $option_str;
        }
    }
    public function chkStateNameExists($state_name, $country_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblstates` WHERE `state_name` = '" . $state_name . "' AND `country_id` = '" . $country_id . "' AND `state_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addState($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblstates` (`country_id`,`state_name`,`state_status`,`added_by_admin`) 

					VALUES (:country_id,:state_name,:state_status,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_id' => $tdata['country_id'], ':state_name' => addslashes($tdata['state_name']), ':state_status' => '1', ':added_by_admin' => $tdata['admin_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addState] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getStateDetails($state_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblstates` WHERE `state_id` = '" . $state_id . "' AND `state_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function chkStateNameExists_edit($state_name, $state_id, $country_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblstates` WHERE `state_name` = '" . $state_name . "' AND `state_id` != '" . $state_id . "' AND `country_code` = '" . $country_id . "' `state_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function updateState($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblstates` SET 

					`country_id` = :country_id,

					`state_name` = :state_name,

					`modified_by_admin` = :modified_by_admin,

					`state_status` = :status  ,

					`state_modified_date` = '" . date('Y-m-d H:i:s') . "' 

					WHERE `state_id` = :state_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_id' => $tdata['country_id'], ':state_name' => addslashes($tdata['state_name']), ':modified_by_admin' => $tdata['admin_id'], ':status' => $tdata['status'], ':state_id' => $tdata['state_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateState] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //update by ample 11-09-20
    public function GetStateName($state_id) {
        $return = '';
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
             $sql = "SELECT `state` FROM `tblstates` where `state_id`= '" . $state_id . "' "; 
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r['state'];
            }
            return $return;
        }
        catch(Exception $ex) {
            echo $e->getMessage();
        }
    }
    //cities start
    public function GetAllCities($txtsearch = '', $status = '', $country_id = '', $state_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `city_name` LIKE '%" . $txtsearch . "%' ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND `city_status` = '" . $status . "' ";
        }
        $sql_country_str = "";
        if ($country_id != '') {
            $sql_country_str = " AND `country_id` = '" . $country_id . "' ";
        }
        $sql_state_str = "";
        if ($state_id != '') {
            $sql_state_str = " AND `state_id` = '" . $state_id . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(city_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(city_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(city_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(city_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(city_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblcities` WHERE `city_deleted` = '0'  " . $sql_search_str . " " . $sql_status_str . " " . $sql_country_str . " " . $sql_state_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY `city_name` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function DeleteCity($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblcities` SET  `city_deleted` = '1', `city_modified_date` = '" . date('Y-m-d H:i:s') . "' ,`deleted_by_admin` = '" . $admin_id . "' WHERE `city_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function GetState($state_id, $country_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $status = 1;
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblstates` WHERE `country_id` =:country_id and `state_deleted` = '0' ORDER BY `state_name` ASC";
            $STH = $DBH->prepare($sql);
            $STH->bindParam('country_id', $country_id);
            $STH->execute();
            $rows_affected = $STH->rowCount();
            $option = '<option value="">Select State</option>';
            if ($rows_affected > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['state_id'] == $state_id) {
                        $option.= '<option value="' . $row['state_id'] . '" selected>' . $row['state_name'] . '</option>';
                    } else {
                        $option.= '<option value="' . $row['state_id'] . '">' . $row['state_name'] . '</option>';
                    }
                }
            }
            return $option;
            //$DBH->commit();
            
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    public function chkCityNameExists($city_name, $state_id, $country_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblcities` WHERE `city_name` = '" . $city_name . "' AND `state_id` = '" . $state_id . "' AND `country_id` = '" . $country_id . "' AND `city_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addCity($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcities` (`country_id`,`state_id`,`city_name`,`city_status`,`added_by_admin`) 

					VALUES (:country_id,:state_id,:city_name,:city_status,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_id' => $tdata['country_id'], ':state_id' => $tdata['state_id'], ':city_name' => addslashes($tdata['city_name']), ':city_status' => '1', ':added_by_admin' => $tdata['admin_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCity] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getCityDetails($city_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcities` WHERE `city_id` = '" . $city_id . "' AND `city_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function chkCityNameExists_edit($city_name, $city_id, $country_id, $state_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblcities` WHERE `city_name` = '" . $city_name . "' AND `city_id` != '" . $city_id . "' AND `country_id` = '" . $country_id . "' AND `state_id` = '" . $state_id . "' AND `city_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function updateCity($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcities` SET 

					`country_id` = :country_id,

					`state_id` = :state_id,

					`city_name` = :city_name,

					`modified_by_admin` = :modified_by_admin,

					`city_status` = :status  ,

					`city_modified_date` = '" . date('Y-m-d H:i:s') . "' 

					WHERE `city_id` = :city_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_id' => $tdata['country_id'], ':state_id' => $tdata['state_id'], ':city_name' => addslashes($tdata['city_name']), ':modified_by_admin' => $tdata['admin_id'], ':status' => $tdata['status'], ':city_id' => $tdata['city_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateState] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //area start
    public function GetAllArea($txtsearch = '', $status = '', $country_id = '', $state_id = '', $city_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `area_name` LIKE '%" . $txtsearch . "%' OR  `area_pincode` LIKE '%" . $txtsearch . "%' ) ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND `area_status` = '" . $status . "' ";
        }
        $sql_country_str = "";
        if ($country_id != '') {
            $sql_country_str = " AND `country_id` = '" . $country_id . "' ";
        }
        $sql_state_str = "";
        if ($state_id != '') {
            $sql_state_str = " AND `state_id` = '" . $state_id . "' ";
        }
        $sql_city_str = "";
        if ($city_id != '') {
            $sql_state_str = " AND `city_id` = '" . $city_id . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(area_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(area_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(area_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(area_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(area_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblarea` WHERE `area_deleted` = '0'  " . $sql_search_str . " " . $sql_status_str . " " . $sql_country_str . " " . $sql_state_str . " " . $sql_city_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY `area_name` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function DeleteArea($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblarea` SET  `area_deleted` = '1', `area_modified_date` = '" . date('Y-m-d H:i:s') . "' ,`deleted_by_admin` = '" . $admin_id . "' WHERE `area_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function GetCity($state_id, $country_id, $city_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $status = 1;
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblcities` WHERE `country_id` =:country_id and `state_id` = :state_id AND `city_deleted` = 0 ORDER BY `city_name` ASC ";
            $STH = $DBH->prepare($sql);
            $STH->bindParam('country_id', $country_id);
            $STH->bindParam('state_id', $state_id);
            $STH->execute();
            $rows_affected = $STH->rowCount();
            $option = '<option value="">Select City</option>';
            if ($rows_affected > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['city_id'] == $city_id) {
                        $option.= '<option value="' . $row['city_id'] . '" selected>' . $row['city_name'] . '</option>';
                    } else {
                        $option.= '<option value="' . $row['city_id'] . '">' . $row['city_name'] . '</option>';
                    }
                }
            }
            return $option;
            //$DBH->commit();
            
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    public function chkAreaNameExists($area_name, $state_id, $country_id, $city_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblarea` WHERE `area_name` = '" . $area_name . "' AND `state_id` = '" . $state_id . "' AND `country_id` = '" . $country_id . "' AND `city_id` = '" . $city_id . "' AND `area_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addArea($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblarea` (`country_id`,`state_id`,`city_id`,`area_name`,`area_pincode`,`area_status`,`added_by_admin`) 

					VALUES (:country_id,:state_id,:city_id,:area_name,:area_pincode,:area_status,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_id' => $tdata['country_id'], ':state_id' => $tdata['state_id'], ':city_id' => $tdata['city_id'], ':area_name' => addslashes($tdata['area_name']), ':area_pincode' => $tdata['area_pincode'], ':area_status' => '1', ':added_by_admin' => $tdata['admin_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCity] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function GetCityName($city_id) {
        $return = '';
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT `city` FROM `tblcities` where `city_id`= '" . $city_id . "' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r['city'];
            }
            return $return;
        }
        catch(Exception $ex) {
            echo $e->getMessage();
        }
    }
    public function getAreaDetails($area_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblarea` WHERE `area_id` = '" . $area_id . "' AND `area_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function chkAreaNameExists_edit($area_name, $area_id, $country_id, $state_id, $city_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblarea` WHERE `area_name` = '" . $area_name . "' AND `area_id` != '" . $area_id . "' AND `country_id` = '" . $country_id . "' AND `state_id` = '" . $state_id . "' AND `city_id` = '" . $city_id . "' AND `area_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function updateArea($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblarea` SET 

					`country_id` = :country_id,

					`state_id` = :state_id,

					`city_id` = :city_id,

					`area_name` = :area_name,

					`area_pincode` = :area_pincode,

					`modified_by_admin` = :modified_by_admin,

					`area_status` = :status  ,

					`area_modified_date` = '" . date('Y-m-d H:i:s') . "' 

					WHERE `area_id` = :area_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':country_id' => $tdata['country_id'], ':state_id' => $tdata['state_id'], ':city_id' => $tdata['city_id'], ':area_name' => addslashes($tdata['area_name']), ':area_pincode' => $tdata['area_pincode'], ':modified_by_admin' => $tdata['admin_id'], ':status' => $tdata['status'], ':area_id' => $tdata['area_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateArea] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //items start
    public function GetAllItems($txtsearch = '', $status = '', $ingredient_id = '', $parent_cat_id = '', $main_cat_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `item_name` LIKE '%" . $txtsearch . "%' OR `item_code` LIKE '%" . $txtsearch . "%' )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND `item_status` = '" . $status . "' ";
        }
        $sql_ingredient_id_str = "";
        if ($ingredient_id != '') {
            $sql_ingredient_id_str = " AND `item_id` IN(SELECT `item_id` FROM `tblitemingredients` WHERE `ingredient_id` = '" . $ingredient_id . "' AND `iig_deleted` = '0' ) ";
        }
        $sql_cat_id_str = "";
        if ($parent_cat_id != '' && $main_cat_id != '') {
            $sql_cat_id_str = " AND `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_parent_id` = '" . $parent_cat_id . "' AND `ic_cat_id` = '" . $main_cat_id . "' AND `ic_deleted` = '0' ) ";
        }
        $sql_parent_cat_id_str = "";
        if ($parent_cat_id != '') {
            $sql_parent_cat_id_str = " AND `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_parent_id` = '" . $parent_cat_id . "' AND `ic_deleted` = '0' ) ";
        }
        $sql_main_cat_id_str = "";
        if ($main_cat_id != '') {
            $sql_main_cat_id_str = " AND `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_id` = '" . $main_cat_id . "' AND `ic_deleted` = '0' ) ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(item_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(item_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(item_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(item_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(item_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblitems` WHERE `item_deleted` = '0'  " . $sql_search_str . " " . $sql_status_str . "  " . $sql_ingredient_id_str . " " . $sql_parent_cat_id_str . " " . $sql_main_cat_id_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . " ORDER BY `item_add_date` DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function DeleteItem($id, $admin_id) {
        $this->DeleteItemById($id, $admin_id); {
            $this->DeleteIngredientsById($id, $admin_id);
            $this->DeleteItemCatById($id, $admin_id);
            return true;
        }
        return false;
    }
    public function GetCategoryID($cat_id, $parent_cat_id) {
        $return = '';
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblcategories` where `cat_id` = '" . $cat_id . "' AND `parent_cat_id`= '" . $parent_cat_id . "' ORDER BY `cat_name` ASC";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = '<option value="' . $r['cat_id'] . '" selected>' . $r['cat_name'] . '</option>';
            }
            return $return;
        }
        catch(Exception $ex) {
            echo $e->getMessage();
        }
    }
    public function GetCategories($cat_id, $parent_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        if ($parent_cat_id === '') {
            $rowcount = 0;
        } else {
            $sql = "SELECT * FROM `tblcategories` where `parent_cat_id` = '" . $parent_cat_id . "' AND `cat_deleted` = 0  ORDER BY `cat_name` ASC";
            $STH = $DBH->query($sql);
            $rowcount = $STH->rowCount();
        }
        $option_str.= '<option value="">Select Category</option>';
        if ($rowcount > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['cat_id'] == $cat_id) {
                    $option_str.= '<option value="' . $row['cat_id'] . '" selected>' . $row['cat_name'] . '</option>';
                } else {
                    $option_str.= '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
            }
            return $option_str;
        } else {
            return $option_str;
        }
    }
    public function GetCategoriesById($cat_id, $parent_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        if ($parent_cat_id === '') {
            $rowcount = 0;
        } else {
            $sql = "SELECT * FROM `tblcategories` where `parent_cat_id` = '" . $parent_cat_id . "' AND `cat_deleted` = 0  ORDER BY `cat_name` ASC";
            $STH = $DBH->query($sql);
            $rowcount = $STH->rowCount();
        }
        $option_str.= '<option value="">Select Category</option>';
        if ($rowcount > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['cat_id'] == $cat_id) {
                    $option_str.= '<option value="' . $row['cat_id'] . '" selected>' . $row['cat_name'] . '</option>';
                } else {
                    $option_str.= '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
            }
            return $option_str;
        } else {
            return $option_str;
        }
    }
    public function chkItemNameExists($item_name) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblitems` WHERE `item_name` = '" . $item_name . "' AND `item_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addItems($tdata) {
        $return = false;
        try {
            $this->AddItem($tdata);
            $item_id = $this->GetLastItemId();
            $ing_id = $tdata['ingredient_id'];
            if (is_array($ing_id) && count($ing_id) > 0) {
                for ($i = 0;$i < count($ing_id);$i++) {
                    $this->AddIngredient($ing_id[$i], $item_id, $tdata);
                }
            }
            $parent = $tdata['parent_cat_id'];
            $cat = $tdata['cat_id'];
            $cat_show = $tdata['cat_show'];
            for ($c = 0;$c < count($parent);$c++) {
                $this->AddItemCat($item_id, $parent[$c], $cat[$c], $tdata['admin_id'], $cat_show[$c]);
            }
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addItems] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function AddItem($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblitems` (`item_name`,`item_status`,`added_by_admin`,`item_disc1`,`item_disc2`,`item_disc_show1`,`item_disc_show2`,`item_add_date`,`ingredient_show`,`ingredient_type`,`item_code`) 

					VALUES (:item_name,:item_status,:added_by_admin,:item_disc1,:item_disc2,:item_disc_show1,:item_disc_show2,:item_add_date,:ingredient_show,:ingredient_type,:item_code)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':item_name' => addslashes($tdata['item_name']), ':item_status' => '1', ':added_by_admin' => $tdata['admin_id'], ':item_disc1' => addslashes($tdata['item_disc1']), ':item_disc2' => addslashes($tdata['item_disc2']), ':item_disc_show1' => addslashes($tdata['item_disc_show1']), ':item_disc_show2' => addslashes($tdata['item_disc_show2']), ':item_add_date' => date('Y-m-d H:i:s'), ':ingredient_show' => addslashes($tdata['ingredient_show']), ':ingredient_type' => addslashes($tdata['ingredient_type']), ':item_code' => addslashes($tdata['item_code'])));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[AddItem] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function GetLastItemId() {
        $return = '';
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT MAX(`item_id`) as id FROM `tblitems` where `item_deleted`= 0 ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r['id'];
            }
            return $return;
        }
        catch(Exception $ex) {
            echo $e->getMessage();
        }
    }
    public function AddIngredient($ing_id, $item_id, $tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblitemingredients` (`item_id`,`ingredient_name`,`iig_status`,`added_by_admin`,`ingredient_id`,`iig_add_date`) 

					VALUES (:item_id,:ingredient_name,:iig_status,:added_by_admin,:ingredient_id,:iig_add_date)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':item_id' => $item_id, ':ingredient_name' => $tdata['ingredient_name'], ':iig_status' => '1', ':added_by_admin' => $tdata['admin_id'], ':ingredient_id' => $ing_id, ':iig_add_date' => date('Y-m-d H:i:s')));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[AddIngredient] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function AddItemCat($item_id, $parent_id, $cat_id, $admin_id, $cat_sh) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblitemcategory` (`item_id`,`ic_cat_parent_id`,`ic_cat_id`,`ic_status`,`added_by_admin`,`ic_show`,`ic_add_date`) 

					VALUES (:item_id,:ic_cat_parent_id,:ic_cat_id,:ic_status,:added_by_admin,:ic_show,:ic_add_date)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':item_id' => $item_id, ':ic_cat_parent_id' => addslashes($parent_id), ':ic_cat_id' => addslashes($cat_id), ':ic_status' => '1', ':added_by_admin' => $admin_id, ':ic_show' => $cat_sh, ':ic_add_date' => date('Y-m-d H:i:s')));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[AddItemCat] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getItemDetails($item_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblitems` WHERE `item_id` = '" . $item_id . "' AND `item_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getingredientDetails($item_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql = "SELECT * FROM `tblitemingredients` WHERE `iig_deleted` = '0' AND `item_id` = '" . $item_id . "'  ORDER BY `iig_id` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getcategoryDetails($item_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql = "SELECT * FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `item_id` = '" . $item_id . "'  ORDER BY `ic_id` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function chkItemNameExists_edit($item_name, $item_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblitems` WHERE `item_name` = '" . $item_name . "' AND `item_id` != '" . $item_id . "' AND `item_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function UpdateItems($tdata) {
        $return = false;
        try {
            $this->UpdateItem($tdata);
            $this->UpdateIngredient($tdata);
            $item_id = $tdata['item_id'];
            $ing_id = $tdata['ingredient_id'];
            for ($i = 0;$i < count($ing_id);$i++) {
                $this->AddIngredient($ing_id[$i], $item_id, $tdata);
            }
            $this->UpdateCategories($tdata);
            $parent = $tdata['parent_cat_id'];
            $cat = $tdata['cat_id'];
            $cat_show = $tdata['cat_show'];
            for ($c = 0;$c < count($parent);$c++) {
                $this->AddItemCat($item_id, $parent[$c], $cat[$c], $tdata['admin_id'], $cat_show[$c]);
            }
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[UpdateItems] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function UpdateItem($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblitems` SET 

					`item_name` = :item_name,

					`item_disc1` = :item_disc1,

					`item_disc2` = :item_disc2,

					`item_disc_show1` = :item_disc_show1,

					`item_disc_show2` = :item_disc_show2,

					`item_status` = :item_status,

					`modified_by_admin` = :modified_by_admin,

					`item_modified_date` = :item_modified_date, 

					`ingredient_show` = :ingredient_show, 

					`ingredient_type` = :ingredient_type,

					`item_code` = :item_code			

					WHERE `item_id` = :item_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':item_name' => addslashes($tdata['item_name']), ':item_disc1' => addslashes($tdata['item_disc1']), ':item_disc2' => addslashes($tdata['item_disc2']), ':item_disc_show1' => addslashes($tdata['item_disc_show1']), ':item_disc_show2' => addslashes($tdata['item_disc_show2']), ':item_status' => $tdata['item_status'], ':modified_by_admin' => $tdata['admin_id'], ':item_modified_date' => date('Y-m-d H:i:s'), ':ingredient_show' => $tdata['ingredient_show'], ':ingredient_type' => $tdata['ingredient_type'], ':item_code' => addslashes($tdata['item_code']), ':item_id' => $tdata['item_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[UpdateItem] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function UpdateIngredient($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblitemingredients` SET 

					`iig_deleted` = :iig_deleted,

					`modified_by_admin` = :modified_by_admin,

					`iig_modified_date` = '" . date('Y-m-d H:i:s') . "' 

					WHERE `item_id` = :item_id";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':iig_deleted' => '1', ':modified_by_admin' => $tdata['admin_id'], ':item_id' => $tdata['item_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[UpdateIngredient] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function UpdateCategories($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblitemcategory` SET 

					`ic_deleted` = :ic_deleted,

					`modified_by_admin` = :modified_by_admin,

					`ic_modified_date` = '" . date('Y-m-d H:i:s') . "' 

					WHERE `item_id` = :item_id";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':ic_deleted' => '1', ':modified_by_admin' => $tdata['admin_id'], ':item_id' => $tdata['item_id'],));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[UpdateIngredient] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function DeleteItemById($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblitems` SET  `item_deleted` = '1', `item_modified_date` = '" . date('Y-m-d H:i:s') . "' ,`deleted_by_admin` = '" . $admin_id . "' WHERE `item_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function DeleteIngredientsById($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblitemingredients` SET  `iig_deleted` = '1', `iig_modified_date` = '" . date('Y-m-d H:i:s') . "' ,`deleted_by_admin` = '" . $admin_id . "' WHERE `item_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function DeleteItemCatById($id, $admin_id) {
        $return = false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblitemcategory` SET  `ic_deleted` = '1', `ic_modified_date` = '" . date('Y-m-d H:i:s') . "' ,`deleted_by_admin` = '" . $admin_id . "' WHERE `item_id`='" . $id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function GetIngredientsById($item_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $not_item_id = "";
        if (is_array($item_id) && count($item_id) > 0) {
            $it_str = implode(',', $item_id);
            $not_item_id = " AND `item_id` NOT IN (" . $it_str . ") ";
            for ($i = 0;$i < count($item_id);$i++) {
                $option_str.= '<option value="' . $item_id[$i] . '" selected>' . $this->GetItemName($item_id[$i]) . '</option>';
            }
        }
        try {
            $sql = "SELECT * FROM `tblitems` WHERE item_deleted = '0' AND  `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_id` = '54' AND ic_deleted = '0' ORDER BY ic_add_date ASC) " . $not_item_id . " ORDER BY item_name ASC ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if (in_array($row['item_id'], $item_id)) {
                        $option_str.= '<option value="' . $row['item_id'] . '" selected>' . $row['item_name'] . '</option>';
                    } else {
                        $option_str.= '<option value="' . $row['item_id'] . '">' . $row['item_name'] . '</option>';
                    }
                }
                return $option_str;
            } else {
                return $option_str;
            }
        }
        catch(Exception $e) {
            $stringData = '[GetIngredientsById] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $option_str;
        }
    }
    public function getIngredientsByIngrdientType($ingredient_type, $item_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $not_item_id = "";
        if (is_array($item_id) && count($item_id) > 0) {
            $it_str = implode(',', $item_id);
            if ($it_str != '') {
                $not_item_id = " AND `item_id` NOT IN (" . $it_str . ") ";
            }
            for ($i = 0;$i < count($item_id);$i++) {
                if ($item_id[$i] != '') {
                    $option_str.= '<option value="' . $item_id[$i] . '" selected>' . $this->GetItemName($item_id[$i]) . '</option>';
                }
            }
        }
        $sql_ingredient_type_str = "";
        if (is_array($ingredient_type)) {
            if (count($ingredient_type) > 0) {
                $str_ingredient_type = implode(',', $ingredient_type);
                $sql_ingredient_type_str = " AND ic_cat_id IN(" . $str_ingredient_type . ")";
            }
        }
        try {
            //$sql = "SELECT * FROM `tblitems` WHERE item_deleted = '0' AND  `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_id` = '54' AND ic_deleted = '0' ORDER BY ic_add_date ASC) ".$not_item_id." ORDER BY item_name ASC ";
            $sql = "SELECT * FROM `tblitems` WHERE item_deleted = '0' AND  `item_id` IN(select `item_id` from `tblitemcategory` WHERE ic_deleted = '0' " . $sql_ingredient_type_str . " ORDER BY ic_add_date ASC) " . $not_item_id . " ORDER BY item_name ASC ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if (in_array($row['item_id'], $item_id)) {
                        $option_str.= '<option value="' . $row['item_id'] . '" selected>' . $row['item_name'] . '</option>';
                    } else {
                        $option_str.= '<option value="' . $row['item_id'] . '">' . $row['item_name'] . '</option>';
                    }
                }
                return $option_str;
            } else {
                return $option_str;
            }
        }
        catch(Exception $e) {
            $stringData = '[getIngredientsByIngrdientType] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $option_str;
        }
    }
    //Manage Cusines - Start
    public function getAllCusines($txtsearch = '', $status = '', $cucat_parent_cat_id = '', $cucat_cat_id = '', $vendor_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $delivery_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND TBI.item_name LIKE '%" . $txtsearch . "%' ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TBC.cusine_status = '" . $status . "' ";
        }
        $sql_leftjoin_cucat = "";
        $sql_cucat_parent_cat_id_str = "";
        $sql_cucat_cat_id_str = "";
        if ($cucat_parent_cat_id != '') {
            $sql_leftjoin_cucat = " LEFT JOIN `tblcusinecategory` AS TCC ON TBC.cusine_id = TCL.cusine_id ";
            $sql_cucat_parent_cat_id_str = " AND TCC.cucat_parent_cat_id = '" . $cucat_parent_cat_id . "' AND TCC.cucat_deleted = '0' ";
            if ($cucat_cat_id != '') {
                $sql_cucat_cat_id_str = " AND TCC.cucat_cat_id = '" . $cucat_cat_id . "' ";
            }
        }
        $sql_vendor_id_str = "";
        if ($vendor_id != '') {
            $sql_vendor_id_str = " AND TBC.vendor_id = '" . $vendor_id . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND TBC.added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(TBC.cusine_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(TBC.cusine_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TBC.cusine_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TBC.cusine_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(TBC.cusine_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( TBC.cusine_country_id = '" . $country_id . "' OR TBC.cusine_country_id = '-1' OR  FIND_IN_SET(" . $country_id . ", TBC.cusine_country_id) > 0  )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( TBC.cusine_state_id = '" . $state_id . "' OR TBC.cusine_state_id = '-1' OR  FIND_IN_SET(" . $state_id . ", TBC.cusine_state_id) > 0  ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( TBC.cusine_city_id = '" . $city_id . "' OR TBC.cusine_city_id = '-1' OR  FIND_IN_SET(" . $city_id . ", TBC.cusine_city_id) > 0  ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( TBC.cusine_area_id = '" . $area_id . "' OR TBC.cusine_area_id = '-1' OR TBC.cusine_area_id = '-1' OR  FIND_IN_SET(" . $area_id . ", TBC.cusine_area_id) > 0 ) ";
        }
        $sql_delivery_date_str = "";
        if ($delivery_date != '') {
            $today_day_of_month = date('j');
            $today_day_of_week = date('N');
            $today_single_date = date('Y-m-d');
            $delivery_day_of_month = date('j', strtotime($delivery_date));
            $delivery_day_of_week = date('N', strtotime($delivery_date));
            $delivery_single_date = date('Y-m-d', strtotime($delivery_date));
            $sql_delivery_date_str = " AND ( 

								( TBC.publish_date_type = 'days_of_month' AND ( TBC.publish_days_of_month = '-1' OR TBC.publish_days_of_month = '" . $today_day_of_month . "' OR  FIND_IN_SET(" . $today_day_of_month . ", TBC.publish_days_of_month) > 0 ) ) OR

								( TBC.publish_date_type = 'days_of_week' AND ( TBC.publish_days_of_week = '-1' OR TBC.publish_days_of_week = '" . $today_day_of_week . "' OR  FIND_IN_SET(" . $today_day_of_week . ", TBC.publish_days_of_week) > 0 ) ) OR

								( TBC.publish_date_type = 'single_date' AND ( TBC.publish_single_date <= '" . $today_single_date . "' ) ) OR

								( TBC.publish_date_type = 'date_range' AND ( TBC.publish_start_date <= '" . $today_single_date . "' AND TBC.publish_end_date >= '" . $today_single_date . "' ) ) 

								) ";
            $sql_delivery_date_str.= " AND ( 

								( TBC.delivery_date_type = 'days_of_month' AND ( TBC.delivery_days_of_month = '-1' OR TBC.delivery_days_of_month = '" . $delivery_day_of_month . "' OR  FIND_IN_SET(" . $delivery_day_of_month . ", TBC.delivery_days_of_month) > 0 ) ) OR

								( TBC.delivery_date_type = 'days_of_week' AND ( TBC.delivery_days_of_week = '-1' OR TBC.delivery_days_of_week = '" . $delivery_day_of_week . "' OR  FIND_IN_SET(" . $delivery_day_of_week . ", TBC.delivery_days_of_week) > 0 ) ) OR

								( TBC.delivery_date_type = 'single_date' AND ( TBC.delivery_single_date = '" . $delivery_single_date . "' ) ) OR

								( TBC.delivery_date_type = 'date_range' AND ( TBC.delivery_start_date <= '" . $delivery_single_date . "' AND TBC.delivery_end_date >= '" . $delivery_single_date . "' ) ) 

								) ";
        }
        $sql = "SELECT TBC.*,TCL.cusine_price,TCL.cusine_qty, TBI.item_name, TBV.vendor_name 

				FROM `tblcusines` AS TBC 

				LEFT JOIN `tblcusinelocations` AS TCL ON TBC.cusine_id = TCL.cusine_id

				" . $sql_leftjoin_cucat . "

				LEFT JOIN `tblitems` AS TBI ON TBC.item_id = TBI.item_id

				LEFT JOIN `tblvendors` AS TBV ON TBC.vendor_id = TBV.vendor_id

				WHERE TBC.cusine_deleted = '0' AND TCL.culoc_deleted = '0' AND TCL.default_price = '1'  " . $sql_search_str . " " . $sql_status_str . " " . $sql_cucat_parent_cat_id_str . " " . $sql_cucat_cat_id_str . " " . $sql_vendor_id_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_delivery_date_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDer BY TBC.cusine_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getCommaSeperatedIngredientsOfItem($item_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT ingredient_id FROM `tblitemingredients` WHERE `item_id` = '" . $item_id . "' AND `iig_deleted` = '0' ORDER BY iig_add_date ASC, iig_id ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $output.= stripslashes($this->GetItemName($r['ingredient_id'])) . ',';
                }
                $output = substr($output, 0, -1);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCommaSeperatedIngredients] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function GetItemName($item_id) {
        $return = '';
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT `item_name` FROM `tblitems` where `item_id`= '" . $item_id . "' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r['item_name'];
            }
            return $return;
        }
        catch(Exception $ex) {
            echo $e->getMessage();
        }
    }
    public function getCategoryListingOfItem($item_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT TC1.cat_name AS parent_cat_name, TC2.cat_name AS main_cat_name FROM `tblitemcategory` AS TIC 

					LEFT JOIN `tblcategories` AS TC1 ON TIC.ic_cat_parent_id = TC1.cat_id 

					LEFT JOIN `tblcategories` AS TC2 ON TIC.ic_cat_id = TC2.cat_id

					WHERE TIC.item_id = '" . $item_id . "' AND TIC.ic_deleted = '0' ORDER BY TIC.ic_add_date ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $output.= stripslashes($r['parent_cat_name']) . ' : ' . stripslashes($r['main_cat_name']) . ',<br>';
                }
                $output = substr($output, 0, -5);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCategoryListingOfItem] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getItemOption($item_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Items</option>';
        } else {
            $output.= '<option value="" >Select Item</option>';
        }
        try {
            $sql = "SELECT item_id,item_name FROM `tblitems` WHERE `item_deleted` = '0' AND `item_id` NOT IN (SELECT DISTINCT(item_id) FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `ic_cat_id` = '54' ) ORDER BY item_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['item_id'] == $item_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['item_id'] . '" ' . $selected . '>' . stripslashes($r['item_name']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getItemOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getVendorOption($vendor_id, $type = '1', $multiple = '0') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $vendor_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Vendors</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Vendors</option>';
            }
        } else {
            $output.= '<option value="" >Select Vendor</option>';
        }
        try {
            $sql = "SELECT vendor_id,vendor_name,vendor_unique_id FROM `tblvendors` WHERE `vendor_deleted` = '0' ORDER BY vendor_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($multiple == '1') {
                        if (is_array($vendor_id) && in_array($r['vendor_id'], $vloc_id)) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    } else {
                        if ($r['vendor_id'] == $vendor_id) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    }
                    $output.= '<option value="' . $r['vendor_id'] . '" ' . $selected . '>' . stripslashes($r['vendor_name']) . ' ('.$r['vendor_unique_id'].')</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getVendorOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getVendorOptionByItemId($item_id, $vendor_id, $type = '1', $multiple = '0') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $vendor_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Vendors</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Vendors</option>';
            }
        } else {
            $output.= '<option value="" >Select Vendor</option>';
        }
        $go_ahead = true;
        $item_sql_str = "";
        if ($multiple == '1') {
            if (is_array($item_id) && count($item_id) > 0) {
                if (in_array('-1', $item_id)) {
                } else {
                    $item_str = implode(',', $item_id);
                    $item_sql_str = " AND ( vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblvendorlocations` WHERE vloc_deleted = 0 AND FIND_IN_SET(" . $item_str . ",vloc_speciality_offered) > 0 ) OR vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblcusines` WHERE cusine_deleted = 0 AND item_id IN(" . $item_str . ") > 0 ) )";
                }
            } else {
                if ($item_id != '' && $item_id != 0) {
                    $item_str = $item_id;
                    $item_sql_str = " AND ( vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblvendorlocations` WHERE vloc_deleted = 0 AND FIND_IN_SET(" . $item_str . ",vloc_speciality_offered) > 0 ) OR vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblcusines` WHERE cusine_deleted = 0 AND item_id IN(" . $item_str . ") > 0 ) )";
                } else {
                    $go_ahead = false;
                }
            }
        } else {
            if ($item_id != '' && $item_id != 0) {
                $item_str = $item_id;
                $item_sql_str = " AND ( vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblvendorlocations` WHERE vloc_deleted = 0 AND FIND_IN_SET(" . $item_str . ",vloc_speciality_offered) > 0 ) OR vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblcusines` WHERE cusine_deleted = 0 AND item_id IN(" . $item_str . ") > 0 ) )";
            } else {
                $go_ahead = false;
            }
        }
        if ($go_ahead) {
            try {
                $sql = "SELECT vendor_id,vendor_name FROM `tblvendors` WHERE `vendor_deleted` = '0' " . $item_sql_str . " ORDER BY vendor_name ASC";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($multiple == '1') {
                            if (is_array($vendor_id) && in_array($r['vendor_id'], $vloc_id)) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        } else {
                            if ($r['vendor_id'] == $vendor_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        }
                        $output.= '<option value="' . $r['vendor_id'] . '" ' . $selected . '>' . stripslashes($r['vendor_name']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getVendorOptionByItemId] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function getVendorLocationOption($vendor_id, $vloc_id, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $vloc_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Locations</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Locations</option>';
            }
        } else {
            $output.= '<option value="" >Select Location</option>';
        }
        $go_ahead = true;
        $vendor_sql_str = "";
        if ($multiple == '1') {
            if (is_array($vendor_id) && count($vendor_id) > 0) {
                if (in_array('-1', $vendor_id)) {
                } else {
                    $vendor_str = implode(',', $vendor_id);
                    $vendor_sql_str = " AND TVL.vendor_id IN (" . $vendor_str . ")";
                }
            } else {
                if ($vendor_id != '' && $vendor_id != 0) {
                    $vendor_sql_str = " AND TVL.vendor_id = '" . $vendor_id . "' ";
                } else {
                    $go_ahead = false;
                }
            }
        } else {
            if ($vendor_id != '' && $vendor_id != 0) {
                $vendor_sql_str = " AND TVL.vendor_id = '" . $vendor_id . "' ";
            } else {
                $go_ahead = false;
            }
        }
        if ($go_ahead) {
            try {
                $sql = "SELECT TVL.vloc_id,TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblvendorlocations` AS TVL

						LEFT JOIN `tblcountry` AS TCN ON TVL.country_id = TCN.country_id 

						LEFT JOIN `tblstates` AS TST ON TVL.state_id = TST.state_id 

						LEFT JOIN `tblcities` AS TCT ON TVL.city_id = TCT.city_id 

						LEFT JOIN `tblarea` AS TAR ON TVL.area_id = TAR.area_id 

						WHERE TVL.vloc_deleted = '0' " . $vendor_sql_str . " ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($multiple == '1') {
                            if (is_array($vloc_id) && in_array($r['vloc_id'], $vloc_id)) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        } else {
                            if ($r['vloc_id'] == $vloc_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        }
                        $output.= '<option value="' . $r['vloc_id'] . '" ' . $selected . '>' . stripslashes($r['area_name']) . ', ' . stripslashes($r['city_name']) . ', ' . stripslashes($r['state_name']) . ', ' . stripslashes($r['country_name']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getVendorLocationOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function chkReferenceNumberExists($reference_number) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $sql = "SELECT * FROM `tbl_event_master` where `reference_number` = '" . $reference_number . "' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getVendorLocationStringByVlocId($vloc_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT TVL.vloc_id,TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblvendorlocations` AS TVL

					LEFT JOIN `tblcountry` AS TCN ON TVL.country_id = TCN.country_id 

					LEFT JOIN `tblstates` AS TST ON TVL.state_id = TST.state_id 

					LEFT JOIN `tblcities` AS TCT ON TVL.city_id = TCT.city_id 

					LEFT JOIN `tblarea` AS TAR ON TVL.area_id = TAR.area_id 

					WHERE TVL.vloc_deleted = '0' AND TVL.vloc_id = '" . $vloc_id . "' ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $output = stripslashes($r['area_name']) . ', ' . stripslashes($r['city_name']) . ', ' . stripslashes($r['state_name']) . ', ' . stripslashes($r['country_name']);
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getVendorLocationStringByVlocId] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getServingTypeOption($serving_type_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Type</option>';
        } else {
            $output.= '<option value="" >Select Type</option>';
        }
        try {
            $sql = "SELECT cat_id as serving_type_id, cat_name as serving_type FROM `tblcategories` WHERE `parent_cat_id` = '61' AND `cat_deleted` = '0' ORDER BY serving_type ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['serving_type_id'] == $serving_type_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['serving_type_id'] . '" ' . $selected . '>' . stripslashes($r['serving_type']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getServingTypeOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getServingSizeOption($serving_size_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Size</option>';
        } else {
            $output.= '<option value="" >Select Size</option>';
        }
        try {
            $sql = "SELECT cat_id as serving_size_id, cat_name as serving_size FROM `tblcategories` WHERE `parent_cat_id` = '76' AND `cat_deleted` = '0' ORDER BY serving_size ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['serving_size_id'] == $serving_size_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['serving_size_id'] . '" ' . $selected . '>' . stripslashes($r['serving_size']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getServingSizeOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getMainProfileOption($cat_id, $type = '1', $multiple = '', $default_cat_ids = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql_default_cat_id_str = "";
        if ($default_cat_ids != '' && $default_cat_ids != '-1') {
            $sql_default_cat_id_str = " AND prct_cat_id IN (" . $default_cat_ids . ") ";
        }
        if ($type == '2') {
            if ($multiple == '1') {
                if (is_array($cat_id) && count($cat_id) > 0 && in_array('-1', $cat_id)) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $output.= '<option value="-1" ' . $sel . ' >All Main Profiles</option>';
            } else {
                $sel = '';
                $output.= '<option value="" ' . $sel . ' >All Main Profiles</option>';
            }
        } else {
            $output.= '<option value="" >Select Main Profile</option>';
        }
        try {
            //$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '0' ".$sql_default_cat_id_str." AND `cat_deleted` = '0' ORDER BY cat_name ASC";
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' " . $sql_default_cat_id_str . " AND  `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";
            //$this->debuglog('[getMainProfileOption] sql:'.$sql);
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($multiple == '1') {
                        if (is_array($cat_id) && count($cat_id) > 0 && in_array($r['prct_cat_id'], $cat_id)) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    } else {
                        if ($r['prct_cat_id'] == $cat_id) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    }
                    $output.= '<option value="' . $r['prct_cat_id'] . '" ' . $selected . '>' . stripslashes($r['prct_cat']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getMainProfileOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            //$this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getMainCategoryOption($parent_cat_id, $cat_id, $type = '1', $multiple = '', $default_cat_ids = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql_default_cat_id_str = "";
        //comment date 21-12-20
        // if ($default_cat_ids != '' && $default_cat_ids != '-1') {
        //     $sql_default_cat_id_str = " AND tblfavcategory.fav_cat_id IN (" . $default_cat_ids . ") ";
        // }
        if ($type == '2') {
            if ($multiple == '1') {
                if (is_array($cat_id) && count($cat_id) > 0 && in_array('-1', $cat_id)) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $output.= '<option value="-1" ' . $sel . ' >All Categories</option>';
            } else {
                $sel = '';
                $output.= '<option value="" ' . $sel . ' >All Categories</option>';
            }
        } else {
            $output.= '<option value="" >Select Category</option>';
        }
        $go_ahead = false;
        if ($multiple == '1') {
            if (is_array($parent_cat_id)) {
                if (count($parent_cat_id) > 0) {
                    $go_ahead = true;
                    $parent_cat_id_str = implode(',', $parent_cat_id);
                    $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id IN (" . $parent_cat_id_str . ") ";
                } else {
                    if ($parent_cat_id != '') {
                        $go_ahead = true;
                        $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' ";
                    }
                }
            } else {
                if ($parent_cat_id != '') {
                    $go_ahead = true;
                    $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' ";
                }
            }
        } else {
            if ($parent_cat_id != '' && $parent_cat_id != '-1') {
                $go_ahead = true;
                $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' ";
            }
        }
        if ($go_ahead) {
            try {
                //$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";
                //$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE ".$sql_parent_cat_id_str." ".$sql_default_cat_id_str." AND `cat_deleted` = '0' ORDER BY cat_name ASC";
               $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE " . $sql_parent_cat_id_str . " " . $sql_default_cat_id_str . " and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC"; 
                $STH = $DBH->query($sql); 
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($multiple == '1') {
                            if (in_array($r['favcat_id'], $cat_id)) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        } else {
                            if ($r['favcat_id'] == $cat_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        }
                        $output.= '<option value="' . $r['favcat_id'] . '" ' . $selected . '>' . stripslashes($r['fav_cat']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getMainCategoryOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function getShowHideOption($val, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Options</option>';
        } else {
            $output.= '<option value="" >Select Option</option>';
        }
        if ($val == '1') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="1" ' . $selected . '>Show</option>';
        if ($val == '0') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="0" ' . $selected . '>Hide</option>';
        return $output;
    }
    public function getDefaultPriceOption($val, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Options</option>';
        } else {
            $output.= '<option value="" >Select Option</option>';
        }
        if ($val == '1') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="1" ' . $selected . '>Yes</option>';
        if ($val == '0') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="0" ' . $selected . '>No</option>';
        return $output;
    }
    public function getYesNoOption($val, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Options</option>';
        } else {
            $output.= '<option value="" >Select Option</option>';
        }
        if ($val == '1') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="1" ' . $selected . '>Yes</option>';
        if ($val == '0') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="0" ' . $selected . '>No</option>';
        return $output;
    }
    public function getStatusOption($val, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Status</option>';
        } else {
            $output.= '<option value="" >Select Status</option>';
        }
        if ($val == '1') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="1" ' . $selected . '>Active</option>';
        if ($val == '0') {
            $selected = ' selected ';
        } else {
            $selected = '';
        }
        $output.= '<option value="0" ' . $selected . '>Inactive</option>';
        return $output;
    }
    public function getCountryOption($country_id, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $country_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Countries</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Countries</option>';
            }
        } else {
            $output.= '<option value="" >Select Country</option>';
        }
        try {
            $sql = "SELECT country_id,country_name FROM `tblcountry` WHERE `country_deleted` = '0' ORDER BY country_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($multiple == '1') {
                        if (in_array($r['country_id'], $country_id)) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    } else {
                        if ($r['country_id'] == $country_id) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    }
                    $output.= '<option value="' . $r['country_id'] . '" ' . $selected . '>' . stripslashes($r['country_name']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getCountryOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getStateOption($country_id, $state_id, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $state_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All States</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All States</option>';
            }
        } else {
            $output.= '<option value="" >Select State</option>';
        }
        $go_ahead = true;
        $country_sql_str = "";
        if ($multiple == '1') {
            if (is_array($country_id) && count($country_id) > 0) {
                if (in_array('-1', $country_id)) {
                } else {
                    $country_str = implode(',', $country_id);
                    $country_sql_str = " AND country_id IN (" . $country_str . ")";
                }
            } else {
                $go_ahead = false;
            }
        } else {
            if ($country_id != '' || $country_id != 0) {
                $country_sql_str = " AND country_id = '" . $country_id . "' ";
            } else {
                $go_ahead = false;
            }
        }
        if ($go_ahead) {
            try {
                $sql = "SELECT state_id,state FROM `tblstates` WHERE `state_deleted` = '0' " . $country_sql_str . " ORDER BY state ASC";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($multiple == '1') {
                            if (is_array($state_id) && in_array($r['state_id'], $state_id)) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        } else {
                            if ($r['state_id'] == $state_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        }
                        $output.= '<option value="' . $r['state_id'] . '" ' . $selected . '>' . stripslashes($r['state']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getStateOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function getCityOption($country_id, $state_id, $city_id, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $city_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Cities</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Cities</option>';
            }
        } else {
            $output.= '<option value="" >Select City</option>';
        }
        $go_ahead = true;
        $state_sql_str = "";
        $country_sql_str = "";
        if ($multiple == '1') {
            if (is_array($country_id) && count($country_id) > 0) {
                if (in_array('-1', $country_id)) {
                } else {
                    $country_str = implode(',', $country_id);
                    $country_sql_str = " AND country_id IN (" . $country_str . ")";
                }
                if (is_array($state_id) && count($state_id) > 0) {
                    if (in_array('-1', $state_id)) {
                    } else {
                        $state_str = implode(',', $state_id);
                        $state_sql_str = " AND state_id IN (" . $state_str . ")";
                    }
                } else {
                    $go_ahead = false;
                }
            } else {
                $go_ahead = false;
            }
        } else {
            if ($country_id != '' || $country_id != 0) {
                $country_sql_str = " AND country_id = '" . $country_id . "' ";
            } else {
                $go_ahead = false;
            }
            if ($state_id != '' || $state_id != 0) {
                $state_sql_str = " AND state_id = '" . $state_id . "' ";
            } else {
                $go_ahead = false;
            }
        }
        if ($go_ahead) {
            try {
                $sql = "SELECT city_id,city FROM `tblcities` WHERE `city_deleted` = '0' " . $country_sql_str . " " . $state_sql_str . " ORDER BY city ASC";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($multiple == '1') {
                            if (is_array($city_id) && in_array($r['city_id'], $city_id)) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        } else {
                            if ($r['city_id'] == $city_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        }
                        $output.= '<option value="' . $r['city'] . '" ' . $selected . '>' . stripslashes($r['city']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getCityOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function getAreaOption($country_id, $state_id, $city_id, $area_id, $type = '1', $multiple = '') {

        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $area_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Areas</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Areas</option>';
            }
        } else {
            $output.= '<option value="" >Select Area</option>';
        }
        $go_ahead = true;
        $city_sql_str = "";
        $state_sql_str = "";
        $country_sql_str = "";
        if ($multiple == '1') {
            if (is_array($country_id) && count($country_id) > 0) {
                if (in_array('-1', $country_id)) {
                } else {
                    $country_str = implode(',', $country_id);
                    $country_sql_str = " AND country_id IN (" . $country_str . ")";
                }
                if (is_array($state_id) && count($state_id) > 0) {
                    if (in_array('-1', $state_id)) {
                    } else {
                        $state_str = implode(',', $state_id);
                        $state_sql_str = " AND state_id IN (" . $state_str . ")";
                    }
                } else {
                    $go_ahead = false;
                }
                if (is_array($city_id) && count($city_id) > 0) {
                    if (in_array('-1', $city_id)) {
                    } else {
                        $city_str = implode(',', $city_id);
                        $city_sql_str = " AND city_id IN (" . $city_str . ")";
                    }
                } else {
                    $go_ahead = false;
                }
            } else {
                $go_ahead = false;
            }
        } else {

            if ($country_id != '' || $country_id != 0) {
                $country_sql_str = " AND country_id = '" . $country_id . "' ";
            } else {
                $go_ahead = false;
            }
            if ($state_id != '' || $state_id != 0) {
                $state_sql_str = " AND state_id = '" . $state_id . "' ";
            } else {
                $go_ahead = false;
            }
            if ($city_id != '' || $city_id != 0) {
                $city_sql_str = " AND city_id = '" . $this->getCityIdbyName($city_id) . "' ";
            } else {
                $go_ahead = false;
            }
        }

        if ($go_ahead) {

            try {
                $sql = "SELECT area_id,area_name FROM `tblarea` WHERE `area_deleted` = '0' " . $country_sql_str . " " . $state_sql_str . " " . $city_sql_str . " ORDER BY area_name ASC"; 
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($multiple == '1') {
                            if (is_array($area_id) && in_array($r['area_id'], $area_id)) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        } else {
                            if ($r['area_id'] == $area_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        }
                        $output.= '<option value="' . $r['area_id'] . '" ' . $selected . '>' . stripslashes($r['area_name']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getAreaOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function getDateTypeOption($date_type) {
        $DBH = new DatabaseHandler();
        $output = '';
        $output.= '<option value="" >Select Date Type</option>';
        try {
            $sql = "SELECT date_type,date_type_title FROM `tbldatetype` WHERE `dt_deleted` = '0' ORDER BY dt_id ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['date_type'] == $date_type) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['date_type'] . '" ' . $selected . '>' . stripslashes($r['date_type_title']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getDateTypeOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getDaysOfMonthOption($days_of_month, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $days_of_month)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                $selected = '';
            }
            $output.= '<option value="-1" ' . $selected . ' >All Days</option>';
        } else {
            $output.= '<option value="" >Select Day</option>';
        }
        for ($i = 1;$i <= 31;$i++) {
            if ($multiple == '1') {
                if (in_array($i, $days_of_month)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ($i == $days_of_month) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
        }
        return $output;
    }
    public function getDaysOfWeekOption($days_of_week, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $days_of_week)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                $selected = '';
            }
            $output.= '<option value="-1" ' . $selected . ' >All Days</option>';
        } else {
            $output.= '<option value="" >Select Day</option>';
        }
        $arr_day = array("1" => "Monday", "2" => "Tuesday", "3" => "Wednesday", "4" => "Thursday", "5" => "Friday", "6" => "Saturday", "7" => "Sunday");
        foreach ($arr_day as $key => $val) {
            if ($multiple == '1') {
                if (in_array($key, $days_of_week)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ($key == $days_of_week) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
        }
        return $output;
    }
    public function addCusineCategory($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcusinecategory` (`cusine_id`,`cucat_parent_cat_id`,`cucat_cat_id`,`cucat_show`,`cucat_status`,`cucat_add_date`,`added_by_admin`) 

					VALUES (:cusine_id,:cucat_parent_cat_id,:cucat_cat_id,:cucat_show,:cucat_status,:cucat_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cusine_id' => addslashes($tdata['cusine_id']), ':cucat_parent_cat_id' => addslashes($tdata['cucat_parent_cat_id']), ':cucat_cat_id' => addslashes($tdata['cucat_cat_id']), ':cucat_show' => addslashes($tdata['cucat_show']), ':cucat_status' => addslashes($tdata['cucat_status']), ':cucat_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCusineCategory] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addCusineWeight($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcusineweight` (`cusine_id`,`cw_qt_parent_cat_id`,`cw_qt_cat_id`,`cw_qu_parent_cat_id`,`cw_qu_cat_id`,`cw_quantity`,`cw_show`,`cw_status`,`cw_add_date`,`added_by_admin`) 

					VALUES (:cusine_id,:cw_qt_parent_cat_id,:cw_qt_cat_id,:cw_qu_parent_cat_id,:cw_qu_cat_id,:cw_quantity,:cw_show,:cw_status,:cw_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cusine_id' => addslashes($tdata['cusine_id']), ':cw_qt_parent_cat_id' => addslashes($tdata['cw_qt_parent_cat_id']), ':cw_qt_cat_id' => addslashes($tdata['cw_qt_cat_id']), ':cw_qu_parent_cat_id' => addslashes($tdata['cw_qu_parent_cat_id']), ':cw_qu_cat_id' => addslashes($tdata['cw_qu_cat_id']), ':cw_quantity' => addslashes($tdata['cw_quantity']), ':cw_show' => addslashes($tdata['cw_show']), ':cw_status' => addslashes($tdata['cw_status']), ':cw_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCusineWeight] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addCusineLocation($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcusinelocations` (`cusine_id`,`vendor_id`,`vloc_id`,`ordering_type_id`,`ordering_size_id`,`max_order`,`min_order`,

					`cusine_qty`,`currency_id`,`cusine_price`,`default_price`,`culoc_status`,`culoc_add_date`,`added_by_admin`,`ordering_size_show`,

					`cusine_qty_show`,`sold_qty_show`,`is_offer`,`offer_price`,`offer_date_type`,`offer_days_of_month`,`offer_days_of_week`,`offer_single_date`,

					`offer_start_date`,`offer_end_date`) 

					VALUES (:cusine_id,:vendor_id,:vloc_id,:ordering_type_id,:ordering_size_id,:max_order,:min_order,

					:cusine_qty,:currency_id,:cusine_price,:default_price,:culoc_status,:culoc_add_date,:added_by_admin,:ordering_size_show,

					:cusine_qty_show,:sold_qty_show,:is_offer,:offer_price,:offer_date_type,:offer_days_of_month,:offer_days_of_week,:offer_single_date,

					:offer_start_date,:offer_end_date)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cusine_id' => addslashes($tdata['cusine_id']), ':vendor_id' => addslashes($tdata['vendor_id']), ':vloc_id' => addslashes($tdata['vloc_id']), ':ordering_type_id' => addslashes($tdata['ordering_type_id']), ':ordering_size_id' => addslashes($tdata['ordering_size_id']), ':max_order' => addslashes($tdata['max_order']), ':min_order' => addslashes($tdata['min_order']), ':cusine_qty' => addslashes($tdata['cusine_qty']), ':currency_id' => addslashes($tdata['currency_id']), ':cusine_price' => addslashes($tdata['cusine_price']), ':default_price' => addslashes($tdata['default_price']), ':culoc_status' => addslashes($tdata['culoc_status']), ':culoc_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin'], ':ordering_size_show' => addslashes($tdata['ordering_size_show']), ':cusine_qty_show' => addslashes($tdata['cusine_qty_show']), ':sold_qty_show' => addslashes($tdata['sold_qty_show']), ':is_offer' => addslashes($tdata['is_offer']), ':offer_price' => addslashes($tdata['offer_price']), ':offer_date_type' => addslashes($tdata['offer_date_type']), ':offer_days_of_month' => addslashes($tdata['offer_days_of_month']), ':offer_days_of_week' => addslashes($tdata['offer_days_of_week']), ':offer_single_date' => addslashes($tdata['offer_single_date']), ':offer_start_date' => addslashes($tdata['offer_start_date']), ':offer_end_date' => addslashes($tdata['offer_end_date'])));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCusineLocation] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addCusine($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
        try {
            $sql = "INSERT INTO `tblcusines` (`item_id`,`cusine_type_parent_id`,`cusine_type_id`,`min_cart_price`,`vendor_id`,`vendor_show`,`cusine_image`,

					`cusine_country_id`,`cusine_state_id`,`cusine_city_id`,`cusine_area_id`,`publish_date_type`,`publish_days_of_month`,`publish_days_of_week`,

					`publish_single_date`,`publish_start_date`,`publish_end_date`,`delivery_date_type`,`delivery_days_of_month`,`delivery_days_of_week`,

					`delivery_single_date`,`delivery_start_date`,`delivery_end_date`,`cusine_desc_1`,`cusine_desc_show_1`,`cusine_desc_2`,`cusine_desc_show_2`,

					`cusine_status`,`cusine_add_date`,`added_by_admin`,`order_cutoff_time`,`delivery_time`,`delivery_time_show`,`delivery_date_show`,`cancel_cutoff_time`,`cancel_cutoff_time_show`,`cgst_tax`,`sgst_tax`,`cess_tax`,`gst_tax`) 

					VALUES (:item_id,:cusine_type_parent_id,:cusine_type_id,:min_cart_price,:vendor_id,:vendor_show,:cusine_image,

					:cusine_country_id,:cusine_state_id,:cusine_city_id,:cusine_area_id,:publish_date_type,:publish_days_of_month,:publish_days_of_week,

					:publish_single_date,:publish_start_date,:publish_end_date,:delivery_date_type,:delivery_days_of_month,:delivery_days_of_week,

					:delivery_single_date,:delivery_start_date,:delivery_end_date,:cusine_desc_1,:cusine_desc_show_1,:cusine_desc_2,:cusine_desc_show_2,

					:cusine_status,:cusine_add_date,:added_by_admin,:order_cutoff_time,:delivery_time,:delivery_time_show,:delivery_date_show,:cancel_cutoff_time,:cancel_cutoff_time_show,:cgst_tax,:sgst_tax,:cess_tax,:gst_tax)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':item_id' => addslashes($tdata['item_id']), ':cusine_type_parent_id' => addslashes($tdata['cusine_type_parent_id']), ':cusine_type_id' => addslashes($tdata['cusine_type_id']), ':min_cart_price' => addslashes($tdata['min_cart_price']), ':vendor_id' => addslashes($tdata['vendor_id']), ':vendor_show' => addslashes($tdata['vendor_show']), ':cusine_image' => addslashes($tdata['cusine_image']), ':cusine_country_id' => addslashes($tdata['cusine_country_id']), ':cusine_state_id' => addslashes($tdata['cusine_state_id']), ':cusine_city_id' => addslashes($tdata['cusine_city_id']), ':cusine_area_id' => addslashes($tdata['cusine_area_id']), ':publish_date_type' => addslashes($tdata['publish_date_type']), ':publish_days_of_month' => addslashes($tdata['publish_days_of_month']), ':publish_days_of_week' => addslashes($tdata['publish_days_of_week']), ':publish_single_date' => addslashes($tdata['publish_single_date']), ':publish_start_date' => addslashes($tdata['publish_start_date']), ':publish_end_date' => addslashes($tdata['publish_end_date']), ':delivery_date_type' => addslashes($tdata['delivery_date_type']), ':delivery_days_of_month' => addslashes($tdata['delivery_days_of_month']), ':delivery_days_of_week' => addslashes($tdata['delivery_days_of_week']), ':delivery_single_date' => addslashes($tdata['delivery_single_date']), ':delivery_start_date' => addslashes($tdata['delivery_start_date']), ':delivery_end_date' => addslashes($tdata['delivery_end_date']), ':cusine_desc_1' => addslashes($tdata['cusine_desc_1']), ':cusine_desc_show_1' => addslashes($tdata['cusine_desc_show_1']), ':cusine_desc_2' => addslashes($tdata['cusine_desc_2']), ':cusine_desc_show_2' => addslashes($tdata['cusine_desc_show_2']), ':cusine_status' => addslashes($tdata['cusine_status']), ':cusine_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin'], ':order_cutoff_time' => $tdata['order_cutoff_time'], ':delivery_time' => $tdata['delivery_time'], ':delivery_time_show' => $tdata['delivery_time_show'], ':delivery_date_show' => $tdata['delivery_date_show'], ':cancel_cutoff_time' => $tdata['cancel_cutoff_time'], ':cancel_cutoff_time_show' => $tdata['cancel_cutoff_time_show'], ':cgst_tax' => addslashes($tdata['cgst_tax']), ':sgst_tax' => addslashes($tdata['sgst_tax']), ':cess_tax' => addslashes($tdata['cess_tax']), ':gst_tax' => addslashes($tdata['gst_tax'])));
            $cusine_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($cusine_id > 0) {
                $return = $cusine_id;
                if (count($tdata['vloc_id']) > 0) {
                    for ($i = 0;$i < count($tdata['vloc_id']);$i++) {
                        $tdata_loc = array();
                        $tdata_loc['cusine_id'] = $cusine_id;
                        $tdata_loc['vendor_id'] = $tdata['vendor_id'];
                        $tdata_loc['vloc_id'] = $tdata['vloc_id'][$i];
                        $tdata_loc['ordering_type_id'] = $tdata['ordering_type_id'][$i];
                        $tdata_loc['ordering_size_id'] = $tdata['ordering_size_id'][$i];
                        $tdata_loc['ordering_size_show'] = $tdata['ordering_size_show'][$i];
                        $tdata_loc['max_order'] = $tdata['max_order'][$i];
                        $tdata_loc['min_order'] = $tdata['min_order'][$i];
                        $tdata_loc['cusine_qty'] = $tdata['cusine_qty'][$i];
                        $tdata_loc['cusine_qty_show'] = $tdata['cusine_qty_show'][$i];
                        $tdata_loc['sold_qty_show'] = $tdata['sold_qty_show'][$i];
                        $tdata_loc['currency_id'] = $tdata['currency_id'][$i];
                        $tdata_loc['cusine_price'] = $tdata['cusine_price'][$i];
                        $tdata_loc['default_price'] = $tdata['default_price'][$i];
                        $tdata_loc['is_offer'] = $tdata['is_offer'][$i];
                        $tdata_loc['offer_price'] = $tdata['offer_price'][$i];
                        $tdata_loc['offer_date_type'] = $tdata['offer_date_type'][$i];
                        $tdata_loc['offer_days_of_month'] = $tdata['offer_days_of_month'][$i];
                        $tdata_loc['offer_days_of_week'] = $tdata['offer_days_of_week'][$i];
                        $tdata_loc['offer_single_date'] = $tdata['offer_single_date'][$i];
                        $tdata_loc['offer_start_date'] = $tdata['offer_start_date'][$i];
                        $tdata_loc['offer_end_date'] = $tdata['offer_end_date'][$i];
                        $tdata_loc['culoc_status'] = 1;
                        $tdata_loc['added_by_admin'] = $tdata['added_by_admin'];
                        $this->addCusineLocation($tdata_loc);
                    }
                }
                if (count($tdata['cucat_parent_cat_id']) > 0) {
                    for ($i = 0;$i < count($tdata['cucat_parent_cat_id']);$i++) {
                        $tdata_cat = array();
                        $tdata_cat['cusine_id'] = $cusine_id;
                        $tdata_cat['cucat_parent_cat_id'] = $tdata['cucat_parent_cat_id'][$i];
                        $tdata_cat['cucat_cat_id'] = $tdata['cucat_cat_id'][$i];
                        $tdata_cat['cucat_show'] = $tdata['cucat_show'][$i];
                        $tdata_cat['cucat_status'] = 1;
                        $tdata_cat['added_by_admin'] = $tdata['added_by_admin'];
                        $this->addCusineCategory($tdata_cat);
                    }
                }
                if (count($tdata['cw_qt_parent_cat_id']) > 0) {
                    for ($i = 0;$i < count($tdata['cw_qt_parent_cat_id']);$i++) {
                        if ($tdata['cw_qt_cat_id'][$i] != '' && $tdata['cw_qu_cat_id'][$i] != '' && $tdata['cw_quantity'][$i] != '') {
                            $tdata_cw = array();
                            $tdata_cw['cusine_id'] = $cusine_id;
                            $tdata_cw['cw_qt_parent_cat_id'] = $tdata['cw_qt_parent_cat_id'][$i];
                            $tdata_cw['cw_qt_cat_id'] = $tdata['cw_qt_cat_id'][$i];
                            $tdata_cw['cw_qu_parent_cat_id'] = $tdata['cw_qu_parent_cat_id'][$i];
                            $tdata_cw['cw_qu_cat_id'] = $tdata['cw_qu_cat_id'][$i];
                            $tdata_cw['cw_quantity'] = $tdata['cw_quantity'][$i];
                            $tdata_cw['cw_show'] = $tdata['cw_show'][$i];
                            $tdata_cw['cw_status'] = 1;
                            $tdata_cw['added_by_admin'] = $tdata['added_by_admin'];
                            $this->addCusineWeight($tdata_cw);
                        }
                    }
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[addCusine] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return $return;
        }
        return $return;
    }
    public function getCategoryListingOfCusine($cusine_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT TC1.cat_name AS parent_cat_name, TC2.cat_name AS main_cat_name FROM `tblcusinecategory` AS TIC 

					LEFT JOIN `tblcategories` AS TC1 ON TIC.cucat_parent_cat_id = TC1.cat_id 

					LEFT JOIN `tblcategories` AS TC2 ON TIC.cucat_cat_id = TC2.cat_id

					WHERE TIC.cusine_id = '" . $cusine_id . "' AND TIC.cucat_deleted = '0' ORDER BY TIC.cucat_add_date ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $output.= stripslashes($r['parent_cat_name']) . ' : ' . stripslashes($r['main_cat_name']) . ',<br>';
                }
                $output = substr($output, 0, -5);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCategoryListingOfCusine] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getCusineDetails($cusine_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcusines` WHERE `cusine_id` = '" . $cusine_id . "' AND `cusine_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getCusineAllCategory($cusine_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcusinecategory` WHERE `cusine_id` = '" . $cusine_id . "' AND `cucat_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_record[] = $r;
            }
        }
        return $arr_record;
    }
    public function getCusineAllWeight($cusine_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcusineweight` WHERE `cusine_id` = '" . $cusine_id . "' AND `cw_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_record[] = $r;
            }
        }
        return $arr_record;
    }
    public function getCusineAllLocation($cusine_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcusinelocations` WHERE `cusine_id` = '" . $cusine_id . "' AND `culoc_deleted` = '0' ORDER BY default_price DESC, culoc_add_date ASC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_record[] = $r;
            }
        }
        return $arr_record;
    }
    public function deleteCusine($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcusines` SET 

					`cusine_deleted` = :cusine_deleted,

					`cusine_modified_date` = :cusine_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `cusine_id` = :cusine_id AND `cusine_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cusine_deleted' => '1', ':cusine_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':cusine_id' => $tdata['cusine_id']));
            $DBH->commit();
            $return = true;
            $this->deleteCusineCategoryByCusineId($tdata);
            $this->deleteCusineLocationByCusineId($tdata);
            $this->deleteCusineWeightByCusineId($tdata);
        }
        catch(Exception $e) {
            $stringData = '[deleteCusine] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteCusineCategoryByCusineId($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcusinecategory` SET 

					`cucat_deleted` = :cucat_deleted,

					`cucat_modified_date` = :cucat_modified_date,

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `cusine_id` = :cusine_id AND `cucat_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cucat_deleted' => '1', ':cucat_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':cusine_id' => $tdata['cusine_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCusineCategoryByCusineId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteCusineWeightByCusineId($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcusineweight` SET 

					`cw_deleted` = :cw_deleted,

					`cw_modified_date` = :cw_modified_date,

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `cusine_id` = :cusine_id AND `cw_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cw_deleted' => '1', ':cw_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':cusine_id' => $tdata['cusine_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCusineWeightByCusineId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteCusineLocationByCusineId($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcusinelocations` SET 

					`culoc_deleted` = :culoc_deleted,

					`culoc_modified_date` = :culoc_modified_date,

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `cusine_id` = :cusine_id AND `culoc_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':culoc_deleted' => '1', ':culoc_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':cusine_id' => $tdata['cusine_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCusineLocationByCusineId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateCusine($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcusines` SET 

					`item_id` = :item_id,

					`cusine_type_parent_id` = :cusine_type_parent_id,

					`cusine_type_id` = :cusine_type_id,

					`min_cart_price` = :min_cart_price,

					`vendor_id` = :vendor_id,

					`vendor_show` = :vendor_show,

					`cusine_image` = :cusine_image,

					`cusine_country_id` = :cusine_country_id,

					`cusine_state_id` = :cusine_state_id,

					`cusine_city_id` = :cusine_city_id,

					`cusine_area_id` = :cusine_area_id,

					`publish_date_type` = :publish_date_type,

					`publish_days_of_month` = :publish_days_of_month,

					`publish_days_of_week` = :publish_days_of_week,

					`publish_single_date` = :publish_single_date,

					`publish_start_date` = :publish_start_date,

					`publish_end_date` = :publish_end_date,

					`delivery_date_type` = :delivery_date_type,

					`delivery_days_of_month` = :delivery_days_of_month,

					`delivery_days_of_week` = :delivery_days_of_week,

					`delivery_single_date` = :delivery_single_date,

					`delivery_start_date` = :delivery_start_date,

					`delivery_end_date` = :delivery_end_date,

					`cusine_desc_1` = :cusine_desc_1,

					`cusine_desc_show_1` = :cusine_desc_show_1,

					`cusine_desc_2` = :cusine_desc_2,

					`cusine_desc_show_2` = :cusine_desc_show_2,

                                        `cusine_status` = :cusine_status,

					`cusine_modified_date` = :cusine_modified_date,  

					`modified_by_admin` = :modified_by_admin,  

					`order_cutoff_time` = :order_cutoff_time,  

					`delivery_time` = :delivery_time,  

					`delivery_time_show` = :delivery_time_show,  

					`delivery_date_show` = :delivery_date_show,  

					`cancel_cutoff_time` = :cancel_cutoff_time,  

					`cancel_cutoff_time_show` = :cancel_cutoff_time_show,

					`cgst_tax` = :cgst_tax, 

					`sgst_tax` = :sgst_tax,  

					`cess_tax` = :cess_tax,  

					`gst_tax` = :gst_tax  	

					WHERE `cusine_id` = :cusine_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':item_id' => addslashes($tdata['item_id']), ':cusine_type_parent_id' => addslashes($tdata['cusine_type_parent_id']), ':cusine_type_id' => addslashes($tdata['cusine_type_id']), ':min_cart_price' => addslashes($tdata['min_cart_price']), ':vendor_id' => addslashes($tdata['vendor_id']), ':vendor_show' => addslashes($tdata['vendor_show']), ':cusine_image' => addslashes($tdata['cusine_image']), ':cusine_country_id' => addslashes($tdata['cusine_country_id']), ':cusine_state_id' => addslashes($tdata['cusine_state_id']), ':cusine_city_id' => addslashes($tdata['cusine_city_id']), ':cusine_area_id' => addslashes($tdata['cusine_area_id']), ':publish_date_type' => addslashes($tdata['publish_date_type']), ':publish_days_of_month' => addslashes($tdata['publish_days_of_month']), ':publish_days_of_week' => addslashes($tdata['publish_days_of_week']), ':publish_single_date' => addslashes($tdata['publish_single_date']), ':publish_start_date' => addslashes($tdata['publish_start_date']), ':publish_end_date' => addslashes($tdata['publish_end_date']), ':delivery_date_type' => addslashes($tdata['delivery_date_type']), ':delivery_days_of_month' => addslashes($tdata['delivery_days_of_month']), ':delivery_days_of_week' => addslashes($tdata['delivery_days_of_week']), ':delivery_single_date' => addslashes($tdata['delivery_single_date']), ':delivery_start_date' => addslashes($tdata['delivery_start_date']), ':delivery_end_date' => addslashes($tdata['delivery_end_date']), ':cusine_desc_1' => addslashes($tdata['cusine_desc_1']), ':cusine_desc_show_1' => addslashes($tdata['cusine_desc_show_1']), ':cusine_desc_2' => addslashes($tdata['cusine_desc_2']), ':cusine_desc_show_2' => addslashes($tdata['cusine_desc_show_2']), ':cusine_status' => addslashes($tdata['cusine_status']), ':cusine_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':order_cutoff_time' => $tdata['order_cutoff_time'], ':delivery_time' => $tdata['delivery_time'], ':delivery_time_show' => $tdata['delivery_time_show'], ':delivery_date_show' => $tdata['delivery_date_show'], ':cancel_cutoff_time' => $tdata['cancel_cutoff_time'], ':cancel_cutoff_time_show' => $tdata['cancel_cutoff_time_show'], ':cgst_tax' => addslashes($tdata['cgst_tax']), ':sgst_tax' => addslashes($tdata['sgst_tax']), ':cess_tax' => addslashes($tdata['cess_tax']), ':gst_tax' => addslashes($tdata['gst_tax']), ':cusine_id' => $tdata['cusine_id']));
            $DBH->commit();
            $return = true;
            $tdata_del_cat = array();
            $tdata_del_cat['cusine_id'] = $tdata['cusine_id'];
            $tdata_del_cat['deleted_by_admin'] = $tdata['modified_by_admin'];
            $this->deleteCusineCategoryByCusineId($tdata_del_cat);
            if (count($tdata['cucat_parent_cat_id']) > 0) {
                for ($i = 0;$i < count($tdata['cucat_parent_cat_id']);$i++) {
                    $tdata_cat = array();
                    $tdata_cat['cusine_id'] = $tdata['cusine_id'];
                    $tdata_cat['cucat_parent_cat_id'] = $tdata['cucat_parent_cat_id'][$i];
                    $tdata_cat['cucat_cat_id'] = $tdata['cucat_cat_id'][$i];
                    $tdata_cat['cucat_show'] = $tdata['cucat_show'][$i];
                    $tdata_cat['cucat_status'] = 1;
                    $tdata_cat['added_by_admin'] = $tdata['modified_by_admin'];
                    $this->addCusineCategory($tdata_cat);
                }
            }
            $tdata_del_cw = array();
            $tdata_del_cw['cusine_id'] = $tdata['cusine_id'];
            $tdata_del_cw['deleted_by_admin'] = $tdata['modified_by_admin'];
            $this->deleteCusineWeightByCusineId($tdata_del_cw);
            if (count($tdata['cw_qt_parent_cat_id']) > 0) {
                for ($i = 0;$i < count($tdata['cw_qt_parent_cat_id']);$i++) {
                    if ($tdata['cw_qt_cat_id'][$i] != '' && $tdata['cw_qu_cat_id'][$i] != '' && $tdata['cw_quantity'][$i] != '') {
                        $tdata_cw = array();
                        $tdata_cw['cusine_id'] = $tdata['cusine_id'];
                        $tdata_cw['cw_qt_parent_cat_id'] = $tdata['cw_qt_parent_cat_id'][$i];
                        $tdata_cw['cw_qt_cat_id'] = $tdata['cw_qt_cat_id'][$i];
                        $tdata_cw['cw_qu_parent_cat_id'] = $tdata['cw_qu_parent_cat_id'][$i];
                        $tdata_cw['cw_qu_cat_id'] = $tdata['cw_qu_cat_id'][$i];
                        $tdata_cw['cw_quantity'] = $tdata['cw_quantity'][$i];
                        $tdata_cw['cw_show'] = $tdata['cw_show'][$i];
                        $tdata_cw['cw_status'] = 1;
                        $tdata_cw['added_by_admin'] = $tdata['modified_by_admin'];
                        $this->addCusineWeight($tdata_cw);
                    }
                }
            }
            $tdata_del_loc = array();
            $tdata_del_loc['cusine_id'] = $tdata['cusine_id'];
            $tdata_del_loc['deleted_by_admin'] = $tdata['modified_by_admin'];
            $this->deleteCusineLocationByCusineId($tdata_del_loc);
            for ($i = 0;$i < count($tdata['vloc_id']);$i++) {
                $tdata_loc = array();
                $tdata_loc['cusine_id'] = $tdata['cusine_id'];
                $tdata_loc['vendor_id'] = $tdata['vendor_id'];
                $tdata_loc['vloc_id'] = $tdata['vloc_id'][$i];
                $tdata_loc['ordering_type_id'] = $tdata['ordering_type_id'][$i];
                $tdata_loc['ordering_size_id'] = $tdata['ordering_size_id'][$i];
                $tdata_loc['ordering_size_show'] = $tdata['ordering_size_show'][$i];
                $tdata_loc['max_order'] = $tdata['max_order'][$i];
                $tdata_loc['min_order'] = $tdata['min_order'][$i];
                $tdata_loc['cusine_qty'] = $tdata['cusine_qty'][$i];
                $tdata_loc['cusine_qty_show'] = $tdata['cusine_qty_show'][$i];
                $tdata_loc['sold_qty_show'] = $tdata['sold_qty_show'][$i];
                $tdata_loc['currency_id'] = $tdata['currency_id'][$i];
                $tdata_loc['cusine_price'] = $tdata['cusine_price'][$i];
                $tdata_loc['default_price'] = $tdata['default_price'][$i];
                $tdata_loc['is_offer'] = $tdata['is_offer'][$i];
                $tdata_loc['offer_price'] = $tdata['offer_price'][$i];
                $tdata_loc['offer_date_type'] = $tdata['offer_date_type'][$i];
                $tdata_loc['offer_days_of_month'] = $tdata['offer_days_of_month'][$i];
                $tdata_loc['offer_days_of_week'] = $tdata['offer_days_of_week'][$i];
                $tdata_loc['offer_single_date'] = $tdata['offer_single_date'][$i];
                $tdata_loc['offer_start_date'] = $tdata['offer_start_date'][$i];
                $tdata_loc['offer_end_date'] = $tdata['offer_end_date'][$i];
                $tdata_loc['culoc_status'] = 1;
                $tdata_loc['added_by_admin'] = $tdata['modified_by_admin'];
                $this->addCusineLocation($tdata_loc);
            }
        }
        catch(Exception $e) {
            $stringData = '[updateCusine] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getCurrencyOption($currency_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Currency</option>';
        } else {
            $output.= '<option value="" >Select Currency</option>';
        }
        try {
            $sql = "SELECT currency_id, currency FROM `tblcurrencies` WHERE `currency_deleted` = '0' ORDER BY currency ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['currency_id'] == $currency_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['currency_id'] . '" ' . $selected . '>' . stripslashes($r['currency']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getCurrencyOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    //Manage Cusines - End
    //Manage Vendors - Start
    public function getPersonTitleOption($person_title, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $person_title)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                $selected = '';
            }
            $output.= '<option value="-1" ' . $selected . ' >All Gender</option>';
        } else {
            $output.= '<option value="" >Select Gender</option>';
        }
        $arr_record = array("Female" => "Female", "Male" => "Male");
        foreach ($arr_record as $key => $val) {
            if ($multiple == '1') {
                if (in_array($key, $person_title)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ($key == $person_title) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
        }
        return $output;
    }
    public function getCertficationTypeOption($vc_cert_type_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Type</option>';
        } else {
            $output.= '<option value="" >Select Type</option>';
        }
        try {
            $sql = "SELECT cat_id as vc_cert_type_id, cat_name as vc_cert_type FROM `tblcategories` WHERE `parent_cat_id` = '71' AND `cat_deleted` = '0' ORDER BY vc_cert_type ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['vc_cert_type_id'] == $vc_cert_type_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['vc_cert_type_id'] . '" ' . $selected . '>' . stripslashes($r['vc_cert_type']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getCertficationTypeOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getAllVendors($txtsearch = '', $status = '', $vendor_parent_cat_id = '', $vendor_cat_id = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $item_id = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $vc_vendor_id = $this->getVendorIdFromVendorCode($txtsearch);
            if ($vc_vendor_id != '') {
                $sql_search_str = " AND ( TVR.vendor_name LIKE '%" . $txtsearch . "%' OR TVR.vendor_id = '" . $vc_vendor_id . "' )";
            } else {
                $sql_search_str = " AND TVR.vendor_name LIKE '%" . $txtsearch . "%' ";
            }
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TVR.vendor_status = '" . $status . "' ";
        }
        $sql_vendor_parent_cat_id_str = "";
        if ($vendor_parent_cat_id != '') {
            $sql_vendor_parent_cat_id_str = " AND TVR.vendor_parent_cat_id = '" . $vendor_parent_cat_id . "' ";
        }
        $sql_vendor_cat_id_str = "";
        if ($vendor_cat_id != '') {
            $sql_vendor_cat_id_str = " AND TVR.vendor_cat_id = '" . $vendor_cat_id . "' ";
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND TVL.country_id = '" . $country_id . "' ";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND TVL.state_id = '" . $state_id . "' ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND TVL.city_id = '" . $city_id . "' ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND TVL.area_id = '" . $area_id . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND TVR.added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(TVR.vendor_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(TVR.vendor_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TVR.vendor_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TVR.vendor_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(TVR.vendor_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_item_id_str = "";
        if ($item_id != '') {
            $item_str = $item_id;
            $sql_item_id_str = " AND ( TVR.vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblvendorlocations` WHERE vloc_deleted = 0 AND FIND_IN_SET(" . $item_str . ",vloc_speciality_offered) > 0 ) OR TVR.vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblcusines` WHERE cusine_deleted = 0 AND item_id IN(" . $item_str . ") > 0 ) )";
        }
        $sql = "SELECT TVR.*, TBC1.cat_id AS main_profile_id, TBC1.cat_name AS main_profile, TBC2.cat_id AS category_id, TBC2.cat_name AS category_name,

				TVL.country_id,TVL.state_id,TVL.city_id,TVL.area_id,

				(SELECT country_name FROM `tblcountry` WHERE `country_id` = TVL.country_id ) AS country_name,

				(SELECT state_name FROM `tblstates` WHERE `state_id` = TVL.state_id ) AS state_name,

				(SELECT city_name FROM `tblcities` WHERE `city_id` = TVL.city_id ) AS city_name,

				(SELECT area_name FROM `tblarea` WHERE `area_id` = TVL.area_id ) AS area_name 

				FROM `tblvendors` AS TVR 

				LEFT JOIN `tblcategories` AS TBC1 ON TVR.vendor_parent_cat_id = TBC1.cat_id   

				LEFT JOIN `tblcategories` AS TBC2 ON TVR.vendor_cat_id = TBC2.cat_id   

				LEFT JOIN `tblvendorlocations` AS TVL ON TVR.vendor_id = TVL.vendor_id   

				WHERE TVR.vendor_deleted = '0' AND TVL.vloc_default = '1' AND TVL.vloc_deleted = '0' 

				" . $sql_search_str . " " . $sql_status_str . " " . $sql_vendor_parent_cat_id_str . " " . $sql_vendor_cat_id_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . " " . $sql_item_id_str . "    

				ORDER BY TVR.vendor_add_date DESC";
        $this->debuglog('[getAllVendors] sql:' . $sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function chkVendorNameExists($vendor_name) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_name` = '" . addslashes($vendor_name) . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkVendorNameExists_edit($vendor_name, $vendor_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_name` = '" . addslashes($vendor_name) . "' AND `vendor_id` != '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkVendorUsernameExists($vendor_username) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '" . addslashes($vendor_username) . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkVendorUsernameExists_edit($vendor_username, $vendor_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '" . addslashes($vendor_username) . "' AND `vendor_id` != '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkVendorEmailExists($vendor_email) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '" . addslashes($vendor_email) . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //add by ample 14-07-20
    public function chkVendorMobileExists($vendor_mobile) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_mobile` = '" . addslashes($vendor_mobile) . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkVendorEmailExists_edit($vendor_email, $vendor_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '" . addslashes($vendor_email) . "' AND `vendor_id` != '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function addVendorLocation($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
        try {
            $sql = "INSERT INTO `tblvendorlocations` (`vendor_id`,`contact_person`,`contact_person_title`,`contact_email`,`contact_designation`,`contact_number`,`contact_remark`,`country_id`,`state_id`,`city_id`,`area_id`,`vloc_parent_cat_id`,`vloc_cat_id`,`vloc_speciality_offered`,`vloc_doc_file`,`vloc_menu_file`,`vloc_default`,`vloc_status`,`added_by_admin`,`vloc_add_date`) 

					VALUES (:vendor_id,:contact_person,:contact_person_title,:contact_email,:contact_designation,:contact_number,:contact_remark,:country_id,:state_id,:city_id,:area_id,:vloc_parent_cat_id,:vloc_cat_id,:vloc_speciality_offered,:vloc_doc_file,:vloc_menu_file,:vloc_default,:vloc_status,:added_by_admin,:vloc_add_date)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vendor_id' => $tdata['vendor_id'], ':contact_person' => addslashes($tdata['contact_person']), ':contact_person_title' => addslashes($tdata['contact_person_title']), ':contact_email' => addslashes($tdata['contact_email']), ':contact_designation' => addslashes($tdata['contact_designation']), ':contact_number' => addslashes($tdata['contact_number']), ':contact_remark' => addslashes($tdata['contact_remark']), ':country_id' => addslashes($tdata['country_id']), ':state_id' => addslashes($tdata['state_id']), ':city_id' => addslashes($tdata['city_id']), ':area_id' => addslashes($tdata['area_id']), ':vloc_parent_cat_id' => addslashes($tdata['vloc_parent_cat_id']), ':vloc_cat_id' => addslashes($tdata['vloc_cat_id']), ':vloc_speciality_offered' => addslashes($tdata['vloc_speciality_offered']), ':vloc_doc_file' => addslashes($tdata['vloc_doc_file']), ':vloc_menu_file' => addslashes($tdata['vloc_menu_file']), ':vloc_default' => addslashes($tdata['vloc_default']), ':vloc_status' => '1', ':added_by_admin' => $tdata['admin_id'], ':vloc_add_date' => date('Y-m-d H:i:s')));
            $return = $DBH->lastInsertId();
            $DBH->commit();
        }
        catch(Exception $e) {
            $stringData = '[addVendorLocation] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
    public function addVendorCerification($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
        try {
            $sql = "INSERT INTO `tblvendorcertifications` (`vendor_id`,`vloc_id`,`vc_cert_type_id`,`vc_cert_name`,`vc_cert_no`,`vc_cert_reg_date`,`vc_cert_validity_date`,`vc_cert_issued_by`,`vc_cert_scan_file`,`vc_cert_status`,`added_by_admin`,`vc_cert_add_date`) 

					VALUES (:vendor_id,:vloc_id,:vc_cert_type_id,:vc_cert_name,:vc_cert_no,:vc_cert_reg_date,:vc_cert_validity_date,:vc_cert_issued_by,:vc_cert_scan_file,:vc_cert_status,:added_by_admin,:vc_cert_add_date)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vendor_id' => $tdata['vendor_id'], ':vloc_id' => addslashes($tdata['vloc_id']), ':vc_cert_type_id' => addslashes($tdata['vc_cert_type_id']), ':vc_cert_name' => addslashes($tdata['vc_cert_name']), ':vc_cert_no' => addslashes($tdata['vc_cert_no']), ':vc_cert_reg_date' => addslashes($tdata['vc_cert_reg_date']), ':vc_cert_validity_date' => addslashes($tdata['vc_cert_validity_date']), ':vc_cert_issued_by' => addslashes($tdata['vc_cert_issued_by']), ':vc_cert_scan_file' => addslashes($tdata['vc_cert_scan_file']), ':vc_cert_status' => $tdata['vc_cert_status'], ':added_by_admin' => $tdata['admin_id'], ':vc_cert_add_date' => date('Y-m-d H:i:s')));
            $return = $DBH->lastInsertId();
            $DBH->commit();
        }
        catch(Exception $e) {
            $stringData = '[addVendorCerification] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
    public function addVendor($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
        $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string_shuffled = str_shuffle($string);
        $otp = substr($string_shuffled, 1, 6);
        try {
            $sql = "INSERT INTO `tblvendors` (`vendor_mobile`,`vendor_username`,`vendor_password`,`vendor_email`,`vendor_name`,`vendor_parent_cat_id`,`vendor_cat_id`,`vendor_status`,`vendor_add_date`,`added_by_admin`,`va_id`,`new_vendor`,`vendor_otp`,`food_products_offered`,`reference_id`) 

					VALUES (:vendor_mobile,:vendor_username,:vendor_password,:vendor_email,:vendor_name,:vendor_parent_cat_id,:vendor_cat_id,:vendor_status,:vendor_add_date,:added_by_admin,:va_id,:new_vendor,:vendor_otp,:food_products_offered,:reference_id)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vendor_username' => addslashes($tdata['vendor_username']), ':vendor_password' => md5($tdata['vendor_password']), ':vendor_email' => addslashes($tdata['vendor_email']), ':vendor_name' => addslashes($tdata['vendor_name']), ':vendor_parent_cat_id' => addslashes($tdata['vendor_parent_cat_id']), ':vendor_cat_id' => addslashes($tdata['vendor_cat_id']), ':vendor_status' => addslashes($tdata['vendor_status']), ':vendor_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['admin_id'], ':va_id' => $tdata['va_id'], ':new_vendor' => $tdata['new_vendor'], ':vendor_otp' => $otp, ':vendor_mobile' => $tdata['vendor_mobile'],':food_products_offered' => $tdata['food_products_offered'],':reference_id' => $tdata['reference_id']));
            $vendor_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($vendor_id > 0) {
                $return = $vendor_id;
                if (count($tdata['vloc_parent_cat_id']) > 0) {
                    for ($i = 0;$i < count($tdata['vloc_parent_cat_id']);$i++) {
                        $tdata_vloc = array();
                        $tdata_vloc['vendor_id'] = $vendor_id;
                        $tdata_vloc['contact_person'] = $tdata['contact_person'][$i];
                        $tdata_vloc['contact_person_title'] = $tdata['contact_person_title'][$i];
                        $tdata_vloc['contact_email'] = $tdata['contact_email'][$i];
                        $tdata_vloc['contact_designation'] = $tdata['contact_designation'][$i];
                        $tdata_vloc['contact_number'] = $tdata['contact_number'][$i];
                        $tdata_vloc['contact_remark'] = $tdata['contact_remark'][$i];
                        $tdata_vloc['country_id'] = $tdata['country_id'][$i];
                        $tdata_vloc['state_id'] = $tdata['state_id'][$i];
                        $tdata_vloc['city_id'] = $tdata['city_id'][$i];
                        $tdata_vloc['area_id'] = $tdata['area_id'][$i];
                        $tdata_vloc['vloc_parent_cat_id'] = $tdata['vloc_parent_cat_id'][$i];
                        $tdata_vloc['vloc_cat_id'] = $tdata['vloc_cat_id'][$i];
                        $tdata_vloc['vloc_speciality_offered'] = $tdata['vloc_speciality_offered'][$i];
                        $tdata_vloc['vloc_doc_file'] = $tdata['vloc_doc_file'][$i];
                        $tdata_vloc['vloc_menu_file'] = $tdata['vloc_menu_file'][$i];
                        if ($i == 0) {
                            $tdata_vloc['vloc_default'] = 1;
                        } else {
                            $tdata_vloc['vloc_default'] = 0;
                        }
                        $tdata_vloc['vloc_status'] = 1;
                        $tdata_vloc['admin_id'] = $tdata['admin_id'];
                        $vloc_id = $this->addVendorLocation($tdata_vloc);
                        if ($vloc_id > 0) {
                            for ($k = 0;$k < count($tdata['vc_cert_type_id'][$i]);$k++) {
                                $tdata_vc = array();
                                $tdata_vc['vendor_id'] = $vendor_id;
                                $tdata_vc['vloc_id'] = $vloc_id;
                                $tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];
                                $tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];
                                $tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];
                                $tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];
                                $tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
                                $tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];
                                $tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];
                                $tdata_vc['vc_cert_status'] = 1;
                                $tdata_vc['admin_id'] = $tdata['admin_id'];
                                $vc_cert_id = $this->addVendorCerification($tdata_vc);
                            }
                        }
                    }
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[addVendor] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getVendorSpecialityOfferedOption($vloc_speciality_offered, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $vloc_speciality_offered)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                $selected = '';
            }
            $output.= '<option value="-1" ' . $selected . ' >All Speciality</option>';
        } else {
            $output.= '<option value="" >Select Speciality</option>';
        }
        try {
            $sql = "SELECT item_id,item_name FROM `tblitems` WHERE item_deleted = '0' ORDER BY item_name ASC ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($multiple == '1') {
                        if (in_array($r['item_id'], $vloc_speciality_offered)) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    } else {
                        if ($r['item_id'] == $vloc_speciality_offered) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    }
                    $output.= '<option value="' . $r['item_id'] . '" ' . $selected . '>' . stripslashes($r['item_name']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getVendorSpecialityOfferedOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getVendorDetails($vendor_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getVendorName($vendor_id) {
        $DBH = new DatabaseHandler();
        $vendor_name = '';
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vendor_name = stripslashes($r['vendor_name']);
        }
        return $vendor_name;
    }
    public function getVendorAllLocationsAndCertifications($vendor_id,$location_id="") {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $str_vloc_id='';
        if($location_id)
        {
            $str_vloc_id=' AND `vloc_id`='.$location_id;
        }
        $sql = "SELECT * FROM `tblvendorlocations` WHERE `vendor_id` = '" . $vendor_id . "' ".$str_vloc_id." AND `vloc_deleted` = '0' ORDER BY vloc_default DESC, vloc_add_date ASC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $r['certificate'] = array();
                $sql2 = "SELECT * FROM `tblvendorcertifications` WHERE `vendor_id` = '" . $vendor_id . "' AND `vloc_id` = '" . $r['vloc_id'] . "' AND `vc_cert_deleted` = '0' ORDER BY vc_cert_add_date ASC ";
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    while ($r2 = $STH2->fetch(PDO::FETCH_ASSOC)) {
                        $r['certificate'][] = $r2;
                    }
                }
                $arr_record[] = $r;
            }
        }
        return $arr_record;
    }
    public function updateVendorLocation($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblvendorlocations` SET 

					`contact_person` = :contact_person,

					`contact_person_title` = :contact_person_title,

					`contact_email` = :contact_email,

					`contact_designation` = :contact_designation,

					`contact_number` = :contact_number,

					`contact_remark` = :contact_remark,

					`country_id` = :country_id,

					`state_id` = :state_id,

					`city_id` = :city_id,

					`area_id` = :area_id,

					`vloc_parent_cat_id` = :vloc_parent_cat_id,

					`vloc_cat_id` = :vloc_cat_id,

					`vloc_speciality_offered` = :vloc_speciality_offered,

					`vloc_doc_file` = :vloc_doc_file,

					`vloc_menu_file` = :vloc_menu_file,

					`vloc_default` = :vloc_default,

					`vloc_status` = :vloc_status,

					`modified_by_admin` = :modified_by_admin,

					`vloc_modified_date` = :vloc_modified_date 

					WHERE `vloc_id` = :vloc_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':contact_person' => addslashes($tdata['contact_person']), ':contact_person_title' => addslashes($tdata['contact_person_title']), ':contact_email' => addslashes($tdata['contact_email']), ':contact_designation' => addslashes($tdata['contact_designation']), ':contact_number' => addslashes($tdata['contact_number']), ':contact_remark' => addslashes($tdata['contact_remark']), ':country_id' => addslashes($tdata['country_id']), ':state_id' => addslashes($tdata['state_id']), ':city_id' => addslashes($tdata['city_id']), ':area_id' => addslashes($tdata['area_id']), ':vloc_parent_cat_id' => addslashes($tdata['vloc_parent_cat_id']), ':vloc_cat_id' => addslashes($tdata['vloc_cat_id']), ':vloc_speciality_offered' => addslashes($tdata['vloc_speciality_offered']), ':vloc_doc_file' => addslashes($tdata['vloc_doc_file']), ':vloc_menu_file' => addslashes($tdata['vloc_menu_file']), ':vloc_default' => addslashes($tdata['vloc_default']), ':vloc_status' => '1', ':modified_by_admin' => $tdata['admin_id'], ':vloc_modified_date' => date('Y-m-d H:i:s'), ':vloc_id' => $tdata['vloc_id']));
            $return = true;
            $DBH->commit();
        }
        catch(Exception $e) {
            $stringData = '[updateVendorLocation] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateVendorCerification($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = true;
        try {
            $sql = "UPDATE `tblvendorcertifications` SET 

					`vc_cert_type_id` = :vc_cert_type_id,

					`vc_cert_name` = :vc_cert_name,

					`vc_cert_no` = :vc_cert_no,

					`vc_cert_reg_date` = :vc_cert_reg_date,

					`vc_cert_validity_date` = :vc_cert_validity_date,

					`vc_cert_issued_by` = :vc_cert_issued_by,

					`vc_cert_scan_file` = :vc_cert_scan_file,

					`vc_cert_status` = :vc_cert_status,

					`modified_by_admin` = :modified_by_admin,

					`vc_cert_modified_date` = :vc_cert_modified_date 

					 WHERE `vc_cert_id` = :vc_cert_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vc_cert_type_id' => addslashes($tdata['vc_cert_type_id']), ':vc_cert_name' => addslashes($tdata['vc_cert_name']), ':vc_cert_no' => addslashes($tdata['vc_cert_no']), ':vc_cert_reg_date' => addslashes($tdata['vc_cert_reg_date']), ':vc_cert_validity_date' => addslashes($tdata['vc_cert_validity_date']), ':vc_cert_issued_by' => addslashes($tdata['vc_cert_issued_by']), ':vc_cert_scan_file' => addslashes($tdata['vc_cert_scan_file']), ':vc_cert_status' => $tdata['vc_cert_status'], ':modified_by_admin' => $tdata['admin_id'], ':vc_cert_modified_date' => date('Y-m-d H:i:s'), ':vc_cert_id' => $tdata['vc_cert_id']));
            $return = true;
            $DBH->commit();
        }
        catch(Exception $e) {
            $stringData = '[updateVendorCerification] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateVendor($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        try {
            //update by ample 03-09-20
            $sql = "UPDATE `tblvendors` SET 

					`vendor_username` = :vendor_username,

					`vendor_email` = :vendor_email,

					`vendor_name` = :vendor_name,

					`vendor_parent_cat_id` = :vendor_parent_cat_id,

					`vendor_cat_id` = :vendor_cat_id,

					`vendor_status` = :vendor_status,

					`vendor_modified_date` = :vendor_modified_date,

					`modified_by_admin` = :modified_by_admin,

                    `food_products_offered` = :food_products_offered 

					WHERE `vendor_id` = :vendor_id";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vendor_username' => addslashes($tdata['vendor_username']), ':vendor_email' => addslashes($tdata['vendor_email']), ':vendor_name' => addslashes($tdata['vendor_name']), ':vendor_parent_cat_id' => addslashes($tdata['vendor_parent_cat_id']), ':vendor_cat_id' => addslashes($tdata['vendor_cat_id']), ':vendor_status' => addslashes($tdata['vendor_status']), ':vendor_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['admin_id'], ':food_products_offered' => addslashes($tdata['food_products_offered']), ':vendor_id' => $tdata['vendor_id'],));



            $vendor_id = $tdata['vendor_id'];
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateVendor] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //add by ample 12-09-20
    public function VendorLocationContacts($tdata) 
    {   


        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $vendor_id = $tdata['vendor_id'];
          
            if (count($tdata['vloc_parent_cat_id']) > 0) 
            {
         
                for ($i = 0;$i < count($tdata['vloc_parent_cat_id']);$i++) 
                {
                    $tdata_vloc = array();
                    $tdata_vloc['vendor_id'] = $vendor_id;
                    $tdata_vloc['contact_person'] = $tdata['contact_person'][$i];
                    $tdata_vloc['contact_person_title'] = $tdata['contact_person_title'][$i];
                    $tdata_vloc['contact_email'] = $tdata['contact_email'][$i];
                    $tdata_vloc['contact_designation'] = $tdata['contact_designation'][$i];
                    $tdata_vloc['contact_number'] = $tdata['contact_number'][$i];
                    $tdata_vloc['contact_remark'] = $tdata['contact_remark'][$i];
                    $tdata_vloc['country_id'] = $tdata['country_id'][$i];
                    $tdata_vloc['state_id'] = $tdata['state_id'][$i];
                    $tdata_vloc['city_id'] = $this->getCityIdbyName($tdata['city_id'][$i]);
                    $tdata_vloc['area_id'] = $tdata['area_id'][$i];
                    $tdata_vloc['vloc_parent_cat_id'] = $tdata['vloc_parent_cat_id'][$i];
                    $tdata_vloc['vloc_cat_id'] = $tdata['vloc_cat_id'][$i];
                    $tdata_vloc['vloc_speciality_offered'] = $tdata['vloc_speciality_offered'][$i];
                    $tdata_vloc['vloc_doc_file'] = $tdata['vloc_doc_file'][$i];
                    $tdata_vloc['vloc_menu_file'] = $tdata['vloc_menu_file'][$i];
                    if ($i == 0) {
                        $tdata_vloc['vloc_default'] = 1;
                    } else {
                        $tdata_vloc['vloc_default'] = 0;
                    }
                    $tdata_vloc['vloc_status'] = 1;
                    $tdata_vloc['admin_id'] = $tdata['admin_id'];
                    $tdata_vloc['vloc_id'] = $tdata['vloc_id'][$i];
                    if ($tdata_vloc['vloc_id'] > 0) {
                        if ($this->updateVendorLocation($tdata_vloc)) {
                            $return = true;
                            $vloc_id = $tdata_vloc['vloc_id'];
                            for ($k = 0;$k < count($tdata['vc_cert_type_id'][$i]);$k++) {
                                $tdata_vc = array();
                                $tdata_vc['vendor_id'] = $vendor_id;
                                $tdata_vc['vloc_id'] = $vloc_id;
                                $tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];
                                $tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];
                                $tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];
                                $tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];
                                $tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
                                $tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];
                                $tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];
                                $tdata_vc['vc_cert_status'] = 1;
                                $tdata_vc['admin_id'] = $tdata['admin_id'];
                                $tdata_vc['vc_cert_id'] = $tdata['vc_cert_id'][$i][$k];
                                if ($tdata_vc['vc_cert_id'] > 0) {
                                    $vc_cert_id = $this->updateVendorCerification($tdata_vc);
                                } else {
                                    $vc_cert_id = $this->addVendorCerification($tdata_vc);
                                }
                            }
                        }
                    } else {
                        $vloc_id = $this->addVendorLocation($tdata_vloc);
                        if ($vloc_id > 0) {
                            $return = true;
                            for ($k = 0;$k < count($tdata['vc_cert_type_id'][$i]);$k++) {
                                $tdata_vc = array();
                                $tdata_vc['vendor_id'] = $vendor_id;
                                $tdata_vc['vloc_id'] = $vloc_id;
                                $tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];
                                $tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];
                                $tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];
                                $tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];
                                $tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
                                $tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];
                                $tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];
                                $tdata_vc['vc_cert_status'] = 1;
                                $tdata_vc['admin_id'] = $tdata['admin_id'];
                                $vc_cert_id = $this->addVendorCerification($tdata_vc);
                            }
                        }
                    }
                }
            }
        

        return $return;
    }

    public function deleteRemovedVendorLocationRows($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        if (is_array($tdata['vloc_id']) && count($tdata['vloc_id']) > 0) {
            $str_vloc_id = implode(',', $tdata['vloc_id']);
        } else {
            return $return;
        }
        try {
            $sql = "UPDATE `tblvendorlocations` SET 

					`vloc_deleted` = :vloc_deleted,

					`vloc_modified_date` = :vloc_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `vendor_id` = :vendor_id AND `vloc_id` NOT IN (" . $str_vloc_id . ") AND `vloc_deleted` != '1'  ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vloc_deleted' => '1', ':vloc_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['admin_id'], ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteRemovedVendorLocationRows] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteRemovedVendorCertificationRows($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $str_vc_cert_id = '';
        if (is_array($tdata['vc_cert_id']) && count($tdata['vc_cert_id']) > 0) {
            foreach ($tdata['vc_cert_id'] as $key => $val) {
                if (is_array($val) && count($val) > 0) {
                    $temp_str_vc_cert_id = implode(',', $val);
                    $str_vc_cert_id.= $temp_str_vc_cert_id . ',';
                }
            }
            $str_vc_cert_id = substr($str_vc_cert_id, 0, -1);
        } else {
            return $return;
        }
        if ($str_vc_cert_id == '') {
            return $return;
        }
        try {
            $sql = "UPDATE `tblvendorcertifications` SET 

					`vc_cert_deleted` = :vc_cert_deleted,

					`vc_cert_modified_date` = :vc_cert_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `vendor_id` = :vendor_id AND `vc_cert_id` NOT IN (" . $str_vc_cert_id . ") AND `vc_cert_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vc_cert_deleted' => '1', ':vc_cert_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['admin_id'], ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteRemovedVendorCertificationRows] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteVendor($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblvendors` SET 

					`vendor_deleted` = :vendor_deleted,

					`vendor_modified_date` = :vendor_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `vendor_id` = :vendor_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vendor_deleted' => '1', ':vendor_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['admin_id'], ':vendor_id' => $tdata['vendor_id']));
            $sql2 = "UPDATE `tblvendorlocations` SET 

					`vloc_deleted` = :vloc_deleted,

					`vloc_modified_date` = :vloc_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `vendor_id` = :vendor_id  AND `vloc_deleted` != '1' ";
            $STH2 = $DBH->prepare($sql2);
            $STH2->execute(array(':vloc_deleted' => '1', ':vloc_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['admin_id'], ':vendor_id' => $tdata['vendor_id']));
            $sql3 = "UPDATE `tblvendorcertifications` SET 

					`vc_cert_deleted` = :vc_cert_deleted,

					`vc_cert_modified_date` = :vc_cert_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `vendor_id` = :vendor_id  AND `vc_cert_deleted` != '1' ";
            $STH3 = $DBH->prepare($sql3);
            $STH3->execute(array(':vc_cert_deleted' => '1', ':vc_cert_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['admin_id'], ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteVendor] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getContactDesignationOption($contact_designation, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Designation</option>';
        } else {
            $output.= '<option value="" >Select Designation</option>';
        }
        try {
            $sql = "SELECT cat_id as contact_designation, cat_name as contact_designation_name FROM `tblcategories` WHERE `parent_cat_id` = '8' AND `cat_deleted` = '0' ORDER BY contact_designation_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['contact_designation'] == $contact_designation) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['contact_designation'] . '" ' . $selected . '>' . stripslashes($r['contact_designation_name']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getContactDesignationOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    //Manage Vendors - End
    public function getAdminsOption($admin_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Admins</option>';
        } else {
            $output.= '<option value="" >Select Admin</option>';
        }
        try {
            $sql = "SELECT admin_id,username FROM `tbladmin` WHERE `deleted` = '0' ORDER BY username ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['admin_id'] == $admin_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['admin_id'] . '" ' . $selected . '>' . stripslashes($r['username']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getAdminsOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getCutOffTimeOption($order_cutoff_time, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $order_cutoff_time)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                $selected = '';
            }
            $output.= '<option value="-1" ' . $selected . ' >All</option>';
        } else {
            $output.= '<option value="" >Select Hrs</option>';
        }
        for ($i = 1;$i <= 72;$i++) {
            if ($multiple == '1') {
                if (in_array($i, $order_cutoff_time)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ($i == $order_cutoff_time) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
        }
        return $output;
    }
    public function getCancellationCutOffTimeOption($order_cutoff_time, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $order_cutoff_time)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                $selected = '';
            }
            $output.= '<option value="-1" ' . $selected . ' >All</option>';
        } else {
            $output.= '<option value="" >Select Hrs</option>';
        }
        for ($i = 1;$i <= 144;$i++) {
            if ($multiple == '1') {
                if (in_array($i, $order_cutoff_time)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ($i == $order_cutoff_time) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
        }
        return $output;
    }
    public function addBannerSlider($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblbanners` (`banner_title`,`banner_title_font_family`,`banner_title_font_size`,`banner_title_font_color`,

					`banner_text_line1`,`banner_text_line1_font_family`,`banner_text_line1_font_size`,`banner_text_line1_font_color`,

					`banner_text_line2`,`banner_text_line2_font_family`,`banner_text_line2_font_size`,`banner_text_line2_font_color`,

					`banner_image`,`banner_order`,`banner_country_id`,`banner_state_id`,`banner_city_id`,`banner_area_id`,

					`banner_publish_date_type`,`banner_publish_days_of_month`,`banner_publish_days_of_week`,`banner_publish_single_date`,

					`banner_publish_start_date`,`banner_publish_end_date`,`banner_status`,`banner_add_date`,`added_by_admin`) 

					VALUES (:banner_title,:banner_title_font_family,:banner_title_font_size,:banner_title_font_color,

					:banner_text_line1,:banner_text_line1_font_family,:banner_text_line1_font_size,:banner_text_line1_font_color,

					:banner_text_line2,:banner_text_line2_font_family,:banner_text_line2_font_size,:banner_text_line2_font_color,

					:banner_image,:banner_order,:banner_country_id,:banner_state_id,:banner_city_id,:banner_area_id,

					:banner_publish_date_type,:banner_publish_days_of_month,:banner_publish_days_of_week,:banner_publish_single_date,

					:banner_publish_start_date,:banner_publish_end_date,:banner_status,:banner_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':banner_title' => addslashes($tdata['banner_title']), ':banner_title_font_family' => addslashes($tdata['banner_title_font_family']), ':banner_title_font_size' => addslashes($tdata['banner_title_font_size']), ':banner_title_font_color' => addslashes($tdata['banner_title_font_color']), ':banner_text_line1' => addslashes($tdata['banner_text_line1']), ':banner_text_line1_font_family' => addslashes($tdata['banner_text_line1_font_family']), ':banner_text_line1_font_size' => addslashes($tdata['banner_text_line1_font_size']), ':banner_text_line1_font_color' => addslashes($tdata['banner_text_line1_font_color']), ':banner_text_line2' => addslashes($tdata['banner_text_line2']), ':banner_text_line2_font_family' => addslashes($tdata['banner_text_line2_font_family']), ':banner_text_line2_font_size' => addslashes($tdata['banner_text_line2_font_size']), ':banner_text_line2_font_color' => addslashes($tdata['banner_text_line2_font_color']), ':banner_image' => addslashes($tdata['banner_image']), ':banner_order' => addslashes($tdata['banner_order']), ':banner_country_id' => addslashes($tdata['banner_country_id']), ':banner_state_id' => addslashes($tdata['banner_state_id']), ':banner_city_id' => addslashes($tdata['banner_city_id']), ':banner_area_id' => addslashes($tdata['banner_area_id']), ':banner_publish_date_type' => addslashes($tdata['banner_publish_date_type']), ':banner_publish_days_of_month' => addslashes($tdata['banner_publish_days_of_month']), ':banner_publish_days_of_week' => addslashes($tdata['banner_publish_days_of_week']), ':banner_publish_single_date' => addslashes($tdata['banner_publish_single_date']), ':banner_publish_start_date' => addslashes($tdata['banner_publish_start_date']), ':banner_publish_end_date' => addslashes($tdata['banner_publish_end_date']), ':banner_status' => addslashes($tdata['banner_status']), ':banner_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $banner_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($banner_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addBannerSlider] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllBannerSliders($txtsearch = '', $status = '', $publish_date_type = '', $publish_days_of_month = '', $publish_days_of_week = '', $publish_single_date = '', $publish_start_date = '', $publish_end_date = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `banner_title` LIKE '%" . $txtsearch . "%' OR `banner_text_line1` LIKE '%" . $txtsearch . "%' OR `banner_text_line2` LIKE '%" . $txtsearch . "%' )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND banner_status = '" . $status . "' ";
        }
        $sql_publish_date_str = "";
        if ($publish_date_type != '') {
            if ($publish_date_type == 'days_of_month') {
                if ($publish_days_of_month != '' && $publish_days_of_month != '-1') {
                    $sql_publish_date_str = " AND `banner_publish_date_type` = 'days_of_month' AND FIND_IN_SET(banner_publish_days_of_month, " . $publish_days_of_month . ") > 0 ";
                }
            } elseif ($publish_date_type == 'days_of_week') {
                if ($publish_days_of_week != '' && $publish_days_of_week != '-1') {
                    $sql_publish_date_str = " AND `banner_publish_date_type` = 'days_of_week' AND FIND_IN_SET(banner_publish_days_of_week, " . $publish_days_of_week . ") > 0 ";
                }
            } elseif ($publish_date_type == 'single_date') {
                if ($publish_single_date != '' && $publish_single_date != '0000-00-00') {
                    $sql_publish_date_str = " AND `banner_publish_date_type` = 'single_date' AND banner_publish_single_date = '" . date('Y-m-d', strtotime($publish_single_date)) . "' ";
                }
            } elseif ($publish_date_type == 'date_range') {
                if ($publish_start_date != '' && $publish_start_date != '0000-00-00' && $publish_end_date != '' && $publish_end_date != '0000-00-00') {
                    $sql_publish_date_str = " AND `banner_publish_date_type` = 'date_range' AND banner_publish_start_date >= '" . date('Y-m-d', strtotime($publish_start_date)) . "' AND banner_publish_start_date <= '" . date('Y-m-d', strtotime($publish_end_date)) . "' AND banner_publish_end_date >= '" . date('Y-m-d', strtotime($publish_start_date)) . "' AND banner_publish_end_date <= '" . date('Y-m-d', strtotime($publish_end_date)) . "' ";
                }
            }
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(banner_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(banner_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(banner_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(banner_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(banner_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( banner_country_id = '" . $country_id . "' OR banner_country_id = '-1' )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( banner_state_id = '" . $state_id . "' OR banner_state_id = '-1' ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( banner_city_id = '" . $city_id . "' OR banner_city_id = '-1' ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( banner_area_id = '" . $area_id . "' OR banner_area_id = '-1' ) ";
        }
        $sql = "SELECT * FROM `tblbanners` 

				WHERE `banner_deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_publish_date_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY banner_order ASC, banner_title ASC, banner_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAreaName($area_id) {
        $DBH = new DatabaseHandler();
        $area_name = '';
        try {
            $sql = "SELECT `area_name` FROM `tblarea` WHERE `area_id`= '" . $area_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $area_name = stripslashes($r['area_name']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getAreaName] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
        return $area_name;
    }
    public function getCityNameOfArea($area_id) {
        $DBH = new DatabaseHandler();
        $city_name = '';
        try {
            $sql = "SELECT `city_id` FROM `tblarea` WHERE `area_id`= '" . $area_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $city_name = $this->getCityName($r['city_id']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCityNameOfArea] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
        return $city_name;
    }
    public function getStateNameOfArea($area_id) {
        $DBH = new DatabaseHandler();
        $state_name = '';
        try {
            $sql = "SELECT `state_id` FROM `tblarea` WHERE `area_id`= '" . $area_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $state_name = $this->getStateName($r['state_id']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getStateNameOfArea] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
        return $state_name;
    }
    public function getStateNameOfCity($city_id) {
        $DBH = new DatabaseHandler();
        $state_name = '';
        try {
            $sql = "SELECT `state_id` FROM `tblcities` WHERE `city_id`= '" . $city_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $state_name = $this->getStateName($r['state_id']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getStateNameOfCity] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
        return $state_name;
    }
    public function getCountryNameOfArea($area_id) {
        $DBH = new DatabaseHandler();
        $country_name = '';
        try {
            $sql = "SELECT `country_id` FROM `tblarea` WHERE `area_id`= '" . $area_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $country_name = $this->getCountryName($r['country_id']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCountryNameOfArea] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
        return $country_name;
    }
    public function getCountryNameOfCity($city_id) {
        $DBH = new DatabaseHandler();
        $country_name = '';
        try {
            $sql = "SELECT `country_id` FROM `tblcities` WHERE `city_id`= '" . $city_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $country_name = $this->getCountryName($r['country_id']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCountryNameOfCity] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
        return $country_name;
    }
    public function getCountryNameOfState($state_id) {
        $DBH = new DatabaseHandler();
        $country_name = '';
        try {
            $sql = "SELECT `country_id` FROM `tblstates` WHERE `state_id`= '" . $state_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $country_name = $this->getCountryName($r['country_id']);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCountryNameOfState] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return '';
        }
        return $country_name;
    }
    public function getLocationStr($country_id = '', $state_id = '', $city_id = '', $area_id = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($area_id == '') {
            $area_id = '-1';
        }
        if ($city_id == '') {
            $city_id = '-1';
        }
        if ($state_id == '') {
            $state_id = '-1';
        }
        if ($country_id == '') {
            $area_id = '-1';
        }
        if ($area_id == '-1') {
            if ($city_id == '-1') {
                if ($state_id == '-1') {
                    if ($country_id == '-1') {
                        $output = 'All';
                    } else {
                        $output = $this->getCountryName($country_id);
                    }
                } else {
                    $output = $this->getStateName($state_id);
                    $output.= ', ' . $this->getCountryNameOfState($state_id);
                }
            } else {
                $output = $this->getCityName($city_id);
                $output.= ', ' . $this->getStateNameOfCity($city_id);
                $output.= ', ' . $this->getCountryNameOfCity($city_id);
            }
        } else {
            $output = $this->getAreaName($area_id);
            $output.= ', ' . $this->getCityNameOfArea($area_id);
            $output.= ', ' . $this->getStateNameOfArea($area_id);
            $output.= ', ' . $this->getCountryNameOfArea($area_id);
        }
        return $output;
    }
    public function deleteBannerSlider($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblbanners` SET 

					`banner_deleted` = :banner_deleted,

					`banner_modified_date` = :banner_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `banner_id` = :banner_id AND `banner_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':banner_deleted' => '1', ':banner_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':banner_id' => $tdata['banner_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteBannerSlider] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getBannerSliderDetails($banner_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblbanners` WHERE `banner_id` = '" . $banner_id . "' AND `banner_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function updateBannerSlider($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblbanners` SET 

					`banner_title` = :banner_title,

					`banner_title_font_family` = :banner_title_font_family,

					`banner_title_font_size` = :banner_title_font_size,

					`banner_title_font_color` = :banner_title_font_color,

					`banner_text_line1` = :banner_text_line1,

					`banner_text_line1_font_family` = :banner_text_line1_font_family,

					`banner_text_line1_font_size` = :banner_text_line1_font_size,

					`banner_text_line1_font_color` = :banner_text_line1_font_color,

					`banner_text_line2` = :banner_text_line2,

					`banner_text_line2_font_family` = :banner_text_line2_font_family,

					`banner_text_line2_font_size` = :banner_text_line2_font_size,

					`banner_text_line2_font_color` = :banner_text_line2_font_color,

					`banner_image` = :banner_image,

					`banner_order` = :banner_order,

					`banner_country_id` = :banner_country_id,

					`banner_state_id` = :banner_state_id,

					`banner_city_id` = :banner_city_id,

					`banner_area_id` = :banner_area_id,

					`banner_publish_date_type` = :banner_publish_date_type,

					`banner_publish_days_of_month` = :banner_publish_days_of_month,

					`banner_publish_days_of_week` = :banner_publish_days_of_week,

					`banner_publish_single_date` = :banner_publish_single_date,

					`banner_publish_start_date` = :banner_publish_start_date,

					`banner_publish_end_date` = :banner_publish_end_date,

					`banner_status` = :banner_status,

					`banner_modified_date` = :banner_modified_date,  

					`modified_by_admin` = :modified_by_admin  

					WHERE `banner_id` = :banner_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':banner_title' => addslashes($tdata['banner_title']), ':banner_title_font_family' => addslashes($tdata['banner_title_font_family']), ':banner_title_font_size' => addslashes($tdata['banner_title_font_size']), ':banner_title_font_color' => addslashes($tdata['banner_title_font_color']), ':banner_text_line1' => addslashes($tdata['banner_text_line1']), ':banner_text_line1_font_family' => addslashes($tdata['banner_text_line1_font_family']), ':banner_text_line1_font_size' => addslashes($tdata['banner_text_line1_font_size']), ':banner_text_line1_font_color' => addslashes($tdata['banner_text_line1_font_color']), ':banner_text_line2' => addslashes($tdata['banner_text_line2']), ':banner_text_line2_font_family' => addslashes($tdata['banner_text_line2_font_family']), ':banner_text_line2_font_size' => addslashes($tdata['banner_text_line2_font_size']), ':banner_text_line2_font_color' => addslashes($tdata['banner_text_line2_font_color']), ':banner_image' => addslashes($tdata['banner_image']), ':banner_order' => addslashes($tdata['banner_order']), ':banner_country_id' => addslashes($tdata['banner_country_id']), ':banner_state_id' => addslashes($tdata['banner_state_id']), ':banner_city_id' => addslashes($tdata['banner_city_id']), ':banner_area_id' => addslashes($tdata['banner_area_id']), ':banner_publish_date_type' => addslashes($tdata['banner_publish_date_type']), ':banner_publish_days_of_month' => addslashes($tdata['banner_publish_days_of_month']), ':banner_publish_days_of_week' => addslashes($tdata['banner_publish_days_of_week']), ':banner_publish_single_date' => addslashes($tdata['banner_publish_single_date']), ':banner_publish_start_date' => addslashes($tdata['banner_publish_start_date']), ':banner_publish_end_date' => addslashes($tdata['banner_publish_end_date']), ':banner_status' => addslashes($tdata['banner_status']), ':banner_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':banner_id' => $tdata['banner_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateBannerSlider] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getFontFamilyOptions($font_family, $type = '1', $multiple = '') {
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $font_family)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Fonts</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Fonts</option>';
            }
        } else {
            $output.= '<option value="" >Select Font</option>';
        }
        $arr_font_family = array('Tahoma', 'Verdana', 'Arial Black', 'Comic Sans MS', 'Lucida Console', 'Palatino Linotype', 'MS Sans Serif4', 'System', 'Georgia1', 'Impact', 'Courier');
        sort($arr_font_family);
        for ($i = 0;$i < count($arr_font_family);$i++) {
            if ($multiple == '1') {
                if (in_array($arr_font_family[$i], $font_family)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ($arr_font_family[$i] == $font_family) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="' . $arr_font_family[$i] . '" ' . $selected . '>' . $arr_font_family[$i] . '</option>';
        }
        return $output;
    }
    public function getFontSizeOptions($font_size, $type = '1', $multiple = '') {
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $font_size)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Font Sizes</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Font Sizes</option>';
            }
        } else {
            $output.= '<option value="" >Select Font Size</option>';
        }
        $arr_font_size = array('8', '9', '10', '11', '12', '13', '14', '16', '18', '20', '22', '24', '28', '30', '32', '36');
        sort($arr_font_size);
        for ($i = 0;$i < count($arr_font_size);$i++) {
            if ($multiple == '1') {
                if (in_array($arr_font_size[$i], $font_size)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ($arr_font_size[$i] == $font_size) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="' . $arr_font_size[$i] . '" ' . $selected . '>' . $arr_font_size[$i] . 'px</option>';
        }
        return $output;
    }
    public function getUsersOption($user_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Users</option>';
        } else {
            $output.= '<option value="" >Select User</option>';
        }
        try {
            $sql = "SELECT user_id,first_name,last_name FROM `tblusers` WHERE `user_deleted` = '0' ORDER BY first_name ASC, last_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['user_id'] == $user_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['user_id'] . '" ' . $selected . '>' . stripslashes($r['first_name']) . ' ' . stripslashes($r['last_name']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getUsersOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getUsersOptionOfVendor($vendor_id, $user_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Users</option>';
        } else {
            $output.= '<option value="" >Select User</option>';
        }
        if ($vendor_id > 0) {
            $sql_vendor_str = " AND user_id IN (SELECT DISTINCT user_id FROM tblordercart WHERE prod_id IN ( SELECT DISTINCT cusine_id FROM tblcusines WHERE vendor_id = '" . $vendor_id . "' ) ) ";
            try {
                $sql = "SELECT user_id,first_name,last_name FROM `tblusers` WHERE `user_deleted` = '0' " . $sql_vendor_str . " ORDER BY first_name ASC, last_name ASC";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($r['user_id'] == $user_id) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                        $output.= '<option value="' . $r['user_id'] . '" ' . $selected . '>' . stripslashes($r['first_name']) . ' ' . stripslashes($r['last_name']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getUsersOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function getOrderStatusOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Status</option>';
        } else {
            $output.= '<option value="" selected>Select Status</option>';
        }
        $arr_order_status = array('Pending', 'Order Received', 'Shipped', 'Completed', 'Cancelled', 'Declined');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getPaymentStatusOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Status</option>';
        } else {
            $output.= '<option value="" selected>Select Status</option>';
        }
        $arr_order_status = array('Unpaid', 'Paid', 'Partial Paid');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getOrderStatusString($status) {
        $output = '';
        $arr_order_status = array('Pending', 'Order Received', 'Shipped', 'Completed', 'Cancelled', 'Declined');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getPaymentStatusString($status) {
        $output = '';
        $arr_order_status = array('Unpaid', 'Paid', 'Partial Paid');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getAllOrders($txtsearch = '', $status = '', $item_id = '', $vendor_id = '', $customer_id = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $payment_status = '', $delivery_date_type = '', $delivery_days_of_month = '', $delivery_days_of_week = '', $delivery_single_date = '', $delivery_start_date = '', $delivery_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( TBO.invoice LIKE '%" . $txtsearch . "%' OR TBO.user_name LIKE '%" . $txtsearch . "%' OR TBO.user_email LIKE '%" . $txtsearch . "%'  OR TBO.user_mobile_no LIKE '%" . $txtsearch . "%' )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TBO.order_status = '" . $status . "' ";
        }
        $sql_payment_status_str = "";
        if ($payment_status != '') {
            $sql_payment_status_str = " AND TBO.payment_status = '" . $payment_status . "' ";
        }
        $sql_item_id_str = "";
        if ($item_id != '') {
            $sql_item_id_str = " AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id = '" . $item_id . "' ) ";
        }
        $sql_vendor_id_str = "";
        if ($vendor_id != '') {
            // $sql_vendor_id_str = " AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id IN (SELECT DISTINCT(cusine_id) FROM tblcusines WHERE vendor_id = '".$vendor_id."' AND cusine_deleted = '0' ) ) ";
            $sql_vendor_id_str = "AND TBO.order_id IN(SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id IN(SELECT DISTINCT(event_id) FROM tbl_event_details WHERE event_master_id IN (SELECT DISTINCT(event_master_id) FROM tbl_event_master WHERE organiser_id = '" . $vendor_id . "' AND is_deleted = '0')))";
        }
        $sql_customer_id_str = "";
        if ($customer_id != '') {
            $sql_customer_id_str = " AND TBO.user_id = '" . $customer_id . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(TBO.order_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(TBO.order_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TBO.order_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TBO.order_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(TBO.order_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_delivery_date_str = "";
        if ($delivery_date_type != '') {
            if ($delivery_date_type == 'days_of_month') {
                if ($delivery_days_of_month != '' && $delivery_days_of_month != '-1') {
                    $sql_delivery_date_str = " AND DAY(TBO.order_delivery_date) = '" . $delivery_days_of_month . "' ";
                }
            } elseif ($delivery_date_type == 'days_of_week') {
                if ($delivery_days_of_week != '' && $delivery_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $delivery_days_of_week = $delivery_days_of_week - 1;
                    $sql_delivery_date_str = " AND WEEKDAY(TBO.order_delivery_date) = '" . $delivery_days_of_week . "' ";
                }
            } elseif ($delivery_date_type == 'single_date') {
                if ($delivery_single_date != '' && $delivery_single_date != '0000-00-00') {
                    $sql_delivery_date_str = " AND DATE(TBO.order_delivery_date) = '" . date('Y-m-d', strtotime($delivery_single_date)) . "' ";
                }
            } elseif ($delivery_date_type == 'date_range') {
                if ($delivery_start_date != '' && $delivery_start_date != '0000-00-00' && $delivery_end_date != '' && $delivery_end_date != '0000-00-00') {
                    $sql_delivery_date_str = " AND DATE(TBO.order_delivery_date) >= '" . date('Y-m-d', strtotime($delivery_start_date)) . "'  AND DATE(TBO.order_delivery_date) <= '" . date('Y-m-d', strtotime($delivery_end_date)) . "' ";
                }
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( TBO.user_country_id = '" . $country_id . "' OR TBO.user_country_id = '-1' )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( TBO.user_state_id = '" . $state_id . "' OR TBO.user_state_id = '-1' ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( TBO.user_city_id = '" . $city_id . "' OR TBO.user_city_id = '-1' ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( TBO.user_area_id = '" . $area_id . "' OR TBO.user_area_id = '-1' ) ";
        }
        // echo  $sql="SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id IN(SELECT DISTINCT(event_id) FROM tbl_event_details WHERE event_master_id IN (SELECT DISTINCT(event_master_id) FROM tbl_event_master WHERE organiser_id = '".$vendor_id."' AND is_deleted = '0'))";
        $sql = "SELECT TBO.* FROM `tblorders` AS TBO  

				WHERE TBO.invoice != '' " . $sql_search_str . " " . $sql_status_str . " " . $sql_payment_status_str . " " . $sql_item_id_str . " " . $sql_vendor_id_str . " " . $sql_customer_id_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_delivery_date_str . " " . $sql_add_date_str . "  ORDER BY TBO.order_add_date DESC ";
        // echo $sql="SELECT DISTINCT(event_id) FROM tbl_event_details WHERE event_master_id IN (SELECT DISTINCT(event_master_id) FROM tbl_event_master WHERE organiser_id = '".$vendor_id."' AND is_deleted = '0')";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                // echo "<pre>";print_r($r);echo "</pre>";
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllMailingOrders($txtsearch = '', $status = '', $item_id = '', $vendor_id = '', $customer_id = '', $order_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $payment_status = '', $delivery_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( TBO.invoice LIKE '%" . $txtsearch . "%' OR TBO.user_name LIKE '%" . $txtsearch . "%' OR TBO.user_email LIKE '%" . $txtsearch . "%'  OR TBO.user_mobile_no LIKE '%" . $txtsearch . "%' )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TBO.order_status = '" . $status . "' ";
        }
        $sql_payment_status_str = "";
        if ($payment_status != '') {
            $sql_payment_status_str = " AND TBO.payment_status = '" . $payment_status . "' ";
        }
        $sql_item_id_str = "";
        if ($item_id != '') {
            $sql_item_id_str = " AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id = '" . $item_id . "' ) ";
            //$sql_item_id_str = " AND TBC.prod_id = '".$item_id."' ) ";
            
        }
        $sql_vendor_id_str = "";
        if ($vendor_id != '') {
            $sql_vendor_id_str = " AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id IN (SELECT DISTINCT(cusine_id) FROM tblcusines WHERE vendor_id = '" . $vendor_id . "' AND cusine_deleted = '0' ) ) ";
            //$sql_vendor_id_str = " AND TBC.prod_id IN (SELECT DISTINCT(cusine_id) FROM tblcusines WHERE vendor_id = '".$vendor_id."' AND cusine_deleted = '0' ) ) ";
            
        }
        $sql_customer_id_str = "";
        if ($customer_id != '') {
            $sql_customer_id_str = " AND TBO.user_id = '" . $customer_id . "' ";
        }
        $sql_order_date_str = "";
        if ($order_date != '') {
            if ($order_date != '' && $order_date != '0000-00-00') {
                $sql_order_date_str = " AND DATE(TBO.order_add_date) = '" . date('Y-m-d', strtotime($order_date)) . "' ";
            }
        }
        $sql_delivery_date_str = "";
        if ($delivery_date != '') {
            if ($delivery_date != '' && $delivery_date != '0000-00-00') {
                $sql_delivery_date_str = " AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE order_cart_delivery_date = '" . date('Y-m-d', strtotime($delivery_date)) . "' ) ";
                //$sql_delivery_date_str = " AND TBC.order_cart_delivery_date = '".date('Y-m-d',strtotime($delivery_date))."' ";
                
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( TBO.user_country_id = '" . $country_id . "' OR TBO.user_country_id = '-1' )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( TBO.user_state_id = '" . $state_id . "' OR TBO.user_state_id = '-1' ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( TBO.user_city_id = '" . $city_id . "' OR TBO.user_city_id = '-1' ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( TBO.user_area_id = '" . $area_id . "' OR TBO.user_area_id = '-1' ) ";
        }
        /*
        
        $sql = "SELECT TBO.*,TBC.order_cart_id,TBC.prod_id,TBC.prod_name,TBC.prod_image,TBC.order_cart_delivery_date,TBC.order_cart_city_id,TBC.order_cart_area_id FROM `tblorders` AS TBO
        
        LEFT JOIN `tblordercart` AS TBC ON TBO.order_id = TBC.order_id
        
        WHERE TBO.invoice != '' ".$sql_search_str." ".$sql_status_str." ".$sql_payment_status_str." ".$sql_item_id_str." ".$sql_vendor_id_str." ".$sql_customer_id_str." ".$sql_country_id_str." ".$sql_state_id_str." ".$sql_city_id_str." ".$sql_area_id_str." ".$sql_delivery_date_str." ".$sql_order_date_str."  ORDER BY TBO.order_add_date DESC ";
        
        */
        $sql = "SELECT TBO.* FROM `tblorders` AS TBO

				WHERE TBO.invoice != '' " . $sql_search_str . " " . $sql_status_str . " " . $sql_payment_status_str . " " . $sql_item_id_str . " " . $sql_vendor_id_str . " " . $sql_customer_id_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_delivery_date_str . " " . $sql_order_date_str . "  ORDER BY TBO.order_add_date DESC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllCancellationOrders($txtsearch = '', $item_id = '', $vendor_id = '', $customer_id = '', $cancel_request_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( TBO.invoice LIKE '%" . $txtsearch . "%' OR TBO.user_name LIKE '%" . $txtsearch . "%' OR TBO.user_email LIKE '%" . $txtsearch . "%'  OR TBO.user_mobile_no LIKE '%" . $txtsearch . "%' )";
        }
        $sql_item_id_str = "";
        if ($item_id != '') {
            $sql_item_id_str = " AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id = '" . $item_id . "' ) ";
        }
        $sql_vendor_id_str = "";
        if ($vendor_id != '') {
            $sql_vendor_id_str = " AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id IN (SELECT DISTINCT(cusine_id) FROM tblcusines WHERE vendor_id = '" . $vendor_id . "' AND cusine_deleted = '0' ) ) ";
        }
        $sql_customer_id_str = "";
        if ($customer_id != '') {
            $sql_customer_id_str = " AND TBO.user_id = '" . $customer_id . "' ";
        }
        $sql_cancel_request_date_str = "";
        if ($cancel_request_date != '' && $cancel_request_date != '0000-00-00') {
            $sql_cancel_request_date_str = "  AND TBO.order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE DATE(cancel_request_date) = '" . date('Y-m-d', strtotime($cancel_request_date)) . "' )  ";
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( TBO.user_country_id = '" . $country_id . "' OR TBO.user_country_id = '-1' )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( TBO.user_state_id = '" . $state_id . "' OR TBO.user_state_id = '-1' ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( TBO.user_city_id = '" . $city_id . "' OR TBO.user_city_id = '-1' ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( TBO.user_area_id = '" . $area_id . "' OR TBO.user_area_id = '-1' ) ";
        }
        $sql = "SELECT TBO.*, TOC.* FROM `tblorders` AS TBO 

				LEFT JOIN `tblordercart` AS TOC ON TBO.invoice = TOC.invoice 

				WHERE TOC.cancel_request_sent = '1' AND TBO.invoice != '' " . $sql_search_str . " " . $sql_item_id_str . " " . $sql_vendor_id_str . " " . $sql_customer_id_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_cancel_request_date_str . " GROUP BY TBO.invoice  ORDER BY TBO.order_add_date DESC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getOrderDetailsByInvoice($invoice) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        try {
            $sql = "SELECT * FROM `tblorders` WHERE `invoice` = '" . $invoice . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_record = $r;
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderDetailsByInvoice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
    public function getOrderDetailsByInvoiceAndVendorId($invoice, $vendor_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        try {
            $sql_vendor_id_str = " AND order_id IN (SELECT DISTINCT(order_id) FROM tblordercart WHERE prod_id IN (SELECT DISTINCT(cusine_id) FROM tblcusines WHERE vendor_id = '" . $vendor_id . "' AND cusine_deleted = '0' ) ) ";
            $sql = "SELECT * FROM `tblorders` WHERE `invoice` = '" . $invoice . "' " . $sql_vendor_id_str;
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_record = $r;
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderDetailsByInvoiceAndVendorId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
    public function getOrderCartDeliveryDateByOrderCartId($order_cart_id) {
        $DBH = new DatabaseHandler();
        $delivery_date = '';
        try {
            $sql = "SELECT * FROM `tblordercart` WHERE `order_cart_id` = '" . $order_cart_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $delivery_date = $r['order_cart_delivery_date'];
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderCartDeliveryDateByOrderCartId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return $delivery_date;
        }
        return $delivery_date;
    }
    public function getOrderDeliveryDateByInvoice($invoice) {
        $DBH = new DatabaseHandler();
        $delivery_date = '';
        try {
            $sql = "SELECT * FROM `tblorders` WHERE `invoice` = '" . $invoice . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $delivery_date = $r['order_delivery_date'];
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderDeliveryDateByInvoice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return $delivery_date;
        }
        return $delivery_date;
    }
    public function chkIfOrderCartIdAlreadyAddedToDelivery($order_item_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblorderdelivery` WHERE `order_item_id` = '" . $order_item_id . "' AND `delivery_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getOrderCartItemsListOfInvoice($invoice, $arr_order_cart_id, $list_mode = '0') {
        $DBH = new DatabaseHandler();
        $output = '';
        /*
        
        //list_mode = 	0 - Add form,
        
        1 - Edit Form
        
        */
        $output.= '<div class="table-responsive">

						<table id="datatable" class="table table-hover" >

							<thead>

								<tr>

									<th>Select</th>

									<th>Delivery Date</th>

									<th>TOS Area</th>

									<th>Customer Delivery Area</th>

									<th>Item Name</th>

									<th>Quantity</th>

								</tr>

							</thead>

							<tbody>';
        $arr_order_cart = $this->getOrderCartDetailsByInvoice($invoice);
        if (count($arr_order_cart) > 0) {
            $arr_order_details = $this->getOrderDetailsByInvoice($invoice);
            foreach ($arr_order_cart as $record) {
                if (is_array($arr_order_cart_id) && count($arr_order_cart_id) > 0 && in_array($record['order_cart_id'], $arr_order_cart_id)) {
                    $checked = ' checked ';
                } else {
                    $checked = '';
                }
                $show_list_record = true;
                if ($list_mode == '0') {
                    if ($this->chkIfOrderCartIdAlreadyAddedToDelivery($record['order_cart_id'])) {
                        $show_list_record = false;
                    }
                } elseif ($list_mode == '1') {
                    if (is_array($arr_order_cart_id) && count($arr_order_cart_id) > 0 && in_array($record['order_cart_id'], $arr_order_cart_id)) {
                        $show_list_record = true;
                    } else {
                        $show_list_record = false;
                    }
                }
                if ($show_list_record) {
                    $checkbox_str = ' <input type="checkbox" name="chkbox_records[]" value="' . $record['order_cart_id'] . '" ' . $checked . '> ';
                } else {
                    $checkbox_str = '';
                }
                $output.= '		<tr>

								<td>' . $checkbox_str . '</td>

								<td>' . date('d-M-Y', strtotime($record['order_cart_delivery_date'])) . '</td>

								<td>' . $this->getCusineLocationStr($record['order_cart_city_id'], $record['order_cart_area_id']) . '</td>

								<td>' . $this->getCusineLocationStr($arr_order_details['user_city_id'], $arr_order_details['user_area_id']) . '</td>

								<td>' . $record['prod_name'] . '</td>

								<td> ' . $record['prod_qty'] . ' ( ' . $record['prod_ordering_size'] . ' )</td>

							</tr>';
            }
        }
        $output.= '		</tbody>

						</table>

					</div>';
        return $output;
    }
    public function getCancelReasonCategoryOption($parent_cat_id, $cat_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Reasone</option>';
        } else {
            $output.= '<option value="" >Select Reason</option>';
        }
        if ($parent_cat_id == '' || $parent_cat_id == '0') {
            return $output;
        }
        try {
            $sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '" . $parent_cat_id . "' AND `cat_deleted` = '0' ORDER BY cat_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['cat_id'] == $cat_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['cat_id'] . '" ' . $selected . '>' . stripslashes($r['cat_name']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getCancelReasonCategoryOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getOrderCartDetailsByInvoiceAndOrderCartId($invoice, $order_cart_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        try {
            $sql = "SELECT * FROM `tblordercart` WHERE `invoice` = '" . $invoice . "' AND `order_cart_id` = '" . $order_cart_id . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_record = $r;
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderCartDetailsByInvoiceAndOrderCartId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
    public function doCancelItem($tdata) {
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
            $STH->execute(array(':cancel_request_sent' => addslashes($tdata['cancel_request_sent']), ':cancel_request_date' => date('Y-m-d H:i:s'), ':cancel_cat_id' => addslashes($tdata['cancel_cat_id']), ':cancel_cat_other' => addslashes($tdata['cancel_cat_other']), ':cancel_comments' => addslashes($tdata['cancel_comments']), ':cancel_request_by_admin' => addslashes($tdata['cancel_request_by_admin']), ':cancel_request_by_admin_id' => addslashes($tdata['cancel_request_by_admin_id']), ':invoice' => $tdata['invoice'], ':order_cart_id' => $tdata['order_cart_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[doCancelItem] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getOrderCartDetailsByInvoice($invoice) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        try {
            $sql = "SELECT * FROM `tblordercart` WHERE `invoice` = '" . $invoice . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $arr_record[] = $r;
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderCartDetailsByInvoice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
    public function getOrderCartDetailsByInvoiceAndVendorId($invoice, $vendor_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        try {
            $sql_vendor_id_str = " AND prod_id IN (SELECT DISTINCT(cusine_id) FROM tblcusines WHERE vendor_id = '" . $vendor_id . "' AND cusine_deleted = '0' ) ";
            $sql = "SELECT * FROM `tblordercart` WHERE `invoice` = '" . $invoice . "' " . $sql_vendor_id_str;
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $arr_record[] = $r;
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderCartDetailsByInvoiceAndVendorId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
    public function getCancellationRequestOrderCartDetailsByInvoice($invoice) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        try {
            $sql = "SELECT * FROM `tblordercart` WHERE `invoice` = '" . $invoice . "' AND `cancel_request_sent` = '1' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $arr_record[] = $r;
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getCancellationRequestOrderCartDetailsByInvoice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
        return $arr_record;
    }
    public function addOrderStatusLog($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblorderstatuslog` (`order_id`,`invoice`,`order_status`,`order_note`,`order_status_date`,`log_added_by_admin`,`log_added_by_id`) 

					VALUES (:order_id,:invoice,:order_status,:order_note,:order_status_date,:log_added_by_admin,:log_added_by_id)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':order_id' => addslashes($tdata['order_id']), ':invoice' => addslashes($tdata['invoice']), ':order_status' => addslashes($tdata['order_status']), ':order_note' => addslashes($tdata['order_note']), ':order_status_date' => date('Y-m-d H:i:s'), ':log_added_by_admin' => addslashes($tdata['order_updated_by_admin']), ':log_added_by_id' => addslashes($tdata['order_updated_by_id'])));
            $order_status_log_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($order_status_log_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addOrderStatusLog] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateOrderStatus($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        if ($this->addOrderStatusLog($tdata)) {
            try {
                $sql = "UPDATE `tblorders` SET 

						`order_status` = :order_status,

						`payment_status` = :payment_status,

						`order_note` = :order_note,

						`order_modified_date` = :order_modified_date,  

						`order_updated_by_admin` = :order_updated_by_admin,  

						`order_updated_by_id` = :order_updated_by_id  

						WHERE `invoice` = :invoice ";
                $STH = $DBH->prepare($sql);
                $STH->execute(array(':order_status' => addslashes($tdata['order_status']), ':payment_status' => addslashes($tdata['payment_status']), ':order_note' => addslashes($tdata['order_note']), ':order_modified_date' => date('Y-m-d H:i:s'), ':order_updated_by_admin' => $tdata['order_updated_by_admin'], ':order_updated_by_id' => $tdata['order_updated_by_id'], ':invoice' => $tdata['invoice']));
                $DBH->commit();
                $return = true;
            }
            catch(Exception $e) {
                $stringData = '[updateOrderStatus] Catch Error:' . $e->getMessage();
                $this->debuglog($stringData);
                return false;
            }
        }
        return $return;
    }
    public function getAllPages($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `page_name` LIKE '%" . $txtsearch . "%' OR `page_title` LIKE '%" . $txtsearch . "%' OR `page_contents` LIKE '%" . $txtsearch . "%' )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND page_status = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(page_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(page_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(page_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(page_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(page_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblpages` 

				WHERE `page_deleted` = '0' AND `show_in_admin` = '1' " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY page_name ASC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function deletePage($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblpages` SET 

					`page_deleted` = :page_deleted,

					`page_modified_date` = :page_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `page_id` = :page_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':page_deleted' => '1', ':page_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':page_id' => $tdata['page_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deletePage] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addPage($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblpages` (`page_name`,`page_title`,`page_contents`,`meta_title`,`meta_keywords`,`meta_desc`,`link_enable`,`page_link`,

					`show_in_manage_menu`,`show_in_admin`,`page_status`,`page_add_date`,`added_by_admin`) 

					VALUES (:page_name,:page_title,:page_contents,:meta_title,:meta_keywords,:meta_desc,:link_enable,:page_link,

					:show_in_manage_menu,:show_in_admin,:page_status,:page_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':page_name' => addslashes($tdata['page_name']), ':page_title' => addslashes($tdata['page_title']), ':page_contents' => addslashes($tdata['page_contents']), ':meta_title' => addslashes($tdata['meta_title']), ':meta_keywords' => addslashes($tdata['meta_keywords']), ':meta_desc' => addslashes($tdata['meta_desc']), ':link_enable' => addslashes($tdata['link_enable']), ':page_link' => addslashes($tdata['page_link']), ':show_in_manage_menu' => addslashes($tdata['show_in_manage_menu']), ':show_in_admin' => addslashes($tdata['show_in_admin']), ':page_status' => addslashes($tdata['page_status']), ':page_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $page_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($page_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addPage] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkIfPageNameExist($page_name) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblpages` WHERE `page_name` = '" . addslashes($page_name) . "' AND `page_deleted` = '0' AND `show_in_admin` = '1' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkIfPageNameExist] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkIfPageNameExist_Edit($page_name, $page_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblpages` WHERE `page_name` = '" . addslashes($page_name) . "' AND `page_id` != '" . $page_id . "' AND `page_deleted` = '0' AND `show_in_admin` = '1' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkIfPageNameExist_Edit] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getPageDetails($page_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '" . addslashes($page_id) . "' AND `page_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function updatePage($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblpages` SET 

					`page_name` = :page_name,

					`page_title` = :page_title,

					`page_contents` = :page_contents,

					`meta_title` = :meta_title,

					`meta_keywords` = :meta_keywords,

					`meta_desc` = :meta_desc,

					`page_link` = :page_link,

					`show_in_manage_menu` = :show_in_manage_menu,

					`page_status` = :page_status,

					`page_modified_date` = :page_modified_date,  

					`modified_by_admin` = :modified_by_admin  

					WHERE `page_id` = :page_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':page_name' => addslashes($tdata['page_name']), ':page_title' => addslashes($tdata['page_title']), ':page_contents' => addslashes($tdata['page_contents']), ':meta_title' => addslashes($tdata['meta_title']), ':meta_keywords' => addslashes($tdata['meta_keywords']), ':meta_desc' => addslashes($tdata['meta_desc']), ':page_link' => addslashes($tdata['page_link']), ':show_in_manage_menu' => addslashes($tdata['show_in_manage_menu']), ':page_status' => addslashes($tdata['page_status']), ':page_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':page_id' => $tdata['page_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updatePage] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllShippingPrices($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $sp_type = '', $sp_applied_on = '', $sp_effective_date = '', $vendor_id = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_vendor_str = "";
        if ($vendor_id != '') {
            $sql_vendor_str = " AND ( `vendor_id` = '" . $vendor_id . "'  )";
        }
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `shipping_price` = '" . $txtsearch . "'  )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND sp_status = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(sp_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(sp_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(sp_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(sp_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(sp_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( sp_country_id = '" . $country_id . "' OR sp_country_id = '-1' OR  FIND_IN_SET(" . $country_id . ", sp_country_id) > 0  )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( sp_state_id = '" . $state_id . "' OR sp_state_id = '-1' OR  FIND_IN_SET(" . $state_id . ", sp_state_id) > 0  ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( sp_city_id = '" . $city_id . "' OR sp_city_id = '-1' OR  FIND_IN_SET(" . $city_id . ", sp_city_id) > 0  ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( sp_area_id = '" . $area_id . "' OR sp_area_id = '-1' OR sp_area_id = '-1' OR  FIND_IN_SET(" . $area_id . ", sp_area_id) > 0 ) ";
        }
        $sql_sp_type_str = "";
        if ($sp_type != '') {
            $sql_sp_type_str = " AND ( `sp_type` = '" . $sp_type . "'  )";
        }
        $sql_sp_applied_on_str = "";
        if ($sp_applied_on != '') {
            $sql_sp_applied_on_str = " AND ( `sp_applied_on` = '" . $sp_applied_on . "'  )";
        }
        $sql_sp_effective_date_str = "";
        if ($sp_effective_date != '') {
            $sql_sp_effective_date_str = " AND ( `sp_effective_date` <= '" . date('Y-m-d', strtotime($sp_effective_date)) . "' AND `sp_effective_date` != '0000-00-00' ) ";
        }
        $sql = "SELECT * FROM `tblshippingprices` 

				WHERE `sp_deleted` = '0' " . $sql_vendor_str . " " . $sql_search_str . " " . $sql_status_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . " " . $sql_sp_type_str . " " . $sql_sp_applied_on_str . " " . $sql_sp_effective_date_str . " ORDER BY sp_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllCancellationPrices($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $cp_type = '', $cp_applied_on = '', $cp_effective_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `cp_title` = '" . $txtsearch . "' OR `cancellation_price` = '" . $txtsearch . "'  )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND cp_status = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(cp_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(cp_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cp_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cp_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(cp_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_cp_type_str = "";
        if ($cp_type != '') {
            $sql_cp_type_str = " AND ( `cp_type` = '" . $cp_type . "'  )";
        }
        $sql_cp_applied_on_str = "";
        if ($cp_applied_on != '') {
            $sql_cp_applied_on_str = " AND ( `cp_applied_on` = '" . $cp_applied_on . "'  )";
        }
        $sql_cp_effective_date_str = "";
        if ($cp_effective_date != '') {
            $sql_cp_effective_date_str = " AND ( `cp_effective_date` <= '" . date('Y-m-d', strtotime($sp_effective_date)) . "' AND `cp_effective_date` != '0000-00-00' ) ";
        }
        $sql = "SELECT * FROM `tblcancellationprices` 

				WHERE `cp_deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . " " . $sql_cp_type_str . " " . $sql_cp_applied_on_str . " " . $sql_cp_effective_date_str . " ORDER BY cp_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function deleteShippingPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblshippingprices` SET 

					`sp_deleted` = :sp_deleted,

					`sp_modified_date` = :sp_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `sp_id` = :sp_id AND `vendor_id` = :vendor_id AND `sp_deleted` = '0' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':sp_deleted' => '1', ':sp_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':sp_id' => $tdata['sp_id'], ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteShippingPrice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteCancellationPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcancellationprices` SET 

					`cp_deleted` = :cp_deleted,

					`cp_modified_date` = :cp_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `cp_id` = :cp_id AND `cp_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cp_deleted' => '1', ':cp_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':cp_id' => $tdata['cp_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCancellationPrice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addShippingPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblshippingprices` (`shipping_price`,`min_order_amount`,`max_order_amount`,`sp_type`,`sp_percentage`,`sp_min_qty_id`,

					`sp_min_qty_val`,`sp_max_qty_id`,`sp_max_qty_val`,`sp_applied_on`,`sp_effective_date`,`sp_country_id`,`sp_state_id`,`sp_city_id`,

					`sp_area_id`,`sp_comments`,`sp_status`,`sp_add_date`,`added_by_admin`,`vendor_id`) 

					VALUES (:shipping_price,:min_order_amount,:max_order_amount,:sp_type,:sp_percentage,:sp_min_qty_id,

					:sp_min_qty_val,:sp_max_qty_id,:sp_max_qty_val,:sp_applied_on,:sp_effective_date,:sp_country_id,:sp_state_id,:sp_city_id,

					:sp_area_id,:sp_comments,:sp_status,:sp_add_date,:added_by_admin,:vendor_id)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':shipping_price' => addslashes($tdata['shipping_price']), ':min_order_amount' => addslashes($tdata['min_order_amount']), ':max_order_amount' => addslashes($tdata['max_order_amount']), ':sp_type' => addslashes($tdata['sp_type']), ':sp_percentage' => addslashes($tdata['sp_percentage']), ':sp_min_qty_id' => addslashes($tdata['sp_min_qty_id']), ':sp_min_qty_val' => addslashes($tdata['sp_min_qty_val']), ':sp_max_qty_id' => addslashes($tdata['sp_max_qty_id']), ':sp_max_qty_val' => addslashes($tdata['sp_max_qty_val']), ':sp_applied_on' => addslashes($tdata['sp_applied_on']), ':sp_effective_date' => addslashes($tdata['sp_effective_date']), ':sp_country_id' => addslashes($tdata['sp_country_id']), ':sp_state_id' => addslashes($tdata['sp_state_id']), ':sp_city_id' => addslashes($tdata['sp_city_id']), ':sp_area_id' => addslashes($tdata['sp_area_id']), ':sp_comments' => addslashes($tdata['sp_comments']), ':sp_status' => addslashes($tdata['sp_status']), ':sp_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin'], ':vendor_id' => $tdata['vendor_id']));
            $sp_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($sp_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addShippingPrice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addCancellationPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblcancellationprices` (`cp_title`,`cancellation_price`,`min_cancellation_amount`,`max_cancellation_amount`,`cp_type`,

					`cp_percentage`,`cp_min_qty_id`,`cp_min_qty_val`,`cp_max_qty_id`,`cp_max_qty_val`,`cp_min_hrs`,`cp_max_hrs`,`cp_applied_on`,`cp_effective_date`,`cp_comments`,

					`cp_status`,`cp_add_date`,`added_by_admin`) 

					VALUES (:cp_title,:cancellation_price,:min_cancellation_amount,:max_cancellation_amount,:cp_type,

					:cp_percentage,:cp_min_qty_id,:cp_min_qty_val,:cp_max_qty_id,:cp_max_qty_val,:cp_min_hrs,:cp_max_hrs,:cp_applied_on,:cp_effective_date,:cp_comments,

					:cp_status,:cp_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cp_title' => addslashes($tdata['cp_title']), ':cancellation_price' => addslashes($tdata['cancellation_price']), ':min_cancellation_amount' => addslashes($tdata['min_cancellation_amount']), ':max_cancellation_amount' => addslashes($tdata['max_cancellation_amount']), ':cp_type' => addslashes($tdata['cp_type']), ':cp_percentage' => addslashes($tdata['cp_percentage']), ':cp_min_qty_id' => addslashes($tdata['cp_min_qty_id']), ':cp_min_qty_val' => addslashes($tdata['cp_min_qty_val']), ':cp_max_qty_id' => addslashes($tdata['cp_max_qty_id']), ':cp_max_qty_val' => addslashes($tdata['cp_max_qty_val']), ':cp_min_hrs' => addslashes($tdata['cp_min_hrs']), ':cp_max_hrs' => addslashes($tdata['cp_max_hrs']), ':cp_applied_on' => addslashes($tdata['cp_applied_on']), ':cp_effective_date' => addslashes($tdata['cp_effective_date']), ':cp_comments' => addslashes($tdata['cp_comments']), ':cp_status' => addslashes($tdata['cp_status']), ':cp_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $cp_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($cp_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addCancellationPrice] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getShippingPriceDetails($sp_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblshippingprices` WHERE `sp_id` = '" . $sp_id . "' AND `sp_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getCancellationPriceDetails($cp_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcancellationprices` WHERE `cp_id` = '" . $cp_id . "' AND `cp_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function updateShippingPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblshippingprices` SET 

					`shipping_price` = :shipping_price,

					`min_order_amount` = :min_order_amount,

					`max_order_amount` = :max_order_amount,

					`sp_type` = :sp_type,

					`sp_percentage` = :sp_percentage,

					`sp_min_qty_id` = :sp_min_qty_id,

					`sp_min_qty_val` = :sp_min_qty_val,

					`sp_max_qty_id` = :sp_max_qty_id,

					`sp_max_qty_val` = :sp_max_qty_val,

					`sp_applied_on` = :sp_applied_on,

					`sp_effective_date` = :sp_effective_date,

					`sp_country_id` = :sp_country_id,

					`sp_state_id` = :sp_state_id,

					`sp_city_id` = :sp_city_id,

					`sp_area_id` = :sp_area_id,

					`sp_comments` = :sp_comments,

					`sp_status` = :sp_status,

					`sp_modified_date` = :sp_modified_date,  

					`modified_by_admin` = :modified_by_admin  

					WHERE `sp_id` = :sp_id AND `vendor_id` = :vendor_id";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':shipping_price' => addslashes($tdata['shipping_price']), ':min_order_amount' => addslashes($tdata['min_order_amount']), ':max_order_amount' => addslashes($tdata['max_order_amount']), ':sp_type' => addslashes($tdata['sp_type']), ':sp_percentage' => addslashes($tdata['sp_percentage']), ':sp_min_qty_id' => addslashes($tdata['sp_min_qty_id']), ':sp_min_qty_val' => addslashes($tdata['sp_min_qty_val']), ':sp_max_qty_id' => addslashes($tdata['sp_max_qty_id']), ':sp_max_qty_val' => addslashes($tdata['sp_max_qty_val']), ':sp_applied_on' => addslashes($tdata['sp_applied_on']), ':sp_effective_date' => addslashes($tdata['sp_effective_date']), ':sp_country_id' => addslashes($tdata['sp_country_id']), ':sp_state_id' => addslashes($tdata['sp_state_id']), ':sp_city_id' => addslashes($tdata['sp_city_id']), ':sp_area_id' => addslashes($tdata['sp_area_id']), ':sp_comments' => addslashes($tdata['sp_comments']), ':sp_status' => addslashes($tdata['sp_status']), ':sp_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':sp_id' => $tdata['sp_id'], ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateShippingPrice] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateCancellationPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcancellationprices` SET 

					`cp_title` = :cp_title,

					`cancellation_price` = :cancellation_price,

					`min_cancellation_amount` = :min_cancellation_amount,

					`max_cancellation_amount` = :max_cancellation_amount,

					`cp_type` = :cp_type,

					`cp_percentage` = :cp_percentage,

					`cp_min_qty_id` = :cp_min_qty_id,

					`cp_min_qty_val` = :cp_min_qty_val,

					`cp_max_qty_id` = :cp_max_qty_id,

					`cp_max_qty_val` = :cp_max_qty_val,

					`cp_min_hrs` = :cp_min_hrs,

					`cp_max_hrs` = :cp_max_hrs,

					`cp_applied_on` = :cp_applied_on,

					`cp_effective_date` = :cp_effective_date,

					`cp_comments` = :cp_comments,

					`cp_status` = :cp_status,

					`cp_modified_date` = :cp_modified_date,  

					`modified_by_admin` = :modified_by_admin  

					WHERE `cp_id` = :cp_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cp_title' => addslashes($tdata['cp_title']), ':cancellation_price' => addslashes($tdata['cancellation_price']), ':min_cancellation_amount' => addslashes($tdata['min_cancellation_amount']), ':max_cancellation_amount' => addslashes($tdata['max_cancellation_amount']), ':cp_type' => addslashes($tdata['cp_type']), ':cp_percentage' => addslashes($tdata['cp_percentage']), ':cp_min_qty_id' => addslashes($tdata['cp_min_qty_id']), ':cp_min_qty_val' => addslashes($tdata['cp_min_qty_val']), ':cp_max_qty_id' => addslashes($tdata['cp_max_qty_id']), ':cp_max_qty_val' => addslashes($tdata['cp_max_qty_val']), ':cp_min_hrs' => addslashes($tdata['cp_min_hrs']), ':cp_max_hrs' => addslashes($tdata['cp_max_hrs']), ':cp_applied_on' => addslashes($tdata['cp_applied_on']), ':cp_effective_date' => addslashes($tdata['cp_effective_date']), ':cp_comments' => addslashes($tdata['cp_comments']), ':cp_status' => addslashes($tdata['cp_status']), ':cp_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':cp_id' => $tdata['cp_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateCancellationPrice] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getTaxTypeOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Types</option>';
        } else {
            $output.= '<option value="" selected>Select Type</option>';
        }
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise', 'Inclusive in price');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getTaxTypeString($status) {
        $output = '';
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise', 'Inclusive in price');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getTaxAppliedOnOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Options</option>';
        } else {
            $output.= '<option value="" selected>Select Option</option>';
        }
        $arr_order_status = array('On Subtotal', 'On (Subtotal - Discount)', 'On (Subtotal - Discount) + Shipping', 'On Final Amount');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getTaxAppliedOnString($status) {
        $output = '';
        $arr_order_status = array('On Subtotal', 'On (Subtotal - Discount)', 'On (Subtotal - Discount) + Shipping', 'On Final Amount');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getShippingTypeOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Types</option>';
        } else {
            $output.= '<option value="" selected>Select Type</option>';
        }
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise', 'Inclusive in price');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getShippingTypeString($status) {
        $output = '';
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise', 'Inclusive in price');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getCancellationTypeOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Types</option>';
        } else {
            $output.= '<option value="" selected>Select Type</option>';
        }
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getCancellationTypeString($status) {
        $output = '';
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getDiscountCouponTypeOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Types</option>';
        } else {
            $output.= '<option value="" selected>Select Type</option>';
        }
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getDiscountCouponTypeString($status) {
        $output = '';
        $arr_order_status = array('Amount wise', 'Percentage wise', 'Quantity wise');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getShippingAppliedOnOption($sp_type, $status, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Options</option>';
        } else {
            $output.= '<option value="" selected>Select Option</option>';
        }
        if ($sp_type == '2') {
            try {
                $sql = "SELECT cat_id , cat_name FROM `tblcategories` WHERE `parent_cat_id` = '197' AND `cat_deleted` = '0' ORDER BY cat_name ASC";
                //$this->debuglog('[getShippingAppliedOnOption] sql:'.$sql);
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($r['cat_id'] == $status) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                        $output.= '<option value="' . $r['cat_id'] . '" ' . $selected . '>' . stripslashes($r['cat_name']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getShippingAppliedOnOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        } else {
            //$arr_order_status = array('On Subtotal','On (Subtotal - Discount)','On Final Amount');
            $arr_order_status = array('On Subtotal', 'On (Subtotal - Discount)');
            for ($i = 0;$i < count($arr_order_status);$i++) {
                //echo '<br>status:'.$status;
                if ($i == $status && $status != '') {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
            }
        }
        return $output;
    }
    public function getShippingAppliedOnString($sp_type, $status) {
        $output = '';
        if ($sp_type == '2') {
            $output = $this->getCategoryName($status);
        } else {
            //$arr_order_status = array('On Subtotal','On (Subtotal - Discount)','On Final Amount');
            $arr_order_status = array('On Subtotal', 'On (Subtotal - Discount)');
            if (array_key_exists($status, $arr_order_status)) {
                $output = $arr_order_status[$status];
            }
        }
        return $output;
    }
    public function getCancellationAppliedOnOption($cp_type, $status, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Options</option>';
        } else {
            $output.= '<option value="" selected>Select Option</option>';
        }
        if ($cp_type == '2') {
            try {
                $sql = "SELECT cat_id , cat_name FROM `tblcategories` WHERE `parent_cat_id` = '197' AND `cat_deleted` = '0' ORDER BY cat_name ASC";
                //$this->debuglog('[getCancellationAppliedOnOption] sql:'.$sql);
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($r['cat_id'] == $status) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                        $output.= '<option value="' . $r['cat_id'] . '" ' . $selected . '>' . stripslashes($r['cat_name']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getCancellationAppliedOnOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        } else {
            //$arr_order_status = array('On Subtotal','On (Subtotal - Discount)','On Final Amount');
            $arr_order_status = array('On Subtotal', 'On Final Amount');
            for ($i = 0;$i < count($arr_order_status);$i++) {
                //echo '<br>status:'.$status;
                if ($i == $status && $status != '') {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
            }
        }
        return $output;
    }
    public function getCancellationAppliedOnString($cp_type, $status) {
        $output = '';
        if ($cp_type == '2') {
            $output = $this->getCategoryName($status);
        } else {
            //$arr_order_status = array('On Subtotal','On (Subtotal - Discount)','On Final Amount');
            $arr_order_status = array('On Subtotal', 'On Final Amount');
            if (array_key_exists($status, $arr_order_status)) {
                $output = $arr_order_status[$status];
            }
        }
        return $output;
    }
    public function getDiscountCouponAppliedOnOption($dc_type, $status, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Options</option>';
        } else {
            $output.= '<option value="" selected>Select Option</option>';
        }
        if ($dc_type == '2') {
            try {
                $sql = "SELECT cat_id , cat_name FROM `tblcategories` WHERE `parent_cat_id` = '197' AND `cat_deleted` = '0' ORDER BY cat_name ASC";
                //$this->debuglog('[getDiscountCouponAppliedOnOption] sql:'.$sql);
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($r['cat_id'] == $status) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                        $output.= '<option value="' . $r['cat_id'] . '" ' . $selected . '>' . stripslashes($r['cat_name']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getDiscountCouponAppliedOnOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        } else {
            $arr_order_status = array('On Subtotal', 'On Final Amount');
            for ($i = 0;$i < count($arr_order_status);$i++) {
                //echo '<br>status:'.$status;
                if ($i == $status && $status != '') {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
            }
        }
        return $output;
    }
    public function getDiscountCouponAppliedOnString($dc_type, $status) {
        $output = '';
        if ($dc_type == '2') {
            $output = $this->getCategoryName($status);
        } else {
            $arr_order_status = array('On Subtotal', 'On Final Amount');
            if (array_key_exists($status, $arr_order_status)) {
                $output = $arr_order_status[$status];
            }
        }
        return $output;
    }
    public function getMultiUserRedeamedOption($status, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Options</option>';
        } else {
            $output.= '<option value="" selected>Select Option</option>';
        }
        $arr_order_status = array('No', 'Yes');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getAllTaxes($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $tax_type = '', $tax_qty_id = '', $tax_effective_date = '', $tax_applied_on = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `tax_name` = '" . $txtsearch . "'  )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND tax_status = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(tax_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(tax_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(tax_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(tax_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(tax_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( tax_country_id = '" . $country_id . "' OR tax_country_id = '-1' OR  FIND_IN_SET(" . $country_id . ", tax_country_id) > 0  )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( tax_state_id = '" . $state_id . "' OR tax_state_id = '-1' OR  FIND_IN_SET(" . $state_id . ", tax_state_id) > 0  ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( tax_city_id = '" . $city_id . "' OR tax_city_id = '-1' OR  FIND_IN_SET(" . $city_id . ", tax_city_id) > 0  ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( tax_area_id = '" . $area_id . "' OR tax_area_id = '-1' OR tax_area_id = '-1' OR  FIND_IN_SET(" . $area_id . ", tax_area_id) > 0 ) ";
        }
        $sql_tax_type_str = "";
        $sql_tax_qty_id_str = "";
        if ($tax_type != '') {
            $sql_tax_type_str = " AND ( tax_type = '" . $tax_type . "' ) ";
            if ($tax_type == '2') {
                if ($tax_qty_id != '') {
                    $sql_tax_qty_id_str = " AND ( tax_qty_id = '" . $tax_qty_id . "' ) ";
                }
            }
        }
        $sql_tax_effective_date_str = "";
        if ($tax_effective_date != '') {
            $sql_tax_effective_date_str = " AND ( tax_effective_date <= '" . $tax_effective_date . "' ) ";
        }
        $sql_tax_applied_on_str = "";
        if ($tax_applied_on != '') {
            $sql_tax_applied_on_str = " AND ( tax_applied_on <= '" . $tax_applied_on . "' ) ";
        }
        $sql = "SELECT * FROM `tbltaxes` 

				WHERE `tax_deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_tax_type_str . " " . $sql_tax_qty_id_str . " " . $sql_tax_effective_date_str . " " . $sql_tax_applied_on_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY tax_name ASC,tax_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function deleteTax($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbltaxes` SET 

					`tax_deleted` = :tax_deleted,

					`tax_modified_date` = :tax_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `tax_id` = :tax_id AND `tax_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':tax_deleted' => '1', ':tax_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':tax_id' => $tdata['tax_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteTax] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addTax($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tbltaxes` (`tax_name`,`tax_type`,`tax_amount`,`tax_percentage`,`tax_qty_id`,`tax_qty_val`,`tax_applied_on`,

					`tax_effective_date`,`tax_country_id`,`tax_state_id`,`tax_city_id`,`tax_area_id`,`tax_comments`,`tax_status`,`tax_add_date`,`added_by_admin`) 

					VALUES (:tax_name,:tax_type,:tax_amount,:tax_percentage,:tax_qty_id,:tax_qty_val,:tax_applied_on,

					:tax_effective_date,:tax_country_id,:tax_state_id,:tax_city_id,:tax_area_id,:tax_comments,:tax_status,:tax_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':tax_name' => addslashes($tdata['tax_name']), ':tax_type' => addslashes($tdata['tax_type']), ':tax_amount' => addslashes($tdata['tax_amount']), ':tax_percentage' => addslashes($tdata['tax_percentage']), ':tax_qty_id' => addslashes($tdata['tax_qty_id']), ':tax_qty_val' => addslashes($tdata['tax_qty_val']), ':tax_applied_on' => addslashes($tdata['tax_applied_on']), ':tax_effective_date' => addslashes($tdata['tax_effective_date']), ':tax_country_id' => addslashes($tdata['tax_country_id']), ':tax_state_id' => addslashes($tdata['tax_state_id']), ':tax_city_id' => addslashes($tdata['tax_city_id']), ':tax_area_id' => addslashes($tdata['tax_area_id']), ':tax_comments' => addslashes($tdata['tax_comments']), ':tax_status' => addslashes($tdata['tax_status']), ':tax_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $sp_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($sp_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addTax] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getTaxDetails($tax_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tbltaxes` WHERE `tax_id` = '" . $tax_id . "' AND `tax_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function updateTax($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbltaxes` SET 

					`tax_name` = :tax_name,

					`tax_type` = :tax_type,

					`tax_amount` = :tax_amount,

					`tax_percentage` = :tax_percentage,

					`tax_qty_id` = :tax_qty_id,

					`tax_qty_val` = :tax_qty_val,

					`tax_applied_on` = :tax_applied_on,

					`tax_effective_date` = :tax_effective_date,

					`tax_country_id` = :tax_country_id,

					`tax_state_id` = :tax_state_id,

					`tax_city_id` = :tax_city_id,

					`tax_area_id` = :tax_area_id,

					`tax_comments` = :tax_comments,

					`tax_status` = :tax_status,

					`tax_modified_date` = :tax_modified_date,  

					`modified_by_admin` = :modified_by_admin  

					WHERE `tax_id` = :tax_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':tax_name' => addslashes($tdata['tax_name']), ':tax_type' => addslashes($tdata['tax_type']), ':tax_amount' => addslashes($tdata['tax_amount']), ':tax_percentage' => addslashes($tdata['tax_percentage']), ':tax_qty_id' => addslashes($tdata['tax_qty_id']), ':tax_qty_val' => addslashes($tdata['tax_qty_val']), ':tax_applied_on' => addslashes($tdata['tax_applied_on']), ':tax_effective_date' => addslashes($tdata['tax_effective_date']), ':tax_country_id' => addslashes($tdata['tax_country_id']), ':tax_state_id' => addslashes($tdata['tax_state_id']), ':tax_city_id' => addslashes($tdata['tax_city_id']), ':tax_area_id' => addslashes($tdata['tax_area_id']), ':tax_comments' => addslashes($tdata['tax_comments']), ':tax_status' => addslashes($tdata['tax_status']), ':tax_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':tax_id' => $tdata['tax_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateTax] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getContactUsParentCategoryOption($cat_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql_cat_id_str = " AND cat_id IN (11,150,151,152,157,163)";
        if ($type == '2') {
            $output.= '<option value="" >All Categories</option>';
        } else {
            $output.= '<option value="" >Select Category</option>';
        }
        try {
            $sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '0' AND `cat_deleted` = '0' " . $sql_cat_id_str . " ORDER BY cat_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['cat_id'] == $cat_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['cat_id'] . '" ' . $selected . '>' . stripslashes($r['cat_name']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getContactUsParentCategoryOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getContactUsSpecialityOption($cat_id, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        $parent_cat_id = "1";
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $cat_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Specialities</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Specialities</option>';
            }
        } else {
            if ($multiple == '1') {
                if (in_array('', $cat_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="" ' . $selected . ' >Select Speciality</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >Select Speciality</option>';
            }
        }
        try {
            $sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '" . $parent_cat_id . "' AND `cat_deleted` = '0' ORDER BY cat_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($multiple == '1') {
                        if (in_array($r['cat_id'], $cat_id)) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    } else {
                        if ($r['cat_id'] == $cat_id) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    }
                    $output.= '<option value="' . $r['cat_id'] . '" ' . $selected . '>' . stripslashes($r['cat_name']) . '</option>';
                }
            }
            if ($multiple == '1') {
                if (in_array('999999999', $cat_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ('999999999' == $cat_id) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="999999999" ' . $selected . '>Others</option>';
        }
        catch(Exception $e) {
            $stringData = '[getContactUsSpecialityOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getContactUsItemOption($item_id, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $item_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Items</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Items</option>';
            }
        } else {
            if ($multiple == '1') {
                if (in_array('', $item_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="" ' . $selected . ' >Select Item</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >Select Item</option>';
            }
        }
        try {
            $sql = "SELECT item_id,item_name FROM `tblitems` WHERE `item_deleted` = '0' AND `item_id` NOT IN (SELECT DISTINCT(item_id) FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `ic_cat_id` = '54' ) ORDER BY item_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($multiple == '1') {
                        if (in_array($r['item_id'], $item_id)) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    } else {
                        if ($r['item_id'] == $item_id) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    }
                    $output.= '<option value="' . $r['item_id'] . '" ' . $selected . '>' . stripslashes($r['item_name']) . '</option>';
                }
            }
            if ($multiple == '1') {
                if (in_array('999999999', $item_id)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            } else {
                if ('999999999' == $item_id) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
            }
            $output.= '<option value="999999999" ' . $selected . '>Others</option>';
        }
        catch(Exception $e) {
            $stringData = '[getContactUsItemOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getAllContactUs($txtsearch = '', $status = '', $contactus_parent_cat_id = '', $contactus_cat_id = '', $contactus_speciality_id = '', $contactus_item_id = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( contactus_name LIKE '%" . $txtsearch . "%' OR contactus_email LIKE '%" . $txtsearch . "%' OR contactus_contact_no LIKE '%" . $txtsearch . "%'  )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND cu_status = '" . $status . "' ";
        }
        $sql_contactus_parent_cat_id_str = "";
        if ($contactus_parent_cat_id != '') {
            $sql_contactus_parent_cat_id_str = " AND contactus_parent_cat_id = '" . $contactus_parent_cat_id . "' ";
        }
        $sql_contactus_cat_id_str = "";
        if ($contactus_cat_id != '') {
            $sql_contactus_cat_id_str = " AND contactus_cat_id = '" . $contactus_cat_id . "' ";
        }
        $sql_contactus_speciality_id_str = "";
        if ($contactus_speciality_id != '') {
            $sql_contactus_speciality_id_str = " AND contactus_speciality_id = '" . $contactus_speciality_id . "' ";
        }
        $sql_contactus_item_id_str = "";
        if ($contactus_item_id != '') {
            $sql_contactus_item_id_str = " AND contactus_item_id = '" . $contactus_item_id . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(cu_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(cu_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cu_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(cu_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(cu_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND cu_id IN ( SELECT TCU.cu_id FROM `tblcontactus` AS TCU LEFT JOIN `tblcities` AS TCT ON TCU.contactus_city_id = TCT.city_id  WHERE TCT.country_id = '" . $country_id . "' AND  TCU.cu_deleted = '0' AND TCT.city_deleted = '0')";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND cu_id IN ( SELECT TCU.cu_id FROM `tblcontactus` AS TCU LEFT JOIN `tblcities` AS TCT ON TCU.contactus_city_id = TCT.city_id  WHERE TCT.state_id = '" . $state_id . "' AND  TCU.cu_deleted = '0' AND TCT.city_deleted = '0')";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( contactus_city_id = '" . $city_id . "' ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( contactus_area_id = '" . $area_id . "' ) ";
        }
        $sql = "SELECT * FROM `tblcontactus`   

				WHERE cu_deleted = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_contactus_parent_cat_id_str . " " . $sql_contactus_cat_id_str . " " . $sql_contactus_speciality_id_str . " " . $sql_contactus_item_id_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_add_date_str . "  ORDER BY cu_add_date DESC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getTopLocationStr($city_id, $area_id = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            if ($area_id == '' || $area_id == '-1' || $area_id == '0') {
                $sql = "SELECT TCT.city_name,TST.state_name,TCN.country_name FROM `tblcities` AS TCT

					LEFT JOIN `tblstates` AS TST ON TCT.state_id = TST.state_id 

					LEFT JOIN `tblcountry` AS TCN ON TCT.country_id = TCN.country_id 

					WHERE TCT.city_id = '" . $city_id . "' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";
            } else {
                $sql = "SELECT TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblarea` AS TAR

					LEFT JOIN `tblcities` AS TCT ON TAR.city_id = TCT.city_id 

					LEFT JOIN `tblstates` AS TST ON TAR.state_id = TST.state_id 

					LEFT JOIN `tblcountry` AS TCN ON TAR.country_id = TCN.country_id 

					WHERE TAR.area_id = '" . $area_id . "' AND TAR.area_deleted = '0' AND TAR.area_status = '1' AND TCT.city_id = '" . $city_id . "' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";
            }
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($area_id == '' || $area_id == '-1' || $area_id == '0') {
                        //$output = stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);
                        $output = stripslashes($r['city_name']);
                    } else {
                        //$output = stripslashes($r['area_name']).', '.stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);
                        $output = stripslashes($r['area_name']) . ', ' . stripslashes($r['city_name']);
                    }
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getTopLocationStr] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getCusineLocationStr($city_id, $area_id = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            if ($area_id == '' || $area_id == '-1' || $area_id == '0') {
                $sql = "SELECT TCT.city_name,TST.state_name,TCN.country_name FROM `tblcities` AS TCT

					LEFT JOIN `tblstates` AS TST ON TCT.state_id = TST.state_id 

					LEFT JOIN `tblcountry` AS TCN ON TCT.country_id = TCN.country_id 

					WHERE TCT.city_id = '" . $city_id . "' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";
            } else {
                $sql = "SELECT TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblarea` AS TAR

					LEFT JOIN `tblcities` AS TCT ON TAR.city_id = TCT.city_id 

					LEFT JOIN `tblstates` AS TST ON TAR.state_id = TST.state_id 

					LEFT JOIN `tblcountry` AS TCN ON TAR.country_id = TCN.country_id 

					WHERE TAR.area_id = '" . $area_id . "' AND TAR.area_deleted = '0' AND TAR.area_status = '1' AND TCT.city_id = '" . $city_id . "' AND TCT.city_deleted = '0' AND TCT.city_status = '1' AND TST.state_deleted = '0' AND TST.state_status = '1' AND TCN.country_deleted = '0' AND TCN.country_status = '1' ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";
            }
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($area_id == '' || $area_id == '-1' || $area_id == '0') {
                        //$output = stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);
                        $output = 'All Area, ' . stripslashes($r['city_name']);
                    } else {
                        //$output = stripslashes($r['area_name']).', '.stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']);
                        $output = stripslashes($r['area_name']) . ', ' . stripslashes($r['city_name']);
                    }
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getCusineLocationStr] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getCommaSepratedCategoryName($cat_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT cat_name FROM `tblcategories` WHERE `cat_id` IN (" . $cat_id . ") AND `cat_deleted` = '0' ORDER BY cat_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $output.= stripslashes($r['cat_name']) . ', ';
                }
                $output = substr($output, 0, -2);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCommaSepratedCategoryName] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getCommaSepratedItemName($item_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT item_name FROM `tblitems` WHERE `item_id` IN (" . $item_id . ") AND `item_deleted` = '0' ORDER BY item_name ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $output.= stripslashes($r['item_name']) . ', ';
                }
                $output = substr($output, 0, -2);
            }
        }
        catch(Exception $e) {
            $stringData = '[getCommaSepratedItemName] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function deleteContactUs($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblcontactus` SET 

					`cu_deleted` = :cu_deleted,

					`cu_modified_date` = :cu_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `cu_id` = :cu_id AND `cu_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cu_deleted' => '1', ':cu_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':cu_id' => $tdata['cu_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteContactUs] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getContactUsDetails($cu_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblcontactus` WHERE `cu_id` = '" . $cu_id . "' AND `cu_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getOrderInvoiceOption($invoice, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            if ($multiple == '1') {
                if (in_array('-1', $invoice)) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="-1" ' . $selected . ' >All Invoices</option>';
            } else {
                $selected = '';
                $output.= '<option value="" ' . $selected . ' >All Invoices</option>';
            }
        } else {
            $output.= '<option value="" >Select Invoice</option>';
        }
        try {
            $sql = "SELECT invoice,user_name,order_add_date FROM `tblorders` WHERE `payment_status` = '1' ORDER BY order_add_date DESC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($multiple == '1') {
                        if (in_array($r['invoice'], $invoice)) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    } else {
                        if ($r['invoice'] == $invoice) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                    }
                    $show_str = stripslashes($r['invoice']) . '- (' . date('d-M-Y', strtotime($r['order_add_date'])) . ') - (' . stripslashes($r['user_name']) . ')';
                    $output.= '<option value="' . $r['invoice'] . '" ' . $selected . '>' . $show_str . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getOrderInvoiceOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getInvoiceStrWithNameAnddate($invoice) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT invoice,user_name,order_add_date FROM `tblorders` WHERE `invoice` = '" . $invoice . "' ORDER BY order_add_date DESC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $output = stripslashes($r['invoice']) . '- (' . date('d-M-Y', strtotime($r['order_add_date'])) . ') - (' . stripslashes($r['user_name']) . ')';
            }
        }
        catch(Exception $e) {
            $stringData = '[getInvoiceStrWithNameAnddate] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getLogisticPartnerTypeOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Types</option>';
        } else {
            $output.= '<option value="" selected>Select Type</option>';
        }
        $arr_order_status = array('3rd party vendors', 'In-house staff');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getLogisticPartnerTypeString($status) {
        $output = '';
        $arr_order_status = array('3rd party vendors', 'In-house staff');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function getLogisticPartnerOption($vendor_cat_id, $vendor_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Partners</option>';
        } else {
            $output.= '<option value="" >Select Partner</option>';
        }
        try {
            if ($vendor_cat_id != '') {
                $sql = "SELECT vendor_id,vendor_name FROM `tblvendors` WHERE `vendor_cat_id` = '" . $vendor_cat_id . "' AND `vendor_deleted` = '0' ORDER BY vendor_name ASC";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($r['vendor_id'] == $vendor_id) {
                            $selected = ' selected ';
                        } else {
                            $selected = '';
                        }
                        $output.= '<option value="' . $r['vendor_id'] . '" ' . $selected . '>' . stripslashes($r['vendor_name']) . '</option>';
                    }
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getLogisticPartnerOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getOrderDeiveryStatusOption($status, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" selected>All Status</option>';
        } else {
            $output.= '<option value="" selected>Select Status</option>';
        }
        $arr_order_status = array('Ready to deliver', 'Delivered Successfully', 'Partial Delivered', 'Recipient not avilabled', 'Delivered to other recipient');
        for ($i = 0;$i < count($arr_order_status);$i++) {
            //echo '<br>status:'.$status;
            if ($i == $status && $status != '') {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . stripslashes($arr_order_status[$i]) . '</option>';
        }
        return $output;
    }
    public function getOrderDeiveryStatusString($status) {
        $output = '';
        $arr_order_status = array('Ready to deliver', 'Delivered Successfully', 'Partial Delivered', 'Recipient not avilabled', 'Delivered to other recipient');
        if (array_key_exists($status, $arr_order_status)) {
            $output = $arr_order_status[$status];
        }
        return $output;
    }
    public function addOrderDelivery($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblorderdelivery` (`invoice`,`order_item_id`,`delivery_date`,`logistic_partner_type`,`logistic_partner_id`,`delivery_person_name`,`delivery_person_contact_no`,`reciever_name`,

					`reciever_contact_no`,`other_reciever_name`,`other_reciever_contact_no`,`delivery_status`,`proof_of_delivery`,`consignment_note`,`other_comments`,

					`delivery_add_date`,`added_by_admin`) 

					VALUES (:invoice,:order_item_id,:delivery_date,:logistic_partner_type,:logistic_partner_id,:delivery_person_name,:delivery_person_contact_no,:reciever_name,

					:reciever_contact_no,:other_reciever_name,:other_reciever_contact_no,:delivery_status,:proof_of_delivery,:consignment_note,:other_comments,

					:delivery_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':invoice' => addslashes($tdata['invoice']), ':order_item_id' => addslashes($tdata['order_item_id']), ':delivery_date' => addslashes($tdata['delivery_date']), ':logistic_partner_type' => addslashes($tdata['logistic_partner_type']), ':logistic_partner_id' => addslashes($tdata['logistic_partner_id']), ':delivery_person_name' => addslashes($tdata['delivery_person_name']), ':delivery_person_contact_no' => addslashes($tdata['delivery_person_contact_no']), ':reciever_name' => addslashes($tdata['reciever_name']), ':reciever_contact_no' => addslashes($tdata['reciever_contact_no']), ':other_reciever_name' => addslashes($tdata['other_reciever_name']), ':other_reciever_contact_no' => addslashes($tdata['other_reciever_contact_no']), ':delivery_status' => addslashes($tdata['delivery_status']), ':proof_of_delivery' => addslashes($tdata['proof_of_delivery']), ':consignment_note' => addslashes($tdata['consignment_note']), ':other_comments' => addslashes($tdata['other_comments']), ':delivery_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $od_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($od_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addOrderDelivery] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllOrderDelivery($txtsearch = '', $delivery_status = '', $delivery_date = '', $logistic_partner_type = '', $logistic_partner_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $vendor_id = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `invoice` = '" . $txtsearch . "'   )";
        }
        $sql_delivery_status_str = "";
        if ($delivery_status != '') {
            $sql_delivery_status_str = " AND delivery_status = '" . $delivery_status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(delivery_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(delivery_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(delivery_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(delivery_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(delivery_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_logistic_partner_type_str = "";
        $sql_logistic_partner_id_str = "";
        if ($logistic_partner_type != '') {
            $sql_logistic_partner_type_str = " AND ( logistic_partner_type = '" . $logistic_partner_type . "' ) ";
            if ($logistic_partner_type != '158') {
                if ($logistic_partner_id != '') {
                    $sql_logistic_partner_id_str = " AND ( logistic_partner_id = '" . $logistic_partner_id . "' ) ";
                }
            }
        }
        $sql_delivery_date_str = "";
        if ($delivery_date != '') {
            $sql_delivery_date_str = " AND ( delivery_date = '" . date('Y-m-d', strtotime($delivery_date)) . "' ) ";
        }
        $sql_vendor_id_str = "";
        if ($vendor_id != '') {
            $sql_vendor_id_str = " AND invoice IN (SELECT DISTINCT(invoice) FROM tblordercart WHERE prod_id IN (SELECT DISTINCT(cusine_id) FROM tblcusines WHERE vendor_id = '" . $vendor_id . "' AND cusine_deleted = '0' ) ) ";
        }
        $sql = "SELECT * FROM `tblorderdelivery` 

				WHERE `delivery_deleted` = '0' " . $sql_vendor_id_str . " " . $sql_search_str . " " . $sql_delivery_status_str . " " . $sql_delivery_date_str . " " . $sql_logistic_partner_type_str . " " . $sql_logistic_partner_id_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY delivery_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function deleteOrderDelivery($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblorderdelivery` SET 

					`delivery_deleted` = :delivery_deleted,

					`delivery_modified_date` = :delivery_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `od_id` = :od_id AND `delivery_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':delivery_deleted' => '1', ':delivery_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':od_id' => $tdata['od_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteOrderDelivery] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getOrderDeliveryDetails($od_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblorderdelivery` WHERE `od_id` = '" . $od_id . "' AND `delivery_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function updateOrderDelivery($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblorderdelivery` SET 

					`delivery_date` = :delivery_date,

					`logistic_partner_type` = :logistic_partner_type,

					`logistic_partner_id` = :logistic_partner_id,

					`delivery_person_name` = :delivery_person_name,

					`delivery_person_contact_no` = :delivery_person_contact_no,

					`reciever_name` = :reciever_name,

					`reciever_contact_no` = :reciever_contact_no,

					`other_reciever_name` = :other_reciever_name,

					`other_reciever_contact_no` = :other_reciever_contact_no,

					`delivery_status` = :delivery_status,

					`proof_of_delivery` = :proof_of_delivery,

					`consignment_note` = :consignment_note,

					`other_comments` = :other_comments,

					`delivery_modified_date` = :delivery_modified_date,  

					`modified_by_admin` = :modified_by_admin

					

					WHERE `od_id` = :od_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':delivery_date' => addslashes($tdata['delivery_date']), ':logistic_partner_type' => addslashes($tdata['logistic_partner_type']), ':logistic_partner_id' => addslashes($tdata['logistic_partner_id']), ':delivery_person_name' => addslashes($tdata['delivery_person_name']), ':delivery_person_contact_no' => addslashes($tdata['delivery_person_contact_no']), ':reciever_name' => addslashes($tdata['reciever_name']), ':reciever_contact_no' => addslashes($tdata['reciever_contact_no']), ':other_reciever_name' => addslashes($tdata['other_reciever_name']), ':other_reciever_contact_no' => addslashes($tdata['other_reciever_contact_no']), ':delivery_status' => addslashes($tdata['delivery_status']), ':proof_of_delivery' => addslashes($tdata['proof_of_delivery']), ':consignment_note' => addslashes($tdata['consignment_note']), ':other_comments' => addslashes($tdata['other_comments']), ':delivery_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':od_id' => $tdata['od_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateOrderDelivery] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteUser($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblusers` SET 

					`user_deleted` = :user_deleted,

					`user_modified_date` = :user_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `user_id` = :user_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':user_deleted' => '1', ':user_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['admin_id'], ':user_id' => $tdata['user_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteUser] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllUsers($txtsearch = '', $status = '', $user_blocked = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $cc_user_id = $this->getUserIdFromCustomerCode($txtsearch);
            if ($cc_user_id != '') {
                $sql_search_str = " AND ( TBU.first_name LIKE '%" . $txtsearch . "%' OR TBU.last_name LIKE '%" . $txtsearch . "%' OR TBU.email LIKE '%" . $txtsearch . "%' OR TBU.mobile_no LIKE '%" . $txtsearch . "%' OR TBU.user_id = '" . $cc_user_id . "' ) ";
            } else {
                $sql_search_str = " AND ( TBU.first_name LIKE '%" . $txtsearch . "%' OR TBU.last_name LIKE '%" . $txtsearch . "%' OR TBU.email LIKE '%" . $txtsearch . "%' OR TBU.mobile_no LIKE '%" . $txtsearch . "%' ) ";
            }
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TBU.user_status = '" . $status . "' ";
        }
        $sql_user_blocked_str = "";
        if ($user_blocked != '') {
            $sql_user_blocked_str = " AND TBU.user_blocked = '" . $user_blocked . "' ";
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND TBU.country_id = '" . $country_id . "' ";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND TBU.state_id = '" . $state_id . "' ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND TBU.city_id = '" . $city_id . "' ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND TBU.area_id = '" . $area_id . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND TBU.added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(TBU.user_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(TBU.user_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TBU.user_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(TBU.user_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(TBU.user_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT TBU.* ,

				(SELECT country_name FROM `tblcountry` WHERE `country_id` = TBU.country_id ) AS country_name,

				(SELECT state_name FROM `tblstates` WHERE `state_id` = TBU.state_id ) AS state_name,

				(SELECT city_name FROM `tblcities` WHERE `city_id` = TBU.city_id ) AS city_name,

				(SELECT area_name FROM `tblarea` WHERE `area_id` = TBU.area_id ) AS area_name 

				FROM `tblusers` AS TBU WHERE TBU.user_deleted = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_user_blocked_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "     

				ORDER BY TBU.user_add_date DESC ";
        //$this->debuglog('[getAllUsers] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function chkEmailExists($email) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            //add user deleted key in table
            $sql = "SELECT * FROM `tblusers` WHERE `email` = '" . $email . "' AND `user_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkEmailExists] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkEmailExists_Edit($email, $user_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblusers` WHERE `email` = '" . $email . "' AND `user_id` != '" . $user_id . "' AND `user_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkEmailExists_Edit] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkMobileNoExists($mobile_no) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblusers` WHERE `mobile_no` = '" . $mobile_no . "' AND `user_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkMobileNoExists] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function chkMobileNoExists_Edit($mobile_no, $user_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        try {
            $sql = "SELECT * FROM `tblusers` WHERE `mobile_no` = '" . $mobile_no . "' AND `user_id` != '" . $user_id . "' AND `user_deleted` = '0' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[chkMobileNoExists_Edit] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addUser($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblusers` (`first_name`,`last_name`,`email`,`password`,`mobile_no`,`building_name`,`floor_no`,`landmark`,`address`,`country_id`,

					`state_id`,`city_id`,`area_id`,`user_status`,`user_add_date`,`added_by_admin`) 

					VALUES (:first_name,:last_name,:email,:password,:mobile_no,:building_name,:floor_no,:landmark,:address,:country_id,

					:state_id,:city_id,:area_id,:user_status,:user_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':first_name' => addslashes($tdata['first_name']), ':last_name' => addslashes($tdata['last_name']), ':email' => addslashes($tdata['email']), ':password' => md5($tdata['password']), ':mobile_no' => addslashes($tdata['mobile_no']), ':building_name' => addslashes($tdata['building_name']), ':floor_no' => addslashes($tdata['floor_no']), ':landmark' => addslashes($tdata['landmark']), ':address' => addslashes($tdata['address']), ':country_id' => addslashes($tdata['country_id']), ':state_id' => addslashes($tdata['state_id']), ':city_id' => addslashes($tdata['city_id']), ':area_id' => addslashes($tdata['area_id']), ':user_status' => addslashes($tdata['user_status']), ':user_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => addslashes($tdata['admin_id'])));
            $return = $DBH->lastInsertId();
            $DBH->commit();
            if ($return > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addUser] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getUserDetails($user_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '" . $user_id . "' AND `user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function updateUser($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblusers` SET 

					`first_name` = :first_name,

					`last_name` = :last_name,

					`email` = :email,

					`mobile_no` = :mobile_no,

					`building_name` = :building_name,

					`floor_no` = :floor_no,

					`landmark` = :landmark,

					`address` = :address,  

					`country_id` = :country_id,  

					`state_id` = :state_id,  

					`city_id` = :city_id,  

					`area_id` = :area_id,

					`user_status` = :user_status,

					`user_blocked` = :user_blocked,

					`user_modified_date` = :user_modified_date,

					`modified_by_admin` = :modified_by_admin

					WHERE `user_id` = :user_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':first_name' => addslashes($tdata['first_name']), ':last_name' => addslashes($tdata['last_name']), ':email' => addslashes($tdata['email']), ':mobile_no' => addslashes($tdata['mobile_no']), ':building_name' => addslashes($tdata['building_name']), ':floor_no' => addslashes($tdata['floor_no']), ':landmark' => addslashes($tdata['landmark']), ':address' => addslashes($tdata['address']), ':country_id' => addslashes($tdata['country_id']), ':state_id' => addslashes($tdata['state_id']), ':city_id' => addslashes($tdata['city_id']), ':area_id' => addslashes($tdata['area_id']), ':user_status' => addslashes($tdata['user_status']), ':user_blocked' => addslashes($tdata['user_blocked']), ':user_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => addslashes($tdata['admin_id']), ':user_id' => $tdata['user_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateUser] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateUserPassword($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblusers` SET `password` = :password WHERE `user_id` = :user_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':password' => md5($tdata['password']), ':user_id' => $tdata['user_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateUserPassword] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAppliedCancellationPriceOption($cancel_request_date, $order_cart_delivery_date, $cp_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Options</option>';
        } else {
            $output.= '<option value="" >Select Option</option>';
        }
        try {
            $date = date('Y-m-d', strtotime($order_cart_delivery_date));
            $one_day_before_current_showing_date = date('Y-m-d', strtotime($date . ' -1 day'));
            $current_showing_date_time = $one_day_before_current_showing_date . ' 23:00:00';
            $timestamp_ocdd = strtotime($current_showing_date_time);
            $timestamp_crd = strtotime($cancel_request_date);
            $calculate_hrs = ($timestamp_ocdd - $timestamp_crd) / 3600;
            $today = date('Y-m-d');
            //$sql = "SELECT cp_id,cp_title FROM `tblcancellationprices` WHERE `cp_effective_date` <= '".$today."' AND `cp_min_hrs` <= '".$calculate_hrs."' AND `cp_max_hrs` >= '".$calculate_hrs."' AND `cp_status` = '1' AND `cp_deleted` = '0' ORDER BY cp_effective_date DESC";
            echo $sql = "SELECT cp_id,cp_title FROM `tblcancellationprices` WHERE `cp_effective_date` <= '" . $today . "' AND CAST(cp_min_hrs AS UNSIGNED) <= '" . $calculate_hrs . "' AND CAST(cp_max_hrs AS UNSIGNED) >= '" . $calculate_hrs . "' AND `cp_status` = '1' AND `cp_deleted` = '0' ORDER BY cp_effective_date DESC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['cp_id'] == $cp_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['cp_id'] . '" ' . $selected . '>' . stripslashes($r['cp_title']) . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getAppliedCancellationPriceOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function doCancelProcess($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblordercart` SET 

					`cp_id` = :cp_id,

					`cancellation_note` = :cancellation_note,

					`cp_sp_amount` = :cp_sp_amount,

					`cp_tax_amount` = :cp_tax_amount,

					`cp_amount` = :cp_amount,

					`prod_cancel_subtotal` = :prod_cancel_subtotal,

					`cancel_process_date` = :cancel_process_date,

					`cancel_process_by_admin` = :cancel_process_by_admin,

					`cancel_process_done` = :cancel_process_done

					WHERE `invoice` = :invoice AND `order_cart_id` = :order_cart_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cp_id' => addslashes($tdata['cp_id']), ':cancellation_note' => addslashes($tdata['cancellation_note']), ':cp_sp_amount' => addslashes($tdata['cp_sp_amount']), ':cp_tax_amount' => addslashes($tdata['cp_tax_amount']), ':cp_amount' => addslashes($tdata['cp_amount']), ':prod_cancel_subtotal' => addslashes($tdata['prod_cancel_subtotal']), ':cancel_process_date' => addslashes($tdata['cancel_process_date']), ':cancel_process_by_admin' => addslashes($tdata['cancel_process_by_admin']), ':cancel_process_done' => addslashes($tdata['cancel_process_done']), ':invoice' => $tdata['invoice'], ':order_cart_id' => $tdata['order_cart_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[doCancelProcess] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function generateRandomString($no_of_char = '') {
        if ($no_of_char == '') {
            $no_of_char = 8;
        }
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $return = "";
        for ($i = 0;$i < $no_of_char;$i++) {
            $return.= $chars[mt_rand(0, strlen($chars) - 1) ];
        }
        return $return;
    }
    public function chkIfDiscountCouponAlreadyExists($discount_coupon) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tbldiscountcoupons` WHERE `discount_coupon` = '" . $discount_coupon . "' AND `dc_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkIfDiscountCouponAlreadyExists_Edit($discount_coupon, $dc_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tbldiscountcoupons` WHERE `discount_coupon` = '" . $discount_coupon . "' AND `dc_id` != '" . $dc_id . "' AND `dc_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function generateDiscountCoupon() {
        $no_of_char = 8;
        $return = $this->generateRandomString($no_of_char);
        if ($this->chkIfDiscountCouponAlreadyExists($return)) {
            $return = $this->generateRandomString($no_of_char);
            if ($this->chkIfDiscountCouponAlreadyExists($return)) {
                $return = $this->generateRandomString($no_of_char);
                if ($this->chkIfDiscountCouponAlreadyExists($return)) {
                    $return = $this->generateRandomString($no_of_char);
                }
            }
        }
        return $return;
    }
    public function addDiscountCoupon($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tbldiscountcoupons` (`discount_coupon`,`discount_price`,`min_order_amount`,`max_order_amount`,`dc_type`,`dc_percentage`,

					`dc_min_qty_id`,`dc_min_qty_val`,`dc_max_qty_id`,`dc_max_qty_val`,`dc_applied_on`,`dc_effective_date_type`,`dc_effective_days_of_month`,

					`dc_effective_days_of_week`,`dc_effective_single_date`,`dc_effective_start_date`,`dc_effective_end_date`,`dc_country_id`,`dc_state_id`,

					`dc_city_id`,`dc_area_id`,`dc_comments`,`dc_multiuser`,`dc_status`,`dc_add_date`,`added_by_admin`,`dc_trade_discount`,`vendor_id`) 

					VALUES (:discount_coupon,:discount_price,:min_order_amount,:max_order_amount,:dc_type,:dc_percentage,

					:dc_min_qty_id,:dc_min_qty_val,:dc_max_qty_id,:dc_max_qty_val,:dc_applied_on,:dc_effective_date_type,:dc_effective_days_of_month,

					:dc_effective_days_of_week,:dc_effective_single_date,:dc_effective_start_date,:dc_effective_end_date,:dc_country_id,:dc_state_id,

					:dc_city_id,:dc_area_id,:dc_comments,:dc_multiuser,:dc_status,:dc_add_date,:added_by_admin,:dc_trade_discount,:vendor_id)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':discount_coupon' => addslashes($tdata['discount_coupon']), ':discount_price' => addslashes($tdata['discount_price']), ':min_order_amount' => addslashes($tdata['min_order_amount']), ':max_order_amount' => addslashes($tdata['max_order_amount']), ':dc_type' => addslashes($tdata['dc_type']), ':dc_percentage' => addslashes($tdata['dc_percentage']), ':dc_min_qty_id' => addslashes($tdata['dc_min_qty_id']), ':dc_min_qty_val' => addslashes($tdata['dc_min_qty_val']), ':dc_max_qty_id' => addslashes($tdata['dc_max_qty_id']), ':dc_max_qty_val' => addslashes($tdata['dc_max_qty_val']), ':dc_applied_on' => addslashes($tdata['dc_applied_on']), ':dc_effective_date_type' => addslashes($tdata['dc_effective_date_type']), ':dc_effective_days_of_month' => addslashes($tdata['dc_effective_days_of_month']), ':dc_effective_days_of_week' => addslashes($tdata['dc_effective_days_of_week']), ':dc_effective_single_date' => addslashes($tdata['dc_effective_single_date']), ':dc_effective_start_date' => addslashes($tdata['dc_effective_start_date']), ':dc_effective_end_date' => addslashes($tdata['dc_effective_end_date']), ':dc_country_id' => addslashes($tdata['dc_country_id']), ':dc_state_id' => addslashes($tdata['dc_state_id']), ':dc_city_id' => addslashes($tdata['dc_city_id']), ':dc_area_id' => addslashes($tdata['dc_area_id']), ':dc_comments' => addslashes($tdata['dc_comments']), ':dc_multiuser' => addslashes($tdata['dc_multiuser']), ':dc_status' => addslashes($tdata['dc_status']), ':dc_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin'], ':dc_trade_discount' => addslashes($tdata['dc_trade_discount']), ':vendor_id' => addslashes($tdata['vendor_id'])));
            $dc_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($dc_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addDiscountCoupon] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteDiscountCoupon($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbldiscountcoupons` SET 

					`dc_deleted` = :dc_deleted,

					`dc_modified_date` = :dc_modified_date,  

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `dc_id` = :dc_id AND `vendor_id` = :vendor_id AND `dc_deleted` = '0' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':dc_deleted' => '1', ':dc_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':dc_id' => $tdata['dc_id'], ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteDiscountCoupon] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllDiscountCoupons($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $dc_type = '', $dc_applied_on = '', $dc_effective_date = '', $vendor_id = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_vendor_str = "";
        if ($vendor_id != '') {
            $sql_vendor_str = " AND ( `vendor_id` = '" . $vendor_id . "'  )";
        }
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `discount_coupon` = '" . $txtsearch . "' OR `discount_price` = '" . $txtsearch . "'  )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND dc_status = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(dc_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(dc_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(dc_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(dc_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(dc_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( dc_country_id = '" . $country_id . "' OR dc_country_id = '-1' OR  FIND_IN_SET(" . $country_id . ", dc_country_id) > 0  )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( dc_state_id = '" . $state_id . "' OR dc_state_id = '-1' OR  FIND_IN_SET(" . $state_id . ", dc_state_id) > 0  ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( dc_city_id = '" . $city_id . "' OR dc_city_id = '-1' OR  FIND_IN_SET(" . $city_id . ", dc_city_id) > 0  ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( dc_area_id = '" . $area_id . "' OR dc_area_id = '-1' OR dc_area_id = '-1' OR  FIND_IN_SET(" . $area_id . ", dc_area_id) > 0 ) ";
        }
        $sql_dc_type_str = "";
        if ($dc_type != '') {
            $sql_dc_type_str = " AND ( `dc_type` = '" . $dc_type . "'  )";
        }
        $sql_dc_applied_on_str = "";
        if ($dc_applied_on != '') {
            $sql_dc_applied_on_str = " AND ( `dc_applied_on` = '" . $dc_applied_on . "'  )";
        }
        $sql_dc_effective_date_str = "";
        if ($dc_effective_date != '') {
            $effective_day_of_month = date('j', strtotime($dc_effective_date));
            $effective_day_of_week = date('N', strtotime($dc_effective_date));
            $effective_single_date = date('Y-m-d', strtotime($dc_effective_date));
            $sql_dc_effective_date_str = " AND ( 

								( dc_effective_date_type = 'days_of_month' AND ( dc_effective_days_of_month = '-1' OR dc_effective_days_of_month = '" . $effective_day_of_month . "' OR  FIND_IN_SET(" . $effective_day_of_month . ", dc_effective_days_of_month) > 0 ) ) OR

								( dc_effective_date_type = 'days_of_week' AND ( dc_effective_days_of_week = '-1' OR dc_effective_days_of_week = '" . $effective_day_of_week . "' OR  FIND_IN_SET(" . $effective_day_of_week . ", dc_effective_days_of_week) > 0 ) ) OR

								( dc_effective_date_type = 'single_date' AND ( dc_effective_single_date <= '" . $effective_single_date . "' ) ) OR

								( dc_effective_date_type = 'date_range' AND ( dc_effective_start_date <= '" . $effective_single_date . "' AND dc_effective_end_date >= '" . $effective_single_date . "' ) ) 

								) ";
        }
        $sql = "SELECT * FROM `tbldiscountcoupons` 

				WHERE `dc_deleted` = '0' " . $sql_vendor_str . " " . $sql_search_str . " " . $sql_status_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . " " . $sql_dc_type_str . " " . $sql_dc_applied_on_str . " " . $sql_dc_effective_date_str . " ORDER BY dc_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getDiscountCouponDetails($dc_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tbldiscountcoupons` WHERE `dc_id` = '" . $dc_id . "' AND `dc_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function updateDiscountCoupon($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbldiscountcoupons` SET 

					`discount_coupon` = :discount_coupon,

					`discount_price` = :discount_price,

					`min_order_amount` = :min_order_amount,

					`max_order_amount` = :max_order_amount,

					`dc_type` = :dc_type,

					`dc_percentage` = :dc_percentage,

					`dc_min_qty_id` = :dc_min_qty_id,

					`dc_min_qty_val` = :dc_min_qty_val,

					`dc_max_qty_id` = :dc_max_qty_id,

					`dc_max_qty_val` = :dc_max_qty_val,

					`dc_applied_on` = :dc_applied_on,

					`dc_effective_date_type` = :dc_effective_date_type,

					`dc_effective_days_of_month` = :dc_effective_days_of_month,

					`dc_effective_days_of_week` = :dc_effective_days_of_week,

					`dc_effective_single_date` = :dc_effective_single_date,

					`dc_effective_start_date` = :dc_effective_start_date,

					`dc_effective_end_date` = :dc_effective_end_date,

					`dc_country_id` = :dc_country_id,

					`dc_state_id` = :dc_state_id,

					`dc_city_id` = :dc_city_id,

					`dc_area_id` = :dc_area_id,

					`dc_comments` = :dc_comments,

					`dc_multiuser` = :dc_multiuser,

					`dc_status` = :dc_status,

					`dc_modified_date` = :dc_modified_date,  

					`modified_by_admin` = :modified_by_admin,  

					`dc_trade_discount` = :dc_trade_discount  

					WHERE `dc_id` = :dc_id AND `vendor_id` = :vendor_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':discount_coupon' => addslashes($tdata['discount_coupon']), ':discount_price' => addslashes($tdata['discount_price']), ':min_order_amount' => addslashes($tdata['min_order_amount']), ':max_order_amount' => addslashes($tdata['max_order_amount']), ':dc_type' => addslashes($tdata['dc_type']), ':dc_percentage' => addslashes($tdata['dc_percentage']), ':dc_min_qty_id' => addslashes($tdata['dc_min_qty_id']), ':dc_min_qty_val' => addslashes($tdata['dc_min_qty_val']), ':dc_max_qty_id' => addslashes($tdata['dc_max_qty_id']), ':dc_max_qty_val' => addslashes($tdata['dc_max_qty_val']), ':dc_applied_on' => addslashes($tdata['dc_applied_on']), ':dc_effective_date_type' => addslashes($tdata['dc_effective_date_type']), ':dc_effective_days_of_month' => addslashes($tdata['dc_effective_days_of_month']), ':dc_effective_days_of_week' => addslashes($tdata['dc_effective_days_of_week']), ':dc_effective_single_date' => addslashes($tdata['dc_effective_single_date']), ':dc_effective_start_date' => addslashes($tdata['dc_effective_start_date']), ':dc_effective_end_date' => addslashes($tdata['dc_effective_end_date']), ':dc_country_id' => addslashes($tdata['dc_country_id']), ':dc_state_id' => addslashes($tdata['dc_state_id']), ':dc_city_id' => addslashes($tdata['dc_city_id']), ':dc_area_id' => addslashes($tdata['dc_area_id']), ':dc_comments' => addslashes($tdata['dc_comments']), ':dc_multiuser' => addslashes($tdata['dc_multiuser']), ':dc_status' => addslashes($tdata['dc_status']), ':dc_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => $tdata['modified_by_admin'], ':dc_trade_discount' => $tdata['dc_trade_discount'], ':dc_id' => $tdata['dc_id'], ':vendor_id' => $tdata['vendor_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[updateDiscountCoupon] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getCustomerCodeByUserId($user_id) {
        $customer_code = '';
        if ($user_id != '') {
            if (strlen($user_id) == 1) {
                $customer_code = 'TOS000000' . $user_id;
            } elseif (strlen($user_id) == 2) {
                $customer_code = 'TOS00000' . $user_id;
            } elseif (strlen($user_id) == 3) {
                $customer_code = 'TOS0000' . $user_id;
            } elseif (strlen($user_id) == 4) {
                $customer_code = 'TOS000' . $user_id;
            } elseif (strlen($user_id) == 5) {
                $customer_code = 'TOS00' . $user_id;
            } elseif (strlen($user_id) == 6) {
                $customer_code = 'TOS0' . $user_id;
            } else {
                $customer_code = 'TOS' . $user_id;
            }
        }
        return $customer_code;
    }
    public function getUserIdFromCustomerCode($customer_code) {
        $user_id = '';
        if ($customer_code != '') {
            $strpos_6 = strpos($customer_code, 'TOS000000');
            if ($strpos_6 === false) {
                $strpos_5 = strpos($customer_code, 'TOS00000');
                if ($strpos_5 === false) {
                    $strpos_4 = strpos($customer_code, 'TOS0000');
                    if ($strpos_4 === false) {
                        $strpos_3 = strpos($customer_code, 'TOS000');
                        if ($strpos_3 === false) {
                            $strpos_2 = strpos($customer_code, 'TOS00');
                            if ($strpos_2 === false) {
                                $strpos_1 = strpos($customer_code, 'TOS0');
                                if ($strpos_1 === false) {
                                    $strpos_0 = strpos($customer_code, 'TOS');
                                    if ($strpos_0 === false) {
                                    } else {
                                        $user_id = substr($customer_code, 3);
                                        //echo'<br>0pos:'.$strpos_0;
                                        //echo'<br>0customer_code:'.$customer_code;
                                        //echo'<br>0user_id:'.$user_id;
                                        
                                    }
                                } else {
                                    $user_id = substr($customer_code, -6);
                                    //echo'<br>1pos:'.$strpos_1;
                                    //echo'<br>1customer_code:'.$customer_code;
                                    //echo'<br>1user_id:'.$user_id;
                                    
                                }
                            } else {
                                $user_id = substr($customer_code, -5);
                                //echo'<br>2pos:'.$strpos_2;
                                //echo'<br>2customer_code:'.$customer_code;
                                //echo'<br>2user_id:'.$user_id;
                                
                            }
                        } else {
                            $user_id = substr($customer_code, -4);
                            //echo'<br>3pos:'.$strpos_3;
                            //echo'<br>3customer_code:'.$customer_code;
                            //echo'<br>3user_id:'.$user_id;
                            
                        }
                    } else {
                        $user_id = substr($customer_code, -3);
                        //echo'<br>4pos:'.$strpos_4;
                        //echo'<br>4customer_code:'.$customer_code;
                        //echo'<br>4user_id:'.$user_id;
                        
                    }
                } else {
                    $user_id = substr($customer_code, -2);
                    //echo'<br>5pos:'.$strpos_5;
                    //echo'<br>5customer_code:'.$customer_code;
                    //echo'<br>5user_id:'.$user_id;
                    
                }
            } else {
                $user_id = substr($customer_code, -1);
                //echo'<br>6pos:'.$strpos_6;
                //echo'<br>6customer_code:'.$customer_code;
                //echo'<br>6user_id:'.$user_id;
                
            }
        }
        return $user_id;
    }
    public function getVendorCodeByVendorId($user_id) {
        $customer_code = '';
        if ($user_id != '') {
            if (strlen($user_id) == 1) {
                $customer_code = 'TOSBA000000' . $user_id;
            } elseif (strlen($user_id) == 2) {
                $customer_code = 'TOSBA00000' . $user_id;
            } elseif (strlen($user_id) == 3) {
                $customer_code = 'TOSBA0000' . $user_id;
            } elseif (strlen($user_id) == 4) {
                $customer_code = 'TOSBA000' . $user_id;
            } elseif (strlen($user_id) == 5) {
                $customer_code = 'TOSBA00' . $user_id;
            } elseif (strlen($user_id) == 6) {
                $customer_code = 'TOSBA0' . $user_id;
            } else {
                $customer_code = 'TOSBA' . $user_id;
            }
        }
        return $customer_code;
    }
    public function getVendorIdFromVendorCode($customer_code) {
        $user_id = '';
        if ($customer_code != '') {
            $strpos_6 = strpos($customer_code, 'TOSBA000000');
            if ($strpos_6 === false) {
                $strpos_5 = strpos($customer_code, 'TOSBA00000');
                if ($strpos_5 === false) {
                    $strpos_4 = strpos($customer_code, 'TOSBA0000');
                    if ($strpos_4 === false) {
                        $strpos_3 = strpos($customer_code, 'TOSBA000');
                        if ($strpos_3 === false) {
                            $strpos_2 = strpos($customer_code, 'TOSBA00');
                            if ($strpos_2 === false) {
                                $strpos_1 = strpos($customer_code, 'TOSBA0');
                                if ($strpos_1 === false) {
                                    $strpos_0 = strpos($customer_code, 'TOSBA');
                                    if ($strpos_0 === false) {
                                    } else {
                                        $user_id = substr($customer_code, 5);
                                        //echo'<br>0pos:'.$strpos_0;
                                        //echo'<br>0customer_code:'.$customer_code;
                                        //echo'<br>0user_id:'.$user_id;
                                        
                                    }
                                } else {
                                    $user_id = substr($customer_code, -6);
                                    //echo'<br>1pos:'.$strpos_1;
                                    //echo'<br>1customer_code:'.$customer_code;
                                    //echo'<br>1user_id:'.$user_id;
                                    
                                }
                            } else {
                                $user_id = substr($customer_code, -5);
                                //echo'<br>2pos:'.$strpos_2;
                                //echo'<br>2customer_code:'.$customer_code;
                                //echo'<br>2user_id:'.$user_id;
                                
                            }
                        } else {
                            $user_id = substr($customer_code, -4);
                            //echo'<br>3pos:'.$strpos_3;
                            //echo'<br>3customer_code:'.$customer_code;
                            //echo'<br>3user_id:'.$user_id;
                            
                        }
                    } else {
                        $user_id = substr($customer_code, -3);
                        //echo'<br>4pos:'.$strpos_4;
                        //echo'<br>4customer_code:'.$customer_code;
                        //echo'<br>4user_id:'.$user_id;
                        
                    }
                } else {
                    $user_id = substr($customer_code, -2);
                    //echo'<br>5pos:'.$strpos_5;
                    //echo'<br>5customer_code:'.$customer_code;
                    //echo'<br>5user_id:'.$user_id;
                    
                }
            } else {
                $user_id = substr($customer_code, -1);
                //echo'<br>6pos:'.$strpos_6;
                //echo'<br>6customer_code:'.$customer_code;
                //echo'<br>6user_id:'.$user_id;
                
            }
        }
        return $user_id;
    }
    public function date_sort($a, $b) {
        return strtotime($a) - strtotime($b);
    }
    public function getOrderAllDeliveryDatesStringByInvoice($invoice) {
        $output = '';
        $arr_temp_dates = array();
        $arr_order_cart = $this->getOrderCartDetailsByInvoice($invoice);
        if (count($arr_order_cart) > 0) {
            foreach ($arr_order_cart as $record) {
                if ($record['order_cart_delivery_date'] != '' && $record['order_cart_delivery_date'] != '0000-00-00') {
                    $arr_temp_dates[] = $record['order_cart_delivery_date'];
                }
            }
            if (count($arr_temp_dates) > 0) {
                $arr_temp_dates = array_unique($arr_temp_dates);
                $arr_temp_dates = array_values($arr_temp_dates);
                usort($arr_temp_dates, array($this, 'date_sort'));
                for ($i = 0;$i < count($arr_temp_dates);$i++) {
                    $output.= ' ' . date('d-M-Y', strtotime($arr_temp_dates[$i])) . ',';
                }
                $output = substr($output, 0, -1);
            }
        }
        return $output;
    }
    public function getOrderAllDeliveryDatesOptionByInvoice($invoice, $delivery_date, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Dates</option>';
        } else {
            $output.= '<option value="" >Select Date</option>';
        }
        $arr_temp_dates = array();
        $arr_order_cart = $this->getOrderCartDetailsByInvoice($invoice);
        if (count($arr_order_cart) > 0) {
            foreach ($arr_order_cart as $record) {
                if ($record['order_cart_delivery_date'] != '' && $record['order_cart_delivery_date'] != '0000-00-00') {
                    $arr_temp_dates[] = $record['order_cart_delivery_date'];
                }
            }
            if (count($arr_temp_dates) > 0) {
                $arr_temp_dates = array_unique($arr_temp_dates);
                $arr_temp_dates = array_values($arr_temp_dates);
                usort($arr_temp_dates, array($this, 'date_sort'));
                for ($i = 0;$i < count($arr_temp_dates);$i++) {
                    if ($arr_temp_dates[$i] == $delivery_date) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . date('d/M/Y', strtotime($arr_temp_dates[$i])) . '" ' . $selected . '>' . date('d/M/Y', strtotime($arr_temp_dates[$i])) . '</option>';
                }
            }
        }
        return $output;
    }
    public function getOrderAllVendorsOptionByInvoice($invoice, $vendor_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Vendors</option>';
        } else {
            $output.= '<option value="" >Select Vendor</option>';
        }
        $arr_temp_records = array();
        $arr_order_cart = $this->getOrderCartDetailsByInvoice($invoice);
        if (count($arr_order_cart) > 0) {
            foreach ($arr_order_cart as $record) {
                if ($record['prod_id'] != '' && $record['prod_id'] != '0') {
                    $arr_temp_records[] = $record['prod_id'];
                }
            }
            if (count($arr_temp_records) > 0) {
                $arr_temp_records = array_unique($arr_temp_records);
                $arr_temp_records = array_values($arr_temp_records);
                $item_str = implode(',', $arr_temp_records);
                $item_sql_str = " AND ( vendor_id IN (SELECT DISTINCT(vendor_id) FROM `tblcusines` WHERE cusine_deleted = 0 AND cusine_id IN(" . $item_str . ") > 0 ) )";
                try {
                    $sql = "SELECT vendor_id,vendor_name FROM `tblvendors` WHERE `vendor_deleted` = '0' " . $item_sql_str . " ORDER BY vendor_name ASC";
                    $STH = $DBH->query($sql);
                    if ($STH->rowCount() > 0) {
                        while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                            if ($r['vendor_id'] == $vendor_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                            $output.= '<option value="' . $r['vendor_id'] . '" ' . $selected . '>' . stripslashes($r['vendor_name']) . '</option>';
                        }
                    }
                }
                catch(Exception $e) {
                    $stringData = '[getOrderAllVendorsOptionByInvoice] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                    $this->debuglog($stringData);
                    return $output;
                }
            }
        }
        return $output;
    }
    public function getSellerTypeOption($seller_type, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Options</option>';
        } else {
            $output.= '<option value="" >Select Option</option>';
        }
        $arr_temp_dates = array('TOS', 'Vendor');
        for ($i = 0;$i < count($arr_temp_dates);$i++) {
            if ($i == $seller_type) {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . $arr_temp_dates[$i] . '</option>';
        }
        return $output;
    }
    public function getMailingLabelLayoutOption($layout_type, $type = '1') {
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Options</option>';
        } else {
            $output.= '<option value="" >Select Option</option>';
        }
        $arr_temp_records = array('2X2(4 per page)', '4X2(8 per page)', '8X2(16 per page)');
        for ($i = 0;$i < count($arr_temp_records);$i++) {
            if ($i == $layout_type) {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $output.= '<option value="' . $i . '" ' . $selected . '>' . $arr_temp_records[$i] . '</option>';
        }
        return $output;
    }
    public function addMailingLabels($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tblmailinglabelpdf` (`random_unique_no`,`html_contents`,`invoice_str`,`mlp_layout`,`mlp_add_date`,`added_by_admin`) 

					VALUES (:random_unique_no,:html_contents,:invoice_str,:mlp_layout,:mlp_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':random_unique_no' => addslashes($tdata['random_unique_no']), ':html_contents' => addslashes($tdata['html_contents']), ':invoice_str' => addslashes($tdata['invoice_str']), ':mlp_layout' => addslashes($tdata['mlp_layout']), ':mlp_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $mlp_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($mlp_id > 0) {
                $return = true;
            }
        }
        catch(Exception $e) {
            $stringData = '[addMailingLabels] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getLayoutWidthHeightDetails($mlp_layout) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $arr_layout_records = array('2X2(4 per page)', '4X2(8 per page)', '8X2(16 per page)');
        //A4 - 595 X 842
        $a4_width = 595;
        $a4_height = 842;
        $a4_height = $a4_height - 8;
        $arr_records['a4width'] = $a4_width;
        $arr_records['a4height'] = $a4_height;
        if ($mlp_layout == 0) {
            $arr_records['width'] = ($a4_width - 5) / 2;
            $arr_records['height'] = ($a4_height - 4) / 2;
            $arr_records['perpage'] = 4;
            $arr_records['font_size'] = 12;
        } elseif ($mlp_layout == 1) {
            $arr_records['width'] = ($a4_width - 5) / 2;
            $arr_records['height'] = ($a4_height - 6) / 4;
            $arr_records['perpage'] = 8;
            $arr_records['font_size'] = 10;
        } elseif ($mlp_layout == 2) {
            $arr_records['width'] = ($a4_width - 5) / 2;
            $arr_records['height'] = ($a4_height - 10) / 8;
            $arr_records['perpage'] = 16;
            $arr_records['font_size'] = 8;
        } else {
            $arr_records['width'] = $a4_width - 2;
            $arr_records['height'] = $a4_height - 2;
            $arr_records['perpage'] = 1;
            $arr_records['font_size'] = 16;
        }
        return $arr_records;
    }
    public function createMailingLabelsPdfContents($tdata) {
        $DBH = new DatabaseHandler();
        $output = '';
        $arr_layout_details = $this->getLayoutWidthHeightDetails($tdata['mlp_layout']);
        $output.= '<div style="margin:0 auto;float:left;width:' . $arr_layout_details['a4width'] . 'px;height:' . $arr_layout_details['a4height'] . 'px;">';
        if (is_array($tdata['invoice_no']) && count($tdata['invoice_no']) > 0) {
            $loop_next_page = 1;
            $loop_next_page2 = 2;
            for ($i = 0, $j = 1;$i < count($tdata['invoice_no']);$i++, $j++) {
                if ($i % 2 == 0) {
                    if ($j < count($tdata['invoice_no'])) {
                        $no_right_border_str = 'border-right:0px;';
                    } else {
                        $no_right_border_str = '';
                    }
                } else {
                    $no_right_border_str = '';
                }
                if ($i > 1) {
                    $no_top_border_str = 'border-top:0px;';
                } else {
                    $no_top_border_str = '';
                }
                $chk_next_page = $arr_layout_details['perpage'] + $loop_next_page;
                $chk_next_page2 = $arr_layout_details['perpage'] + $loop_next_page2;
                if ($j % $chk_next_page == 0) {
                    $loop_next_page = $loop_next_page + $arr_layout_details['perpage'];
                    $next_page_top_margin_str = 'margin-top:12px;';
                    $no_top_border_str = '';
                } elseif ($j % $chk_next_page2 == 0) {
                    $loop_next_page2 = $loop_next_page2 + $arr_layout_details['perpage'];
                    $next_page_top_margin_str = 'margin-top:12px;';
                    $no_top_border_str = '';
                } else {
                    $next_page_top_margin_str = '';
                }
                $output.= '<div style="float:left;font-size:' . $arr_layout_details['font_size'] . 'px;width:' . $arr_layout_details['width'] . 'px;height:' . $arr_layout_details['height'] . 'px;border:1px solid #000000;' . $no_right_border_str . ' ' . $no_top_border_str . ' ' . $next_page_top_margin_str . '">';
                $arr_order_details = $this->getOrderDetailsByInvoice($tdata['invoice_no'][$i]);
                if ($tdata['billing_address_show'][$i] == '1') {
                    if ($tdata['delivery_address_show'][$i] == '1') {
                        $div_billing_width = 50;
                    } else {
                        $div_billing_width = 100;
                    }
                    $div_billing_height = $arr_layout_details['height'] / 2;
                    //$output .= '<div style="float:left;width:'.$div_billing_width.'%;height:'.$div_billing_height.'px;">';
                    $output.= '<div style="float:left;width:' . $div_billing_width . '%;">';
                    if ($tdata['mlp_layout'] == 2) {
                        //$output .= '<p><strong>Billing Address</strong><br>';
                        $output.= '<p>';
                    } else {
                        //$output .= '<p><strong>Billing Address</strong></p><p>';
                        $output.= '<p>';
                    }
                    if ($tdata['customer_name_show'][$i] == '1') {
                        $output.= '<strong>' . $arr_order_details['user_name'] . '</strong><br>';
                    }
                    if ($tdata['billing_address_show'][$i] == '1') {
                        if ($arr_order_details['billing_building_name'] != '') {
                            $output.= $arr_order_details['billing_building_name'] . ', ';
                        }
                        if ($arr_order_details['billing_floor_no'] != '') {
                            $output.= $arr_order_details['billing_floor_no'] . ', ';
                        }
                        if ($arr_order_details['billing_address'] != '') {
                            $output.= $arr_order_details['billing_address'] . ', ';
                        }
                        $output.= '<br>';
                        if ($arr_order_details['billing_area_name'] != '') {
                            $output.= $arr_order_details['billing_area_name'] . ', ';
                        }
                        if ($arr_order_details['billing_city_name'] != '') {
                            $output.= $arr_order_details['billing_city_name'] . ' ';
                            if ($arr_order_details['billing_pincode'] != '') {
                                $output.= ' - ' . $arr_order_details['billing_pincode'] . ', ';
                            } else {
                                $output.= ', ';
                            }
                        }
                        if ($arr_order_details['billing_state_name'] != '') {
                            $output.= $arr_order_details['billing_state_name'] . ', ';
                        }
                        if ($arr_order_details['billing_country_name'] != '') {
                            $output.= '<br>' . $arr_order_details['billing_country_name'] . ' ';
                        }
                        if ($tdata['mlp_layout'] == 2) {
                            $output.= '<br>';
                        } else {
                            $output.= '<br><br>';
                        }
                    }
                    if ($tdata['customer_no_show'][$i] == '1') {
                        $output.= '<br>Contact No : ' . $arr_order_details['user_mobile_no'] . '';
                    }
                    if ($tdata['customer_email_show'][$i] == '1') {
                        $output.= '<br>Email : ' . $arr_order_details['user_email'] . '';
                    }
                    if ($tdata['mlp_layout'] == 2) {
                        $output.= '</p></div>';
                    } else {
                        $output.= '</p></div>';
                    }
                } else {
                    $div_billing_width = 0;
                    $div_billing_height = 0;
                }
                if ($tdata['delivery_address_show'][$i] == '1') {
                    if ($tdata['billing_address_show'][$i] == '1') {
                        $div_delivery_width = 50;
                    } else {
                        $div_delivery_width = 100;
                    }
                    $div_delivery_height = $arr_layout_details['height'] / 2;
                    //$output .= '<div style="float:left;width:'.$div_delivery_width.'%;height:'.$div_delivery_height.'px;">';
                    $output.= '<div style="float:left;width:' . $div_delivery_width . '%;">';
                    if ($tdata['mlp_layout'] == 2) {
                        //$output .= '<p><strong>Delivery Address</strong><br>';
                        $output.= '<p>';
                    } else {
                        //$output .= '<p><strong>Delivery Address</strong></p><p>';
                        $output.= '<p>';
                    }
                    if ($tdata['customer_name_show'][$i] == '1') {
                        $output.= '<strong>' . $arr_order_details['user_name'] . '</strong><br>';
                    }
                    if ($tdata['delivery_address_show'][$i] == '1') {
                        if ($arr_order_details['user_building_name'] != '') {
                            $output.= $arr_order_details['user_building_name'] . ', ';
                        }
                        if ($arr_order_details['user_floor_no'] != '') {
                            $output.= $arr_order_details['user_floor_no'] . ', ';
                        }
                        if ($arr_order_details['user_address'] != '') {
                            $output.= $arr_order_details['user_address'] . ', ';
                        }
                        $output.= '<br>';
                        if ($arr_order_details['user_area_name'] != '') {
                            $output.= $arr_order_details['user_area_name'] . ', ';
                        }
                        if ($arr_order_details['user_city_name'] != '') {
                            $output.= $arr_order_details['user_city_name'] . ' ';
                            if ($arr_order_details['user_pincode'] != '') {
                                $output.= ' - ' . $arr_order_details['user_pincode'] . ', ';
                            } else {
                                $output.= ', ';
                            }
                        }
                        if ($arr_order_details['user_state_name'] != '') {
                            $output.= $arr_order_details['user_state_name'] . ', ';
                        }
                        if ($arr_order_details['user_country_name'] != '') {
                            $output.= '<br>' . $arr_order_details['user_country_name'] . ' ';
                        }
                        if ($tdata['mlp_layout'] == 2) {
                            $output.= '<br>';
                        } else {
                            $output.= '<br><br>';
                        }
                    }
                    if ($tdata['customer_no_show'][$i] == '1') {
                        $output.= '<br>Contact No : ' . $arr_order_details['user_mobile_no'] . '';
                    }
                    if ($tdata['customer_email_show'][$i] == '1') {
                        $output.= '<br>Email : ' . $arr_order_details['user_email'] . '';
                    }
                    if ($tdata['mlp_layout'] == 2) {
                        $output.= '</p></div>';
                    } else {
                        $output.= '</p></div>';
                    }
                } else {
                    $div_delivery_width = 0;
                    $div_delivery_height = 0;
                }
                if ($tdata['invoice_no_show'][$i] == '1' || $tdata['invoice_date_show'][$i] == '1' || $tdata['delivery_date_show'][$i] == '1') {
                    if ($tdata['seller_name_show'][$i] == '1' || $tdata['seller_address_show'][$i] == '1' || $tdata['pan_no_show'][$i] == '1') {
                        $div_invoice_width = 50;
                    } else {
                        $div_invoice_width = 100;
                    }
                    $div_invoice_height = $arr_layout_details['height'] / 2;
                    //$output .= '<div style="float:left;width:'.$div_invoice_width.'%;height:'.$div_invoice_height.'px;">';
                    $output.= '<div style="float:left;width:' . $div_invoice_width . '%;">';
                    if ($tdata['mlp_layout'] == 2) {
                        //$output .= '<p><strong>Invoice Details</strong><br>';
                        $output.= '<p>';
                    } else {
                        //$output .= '<p><strong>Invoice Details</strong></p><p>';
                        $output.= '<p>';
                    }
                    if ($tdata['invoice_no_show'][$i] == '1') {
                        $output.= 'Invoice No : ' . $tdata['invoice_no'][$i] . '<br>';
                    }
                    if ($tdata['invoice_date_show'][$i] == '1') {
                        $output.= 'Order Date : ' . $tdata['invoice_date'][$i] . '<br>';
                    }
                    if ($tdata['delivery_date_show'][$i] == '1') {
                        $output.= 'Delivery Date : ' . $tdata['delivery_date'][$i] . '<br>';
                    }
                    $output.= '</p></div>';
                } else {
                    $div_invoice_width = 0;
                    $div_invoice_height = 0;
                }
                if ($tdata['seller_name_show'][$i] == '1' || $tdata['seller_address_show'][$i] == '1' || $tdata['pan_no_show'][$i] == '1') {
                    if ($div_invoice_width == 0) {
                        $div_seller_width = 100;
                    } else {
                        $div_seller_width = 100;
                    }
                    $div_seller_height = $arr_layout_details['height'] / 2;
                    //$output .= '<div style="float:left;width:'.$div_seller_width.'%;height:'.$div_seller_height.'px;">';
                    $output.= '<div style="float:left;width:' . $div_seller_width . '%;">';
                    if ($tdata['mlp_layout'] == 2) {
                        //$output .= '<p><strong>Seller Details</strong><br>';
                        $output.= '<p>';
                    } else {
                        //$output .= '<p><strong>Seller Details</strong></p><p>';
                        $output.= '<p>';
                    }
                    if ($tdata['seller_name_show'][$i] == '1') {
                        if ($tdata['seller_type'][$i] == '0') {
                            $output.= 'Seller : ' . $tdata['tos_name'][$i] . '<br>';
                        } else {
                            $output.= 'Seller : ' . $this->getVendorName($tdata['vendor_id'][$i]) . '<br>';
                        }
                    }
                    if ($tdata['seller_address_show'][$i] == '1') {
                        if ($tdata['seller_type'][$i] == '0') {
                            $output.= 'Address : ' . $tdata['tos_address'][$i] . '<br>';
                        } else {
                            $output.= 'Address : ' . $this->getVendorLocationStringByVlocId($tdata['vloc_id'][$i]) . '<br>';
                        }
                    }
                    if ($tdata['pan_no_show'][$i] == '1') {
                        $output.= 'PAN : ' . $tdata['pan_no'][$i] . '';
                    }
                    $output.= '</p></div>';
                } else {
                    $div_seller_width = 0;
                    $div_seller_height = 0;
                }
                $output.= '</div>';
            }
        }
        $output.= '</div>';
        return $output;
    }
    public function getMailingLabelsPdfContents($random_unique_no) {
        $DBH = new DatabaseHandler();
        $return = '';
        try {
            $sql = "SELECT html_contents FROM `tblmailinglabelpdf`  WHERE  `random_unique_no` = '" . $random_unique_no . "' ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = stripslashes($r['html_contents']);
            }
            return $return;
        }
        catch(Exception $e) {
            $stringData = '[getMailingLabelsPdfContents] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return $return;
        }
    }
    public function getVendorsAccessDetails($va_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblvendoraccess` WHERE `va_id` = '" . $va_id . "' AND `va_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getVendorsAccessFormDetails($vaf_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblvendoraccessforms` WHERE `vaf_id` = '" . $vaf_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function chkVendorAccessCategoryExists($va_cat_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendoraccess` WHERE `va_cat_id` = '" . $va_cat_id . "' AND `va_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkVendorAccessCategoryExists_edit($va_cat_id, $va_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendoraccess` WHERE `va_cat_id` = '" . $va_cat_id . "' AND `va_id` != '" . $va_id . "' AND `va_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getAllVendorsAccess($txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND ( `va_name` = '" . addslashes($txtsearch) . "' )";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND va_status = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(va_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(va_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(va_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(va_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(va_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblvendoraccess` 

				WHERE `va_deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . " ORDER BY va_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllVendorsAccessForms($va_id, $txtsearch = '', $status = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        $sql_status_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND `vaf_title` LIKE '%" . $txtsearch . "%' ";
        }
        if ($status != '') {
            $sql_status_str = " AND `vaf_status` = '" . $status . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND added_by_admin = '" . $added_by_admin . "' ";
        }
        $sql_add_date_str = "";
        if ($added_date_type != '') {
            if ($added_date_type == 'days_of_month') {
                if ($added_days_of_month != '' && $added_days_of_month != '-1') {
                    $sql_add_date_str = " AND DAY(vaf_add_date) = '" . $added_days_of_month . "' ";
                }
            } elseif ($added_date_type == 'days_of_week') {
                if ($added_days_of_week != '' && $added_days_of_week != '-1') {
                    //In WEEKDAY()  0-Monday,6-Sunday
                    $added_days_of_week = $added_days_of_week - 1;
                    $sql_add_date_str = " AND WEEKDAY(vaf_add_date) = '" . $added_days_of_week . "' ";
                }
            } elseif ($added_date_type == 'single_date') {
                if ($added_single_date != '' && $added_single_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(vaf_add_date) = '" . date('Y-m-d', strtotime($added_single_date)) . "' ";
                }
            } elseif ($added_date_type == 'date_range') {
                if ($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00') {
                    $sql_add_date_str = " AND DATE(vaf_add_date) >= '" . date('Y-m-d', strtotime($added_start_date)) . "'  AND DATE(vaf_add_date) <= '" . date('Y-m-d', strtotime($added_end_date)) . "' ";
                }
            }
        }
        $sql = "SELECT * FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vaf_deleted` = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_added_by_admin_str . " " . $sql_add_date_str . "  ORDER BY vaf_add_date DESC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getVendorAccessAdminMenuId($va_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql = "SELECT va_am_id FROM `tblvendoraccess` WHERE `va_id` = '" . $va_id . "' AND `va_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $output = stripslashes($r['va_am_id']);
        }
        return $output;
    }
    public function getVendorAccessFormOption($va_id, $vafm_id, $type = '1') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Forms</option>';
        } else {
            $output.= '<option value="" >Select Form</option>';
        }
        $va_am_id_str = $this->getVendorAccessAdminMenuId($va_id);
        if ($va_am_id_str != '') {
            $sql = "SELECT * FROM `tblvendoraccessformsmaster` WHERE `vafm_am_id` IN (" . $va_am_id_str . ") AND `vafm_deleted` = '0' ORDER BY vafm_title ASC ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['vafm_id'] == $vafm_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['vafm_id'] . '" ' . $selected . '>' . stripslashes($r['vafm_title']) . '</option>';
                }
            }
        }
        return $output;
    }
    public function getVendorAccessFormFieldCategoryValueDefault($vafm_id, $field_name) {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($vafm_id == '1') {
            if ($field_name == 'vendor_parent_cat_id') {
                $output = '11';
            } elseif ($field_name == 'vendor_cat_id') {
                $output = '-1';
            } elseif ($field_name == 'vloc_parent_cat_id') {
                $output = '2';
            } elseif ($field_name == 'vloc_cat_id') {
                $output = '-1';
            }
        } elseif ($vafm_id == '2') {
            if ($field_name == 'cusine_type_parent_id') {
                $output = '119';
            } elseif ($field_name == 'cusine_type_id') {
                $output = '-1';
            } else {
                $output = '-1';
            }
        }
        return $output;
    }
    public function getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, $field_name) {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql = "SELECT vaf_id FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vafm_id` = '" . $vafm_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vaf_id = stripslashes($r['vaf_id']);
            if ($vaf_id > 0) {
                $sql2 = "SELECT field_default_value FROM `tblvendoraccessformfields` WHERE `vaf_id` = '" . $vaf_id . "' AND `field_name` = '" . addslashes($field_name) . "' AND `vaff_deleted` = '0' ";
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    $r2 = $STH2->fetch(PDO::FETCH_ASSOC);
                    $output = stripslashes($r2['field_default_value']);
                } else {
                    $output = $this->getVendorAccessFormFieldCategoryValueDefault($vafm_id, $field_name);
                }
            } else {
                $output = $this->getVendorAccessFormFieldCategoryValueDefault($vafm_id, $field_name);
            }
        } else {
            $output = $this->getVendorAccessFormFieldCategoryValueDefault($vafm_id, $field_name);
        }
        $strpos_oo = strpos($output, ',');
        if ($strpos_oo === false) {
            $arr_output = array($output);
        } else {
            $arr_output = explode(',', $output);
        }
        return $arr_output;
    }
    public function getVendorAccessFormFieldShowValueDefault($vafm_id, $field_name) {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($vafm_id == '1') {
            if ($field_name == 'vendor_parent_cat_id') {
                $output = '0';
            } elseif ($field_name == 'vendor_cat_id') {
                $output = '1';
            } elseif ($field_name == 'vloc_parent_cat_id') {
                $output = '0';
            } elseif ($field_name == 'vloc_cat_id') {
                $output = '1';
            } else {
                $output = '1';
            }
        } elseif ($vafm_id == '2') {
            if ($field_name == 'cusine_type_id') {
                $output = '1';
            } elseif ($field_name == 'vendor_id') {
                $output = '0';
            } else {
                $output = '1';
            }
        }
        return $output;
    }
    public function getVendorAccessFormFieldShowValue($va_id, $vafm_id, $field_name) {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql = "SELECT vaf_id FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vafm_id` = '" . $vafm_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vaf_id = stripslashes($r['vaf_id']);
            if ($vaf_id > 0) {
                $sql2 = "SELECT field_show FROM `tblvendoraccessformfields` WHERE `vaf_id` = '" . $vaf_id . "' AND `field_name` = '" . addslashes($field_name) . "' AND `vaff_deleted` = '0' ";
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    $r2 = $STH2->fetch(PDO::FETCH_ASSOC);
                    $output = stripslashes($r2['field_show']);
                } else {
                    $output = $this->getVendorAccessFormFieldShowValueDefault($vafm_id, $field_name);
                }
            } else {
                $output = $this->getVendorAccessFormFieldShowValueDefault($vafm_id, $field_name);
            }
        } else {
            $output = $this->getVendorAccessFormFieldShowValueDefault($vafm_id, $field_name);
        }
        return $output;
    }
    public function getArrayOfVendorAccessFormFields($vafm_id) {
        if ($vafm_id == '1') {
            $arr_records = array('vendor_parent_cat_id', 'vendor_cat_id', 'vendor_name', 'vendor_username', 'vendor_password', 'vloc_parent_cat_id', 'vloc_cat_id', 'country_id', 'state_id', 'city_id', 'area_id', 'contact_person_title', 'contact_person', 'contact_email', 'contact_number', 'contact_designation', 'contact_remark', 'vloc_speciality_offered', 'vloc_menu_file', 'vloc_doc_file', 'vc_cert_type_id', 'vc_cert_name', 'vc_cert_no', 'vc_cert_issued_by', 'vc_cert_reg_date', 'vc_cert_validity_date', 'vc_cert_scan_file');
        } elseif ($vafm_id == '2') {
            $arr_records = array('item_id', 'cusine_image', 'cusine_type_id', 'min_cart_price', 'vendor_id', 'vendor_show', 'vloc_id', 'ordering_type_id', 'ordering_size_id', 'ordering_size_show', 'max_order', 'min_order', 'cusine_qty', 'cusine_qty_show', 'sold_qty_show', 'currency_id', 'cusine_price', 'default_price', 'is_offer', 'offer_price', 'offer_date_type', 'cucat_parent_cat_id', 'cucat_cat_id', 'cucat_show', 'cw_qt_cat_id', 'cw_qu_cat_id', 'cw_quantity', 'cw_show', 'country_id', 'state_id', 'city_id', 'area_id', 'publish_date_type', 'delivery_date_type', 'delivery_date_show', 'order_cutoff_time', 'delivery_time', 'delivery_time_show', 'cancel_cutoff_time', 'cancel_cutoff_time_show', 'cusine_desc_1', 'cusine_desc_show_1', 'cusine_desc_2', 'cusine_desc_show_2');
        } else {
            $arr_records = array();
        }
        return $arr_records;
    }
    public function getVendorAccessFormCode($va_id, $vafm_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($va_id != '' && $va_id != '0') {
            if ($vafm_id == '1') {
                $arr_vendor_parent_cat_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'vendor_parent_cat_id');
                $arr_vendor_cat_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'vendor_cat_id');
                $arr_vloc_parent_cat_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'vloc_parent_cat_id');
                $arr_vloc_cat_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'vloc_cat_id');
                $vendor_parent_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vendor_parent_cat_id');
                $vendor_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vendor_cat_id');
                $vendor_name_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vendor_name');
                $vendor_username_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vendor_username');
                $vendor_password_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vendor_password');
                $vloc_parent_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vloc_parent_cat_id');
                $vloc_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vloc_cat_id');
                $country_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'country_id');
                $state_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'state_id');
                $city_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'city_id');
                $area_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'area_id');
                $contact_person_title_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'contact_person_title');
                $contact_person_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'contact_person');
                $contact_email_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'contact_email');
                $contact_number_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'contact_number');
                $contact_designation_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'contact_designation');
                $contact_remark_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'contact_remark');
                $vloc_speciality_offered_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vloc_speciality_offered');
                $vloc_menu_file_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vloc_menu_file');
                $vloc_doc_file_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vloc_doc_file');
                $vc_cert_type_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vc_cert_type_id');
                $vc_cert_name_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vc_cert_name');
                $vc_cert_no_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vc_cert_no');
                $vc_cert_issued_by_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vc_cert_issued_by');
                $vc_cert_reg_date_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vc_cert_reg_date');
                $vc_cert_validity_date_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vc_cert_validity_date');
                $vc_cert_scan_file_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vc_cert_scan_file');
                $output = '	<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Profile Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Main Profile<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_parent_cat_id_show" id="vendor_parent_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($vendor_parent_cat_id_show) . '

											</select>

										</div>

										<label class="col-lg-2 control-label">Main Profile:<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_parent_cat_id[]" id="vendor_parent_cat_id" multiple class="form-control" onchange="getMainCategoryOptionCommonMultiple(\'vendor\',\'2\',\'1\');" required  >

												' . $this->getMainProfileOption($arr_vendor_parent_cat_id, '1', '1') . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Category<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_cat_id_show" id="vendor_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($vendor_cat_id_show) . '

											</select>

										</div>

										<label class="col-lg-2 control-label">Category:<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_cat_id[]" id="vendor_cat_id" multiple class="form-control" required>

												' . $this->getMainCategoryOption($arr_vendor_parent_cat_id, $arr_vendor_cat_id, '2', '1') . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Company Name<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_name_show" id="vendor_name_show" class="form-control" required>

												' . $this->getShowHideOption($vendor_name_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Username<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_username_show" id="vendor_username_show" class="form-control" required>

												' . $this->getShowHideOption($vendor_username_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Password<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_password_show" id="vendor_password_show" class="form-control" required>

												' . $this->getShowHideOption($vendor_password_show) . '

											</select>

										</div>

									</div>

								</div>

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Location and Contact Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Location Main Profile<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_parent_cat_id_show" id="vloc_parent_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($vloc_parent_cat_id_show) . '

											</select>

										</div>

										<label class="col-lg-2 control-label">Location Main Profile:<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id" multiple class="form-control" onchange="getMainCategoryOptionCommonMultiple(\'vloc\',\'2\',\'1\');" required  >

												' . $this->getMainProfileOption($arr_vloc_parent_cat_id, '1', '1') . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Location Category<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_cat_id_show" id="vloc_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($vloc_cat_id_show) . '

											</select>

										</div>

										<label class="col-lg-2 control-label">Location Category:<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_cat_id[]" id="vloc_cat_id" multiple class="form-control" required>

												' . $this->getMainCategoryOption($arr_vloc_parent_cat_id, $arr_vloc_cat_id, '2', '1') . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Country<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="country_id_show" id="country_id_show" class="form-control" required>

												' . $this->getShowHideOption($country_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show State<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="state_id_show" id="state_id_show" class="form-control" required>

												' . $this->getShowHideOption($state_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show City<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="city_id_show" id="city_id_show" class="form-control" required>

												' . $this->getShowHideOption($city_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Area<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="area_id_show" id="area_id_show" class="form-control" required>

												' . $this->getShowHideOption($area_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Gender<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="contact_person_title_show" id="contact_person_title_show" class="form-control" required>

												' . $this->getShowHideOption($contact_person_title_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Contact Person<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="contact_person_show" id="contact_person_show" class="form-control" required>

												' . $this->getShowHideOption($contact_person_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Contact Email<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="contact_email_show" id="contact_email_show" class="form-control" required>

												' . $this->getShowHideOption($contact_email_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Contact Number<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="contact_number_show" id="contact_number_show" class="form-control" required>

												' . $this->getShowHideOption($contact_number_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Contact Designation<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="contact_designation_show" id="contact_designation_show" class="form-control" required>

												' . $this->getShowHideOption($contact_designation_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Remark<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="contact_remark_show" id="contact_remark_show" class="form-control" required>

												' . $this->getShowHideOption($contact_remark_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Speciality Offered<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_speciality_offered_show" id="vloc_speciality_offered_show" class="form-control" required>

												' . $this->getShowHideOption($vloc_speciality_offered_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Menu Image/Pdf<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_menu_file_show" id="vloc_menu_file_show" class="form-control" required>

												' . $this->getShowHideOption($vloc_menu_file_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Vendor Estt Pdf<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_doc_file_show" id="vloc_doc_file_show" class="form-control" required>

												' . $this->getShowHideOption($vloc_doc_file_show) . '

											</select>

										</div>

									</div>

								</div>

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Type<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vc_cert_type_id_show" id="vc_cert_type_id_show" class="form-control" required>

												' . $this->getShowHideOption($vc_cert_type_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Name<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vc_cert_name_show" id="vc_cert_name_show" class="form-control" required>

												' . $this->getShowHideOption($vc_cert_name_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Number<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vc_cert_no_show" id="vc_cert_no_show" class="form-control" required>

												' . $this->getShowHideOption($vc_cert_no_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Issued By<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vc_cert_issued_by_show" id="vc_cert_issued_by_show" class="form-control" required>

												' . $this->getShowHideOption($vc_cert_issued_by_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Issued Date<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vc_cert_reg_date_show" id="vc_cert_reg_date_show" class="form-control" required>

												' . $this->getShowHideOption($vc_cert_reg_date_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Vaidity Date<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vc_cert_validity_date_show" id="vc_cert_validity_date_show" class="form-control" required>

												' . $this->getShowHideOption($vc_cert_validity_date_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Scan Image<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vc_cert_scan_file_show" id="vc_cert_scan_file_show" class="form-control" required>

												' . $this->getShowHideOption($vc_cert_scan_file_show) . '

											</select>

										</div>

									</div>

								</div>

							</div>';
            } elseif ($vafm_id == '2') {
                $arr_cusine_type_parent_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'cusine_type_parent_id');
                $arr_cusine_type_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'cusine_type_id');
                $arr_cucat_parent_cat_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'cucat_parent_cat_id');
                $arr_cucat_cat_id = $this->getVendorAccessFormFieldCategoryValue($va_id, $vafm_id, 'cucat_cat_id');
                $item_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'item_id');
                $cusine_image_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_image');
                $cusine_type_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_type_id');
                $min_cart_price_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'min_cart_price');
                $vendor_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vendor_id');
                $vendor_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vendor_show');
                $vloc_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'vloc_id');
                $ordering_type_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'ordering_type_id');
                $ordering_size_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'ordering_size_id');
                $ordering_size_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'ordering_size_show');
                $max_order_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'max_order');
                $min_order_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'min_order');
                $cusine_qty_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_qty');
                $cusine_qty_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_qty_show');
                $sold_qty_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'sold_qty_show');
                $currency_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'currency_id');
                $cusine_price_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_price');
                $default_price_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'default_price');
                $is_offer_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'is_offer');
                $offer_price_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'offer_price');
                $offer_date_type_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'offer_date_type');
                $cucat_parent_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cucat_parent_cat_id');
                $cucat_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cucat_cat_id');
                $cucat_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cucat_show');
                $cw_qt_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cw_qt_cat_id');
                $cw_qu_cat_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cw_qu_cat_id');
                $cw_quantity_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cw_quantity');
                $cw_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cw_show');
                $country_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'country_id');
                $state_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'state_id');
                $city_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'city_id');
                $area_id_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'area_id');
                $publish_date_type_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'publish_date_type');
                $delivery_date_type_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'delivery_date_type');
                $delivery_date_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'delivery_date_show');
                $order_cutoff_time_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'order_cutoff_time');
                $delivery_time_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'delivery_time');
                $delivery_time_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'delivery_time_show');
                $cancel_cutoff_time_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cancel_cutoff_time');
                $cancel_cutoff_time_show_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cancel_cutoff_time_show');
                $cusine_desc_1_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_desc_1');
                $cusine_desc_show_1_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_desc_show_1');
                $cusine_desc_2_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_desc_2');
                $cusine_desc_show_2_show = $this->getVendorAccessFormFieldShowValue($va_id, $vafm_id, 'cusine_desc_show_2');
                $output = '	<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Item Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Item<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="item_id_show" id="item_id_show" class="form-control" required>

												' . $this->getShowHideOption($item_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cusine Image<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_image_show" id="cusine_image_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_image_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Menu Presentation<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_type_id_show" id="cusine_type_id_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_type_id_show) . '

											</select>

										</div>

										<label class="col-lg-2 control-label">Menu Presentation Category:<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_type_id[]" id="cusine_type_id" multiple class="form-control" required>

												' . $this->getMainCategoryOption($arr_cusine_type_parent_id, $arr_cusine_type_id, '2', '1') . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Min Cart Price<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="min_cart_price_show" id="min_cart_price_show" class="form-control" required>

												' . $this->getShowHideOption($min_cart_price_show) . '

											</select>

										</div>

									</div>	

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Vendor<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_id_show" id="vendor_id_show" class="form-control" required>

												' . $this->getShowHideOption($vendor_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Vendor Details<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vendor_show_show" id="vendor_show_show" class="form-control" required>

												' . $this->getShowHideOption($vendor_show_show) . '

											</select>

										</div>

									</div>

								</div>

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Vendor Location, Inventory and Price Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Vendor Location<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="vloc_id_show" id="vloc_id_show" class="form-control" required>

												' . $this->getShowHideOption($vloc_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Ordering Type<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="ordering_type_id_show" id="ordering_type_id_show" class="form-control" required>

												' . $this->getShowHideOption($ordering_type_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Ordering Size<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="ordering_size_id_show" id="ordering_size_id_show" class="form-control" required>

												' . $this->getShowHideOption($ordering_size_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Ordering Size in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="ordering_size_show_show" id="ordering_size_show_show" class="form-control" required>

												' . $this->getShowHideOption($ordering_size_show_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Max Order Quantity<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="max_order_show" id="max_order_show" class="form-control" required>

												' . $this->getShowHideOption($max_order_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Min Order Quantity<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="min_order_show" id="min_order_show" class="form-control" required>

												' . $this->getShowHideOption($min_order_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Current Stock<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_qty_show" id="cusine_qty_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_qty_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Current Stock in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_qty_show_show" id="cusine_qty_show_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_qty_show_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Sold Quantity in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="sold_qty_show_show" id="sold_qty_show_show" class="form-control" required>

												' . $this->getShowHideOption($sold_qty_show_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Currency<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="currency_id_show" id="currency_id_show" class="form-control" required>

												' . $this->getShowHideOption($currency_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Price<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_price_show" id="cusine_price_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_price_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Default Price<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="default_price_show" id="default_price_show" class="form-control" required>

												' . $this->getShowHideOption($default_price_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Offer Item<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="is_offer_show" id="is_offer_show" class="form-control" required>

												' . $this->getShowHideOption($is_offer_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Offer Price<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="offer_price_show" id="offer_price_show" class="form-control" required>

												' . $this->getShowHideOption($offer_price_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Offer Date<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="offer_date_type_show" id="offer_date_type_show" class="form-control" required>

												' . $this->getShowHideOption($offer_date_type_show) . '

											</select>

										</div>

									</div>

								</div>

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Category Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Main Profile<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cucat_parent_cat_id_show" id="cucat_parent_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($cucat_parent_cat_id_show) . '

											</select>

										</div>

										<label class="col-lg-2 control-label">Main Profile<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id" multiple class="form-control" onchange="getMainCategoryOptionCommonMultiple(\'cucat\',\'2\',\'1\');" required  >

												' . $this->getMainProfileOption($arr_cucat_parent_cat_id, '2', '1') . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Category<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cucat_cat_id_show" id="cucat_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($cucat_cat_id_show) . '

											</select>

										</div>

										<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cucat_cat_id[]" id="cucat_cat_id" multiple class="form-control" required  >

												' . $this->getMainCategoryOption($arr_cucat_parent_cat_id, $arr_cucat_cat_id, '2', '1') . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Category in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cucat_show_show" id="cucat_show_show" class="form-control" required>

												' . $this->getShowHideOption($cucat_show_show) . '

											</select>

										</div>

									</div>	

								<div>	

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Package Weight Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Quantity Type<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cw_qt_cat_id_show" id="cw_qt_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($cw_qt_cat_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Quantity Unit<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cw_qu_cat_id_show" id="cw_qu_cat_id_show" class="form-control" required>

												' . $this->getShowHideOption($cw_qu_cat_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Quantity<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cw_quantity_show" id="cw_quantity_show" class="form-control" required>

												' . $this->getShowHideOption($cw_quantity_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Quantity in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cw_show_show" id="cw_show_show" class="form-control" required>

												' . $this->getShowHideOption($cw_show_show) . '

											</select>

										</div>

									</div>

								</div>	

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Delivery Location Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Country<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="country_id_show" id="country_id_show" class="form-control" required>

												' . $this->getShowHideOption($country_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show State<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="state_id_show" id="state_id_show" class="form-control" required>

												' . $this->getShowHideOption($state_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show City<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="city_id_show" id="city_id_show" class="form-control" required>

												' . $this->getShowHideOption($city_id_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Area<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="area_id_show" id="area_id_show" class="form-control" required>

												' . $this->getShowHideOption($area_id_show) . '

											</select>

										</div>

									</div>

								</div>

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Publish and Delivery Date Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Date of Publish<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="publish_date_type_show" id="publish_date_type_show" class="form-control" required>

												' . $this->getShowHideOption($publish_date_type_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Date of Delivery<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="delivery_date_type_show" id="delivery_date_type_show" class="form-control" required>

												' . $this->getShowHideOption($delivery_date_type_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Delivery Date in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="delivery_date_show_show" id="delivery_date_show_show" class="form-control" required>

												' . $this->getShowHideOption($delivery_date_show_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cut Off Time<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="order_cutoff_time_show" id="order_cutoff_time_show" class="form-control" required>

												' . $this->getShowHideOption($order_cutoff_time_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Delivery Time <span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="delivery_time_show" id="delivery_time_show" class="form-control" required>

												' . $this->getShowHideOption($delivery_time_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Delivery Time in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="delivery_time_show_show" id="delivery_time_show_show" class="form-control" required>

												' . $this->getShowHideOption($delivery_time_show_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cancellation Cut Off Time<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cancel_cutoff_time_show" id="cancel_cutoff_time_show" class="form-control" required>

												' . $this->getShowHideOption($cancel_cutoff_time_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cancellation Cut Off Time in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cancel_cutoff_time_show_show" id="cancel_cutoff_time_show_show" class="form-control" required>

												' . $this->getShowHideOption($cancel_cutoff_time_show_show) . '

											</select>

										</div>

									</div>

								</div>		

								<div class="form-group left-label">

									<label class="col-lg-4 control-label"><strong>Other Details:</strong></label>

								</div>

								<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cusine Description 1<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_desc_1_show" id="cusine_desc_1_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_desc_1_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cusine Description 1 in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_desc_show_1_show" id="cusine_desc_show_1_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_desc_show_1_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cusine Description 2<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_desc_2_show" id="cusine_desc_2_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_desc_2_show) . '

											</select>

										</div>

									</div>

									<div class="form-group">

										<label class="col-lg-2 control-label">Show Cusine Description 2 in Frontend<span style="color:red">*</span></label>

										<div class="col-lg-4">

											<select name="cusine_desc_show_2_show" id="cusine_desc_show_2_show" class="form-control" required>

												' . $this->getShowHideOption($cusine_desc_show_2_show) . '

											</select>

										</div>

									</div>

							</div>';
            }
        }
        return $output;
    }
    public function chkVendorAccessFormExists($va_id, $vafm_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vafm_id` = '" . $vafm_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkVendorAccessFormExists_edit($va_id, $vafm_id, $vaf_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vafm_id` = '" . $vafm_id . "' AND `vaf_id` != '" . $vaf_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function chkValidVendorAccessForm($va_id, $vaf_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vaf_id` = '" . $vaf_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getVendorsAccessFormMasterDetails($vafm_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tblvendoraccessformsmaster` WHERE `vafm_id` = '" . $vafm_id . "' AND `vafm_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getVendorAccessFormIdFromVAID($va_id, $vafm_id) {
        $DBH = new DatabaseHandler();
        $vaf_id = 0;
        $sql = "SELECT vaf_id FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vafm_id` = '" . $vafm_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vaf_id = $r['vaf_id'];
        }
        return $vaf_id;
    }
    public function getVendorAccessFormIdFromVAIDAndVAFAMID($va_id, $vaf_am_id) {
        $DBH = new DatabaseHandler();
        $vaf_id = 0;
        $sql = "SELECT vaf_id FROM `tblvendoraccessforms` WHERE `va_id` = '" . $va_id . "' AND `vaf_am_id` = '" . $vaf_am_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            //echo 'Hiiii';
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vaf_id = $r['vaf_id'];
        }
        return $vaf_id;
    }
    public function getVendorAccessFormFieldsDetails($vaf_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql2 = "SELECT * FROM `tblvendoraccessformfields` WHERE `vaf_id` = '" . $vaf_id . "' AND `vaff_deleted` = '0' ";
        $STH2 = $DBH->query($sql2);
        if ($STH2->rowCount() > 0) {
            while ($r2 = $STH2->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r2;
            }
        }
        return $arr_records;
    }
    public function getVendorAccessFormTitle($vaf_id) {
        $DBH = new DatabaseHandler();
        $vaf_title = '';
        $sql = "SELECT vaf_title FROM `tblvendoraccessforms` WHERE `vaf_id` = '" . $vaf_id . "' AND `vaf_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vaf_title = stripslashes($r['vaf_title']);
        }
        return $vaf_title;
    }
    public function chkIfShowVendorAccessFormFieldFromVAFID($vaf_id, $field_name) {
        $DBH = new DatabaseHandler();
        $output = false;
        if ($vaf_id > 0) {
            $sql2 = "SELECT field_show FROM `tblvendoraccessformfields` WHERE `vaf_id` = '" . $vaf_id . "' AND `field_name` = '" . addslashes($field_name) . "' AND `vaff_deleted` = '0' ";
            $STH2 = $DBH->query($sql2);
            if ($STH2->rowCount() > 0) {
                $r2 = $STH2->fetch(PDO::FETCH_ASSOC);
                $show = stripslashes($r2['field_show']);
                if ($show == '1') {
                    $output = true;
                }
            }
        }
        return $output;
    }
    public function getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id, $field_name) {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($vaf_id > 0) {
            $sql2 = "SELECT field_default_value FROM `tblvendoraccessformfields` WHERE `vaf_id` = '" . $vaf_id . "' AND `field_name` = '" . addslashes($field_name) . "' AND `vaff_deleted` = '0' ";
            $STH2 = $DBH->query($sql2);
            if ($STH2->rowCount() > 0) {
                $r2 = $STH2->fetch(PDO::FETCH_ASSOC);
                $output = stripslashes($r2['field_default_value']);
            }
        }
        return $output;
    }
    public function getVendorIdByEmail($email) {
        $DBH = new DatabaseHandler();
        $vendor_id = 0;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '" . addslashes($email) . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vendor_id = $r['vendor_id'];
        }
        return $vendor_id;
    }
    public function getVendorContactNumber($vendor_id) {
        $DBH = new DatabaseHandler();
        $contact_number = '';
        $sql = "SELECT vendor_mobile FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $contact_number = stripslashes($r['vendor_mobile']);
        }
        return $contact_number;
    }
    public function getVendorOtp($vendor_id) {
        $DBH = new DatabaseHandler();
        $vendor_otp = '';
        $sql = "SELECT vendor_otp FROM `tblvendors` WHERE `vendor_id` = '" . $vendor_id . "' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $vendor_otp = stripslashes($r['vendor_otp']);
        }
        return $vendor_otp;
    }
    //update ample 21-07-20
    public function sendSignUpEmailToVendor($email,$mobile) {
        $vendor_id = $this->getVendorIdByEmail($email);
        if ($vendor_id > 0) {
            $otp = $this->getVendorOtp($vendor_id);
            $fname = $this->getVendorName($vendor_id);
            $url = ' https://www.wellnessway4u.com/validate_pro_user.php?sess=' . base64_encode($email) . '';
            //list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = $obj->getEmailAutoresponderDetails('1');
            $mail_data = $this->getEmailAutoresponderDetails('3');
            $to_email = $email;
            $from_email = $mail_data['email_ar_from_email'];
            $from_name = $mail_data['email_ar_from_name'];
            $subject = $mail_data['email_ar_subject'];
            $message = $mail_data['email_ar_body'];
            $message = str_ireplace("[[ADVISER_NAME]]", $fname, $message);
            $message = str_ireplace("[[ADVISER_EMAIL]]", $to_email, $message);
            $message = str_ireplace("[[ANCHER_URL_START]]", '<a href="' . $url . '">', $message);
            $message = str_ireplace("[[ANCHER_URL_END]]", '</a>', $message);
            $message = str_ireplace("[[URL]]", $url, $message);
            $message = str_ireplace("[[OTP]]", $otp, $message);
            $mail = new PHPMailer();
            $mail->IsHTML(true);
            $mail->Host = "batmobile.websitewelcome.com"; // SMTP server
            $mail->From = $from_email;
            $mail->FromName = $from_name;
            $mail->AddAddress($to_email);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->Send();
            $mail->ClearAddresses();

            //add by ample 13-07-20
            $tdata_sms = array();
            $tdata_sms['mobile_no'] = $mobile;
            
            $sms_mail_data =$this->getEmailAutoresponderDetails('19');
            $sms_msg = $sms_mail_data['email_ar_body'];
            $sms_msg = str_ireplace("[[ADVISER_NAME]]", $name, $sms_msg);
            $sms_msg = str_ireplace("[[ADVISER_EMAIL]]", $email, $sms_msg);
            $sms_msg = str_ireplace("[[OTP]]", $otp, $sms_msg);

            $sms_credential=$this->get_SMS_credential($sms_mail_data['SMS_ID']); 
            $tdata_sms['SMS_USERNAME']=$sms_credential['SMS_USERNAME'];
            $tdata_sms['SMS_PASSWORD']=$sms_credential['SMS_PASSWORD'];
            $tdata_sms['SMS_SENDERID']=$sms_credential['SMS_SENDERID'];
            $tdata_sms['SMS_URL']=$sms_credential['SMS_URL'];
            $tdata_sms['sms_message'] = strip_tags($sms_msg); //add by ample 15-06-20
            $this->sendSMS($tdata_sms);


            // SENDSMS TO VENDOR - VENDOR SIGNUP - START
            // $tdata_sms = array();
            // $tdata_sms['mobile_no'] = $this->getVendorContactNumber($vendor_id);
            // $tdata_sms['sms_message'] = 'Dear ' . $fname . ', Your profile is successfully created at Wellnessway4you.com.';
            // $this->sendSMS($tdata_sms);
            // $tdata_sms_otp = array();
            // $tdata_sms_otp['mobile_no'] = $this->getVendorContactNumber($vendor_id);
            // $tdata_sms_otp['sms_message'] = 'Dear ' . $fname . ', Your profile is successfully created at Wellnessway4you.com activate your profile using OTP: ' . $otp;
            // $this->sendSMS($tdata_sms_otp);
            // // SENDSMS TO VENDOR - VENDOR SIGNUP - END
            // // SENDSMS TO ADMIN - VENDOR SIGNUP - START
            // $tdata_sms_admin = array();
            // $tdata_sms_admin['mobile_no'] = '8655018341';
            // $tdata_sms_admin['sms_message'] = "Dear Admin,New Business associate profile is registered with name:" . $fname;
            // $this->sendSMS($tdata_sms_admin);
            // SENDSMS TO ADMIN - VENDOR SIGNUP - END
            return true;
        }
    }
    public function sendNewCusineAddedEmailToAdmin($cusine_id) {
        $arr_record = $this->getCusineDetails($cusine_id);
        if (count($arr_record) > 0) {
            $vendor_name = $this->getVendorName($arr_record['vendor_id']);
            $cusine_name = $this->GetItemName($arr_record['item_id']);
            $from_email = 'support@tastes-of-states.com';
            $from_name = 'Wellnessway4you';
            $subject = "New Cusine added by business associate(" . $vendor_name . ")";
            $emailHTML = '';
            $emailHTML.= '<p>Dear Admin</p>';
            $emailHTML.= '<p>' . $vendor_name . ' has added new cusine.</p>';
            $emailHTML.= '<p>Below are the details.</p>';
            $emailHTML.= '<p>Cusine Name:' . $cusine_name . ' has added new cusine.</p>';
            $emailHTML.= '<p>Thanks and Regards</p>';
            $emailHTML.= '<p>Team Wellnessway4you</p>';
            $to_email = 'support@tastes-of-states.com';
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
            // SENDSMS TO ADMIN - NEW CUSINE ADDED - START
            $tdata_sms_admin = array();
            $tdata_sms_admin['mobile_no'] = '8828033111';
            $tdata_sms_admin['sms_message'] = "Dear Admin, " . $vendor_name . " has added new cusine.";
            //$this->sendSMS($tdata_sms_admin);
            // SENDSMS TO ADMIN - NEW CUSINE ADDED - END
            
        }
    }
    public function getTaxOptionByTaxCatId($tax_cat_id, $tax_id, $type = '1', $multiple = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($type == '2') {
            $output.= '<option value="" >All Tax</option>';
        } else {
            $output.= '<option value="" >Select Tax</option>';
        }
        if ($tax_cat_id != '') {
            $sql = "SELECT * FROM `tbltaxes` WHERE `tax_cat_id` = '" . $tax_cat_id . "' AND `tax_status` = '1' AND `tax_deleted` = '0' ORDER BY tax_effective_date DESC, tax_add_date DESC ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['tax_id'] == $tax_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['tax_id'] . '" ' . $selected . '>' . stripslashes($r['tax_name']) . ' (' . stripslashes($r['tax_percentage']) . ' %)</option>';
                }
            }
        }
        return $output;
    }
    public function sendNewItemToAddEmailToAdmin($tdata) {
        $fname = $tdata['vendor_name'];
        $from_email = 'support@tastes-of-states.com';
        $from_name = 'Wellnessway4you';
        $subject = "Request to add new item in item master";
        $emailHTML = '';
        $emailHTML.= '<p>Dear Admin</p>';
        $emailHTML.= '<p>' . $fname . ' has sent you request to add new item.</p>';
        $emailHTML.= '<p>New Item Name: ' . $tdata['item_name'] . ' </p>';
        $emailHTML.= '<p>Thanks and Regards</p>';
        $emailHTML.= '<p>Team Wellnessway4you</p>';
        $to_email = $from_email;
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
        // SENDSMS TO ADMIN - NEW CUSINE ADDED - START
        $tdata_sms_admin = array();
        $tdata_sms_admin['mobile_no'] = '8828033111';
        $tdata_sms_admin['sms_message'] = "Dear Admin, " . $fname . " has sent you request to add new item.";
        $this->sendSMS($tdata_sms_admin);
        // SENDSMS TO ADMIN - NEW CUSINE ADDED - END
        
    }
    public function getProfileCategoryName($id) {
        $return = array();
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblprofilecustomcategories`  where  `prct_cat_id` = '" . $id . "' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r;
            }
            return $return['prct_cat'];
        }
        catch(Exception $e) {
            $stringData = '[GetCategory] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
    }
    public function getSubCategoryName($id) {
        $return = array();
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblfavcategory`  where  `fav_cat_id` = '" . $id . "' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $row_count = $STH->rowCount();
            if ($row_count > 0) {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $return = $r;
            }
            return $return['fav_cat'];
        }
        catch(Exception $e) {
            $stringData = '[GetCategory] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return array();
        }
    }
    public function getCityOptions() {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $sql = "SELECT * FROM `tblcities` WHERE 1 ORDER BY `city` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                //<option value="Paris">Paris</option>
                $option_str.= '<option value="' . $row['city'] . '" >' . stripslashes($row['city']) . '</option>';
            }
        }
        return $option_str;
    }
    public function getCityIdbyName($city_name) {
        $DBH = new DatabaseHandler();
        $city_id = 0;
        $sql = "SELECT * FROM `tblcities` WHERE `city` = '" . $city_name . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $city_id = $row['city_id'];
        }
        return $city_id;
    }
    public function getPlaceOptions($city_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $sql = "SELECT * FROM `tblplaces` WHERE `city_id` = '" . $city_id . "' ORDER BY `place` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $option_str.= '<option value="' . $row['place_id'] . '" >' . stripslashes($row['place']) . '</option>';
            }
        }
        return $option_str;
    }
    public function getFavCategoryRamakant($fav_cat_type_id, $fav_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $fav_cat_type_id = explode(',', $fav_cat_type_id);
        $fav_cat_type_id = implode('\',\'', $fav_cat_type_id);
        $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('" . $fav_cat_type_id . "') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['favcat_id'] == $fav_cat_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $cat_name = $row['fav_cat'];
                $option_str.= '<option value="' . $row['favcat_id'] . '" ' . $sel . '>' . stripslashes($cat_name) . '</option>';
            }
        }
        //echo $option_str;
        return $option_str;
    }
    public function getFavCategoryVendor($fav_cat_type_id, $fav_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $fav_cat_type_id = explode(',', $fav_cat_type_id);
        $fav_cat_type_id = implode('\',\'', $fav_cat_type_id);
        //$fav_cat_id = explode(',', $fav_cat_id);
        $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('" . $fav_cat_type_id . "') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if (in_array($row['favcat_id'], $fav_cat_id)) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $cat_name = $row['fav_cat'];
                $option_str.= '<option value="' . $row['favcat_id'] . '" ' . $sel . '>' . stripslashes($cat_name) . '</option>';
            }
        }
        //echo $option_str;
        return $option_str;
    }
    public function getEmailAutoresponderDetails($email_action_id) {
        $DBH = new DatabaseHandler();
        $data = array();
        $sql = "SELECT * FROM `tblautoresponders` WHERE `email_action_id` = '" . $email_action_id . "' AND `email_ar_status` = '1' AND `email_ar_deleted` = '0' ORDER BY `email_ar_add_date` DESC LIMIT 1 ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $r;
        }
        return $data;
    }
    public function getAllEvents_OLD($txtsearch = '', $status = '', $cucat_parent_cat_id = '', $cucat_cat_id = '', $vendor_id = '', $added_by_admin = '', $added_date_type = '', $added_days_of_month = '', $added_days_of_week = '', $added_single_date = '', $added_start_date = '', $added_end_date = '', $country_id = '', $state_id = '', $city_id = '', $area_id = '', $delivery_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND TBE.event_name LIKE '%" . $txtsearch . "%' ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TBE.status = '" . $status . "' ";
        }
        $sql_vendor_id_str = "";
        if ($vendor_id != '') {
            $sql_vendor_id_str = " AND TBE.organiser_id = '" . $vendor_id . "' ";
        }
        $sql_added_by_admin_str = "";
        if ($added_by_admin != '') {
            $sql_added_by_admin_str = " AND TBE.posted_by = '" . $added_by_admin . "' ";
        }
        $sql_country_id_str = "";
        if ($country_id != '') {
            $sql_country_id_str = " AND ( TBD.country_id = '" . $country_id . "' OR TBD.country_id = '-1' OR  FIND_IN_SET(" . $country_id . ", TBD.country_id) > 0  )";
        }
        $sql_state_id_str = "";
        if ($state_id != '') {
            $sql_state_id_str = " AND ( TBD.state_id = '" . $state_id . "' OR TBD.state_id = '-1' OR  FIND_IN_SET(" . $state_id . ", TBD.state_id) > 0  ) ";
        }
        $sql_city_id_str = "";
        if ($city_id != '') {
            $sql_city_id_str = " AND ( TBD.city_id = '" . $city_id . "' OR TBD.city_id = '-1' OR  FIND_IN_SET(" . $city_id . ", TBD.city_id) > 0  ) ";
        }
        $sql_area_id_str = "";
        if ($area_id != '') {
            $sql_area_id_str = " AND ( TBD.area_id = '" . $area_id . "' OR TBD.area_id = '-1' OR TBD.area_id = '-1' OR  FIND_IN_SET(" . $area_id . ", TBD.area_id) > 0 ) ";
        }
        //update by ample 09-09-20
        $sql = "SELECT TBE.*,TBD.event_master_id,TBD.venue_details,TBD.city_id

                        FROM `tbl_event_master` AS TBE

                        LEFT JOIN `tbl_event_details` AS TBD ON TBD.event_master_id = TBE.event_master_id

                        -- LEFT JOIN `tbl_event_certificates` AS TBC ON TBC.event_id = TBD.event_id

                        WHERE TBE.is_deleted = '0' AND TBD.event_deleted = '0' " . $sql_search_str . " " . $sql_status_str . " " . $sql_vendor_id_str . " " . $sql_country_id_str . " " . $sql_state_id_str . " " . $sql_city_id_str . " " . $sql_area_id_str . "  " . $sql_added_by_admin_str . "   ORDER BY TBE.add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    //update by ample 22-12-20
    public function getAllEvents($txtsearch = '', $status = '', $cucat_parent_cat_id = '', $cucat_cat_id = '', $vendor_id = '',$added_start_date = '', $added_end_date = '') {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND (TBE.event_name LIKE '%" . $txtsearch . "%' OR  TBE.event_tags LIKE '%" . $txtsearch . "%' ) ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TBE.status = '" . $status . "' ";
        }
        $sql_vendor_id_str = "";
        if ($vendor_id != '') {
            $sql_vendor_id_str = " AND TBE.organiser_id = '" . $vendor_id . "' ";
        }
        $sql_main_cat_id = "";
        if ($cucat_parent_cat_id != '') {
            $sql_main_cat_id = " AND (TBE.prof_cat_id_1 = " . $cucat_parent_cat_id . " OR TBE.prof_cat_id_2 = " . $cucat_parent_cat_id . " OR TBE.prof_cat_id_3 = " . $cucat_parent_cat_id . " OR TBE.prof_cat_id_4 = " . $cucat_parent_cat_id . " OR TBE.prof_cat_id_5 = " . $cucat_parent_cat_id . ")  ";
        }
        $sql_sub_cat_id = "";
        if ($cucat_cat_id != '') {
            $sql_sub_cat_id = " AND (TBE.fav_cat_id_1 = " . $cucat_cat_id . " OR TBE.fav_cat_id_2 = " . $cucat_cat_id . " OR TBE.fav_cat_id_3 = " . $cucat_cat_id . " OR TBE.fav_cat_id_4 = " . $cucat_cat_id . " OR TBE.fav_cat_id_5 = " . $cucat_cat_id . ")  ";
        }
       
        //update by ample 09-09-20
        $sql = "SELECT TBE.*
                        FROM `tbl_event_master` AS TBE
                        WHERE TBE.is_deleted = '0'  " . $sql_search_str . " " . $sql_status_str . " " . $sql_vendor_id_str . " " . $sql_main_cat_id . " " . $sql_sub_cat_id . "   ORDER BY TBE.add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getnextrefernceNumber() {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = '';
        $sql = "SELECT * FROM `tbl_event_master` where 1 order by event_master_id desc limit 1 ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $return = 'EVE-' . ($row['event_master_id'] + 1);
        } else {
            $return = 'EVE-1';
        }
        return $return;
    }
    public function getFavCatNameById($fav_cat_id) {
        $DBH = new DatabaseHandler();
        $contact_number = '';
        $sql = "SELECT fav_cat FROM `tblfavcategory` WHERE `fav_cat_id` = '" . $fav_cat_id . "'  ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $contact_number = stripslashes($r['fav_cat']);
        }
        return $contact_number;
    }
    public function getFavCategoryTypeOptions($prct_cat_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($r['prct_cat_id'] == $prct_cat_id) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $output.= '<option value="' . $r['prct_cat_id'] . '" ' . $selected . '>' . stripslashes($r['prct_cat']) . '</option>';
            }
        }
        return $output;
    }
    public function getTimeOptionsNew($start_time, $end_time, $time) {
        if ($end_time == $start_time) {
        } elseif ($end_time < $start_time) {
            $end_time = 24 + $end_time;
            $start = $start_time * 60 + 0;
            $end = $end_time * 60 + 0;
            $i = $start;
            while ($i < $end) {
                $minute = $i % 60;
                $hour = ($i - $minute) / 60;
                if ($hour > 23) {
                    $hour = $hour - 24;
                }
                if (($hour >= 0) && ($hour < 12)) {
                    $str = 'AM';
                } else {
                    $str = 'PM';
                }
                $val = sprintf('%02d:%02d', $hour, $minute);
                $val = $val . ' ' . $str;
                if ($time == $val) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $option_str.= '<option value="' . $val . '" ' . $selected . ' >' . $val . '</option>';
                $i = $i + 15;
            }
        } else {
            $start = $start_time * 60 + 0;
            $end = $end_time * 60 + 0;
            for ($i = $start;$i < $end;$i+= 15) {
                $minute = $i % 60;
                $hour = ($i - $minute) / 60;
                if (($hour >= 24) && ($hour <= 36)) {
                    $hour = $hour - 24;
                }
                if (($hour >= 0) && ($hour < 12)) {
                    $str = 'AM';
                } else {
                    $str = 'PM';
                }
                $val = sprintf('%02d:%02d', $hour, $minute);
                $val = $val . ' ' . $str;
                if ($time == $val) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                $option_str.= '<option value="' . $val . '" ' . $selected . ' >' . $val . '</option>';
            }
        }
        return $option_str;
    }
    public function getHeightOptions($height_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';
        $sql = "SELECT * FROM `tblheights` ORDER BY `height_cms` ASC";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['height_id'] == $height_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $option_str.= '<option value="' . $row['height_id'] . '" ' . $sel . '>' . $row['height_cms'] . ' cms (' . $row['height_feet_inch'] . ')</option>';
            }
        }
        return $option_str;
    }
    public function chkValidPassword($password) {
        $r1 = '/[A-Z]/'; //Uppercase
        $r2 = '/[a-z]/'; //lowercase
        $r3 = '/[!@#$%^&*()\-_=+{};:,<.>]/'; // whatever you mean by 'special char'
        $r4 = '/[0-9]/'; //numbers
        if (preg_match_all($r1, $password, $o) < 1) return false;
        if (preg_match_all($r2, $password, $o) < 1) return false;
        if (preg_match_all($r3, $password, $o) < 1) return false;
        if (preg_match_all($r4, $password, $o) < 1) return false;
        if (strlen($password) < 6) return false;
        return true;
    }
    public function getFavCatBYProfileId($parent_cat_id, $cat_id) {
        $DBH = new DatabaseHandler();
        $output = '';
        try {
            $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' and tblcustomfavcategory.cat_deleted ='0' and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                    if ($r['favcat_id'] == $cat_id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    $output.= '<option value="' . $r['favcat_id'] . '" ' . $selected . '>' . $r['fav_cat'] . '</option>';
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[getMainProfileOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
            $this->debuglog($stringData);
            return $output;
        }
        return $output;
    }
    public function getEventCategoryRamakant($page_id, $healcareandwellbeing) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';
        $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE `page_name`= '" . $page_id . "' and `pag_cat_status` = 1 and `is_deleted` = 0 ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $option_str.= '<option value="">Select Type</option>';
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['healcareandwellbeing'] == $healcareandwellbeing) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $option_str.= '<option value="' . $row['healcareandwellbeing'] . '" ' . $sel . '>' . stripslashes($this->getFavCatNameById($row['healcareandwellbeing'])) . '</option>';
            }
        }
        return $option_str;
    }
    public function getPageCatDropdownValue($page_name, $healcareandwellbeing) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE  page_name ='" . $page_name . "' and `healcareandwellbeing` = '" . $healcareandwellbeing . "'  ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $data = $STH->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    public function getMoreFavCategoryTypeOptions($fav_cat_id, $fav_cat_type_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';
        $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN ('" . $fav_cat_id . "') ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $option_str.= '<option value="">Select Type</option>';
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['prct_cat_id'] == $fav_cat_type_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $option_str.= '<option value="' . $row['prct_cat_id'] . '" ' . $sel . '>' . stripslashes($row['prct_cat']) . '</option>';
            }
        }
        return $option_str;
    }
    public function getSelectedSubCatbyidVivek($page_cat_id) {
        $DBH = new DatabaseHandler();
        //            $DBH = $my_DBH->raw_handle();
        //            $DBH->beginTransaction();
        $return = '';
        $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '" . $page_cat_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $return = $row['sub_cat1'];
        }
        return $return;
    }
    public function getAllCategoryChkeckboxEvent($id_no, $parent_cat_id, $arr_selected_cat_id, $cat_id = '', $adviser_panel = '', $width = '300', $height = '250') {
        $DBH = new DatabaseHandler();
        //            $DBH = $my_DBH->raw_handle();
        //            $DBH->beginTransaction();
        $output = '';
        if ($adviser_panel == '') {
            $sql_str_search = "";
        } else {
            //                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            
        }
        //            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";
        $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            //                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
            //                                <input type="checkbox" name="fav_cat_'.$id_no.'" id="fav_cat_'.$id_no.'" value="1" onclick="toggleCheckBoxes(\'selected_cat_id1\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong>
            //                            </div>
            //                            <div style="clear:both;"></div>';
            $output.= '<div style="width:' . $width . 'px;height:' . $height . 'px;float:left;overflow:scroll;">';
            $output.= '	<ul style="list-style:none;padding:0px;margin:0px;">';
            $i = 1;
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $prct_cat_id = $row['favcat_id'];
                $cat_name = stripslashes($row['fav_cat']);
                if (in_array($prct_cat_id, $arr_selected_cat_id)) {
                    $selected = ' checked ';
                } else {
                    $selected = '';
                }
                //$liwidth = $width - 20;
                $liwidth = 300;
                $output.= '<li style="padding:0px;width:' . $liwidth . 'px;float:left;"><input type="checkbox" ' . $selected . ' name="fav_cat_' . $id_no . '[]" id="selected_cat_id1_' . $i . '" value="' . $prct_cat_id . '"  />&nbsp;<strong>' . $cat_name . '</strong></li>';
                $i++;
            }
            $output.= '</div>';
        }
        return $output;
    }
    public function addEventCerification($tdata) {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
        try {
            $sql = "INSERT INTO `tbl_event_certificates`(`user_id`, `user_type`, `event_master_id`, `event_id`, `certificate_type`, `certificate_name`, `certificate_number`, `certificate_issue_date`, `certificate_issue_by`, `certificate_validity_date`, `certificate_scan_copy`,data_type) " . "VALUES (:user_id,:user_type,:event_master_id,:event_id,:certificate_type,:certificate_name,:certificate_number,:certificate_issue_date,:certificate_issue_by,:certificate_validity_date,:certificate_scan_copy,:data_type)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':user_id' => $tdata['user_id'], ':user_type' => addslashes($tdata['user_type']), ':event_master_id' => addslashes($tdata['event_master_id']), ':event_id' => addslashes($tdata['event_id']), ':certificate_type' => addslashes($tdata['certificate_type']), ':certificate_name' => addslashes($tdata['certificate_name']), ':certificate_number' => addslashes($tdata['certificate_number']), ':certificate_issue_date' => date("Y-m-d", strtotime($tdata['certificate_issue_date'])), ':certificate_issue_by' => addslashes($tdata['certificate_issue_by']), ':certificate_validity_date' => date("Y-m-d", strtotime($tdata['certificate_validity_date'])), ':certificate_scan_copy' => $tdata['certificate_scan_copy'], ':data_type' => addslashes($tdata['data_type'])));
            $return = $DBH->lastInsertId();
            $DBH->commit();
        }
        catch(Exception $e) {
            $stringData = '[addVendorCerification] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
    public function addEvent($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        try {
            $sql = "INSERT INTO `tbl_event_master`(`reference_number`,`wellbeing_id`,`prof_cat_id_1`, `fav_cat_id_1`, `prof_cat_id_2`, `fav_cat_id_2`, `prof_cat_id_3`, `fav_cat_id_3`, `prof_cat_id_4`, `fav_cat_id_4`, `prof_cat_id_5`, `fav_cat_id_5`, `organiser_id`, `institution_id`, `sponsor_id`, `event_name`, `event_contents`,`posted_by`, `admin_type`,`event_tags`) " . "VALUES (:reference_number,:healcareandwellbeing,:prof_cat_id_1,:fav_cat_id_1,:prof_cat_id_2,:fav_cat_id_2,:prof_cat_id_3,:fav_cat_id_3,:prof_cat_id_4,:fav_cat_id_4,:prof_cat_id_5,:fav_cat_id_5,:organiser_id,:institution_id,:sponsor_id,:event_name,:event_contents,:posted_by,:admin_type,:event_tags)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':reference_number' => addslashes($tdata['reference_number']), ':healcareandwellbeing' => addslashes($tdata['healcareandwellbeing']), ':prof_cat_id_1' => $tdata['profile_cat_1'], ':fav_cat_id_1' => addslashes($tdata['fav_cat_1']), ':prof_cat_id_2' => $tdata['profile_cat_2'], ':fav_cat_id_2' => addslashes($tdata['fav_cat_2']), ':prof_cat_id_3' => $tdata['profile_cat_3'], ':fav_cat_id_3' => addslashes($tdata['fav_cat_3']), ':prof_cat_id_4' => $tdata['profile_cat_4'], ':fav_cat_id_4' => addslashes($tdata['fav_cat_4']), ':prof_cat_id_5' => $tdata['profile_cat_5'], ':fav_cat_id_5' => addslashes($tdata['fav_cat_5']), ':organiser_id' => $tdata['organiser_id'], ':institution_id' => $tdata['institution_id'], ':sponsor_id' => $tdata['sponsor_id'], ':event_name' => addslashes($tdata['event_name']), ':event_contents' => addslashes($tdata['event_contents']), ':posted_by' => $tdata['admin_id'], ':admin_type' => 'Vendor', ':event_tags' => $tdata['event_tags']));
            $event_master_id = $DBH->lastInsertId();
            if ($event_master_id > 0) {

                $return = true;

            }
            $DBH->commit();
        }
        catch(Exception $e) {
            $stringData = '[addVendor] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
     public function addEventLocInfo($tdata)
    {   

         $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
            $event_master_id=$tdata['event_master_id'];
            if ($event_master_id > 0) {
               
                if (count($tdata['vloc_parent_cat_id']) > 0) {
                    //print_r($tdata['vloc_parent_cat_id']);
                    for ($i = 0;$i < count($tdata['vloc_parent_cat_id']);$i++) {
                        $tdata_vloc = array();
                        $tdata_vloc['event_master_id'] = $event_master_id;
                        $tdata_vloc['location_category'] = $tdata['vloc_parent_cat_id'][$i];
                        $tdata_vloc['location_sub_category'] = $tdata['vloc_cat_id'][$i];
                        $tdata_vloc['country_id'] = $tdata['country_id'][$i];
                        $tdata_vloc['state_id'] = $tdata['state_id'][$i];
                        $tdata_vloc['city_id'] = $this->getCityIdbyName($tdata['city_id'][$i]);
                        $tdata_vloc['area_id'] = $tdata['area_id'][$i];
                        $tdata_vloc['venue_details'] = $tdata['venue'][$i];
                        $tdata_vloc['start_date'] = $tdata['start_date'][$i];
                        $tdata_vloc['start_time'] = $tdata['start_time'][$i];
                        $tdata_vloc['end_date'] = $tdata['end_date'][$i];
                        $tdata_vloc['end_time'] = $tdata['end_time'][$i];
                        $tdata_vloc['time_zone_id'] = $tdata['time_zone'][$i];
                        $tdata_vloc['venue_image'] = $tdata['venue_image_file'][$i];
                        $tdata_vloc['event_image'] = $tdata['event_image_file'][$i];
                        $tdata_vloc['no_of_groups'] = $tdata['no_of_groups'][$i];
                        $tdata_vloc['no_of_teams'] = $tdata['no_of_teams'][$i];
                        $tdata_vloc['no_of_participants'] = $tdata['no_of_participants'][$i];
                        $tdata_vloc['no_of_judges'] = $tdata['no_of_judges'][$i];
                        $tdata_vloc['rules_regulation_pdf'] = $tdata['vloc_menu_file'][$i];
                        $tdata_vloc['institution_profile_pdf'] = $tdata['vloc_doc_file'][$i];
                        //add by ample 22-09-20
                        $tdata_vloc['online_registration_link'] = $tdata['online_registration_link'][$i];
                        $tdata_vloc['online_registration_id'] = $tdata['online_registration_id'][$i];
                        //add by ample 20-12-19
                        // $tdata_vloc['participants_profile']=$tdata['participants_profile'][$i];
                        // $tdata_vloc['participants_gender']=$tdata['participants_title'][$i];
                        // $tdata_vloc['participants_special_remark']=$tdata['parti_remarks'][$i];
                        // $tdata_vloc['participants_from_age_group']=$tdata['from_age'][$i];
                        // $tdata_vloc['participants_to_age_group']=$tdata['to_age'][$i];
                        // $tdata_vloc['participants_from_height']=$tdata['from_height'][$i];
                        // $tdata_vloc['participants_to_height']=$tdata['to_height'][$i];
                        // $tdata_vloc['participants_from_weight']=$tdata['from_weight'][$i];
                        // $tdata_vloc['participants_to_weight']=$tdata['to_weight'][$i];
                        $tdata_vloc['participants_profile'] = '';
                        $tdata_vloc['participants_gender'] = '';
                        $tdata_vloc['participants_special_remark'] = '';
                        $tdata_vloc['participants_from_age_group'] = '';
                        $tdata_vloc['participants_to_age_group'] = '';
                        $tdata_vloc['participants_from_height'] = '';
                        $tdata_vloc['participants_to_height'] = '';
                        $tdata_vloc['participants_from_weight'] = '';
                        $tdata_vloc['participants_to_weight'] = '';
                        $tdata_vloc['judge_gender'] = $tdata['judge_title'][$i];
                        $tdata_vloc['judge_special_remark'] = $tdata['judge_remarks'][$i];
                        $tdata_vloc['organiser_facebook_page'] = $tdata['facebook_page_link'][$i];
                        $tdata_vloc['organiser_twitter_page'] = $tdata['twitter_page_link'][$i];
                        $tdata_vloc['organiser_instagram_page'] = $tdata['instagram_page_link'][$i];
                        $tdata_vloc['organiser_youtube_channel'] = $tdata['youtube_page_link'][$i];
                        $tdata_vloc['organiser_gender'] = $tdata['contact_person_title'][$i];
                        $tdata_vloc['organiser_contact_person'] = $tdata['contact_person'][$i];
                        $tdata_vloc['organiser_email'] = $tdata['contact_email'][$i];
                        $tdata_vloc['organiser_contact_number'] = $tdata['contact_number'][$i];
                        $tdata_vloc['organiser_designation'] = $tdata['contact_designation'][$i];
                        $tdata_vloc['organiser_remarks'] = $tdata['contact_remark'][$i];
                        $tdata_vloc['event_format'] = $tdata['event_format'][$i];
                        $tdata_vloc['slot1_start_time'] = $tdata['slot1_start_time'][$i];
                        $tdata_vloc['slot1_end_time'] = $tdata['slot1_end_time'][$i];
                        $tdata_vloc['slot2_start_time'] = $tdata['slot2_start_time'][$i];
                        $tdata_vloc['slot2_end_time'] = $tdata['slot2_end_time'][$i];
                        $tdata_vloc['slot3_start_time'] = $tdata['slot3_start_time'][$i];
                        $tdata_vloc['slot3_end_time'] = $tdata['slot3_end_time'][$i];
                        $tdata_vloc['slot4_start_time'] = $tdata['slot4_start_time'][$i];
                        $tdata_vloc['slot4_end_time'] = $tdata['slot4_end_time'][$i];
                        $tdata_vloc['slot5_start_time'] = $tdata['slot5_start_time'][$i];
                        $tdata_vloc['slot5_end_time'] = $tdata['slot5_end_time'][$i];
                        $tdata_vloc['slot6_start_time'] = $tdata['slot6_start_time'][$i];
                        $tdata_vloc['slot6_end_time'] = $tdata['slot6_end_time'][$i];
                        $vloc_id = $this->addEventLocation($tdata_vloc);
                        if ($vloc_id > 0) {
                            $return = true;
                            // add by ample 24-12-19
                            for ($k = 0;$k < count($tdata['pp_type_id'][$i]);$k++) {
                                $tdata_pp = array();
                                $tdata_pp['event_master_id'] = $event_master_id;
                                $tdata_pp['event_id'] = $vloc_id;
                                $tdata_pp['profile'] = $tdata['pp_type_id'][$i][$k];
                                $tdata_pp['gender'] = $tdata['pp_gender'][$i][$k];
                                $tdata_pp['special_remark'] = $tdata['pp_remark'][$i][$k];
                                $tdata_pp['from_age_group'] = $tdata['pp_from_age'][$i][$k];
                                $tdata_pp['to_age_group'] = $tdata['pp_to_age'][$i][$k];
                                $tdata_pp['from_height'] = $tdata['pp_from_height'][$i][$k];
                                $tdata_pp['to_height'] = $tdata['pp_to_height'][$i][$k];
                                $tdata_pp['from_weight'] = $tdata['pp_from_weight'][$i][$k];
                                $tdata_pp['to_weight'] = $tdata['pp_to_weight'][$i][$k];
                                $tdata_pp['added_by'] = $tdata['admin_id'];
                                $pp_criteria_id = $this->addEventCriteria($tdata_pp);
                            }
                            for ($k = 0;$k < count($tdata['org_cert_type_id'][$i]);$k++) {
                                $tdata_vc = array();
                                $tdata_vc['user_id'] = $tdata['organiser_id'];
                                $tdata_vc['event_master_id'] = $event_master_id;
                                $tdata_vc['user_type'] = 'ORG';
                                $tdata_vc['data_type'] = 'Organiser';
                                $tdata_vc['event_id'] = $vloc_id;
                                $tdata_vc['certificate_type'] = $tdata['org_cert_type_id'][$i][$k];
                                $tdata_vc['certificate_name'] = $tdata['org_cert_name'][$i][$k];
                                $tdata_vc['certificate_number'] = $tdata['org_cert_no'][$i][$k];
                                $tdata_vc['certificate_issue_date'] = $tdata['org_cert_reg_date'][$i][$k];
                                $tdata_vc['certificate_issue_by'] = $tdata['org_cert_issued_by'][$i][$k];
                                $tdata_vc['certificate_validity_date'] = $tdata['org_cert_validity_date'][$i][$k];
                                $tdata_vc['certificate_scan_copy'] = $tdata['org_cert_scan_file'][$i][$k];
                                $vc_cert_id = $this->addEventCerification($tdata_vc);
                            }
                            //add by ample for participate 20-12-19
                            // for($k=0;$k<count($tdata['vc_cert_type_id'][$i]);$k++)
                            // {
                            //  $tdata_pc = array();
                            //                          $tdata_pc['user_id'] = $tdata['organiser_id'];
                            //  $tdata_pc['event_master_id'] = $event_master_id;
                            //  $tdata_pc['user_type'] ='ORG';
                            //                          $tdata_pc['data_type'] ='Participant';
                            //  $tdata_pc['event_id'] = $vloc_id;
                            //  $tdata_pc['certificate_type'] = $tdata['vc_cert_type_id'][$i][$k];
                            //  $tdata_pc['certificate_name'] = $tdata['vc_cert_name'][$i][$k];
                            //  $tdata_pc['certificate_number'] = $tdata['vc_cert_no'][$i][$k];
                            //  $tdata_pc['certificate_issue_date'] = $tdata['vc_cert_reg_date'][$i][$k];
                            //  $tdata_pc['certificate_issue_by'] = $tdata['vc_cert_issued_by'][$i][$k];
                            //  $tdata_pc['certificate_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
                            //  $tdata_pc['certificate_scan_copy'] = $tdata['vc_cert_scan_file'][$i][$k];
                            //  $pc_cert_id = $this->addEventCerification($tdata_pc);
                            // }
                            //add by ample for judge 20-12-19
                            for ($k = 0;$k < count($tdata['judge_cert_type_id'][$i]);$k++) {
                                $tdata_jc = array();
                                $tdata_jc['user_id'] = $tdata['organiser_id'];
                                $tdata_jc['event_master_id'] = $event_master_id;
                                $tdata_jc['user_type'] = 'ORG';
                                $tdata_jc['data_type'] = 'Judge';
                                $tdata_jc['event_id'] = $vloc_id;
                                $tdata_jc['certificate_type'] = $tdata['judge_cert_type_id'][$i][$k];
                                $tdata_jc['certificate_name'] = $tdata['judge_cert_name'][$i][$k];
                                $tdata_jc['certificate_number'] = $tdata['judge_cert_no'][$i][$k];
                                $tdata_jc['certificate_issue_date'] = $tdata['judge_cert_reg_date'][$i][$k];
                                $tdata_jc['certificate_issue_by'] = $tdata['judge_cert_issued_by'][$i][$k];
                                $tdata_jc['certificate_validity_date'] = $tdata['judge_cert_validity_date'][$i][$k];
                                $tdata_jc['certificate_scan_copy'] = $tdata['judge_cert_scan_file'][$i][$k];
                                $jc_cert_id = $this->addEventCerification($tdata_jc);
                            }
                            $date1 = date_create($tdata['start_date'][$i]);
                            $date2 = date_create($tdata['end_date'][$i]);
                            $diff = date_diff($date1, $date2);
                            $diff_count = $diff->format("%a");
                            for ($j = 0;$j <= $diff_count;$j++) {
                                $tdata_ett = array();
                                $tdata_ett['event_master_id'] = $event_master_id;
                                $tdata_ett['event_id'] = $vloc_id;
                                $tdata_ett['event_start_date'] = date("Y-m-d", strtotime($tdata['start_date'][$i] . $j . ' days'));
                                $tdata_ett['event_days'] = date('l', strtotime($tdata_ett['event_start_date']));
                                $tdata_ett['event_end_date'] = date("Y-m-d", strtotime($tdata['end_date'][$i]));
                                $tdata_ett['event_start_time'] = $tdata['start_time'][$i];
                                $tdata_ett['event_end_time'] = $tdata['end_time'][$i];
                                $this->AddEventTimeTable($tdata_ett);
                            }
                        }
                    }
                }
                //$return = true;
                
            }
          
        return $return;
    }
    public function addEventLocation($tdata) {
        //print_r($tdata);
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
        try {
            //update by ample 20-12-19
            $sql = "INSERT INTO `tbl_event_details`(`event_master_id`, `location_category`, `location_sub_category`,`country_id`,`state_id`,`city_id`, `area_id`, `venue_details`, `start_date`, `start_time`, `end_date`, `end_time`, `time_zone_id`, `venue_image`, `event_image`, `no_of_groups`, `no_of_teams`, `no_of_participants`, `no_of_judges`, `rules_regulation_pdf`, `institution_profile_pdf`, `participants_gender`, `participants_special_remark`, `participants_from_age_group`, `participants_to_age_group`, `participants_from_height`,`participants_to_height`, `participants_from_weight`,`participants_to_weight`, `judge_gender`, `judge_special_remark`, `organiser_facebook_page`, `organiser_twitter_page`, `organiser_instagram_page`, `organiser_youtube_channel`, `organiser_gender`, `organiser_contact_person`, `organiser_email`, `organiser_contact_number`, `organiser_designation`, `organiser_remarks`,`event_format`,`slot1_start_time`,`slot1_end_time`,`slot2_start_time`,`slot2_end_time`,`slot3_start_time`,`slot3_end_time`,`slot4_start_time`,`slot4_end_time`,`slot5_start_time`,`slot5_end_time`,`slot6_start_time`,`slot6_end_time`,`participants_profile`,`online_registration_link`,`online_registration_id`) " . "VALUES (:event_master_id,:location_category,:location_sub_category,:country_id,:state_id,:city_id,:area_id,:venue_details,:start_date,:start_time,:end_date,:end_time,:time_zone_id,:venue_image,:event_image,:no_of_groups,:no_of_teams,:no_of_participants,:no_of_judges,:rules_regulation_pdf,:institution_profile_pdf,:participants_gender,:participants_special_remark,:participants_from_age_group,:participants_to_age_group,:participants_from_height,:participants_to_height,:participants_from_weight,:participants_to_weight,:judge_gender,:judge_special_remark,:organiser_facebook_page,:organiser_twitter_page,:organiser_instagram_page,:organiser_youtube_channel,:organiser_gender,:organiser_contact_person,:organiser_email,:organiser_contact_number,:organiser_designation,:organiser_remarks,:event_format,:slot1_start_time,:slot1_end_time,:slot2_start_time,:slot2_end_time,:slot3_start_time,:slot3_end_time,:slot4_start_time,:slot4_end_time,:slot5_start_time,:slot5_end_time,:slot6_start_time,:slot6_end_time,:participants_profile,:online_registration_link,:online_registration_id)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_master_id' => $tdata['event_master_id'], ':location_category' => $tdata['location_category'], ':location_sub_category' => $tdata['location_sub_category'], ':country_id' => $tdata['country_id'], ':state_id' => $tdata['state_id'], ':city_id' => $tdata['city_id'], ':area_id' => $tdata['area_id'], ':venue_details' => addslashes($tdata['venue_details']), ':start_date' => date("Y-m-d", strtotime($tdata['start_date'])), ':start_time' => addslashes($tdata['start_time']), ':end_date' => date("Y-m-d", strtotime($tdata['end_date'])), ':end_time' => addslashes($tdata['end_time']), ':time_zone_id' => $tdata['time_zone_id'], ':venue_image' => addslashes($tdata['venue_image']), ':event_image' => addslashes($tdata['event_image']), ':no_of_groups' => $tdata['no_of_groups'], ':no_of_teams' => $tdata['no_of_teams'], ':no_of_participants' => $tdata['no_of_participants'], ':no_of_judges' => $tdata['no_of_judges'], ':rules_regulation_pdf' => addslashes($tdata['rules_regulation_pdf']), ':institution_profile_pdf' => addslashes($tdata['institution_profile_pdf']), ':participants_gender' => addslashes($tdata['participants_gender']), ':participants_special_remark' => addslashes($tdata['participants_special_remark']), ':participants_from_age_group' => $tdata['participants_from_age_group'], ':participants_to_age_group' => $tdata['participants_to_age_group'], ':participants_from_height' => addslashes($tdata['participants_from_height']), ':participants_to_height' => addslashes($tdata['participants_to_height']), ':participants_from_weight' => addslashes($tdata['participants_from_weight']), ':participants_to_weight' => addslashes($tdata['participants_to_weight']), ':judge_gender' => addslashes($tdata['judge_gender']), ':judge_special_remark' => addslashes($tdata['judge_special_remark']), ':organiser_facebook_page' => addslashes($tdata['organiser_facebook_page']), ':organiser_twitter_page' => addslashes($tdata['organiser_twitter_page']), ':organiser_instagram_page' => addslashes($tdata['organiser_instagram_page']), ':organiser_youtube_channel' => addslashes($tdata['organiser_youtube_channel']), ':organiser_gender' => addslashes($tdata['organiser_gender']), ':organiser_contact_person' => addslashes($tdata['organiser_contact_person']), ':organiser_email' => addslashes($tdata['organiser_email']), ':organiser_contact_number' => addslashes($tdata['organiser_contact_number']), ':organiser_designation' => addslashes($tdata['organiser_designation']), ':organiser_remarks' => addslashes($tdata['organiser_remarks']), ':event_format' => addslashes($tdata['event_format']), ':slot1_start_time' => addslashes($tdata['slot1_start_time']), ':slot1_end_time' => addslashes($tdata['slot1_end_time']), ':slot2_start_time' => addslashes($tdata['slot2_start_time']), ':slot2_end_time' => addslashes($tdata['slot2_end_time']), ':slot3_start_time' => addslashes($tdata['slot3_start_time']), ':slot3_end_time' => addslashes($tdata['slot3_end_time']), ':slot4_start_time' => addslashes($tdata['slot4_start_time']), ':slot4_end_time' => addslashes($tdata['slot4_end_time']), ':slot5_start_time' => addslashes($tdata['slot5_start_time']), ':slot5_end_time' => addslashes($tdata['slot5_end_time']), ':slot6_start_time' => addslashes($tdata['slot6_start_time']), ':slot6_end_time' => addslashes($tdata['slot6_end_time']), ':participants_profile' => $tdata['participants_profile'], ':online_registration_link' => addslashes($tdata['online_registration_link']), ':online_registration_id' => $tdata['online_registration_id']));
            $return = $DBH->lastInsertId();
            $DBH->commit();
            //start code by ample 10-09-20
            if($return)
            {
                if(isset($tdata['event_id']) && !empty($tdata['event_id']))
                {   
                    $this->event_update_in_event_loc_price($tdata['event_id'],$return);
                    $this->event_update_in_event_price($tdata['event_id'],$return);
                }
            }
            //end code by ample 10-09-20
        }
        catch(Exception $e) {
            $stringData = '[addVendorLocation] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
    //add by ample 24-12-19
    public function addEventCriteria($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
        try {
            $sql = "INSERT INTO `tbl_event_participants_criteria`(`event_master_id`, `event_id`, `profile`, `gender`, `special_remark`, `from_age_group`, `to_age_group`, `from_height`, `to_height`, `from_weight`, `to_weight`,`added_by`) " . "VALUES (:event_master_id,:event_id,:profile,:gender,:special_remark,:from_age_group,:to_age_group,:from_height,:to_height,:from_weight,:to_weight,:added_by)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_master_id' => addslashes($tdata['event_master_id']), ':event_id' => addslashes($tdata['event_id']), ':profile' => addslashes($tdata['profile']), ':gender' => addslashes($tdata['gender']), ':special_remark' => addslashes($tdata['special_remark']), ':from_age_group' => addslashes($tdata['from_age_group']), ':to_age_group' => addslashes($tdata['to_age_group']), ':from_height' => addslashes($tdata['from_height']), ':to_height' => addslashes($tdata['to_height']), ':from_weight' => addslashes($tdata['from_weight']), ':to_weight' => addslashes($tdata['to_weight']), ':added_by' => addslashes($tdata['added_by'])));
            $return = $DBH->lastInsertId();
            $DBH->commit();
        }
        catch(Exception $e) {
            $stringData = '[addEventCriteria] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
    //update by ample 22-12-20
    public function GetAllEventDetails($txtsearch, $status, $parent_cat_id, $sub_cat_id, $country_id, $state_id, $city_id, $area_id, $vendor_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $date = date("Y-m-d");
        $sql_search_str = "";
        if ($txtsearch != '') {
            $sql_search_str = " AND (TEM.event_name LIKE '%" . $txtsearch . "%' OR  TEM.event_tags LIKE '%" . $txtsearch . "%' ) ";
        }
        $sql_status_str = "";
        if ($status != '') {
            $sql_status_str = " AND TED.event_status = '" . $status . "' ";
        }
        $sql_main_cat_id = "";
        if ($cucat_parent_cat_id != '') {
            $sql_main_cat_id = " AND TED.location_category = " . $parent_cat_id . " ";
        }
        $sql_sub_cat_id = "";
        if ($cucat_cat_id != '') {
            $sql_sub_cat_id = " AND TED.location_sub_category = " . $sub_cat_id . "  ";
        }
        $sql_country_str = "";
        if ($country_id != '') {
            $sql_country_str = " AND TED.country_id = '" . $country_id . "' ";
        }
        $sql_state_str = "";
        if ($state_id != '') {
            $sql_state_str = " AND TED.state_id = '" . $state_id . "' ";
        }
        $sql_city_str = "";
        if ($city_id != '') {
            $sql_city_str = " AND TED.city_id = '" .$this->getCityIdbyName($city_id). "' ";
        }
        $sql_area_str = "";
        if ($area_id != '') {
            $sql_area_str = " AND TED.area_id = '" . $area_id . "' ";
        }
       
        //$sql = "SELECT * from tbl_event_details where `event_status` = 1  and  `end_date` >= '".$date."'  order by event_id ASC";
       $sql = "SELECT TEM.posted_by,TED.event_add_date,TED.event_id,TED.event_master_id,TED.venue_details,TED.city_id,TED.start_date,TED.event_deleted,TED.start_time,TED.end_date,TED.end_time,TED.event_status,TEM.event_master_id,TEM.reference_number,TEM.organiser_id,TEM.institution_id,TEM.event_name from tbl_event_details TED " . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TEM.organiser_id = $vendor_id AND TED.event_status = 1 AND TED.event_deleted = 0 " . $sql_search_str . " " . $sql_status_str . " " . $sql_main_cat_id . " " . $sql_sub_cat_id . " " . $sql_country_str . " " . $sql_state_str . " " . $sql_city_str . " " . $sql_area_str . "  order by TED.event_id ASC";
        //$this->debuglog('[getAllVendors] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getIdByProfileFavCategoryName($fav_cat_id) {
        // $this->connectDB();
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $meal_item = array();
        $fav_cat_id = explode(',', $fav_cat_id);
        $fav_cat_id = implode('\',\'', $fav_cat_id);
        //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN('" . $fav_cat_id . "') ";
        // $this->execute_query($sql);
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $meal_item[] = stripslashes($row['fav_cat']);
            }
        }
        //print_r($meal_item) ;
        $final_value = implode(',', $meal_item);
        return $final_value;
    }
    public function getAllEventLocation($txtsearch = '', $status = '', $city_id = '', $area_id = '', $event_master_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql = "SELECT * from tbl_event_details where `event_master_id` = '" . $event_master_id . "' and `event_status` =1 and `event_deleted` = 0 order by event_id ASC";
        //$this->debuglog('[getAllVendors] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function GetEventDetails($event_master_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql = "SELECT * from tbl_event_master where `event_master_id` = '" . $event_master_id . "' and `status` = 1 and `is_deleted` = 0";
        //$this->debuglog('[getAllVendors] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records = $r;
            }
        }
        return $arr_records;
    }
    public function EventPriceLocationAvailable($event_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * from tbl_event_loc_price where `event_id` = '" . $event_id . "' and `culoc_status` = 1 and `culoc_deleted` = 0";
        //$this->debuglog('[getAllVendors] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //update by ample 17-09-20
    public function GETEVENTDETAILSBYID($event_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        //$sql = "SELECT * from tbl_event_details where `event_status` = 1  and  `end_date` >= '".$date."'  order by event_id ASC";
        $sql = "SELECT TEM.posted_by,TED.event_add_date,TED.event_id,TED.event_master_id,TED.venue_details,TED.city_id,TED.start_date,TED.start_time,TED.end_date,TED.end_time,TED.event_status,TEM.event_master_id,TEM.reference_number,TEM.organiser_id,TEM.institution_id,TEM.event_name,TEM.admin_type from tbl_event_details TED " . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1  AND  TED.event_id = '" . $event_id . "'  order by TED.event_id ASC";
        //$this->debuglog('[getAllVendors] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_records = $r;
        }
        return $arr_records;
    }
    public function getCouponOptions($discount_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $sql = "SELECT * FROM `tbldiscountcoupons` WHERE `dc_deleted` = 0 and `dc_status` = 1 ORDER BY `dc_id` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $str = '';
                if ($row['dc_type'] == 1) {
                    $str = 'discount : ' . $row['dc_percentage'] . '%';
                } else {
                    $str = 'discount : Rs' . $row['discount_price'];
                }
                if ($row['dc_id'] == $discount_id) {
                    $sel = 'selected';
                } else {
                    $sel = '';
                }
                //<option value="Paris">Paris</option>
                $option_str.= '<option value="' . $row['dc_id'] . '" ' . $sel . ' >' . stripslashes($row['discount_coupon']) . ' (' . $str . ')</option>';
            }
        }
        return $option_str;
    }
    public function addEventPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tbl_event_price`(`event_id`,`publish_date_type`, `publish_days_of_month`, " . "`publish_days_of_week`, `publish_single_date`, `publish_start_date`, `publish_end_date`, " . "`event_desc_1`, `event_desc_show_1`, `event_desc_2`, `event_desc_show_2`, `event_price_status`, " . "`added_by_admin`,`cancel_cutoff_time`, `cancel_cutoff_time_show`, " . "`cgst_tax`, `sgst_tax`, `cess_tax`, `gst_tax`, `registration_cutoff_time`, `registration_time_show`,`admin_type`) " . "VALUES (:event_id,:publish_date_type,:publish_days_of_month,:publish_days_of_week,:publish_single_date,:publish_start_date,:publish_end_date,:event_desc_1," . ":event_desc_show_1,:event_desc_2,:event_desc_show_2,:event_price_status,:added_by_admin,:cancel_cutoff_time,:cancel_cutoff_time_show,:cgst_tax," . ":sgst_tax,:cess_tax,:gst_tax,:registration_cutoff_time,:registration_time_show,:admin_type)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_id' => addslashes($tdata['event_id']), ':publish_date_type' => addslashes($tdata['publish_date_type']), ':publish_days_of_month' => addslashes($tdata['publish_days_of_month']), ':publish_days_of_week' => addslashes($tdata['publish_days_of_week']), ':publish_single_date' => addslashes($tdata['publish_single_date']), ':publish_start_date' => addslashes($tdata['publish_start_date']), ':publish_end_date' => addslashes($tdata['publish_end_date']), ':event_desc_1' => addslashes($tdata['cusine_desc_1']), ':event_desc_show_1' => addslashes($tdata['cusine_desc_show_1']), ':event_desc_2' => addslashes($tdata['cusine_desc_2']), ':event_desc_show_2' => addslashes($tdata['cusine_desc_show_2']), ':event_price_status' => '1', ':added_by_admin' => addslashes($tdata['added_by_admin']), ':admin_type' => addslashes($tdata['admin_type']), ':cancel_cutoff_time' => addslashes($tdata['cancel_cutoff_time']), ':cancel_cutoff_time_show' => addslashes($tdata['cancel_cutoff_time_show']), ':cgst_tax' => addslashes($tdata['cgst_tax']), ':sgst_tax' => addslashes($tdata['sgst_tax']), ':cess_tax' => addslashes($tdata['cess_tax']), ':gst_tax' => addslashes($tdata['gst_tax']), ':registration_cutoff_time' => addslashes($tdata['registration_cutoff_time']), ':registration_time_show' => addslashes($tdata['registration_time_show'])));
            $event_price_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($event_price_id > 0) {
                $return = true;
                if (count($tdata['registration_type_id']) > 0) {
                    for ($i = 0;$i < count($tdata['registration_type_id']);$i++) {
                        $tdata_loc = array();
                        $tdata_loc['event_id'] = $tdata['event_id'];
                        $tdata_loc['event_price_id'] = $event_price_id;
                        $tdata_loc['ticket_name'] = $tdata['ticket_name'][$i];
                        $tdata_loc['ordering_type_id'] = $tdata['ordering_type_id'][$i];
                        $tdata_loc['max_order'] = $tdata['max_order'][$i];
                        $tdata_loc['min_order'] = $tdata['min_order'][$i];
                        $tdata_loc['cusine_qty'] = $tdata['cusine_qty'][$i];
                        $tdata_loc['currency_id'] = $tdata['currency_id'][$i];
                        $tdata_loc['cusine_price'] = $tdata['ticket_price'][$i];
                        $tdata_loc['default_price'] = $tdata['default_price'][$i];
                        $tdata_loc['cusine_qty_show'] = $tdata['cusine_qty_show'][$i];
                        $tdata_loc['sold_qty_show'] = $tdata['sold_qty_show'][$i];
                        $tdata_loc['is_offer'] = $tdata['is_offer'][$i];
                        $tdata_loc['offer_price'] = $tdata['offer_price'][$i];
                        $tdata_loc['offer_date_type'] = $tdata['offer_date_type'][$i];
                        $tdata_loc['offer_days_of_month'] = $tdata['offer_days_of_month'][$i];
                        $tdata_loc['offer_days_of_week'] = $tdata['offer_days_of_week'][$i];
                        $tdata_loc['offer_single_date'] = $tdata['offer_single_date'][$i];
                        $tdata_loc['offer_start_date'] = $tdata['offer_start_date'][$i];
                        $tdata_loc['offer_end_date'] = $tdata['offer_end_date'][$i];
                        $tdata_loc['is_discount'] = $tdata['is_discount'][$i];
                        $tdata_loc['discount_date_type'] = $tdata['discount_date_type'][$i];
                        $tdata_loc['discount_days_of_month'] = $tdata['discount_days_of_month'][$i];
                        $tdata_loc['discount_days_of_week'] = $tdata['discount_days_of_week'][$i];
                        $tdata_loc['discount_single_date'] = $tdata['discount_single_date'][$i];
                        $tdata_loc['discount_start_date'] = $tdata['discount_start_date'][$i];
                        $tdata_loc['discount_end_date'] = $tdata['discount_end_date'][$i];
                        $tdata_loc['discount_code'] = $tdata['discount_code'][$i];
                        $tdata_loc['bulk_booking_allowed'] = $tdata['is_bulk_booking'][$i];
                        $tdata_loc['registration_type'] = $tdata['registration_type_id'][$i];
                        $tdata_loc['registration_fees'] = $tdata['registration_fees'][$i];
                        $tdata_loc['registration_show'] = $tdata['registration_show'][$i];
                        $tdata_loc['currency_fees'] = $tdata['reg_currency_id'][$i];
                        $tdata_loc['registration_criteria'] = $tdata['registration_criteria'][$i];
                        $tdata_loc['culoc_status'] = 1;
                        $tdata_loc['added_by_admin'] = $tdata['added_by_admin'];
                        $this->addEventPriceLocation($tdata_loc);
                    }
                }
                if (count($tdata['cucat_parent_cat_id']) > 0) {
                    for ($i = 0;$i < count($tdata['cucat_parent_cat_id']);$i++) {
                        $tdata_cat = array();
                        $tdata_cat['event_id'] = $tdata['event_id'];
                        $tdata_cat['event_price_id'] = $event_price_id;
                        $tdata_cat['cucat_parent_cat_id'] = $tdata['cucat_parent_cat_id'][$i];
                        $tdata_cat['cucat_cat_id'] = $tdata['cucat_cat_id'][$i];
                        $tdata_cat['cucat_show'] = $tdata['cucat_show'][$i];
                        $tdata_cat['cucat_status'] = 1;
                        $tdata_cat['added_by_admin'] = $tdata['added_by_admin'];
                        $this->addEventLocCategory($tdata_cat);
                    }
                }
            }
        }
        catch(Exception $e) {
            $stringData = '[addCusine] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //copy and update by ample 15-09-20
     public function addEventPriceDetail($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
     
            $event_price_id = $tdata['event_price_id'];
           
            if ($event_price_id > 0) {

                if (count($tdata['registration_type_id']) > 0) {
                    for ($i = 0;$i < count($tdata['registration_type_id']);$i++) {
                        $tdata_loc = array();
                        $tdata_loc['event_id'] = $tdata['event_id'];
                        $tdata_loc['event_price_id'] = $event_price_id;
                        $tdata_loc['ticket_name'] = $tdata['ticket_name'][$i];
                        $tdata_loc['ordering_type_id'] = $tdata['ordering_type_id'][$i];
                        $tdata_loc['max_order'] = $tdata['max_order'][$i];
                        $tdata_loc['min_order'] = $tdata['min_order'][$i];
                        $tdata_loc['cusine_qty'] = $tdata['cusine_qty'][$i];
                        $tdata_loc['currency_id'] = $tdata['currency_id'][$i];
                        $tdata_loc['cusine_price'] = $tdata['ticket_price'][$i];
                        $tdata_loc['default_price'] = $tdata['default_price'][$i];
                        $tdata_loc['cusine_qty_show'] = $tdata['cusine_qty_show'][$i];
                        $tdata_loc['sold_qty_show'] = $tdata['sold_qty_show'][$i];
                        $tdata_loc['is_offer'] = $tdata['is_offer'][$i];
                        $tdata_loc['offer_price'] = $tdata['offer_price'][$i];
                        $tdata_loc['offer_date_type'] = $tdata['offer_date_type'][$i];
                        $tdata_loc['offer_days_of_month'] = $tdata['offer_days_of_month'][$i];
                        $tdata_loc['offer_days_of_week'] = $tdata['offer_days_of_week'][$i];
                        $tdata_loc['offer_single_date'] = $tdata['offer_single_date'][$i];
                        $tdata_loc['offer_start_date'] = $tdata['offer_start_date'][$i];
                        $tdata_loc['offer_end_date'] = $tdata['offer_end_date'][$i];
                        $tdata_loc['is_discount'] = $tdata['is_discount'][$i];
                        $tdata_loc['discount_date_type'] = $tdata['discount_date_type'][$i];
                        $tdata_loc['discount_days_of_month'] = $tdata['discount_days_of_month'][$i];
                        $tdata_loc['discount_days_of_week'] = $tdata['discount_days_of_week'][$i];
                        $tdata_loc['discount_single_date'] = $tdata['discount_single_date'][$i];
                        $tdata_loc['discount_start_date'] = $tdata['discount_start_date'][$i];
                        $tdata_loc['discount_end_date'] = $tdata['discount_end_date'][$i];
                        $tdata_loc['discount_code'] = $tdata['discount_code'][$i];
                        $tdata_loc['bulk_booking_allowed'] = $tdata['is_bulk_booking'][$i];
                        $tdata_loc['registration_type'] = $tdata['registration_type_id'][$i];
                        $tdata_loc['registration_fees'] = $tdata['registration_fees'][$i];
                        $tdata_loc['registration_show'] = $tdata['registration_show'][$i];
                        $tdata_loc['currency_fees'] = $tdata['reg_currency_id'][$i];
                        $tdata_loc['registration_criteria'] = $tdata['registration_criteria'][$i];
                        $tdata_loc['culoc_status'] = 1;
                        $tdata_loc['added_by_admin'] = $tdata['added_by_admin'];
                        $res=$this->addEventPriceLocation($tdata_loc);
                        if($res==true)
                        {
                            $return=true;
                        }
                    }   
                }

            }
        

        return $return;
    }
    public function addEventPriceLocation($tdata) {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tbl_event_loc_price`(`event_id`, `event_price_id`, `ticket_name`, " . "`ordering_type_id`, `max_order`, `min_order`, `cusine_qty`, `currency_id`, " . "`cusine_price`, `default_price`, `culoc_status`,`culoc_add_date`," . "`added_by_admin`,`cusine_qty_show`, " . "`sold_qty_show`, `is_offer`, `offer_price`, `offer_date_type`, `offer_days_of_month`, `offer_days_of_week`," . "`offer_single_date`, `offer_start_date`, `offer_end_date`, `registration_type`, `registration_fees`, " . "`currency_fees`, `registration_criteria`, `discount_date_type`, `discount_days_of_month`, " . "`discount_days_of_week`, `discount_single_date`, `discount_start_date`, `discount_end_date`, " . "`bulk_booking_allowed`, `is_discount_applicable`, `discount_code`,`registration_show`) " . "VALUES (:event_id,:event_price_id,:ticket_name,:ordering_type_id,:max_order,:min_order,:cusine_qty," . ":currency_id,:cusine_price,:default_price,:culoc_status,:culoc_add_date,:added_by_admin,:cusine_qty_show," . ":sold_qty_show,:is_offer,:offer_price,:offer_date_type,:offer_days_of_month,:offer_days_of_week,:offer_single_date,:offer_start_date," . ":offer_end_date,:registration_type,:registration_fees,:currency_fees,:registration_criteria,:discount_date_type,:discount_days_of_month,:discount_days_of_week," . ":discount_single_date,:discount_start_date,:discount_end_date,:bulk_booking_allowed,:is_discount_applicable,:discount_code,:registration_show)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_id' => addslashes($tdata['event_id']), ':event_price_id' => addslashes($tdata['event_price_id']), ':ticket_name' => addslashes($tdata['ticket_name']), ':ordering_type_id' => addslashes($tdata['ordering_type_id']), ':max_order' => addslashes($tdata['max_order']), ':min_order' => addslashes($tdata['min_order']), ':cusine_qty' => addslashes($tdata['cusine_qty']), ':currency_id' => addslashes($tdata['currency_id']), ':cusine_price' => addslashes($tdata['cusine_price']), ':default_price' => addslashes($tdata['default_price']), ':culoc_status' => '1', ':culoc_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin'], ':cusine_qty_show' => addslashes($tdata['cusine_qty_show']), ':sold_qty_show' => addslashes($tdata['sold_qty_show']), ':is_offer' => addslashes($tdata['is_offer']), ':offer_price' => addslashes($tdata['offer_price']), ':offer_date_type' => addslashes($tdata['offer_date_type']), ':offer_days_of_month' => addslashes($tdata['offer_days_of_month']), ':offer_days_of_week' => addslashes($tdata['offer_days_of_week']), ':offer_single_date' => addslashes($tdata['offer_single_date']), ':offer_start_date' => addslashes($tdata['offer_start_date']), ':offer_end_date' => addslashes($tdata['offer_end_date']), ':is_discount_applicable' => addslashes($tdata['is_discount']), ':discount_code' => addslashes($tdata['discount_code']), ':discount_date_type' => addslashes($tdata['discount_date_type']), ':discount_days_of_month' => addslashes($tdata['discount_days_of_month']), ':discount_days_of_week' => addslashes($tdata['discount_days_of_week']), ':discount_single_date' => addslashes($tdata['discount_single_date']), ':discount_start_date' => addslashes($tdata['discount_start_date']), ':discount_end_date' => addslashes($tdata['discount_end_date']), ':bulk_booking_allowed' => addslashes($tdata['bulk_booking_allowed']), ':registration_type' => addslashes($tdata['registration_type']), ':currency_fees' => addslashes($tdata['currency_fees']), ':registration_fees' => addslashes($tdata['registration_fees']), ':registration_criteria' => addslashes($tdata['registration_criteria']), ':registration_show' => addslashes($tdata['registration_show'])));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCusineLocation] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function addEventLocCategory($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "INSERT INTO `tbleventloccategory` (`event_id`,`event_price_id`,`cucat_parent_cat_id`,`cucat_cat_id`,`cucat_show`,`cucat_status`,`cucat_add_date`,`added_by_admin`) 

					VALUES (:event_id,:event_price_id,:cucat_parent_cat_id,:cucat_cat_id,:cucat_show,:cucat_status,:cucat_add_date,:added_by_admin)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_id' => addslashes($tdata['event_id']), ':event_price_id' => addslashes($tdata['event_price_id']), ':cucat_parent_cat_id' => addslashes($tdata['cucat_parent_cat_id']), ':cucat_cat_id' => addslashes($tdata['cucat_cat_id']), ':cucat_show' => addslashes($tdata['cucat_show']), ':cucat_status' => addslashes($tdata['cucat_status']), ':cucat_add_date' => date('Y-m-d H:i:s'), ':added_by_admin' => $tdata['added_by_admin']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[addCusineCategory] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getEventPriceDetails($event_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tbl_event_price` WHERE `event_id` = '" . $event_id . "' AND `event_price_status` = '1' AND `event_deleted` = 0 ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }
        return $arr_record;
    }
    public function getEventPriceAllLocation($event_price_id,$event_loc_price_id="") {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $str_ev_loc_pr="";
        if($event_loc_price_id)
        {
            $str_ev_loc_pr=" AND evlocprice_id=".$event_loc_price_id;
        }
        $sql = "SELECT * FROM `tbl_event_loc_price` WHERE `event_price_id` = '" . $event_price_id . "' ".$str_ev_loc_pr." AND `culoc_deleted` = '0' ORDER BY default_price DESC, culoc_add_date ASC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_record[] = $r;
            }
        }
        return $arr_record;
    }
    public function getEventPriceAllCategory($event_price_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $sql = "SELECT * FROM `tbleventloccategory` WHERE `event_price_id` = '" . $event_price_id . "' AND `cucat_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_record[] = $r;
            }
        }
        return $arr_record;
    }
    public function updateEventPrice($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        try {
            $sql = "UPDATE `tbl_event_price` SET 

					`event_id` = :event_id,

					`publish_date_type` = :publish_date_type,

					`publish_days_of_month` = :publish_days_of_month,

					`publish_days_of_week` = :publish_days_of_week,

					`publish_single_date` = :publish_single_date,

					`publish_start_date` = :publish_start_date,

					`publish_end_date` = :publish_end_date,

					`event_desc_1` = :event_desc_1,

					`event_desc_show_1` = :event_desc_show_1,

					`event_desc_2` = :event_desc_2,

					`event_desc_show_2` = :event_desc_show_2,

					`event_price_status` = :event_price_status,

					`event_modified_date` = :event_modified_date,

					`modified_by_admin` = :modified_by_admin,

					`order_cutoff_time` = :order_cutoff_time,

					`cancel_cutoff_time` = :cancel_cutoff_time,

					`cancel_cutoff_time_show` = :cancel_cutoff_time_show,

					`cgst_tax` = :cgst_tax,

					`sgst_tax` = :sgst_tax,

					`cess_tax` = :cess_tax,

					`gst_tax` = :gst_tax,

					`registration_cutoff_time` = :registration_cutoff_time,

					`registration_time_show` = :registration_time_show 

					 WHERE `event_price_id` = :event_price_id ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_id' => $tdata['event_id'], ':publish_date_type' => addslashes($tdata['publish_date_type']), ':publish_days_of_month' => addslashes($tdata['publish_days_of_month']), ':publish_days_of_week' => addslashes($tdata['publish_days_of_week']), ':publish_single_date' => $tdata['publish_single_date'], ':publish_start_date' => $tdata['publish_start_date'], ':publish_end_date' => $tdata['publish_end_date'], ':event_desc_1' => addslashes($tdata['cusine_desc_1']), ':event_desc_show_1' => addslashes($tdata['cusine_desc_show_1']), ':event_desc_2' => addslashes($tdata['cusine_desc_2']), ':event_desc_show_2' => addslashes($tdata['cusine_desc_show_2']), ':event_price_status' => addslashes($tdata['event_status']), ':event_modified_date' => date('Y-m-d H:i:s'), ':modified_by_admin' => addslashes($tdata['modified_by_admin']), ':order_cutoff_time' => addslashes($tdata['order_cutoff_time']), ':cancel_cutoff_time' => addslashes($tdata['cancel_cutoff_time']), ':cancel_cutoff_time_show' => addslashes($tdata['cancel_cutoff_time_show']), ':cgst_tax' => addslashes($tdata['cgst_tax']), ':sgst_tax' => addslashes($tdata['sgst_tax']), ':cess_tax' => addslashes($tdata['cess_tax']), ':gst_tax' => addslashes($tdata['gst_tax']), ':registration_cutoff_time' => addslashes($tdata['registration_cutoff_time']), ':registration_time_show' => addslashes($tdata['registration_time_show']), ':event_price_id' => $tdata['event_price_id']));
            //echo $sql;
            $DBH->commit();
            $return = true;
            //die();
            $tdata_del_cat = array();
            $tdata_del_cat['event_id'] = $tdata['event_id'];
            $tdata_del_cat['event_price_id'] = $tdata['event_price_id'];
            $tdata_del_cat['deleted_by_admin'] = $tdata['modified_by_admin'];
            $this->deleteEventPriceCategoryByEventPriceId($tdata_del_cat);
            if (count($tdata['cucat_parent_cat_id']) > 0) {
                for ($i = 0;$i < count($tdata['cucat_parent_cat_id']);$i++) {
                    $tdata_cat = array();
                    $tdata_cat['event_id'] = $tdata['event_id'];
                    $tdata_cat['event_price_id'] = $tdata['event_price_id'];
                    $tdata_cat['cucat_parent_cat_id'] = $tdata['cucat_parent_cat_id'][$i];
                    $tdata_cat['cucat_cat_id'] = $tdata['cucat_cat_id'][$i];
                    $tdata_cat['cucat_show'] = $tdata['cucat_show'][$i];
                    $tdata_cat['cucat_status'] = 1;
                    $tdata_cat['added_by_admin'] = $tdata['modified_by_admin'];
                    $this->addEventLocCategory($tdata_cat);
                }
            }
        }
        catch(Exception $e) {
            //echo 'Hiiiii';
            $stringData = '[updateprice] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    //copy by ample 09-15-20
    public function updateEventPriceDetail($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

            $tdata_del_loc = array();
            $tdata_del_loc['event_id'] = $tdata['event_id'];
            $tdata_del_loc['event_price_id'] = $tdata['event_price_id']; 
            $tdata_del_loc['event_loc_price_id'] = $tdata['event_loc_price_id'];
            $tdata_del_loc['deleted_by_admin'] = $tdata['modified_by_admin'];
            $this->deleteEventPriceLocationByEventPriceId($tdata_del_loc);
            for ($i = 0;$i < count($tdata['registration_type_id']);$i++) {
                $tdata_loc = array();
                $tdata_loc['event_id'] = $tdata['event_id'];
                $tdata_loc['event_price_id'] = $tdata['event_price_id'];
                $tdata_loc['ticket_name'] = $tdata['ticket_name'][$i];
                $tdata_loc['ordering_type_id'] = $tdata['ordering_type_id'][$i];
                $tdata_loc['max_order'] = $tdata['max_order'][$i];
                $tdata_loc['min_order'] = $tdata['min_order'][$i];
                $tdata_loc['cusine_qty'] = $tdata['cusine_qty'][$i];
                $tdata_loc['currency_id'] = $tdata['currency_id'][$i];
                $tdata_loc['cusine_price'] = $tdata['ticket_price'][$i];
                $tdata_loc['default_price'] = $tdata['default_price'][$i];
                $tdata_loc['cusine_qty_show'] = $tdata['cusine_qty_show'][$i];
                $tdata_loc['sold_qty_show'] = $tdata['sold_qty_show'][$i];
                $tdata_loc['is_offer'] = $tdata['is_offer'][$i];
                $tdata_loc['offer_price'] = $tdata['offer_price'][$i];
                $tdata_loc['offer_date_type'] = $tdata['offer_date_type'][$i];
                $tdata_loc['offer_days_of_month'] = $tdata['offer_days_of_month'][$i];
                $tdata_loc['offer_days_of_week'] = $tdata['offer_days_of_week'][$i];
                $tdata_loc['offer_single_date'] = $tdata['offer_single_date'][$i];
                $tdata_loc['offer_start_date'] = $tdata['offer_start_date'][$i];
                $tdata_loc['offer_end_date'] = $tdata['offer_end_date'][$i];
                $tdata_loc['is_discount'] = $tdata['is_discount'][$i];
                $tdata_loc['discount_date_type'] = $tdata['discount_date_type'][$i];
                $tdata_loc['discount_days_of_month'] = $tdata['discount_days_of_month'][$i];
                $tdata_loc['discount_days_of_week'] = $tdata['discount_days_of_week'][$i];
                $tdata_loc['discount_single_date'] = $tdata['discount_single_date'][$i];
                $tdata_loc['discount_start_date'] = $tdata['discount_start_date'][$i];
                $tdata_loc['discount_end_date'] = $tdata['discount_end_date'][$i];
                $tdata_loc['discount_code'] = $tdata['discount_code'][$i];
                $tdata_loc['bulk_booking_allowed'] = $tdata['is_bulk_booking'][$i];
                $tdata_loc['registration_type'] = $tdata['registration_type_id'][$i];
                $tdata_loc['registration_fees'] = $tdata['registration_fees'][$i];
                $tdata_loc['registration_show'] = $tdata['registration_show'][$i];
                $tdata_loc['currency_fees'] = $tdata['reg_currency_id'][$i];
                $tdata_loc['registration_criteria'] = $tdata['registration_criteria'][$i];
                $tdata_loc['culoc_status'] = 1;
                $tdata_loc['added_by_admin'] = $tdata['modified_by_admin'];
                $res=$this->addEventPriceLocation($tdata_loc);
                if($res==true)
                {
                    $return = true;
                }
            }

        return $return;
    }
    public function deleteEventPriceCategoryByEventPriceId($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tbleventloccategory` SET 

					`cucat_deleted` = :cucat_deleted,

					`cucat_modified_date` = :cucat_modified_date,

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `event_price_id` = :event_price_id AND `cucat_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':cucat_deleted' => '1', ':cucat_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':event_price_id' => $tdata['event_price_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCusineCategoryByCusineId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteEventPriceLocationByEventPriceId($tdata) {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $event_loc_price_id=$tdata['event_loc_price_id'];
        $str_ev_loc_pr="";
        if($event_loc_price_id)
        {
            $str_ev_loc_pr=" AND evlocprice_id=".$event_loc_price_id;
        }

        try {
            $sql = "UPDATE `tbl_event_loc_price` SET 

					`culoc_deleted` = :culoc_deleted,

					`culoc_modified_date` = :culoc_modified_date,

					`deleted_by_admin` = :deleted_by_admin  

					WHERE `event_price_id` = :event_price_id ".$str_ev_loc_pr." AND `culoc_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':culoc_deleted' => '1', ':culoc_modified_date' => date('Y-m-d H:i:s'), ':deleted_by_admin' => $tdata['deleted_by_admin'], ':event_price_id' => $tdata['event_price_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCusineLocationByCusineId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllEventLocationbyEventMaster($event_master_id) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql = "SELECT * from tbl_event_details where `event_master_id` = '" . $event_master_id . "' and `event_deleted` = 0 order by event_id ASC";
        //$this->debuglog('[getAllVendors] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllEventOrgCertificate($event_id, $user_id, $user_type) {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $sql = "SELECT * from tbl_event_certificates where `event_id` = '" . $event_id . "' and `user_id` = '" . $user_id . "'and `user_type` = '" . $user_type . "' order by certificate_id ASC";
        //$this->debuglog('[getAllVendors] sql:'.$sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_records[] = $r;
            }
        }
        return $arr_records;
    }
    public function getAllCategoryOptionEvent($id_no, $parent_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $fav_cat_id = '';
        $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('" . $parent_cat_id . "') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['favcat_id'] == $fav_cat_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $cat_name = $row['fav_cat'];
                $option_str.= '<option value="' . $row['favcat_id'] . '" ' . $sel . '>' . stripslashes($cat_name) . '</option>';
            }
        }
        //echo $option_str;
        return $option_str;
    }
    public function getMainCategoryOptionLOC($parent_cat_id, $cat_id, $type = '1', $multiple = '', $default_cat_ids = '') {
        $DBH = new DatabaseHandler();
        $output = '';
        $sql_default_cat_id_str = "";
        if ($default_cat_ids != '' && $default_cat_ids != '-1') {
            $sql_default_cat_id_str = " AND tblfavcategory.fav_cat_id IN (" . $default_cat_ids . ") ";
        }
        if ($type == '2') {
            if ($multiple == '1') {
                if (is_array($cat_id) && count($cat_id) > 0 && in_array('-1', $cat_id)) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $output.= '<option value="-1" ' . $sel . ' >All Categories</option>';
            } else {
                $sel = '';
                $output.= '<option value="" ' . $sel . ' >All Categories</option>';
            }
        } else {
            $output.= '<option value="" >Select Category</option>';
        }
        $go_ahead = false;
        if ($multiple == '1') {
            if (is_array($parent_cat_id)) {
                if (count($parent_cat_id) > 0) {
                    $go_ahead = true;
                    $parent_cat_id_str = implode(',', $parent_cat_id);
                    $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id IN (" . $parent_cat_id_str . ") ";
                } else {
                    if ($parent_cat_id != '') {
                        $go_ahead = true;
                        $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' ";
                    }
                }
            } else {
                if ($parent_cat_id != '') {
                    $go_ahead = true;
                    $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' ";
                }
            }
        } else {
            if ($parent_cat_id != '' && $parent_cat_id != '-1') {
                $go_ahead = true;
                $sql_parent_cat_id_str = " tblcustomfavcategory.fav_cat_type_id = '" . $parent_cat_id . "' ";
            }
        }
        if ($go_ahead) {
            try {
                //$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";
                //$sql = "SELECT fav_cat_id,fav_cat FROM `tblfavcategory` WHERE 1 ORDER BY fav_cat ASC";
                $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE " . $sql_parent_cat_id_str . " " . $sql_default_cat_id_str . " and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                        if ($multiple == '1') {
                            if (in_array($r['fav_cat_id'], $cat_id)) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        } else {
                            if ($r['fav_cat_id'] == $cat_id) {
                                $selected = ' selected ';
                            } else {
                                $selected = '';
                            }
                        }
                        $output.= '<option value="' . $r['fav_cat_id'] . '" ' . $selected . '>' . stripslashes($r['fav_cat']) . '</option>';
                    }
                }
            }
            catch(Exception $e) {
                $stringData = '[getMainCategoryOption] Catch Error:' . $e->getMessage() . ' , sql:' . $sql;
                $this->debuglog($stringData);
                return $output;
            }
        }
        return $output;
    }
    public function getFavCategoryVendorEdit($fav_cat_type_id, $fav_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $fav_cat_type_id = explode(',', $fav_cat_type_id);
        $fav_cat_type_id = implode('\',\'', $fav_cat_type_id);
        //$fav_cat_id = explode(',', $fav_cat_id);
        $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('" . $fav_cat_type_id . "') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if (in_array($row['favcat_id'], $fav_cat_id)) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $cat_name = $row['fav_cat'];
                $option_str.= '<option value="' . $row['favcat_id'] . '" ' . $sel . '>' . stripslashes($cat_name) . '</option>';
            }
        }
        //echo $option_str;
        return $option_str;
    }
    public function getEventAllLocationsAndCertifications($event_master_id, $user_id, $event_id="") {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        $str_event_id="";
        if($event_id)
        {
            $str_event_id=' AND event_id='.$event_id;
        }
        $sql = "SELECT * from tbl_event_details where `event_master_id` = '" . $event_master_id . "' ".$str_event_id." and `event_deleted` = 0 order by event_id ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($r = $STH->fetch(PDO::FETCH_ASSOC)) {
                $r['organiser_certificate'] = array();
                //$sql2 = "SELECT * FROM `tblvendorcertifications` WHERE `vendor_id` = '".$vendor_id."' AND `vloc_id` = '".$r['vloc_id']."' AND `vc_cert_deleted` = '0' ORDER BY vc_cert_add_date ASC ";
                $sql2 = "SELECT * from tbl_event_certificates where `event_id` = '" . $r['event_id'] . "' and `user_id` = '" . $user_id . "'and `user_type` = 'ORG' and `data_type` = 'Organiser' order by certificate_id ASC";
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    while ($r2 = $STH2->fetch(PDO::FETCH_ASSOC)) {
                        $r['organiser_certificate'][] = $r2;
                    }
                }
                $r['participant_certificate'] = array();
                //$sql2 = "SELECT * FROM `tblvendorcertifications` WHERE `vendor_id` = '".$vendor_id."' AND `vloc_id` = '".$r['vloc_id']."' AND `vc_cert_deleted` = '0' ORDER BY vc_cert_add_date ASC ";
                // $sql2 = "SELECT * from tbl_event_certificates where `event_id` = '".$r['event_id']."' and `user_id` = '".$user_id."'and `user_type` = 'ORG' and `data_type` = 'Participant' order by certificate_id ASC";
                //                             $STH2 = $DBH->query($sql2);
                // if($STH2->rowCount() > 0)
                // {
                // 	while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
                // 	{
                // 		$r['participant_certificate'][] = $r2;
                // 	}
                // }
                $r['judge_certificate'] = array();
                //$sql2 = "SELECT * FROM `tblvendorcertifications` WHERE `vendor_id` = '".$vendor_id."' AND `vloc_id` = '".$r['vloc_id']."' AND `vc_cert_deleted` = '0' ORDER BY vc_cert_add_date ASC ";
                $sql2 = "SELECT * from tbl_event_certificates where `event_id` = '" . $r['event_id'] . "' and `user_id` = '" . $user_id . "'and `user_type` = 'ORG' and `data_type` = 'Judge' order by certificate_id ASC";
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    while ($r2 = $STH2->fetch(PDO::FETCH_ASSOC)) {
                        $r['judge_certificate'][] = $r2;
                    }
                }
                $r['participant_profile'] = array();
                $sql3 = "SELECT * from tbl_event_participants_criteria where `event_id` = '" . $r['event_id'] . "' and `event_master_id` = '" . $event_master_id . "'order by criteria_id ASC";
                $STH3 = $DBH->query($sql3);
                if ($STH3->rowCount() > 0) {
                    while ($r3 = $STH3->fetch(PDO::FETCH_ASSOC)) {
                        $r['participant_profile'][] = $r3;
                    }
                }
                $arr_record[] = $r;
            }
        }
        return $arr_record;
    }
    public function GetPfileCatEdit($healcareandwellbeing, $page_name, $cat_type, $prof_cat) {
        $data = $this->getPageCatDropdownValue($page_name, $healcareandwellbeing);
        $profile_cat1 = '';
        $profile_cat2 = '';
        $profile_cat3 = '';
        $profile_cat4 = '';
        $profile_cat5 = '';
        $fav_cat_id1_val = explode(',', $data['prof_cat1']);
        $fav_cat_id2_val = explode(',', $data['prof_cat2']);
        $fav_cat_id3_val = explode(',', $data['prof_cat3']);
        $fav_cat_id4_val = explode(',', $data['prof_cat4']);
        $fav_cat_id5_val = explode(',', $data['prof_cat5']);
        $fav_cat_id1 = implode('\',\'', $fav_cat_id1_val);
        $fav_cat_id2 = implode('\',\'', $fav_cat_id2_val);
        $fav_cat_id3 = implode('\',\'', $fav_cat_id3_val);
        $fav_cat_id4 = implode('\',\'', $fav_cat_id4_val);
        $fav_cat_id5 = implode('\',\'', $fav_cat_id5_val);
        //        echo '<pre>';
        //        print_r($fav_cat_id1);
        //        echo '</pre>';
        if ($cat_type == 'prof_cat_id_1') {
            if ($data['prof_cat1'] != '') {
                $profile_cat1 = $this->getMoreFavCategoryTypeOptions($fav_cat_id1, $prof_cat);
            }
            return $profile_cat1;
        }
        if ($cat_type == 'prof_cat_id_2') {
            if ($data['prof_cat2'] != '') {
                $profile_cat2 = $this->getMoreFavCategoryTypeOptions($fav_cat_id2, $prof_cat);
            }
            return $profile_cat2;
        }
        if ($cat_type == 'prof_cat_id_3') {
            if ($data['prof_cat3'] != '') {
                $profile_cat3 = $this->getMoreFavCategoryTypeOptions($fav_cat_id3, $prof_cat);
            }
            return $profile_cat3;
        }
        if ($cat_type == 'prof_cat_id_4') {
            if ($data['prof_cat4'] != '') {
                $profile_cat4 = $this->getMoreFavCategoryTypeOptions($fav_cat_id4, $prof_cat);
            }
            return $profile_cat4;
        }
        if ($cat_type == 'prof_cat_id_5') {
            if ($data['prof_cat5'] != '') {
                $profile_cat5 = $this->getMoreFavCategoryTypeOptions($fav_cat_id5, $prof_cat);
            }
            return $profile_cat5;
        }
    }
    public function getAllCategoryOptionEventEdit($parent_cat_id, $fav_cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        //$fav_cat_id='';
        echo $fav_cat_id;
        $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('" . $parent_cat_id . "') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['favcat_id'] == $fav_cat_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $cat_name = $row['fav_cat'];
                $option_str.= '<option value="' . $row['favcat_id'] . '" ' . $sel . '>' . stripslashes($cat_name) . '</option>';
            }
        }
        //echo $option_str;
        return $option_str;
    }
    public function updateEvent($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        try {
            $sql = "UPDATE `tbl_event_master` SET 

					`prof_cat_id_1` = :prof_cat_id_1,

					`fav_cat_id_1` = :fav_cat_id_1,

					`prof_cat_id_2` = :prof_cat_id_2,

					`fav_cat_id_2` = :fav_cat_id_2,

					`prof_cat_id_3` = :prof_cat_id_3,

					`fav_cat_id_3` = :fav_cat_id_3,

					`prof_cat_id_4` = :prof_cat_id_4,

					`fav_cat_id_4` = :fav_cat_id_4,

					`prof_cat_id_5` = :prof_cat_id_5,

					`fav_cat_id_5` = :fav_cat_id_5,

					`organiser_id` = :organiser_id,

					`institution_id` = :institution_id,

					`sponsor_id` = :sponsor_id,

					`event_name` = :event_name,

					`event_contents` = :event_contents,

                                        `updated_by` = :updated_by,

					`status` = :status,

                                        `event_tags` =:event_tags

					 WHERE `event_master_id` = :event_master_id ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':prof_cat_id_1' => $tdata['profile_cat_1'], ':fav_cat_id_1' => addslashes($tdata['fav_cat_1']), ':prof_cat_id_2' => $tdata['profile_cat_2'], ':fav_cat_id_2' => addslashes($tdata['fav_cat_2']), ':prof_cat_id_3' => $tdata['profile_cat_3'], ':fav_cat_id_3' => addslashes($tdata['fav_cat_3']), ':prof_cat_id_4' => $tdata['profile_cat_4'], ':fav_cat_id_4' => addslashes($tdata['fav_cat_4']), ':prof_cat_id_5' => $tdata['profile_cat_5'], ':fav_cat_id_5' => addslashes($tdata['fav_cat_5']), ':organiser_id' => $tdata['organiser_id'], ':institution_id' => $tdata['institution_id'], ':sponsor_id' => $tdata['sponsor_id'], ':event_name' => addslashes($tdata['event_name']), ':event_contents' => addslashes($tdata['event_contents']), ':updated_by' => $tdata['admin_id'], ':status' => $tdata['status'], ':event_tags' => $tdata['event_tags'], ':event_master_id' => $tdata['event_master_id']));
            //echo $sql;
            $DBH->commit();
            $return = true;
            
        }
        catch(Exception $e) {

            $stringData = '[updateprice] Catch Error:' . $e->getMessage();
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function updateEventLocInfo($tdata) {
            
            // echo "<pre>";
            // print_r($tdata);
            // die('ss');

            $return=false;
            $tdata_del_loc = array();
            $tdata_del_loc['event_id'] = $tdata['event_id'];
            $tdata_del_loc['event_master_id'] = $tdata['event_master_id'];
            $tdata_del_loc['deleted_by_admin'] = $tdata['admin_id'];
            $this->deleteEventLocationByEventMasterId($tdata_del_loc);
            $tdata_del_cat = array();
            $tdata_del_cat['event_id'] = $tdata['event_id'];
            $tdata_del_cat['event_master_id'] = $tdata['event_master_id'];
            $tdata_del_cat['event_deleted_by'] = $tdata['admin_id'];
            //add by ample 30-12-19
            $tdata_del_cat['certificate_deleted_date'] = date("Y-m-d H:i:s");
            $this->deleteEventLocationOrgCertificate($tdata_del_cat);
            $this->deleteEventTimeTable($tdata_del_cat);
            $tdata_del_pp = array();
            $tdata_del_pp['event_id'] = $tdata['event_id'];
            $tdata_del_pp['event_master_id'] = $tdata['event_master_id'];
            $tdata_del_pp['deleted_by'] = $tdata['admin_id'];
            //add by ample 30-12-19
            $tdata_del_pp['deleted_date'] = date("Y-m-d H:i:s");
            $this->deleteEventProfileCriteria($tdata_del_pp);
            for ($i = 0;$i < count($tdata['vloc_parent_cat_id']);$i++) {
                $tdata_vloc = array();

                $tdata_vloc['event_master_id'] = $tdata['event_master_id'];
                $tdata_vloc['event_id'] = $tdata['event_id'];
                $tdata_vloc['location_category'] = $tdata['vloc_parent_cat_id'][$i];
                $tdata_vloc['location_sub_category'] = $tdata['vloc_cat_id'][$i];
                $tdata_vloc['country_id'] = $tdata['country_id'][$i];
                $tdata_vloc['state_id'] = $tdata['state_id'][$i];
                $tdata_vloc['city_id'] = $this->getCityIdbyName($tdata['city_id'][$i]);
                $tdata_vloc['area_id'] = $tdata['area_id'][$i];
                $tdata_vloc['venue_details'] = $tdata['venue'][$i];
                $tdata_vloc['start_date'] = $tdata['start_date'][$i];
                $tdata_vloc['start_time'] = $tdata['start_time'][$i];
                $tdata_vloc['end_date'] = $tdata['end_date'][$i];
                $tdata_vloc['end_time'] = $tdata['end_time'][$i];
                $tdata_vloc['time_zone_id'] = $tdata['time_zone'][$i];
                $tdata_vloc['venue_image'] = $tdata['venue_image_file'][$i];
                $tdata_vloc['event_image'] = $tdata['event_image_file'][$i];
                $tdata_vloc['no_of_groups'] = $tdata['no_of_groups'][$i];
                $tdata_vloc['no_of_teams'] = $tdata['no_of_teams'][$i];
                $tdata_vloc['no_of_participants'] = $tdata['no_of_participants'][$i];
                $tdata_vloc['no_of_judges'] = $tdata['no_of_judges'][$i];
                $tdata_vloc['rules_regulation_pdf'] = $tdata['vloc_menu_file'][$i];
                $tdata_vloc['institution_profile_pdf'] = $tdata['vloc_doc_file'][$i];
                 //add by ample 22-09-20
                $tdata_vloc['online_registration_link'] = $tdata['online_registration_link'][$i];
                $tdata_vloc['online_registration_id'] = $tdata['online_registration_id'][$i];
                //add by ample 20-12-19
                // $tdata_vloc['participants_profile']=$tdata['participants_profile'][$i];
                // $tdata_vloc['participants_gender']=$tdata['participants_title'][$i];
                // $tdata_vloc['participants_special_remark']=$tdata['parti_remarks'][$i];
                // $tdata_vloc['participants_from_age_group']=$tdata['from_age'][$i];
                // $tdata_vloc['participants_to_age_group']=$tdata['to_age'][$i];
                // $tdata_vloc['participants_from_height']=$tdata['from_height'][$i];
                // $tdata_vloc['participants_to_height']=$tdata['to_height'][$i];
                // $tdata_vloc['participants_from_weight']=$tdata['from_weight'][$i];
                // $tdata_vloc['participants_to_weight']=$tdata['to_weight'][$i];
                $tdata_vloc['participants_profile'] = "";
                $tdata_vloc['participants_gender'] = "";
                $tdata_vloc['participants_special_remark'] = "";
                $tdata_vloc['participants_from_age_group'] = "";
                $tdata_vloc['participants_to_age_group'] = "";
                $tdata_vloc['participants_from_height'] = "";
                $tdata_vloc['participants_to_height'] = "";
                $tdata_vloc['participants_from_weight'] = "";
                $tdata_vloc['participants_to_weight'] = "";
                $tdata_vloc['judge_gender'] = $tdata['judge_title'][$i];
                $tdata_vloc['judge_special_remark'] = $tdata['judge_remarks'][$i];
                $tdata_vloc['organiser_facebook_page'] = $tdata['facebook_page_link'][$i];
                $tdata_vloc['organiser_twitter_page'] = $tdata['twitter_page_link'][$i];
                $tdata_vloc['organiser_instagram_page'] = $tdata['instagram_page_link'][$i];
                $tdata_vloc['organiser_youtube_channel'] = $tdata['youtube_page_link'][$i];
                $tdata_vloc['organiser_gender'] = $tdata['contact_person_title'][$i];
                $tdata_vloc['organiser_contact_person'] = $tdata['contact_person'][$i];
                $tdata_vloc['organiser_email'] = $tdata['contact_email'][$i];
                $tdata_vloc['organiser_contact_number'] = $tdata['contact_number'][$i];
                $tdata_vloc['organiser_designation'] = $tdata['contact_designation'][$i];
                $tdata_vloc['organiser_remarks'] = $tdata['contact_remark'][$i];
                $tdata_vloc['event_format'] = $tdata['event_format'][$i];
                $tdata_vloc['slot1_start_time'] = $tdata['slot1_start_time'][$i];
                $tdata_vloc['slot1_end_time'] = $tdata['slot1_end_time'][$i];
                $tdata_vloc['slot2_start_time'] = $tdata['slot2_start_time'][$i];
                $tdata_vloc['slot2_end_time'] = $tdata['slot2_end_time'][$i];
                $tdata_vloc['slot3_start_time'] = $tdata['slot3_start_time'][$i];
                $tdata_vloc['slot3_end_time'] = $tdata['slot3_end_time'][$i];
                $tdata_vloc['slot4_start_time'] = $tdata['slot4_start_time'][$i];
                $tdata_vloc['slot4_end_time'] = $tdata['slot4_end_time'][$i];
                $tdata_vloc['slot5_start_time'] = $tdata['slot5_start_time'][$i];
                $tdata_vloc['slot5_end_time'] = $tdata['slot5_end_time'][$i];
                $tdata_vloc['slot6_start_time'] = $tdata['slot6_start_time'][$i];
                $tdata_vloc['slot6_end_time'] = $tdata['slot6_end_time'][$i];
                // print_r($tdata_vloc);
                // // die();
                $vloc_id = $this->addEventLocation($tdata_vloc);
                if ($vloc_id > 0) {
                    $return = true;
                    // add by ample 24-12-19
                    for ($k = 0;$k < count($tdata['pp_type_id'][$i]);$k++) {
                        $tdata_pp = array();
                        $tdata_pp['event_master_id'] = $tdata['event_master_id'];
                        $tdata_pp['event_id'] = $vloc_id;
                        $tdata_pp['profile'] = $tdata['pp_type_id'][$i][$k];
                        $tdata_pp['gender'] = $tdata['pp_gender'][$i][$k];
                        $tdata_pp['special_remark'] = $tdata['pp_remark'][$i][$k];
                        $tdata_pp['from_age_group'] = $tdata['pp_from_age'][$i][$k];
                        $tdata_pp['to_age_group'] = $tdata['pp_to_age'][$i][$k];
                        $tdata_pp['from_height'] = $tdata['pp_from_height'][$i][$k];
                        $tdata_pp['to_height'] = $tdata['pp_to_height'][$i][$k];
                        $tdata_pp['from_weight'] = $tdata['pp_from_weight'][$i][$k];
                        $tdata_pp['to_weight'] = $tdata['pp_to_weight'][$i][$k];
                        $tdata_pp['added_by'] = $tdata['admin_id'];
                        $pp_criteria_id = $this->addEventCriteria($tdata_pp);
                    }
                    for ($k = 0;$k < count($tdata['org_cert_type_id'][$i]);$k++) {
                        $tdata_vc = array();
                        $tdata_vc['user_id'] = $tdata['organiser_id'];
                        $tdata_vc['event_master_id'] = $tdata['event_master_id'];
                        $tdata_vc['user_type'] = 'ORG';
                        $tdata_vc['data_type'] = 'Organiser';
                        $tdata_vc['event_id'] = $vloc_id;
                        $tdata_vc['certificate_type'] = $tdata['org_cert_type_id'][$i][$k];
                        $tdata_vc['certificate_name'] = $tdata['org_cert_name'][$i][$k];
                        $tdata_vc['certificate_number'] = $tdata['org_cert_no'][$i][$k];
                        $tdata_vc['certificate_issue_date'] = $tdata['org_cert_reg_date'][$i][$k];
                        $tdata_vc['certificate_issue_by'] = $tdata['org_cert_issued_by'][$i][$k];
                        $tdata_vc['certificate_validity_date'] = $tdata['org_cert_validity_date'][$i][$k];
                        $tdata_vc['certificate_scan_copy'] = $tdata['org_cert_scan_file'][$i][$k];
                        $vc_cert_id = $this->addEventCerification($tdata_vc);
                    }
                    //add by ample for participate 20-12-19
                    // for($k=0;$k<count($tdata['vc_cert_type_id'][$i]);$k++)
                    // {
                    //  $tdata_pc = array();
                    //                          $tdata_pc['user_id'] = $tdata['organiser_id'];
                    //  $tdata_pc['event_master_id'] = $tdata['event_master_id'];
                    //  $tdata_pc['user_type'] ='ORG';
                    //                          $tdata_pc['data_type'] ='Participant';
                    //  $tdata_pc['event_id'] = $vloc_id;
                    //  $tdata_pc['certificate_type'] = $tdata['vc_cert_type_id'][$i][$k];
                    //  $tdata_pc['certificate_name'] = $tdata['vc_cert_name'][$i][$k];
                    //  $tdata_pc['certificate_number'] = $tdata['vc_cert_no'][$i][$k];
                    //  $tdata_pc['certificate_issue_date'] = $tdata['vc_cert_reg_date'][$i][$k];
                    //  $tdata_pc['certificate_issue_by'] = $tdata['vc_cert_issued_by'][$i][$k];
                    //  $tdata_pc['certificate_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
                    //  $tdata_pc['certificate_scan_copy'] = $tdata['vc_cert_scan_file'][$i][$k];
                    //  $pc_cert_id = $this->addEventCerification($tdata_pc);
                    // }
                    //add by ample for judge 20-12-19
                    for ($k = 0;$k < count($tdata['judge_cert_type_id'][$i]);$k++) {
                        $tdata_jc = array();
                        $tdata_jc['user_id'] = $tdata['organiser_id'];
                        $tdata_jc['event_master_id'] = $tdata['event_master_id'];
                        $tdata_jc['user_type'] = 'ORG';
                        $tdata_jc['data_type'] = 'Judge';
                        $tdata_jc['event_id'] = $vloc_id;
                        $tdata_jc['certificate_type'] = $tdata['judge_cert_type_id'][$i][$k];
                        $tdata_jc['certificate_name'] = $tdata['judge_cert_name'][$i][$k];
                        $tdata_jc['certificate_number'] = $tdata['judge_cert_no'][$i][$k];
                        $tdata_jc['certificate_issue_date'] = $tdata['judge_cert_reg_date'][$i][$k];
                        $tdata_jc['certificate_issue_by'] = $tdata['judge_cert_issued_by'][$i][$k];
                        $tdata_jc['certificate_validity_date'] = $tdata['judge_cert_validity_date'][$i][$k];
                        $tdata_jc['certificate_scan_copy'] = $tdata['judge_cert_scan_file'][$i][$k];
                        $jc_cert_id = $this->addEventCerification($tdata_jc);
                    }
                    $date1 = date_create($tdata['start_date'][$i]);
                    $date2 = date_create($tdata['end_date'][$i]);
                    $diff = date_diff($date1, $date2);
                    $diff_count = $diff->format("%a");
                    for ($j = 0;$j <= $diff_count;$j++) {
                        $tdata_ett = array();
                        $tdata_ett['event_master_id'] = $tdata['event_master_id'];
                        $tdata_ett['event_id'] = $vloc_id;
                        $tdata_ett['event_start_date'] = date("Y-m-d", strtotime($tdata['start_date'][$i] . $j . ' days'));
                        $tdata_ett['event_days'] = date('l', strtotime($tdata_ett['event_start_date']));
                        $tdata_ett['event_end_date'] = date("Y-m-d", strtotime($tdata['end_date'][$i]));
                        $tdata_ett['event_start_time'] = $tdata['start_time'][$i];
                        $tdata_ett['event_end_time'] = $tdata['end_time'][$i];
                        $this->AddEventTimeTable($tdata_ett);
                    }
                }
            }

        return $return;
    }
    public function deleteEventLocationByEventMasterId($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $str_event_id="";
        if($tdata['event_id'])
        {
            $str_event_id=" AND `event_id`=".$tdata['event_id'];
        }
        try {
            $sql = "UPDATE `tbl_event_details` SET 

					`event_deleted` = :event_deleted,

					`event_updated_date` = :event_updated_date,

					`event_deleted_by` = :event_deleted_by  

					WHERE `event_master_id` = :event_master_id ".$str_event_id." AND `event_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_deleted' => '1', ':event_updated_date' => date('Y-m-d H:i:s'), ':event_deleted_by' => $tdata['admin_id'], ':event_master_id' => $tdata['event_master_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCusineLocationByCusineId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function deleteEventLocationOrgCertificate($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $str_event_id="";
        if($tdata['event_id'])
        {
            $str_event_id=" AND `event_id`=".$tdata['event_id'];
        }
        try {
            $sql = "UPDATE `tbl_event_certificates` SET 

                                    `certificate_deleted` = :certificate_deleted,

                                    `certificate_deleted_date` = :certificate_deleted_date,

                                    `certificate_deleted_by` = :certificate_deleted_by  

                                    WHERE `event_master_id` = :event_master_id ".$str_event_id." AND `certificate_deleted` != '1' AND `user_type` ='ORG' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':certificate_deleted' => '1', ':certificate_deleted_date' => date('Y-m-d H:i:s'), ':certificate_deleted_by' => $tdata['admin_id'], ':event_master_id' => $tdata['event_master_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteCusineLocationByCusineId] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    // add by ample 24-12-19
    public function deleteEventProfileCriteria($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $str_event_id="";
        if($tdata['event_id'])
        {
            $str_event_id=" AND `event_id`=".$tdata['event_id'];
        }
        try {
            $sql = "UPDATE `tbl_event_participants_criteria` SET 
                                    `is_deleted` = :is_deleted,
                                    `deleted_date` = :deleted_date,
                                    `deleted_by` = :deleted_by  
                                    WHERE `event_master_id` = :event_master_id ".$str_event_id." AND `is_deleted` != '1' ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':is_deleted' => '1', ':deleted_date' => date('Y-m-d H:i:s'), ':deleted_by' => $tdata['admin_id'], ':event_master_id' => $tdata['event_master_id']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[deleteEventProfileCriteria] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function GETDATADROPDOWNMYDAYTODAYOPTION($page_cat_id, $page_name) {
        $DBH = new DatabaseHandler();
        $arr_data = array();
        $sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = '" . $page_name . "' and `healcareandwellbeing` = '" . $page_cat_id . "' and `is_deleted` = 0 ORDER BY `order_show` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_data[] = $row;
            }
        }
        return $arr_data;
    }
    public function GetFecthDataDesign($canv_sub_cat_link, $cat_id) {
        $final_data = array();
        if ($canv_sub_cat_link == 'tbl_bodymainsymptoms') {
            //echo 'Hiii';
            $symtum_cat = $this->getAllMainSymptomsMyDesign($cat_id);
            if (!empty($symtum_cat)) {
                $final_data = $this->GetmycanvasdataDesign($symtum_cat);
            }
        }
        if ($canv_sub_cat_link == 'tblsolutionitems') {
            //$symtum_cat = $this->getAllMainSymptomsRamakantFront($cat_id);
            $final_data = $this->GetmycanvassolutionitemsDesign($cat_id);
        }
        if ($canv_sub_cat_link == 'tbldailymealsfavcategory') {
            // echo 'Hiii';
            $symtum_cat = $this->getAllDailyMealsMyDesign($cat_id);
            if (!empty($symtum_cat)) {
                $final_data = $this->GetmycanvasmealdataDesign($symtum_cat);
            }
        }
        if ($canv_sub_cat_link == 'tbldailyactivity') {
            //$symtum_cat = $this->getAllDailyActivityMyCanvas($cat_id);
            $final_data = $this->GetmycanvasDailyActivitydataDesign($cat_id);
        }
        if (count($final_data) > 0) {
            $final_data = $final_data;
        } else {
            //$final_data[]= array();
            return $final_data;
        }
        return $final_data;
    }
    public function GetmycanvasdataDesign($symtum_cat) {
        $symtum_cat = implode(',', $symtum_cat);
        $DBH = new DatabaseHandler();
        $option_str = array();
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) ORDER BY `bms_name` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $option_str[] = $row['bms_name'];
            }
        }
        return $option_str;
    }
    public function GetmycanvassolutionitemsDesign($cat_id) {
        $DBH = new DatabaseHandler();
        $option_str = array();
        $sql = "SELECT * FROM `tblsolutionitems` WHERE  sol_item_cat_id IN($cat_id) ORDER BY `sol_box_title` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $option_str[] = strip_tags($row['sol_box_title']);
            }
        }
        return $option_str;
    }
    public function getAllMainSymptomsMyDesign($symtum_cat) {
        $DBH = new DatabaseHandler();
        $str_sql_search = " AND `fav_parent_cat` IN (" . $symtum_cat . ") ";
        $data = array();
        $sql = "SELECT DISTINCT bmsid FROM `tblsymtumscustomcategory` WHERE  symtum_deleted = '0' " . $str_sql_search . " ORDER BY bmsid DESC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row['bmsid'];
            }
        }
        return $data;
    }
    public function getAllDailyMealsMyDesign($symtum_cat) {
        $DBH = new DatabaseHandler();
        $str_sql_search = " AND `fav_cat_id` IN (" . $symtum_cat . ") ";
        $data = array();
        $sql = "SELECT DISTINCT meal_id FROM `tbldailymealsfavcategory` WHERE  show_hide = '1' " . $str_sql_search . " ORDER BY meal_id DESC ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[] = strip_tags($row['meal_id']);
            }
        }
        return $data;
    }
    public function GetmycanvasmealdataDesign($symtum_cat) {
        $symtum_cat = implode(',', $symtum_cat);
        $DBH = new DatabaseHandler();
        $option_str = array();
        $sql = "SELECT * FROM `tbldailymeals` WHERE meal_id IN($symtum_cat) ORDER BY `meal_item` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $option_str[] = strip_tags($row['meal_item']);
            }
        }
        return $option_str;
    }
    public function GetmycanvasDailyActivitydataDesign($symtum_cat) {
        $DBH = new DatabaseHandler();
        $option_str = array();
        $sql = "SELECT * FROM `tbldailyactivity` WHERE (activity_category IN($symtum_cat) OR activity_level_code IN($symtum_cat)) ORDER BY `activity` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $option_str[] = strip_tags($row['activity']);
            }
        }
        return $option_str;
    }
    public function CreateDesignLifeDropdown($show_cat, $final_array) {
        $option_str = '';
        $data = array();
        if (!empty($show_cat)) {
            for ($i = 0;$i < count($show_cat);$i++) {
                //$option_str .='<option value="'.$this->getFavCategoryNameVivek($show_cat[$i]).'">'.$this->getFavCategoryNameVivek($show_cat[$i]).'</option>';
                $data[] = $this->getFavCategoryNameVivek($show_cat[$i]);
            }
        }
        $final_array_new = array_merge($data, $final_array);
        //$final_array_new = asort($final_array_new);
        //   echo '<pre>';
        //   print_r($final_array_new);
        //   echo '</pre>';
        //   die();
        if (!empty($final_array_new)) {
            for ($j = 0;$j < count($final_array_new);$j++) {
                $option_str.= '<option value="' . $final_array_new[$j] . '">' . $final_array_new[$j] . '</option>';
            }
        }
        return $option_str;
    }
    public function CreateDesignLifeDropdownEdit($show_cat, $final_array, $arr_event_tags) {
        $option_str = '';
        $data = array();
        if (!empty($show_cat)) {
            for ($i = 0;$i < count($show_cat);$i++) {
                //$option_str .='<option value="'.$this->getFavCategoryNameVivek($show_cat[$i]).'">'.$this->getFavCategoryNameVivek($show_cat[$i]).'</option>';
                $data[] = $this->getFavCategoryNameVivek($show_cat[$i]);
            }
        }
        $final_array_new = array_merge($data, $final_array);
        //$final_array_new = asort($final_array_new);
        //   echo '<pre>';
        //   print_r($final_array_new);
        //   echo '</pre>';
        //   die();
        if (!empty($final_array_new)) {
            $sel = '';
            for ($j = 0;$j < count($final_array_new);$j++) {
                if (in_array($final_array_new[$j], $arr_event_tags)) {
                    $sel = 'selected';
                } else {
                    $sel = '';
                }
                $option_str.= '<option value="' . $final_array_new[$j] . '" ' . $sel . '>' . $final_array_new[$j] . '</option>';
            }
        }
        return $option_str;
    }
    public function getFavCategoryNameVivek($fav_cat_id) {
        $DBH = new DatabaseHandler();
        $fav_cat_type = '';
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '" . $fav_cat_id . "' ";
        //$this->execute_query($sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $fav_cat_type = stripslashes($row['fav_cat']);
        }
        return $fav_cat_type;
    }
    public function AddEventTimeTable($tdata) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        //            echo '<pre>';
        //            print_r($tdata);
        //            echo '</pre>';
        try {
            $sql = "INSERT INTO `tbl_event_time_table` (`event_id`,`event_master_id`,`event_start_date`,`event_end_date`,`event_start_time`,`event_end_time`,`event_days`) 

					VALUES (:event_id,:event_master_id,:event_start_date,:event_end_date,:event_start_time,:event_end_time,:event_days)";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':event_id' => $tdata['event_id'], ':event_master_id' => $tdata['event_master_id'], ':event_start_date' => addslashes($tdata['event_start_date']), ':event_end_date' => addslashes($tdata['event_end_date']), ':event_start_time' => $tdata['event_start_time'], ':event_end_time' => $tdata['event_end_time'], ':event_days' => $tdata['event_days']));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            return false;
        }
        return $return;
    }
    public function deleteEventTimeTable($tdata) {
        $DBH = new DatabaseHandler();
        $return = false;
        $str_event_id="";
        if($tdata['event_id'])
        {
            $str_event_id=" AND `event_id`=".$tdata['event_id'];
        }
        $sql = "DELETE FROM `tbl_event_time_table` WHERE `event_master_id` = '" . $tdata['event_master_id'] . "' ".$str_event_id." ";
        //$this->execute_query($sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getPageContents($page_id) {
        $DBH = new DatabaseHandler();
        $page_contents = '';
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '" . $page_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $temp = stripslashes($row['page_contents']);
            $temp = str_replace('&nbsp;', ' ', $temp);
            $page_contents = html_entity_decode($temp);
        }
        return $page_contents;
    }
    //update by ample
    public function chkIfRequestAlreadySentByAdviser($pro_user_id, $user_email) {
        $DBH = new DatabaseHandler();
        $return = false;
        //code comment and new add sql chnage  pro_user_id to vendor_id by ample 23-10-19
        //$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' ";
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE `vendor_id` = '" . $pro_user_id . "' AND `user_email` = '" . $user_email . "' AND `invite_by_user` = '0' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            if ($row['request_status'] != '2') {
                $return = true;
            }
        }
        return $return;
    }
    public function addAdvisorsReferral($pro_user_id, $user_email, $user_name, $message, $new_user) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            //code comment and new sql update by ample 23-10-19
            // $sql = "INSERT INTO `tbladviserreferrals` (`pro_user_id`,`vendor_id`,`user_email`,`user_name`,`message`,`request_status`,`new_user`)
            // 		VALUES (:pro_user_id,:vendor_id,:user_email,:user_name,:message,:request_status,:new_user)";
            $sql = "INSERT INTO `tbladviserreferrals` (`user_id`,`vendor_id`,`user_email`,`user_name`,`message`,`request_status`,`new_user`) 

					VALUES (:user_id,:vendor_id,:user_email,:user_name,:message,:request_status,:new_user)";
            $STH = $DBH->prepare($sql);
            //
            $STH->execute(array(
            //':pro_user_id' =>0, //comment by ample 23-10-19
            ':user_id' => 0, ':vendor_id' => addslashes($pro_user_id), ':user_email' => addslashes($user_email), ':user_name' => addslashes($user_name), ':message' => addslashes($message), ':request_status' => 0, ':new_user' => addslashes($new_user)));
            $ar_id = $DBH->lastInsertId();
            $DBH->commit();
            if ($ar_id > 0) {
                $return = $ar_id;
            }
        }
        catch(Exception $e) {
            $stringData = '[addOrderStatusLog] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return false;
        }
        return $return;
    }
    public function getAllAdviserUserReferrals_OLD($vendor_id, $user_id, $status, $invite_start_date, $invite_end_date, $status_start_date, $status_end_date) {
        $DBH = new DatabaseHandler();
        $temp_arr = array();
        $user_email = $this->getProUserEmailById($vendor_id);
        if ($user_id != '') {
            $uemail = $this->getUserEmailById($user_id);
            $str_sql_user_id1 = " AND `user_email` = '" . $uemail . "' ";
            $str_sql_user_id2 = " AND `user_id` = '" . $user_id . "' ";
        } else {
            $str_sql_user_id1 = "";
            $str_sql_user_id2 = "";
        }
        if ($status != '') {
            if ($status == '1') {
                $str_sql_status1 = " AND `request_status` = '1' ";
                $str_sql_status2 = " AND `request_status` = '1' ";
            } elseif ($status == '2') {
                $str_sql_status1 = " AND `request_status` = '2' ";
                $str_sql_status2 = " AND `request_status` = '2' ";
            } elseif ($status == '3') {
                $str_sql_status1 = " AND `request_status` = '3' ";
                $str_sql_status2 = " AND `request_status` = '3' ";
            } else {
                $str_sql_status1 = " AND `request_status` = '0' ";
                $str_sql_status2 = " AND `request_status` = '0' ";
            }
        } else {
            $str_sql_status1 = "";
            $str_sql_status2 = "";
        }
        if ($invite_start_date == '' && $invite_end_date == '') {
            $str_sql_invite_date1 = "";
            $str_sql_invite_date2 = "";
        } else {
            if ($invite_start_date != '' && $invite_end_date == '') {
                $str_sql_invite_date1 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($invite_start_date)) . "' ";
                $str_sql_invite_date2 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($invite_start_date)) . "' ";
            } elseif ($invite_start_date == '' && $invite_end_date != '') {
                $str_sql_invite_date1 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
                $str_sql_invite_date2 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
            } else {
                $str_sql_invite_date1 = " AND `request_sent_date` >= '" . date('Y-m-d', strtotime($invite_start_date)) . "' AND `request_sent_date` <= '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
                $str_sql_invite_date2 = " AND `request_sent_date` >= '" . date('Y-m-d', strtotime($invite_start_date)) . "' AND `request_sent_date` <= '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
            }
        }
        if ($status_start_date == '' && $status_end_date == '') {
            $str_sql_status_date1 = "";
            $str_sql_status_date2 = "";
        } else {
            if ($status_start_date != '' && $status_end_date == '') {
                $str_sql_status_date1 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($status_start_date)) . "' ";
                $str_sql_status_date2 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($status_start_date)) . "' ";
            } elseif ($invite_start_date == '' && $invite_end_date != '') {
                $str_sql_status_date1 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($status_end_date)) . "' ";
                $str_sql_status_date2 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($status_end_date)) . "' ";
            } else {
                $str_sql_status_date1 = " AND `request_sent_date` >= '" . date('Y-m-d', strtotime($status_start_date)) . "' AND `request_sent_date` <= '" . date('Y-m-d', strtotime($status_end_date)) . "' ";
                $str_sql_status_date2 = " AND `request_sent_date` >= '" . date('Y-m-d', strtotime($status_start_date)) . "' AND `request_sent_date` <= '" . date('Y-m-d', strtotime($status_end_date)) . "' ";
            }
        }
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE "
        //update by ample 24-10-19
        // . "(`user_id` = '".$pro_user_id."' ".$str_sql_user_id1." ".$str_sql_status1." ".$str_sql_invite_date1." ".$str_sql_status_date1." AND `invite_by_user` = '0') "
        // . "OR (`user_email` = '".$user_email."' ".$str_sql_user_id2." ".$str_sql_status2." ".$str_sql_invite_date2." ".$str_sql_status_date2." AND `invite_by_user` = '1') "
        // . " ORDER BY request_sent_date";
         . "(`vendor_id` = '" . $vendor_id . "' " . $str_sql_user_id1 . " " . $str_sql_status1 . " " . $str_sql_invite_date1 . " " . $str_sql_status_date1 . " AND `invite_by_user` = '0') " . "OR (`user_email` = '" . $user_email . "' " . $str_sql_user_id2 . " " . $str_sql_status2 . " " . $str_sql_invite_date2 . " " . $str_sql_status_date2 . " AND `invite_by_user` = '1') " . " ORDER BY request_sent_date";
        // echo '<br>'.$sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $temp_arr[] = $row;
            }
        }
        return $temp_arr;
    }
    public function getAllAdviserUserReferrals($vendor_id, $user_id="", $txtsearch, $invite_start_date, $invite_end_date) {
        $DBH = new DatabaseHandler();
        $temp_arr = array();
        $str_sql_user=$str_sql_vendor=$str_search="";
        $where="";$and1="";$and2="";$and3="";
        if($vendor_id || $user_id || $txtsearch || $invite_start_date || $invite_end_date)
        {
            $where=' WHERE';
        }
        if ($user_id) 
        {   
            $str_sql_user = " `user_id` = '" . $user_id . "' ";
        }
        if ($vendor_id) 
        {   
            if($user_id)
            {
                $and1=' AND';
            }
            $str_sql_vendor = " `vendor_id` = '" . $vendor_id . "' ";
        }
        if($txtsearch)
        {   
            if($user_id || $vendor_id)
            {
                $and2=' AND';
            }

            $str_search = " ( `user_email` Like '%".$txtsearch."%' OR `user_name` Like '%".$txtsearch."%' OR `message` Like '%".$txtsearch."%' ) ";
        }

        if ($invite_start_date == '' && $invite_end_date == '') {
            $str_sql_invite_date1 = "";
            $str_sql_invite_date2 = "";
        } else {
            if ($invite_start_date != '' && $invite_end_date == '') {
                if($user_id || $vendor_id || $txtsearch)
                {
                    $and3=' AND';
                }
                $str_sql_invite_date1 = $and3. "  `request_sent_date` = '" . date('Y-m-d', strtotime($invite_start_date)) . "' ";
                $str_sql_invite_date2 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($invite_start_date)) . "' ";
            } elseif ($invite_start_date == '' && $invite_end_date != '') {
                if($user_id || $vendor_id || $txtsearch)
                {
                    $and3=' AND';
                }
                $str_sql_invite_date1 = $and3. "  `request_sent_date` = '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
                $str_sql_invite_date2 = " AND `request_sent_date` = '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
            } else {
                if($user_id || $vendor_id || $txtsearch)
                {
                    $and3=' AND';
                }
                $str_sql_invite_date1 = $and3."  `request_sent_date` >= '" . date('Y-m-d', strtotime($invite_start_date)) . "' AND `request_sent_date` <= '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
                $str_sql_invite_date2 = " AND `request_sent_date` >= '" . date('Y-m-d', strtotime($invite_start_date)) . "' AND `request_sent_date` <= '" . date('Y-m-d', strtotime($invite_end_date)) . "' ";
            }
        }
      
        $sql = "SELECT * FROM `tbladviserreferrals` ".$where."  ".$str_sql_user." ".$and1." ".$str_sql_vendor." ".$and2." ".$str_search." ".$str_sql_invite_date1." ".$str_sql_invite_date2." ORDER BY request_sent_date";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $temp_arr[] = $row;
            }
        }
        return $temp_arr;
    }
    //update by ample 04-03-20
    public function getAllAdviserUserQueries($pro_user_id, $user_id, $pg_id, $start_date, $end_date, $search_keywords) {
        $DBH = new DatabaseHandler();
        $temp_arr = array();
        if ($user_id != '') {
            $str_sql_user_id = " AND `user_id` = '" . $user_id . "' ";
        } else {
            $str_sql_user_id = '';
        }
        if ($pg_id != '') {
            // $arr_temp = explode('_', $pg_id);
            $arr_temp = explode('|', $pg_id);
            $temp_page_id = $arr_temp[0];
            $temp_page_tbl = $arr_temp[1];
            // $temp_permission_type = $arr_temp[1];
            //$str_sql_pg_id = " AND `page_id` = '" . $temp_page_id . "' AND `permission_type` = '" . $temp_permission_type . "' ";
            $str_sql_pg_id = " AND `page_id` = '" . $temp_page_id . "' AND `page_table` = '" . $temp_page_tbl . "' ";
        } else {
            $str_sql_pg_id = '';
        }
        if ($search_keywords != '') {
            $str_sql_search_keywords = " AND ( `query` LIKE '%" . $search_keywords . "%' OR `aq_user_unique_id` LIKE '%" . $search_keywords . "%' )";
        } else {
            $str_sql_search_keywords = '';
        }
        //update by ample 03-03-20 remove pro_user_id add vendor_id & again update remove `from_user` = '1' 25-03-20
        $sql = "SELECT * FROM `tbladviserqueries` WHERE  `vendor_id` = '" . $pro_user_id . "' AND `parent_aq_id` = '0' AND DATE(aq_add_date) >= '" . date('Y-m-d', strtotime($start_date)) . "' AND DATE(aq_add_date) <= '" . date('Y-m-d', strtotime($end_date)) . "' " . $str_sql_user_id . " " . $str_sql_pg_id . "  " . $str_sql_search_keywords . "  ORDER BY `aq_add_date` DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $temp_arr[] = $row;
            }
        }
        return $temp_arr;
    }
    public function getProUserEmailById($pro_user_id) {
        $DBH = new DatabaseHandler();
        $email = '';
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $pro_user_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $email = $row['vendor_email'];
        }
        return $email;
    }
    public function getUserEmailById($user_id) {
        $DBH = new DatabaseHandler();
        $email = '';
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '" . $user_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $email = $row['email'];
        }
        return $email;
    }
    public function getUserRegistrationDateByEmail($email) {
        $DBH = new DatabaseHandler();
        $user_add_date = '';
        $sql = "SELECT * FROM `tblusers` WHERE `email` = '" . $email . "'";
        //echo "<br>Testkk sql = ".$sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $user_add_date = date('d/m/Y h:i:s A', stripslashes($row['user_add_date']));
        }
        return $user_add_date;
    }
    public function getUserId($email) {
        $DBH = new DatabaseHandler();
        $user_id = 0;
        $sql = "SELECT * FROM `tblusers` WHERE `email` = '" . $email . "' AND `status` = '1'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['user_id'];
        }
        return $user_id;
    }
    public function getUserFullNameById($user_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $name = '';
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '" . $user_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $return = true;
            $name = stripslashes($row['name']);
        }
        return $name;
    }
    public function chkIfUserIsAdvisersReferrals($pro_user_id, $user_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $user_email = $this->getUserEmailById($user_id);
        $pro_user_email = $this->getProUserEmailById($pro_user_id);
        //$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1'";
        //update 	vendor_id by ample 03-03-20
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE (`vendor_id` = '" . $pro_user_id . "' AND `user_email` = '" . $user_email . "' AND `request_status` = '1' AND `invite_by_user` = '0') OR (`vendor_id` = '" . $pro_user_id . "' AND `user_email` = '" . $pro_user_email . "' AND `request_status` = '1' AND `invite_by_user` = '1')";
        //echo '<br>'.$sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //add by ample 06-03-20
    public function chkIfIsAdvisersReferralsData($pro_user_id, $user_id) {
        $DBH = new DatabaseHandler();
        $ar_id = $request_status=$last_status="";
        $user_email = $this->getUserEmailById($user_id);
        $pro_user_email = $this->getProUserEmailById($pro_user_id);
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE (`vendor_id` = '" . $pro_user_id . "' AND `user_email` = '" . $user_email . "' AND  `invite_by_user` = '0') OR (`user_id` = '" . $user_id . "' AND `user_email` = '" . $pro_user_email . "' AND `invite_by_user` = '1')";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $ar_id = $row['ar_id'];
            $request_status = $row['request_status'];
            $last_status=$row['last_status_updated_by_adviser'];
        }
        return array($ar_id, $request_status,$last_status);
    }
    //add by ample 06-03-20
    public function chkIfUserIsAdvisersReferralsChkByUserEmail($user_email, $vendor_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $user_id = $this->getUserId($user_email);
        $vendor_email = $this->getProUserEmailById($vendor_id);

        $sql = "SELECT * FROM `tbladviserreferrals` WHERE `user_id` = '" . $user_id . "' AND `user_email` = '" . $vendor_email . "' AND `request_status` = '1'";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getReportTypeName($report_id) {
        $DBH = new DatabaseHandler();
        $output = 'My Query';
        $sql = "SELECT * FROM `tblusersreports` WHERE `report_id`  = '" . $report_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $output = stripslashes($row['report_name']);
        }
        return $output;
    }
    //add by ample 04-03-20 & update 
    public function getReferenceName($report_id = "", $report_tbl = "") {
        $DBH = new DatabaseHandler();
        $output = 'My Query';
        if($report_tbl=='tbl_recordshow_dropdown')
        {
            $sql = "SELECT report_name FROM `tbl_recordshow_dropdown` WHERE `page_cat_id`  = '" . $report_id . "'";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $output = stripslashes($row['report_name']);
            }
        } elseif ($report_tbl == 'tblfavcategory') {
            $sql = "SELECT fav_cat FROM `tblfavcategory` WHERE `fav_cat_id`  = '" . $report_id . "'";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $output = stripslashes($row['fav_cat']);
            }
        }
        elseif ($report_tbl == 'tblusersreports') {
            $sql = "SELECT report_name FROM `tblusersreports` WHERE `report_id`  = '" . $report_id . "'";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $output = stripslashes($row['report_name']);
            }
        }
        return $output;
    }
    public function getAllAdviserQueriesByID($id) {
        $DBH = new DatabaseHandler();
        $temp_arr = array();
        $str_feedback_id = $this->getAllConvarsationIdAdviserQuery($id);
        $sql = "SELECT * FROM `tbladviserqueries` WHERE  `aq_id` IN (" . $str_feedback_id . ") ORDER BY `aq_add_date` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $temp_arr[] = $row;
            }
        }
        return $temp_arr;
    }
    public function getAllConvarsationIdAdviserQuery($id) {
        $main_parent_id = $this->getMainParantIdAdviserQuery($id);
        $str_feedback_id = $this->getRecursiveAdviserQueryId($main_parent_id, $main_parent_id);
        return $str_feedback_id;
    }
    public function getMainParantIdAdviserQuery($id) {
        $DBH = new DatabaseHandler();
        $sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '" . $id . "' ORDER BY `aq_add_date` DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $parent_feedback_id = $row['parent_aq_id'];
            if ($parent_feedback_id == 0) {
                return $id;
            } else {
                return $this->getMainParantIdAdviserQuery($parent_feedback_id);
            }
        } else {
            return 0;
        }
    }
    public function getRecursiveAdviserQueryId($main_parent_id, $return) {
        $DBH = new DatabaseHandler();
        $sql = "SELECT * FROM `tbladviserqueries` WHERE `parent_aq_id` = '" . $main_parent_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $temp_feedback_id = $row['aq_id'];
                if ($return == '') {
                    $return.= $this->getRecursiveAdviserQueryId($temp_feedback_id, $main_parent_id) . ',';
                } else {
                    $return.= ',' . $this->getRecursiveAdviserQueryId($temp_feedback_id, $main_parent_id);
                }
            }
        } else {
            $return.= ',' . $main_parent_id;
        }
        return $return;
    }
    //update by ample 06-03-20
    public function getAllMyUserInvitations($vendor_id, $user_id="") {
        $search_user_id = $user_id != '' ? ' AND tar.user_id="' . $user_id . '"' : '';
        $DBH = new DatabaseHandler();
        $temp_arr = array();
        // remove tar.invite_by_user = '1' by ample 24-10-19
        $sql = "SELECT * FROM `tbladviserreferrals` AS tar " . "LEFT JOIN `tblusers` AS tpf ON tar.user_id = tpf.user_id " . "WHERE tar.vendor_id = '" . $vendor_id . "' " . $search_user_id . "  AND (tar.request_status = '1' OR tar.request_status = '3')" . "ORDER BY tar.request_sent_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $temp_arr[] = $row;
            }
        }
        //   $sql = "SELECT * FROM `tbladviseractivation` WHERE `user_id` = '".$user_id."'AND `vendor_id`='".$vendor_id."' ORDER BY aa_add_date DESC";
        // $STH = $DBH->query($sql);
        // if( $STH->rowCount() > 0 )
        //        {
        //            while($row = $STH->fetch(PDO::FETCH_ASSOC))
        //            {
        // 		$temp_arr[] = $row;
        // 	    }
        // 	}
        // if($pro_user_id != '')
        // {
        // 	$str_sql_pro_user_id = " AND tar.pro_user_id = '".$pro_user_id."' ";
        // }
        // else
        // {
        // 	$str_sql_pro_user_id = "";
        // }
        //       $sql = "SELECT * FROM `tbladviserreferrals` AS tar "
        //            . "LEFT JOIN `tblusers` AS tpf ON tar.pro_user_id = tpf.user_id "
        //            . "WHERE tar.user_email = '".$user_email."' AND tar.invite_by_user = '1' AND (tar.request_status = '1' OR tar.request_status = '3')  ".$str_sql_pro_user_id." "
        //            . "ORDER BY tar.request_sent_date DESC";
        // $STH = $DBH->query($sql);
        //        if( $STH->rowCount() > 0 )
        //        {
        // 		while($row = $STH->fetch(PDO::FETCH_ASSOC))
        // 		{
        // 			$temp_arr[] = $row;
        // 		}
        //     }
        //    $puid = $this->getProUserId($user_email);
        //    if($pro_user_id != '')
        // {
        // 	$str_sql_pro_user_email = " AND tpf.user_id = '".$pro_user_id."' ";
        // }
        // else
        // {
        // 	$str_sql_pro_user_email = "";
        // }
        //        $sql = "SELECT * FROM `tbladviserreferrals` AS tar "
        //            . "LEFT JOIN `tblusers` AS tpf ON tar.user_email = tpf.email "
        //            . "WHERE tar.pro_user_id = '".$puid."' AND tar.invite_by_user = '0' AND (tar.request_status = '1' OR tar.request_status = '3')  ".$str_sql_pro_user_email." "
        //            . "ORDER BY tar.request_sent_date DESC";
        // $STH = $DBH->query($sql);
        //        if( $STH->rowCount() > 0 )
        //        {
        // 		while($row = $STH->fetch(PDO::FETCH_ASSOC))
        // 		{
        // 			$temp_arr[] = $row;
        // 		}
        //     }
        return $temp_arr;
    }
    public function getAdviserStatusActivationsRecords($ar_id, $user_id, $vendor_id) {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        // $sql = "SELECT * FROM `tbladviseractivation` WHERE `ar_id` = '".$ar_id."' ORDER BY aa_add_date DESC";
        // $sql = "SELECT * FROM `tbladviseractivation` WHERE `pro_user_id` = '".$pro_user_id."'AND `vendor_id`='".$vendor_id."' ORDER BY aa_add_date DESC";
        $sql = "SELECT * FROM `tbladviseractivation` WHERE `user_id` = '" . $user_id . "'AND `vendor_id`='" . $vendor_id . "' ORDER BY aa_add_date DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $arr_record[] = $row;
            }
        }
        // echo "<pre>";print_r();echo "</pre>";
        return $arr_record;
    }
    public function getAdviserReportsPermissions($user_id, $pro_user_id, $ar_id) {
        $DBH = new DatabaseHandler();
        $temp_arr = array();
        //update query by ample 01-11-19
        $sql = "SELECT * FROM `tbladviserreportpermission` WHERE `user_id` = '" . $user_id . "' AND `pro_user_id` = '" . $pro_user_id . "' AND `ar_id` = '" . $ar_id . "' ORDER BY `arp_add_date` DESC";
        //$sql = "SELECT * FROM `tbladviserreportpermission` WHERE `ar_id` = '".$ar_id."' ORDER BY `arp_add_date` DESC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $temp_arr[] = $row;
            }
        }
        return $temp_arr;
    }
    public function getReportTypeNameString($str_report_id, $str_permission_type) {
        $DBH = new DatabaseHandler();
        $output = '';
        if ($str_report_id != '') {
            $arr_temp_report_id = explode(',', $str_report_id);
            $arr_temp_permission_type = explode(',', $str_permission_type);
            for ($i = 0;$i < count($arr_temp_report_id);$i++) {
                //change table name and key by ample 01-11-19
                //$sql = "SELECT * FROM `tblusersreports` WHERE `report_id`  = '".$arr_temp_report_id[$i]."'";
                $sql = "SELECT * FROM `tbl_recordshow_dropdown` WHERE `page_cat_id`  = '" . $arr_temp_report_id[$i] . "'";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    //code comment by ample 1-11-19
                    // if($arr_temp_permission_type[$i] == '2')
                    // {
                    // 	$temp_permission_type = 'Standard Set';
                    // }
                    // elseif($arr_temp_permission_type[$i] == '3')
                    // {
                    // 	$temp_permission_type = 'Adviser Set';
                    // }
                    // else
                    // {
                    // 	$temp_permission_type = 'Both Set';
                    // }
                    //$output .= $row['report_name'].'('.$temp_permission_type.'), ';
                    $output.= $row['report_name'];
                    $output.= ',';
                }
            }
            $output = substr($output, 0, -2);
        }
        return $output;
    }
    public function getProUserId($email) {
        $DBH = new DatabaseHandler();
        $pro_user_id = 0;
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '" . $email . "' AND `vendor_status` = '1'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $pro_user_id = $row['vendor_id'];
        }
        return $pro_user_id;
    }
    public function genrateProUserUniqueId($user_id) {
        $unique_id = '';
        $strlen_user_id = strlen($user_id);
        if ($strlen_user_id == 1) {
            $unique_id = 'WP10000000' . $user_id;
        } elseif ($strlen_user_id == 2) {
            $unique_id = 'WP1000000' . $user_id;
        } elseif ($strlen_user_id == 3) {
            $unique_id = 'WP100000' . $user_id;
        } elseif ($strlen_user_id == 4) {
            $unique_id = 'WP10000' . $user_id;
        } elseif ($strlen_user_id == 5) {
            $unique_id = 'WP1000' . $user_id;
        } elseif ($strlen_user_id == 6) {
            $unique_id = 'WP100' . $user_id;
        } elseif ($strlen_user_id == 7) {
            $unique_id = 'WP10' . $user_id;
        } else {
            $unique_id = 'WP1' . $user_id;
        }
        return $unique_id;
    }
    public function updatevendoruniqueid($vendor_unique_id, $vendor_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
            $sql = "UPDATE `tblvendors` SET 

                                    `vendor_unique_id` = :vendor_unique_id  

                                     WHERE `vendor_id` = :vendor_id ";
            $STH = $DBH->prepare($sql);
            $STH->execute(array(':vendor_unique_id' => $vendor_unique_id, ':vendor_id' => $vendor_id));
            $DBH->commit();
            $return = true;
        }
        catch(Exception $e) {
            $stringData = '[upadtevendor] Catch Error:' . $e->getMessage() . ', sql:' . $sql;
            $this->debuglog($stringData);
            return $return;
        }
        return $return;
    }
    public function getAdvisersUserOptions($user_id, $pro_user_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        //$email = getUserEmailById($user_id);
        $email = $this->getProUserEmailById($pro_user_id);
        $sql = "SELECT * FROM `tbladviserreferrals` AS tar " . "LEFT JOIN `tblusers` AS tpu ON tar.pro_user_id = tpu.user_id  " . "WHERE tar.user_email = '" . $email . "' AND tar.invite_by_user = '1' AND tar.request_status = '1' " . "ORDER BY tpu.name ASC";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['pro_user_id'] == $user_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $option_str.= '<option value="' . $row['pro_user_id'] . '" ' . $sel . '>' . stripslashes($row['name']) . '</option>';
            }
        }
        $sql = "SELECT * FROM `tbladviserreferrals` AS tar " . "LEFT JOIN `tblusers` AS tpu ON tar.user_email = tpu.email  " . "WHERE tar.pro_user_id = '" . $pro_user_id . "' AND tar.invite_by_user = '0' AND tar.request_status = '1'  " . "ORDER BY tpu.name ASC";
        //echo $sql;
        $STH2 = $DBH->query($sql);
        if ($STH2->rowCount() > 0) {
            while ($row = $STH2->fetch(PDO::FETCH_ASSOC)) {
                if ($row['user_id'] == $user_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $option_str.= '<option value="' . $row['user_id'] . '" ' . $sel . '>' . stripslashes($row['name']) . '</option>';
            }
        }
        return $option_str;
    }
    public function getUserQueryPageOptions($page_id, $user_id, $pro_user_id, $show_all = '1') {
        $DBH = new DatabaseHandler();
        $option_str = '';
        if ($page_id == '0_0') {
            $sel = ' selected ';
        } else {
            $sel = '';
        }
        //$option_str .= '<option value="0_0" '.$sel.'>My Query</option>';
        list($str_report_id, $str_permission_type) = $this->getUserAcceptedReportId($user_id, $pro_user_id);
        if ($str_report_id != '') {
            $arr_report_id = explode(',', $str_report_id);
            $arr_permission_type = explode(',', $str_permission_type);
            for ($i = 0;$i < count($arr_report_id);$i++) {
                //$sql = "SELECT * FROM `tblusersreports` WHERE `report_id` = '".$arr_report_id[$i]."' AND `report_status` = '1' ORDER BY `report_name` ASC";
                //echo $sql;
                $sql = "SELECT * FROM `tblpagedropdowns` WHERE pd_id = '20' and  `pd_status` = 1 ";
                $STH2 = $DBH->query($sql);
                if ($STH2->rowCount() > 0) {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $page_id_arr = explode(',', $row['page_id_str']);
                    for ($i = 0;$i < count($page_id_arr);$i++)
                    //while($row = $STH2->fetch(PDO::FETCH_ASSOC) )
                    {
                        if ($page_id == $page_id_arr[$i] . '_1') {
                            $sel1 = '';
                            $sel2 = ' selected ';
                        } elseif ($page_id == $page_id_arr[$i] . '_0') {
                            $sel1 = ' selected ';
                            $sel2 = '';
                        } else {
                            $sel1 = '';
                            $sel2 = '';
                        }
                        if ($arr_permission_type[$i] == '2') {
                            $option_str.= '<option value="' . $page_id_arr[$i] . '_0" ' . $sel1 . '>' . $this->get_PageName($page_id_arr[$i]) . ' (Standard Set)</option>';
                        } elseif ($arr_permission_type[$i] == '3') {
                            $option_str.= '<option value="' . $page_id_arr[$i] . '_1" ' . $sel2 . '>' . $this->get_PageName($page_id_arr[$i]) . ' (Adviser Set)</option>';
                        } else {
                            $option_str.= '<option value="' . $page_id_arr[$i] . '_0" ' . $sel1 . '>' . $this->get_PageName($page_id_arr[$i]) . ' (Standard Set)</option>';
                            $option_str.= '<option value="' . $page_id_arr[$i] . '_1" ' . $sel2 . '>' . $this->get_PageName($page_id_arr[$i]) . ' (Adviser Set)</option>';
                        }
                    }
                }
            }
        } elseif ($show_all == '1') {
            //$sql = "SELECT * FROM `tblusersreports` WHERE `report_status` = '1' ORDER BY `report_name` ASC";
            //echo $sql;
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE pd_id = '20' and  `pd_status` = 1 ";
            $STH2 = $DBH->query($sql);
            if ($STH2->rowCount() > 0) {
                $row = $STH2->fetch(PDO::FETCH_ASSOC);
                $page_id_arr = explode(',', $row['page_id_str']);
                for ($i = 0;$i < count($page_id_arr);$i++) {
                    if ($page_id == $page_id_arr[$i] . '_1') {
                        $sel1 = '';
                        $sel2 = ' selected ';
                    } elseif ($page_id == $page_id_arr[$i] . '_0') {
                        $sel1 = ' selected ';
                        $sel2 = '';
                    } else {
                        $sel1 = '';
                        $sel2 = '';
                    }
                    $option_str.= '<option value="' . $page_id_arr[$i] . '_0" ' . $sel1 . '>' . $this->get_PageName($page_id_arr[$i]) . ' (Standard Set)</option>';
                    $option_str.= '<option value="' . $page_id_arr[$i] . '_1" ' . $sel2 . '>' . $this->get_PageName($page_id_arr[$i]) . ' (Adviser Set)</option>';
                }
            }
        }
        return $option_str;
    }
    public function getUserAcceptedReportId($user_id, $pro_user_id) {
        $DBH = new DatabaseHandler();
        $str_report_id = '';
        $str_permission_type = '';
        $user_email = $this->getUserEmailById($user_id);
        $pro_user_email = $this->getProUserEmailById($pro_user_id);
        //$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1' ORDER BY `ar_id` DESC LIMIT 1";
        $sql = "SELECT * FROM `tbladviserreferrals` " . "WHERE ( (`pro_user_id` = '" . $pro_user_id . "' AND `user_email` = '" . $user_email . "' AND `invite_by_user` = '0') " . "OR (`pro_user_id` = '" . $user_id . "' AND `user_email` = '" . $pro_user_email . "' AND `invite_by_user` = '1') ) " . "AND ( `request_status` = '1' ) ORDER BY `ar_id` DESC LIMIT 1";
        //echo $sql;
        $STH2 = $DBH->query($sql);
        if ($STH2->rowCount() > 0) {
            $row = $STH2->fetch(PDO::FETCH_ASSOC);
            $str_report_id = $row['report_id'];
            $str_permission_type = $row['permission_type'];
            list($str_report_id, $str_permission_type) = $this->getUserPlanRefinedReportsIds($user_id, $str_report_id, $str_permission_type);
        }
        return array($str_report_id, $str_permission_type);
    }
    public function getUserPlanRefinedReportsIds($user_id, $str_report_id, $str_permission_type) {
        $DBH = new DatabaseHandler();
        $return_str_report_id = '';
        $return_permission_type = '';
        if ($str_report_id != '') {
            $arr_report_id = explode(',', $str_report_id);
            $arr_permission_type = explode(',', $str_permission_type);
            for ($i = 0;$i < count($arr_report_id);$i++) {
                $sql = "SELECT * FROM `tbladviserplanatributes` WHERE `ref_report_id` = '" . $arr_report_id[$i] . "' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";
                //echo $sql;
                $STH2 = $DBH->query($sql);
                if ($STH2->rowCount() > 0) {
                    $row = $STH2->fetch(PDO::FETCH_ASSOC);
                    $temp_apa_id = $row['apa_id'];
                    if ($this->chkUserPlanFeaturePermission($user_id, $temp_apa_id)) {
                        $return_str_report_id.= $arr_report_id[$i] . ',';
                        $return_permission_type.= $arr_permission_type[$i] . ',';
                    }
                }
            }
            $return_str_report_id = substr($return_str_report_id, 0, -1);
            $return_permission_type = substr($return_permission_type, 0, -1);
        }
        return array($return_str_report_id, $return_permission_type);
    }
    public function chkUserPlanFeaturePermission($user_id, $upa_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $default_up_id = $this->getUserDefaultPlanId();
        $sql = "SELECT * FROM `tbluserplandetails` AS tupd LEFT JOIN `tbluserplans` AS tup ON tupd.up_id = tup.up_id WHERE tupd.up_id = '" . $default_up_id . "' AND tup.up_default = '1' AND tup.up_status = '1' AND tup.up_deleted = '0' AND tupd.upa_id = '" . $upa_id . "' AND tupd.upd_status = '1'  AND tupd.upd_deleted = '0' AND tupd.upa_value = '1' ";
        //echo '<br>sql = '.$sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        } else {
            $user_up_id = $this->getUserCurrentActivatedPlanId($user_id);
            if ($user_up_id > 0) {
                $sql2 = "SELECT * FROM `tbluserplandetails` AS tupd LEFT JOIN `tbluserplans` AS tup ON tupd.up_id = tup.up_id WHERE tupd.up_id = '" . $user_up_id . "' AND tup.up_status = '1' AND tup.up_deleted = '0' AND tupd.upa_id = '" . $upa_id . "' AND tupd.upd_status = '1'  AND tupd.upd_deleted = '0' AND tupd.upa_value = '1' ";
                //echo '<br>sql2 = '.$sql2;
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    $return = true;
                }
            }
        }
        return $return;
    }
    public function getUserDefaultPlanId() {
        $DBH = new DatabaseHandler();
        $up_id = 0;
        $sql = "SELECT * FROM `tbluserplans` WHERE `up_default` = '1' AND `up_status` = '1' AND `up_deleted` = '0' ORDER BY `up_add_date` DESC LIMIT 1";
        //echo '<br>'.$sql.'<br>';
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $up_id = $row['up_id'];
        }
        return $up_id;
    }
    public function getUserCurrentActivatedPlanId($user_id) {
        $DBH = new DatabaseHandler();
        $up_id = 0;
        $sql = "SELECT * FROM `tbluserplanrequests` WHERE `user_id` = '" . $user_id . "' AND `upr_status` = '1' ORDER BY `upr_add_date` DESC LIMIT 1";
        //echo '<br>'.$sql.'<br>';
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $up_id = $row['up_id'];
        } else {
            $up_id = $this->getUserDefaultPlanId();
        }
        return $up_id;
    }
    public function get_PageName($page_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $page_name = '';
        $sql = "SELECT * FROM `tblpages` WHERE  `page_id` = '" . $page_id . "' ";
        //echo $sql;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $page_name = stripslashes($row['page_name']);
        }
        return $page_name;
    }
    //update by ample 04-03-20
    public function showUserQueryPopup($pro_user_id, $parent_aq_id,$user_id) {
        $output = '';
        $name = $this->getUserFullNameById($user_id);
        $email = $this->getUserEmailById($user_id);
        $readonly = ' readonly ';
        $temp_page_id = '';
        $temp_user_id = $user_id;
        if ($parent_aq_id == '' || $parent_aq_id == '0' || $parent_aq_id == 0) {
            $readonly2 = '';
            $parent_aq_id = '0';

            $output.= '<form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data">'; 
            $output.= '<input type="hidden" name="hdnparent_aq_id" id="hdnparent_aq_id" value="' . $parent_aq_id . '" />'; 
            $output.= '<input type="hidden" name="hdntemp_pro_user_id" id="hdntemp_pro_user_id" value="' . $pro_user_id . '" />'; 
            $output.= '<input type="hidden" name="hdntemp_user_id" id="hdntemp_user_id" value="' . $user_id . '" />'; 
            $output.= '<input type="hidden" name="hdnname" id="hdnname" value="' . $name . '" />'; 
            $output.= '<input type="hidden" name="hdnemail" id="hdnemail" value="' . $email . '" />'; 
            $output.= '<input type="hidden" name="hdnfrom_user" id="from_user" value="0" />'; 
            $output.= '<table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">';
            
        } else {
            $query_data = $this->getAdviserQueryDetails($parent_aq_id);
            $temp_page_id = $query_data[0]['page_id'];
            $temp_page_tbl = $query_data[0]['page_table'];
            $temp_user_id = $query_data[0]['user_id'];
            $name = $query_data[0]['user_name'];
            $email = $query_data[0]['user_email'];
            $temp_query = $query_data[0]['query'];
            $readonly2 = ' readonly ';

            $output.= '<form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data">'; 
            $output.= '<input type="hidden" name="hdnparent_aq_id" id="hdnparent_aq_id" value="' . $parent_aq_id . '" />'; 
            $output.= '<input type="hidden" name="hdntemp_pro_user_id" id="hdntemp_pro_user_id" value="' . $pro_user_id . '" />'; 
            $output.= '<input type="hidden" name="hdntemp_user_id" id="hdntemp_user_id" value="' . $temp_user_id . '" />'; 
            $output.= '<input type="hidden" name="hdntemp_page_id" id="hdntemp_page_id" value="' . $temp_page_id . '|' . $temp_page_tbl . '" />'; 
            $output.= '<input type="hidden" name="hdnname" id="hdnname" value="' . $name . '" />'; 
            $output.= '<input type="hidden" name="hdnemail" id="hdnemail" value="' . $email . '" />'; 
            $output.= '<input type="hidden" name="hdnfrom_user" id="from_user" value="0" />'; 
            $output.= '<table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">';
        }
           

            if ($parent_aq_id == '0') {

                $output.='<tr><td width="60%" height="40" align="left" valign="top">Reference:</td><td width="40%" height="40" align="left" valign="top"><select id="hdntemp_page_id" name="temp_page_id" ' . $readonly2 . ' style="width:150px;">

                                    <option value="">Select Reference</option>

                                    ' . $this->getAdviserQueryReference($user_id, $pro_user_id) . '

                                </select>
                </td></tr>';
                $output.='<tr><td width="60%" height="40" align="left" valign="top">User:</td><td width="40%" height="40" align="left" valign="top">' . $name . '</td></tr>';
                        // $output.='<tr><td width="60%" height="40" align="left" valign="top">Email:</td><td width="40%" height="40" align="left" valign="top">' . $email . '</td></tr>';
                        $output.='<tr><td width="60%" height="110" align="left" valign="top">Reply:</td><td width="40%" height="110" align="left" valign="top"><textarea  cols="30" rows="5" type="text" id="feedback" name="feedback"></textarea></td></tr>';
                        $output.='<tr><td width="60%" height="40" align="left" valign="middle">&nbsp;</td><td width="40%" height="40" align="left" valign="middle"><input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="replyUserQuery()"/></td></tr>';
            }
            else
            {
                 $output.='<tr><td width="60%" height="40" align="left" valign="top">Reference:</td><td width="40%" height="40" align="left" valign="top">' . $this->getReferenceName($temp_page_id,$temp_page_tbl) . '</td></tr>';
                $output.='<tr><td width="60%" height="40" align="left" valign="top">User:</td><td width="40%" height="40" align="left" valign="top">' . $name . '</td></tr>';
                        // $output.='<tr><td width="60%" height="40" align="left" valign="top">Email:</td><td width="40%" height="40" align="left" valign="top">' . $email . '</td></tr>';
                        $output.='<tr><td width="60%" height="110" align="left" valign="top">Query:</td><td width="40%" height="110" align="left" valign="top">' . $temp_query . '</td></tr>';
                        $output.='<tr><td width="60%" height="110" align="left" valign="top">Reply:</td><td width="40%" height="110" align="left" valign="top"><textarea  cols="30" rows="5" type="text" id="feedback" name="feedback"></textarea></td></tr>';
                        $output.='<tr><td width="60%" height="40" align="left" valign="middle">&nbsp;</td><td width="40%" height="40" align="left" valign="middle"><input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="replyUserQuery()"/></td></tr>';
            }

					$output.='</table>
				</form>';
        return $output;
    }
    public function getAdviserQueryDetails($aq_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $temp_arr = array();
        $sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '" . $aq_id . "' ";
        //echo $sql;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $temp_arr[] = $row;
        }
        return $temp_arr;
    }
    //update by ample 04-03-20
    public function addAdviserQuery($parent_aq_id, $page_id, $user_id, $name, $email, $pro_user_id, $from_user, $query) {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        if ($page_id == '') {
            $temp_page_id = '0';
            $temp_permission_type = '0';
            $page_table='';
        } else {
            $arr_temp = explode('|', $page_id);
            $temp_page_id = $arr_temp[0];
            $page_table = $arr_temp[1];
            $temp_permission_type = '0';
        }
        if ($from_user == '1') {
            $aq_user_unique_id = $this->getUserAqUniqueId($user_id);
        } else {
            $aq_user_unique_id = $this->getProUserAqUniqueId($pro_user_id);
        }
        $sql = "INSERT INTO `tbladviserqueries`(`parent_aq_id`,`aq_user_unique_id`,`page_id`,`permission_type`,`user_id`,`user_name`,`user_email`,`vendor_id`,`query`,`from_user`,`aq_status`,page_table) VALUES ('" . addslashes($parent_aq_id) . "','" . addslashes($aq_user_unique_id) . "','" . addslashes($temp_page_id) . "','" . addslashes($temp_permission_type) . "','" . addslashes($user_id) . "','" . addslashes($name) . "','" . addslashes($email) . "','" . addslashes($pro_user_id) . "','" . addslashes($query) . "','" . addslashes($from_user) . "','1','" . addslashes($page_table) . "')";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
     //add ample 06-04-20
    public function updateUserQuery($aq_id, $query) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "UPDATE `tbladviserqueries` SET `query` = '".$query."' WHERE `aq_id` = '".$aq_id."'";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function getUserAqUniqueId($user_id) {
        $DBH = new DatabaseHandler();
        $return = '';
        $name = $this->getUserFullNameById($user_id);
        if ($name != '') {
            $str_name = strtoupper(substr($name, 0, 4));
            $sql = "SELECT * FROM `tbladviserqueries` WHERE `user_id` = '" . $user_id . "' AND `from_user` = '1' ";
            //echo $sql;
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $num_rows = $STH->rowCount() + 1;
                if (strlen($num_rows) == 1) {
                    $num_rows = '0000' . $num_rows;
                } elseif (strlen($num_rows) == 2) {
                    $num_rows = '000' . $num_rows;
                } elseif (strlen($num_rows) == 3) {
                    $num_rows = '00' . $num_rows;
                } elseif (strlen($num_rows) == 4) {
                    $num_rows = '0' . $num_rows;
                } else {
                    $num_rows = $num_rows;
                }
            }
            $return = $str_name . $num_rows;
        }
        return $return;
    }
    public function getProUserAqUniqueId($pro_user_id) {
        $DBH = new DatabaseHandler();
        $return = '';
        $name = $this->getProUserFullNameById($pro_user_id);
        if ($name != '') {
            $str_name = strtoupper(substr($name, 0, 4));
            //update vendor id remove pro user id by ample 04-03-20
            $sql = "SELECT * FROM `tbladviserqueries` WHERE `vendor_id` = '" . $pro_user_id . "' AND `from_user` = '0' ";
            //echo $sql;
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $num_rows = $STH->rowCount() + 1;
                if (strlen($num_rows) == 1) {
                    $num_rows = '0000' . $num_rows;
                } elseif (strlen($num_rows) == 2) {
                    $num_rows = '000' . $num_rows;
                } elseif (strlen($num_rows) == 3) {
                    $num_rows = '00' . $num_rows;
                } elseif (strlen($num_rows) == 4) {
                    $num_rows = '0' . $num_rows;
                } else {
                    $num_rows = $num_rows;
                }
            }
            $return = $str_name . $num_rows;
        }
        return $return;
    }
    public function getProUserFullNameById($pro_user_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $name = '';
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '" . $pro_user_id . "'";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $return = true;
            $name = stripslashes($row['vendor_name']);
        }
        return $name;
    }
    public function showActivateUserInvitationPopup($ar_id, $pro_user_id, $vendor_id) {
        $output = '';
        $output.= '<div style=""><table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;"><tbody><tr><td colspan="2" align="left" valign="middle" height="40">&nbsp;</td></tr><tr><td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Activation:</span></strong></td><td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td></tr><tr><td colspan="2" align="left" valign="middle" height="40">&nbsp;</td></tr><tr><td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Activate" onclick="activateUserInvitation(\'' . $ar_id . '\',\'' . $pro_user_id . '\',\'' . $vendor_id . '\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td></tr></tbody></table></div>';
        return $output;
    }
    public function showDeactivateUserInvitationPopup($ar_id, $pro_user_id, $vendor_id) {
        $output = '';
        $output.= '<div style="">';
        $output.= '<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;"><tbody><tr><td colspan="2" align="left" valign="middle" height="40">&nbsp;</td></tr><tr><td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Deactivation:</span></strong></td><td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td></tr><tr><td colspan="2" align="left" valign="middle" height="40">&nbsp;</td></tr><tr><td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Deactivate" onclick="deactivateUserInvitation(\'' . $ar_id . '\',\'' . $pro_user_id . '\',\'' . $vendor_id . '\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td></tr></tbody></table></div>';
        return $output;
    }
    public function deactivateUserInvitation($ar_id, $user_id, $pro_user_id, $status_reason) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $sql = "UPDATE `tbladviserreferrals` SET " . "`request_status` = '3' , `last_status_updated_by_adviser` = '1' " . "WHERE `ar_id` = '" . $ar_id . "' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $sql2 = "INSERT INTO `tbladviseractivation`(`ar_id`,`user_id`,`vendor_id`,`aa_status`,`aa_status_reason`,`aa_status_updated_by_adviser`) VALUES('" . $ar_id . "','" . $user_id . "','" . $pro_user_id . "','3','" . addslashes($status_reason) . "','1')";
            $STH2 = $DBH->prepare($sql2);
            $STH2->execute();
            if ($STH2->rowCount() > 0) {
                $return = true;
            }
        }
        return $return;
    }
    public function activateUserInvitation($ar_id, $user_id, $pro_user_id, $status_reason) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $sql = "UPDATE `tbladviserreferrals` SET " . "`request_status` = '1' , `last_status_updated_by_adviser` = '1' " . "WHERE `ar_id` = '" . $ar_id . "' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $sql2 = "INSERT INTO `tbladviseractivation`(`ar_id`,`user_id`,`vendor_id`,`aa_status`,`aa_status_reason`,`aa_status_updated_by_adviser`) VALUES('" . $ar_id . "','" . $user_id . "','" . $pro_user_id . "','1','" . addslashes($status_reason) . "','1')";
            $STH2 = $DBH->prepare($sql2);
            $STH2->execute();
            if ($STH2->rowCount() > 0) {
                $return = true;
            }
        }
        return $return;
    }
    public function updateAdvisorsReferral($ar_id, $pro_user_id, $user_email) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $sql = "UPDATE `tbladviserreferrals` SET `referral_accept_date` = NOW() , `referral_status` = '1' WHERE `ar_id` = '" . $ar_id . "' AND `pro_user_id` = '" . $pro_user_id . "' AND `user_email` = '" . $user_email . "'";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function doAcceptUserInvitation($ar_id, $user_id, $pro_user_id = "") {
        // This code added by ample 23-10-19
        if (empty($pro_user_id)) {
            $pro_user_id = $_SESSION['adm_vendor_id'];
        }
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        // if($this->chkIfUserRequestDateisUpdated($pro_user_id,$user_id))
        // {
        // $sql = "UPDATE `tbladviserreferrals` SET "
        //                       . "`request_status` = '1' ,`request_accept_date` = NOW(), `last_status_updated_by_adviser` = '1',`vendor_id`='".$_SESSION['adm_vendor_id']."' "
        //                       . "WHERE `ar_id` = '".$ar_id."'";
        //}
        // else
        // {
        $sql = "UPDATE `tbladviserreferrals` SET " . "`request_accept_date` = NOW(), `request_status` = '1', `last_status_updated_by_adviser` = '1',`vendor_id`='" . $_SESSION['adm_vendor_id'] . "' " . "WHERE `ar_id` = '" . $ar_id . "'";
        // }
        // echo "hi";
        // exit;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    function chkIfUserRequestDateisUpdated($pro_user_id, $user_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = true;
        $user_email = $this->getProUserEmailById($user_id);
        $sql = "SELECT * FROM `tbladviserreferrals` " . "WHERE `user_id` = '" . $pro_user_id . "' AND `user_email` = '" . $user_email . "' AND `request_accept_date` = '0000-00-00 00:00:00'";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $return = false;
        }
        return $return;
    }
    public function showDeclineUserInvitationPopup($ar_id, $pro_user_id) {
        $output = '';
        $output.= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';
        $output.= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">



					<tbody>



						';
        $output.= '		<tr>



							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>



						</tr>';
        $output.= '		<tr>



							<td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Decline:</span></strong></td>



							<td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td>



						</tr>';
        $output.= '		<tr>



							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>



						</tr>';
        $output.= '		<tr>



							<td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Deactivate" onclick="declineUserInvitation(\'' . $ar_id . '\',\'' . $pro_user_id . '\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>



							



						</tr>';
        $output.= '	</tbody>



					</table>



				</div>';
        return $output;
    }
    public function showDeclineUserInvitation($ar_id, $pro_user_id) {
        $output = '';
        $output.= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';
        $output.= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">



					<tbody>



						';
        $output.= '		<tr>



							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>



						</tr>';
        $output.= '		<tr>



							<td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Decline:</span></strong></td>



							<td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td>



						</tr>';
        $output.= '		<tr>



							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>



						</tr>';
        $output.= '		<tr>



							<td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Deactivate" onclick="declineUserInvitation(\'' . $ar_id . '\',\'' . $pro_user_id . '\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>



							



						</tr>';
        $output.= '	</tbody>



					</table>



				</div>';
        return $output;
    }
    public function declineUserInvitation($ar_id, $user_id, $pro_user_id, $status_reason) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $sql = "UPDATE `tbladviserreferrals` SET " . "`request_accept_date` = NOW() , `request_status` = '2' , `last_status_updated_by_adviser` = '1' " . "WHERE `ar_id` = '" . $ar_id . "' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $sql2 = "INSERT INTO `tbladviseractivation`(`ar_id`,`user_id`,`pro_user_id`,`aa_status`,`aa_status_reason`,`aa_status_updated_by_adviser`) VALUES('" . $ar_id . "','" . $user_id . "','" . $pro_user_id . "','2','" . addslashes($status_reason) . "','1')";
            $STH2 = $DBH->prepare($sql2);
            $STH2->execute();
            if ($STH2->rowCount() > 0) {
                $return = true;
            }
        }
        return $return;
    }
    //update by queary by ample 31-10-19
    public function getAdviserAcceptedUsersOptions($user_id = "", $vendor_id) {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $email = $this->getUserEmailById($user_id);
        // remove tar.invite_by_user = '1' by ample 24-10-19
        $sql = "SELECT tar.* ,tpu.name FROM `tbladviserreferrals` AS tar " . "LEFT JOIN `tblusers` AS tpu ON tar.user_id = tpu.user_id " . "WHERE tar.vendor_id = '" . $vendor_id . "' AND ( tar.request_status = '1' OR tar.request_status = '3') " . "GROUP BY tar.user_id ORDER BY tpu.name ASC";
        // $sql = "SELECT tar.* , tpu.name FROM `tbladviserreferrals` AS tar "
        //                 . "LEFT JOIN `tblusers` AS tpu ON tar.user_id = tpu.user_id "
        //                 . "WHERE ( tar.request_status = '1' OR tar.request_status = '3') "
        //                 . " GROUP BY tar.user_id   ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['user_id'] != 0 && $row['user_id'] != '') {
                    if ($row['user_id'] == $user_id) {
                        $option_str.= '<option value="' . $row['user_id'] . '" selected>' . stripslashes($row['name']) . '</option>';
                    } else {
                        $option_str.= '<option value="' . $row['user_id'] . '">' . stripslashes($row['name']) . '</option>';
                    }
                }
            }
        }
        return $option_str;
    }
    public function getReportnameOfUser($type) {
        $DBH = new DatabaseHandler();
        $flag = false;
        $sql = "SELECT `report_name` FROM `tbl_recordshow_dropdown` WHERE `enduse` = '" . $type . "' AND `pag_cat_status` = '1' AND `is_deleted`=0";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $html = "";
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $reportname = $row['report_name'];
                $html.= '<option value="' . $row['page_cat_id'] . '">' . $row['report_name'] . '</option>';
            }
            // $flag = true;
            
        }
        return $html;
    }
    // //add by ample 04-03-20
    // public function getAdviserQueryReference($user_id="", $vendor_id="",$show_all='0') {
    //     $DBH = new DatabaseHandler();
    //     $option_str = '';
    //     if($show_all=='1')
    //     {
    //        $data = array();
    //         $sql = "SELECT * FROM `tblusersreports` WHERE report_status='1' ORDER BY `report_name` ASC";
    //         $STH = $DBH->query($sql);
    //         if ($STH->rowCount() > 0) {
    //             while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
    //                 $data[] = $row;
    //             }
    //         }
    //         if (!empty($data)) {
    //             foreach ($data as $key => $value) {
    //                 $option_str.= '<option value="' . $value["report_id"] . '|tblusersreports">' . $value["report_name"] . ' </option>';
    //             }
    //         }
            
    //     }
    //     else
    //     {
    //         $str_report_id = $this->selectReportName($vendor_id,$user_id);
    //         if (!empty($str_report_id)) { 
    //             $arr_report_id = explode(',',$str_report_id);
    //             for ($i = 0;$i < count($arr_report_id);$i++) {
    //                 $sql = "SELECT * FROM `tblusersreports` WHERE report_id = '".$arr_report_id[$i]."' AND report_status='1' ORDER BY `report_name` ASC";
                   
    //                 $STH = $DBH->query($sql);
    //                 if ($STH->rowCount() > 0) {
    //                         $row = $STH->fetch(PDO::FETCH_ASSOC);
    //                         $option_str.= '<option value="' . $row["report_id"] .'|tblusersreports">' . $row["report_name"] .' </option>';
    //                     }
    //                 }
    //             }
    //     }
        
    //     $option_str.= $this->getManageFavCatDropdownData('36');
    //     return $option_str;
    // }
     //add by ample 04-03-20 & update 13-04-20 for change table
    public function getAdviserQueryReference($user_id="", $vendor_id="",$show_all='0',$page_id="") {
        $DBH = new DatabaseHandler();
        $option_str = '';
        if($show_all=='1')
        {
           $data = array();
            $sql = "SELECT page_cat_id,report_name FROM `tbl_recordshow_dropdown` WHERE pag_cat_status='1' AND is_deleted='0' AND enduse='user' ORDER BY `report_name` ASC";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $sel="";
                    if(!empty($page_id))
                    {
                       $page=explode('|',$page_id);
                        if($page[0]==$value["page_cat_id"] && $page[1]=='tbl_recordshow_dropdown')
                        {
                            $sel="selected";
                        }
                    }
                    $option_str.= '<option value="' . $value["page_cat_id"] . '|tbl_recordshow_dropdown">' . $value["report_name"] . ' </option>';
                }
            }
            
        }
        else
        {
            $str_report_id = $this->selectReportName($vendor_id,$user_id);
            if (!empty($str_report_id)) { 
                $arr_report_id = explode(',',$str_report_id);
                for ($i = 0;$i < count($arr_report_id);$i++) {
                    $sql = "SELECT page_cat_id,report_name FROM `tbl_recordshow_dropdown` WHERE page_cat_id = '".$arr_report_id[$i]."' AND pag_cat_status='1' AND is_deleted='0' AND enduse='user' ORDER BY `report_name` ASC";
                   
                    $STH = $DBH->query($sql);
                    if ($STH->rowCount() > 0) {
                            $row = $STH->fetch(PDO::FETCH_ASSOC);
                            $sel="";
                                if(!empty($page_id))
                                {
                                    $page=explode('|',$page_id);
                                    if($page[0]==$row["page_cat_id"] && $page[1]=='tbl_recordshow_dropdown')
                                    {
                                        $sel="selected";
                                    }
                                }
                            $option_str.= '<option value="' . $row["page_cat_id"] .'|tbl_recordshow_dropdown" '.$sel.'>' . $row["report_name"] .' </option>';
                        }
                    }
                }
        }
        
        $option_str.= $this->getManageFavCatDropdownData('36',$page_id);
        return $option_str;
    }
    //add by ample 03-03-20
    public function getManageFavCatDropdown($id = "") {
        $DBH = new DatabaseHandler();
        $data = array();
        $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '" . $id . "' LIMIT 1";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;
    }
    public function getManageFavCatDropdownData($id = "",$page_id="") {
        $option_str = '';
        $data = $this->getManageFavCatDropdown($id);
        if (!empty($data)) {
            $data['subcat'] = '';
            for ($i = 0;$i < 10;$i++) {
                if (!empty($data['sub_cat' . $i])) {
                    $data['subcat'] = $data['subcat'] . ',' . $data['sub_cat' . $i];
                }
                $data['subcat'] = trim($data['subcat'], ",");
            }
            $newData = $this->GetCategoryNameByid($data['subcat']);
            if (!empty($newData)) {
                foreach ($newData as $key => $value) {
                    $sel="";
                                if(!empty($page_id))
                                {
                                    $page=explode('|',$page_id);
                                    if($page[0]==$value["activity_id"] && $page[1]=='tblfavcategory')
                                    {
                                        $sel="selected";
                                    }
                                }
                    $option_str.= '<option value="' . $value["activity_id"] . '|tblfavcategory" '.$sel.'>' . $value["activity_name"] . ' </option>';
                }
            }
        }
        return $option_str;
    }
    public function GetCategoryNameByid($symtum_cat) {
        $DBH = new DatabaseHandler();
        $option_str = array();
        $sql = "SELECT * FROM `tblfavcategory` WHERE  fav_cat_id IN($symtum_cat) ORDER BY `fav_cat` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data = array();
                $data['activity_name'] = strip_tags($row['fav_cat']);
                $data['activity_id'] = $row['fav_cat_id'];
                $option_str[] = $data;
            }
        }
        return $option_str;
    }
    // add by  ample 27-12-19
    public function getDataFromFavCategory($cat_ids = "") {
        $DBH = new DatabaseHandler();
        $data = array();
        $cat_id = implode($cat_ids, '\',\'');
        $sql = "SELECT fav_cat FROM tblfavcategory WHERE fav_cat_id IN ('" . $cat_id . "')";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row['fav_cat'];
            }
        }
        return $data;
    }
    // add by ample 27-12-19
    public function get_data_from_tblcolumndetails($UID = "") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $details_arr = array();
        $sql1 = "SELECT * FROM `tblcolumndetails` WHERE `uniqu_m_id`='" . $UID . "'";
        $STH = $DBH->prepare($sql1);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row1 = $STH->fetch(PDO::FETCH_ASSOC)) {
                $details_arr[] = $row1;
            }
        }
        return $details_arr;
    }
    // write by ample 27-12-19
    public function FilterDataDropdown($data_dropdown = "") {
        $final_data = array();
        if (!empty($data_dropdown)) {
            for ($i = 0;$i < count($data_dropdown);$i++) {
                if ($data_dropdown[$i]['sub_cat1'] != '') {
                    $prof_cat_tbl1 = $data_dropdown[$i]['canv_sub_cat1_link'];
                    $prof_cat_col1 = $data_dropdown[$i]['prof_cat1_ref_code'];
                    $sub_cat1 = explode(',', $data_dropdown[$i]['sub_cat1']);
                    if ($data_dropdown[$i]['canv_sub_cat1_show_fetch'] == '2') {
                        $cat_data1 = $this->getDataFromReportCustomized($sub_cat1, $prof_cat_tbl1, $prof_cat_col1, $data_dropdown[$i]['prof_cat1_uid']);
                        $final_data = array_merge($final_data, $cat_data1);
                    } elseif ($data_dropdown[$i]['canv_sub_cat1_show_fetch'] == '1') {
                        $cat_data1 = $this->getDataFromFavCategory($sub_cat1);
                        $final_data = array_merge($final_data, $cat_data1);
                    }
                }
                if ($data_dropdown[$i]['sub_cat2'] != '') {
                    $prof_cat_tbl2 = $data_dropdown[$i]['canv_sub_cat2_link'];
                    $prof_cat_col2 = $data_dropdown[$i]['prof_cat2_ref_code'];
                    $sub_cat2 = explode(',', $data_dropdown[$i]['sub_cat2']);
                    if ($data_dropdown[$i]['canv_sub_cat2_show_fetch'] == '2') {
                        $cat_data2 = $this->getDataFromReportCustomized($sub_cat2, $prof_cat_tbl2, $prof_cat_col2, $data_dropdown[$i]['prof_cat2_uid']);
                        $final_data = array_merge($final_data, $cat_data2);
                    } elseif ($data_dropdown[$i]['canv_sub_cat2_show_fetch'] == '1') {
                        $cat_data2 = $this->getDataFromFavCategory($sub_cat2);
                        $final_data = array_merge($final_data, $cat_data2);
                    }
                }
                if ($data_dropdown[$i]['sub_cat3'] != '') {
                    $prof_cat_tbl3 = $data_dropdown[$i]['canv_sub_cat3_link'];
                    $prof_cat_col3 = $data_dropdown[$i]['prof_cat3_ref_code'];
                    $sub_cat3 = explode(',', $data_dropdown[$i]['sub_cat3']);
                    if ($data_dropdown[$i]['canv_sub_cat3_show_fetch'] == '2') {
                        $cat_data3 = $this->getDataFromReportCustomized($sub_cat3, $prof_cat_tbl3, $prof_cat_col3, $data_dropdown[$i]['prof_cat3_uid']);
                        $final_data = array_merge($final_data, $cat_data3);
                    } elseif ($data_dropdown[$i]['canv_sub_cat3_show_fetch'] == '1') {
                        $cat_data3 = $this->getDataFromFavCategory($sub_cat3);
                        $final_data = array_merge($final_data, $cat_data3);
                    }
                }
                if ($data_dropdown[$i]['sub_cat4'] != '') {
                    $prof_cat_tbl4 = $data_dropdown[$i]['canv_sub_cat4_link'];
                    $prof_cat_col4 = $data_dropdown[$i]['prof_cat4_ref_code'];
                    $sub_cat4 = explode(',', $data_dropdown[$i]['sub_cat4']);
                    if ($data_dropdown[$i]['canv_sub_cat4_show_fetch'] == '2') {
                        $cat_data4 = $this->getDataFromReportCustomized($sub_cat4, $prof_cat_tbl4, $prof_cat_col4, $data_dropdown[$i]['prof_cat4_uid']);
                        $final_data = array_merge($final_data, $cat_data4);
                    } elseif ($data_dropdown[$i]['canv_sub_cat4_show_fetch'] == '1') {
                        $cat_data4 = $this->getDataFromFavCategory($sub_cat4);
                        $final_data = array_merge($final_data, $cat_data4);
                    }
                }
                if ($data_dropdown[$i]['sub_cat5'] != '') {
                    $prof_cat_tbl5 = $data_dropdown[$i]['canv_sub_cat5_link'];
                    $prof_cat_col5 = $data_dropdown[$i]['prof_cat5_ref_code'];
                    $sub_cat5 = explode(',', $data_dropdown[$i]['sub_cat5']);
                    if ($data_dropdown[$i]['canv_sub_cat5_show_fetch'] == '2') {
                        $cat_data5 = $this->getDataFromReportCustomized($sub_cat5, $prof_cat_tbl5, $prof_cat_col5, $data_dropdown[$i]['prof_cat5_uid']);
                        $final_data = array_merge($final_data, $cat_data5);
                    } elseif ($data_dropdown[$i]['canv_sub_cat5_show_fetch'] == '1') {
                        $cat_data5 = $this->getDataFromFavCategory($sub_cat5);
                        $final_data = array_merge($final_data, $cat_data5);
                    }
                }
                if ($data_dropdown[$i]['sub_cat6'] != '') {
                    $prof_cat_tbl6 = $data_dropdown[$i]['canv_sub_cat6_link'];
                    $prof_cat_col6 = $data_dropdown[$i]['prof_cat6_ref_code'];
                    $sub_cat6 = explode(',', $data_dropdown[$i]['sub_cat6']);
                    if ($data_dropdown[$i]['canv_sub_cat5_show_fetch'] == '2') {
                        $cat_data6 = $this->getDataFromReportCustomized($sub_cat6, $prof_cat_tbl6, $prof_cat_col6, $data_dropdown[$i]['prof_cat6_uid']);
                        $final_data = array_merge($final_data, $cat_data6);
                    } elseif ($data_dropdown[$i]['canv_sub_cat5_show_fetch'] == '1') {
                        $cat_data6 = $this->getDataFromFavCategory($sub_cat6);
                        $final_data = array_merge($final_data, $cat_data6);
                    }
                }
                if ($data_dropdown[$i]['sub_cat7'] != '') {
                    $prof_cat_tbl7 = $data_dropdown[$i]['canv_sub_cat7_link'];
                    $prof_cat_col7 = $data_dropdown[$i]['prof_cat7_ref_code'];
                    $sub_cat7 = explode(',', $data_dropdown[$i]['sub_cat7']);
                    if ($data_dropdown[$i]['canv_sub_cat7_show_fetch'] == '2') {
                        $cat_data7 = $this->getDataFromReportCustomized($sub_cat7, $prof_cat_tbl7, $prof_cat_col7, $data_dropdown[$i]['prof_cat7_uid']);
                        $final_data = array_merge($final_data, $cat_data7);
                    } elseif ($data_dropdown[$i]['canv_sub_cat7_show_fetch'] == '1') {
                        $cat_data7 = $this->getDataFromFavCategory($sub_cat7);
                        $final_data = array_merge($final_data, $cat_data7);
                    }
                }
                if ($data_dropdown[$i]['sub_cat8'] != '') {
                    $prof_cat_tbl8 = $data_dropdown[$i]['canv_sub_cat8_link'];
                    $prof_cat_col8 = $data_dropdown[$i]['prof_cat8_ref_code'];
                    $sub_cat8 = explode(',', $data_dropdown[$i]['sub_cat8']);
                    if ($data_dropdown[$i]['canv_sub_cat8_show_fetch'] == '2') {
                        $cat_data8 = $this->getDataFromReportCustomized($sub_cat8, $prof_cat_tbl8, $prof_cat_col8, $data_dropdown[$i]['prof_cat8_uid']);
                        $final_data = array_merge($final_data, $cat_data8);
                    } elseif ($data_dropdown[$i]['canv_sub_cat8_show_fetch'] == '1') {
                        $cat_data8 = $this->getDataFromFavCategory($sub_cat8);
                        $final_data = array_merge($final_data, $cat_data8);
                    }
                }
                if ($data_dropdown[$i]['sub_cat9'] != '') {
                    $symtum_cat.= $data_dropdown[$i]['sub_cat9'] . ',';
                    $prof_cat_tbl9 = $data_dropdown[$i]['canv_sub_cat9_link'];
                    $prof_cat_col9 = $data_dropdown[$i]['prof_cat9_ref_code'];
                    $sub_cat9 = explode(',', $data_dropdown[$i]['sub_cat9']);
                    if ($data_dropdown[$i]['canv_sub_cat9_show_fetch'] == '2') {
                        $cat_data9 = $this->getDataFromReportCustomized($sub_cat9, $prof_cat_tbl9, $prof_cat_col9, $data_dropdown[$i]['prof_cat9_uid']);
                        $final_data = array_merge($final_data, $cat_data9);
                    } elseif ($data_dropdown[$i]['canv_sub_cat9_show_fetch'] == '1') {
                        $cat_data9 = $this->getDataFromFavCategory($sub_cat9);
                        $final_data = array_merge($final_data, $cat_data9);
                    }
                }
                if ($data_dropdown[$i]['sub_cat10'] != '') {
                    $prof_cat_tbl10 = $data_dropdown[$i]['canv_sub_cat10_link'];
                    $prof_cat_col10 = $data_dropdown[$i]['prof_cat10_ref_code'];
                    $sub_cat10 = explode(',', $data_dropdown[$i]['sub_cat10']);
                    if ($data_dropdown[$i]['canv_sub_cat10_show_fetch'] == '2') {
                        $cat_data10 = $this->getDataFromReportCustomized($sub_cat10, $prof_cat_tbl10, $prof_cat_col10, $data_dropdown[$i]['prof_cat10_uid']);
                        $final_data = array_merge($final_data, $cat_data10);
                    } elseif ($data_dropdown[$i]['canv_sub_cat10_show_fetch'] == '1') {
                        $cat_data10 = $this->getDataFromFavCategory($sub_cat10);
                        $final_data = array_merge($final_data, $cat_data10);
                    }
                }
            }
            sort($final_data);
            return $final_data;
        } else {
            return $final_data;
        }
    }
    //function added by ample 27-12-19
    public function getDataRecordsDropdownDetails($table_name = "") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $pdm_id = '';
        $page_id_str = '';
        $pd_status = '';
        $sql = "SELECT * FROM `tbl_recordshow_dropdown` WHERE `table_name` = '" . $table_name . "' AND `is_deleted` = '0' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $sql1 = "SELECT * FROM `tblcolumndetails` WHERE `uniqu_m_id`='" . $row['uniqu_id'] . "'";
            $STH = $DBH->prepare($sql1);
            $STH->execute();
            if ($STH->rowCount() > 0) {
                while ($row1 = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $details_arr[] = $row1;
                }
            }
        }
        return $details_arr;
    }
    //function added by ample 27-12-19
    public function get_custom_filter_check($report_data = "", $colum_name = "") {
        $report_list = array();
        if (!empty($report_data)) {
            //$filter_data=1;
            foreach ($report_data as $key => $value) {
                if ($value['col_name'] == $colum_name) {
                    //$report_list=$value;
                    $report_list['final_data_value'] = $value;
                    // if($value['col_query_field']=='No')
                    // {
                    //     $filter_data=0;
                    // }
                    
                } else {
                    // if($value['col_query_field']=='Yes')
                    // {
                    $report_list['filter_data_value'][] = $value;
                    //}
                    
                }
            }
            // if($filter_data==0)
            // {
            //     $report_list['filter_data_value']=array();
            // }
            
        }
        return $report_list;
    }
    //function added by ample 27-12-19
    public function get_custom_filter_data($filter_data = "", $cat_id = "", $prof_cat_tbl = "", $prof_cat_col = "") {
        $DBH = new DatabaseHandler();
        $data = array();
        if (!empty($filter_data)) {
            foreach ($filter_data as $key => $value) {
                $cat_id = implode($cat_id, '\',\'');
                //$sql = "SELECT DISTINCT ".$value['fetch_columns']." FROM ".$value['Id_table']." WHERE ".$value['fetch_value']." IN ('".$cat_id."')";
                $sql = "SELECT DISTINCT " . $prof_cat_col . " FROM " . $prof_cat_tbl . " WHERE " . $value['col_name'] . " IN ('" . $cat_id . "')";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                        //$data[] = $row[$value['fetch_columns']];
                        $data[] = $row[$prof_cat_col];
                    }
                }
            }
        }
        return $data;
    }
    //function added by ample 27-12-19
    public function get_custom_final_key_value($cat_data = "", $match_data = "") {
        $DBH = new DatabaseHandler();
        $data = array();
        if (!empty($cat_data)) {
            foreach ($cat_data as $key => $value) {
                $cat_id = implode($cat_id, '\',\'');
                $sql = "SELECT " . $match_data['fetch_columns'] . " FROM " . $match_data['Id_table'] . " WHERE " . $match_data['fetch_value'] . " = '" . $value . "'";
                //print_r($sql);
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                        $data[] = $row[$match_data['fetch_columns']];
                    }
                }
            }
        }
        return $data;
    }
    //function added by ample 13-11-19 again update this 27-12-19
    public function getDataFromReportCustomized($sub_cat = "", $prof_cat_tbl = "", $prof_cat_col = "", $UID = "") {
        $final_data = array();
        if ($sub_cat && $prof_cat_tbl && $prof_cat_col && $UID) {
            // echo "<pre>";
            //   print_r($sub_cat);
            // change function 22-11-19
            // $report_custom = $this->getDataRecordsDropdownDetails($prof_cat_tbl);
            $report_custom = $this->get_data_from_tblcolumndetails($UID);
            //   echo "report-custom--------";
            // print_r($report_custom);
            if (!empty($report_custom)) {
                $report_list = $this->get_custom_filter_check($report_custom, $prof_cat_col);
            }
            // echo "report_list----------";
            // print_r($report_list);
            if (!empty($report_list['filter_data_value'])) {
                $filter_arrray = $this->get_custom_filter_data($report_list['filter_data_value'], $sub_cat, $prof_cat_tbl, $prof_cat_col);
                //    echo "filter_array----------";
                // print_r($filter_arrray);
                if (!empty($filter_arrray) && $report_list['final_data_value']) {
                    $final_data = $this->get_custom_final_key_value($filter_arrray, $report_list['final_data_value']);
                }
            } else {
                if (!empty($report_list['final_data_value'])) {
                    $final_data = $this->get_custom_final_key_value($sub_cat, $report_list['final_data_value']);
                }
            }
            return $final_data;
        } else {
            return $final_data;
        }
    }
    //add by ample 05-03-20
    public function setUserQueryRead($aq_id, $vendor_id, $pro_user_read) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "UPDATE `tbladviserqueries` SET `pro_user_read` = '" . $pro_user_read . "' WHERE `aq_id` = '" . $aq_id . "' AND `vendor_id` = '" . $vendor_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    // add by ample 25-03-20
    public function selectReportName($vendor_id = "",$user_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $page_name = '';
        //$sql ="SELECT `report_id`FROM `tbladviserreferrals` WHERE  `user_id` = '".$_SESSION['user_id']."'";
        //update sql by ample 30-10-19
        $sql = "SELECT `report_id`FROM `tbladviserreferrals` WHERE  `user_id` = '" . $user_id . "' AND `vendor_id` = '" . $vendor_id . "'";
        //echo $sql;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $report_id = stripslashes($row['report_id']);
                // $report_id = stripslashes($row['page_cat_id']);
                // $arr_va[]=array($report_name,$report_id);
                
            }
        }
        return $report_id;
    }
    //copy by ample
    public function getPageTitle($page_id) {
        $DBH = new DatabaseHandler();
        $page_title = '';
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '" . $page_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            // echo "<pre>";print_r($row);echo "</pre>";
            $page_title = stripslashes($row['page_title']);
        }
        return $page_title;
    }
    //add by ample 17-04-20
    public function getFeeadBackPage($page_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';
        $sql2 = "SELECT * FROM `tblpages` WHERE `page_id` = " .$page_id;
        $STH2 = $DBH->prepare($sql2);
        $STH2->execute();
        if ($STH2->rowCount() > 0) {
           $row = $STH2->fetch(PDO::FETCH_ASSOC);
           $option_str.= '<option value="0">General</option>';
           $option_str.= '<option value="' . $row['page_id'] . '" selected>' . stripslashes($row['page_name']) . '</option>';
           }
           else
           {
                $option_str.= '<option value="0" selected>General</option>';
           }
        return $option_str;
    }
    //add by ample 17-04-20
    function InsertFeedback($parent_id, $page_id, $name, $email, $feedback, $user_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "INSERT INTO `tblfeedback` (`parent_feedback_id`,`page_id`,`user_id`,`name`,`email`,`feedback`,`admin`,`status`,`is_vendor`) VALUES ('" . addslashes($parent_id) . "','" . addslashes($page_id) . "','" . addslashes($user_id) . "','" . addslashes($name) . "','" . addslashes($email) . "','" . addslashes($feedback) . "','0','1','1')";
        $result = $DBH->query($sql);
        if ($result) {
            $return = true;
        }
        return $return;
    }
     //add by ample 17-04-20
    public function GetFeedBackData() {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();

        $user_id=$_SESSION['adm_vendor_id'];

        $sql = "SELECT * FROM `tblfeedback` WHERE user_id=".$user_id." AND `parent_feedback_id` = '0' AND `admin` = '0' AND is_vendor='1' AND status='1' ORDER BY feedback_add_date DESC";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]= $row;
            }
        }
        return $data;
    }

     //add by ample 17-04-20
    public function GetFeedBackDataByID($feedback_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $user_id=$_SESSION['adm_vendor_id'];
        $sql = "SELECT * FROM `tblfeedback` WHERE user_id=".$user_id." AND feedback_id=".$feedback_id." AND `parent_feedback_id` = '0' AND `admin` = '0' AND is_vendor='1'";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
                $data= $row;
        }
        return $data;
    }
    //add by ample 17-04-20
    public function GetAllConvarsationByID($feedback_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT * FROM `tblfeedback` WHERE `parent_feedback_id` = ".$feedback_id." AND status='1'
                    ORDER BY feedback_add_date DESC";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]= $row;
            }
        }
        return $data;
    }
    //add by ample 17-04-20
    public function get_feedback_data($feedback_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT * FROM `tblfeedback` WHERE feedback_id=".$feedback_id;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
                $data= $row;
        }
        return $data;
    }
    //add ample 17-04-20
    public function feedback_update($feedback_id, $feedback) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "UPDATE `tblfeedback` SET `feedback` = '".$feedback."' WHERE `feedback_id` = '".$feedback_id."'";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //add by ample 22-04-20
    public function getPageIcon($page_id="") {
        $DBH = new DatabaseHandler();
        $page_icon = '';
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '" . $page_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            if($row['page_icon']!='') { 

                    if($row['page_icon_type']=='Image')
                    {   

                        $imgData=$this->getImgData($row['page_icon']);
                        if(!empty($imgData['image']))
                        {
                            $page_icon='<img src="'.MAIN_URL.'/uploads/'.$imgData['image'].'" style="width:75px; height: 75px;"/><br>';
                        }
                    }
                    else
                    {   
                        $fileData=$this->getFileData($row['page_icon']);
                        $page_icon='<a href="'.MAIN_URL.'/uploads/'. $fileData['box_banner'].'" target="_blank">'.$fileData['box_banner'].'</a><br>';
                    }
            
              }

        }
        return $page_icon;
    }
    //copy by ample 22-04-20
    public function getImgData($icons_id="")
    {

        $DBH = new DatabaseHandler();
        $data = array();

            $sql = "SELECT * FROM  tbl_icons WHERE  icons_id=".$icons_id;
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;
                }
            }

        return $data;
    }
    //copy by ample 22-04-20
    public function getFileData($box_id="")
    {

        $DBH = new DatabaseHandler();
        $data = array();

            $sql = "SELECT * FROM  tblmindjumble WHERE  mind_jumble_box_id=".$box_id;
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;
                }
            }

        return $data;
    }
    //get fevcategory icon add by ample 23-04-20
    public function get_icon_of_favcategory($favcat_id="")
    {
        $icon='';
        $data=$this->getFavCategoryData($favcat_id);
        if(!empty($data))
        {
            if($data['page_icon']!='') { 

                    if($data['page_icon_type']=='Image')
                    {   

                        $imgData=$this->getImgData($data['page_icon']);
                        if(!empty($imgData['image']))
                        {
                            $icon=$imgData['image'];
                        }
                    }
                    // else
                    // {   
                    //     $fileData=$this->getFileData($data['page_icon']);
                    //     $page_icon='<a href="'.SITE_URL.'/uploads/'. $fileData['box_banner'].'" target="_blank">'.$fileData['box_banner'].'</a><br>';
                    // }
            
              }
        }
        return $icon;
    }
    //get fevcategory url add by ample 23-04-20
    public function get_url_of_favcategory($favcat_id="",$redirect_page="",$redirect_id="",$redirect="",$title="",$url_type="")
    {   
        $url='';
        $data=$this->getFavCategoryData($favcat_id);
        if(!empty($data))
        {   
            if($url_type=='VIEW')
            {   
                $url=$data['data_view_url'].'?';
                $url=$url.'&redirect_page='.$redirect_page.'&redirect_id='.$redirect_id.'&redirect='.$redirect;
            }
            else
            {   
                if(!empty($data['link']))
                {
                    $url=$data['link'].'?';
                    if(!empty($data['ref_num']))
                    {
                        $url=$url.'&ref_num='.$data['ref_num'];
                    }
                    if(!empty($data['group_code_id']))
                    {
                        $url=$url.'&group_id='.$data['group_code_id'];
                    }
                    if(!empty($data['ref_num']) || !empty($data['group_code_id']))
                    {
                        $url=$url.'&fav_cat_id='.$data['fav_cat_id'];
                        if($title)
                        {
                            $title=base64_encode($title);
                            $url=$url.'&title='.$title;
                        }
                    }
                    if($data['link']=='design-my-life.php')
                    {
                        $url=$url.'&redirect_page='.$redirect_page.'&redirect_id='.$redirect_id.'&redirect='.$redirect;
                    }

                }
            }
            
        }
        return $url;
    }
    //add by ample 24-04-20
    public function get_redirection_data($redirect="",$redirect_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = false;
        $vendor_id=$_SESSION['adm_vendor_id'];
        $sql = "SELECT * FROM `tbl_user_design_your_data` WHERE redirect='".$redirect."' AND redirect_id=".$redirect_id." AND vendor_id=".$vendor_id;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
                //$data= $row;
            $data= true;
        }
        return $data;
    }
    //copy by ample 24-04-20
    public function getFavCategoryData($fav_cat_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '" . $fav_cat_id . "' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;
    }
    //add by ample 24-04-20
    public function get_redirection_data_user($redirect="",$redirect_id="",$user_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = false;
        $sql = "SELECT * FROM `tbl_user_design_your_data` WHERE redirect='".$redirect."' AND user_id=".$user_id." AND redirect_id=".$redirect_id;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
                //$data= $row;
            $data= true;
        }
        return $data;
    }
      //add by ample 17-04-2
    public function get_DLY_for_appointment($group_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT * FROM `tbl_design_your_life` WHERE group_code_id=".$group_id." AND `is_deleted` = '0' AND status='1' ORDER BY id DESC";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]= $row;
            }
        }
        return $data;
    }
    //add by ample 27-05-20     
    function get_specifiq_data_DYL($data_id="")
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
            $data=array();
            // $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $return=false;

            $sql="SELECT * FROM `tbl_specifiq_text_dyl` WHERE `data_id`=".$data_id." ORDER BY text_order ASC";

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }

        return $data;  
    }
    //create new function for save vendor_contacts
    public function save_vendor_contacts($vendor_id,$vloc_id,$data)
    {

            $my_DBH = new DatabaseHandler();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tblvendorcontacts` (`vendor_id`,`vloc_id`,`contact_person`,`contact_person_title`,`contact_email`,`contact_number`,`contact_designation`,`contact_remark`,`speciality_offered`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$vendor_id.",".$vloc_id.",'".$value['contact_person']."','".$value['contact_person_title']."','".$value['contact_email']."','".$value['contact_number']."','".$value['contact_designation']."','".$value['contact_remark']."','".$value['speciality_offered']."'),";
                }
                //$values = rtrim($values, ',');
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
                //echo $insert_query;
            // $STH = $DBH->prepare($sql);
            //  $STH->execute();
             $STH = $DBH->query($insert_query);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 24-06-20  
    function get_vendor_contacts($vendor_id,$vloc_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
            $data=array();
            $return=false;

            $sql="SELECT * FROM `tblvendorcontacts` WHERE `vendor_id`=".$vendor_id." AND `vloc_id`=".$vloc_id." ORDER BY contact_id DESC";

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }

        return $data;  
    }
    //add by ample 25-06-20  
    function get_vendor_contact_info($contact_id,$vendor_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
            $data=array();
            $return=false;

            $sql="SELECT * FROM `tblvendorcontacts` WHERE `contact_id`=".$contact_id. " AND `vendor_id` = ".$vendor_id;

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $row['certificate'] = array();
                $sql2 = "SELECT * FROM `tblvendorcertifications` WHERE `vendor_id` = '".$vendor_id."' AND `vcon_id` = '".$contact_id."' AND `vc_cert_deleted` = '0' ORDER BY vc_cert_add_date ASC ";
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    while ($r2 = $STH2->fetch(PDO::FETCH_ASSOC)) {
                        $row['certificate'][] = $r2;
                    }
                }
                $data= $row;

            }

        return $data;  
    }
     //added by ample 25-06-20
    public function update_vendor_contacts($id,$data)
    {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tblvendorcontacts` SET 
            `update_on`='".date('Y-m-d H:i:s')."',`contact_person_title`='".$data['contact_person_title']."',`contact_person`='".$data['contact_person']."',`contact_email`='".$data['contact_email']."',`contact_number`='".$data['contact_number']."',`contact_designation`='".$data['contact_designation']."',`contact_remark`='".$data['contact_remark']."',`speciality_offered`='".$data['speciality_offered']."' WHERE `contact_id`='".$id."'";
        $STH = $DBH->query($sql);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //added ample 26-06-20
    function add_vendor_staff_certificate($vendor_id,$data,$vcon_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

            $query = "INSERT INTO `tblvendorcertifications` (`vendor_id`,`vloc_id`,`vcon_id`,`vc_cert_type_id`,`vc_cert_name`,`vc_cert_no`,`vc_cert_reg_date`,`vc_cert_validity_date`,`vc_cert_issued_by`,`vc_cert_scan_file`,`vc_cert_status`) VALUES ";
            $values = '';
            foreach ($data as $key => $value) {
                 $values .= "(".$vendor_id.",'0',".$vcon_id.",'".$value['vc_cert_type_id']."','".$value['vc_cert_name']."','".$value['vc_cert_no']."','".$value['vc_cert_reg_date']."','".$value['vc_cert_validity_date']."','".$value['vc_cert_issued_by']."','".$value['vc_cert_scan_file']."','1'),";
            }
            //$values = rtrim($values, ',');
            $values = substr($values, 0, strlen($values) - 1);
            $insert_query = $query . $values;
            //echo $insert_query;
        // $STH = $DBH->prepare($sql);
        //  $STH->execute();
         $STH = $DBH->query($insert_query);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //added by ample 25-06-20
    public function edit_vendor_staff_certificate($data)
    {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        foreach ($data as $key => $value) {
            $sql="UPDATE `tblvendorcertifications` SET 
            `vc_cert_modified_date`='".date('Y-m-d H:i:s')."',`vc_cert_type_id`='".$value['vc_cert_type_id']."',`vc_cert_name`='".$value['vc_cert_name']."',`vc_cert_no`='".$value['vc_cert_no']."',`vc_cert_reg_date`='".$value['vc_cert_reg_date']."',`vc_cert_validity_date`='".$value['vc_cert_validity_date']."',`vc_cert_issued_by`='".$value['vc_cert_issued_by']."',`vc_cert_scan_file`='".$value['vc_cert_scan_file']."' WHERE `vc_cert_id`='".$value['vc_cert_id']."'";
            $STH = $DBH->query($sql);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        }
        
        return $return;
    }
     //add by ample 25-06-20  
    function get_vendor_contact_detail($contact_id,$vendor_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
            $data=array();
            $return=false;

            $sql="SELECT * FROM `tblvendorcontacts` WHERE `contact_id`=".$contact_id. " AND `vendor_id` = ".$vendor_id;

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $data= $row;

            }

        return $data;  
    }
    //create new function for save vendor_contacts
    public function save_time_slots($data)
    {

            $my_DBH = new DatabaseHandler();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

            $insert_query = "INSERT INTO `vendor_session_time` (`vendor_id`,`contact_id`,`week`,`start_time`,`end_time`) VALUES ('".$data['vendor_id']."','".$data['contact_id']."','".$data['week']."','".$data['start_time']."','".$data['end_time']."')";

             $STH = $DBH->query($insert_query);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
      //add by ample 25-06-20  
    function get_vendor_time_slots($contact_id,$vendor_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
            $data=array();
            $return=false;

            $sql="SELECT * FROM `vendor_session_time` WHERE `contact_id`=".$contact_id. " AND `vendor_id` = ".$vendor_id." ORDER BY start_time ASC";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                        $data[]= $row;
                    }

            }

        return $data;  
    }
    //create new function for save vendor_contacts 07-07-20
    public function save_vendor_holidays($data)
    {

            $my_DBH = new DatabaseHandler();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

            $insert_query = "INSERT INTO `vendor_holidays` (`vendor_id`,`contact_id`,`start_date`,`end_date`) VALUES ('".$data['vendor_id']."','".$data['contact_id']."','".$data['start_date']."','".$data['end_date']."')";

             $STH = $DBH->query($insert_query);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 08-07-20  
    function get_vendor_holidays($contact_id,$vendor_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
            $data=array();
            $return=false;

            $sql="SELECT * FROM `vendor_holidays` WHERE `contact_id`=".$contact_id. " AND `vendor_id` = ".$vendor_id;
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                        $data[]= $row;
                    }

            }
        return $data;  
    }
    //added ample 08-07-20
    function save_week_setting_data($vendor_id,$contact_id,$data)
    {   
        $this->delete_week_setting_data($vendor_id,$contact_id);

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

            $query = "INSERT INTO `vendor_week_setting` (`vendor_id`,`contact_id`,`week`,`status`) VALUES ";
            $values = '';
            foreach ($data as $key => $value) {
                 $values .= "('".$vendor_id."','".$contact_id."','".$value['week']."','".$value['status']."'),";
            }
            //$values = rtrim($values, ',');
            $values = substr($values, 0, strlen($values) - 1);
            $insert_query = $query . $values;
         $STH = $DBH->query($insert_query);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //add by ample 08-07-20
    public function delete_week_setting_data($vendor_id,$contact_id)
    {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `vendor_week_setting` WHERE `vendor_id` = ".$vendor_id." AND `contact_id` = ".$contact_id.""; 
        // $STH = $DBH->prepare($sql); 
        // $STH->execute();
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 08-07-20  
    function get_vendor_week_setting($contact_id,$vendor_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
            $data=array();
            $return=false;

            $sql="SELECT * FROM `vendor_week_setting` WHERE `contact_id`=".$contact_id. " AND `vendor_id` = ".$vendor_id." ORDER BY ID ASC LIMIT 7";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                        $data[]= $row;
                    }

            }
        return $data;  
    }
    //add by ample 08-07-20
    function holiday_data_delete($id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `vendor_holidays` WHERE `id` = ".$id; 
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 09-07-20
    function slot_data_delete($id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `vendor_session_time` WHERE `id` = ".$id; 
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
     //add by ample 13-07-20
    public function get_SMS_credential($SMS_ID) {
        $DBH = new DatabaseHandler();
        $data = array();
        $sql = "SELECT * FROM `tbl_sms_credentials` WHERE `SMS_ID` = '" . $SMS_ID . "' AND `STATUS` = '1' AND `DELETED` = '0' ORDER BY `SMS_ID` DESC LIMIT 1 ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $r;
        }
        return $data;
    }
    //add by ample 17-07-20
    public function GetAppointmentData($start_date="",$end_date="",$search_keywords="",$user_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        if ($user_id != '') {
            $str_sql_user_id = " AND `user_id` = '" . $user_id . "' ";
        } else {
            $str_sql_user_id = '';
        }
        if ($search_keywords != '') {
            $str_sql_search_keywords = " AND ( `contact_name` LIKE '%" . $search_keywords . "%' OR `contact_address` LIKE '%" . $search_keywords . "%' )";
        } else {
            $str_sql_search_keywords = '';
        }
        if ($start_date != '') {
            $str_sql_start_date = " AND DATE(appointment_date) >= '" . date('Y-m-d', strtotime($start_date)) . "' ";
        } else {
            $str_sql_start_date = '';
        }
        if ($end_date != '') {
            $str_sql_end_date = " AND DATE(appointment_date) <= '" . date('Y-m-d', strtotime($end_date)) . "' ";
        } else {
            $str_sql_end_date = '';
        }
        $vendor_id=$_SESSION['adm_vendor_id'];
        $sql = "SELECT * FROM `tbl_appointment_data` WHERE vendor_id=".$vendor_id." " . $str_sql_vendor_id . " " . $str_sql_search_keywords . " " . $str_sql_start_date . " " . $str_sql_end_date . " ORDER BY id DESC";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]= $row;
            }
        }
        return $data;
    }
    //add by ample 18-07-20
    public function appointment_status_update($data) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "UPDATE `tbl_appointment_data` SET `request_status` = '" . $data['request_status'] . "',`remark` = '" . $data['remark'] . "',`status_update_date`='".date('Y-m-d H:i:s')."' WHERE `id` = '" . $data['id'] . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;

    }
    //add by ample 18-07-20
    public function appointment_reschedule_update($data) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "UPDATE `tbl_appointment_data` SET `request_status` = '" . $data['request_status'] . "',`remark` = '" . $data['remark'] . "',`reschedule_date` = '" . $data['reschedule_date'] . "',`reschedule_time` = '" . $data['reschedule_time'] . "',`reschedule_location` = '" . $data['reschedule_location'] . "',`status_update_date`='".date('Y-m-d H:i:s')."' WHERE `id` = '" . $data['id'] . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;

    }
    //add by ample 21-07-20
    public function get_appointment_detail($appt_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $vendor_id=$_SESSION['adm_vendor_id'];
        $data = false;
        $sql = "SELECT * FROM `tbl_appointment_data` WHERE vendor_id=".$vendor_id." AND id=".$appt_id;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
                $data= $row;
        }
        if(!empty($data))
        {
            $data['special']=$this->get_appointment_other_detail($appt_id);
        }
        return $data;
    }
    //add by ample 21-07-20
    public function get_appointment_other_detail($appt_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT * FROM `tbl_appointment_other_data` WHERE appointment_id=".$appt_id;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]= $row;
            }
        }
        return $data;
    }
    //copy by ample 21-07-20
    public function getmonthname($no_month) {
        $option_str = '';
        $arr_record = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        return $arr_record[$no_month];
    }
    public function getWeekName($no_week) {
        $option_str = '';
        $arr_day_of_week = array(1 => 'Sunday', 2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday', 5 => 'Thursday', 6 => 'Friday', 7 => 'Saturday');
        return $arr_day_of_week[$no_week];
    }
    public function getFavCategoryNameMultiple($fav_cat_id) {

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $fav_cat_data = array();
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN (" . $fav_cat_id . ") ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
             while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {
                    $fav_cat_data[] = stripslashes($row['fav_cat']);
                }
        }
        return implode(',', $fav_cat_data);
    }
    public function getFavCategoryName($fav_cat_id) {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $fav_cat_type = '';
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '" . $fav_cat_id . "' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $fav_cat_type = stripslashes($row['fav_cat']);
        }
        return $fav_cat_type;
    }
    public function get_users_appointments($appt_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $vendor_id=$_SESSION['adm_vendor_id'];
        $sql = "SELECT DISTINCT `user_id` FROM `tbl_appointment_data` WHERE vendor_id=".$vendor_id;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]= $row['user_id'];
            }
        }
        return $data;
    }
    //add by ample 27-07-20
    public function contact_status_update($contact_id, $status) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "UPDATE `tblvendorcontacts` SET `status` = ".$status." WHERE `contact_id` = ".$contact_id."";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //add by ample 05-09-20
    public function GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($page_cat_id, $page_name, $level) {
        $DBH = new DatabaseHandler();
        $data = array();
        $arr_data= array();
         $sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = " . $page_name . " and `healcareandwellbeing` = " . $page_cat_id . " and `level`=".$level." and `is_deleted` = 0 and `pag_cat_status`=1 order by page_cat_id DESC limit 1"; 
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_data[]= $row;

                if(!empty($arr_data))
                {   
                    $data['tag_heading']=$arr_data[0]['level_heading'];
                    $data['tag_data']=$this->FilterDataDropdown($arr_data);
                }
            
        }
        else
        {
            $sql2 = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = " . $page_name . " and `healcareandwellbeing` = 423 and `level`=".$level."  and `is_deleted` = 0 and `pag_cat_status`=1 order by page_cat_id DESC limit 1";
            $STH = $DBH->query($sql2);
            if ($STH->rowCount() > 0) {
            
                $row2 = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_data[]= $row2;
            
            }

            if(!empty($arr_data))
                {   
                    $data['tag_heading']=$arr_data[0]['level_heading'];
                    $data['tag_data']=$this->FilterDataDropdown($arr_data);
                }
        }
        
        return $data;
    }
     //add by ample 10-09-20
    public function GETDATADROPDOWNMYDAYTODAYOPTION_ForEventTags($page_cat_id, $page_name) {
        $DBH = new DatabaseHandler();
        $data = array();
        $arr_data= array();
        $sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = " . $page_name . " and `healcareandwellbeing` = " . $page_cat_id . " and `is_deleted` = 0 and `pag_cat_status`=1 order by page_cat_id DESC limit 1"; 
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_data[]= $row;

                if(!empty($arr_data))
                {   
                    $data['tag_heading']=$arr_data[0]['heading'];
                    $data['tag_data']=$this->FilterDataDropdown($arr_data);
                }
            
        }
        else
        {
            $sql2 = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = " . $page_name . " and `healcareandwellbeing` = 423 and `is_deleted` = 0 and `pag_cat_status`=1 order by page_cat_id DESC limit 1";
            $STH = $DBH->query($sql2);
            if ($STH->rowCount() > 0) {
            
                $row2 = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_data[]= $row2;
            
            }

            if(!empty($arr_data))
                {   
                    $data['tag_heading']=$arr_data[0]['heading'];
                    $data['tag_data']=$this->FilterDataDropdown($arr_data);
                }
        }
        
        return $data;
    }
    //copy code ample 09-09-20
    public function getbanners($page_id, $side) {
        $DBH = new DatabaseHandler();
        $arr_banner_id = array();
        $arr_page_id = array();
        $arr_page = array();
        $arr_position_id = array();
        $arr_banner = array();
        $arr_url = array();
        $arr_banner_type = array();
        $arr_position = array();
        $arr_side = array();
        $arr_width = array();
        $arr_height = array();
        $arr_sequence_banner_id = array();
        $sql = "SELECT * FROM `tblposition` WHERE `side` = '" . ($side) . "' ORDER BY `position` ";
        // echo $sql; die();
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $position_id = $row['position_id'];
                $max_banner_id = $this->get_max_banner_id($position_id, $page_id);
                $min_banner_id = $this->get_min_banner_id($position_id, $page_id);
                if (($_SESSION['ref_banner_id_' . $position_id . '_' . $page_id] == '') || ($_SESSION['ref_banner_id_' . $position_id . '_' . $page_id] == $max_banner_id)) {
                    $sql2 = "SELECT * FROM `tblbanners` AS TA



                          LEFT JOIN `tblposition` AS TS ON TA.position_id = TS.position_id



                          WHERE TA.position_id = '" . $position_id . "' AND TA.page_id = '" . $page_id . "' AND TA.status = '1' ORDER BY  `banner_id` LIMIT 1";
                } else {
                    $sql2 = "SELECT * FROM `tblbanners` AS TA



                          LEFT JOIN `tblposition` AS TS ON TA.position_id = TS.position_id



                          WHERE TA.position_id = '" . $position_id . "' AND TA.page_id = '" . $page_id . "' AND TA.status = '1'  AND TA.banner_id > '" . $_SESSION['ref_banner_id_' . $position_id . '_' . $page_id] . "' ORDER BY TA.banner_id LIMIT 1";
                }
                $STH2 = $DBH->query($sql2);
                if ($STH2->rowCount() > 0) {
                    while ($row2 = $STH2->fetch(PDO::FETCH_ASSOC)) {
                        $_SESSION['ref_banner_id_' . $position_id . '_' . $page_id] = $row2['banner_id'];
                        array_push($arr_banner_id, $row2['banner_id']);
                        array_push($arr_page_id, stripslashes($row2['page_id']));
                        array_push($arr_page, stripslashes($row2['page']));
                        array_push($arr_position_id, $row2['position_id']);
                        array_push($arr_banner, stripslashes($row2['banner']));
                        array_push($arr_url, stripslashes($row2['url']));
                        array_push($arr_banner_type, stripslashes($row2['banner_type']));
                        array_push($arr_position, $row2['position']);
                        array_push($arr_side, stripslashes($row2['side']));
                        array_push($arr_width, stripslashes($row2['width']));
                        array_push($arr_height, $row2['height']);
                    }
                }
            }
        }
        return array($arr_banner_id, $arr_page_id, $arr_page, $arr_position_id, $arr_banner, $arr_url, $arr_banner_type, $arr_position, $arr_side, $arr_width, $arr_height);
    }
    //copy by ample 09-09-20
    public function get_max_banner_id($position_id, $page_id) {
        $DBH = new DatabaseHandler();
        $max_banner_id = '';
        $sql = "SELECT * FROM `tblbanners` WHERE  `position_id` = '" . $position_id . "' AND `page_id` = '" . $page_id . "' AND status = '1' ORDER BY banner_id DESC limit 1";
        //echo $sql.'</br>';
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $max_banner_id = $row['banner_id'];
        }
        return $max_banner_id;
    }
    //copy by ample 09-09-20
    public function get_min_banner_id($position_id, $page_id) {
        $DBH = new DatabaseHandler();
        $min_banner_id = '';
        $sql = "SELECT * FROM `tblbanners` WHERE  `position_id` = '" . $position_id . "' AND `page_id` = '" . $page_id . "' AND status = '1' ORDER BY banner_id ASC limit 1";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $min_banner_id = $row['banner_id'];
        }
        return $min_banner_id;
    }
    //update 09-10-20
    public function event_update_in_event_loc_price($old_event_id,$new_event_id)
    {
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tbl_event_loc_price` SET `event_id`=".$new_event_id." WHERE `event_id`=".$old_event_id."";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function event_update_in_event_price($old_event_id,$new_event_id)
    {
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tbl_event_price` SET `event_id`=".$new_event_id." WHERE `event_id`=".$old_event_id."";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            return true;
        }
        else
        {
            return false;
        }
    }
    //copy by ample 18-09-20
    public function eventLocationStatusUpdate($id,$status)
    {
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tbl_event_details` SET `event_status`=".$status." WHERE `event_id`=".$id."";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function eventMasterStatusUpdate($id,$status)
    {
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tbl_event_master` SET `status`=".$status." WHERE `event_master_id`=".$id."";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            return true;
        }
        else
        {
            return false;
        }
    }
    //copy by ample 18-09-20
    public function eventPriceStatusUpdate($id,$status)
    {
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tbl_event_price` SET `event_price_status`=".$status." WHERE `event_price_id`=".$id."";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function eventPriceInfoStatusUpdate($id,$status)
    {
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tbl_event_loc_price` SET `culoc_status`=".$status." WHERE `evlocprice_id`=".$id."";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            return true;
        }
        else
        {
            return false;
        }
    }
    //add by ample 18-09-20
    public function vendorLocationStatusUpdate($id,$status)
    {
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblvendorlocations` SET `vloc_status`=".$status." WHERE `vloc_id`=".$id."";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            return true;
        }
        else
        {
            return false;
        }
    }
    //added by ample 27-11-20
    public function chkValidReferenceID($unique_id) {
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "SELECT * FROM `tblusers` WHERE `unique_id` = '" . $unique_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //add by ample 30-11-20
    public function get_referal_id($email_id="") {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $uniqid = '';
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE `user_email` = '" . $email_id . "' AND invite_by_user=1";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $uniqid = $this->getUserUniqueId($row['user_id']);
            }
        }
        return $uniqid;
    }
    public function getUserUniqueId($user_id) {
        $DBH = new DatabaseHandler();
        $unique_id = '';
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '" . $user_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $unique_id = stripslashes($row['unique_id']);
        }
        return $unique_id;
    }
    //add by ample 30-11-20
    public function update_advice_referal_status($email, $reference_id) {
        $user_id=$this->get_userID_by_referenceID($reference_id);
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "UPDATE `tbladviserreferrals` set `referral_accept_date`=NOW(),`referral_status` = '1',`request_accept_date`=NOW(),`request_status` = '1',`last_status_updated_by_adviser`='1' WHERE  `user_id` = '" . $user_id . "' AND `user_email` = '" . $email . "' AND invite_by_user=1";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function get_userID_by_referenceID($unique_id) {
        $DBH = new DatabaseHandler();
        $data = array();
        $sql = "SELECT * FROM `tblusers` WHERE `unique_id` = '" . $unique_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $data= $r['user_id'];
        }
        return $data;
    }
    public function get_user_name_by_referenceID($unique_id) {
        $DBH = new DatabaseHandler();
        $text = '';
        $sql = "SELECT * FROM `tblusers` WHERE `unique_id` = '" . $unique_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $text= $r['name'].' '.$r['last_name'];
        }
        return $text;
    }
}
?>