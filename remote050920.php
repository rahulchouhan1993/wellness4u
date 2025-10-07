<?php
include ('classes/config.php');
$action = stripslashes($_REQUEST['action']);
$obj = new frontclass();
$obj2 = new Profclass();
if ($action == 'resendotp') {
    $response = array();
    $email = $_REQUEST['email'] != '' ? $_REQUEST['email'] : '';
    $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string_shuffled = str_shuffle($string);
    $otp = substr($string_shuffled, 1, 6);
    $data = array();
    $data['email'] = $email;
    $data['otp'] = $otp;
    $otp_flag = $obj2->reSendProfOTP($data);
    if ($otp_flag) {
        $tdata_sms_otp = array();
        $tdata_sms_otp['email'] = $email;
        $tdata_sms_otp['sms_message'] = 'OTP for activating profile is: ' . $otp;
        $obj2->sendProfSMS($tdata_sms_otp);
        $response['msg'] = $obj->print_message(22); //'OTP send successfully on registered mobile please activate your profile using OTP ';
        $response['status'] = 1;
    }
    echo json_encode(array($response));
    exit(0);
} elseif ($action == 'VerifyOTP') {
    $obj2 = new Profclass();
    $obj = new frontclass();
    $data = array();
    $data['email'] = $_REQUEST['email'];
    $data['otp'] = $_REQUEST['otp'];
    $otp_flag = $obj2->VerifyOTP($data);
    if ($otp_flag) {
        $pro_user_id = $obj->getProUserId($data['email']);
        $email = $obj->getProUserEmailById($pro_user_id);
        $name = $obj->getProUserFullNameById($pro_user_id);
        $unique_id = $obj->getProUserUniqueId($pro_user_id);
        //list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('4');
        $mail_data = $obj->getEmailAutoresponderDetails('4');
        // echo "<pre>";print_r($mail_data);echo "</pre>";
        $to_email = $data['email'];
        $from_email = $mail_data['email_ar_from_email'];
        $from_name = $mail_data['email_ar_from_name'];
        $subject = $mail_data['email_ar_subject'];
        $message = $mail_data['email_ar_body'];
        $message = str_ireplace("[[ADVISER_NAME]]", $name, $message);
        $message = str_ireplace("[[ADVISER_EMAIL]]", $email, $message);
        $message = str_ireplace("[[ADVISER_UNIQUE_ID]]", $unique_id, $message);
        // echo "<pre>";print_r($message);echo "</pre>";
        // exit;
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
        // <p><strong>Hi [[ADVISER_NAME]],</strong></p>
        // <p>Congrats on becoming an wellness way 4U user. We\'re glad you\'ve decided to join all of us.</p>
        // <p>Your Username is <strong>[[ADVISER_EMAIL]]</strong></p>
        // <p>Your Unique Id is <strong>[[ADVISER_UNIQUE_ID]]</strong></p>
        // <p>Best Regards</p>
        // <p>www.wellnessway4u.com</p>
        $response['msg'] = $obj->print_message(21); //'Your account activated successfully click link and start login in your profile <a href="wa_register.php" style="color:blue;">Login</a>';
        $response['status'] = 1;
    } else {
        //echo 'Hiiiii';
        $response['status'] = 0;
        $response['msg'] = $obj->print_message(23);
    }
    echo json_encode(array($response));
    exit(0);
} elseif ($action == 'resenduserotp') {
    $obj = new frontclass();
    $response = array();
    $email = $_REQUEST['email'] != '' ? $_REQUEST['email'] : '';
    $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string_shuffled = str_shuffle($string);
    $otp = substr($string_shuffled, 1, 6);
    $data = array();
    $data['email'] = $email;
    $data['otp'] = $otp;
    $otp_flag = $obj->reSendUserOTP($data);
    if ($otp_flag) {
        $user_data = $obj->getUserDetails($email);
        $tdata_sms_otp = array();
        $tdata_sms_otp['mobile_no'] = $user_data['mobile'];
        $tdata_sms_otp['sms_message'] = 'OTP for activating profile is: ' . $otp;
        $obj->sendSMS($tdata_sms_otp);
        $response['msg'] = $obj->print_message(22); //'OTP send successfully on registered mobile please activate your profile using OTP ';
        $response['status'] = 1;
    }
    echo json_encode(array($response));
    exit(0);
} elseif ($action == 'VerifyUserOTP') {
    $obj = new frontclass();
    $data = array();
    $data['email'] = $_REQUEST['email'];
    $data['otp'] = $_REQUEST['otp'];
    $otp_flag = $obj->VerifyOTP($data);
    if ($otp_flag) {
        //$obj->SendUserWelcomeEmail();
        $user_id = $obj->getUserId($data['email']);
        $name = $obj->getUserFullNameById($user_id);
        $unique_id = $obj->getUserUniqueId($user_id);
        $email = $obj->getUserEmailById($user_id);
        //list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('2');
        $mail_data = $obj->getEmailAutoresponderDetails('2');
        $to_email = $data['email'];
        $from_email = $mail_data['email_ar_from_email'];
        $from_name = $mail_data['email_ar_from_name'];
        $subject = $mail_data['email_ar_subject'];
        $message = $mail_data['email_ar_body'];
        //  echo "<pre>";print_r($email);echo "<pre>";
        // exit;
        $message = str_ireplace("[[USER_NAME]]", $name, $message);
        $message = str_ireplace("[[USER_EMAIL]]", $email, $message);
        $message = str_ireplace("[[USER_UNIQUE_ID]]", $unique_id, $message);
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
        $response['msg'] = $obj->print_message(20); //'Your account activated successfully click link and start login in your profile <a href="login.php">Login</a>';
        $response['status'] = 1;
    }
    echo json_encode(array($response));
    exit(0);
} elseif ($action == 'geteventregistrationfees') {
    //    print_r($_REQUEST);
    //    die();
    $event_id = $_REQUEST['event_id'];
    $registration_type = $_REQUEST['registration_type'];
    //    echo $event_id;
    //    echo $registration_type;
    if ($event_id != '' && $registration_type != '') {
        //echo 'Hiii';
        $obj = new frontclass();
        $registraion_fees = $obj->GetEventRegistrationfess($event_id, $registration_type);
        echo number_format($registraion_fees, 2);
        exit(0);
    }
} elseif ($action == 'geteventticketfees') {
    //    print_r($_REQUEST);
    //    die();
    $event_id = $_REQUEST['event_id'];
    $ticket_type = $_REQUEST['ticket_type'];
    //    echo $event_id;
    //    echo $registration_type;
    if ($event_id != '' && $ticket_type != '') {
        //echo 'Hiii';
        $obj = new frontclass();
        $registraion_fees = $obj->GetEventTicketfess($event_id, $ticket_type);
        echo number_format($registraion_fees, 2);
        exit(0);
    }
} elseif ($action == 'geteventticketqty') {
    $event_id = $_REQUEST['event_id'];
    $ticket_type = $_REQUEST['ticket_type'];
    if ($event_id != '' && $ticket_type != '') {
        $obj = new frontclass();
        $registraion_fees = $obj->GetEventTicketQty($event_id, $ticket_type);
        echo $registraion_fees;
        exit(0);
    }
} elseif ($action == 'addtocart') {
    $error = 0;
    $err_msg = '';
    $event_id = '';
    if (isset($_POST['event_id']) && trim($_POST['event_id']) != '') {
        $event_id = trim($_POST['event_id']);
    }
    if (isset($_POST['event_name']) && trim($_POST['event_name']) != '') {
        $event_name = trim($_POST['event_name']);
    }
    $qty = '';
    if (isset($_POST['qty']) && trim($_POST['qty']) != '') {
        $qty = trim($_POST['qty']);
    }
    $booking_slot = '';
    if (isset($_POST['booking_slot']) && trim($_POST['booking_slot']) != '') {
        $booking_slot = trim($_POST['booking_slot']);
    } else {
        $error = 1;
        $err_msg = 'Please select Session';
    }
    // echo $booking_slot;
    // exit;
    $booking_date = '';
    if (isset($_POST['booking_date']) && trim($_POST['booking_date']) != '') {
        $booking_date = trim($_POST['booking_date']);
    }
    $type = '';
    if (isset($_POST['type']) && trim($_POST['type']) != '') {
        $type = trim($_POST['type']);
    }
    $registraion_type = '';
    if (isset($_POST['registraion_type']) && trim($_POST['registraion_type']) != '') {
        $registraion_type = trim($_POST['registraion_type']);
    }
    if ($event_id != '') {
        if ($qty != '') {
            if ($obj->chkIfTicketQtyAvailable($event_id, $qty, $type)) {
                // echo "<pre>";print_r($obj->chkIfTicketQtyAvailable($event_id,$qty,$type));echo "</pre>";
                if ($obj->addToCart($event_id, $qty, $booking_slot, $booking_date, $type, $registraion_type, $event_name)) {
                    $obj->getqty($event_id, $qty, $booking_slot, $booking_date, $type, $registraion_type);
                    $error = 0;
                    $err_msg = 'Item added successfully';
                } else {
                    $error = 1;
                    $err_msg = 'Something went wrong, Please try again later.';
                }
            } else {
                $error = 1;
                $err_msg = 'Sorry currently this quantity not available';
            }
        } else {
            $error = 1;
            $err_msg = 'Invalid quantity';
        }
    } else {
        $error = 1;
        $err_msg = 'Please select any item';
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg;
    echo $ret_str;
} elseif ($action == 'getAllDelaveyListOfItem') {
    $event_id = '';
    $cusine_name = '';
    if (isset($_POST['event_id']) && trim($_POST['event_id']) != '') {
        $event_id = trim($_POST['event_id']);
        $cnt = 0; // $j ==cnt ;
        $type = trim($_POST['type']);
        $ename = trim($_POST['ename']);
    }
    $item_delavery = $obj->getAllDelaveryListOfItem($event_id);
    // $order_cutoff_time is a refference data;
    // echo "<pre>";print_r($item_delavery);echo "<pre>";
    // exit;
    //                echo '<pre>';
    //                print_r($item_delavery);
    //                echo '</pre>';
    //        echo "<pre>";print_r($item_delavery);echo "<pre>";
    // exit;
    if (is_array($item_delavery) && count($item_delavery)) {
        //   echo "<pre>";print_r($item_delavery);echo "<pre>";
        // exit;
        $now = time();
        $next_delavery_date = array();
        //                echo '<pre>';
        //                print_r($item_delavery);
        //                echo '</pre>';
        // exit;
        if ($item_delavery['registration_cutoff_time'] != '') {
            $delaverydate_array = $item_delavery['delavery_date'];
            for ($k = 0;$k < count($delaverydate_array);$k++) {
                $cusine_delivery_date = $delaverydate_array[$k];
                //
                $date = date('Y-m-d', strtotime($cusine_delivery_date));
                //$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
                //$current_showing_date_time = $current_showing_date. ' 23:59:59';
                $one_day_before_current_showing_date = $date . ' ' . date("H:i:s");
                //$current_showing_date_time = $one_day_before_current_showing_date. ' '.$date_data[0].':00';
                //echo '<br>';
                $current_showing_date_time = $one_day_before_current_showing_date;
                $timestamp_csdt = strtotime($current_showing_date_time);
                $sec_cuttoff_time = $item_delavery['registration_cutoff_time'] * 3600;
                //$final_compared_timestamp = $timestamp_csdt - $sec_cuttoff_time;
                $final_compared_timestamp = $timestamp_csdt - $sec_cuttoff_time;
                if ($now < $final_compared_timestamp) {
                    $next_delavery_date[] = $cusine_delivery_date;
                }
                // $next_delavery_date[]= $cusine_delivery_date;
                
            }
        }
    }
    $req = '';
    // echo "<pre>";print_r($next_delavery_date);echo "<pre>";
    // exit;
    if (is_array($next_delavery_date) && count($next_delavery_date) > 0) {
        $cusine_id = $item_delavery['event_id'];
        // <th >Qty</th>
        //
        $req = '<div class="table-responsive">          

        <table class="table table-bordered">

          <thead>

            <tr>

                        <th>Dates</th>';
        if ($type == 'Registraion') {
            $req.= '<th>Registraion Type</th>';
        } else {
            $req.= '<th>Registraion Type</th>';
        }
        $req.= ' <th>Slots</th>

                               

                               <th>Book</th>

                 </tr>

          </thead>

        <tbody>';
        for ($j = 0;$j < count($next_delavery_date);$j++) {
            $slot = '';
            $time = strtotime(date("H:i:s")) + ($item_delavery['registration_cutoff_time'] * 3600);
            $slot_capare = date("Y-m-d") . ' ' . date("H:i:s", $time);
            $slot_capare_final = strtotime($slot_capare);
            $slot_1_time = explode(' ', $item_delavery['time_slot']['slot1_start_time']);
            $slot_2_time = explode(' ', $item_delavery['time_slot']['slot2_start_time']);
            $slot_3_time = explode(' ', $item_delavery['time_slot']['slot3_start_time']);
            $slot_4_time = explode(' ', $item_delavery['time_slot']['slot4_start_time']);
            $slot_5_time = explode(' ', $item_delavery['time_slot']['slot5_start_time']);
            $slot_6_time = explode(' ', $item_delavery['time_slot']['slot6_start_time']);
            $slot_1 = $next_delavery_date[$j] . ' ' . $slot_1_time[0] . ':00';
            $slot_2 = $next_delavery_date[$j] . ' ' . $slot_2_time[0] . ':00';
            $slot_3 = $next_delavery_date[$j] . ' ' . $slot_3_time[0] . ':00';
            $slot_4 = $next_delavery_date[$j] . ' ' . $slot_4_time[0] . ':00';
            $slot_5 = $next_delavery_date[$j] . ' ' . $slot_5_time[0] . ':00';
            $slot_6 = $next_delavery_date[$j] . ' ' . $slot_6_time[0] . ':00';
            $slot_1_campare = strtotime($slot_1);
            $slot_2_campare = strtotime($slot_2);
            $slot_3_campare = strtotime($slot_3);
            $slot_4_campare = strtotime($slot_4);
            $slot_5_campare = strtotime($slot_5);
            $slot_6_campare = strtotime($slot_6);
            if ($slot_1_campare > $slot_capare_final) {
                $slot.= (($item_delavery['time_slot']['slot1_start_time'] & $item_delavery['time_slot']['slot1_end_time']) != '' ? '<option value="' . $item_delavery['time_slot']['slot1_start_time'] . ' TO ' . $item_delavery['time_slot']['slot1_end_time'] . '">' . $item_delavery['time_slot']['slot1_start_time'] . ' TO ' . $item_delavery['time_slot']['slot1_end_time'] . '</option>' : '');
            }
            if ($slot_2_campare > $slot_capare_final) {
                $slot.= (($item_delavery['time_slot']['slot2_start_time'] & $item_delavery['time_slot']['slot2_end_time']) != '' ? '<option value="' . $item_delavery['time_slot']['slot2_start_time'] . ' TO ' . $item_delavery['time_slot']['slot2_end_time'] . '">' . $item_delavery['time_slot']['slot2_start_time'] . ' TO ' . $item_delavery['time_slot']['slot2_end_time'] . '</option>' : '');
            }
            if ($slot_3_campare > $slot_capare_final) {
                $slot.= (($item_delavery['time_slot']['slot3_start_time'] & $item_delavery['time_slot']['slot3_end_time']) != '' ? '<option value="' . $item_delavery['time_slot']['slot3_start_time'] . ' TO ' . $item_delavery['time_slot']['slot3_end_time'] . '">' . $item_delavery['time_slot']['slot3_start_time'] . ' TO ' . $item_delavery['time_slot']['slot3_end_time'] . '</option>' : '');
            }
            if ($slot_4_campare > $slot_capare_final) {
                $slot.= (($item_delavery['time_slot']['slot4_start_time'] & $item_delavery['time_slot']['slot4_end_time']) != '' ? '<option value="' . $item_delavery['time_slot']['slot4_start_time'] . ' TO ' . $item_delavery['time_slot']['slot4_end_time'] . '">' . $item_delavery['time_slot']['slot4_start_time'] . ' TO ' . $item_delavery['time_slot']['slot4_end_time'] . '</option>' : '');
            }
            if ($slot_5_campare > $slot_capare_final) {
                $slot.= (($item_delavery['time_slot']['slot5_start_time'] & $item_delavery['time_slot']['slot5_end_time']) != '' ? '<option value="' . $item_delavery['time_slot']['slot5_start_time'] . ' TO ' . $item_delavery['time_slot']['slot5_end_time'] . '">' . $item_delavery['time_slot']['slot5_start_time'] . ' TO ' . $item_delavery['time_slot']['slot5_end_time'] . '</option>' : '');
            }
            if ($slot_6_campare > $slot_capare_final) {
                $slot.= (($item_delavery['time_slot']['slot6_start_time'] & $item_delavery['time_slot']['slot6_end_time']) != '' ? '<option value="' . $item_delavery['time_slot']['slot6_start_time'] . ' TO ' . $item_delavery['time_slot']['slot6_end_time'] . '">' . $item_delavery['time_slot']['slot6_start_time'] . ' TO ' . $item_delavery['time_slot']['slot6_end_time'] . '</option>' : '');
            }
            $temp_showing_date = date('jS F', strtotime($next_delavery_date[$j]));
            $temp_showing_day = date(' ( l ) ', strtotime($next_delavery_date[$j]));
            $req.= '<tr>

                                        <td>' . $temp_showing_date . '<span class="small_note">' . $temp_showing_day . '</td>';
            if ($type == 'Registraion') {
                $registration_type = $obj->GetEventRegistrationType($event_id);
                $req.= '<td><select name="registraion_type_' . $j . '" id="registraion_type_' . $j . '" required="" class="form-control">

                                            <option value="">Select Registration Type</option>' . $obj->GetRegistratiotypeoption($registration_type) . '</select></td>';
            } else {
                $book_type = $obj->GetEventbookingType($event_id);
                $req.= '<td><select name="registraion_type_' . $j . '" id="registraion_type_' . $j . '" required="" class="form-control">

                                            <option value="">Select Registration Type</option>' . $obj->GetRegistratiotypeoption($book_type) . '</select></td>';
            }
            $req.= '<td>

           <input type="hidden" name="event_name_' . $j . '" id="event_name_' . $j . '" value="' . $ename . '">

         

          <select name="time_slot_' . $j . '" id="time_slot_' . $j . '" required="" class="form-control">

                                        <option value="">Select sessions</option>' . $slot . '</select></td>';
            $req.= '<td><button type="button" class="btn btn-success btn-xs" onclick="addToCart(' . $event_id . ',1,\'' . $type . '\',\'' . $next_delavery_date[$j] . '\',' . $j . ');">Book-Ticket</button></td>

          </tr>';
            // <td><input type="text" class="form-control" name="qty_'.$event_id.'" id="qty_'.$event_id.'" value="1" readonly></td>
            
        }
        $req.= '<tr>

                 <td  colspan="5">

                 <a href="javascript:doCheckoutProceedToPayment()">

                 <button class="btn_disabled_no_click dlvry_mg dlvry_clr" tabindex="0" style="float:right;" >Make Payment</button>

                 </a>

                 </td>

               </tr>';
    }
    $ret_str = $req;
    echo $ret_str;
    // exit();
    
} elseif ($action == 'docheckoutproceedtopayment') {
    //   echo "<pre>";print_r('hi');echo "</pre>";
    // exit;
    $error = 0;
    $err_msg = '';
    $url = '';
    if ($obj->isLoggedIn()) {
        // echo "<pre>";print_r($obj->chkIfCartEmpty());echo "</pre>";
        // exit;
        if ($obj->chkIfCartEmpty()) {
            $error = 1;
            $err_msg = 'Your cart is empty.';
            // exit;
            
        } else {
            $user_id = $_SESSION['user_id'];
            if ($obj->chkValidUserId($user_id)) {
                $invoice = $obj->genrateInvoiceNumber($user_id);
                $cart_session_id = session_id();
                $arr_user_detail = $obj->get_user_details($user_id);
                $arr_cart_detail = $obj->getCartDetailsBySessId($cart_session_id); //check code
                // echo "<pre>";print_r($arr_user_detail);echo "<pre>";
                // echo "<pre>";print_r($arr_cart_detail);echo "<pre>";
                // exit;
                $obj->debuglog('[remote_createorder] arr_cart_detail:<pre>' . print_r($arr_cart_detail, 1) . '</pre>');
                $tdata = array();
                $tdata['invoice'] = $invoice;
                $tdata['cart_session_id'] = $cart_session_id;
                $tdata['order_status'] = 0;
                $tdata['payment_status'] = 0;
                $tdata['user_id'] = $user_id;
                $tdata['user_name'] = $arr_user_detail['first_name'] . ' ' . $arr_user_detail['last_name'];
                $tdata['user_email'] = $arr_user_detail['email'];
                $tdata['user_mobile_no'] = $arr_user_detail['mobile'];
                $tdata['user_building_name'] = $arr_user_detail['building_name'];
                $tdata['user_floor_no'] = $arr_user_detail['floor_no'];
                $tdata['user_landmark'] = $arr_user_detail['landmark'];
                $tdata['user_address'] = $arr_user_detail['address'];
                $tdata['user_country_id'] = $arr_user_detail['country_id'];
                $tdata['user_country_name'] = $obj->getCountryName($arr_user_detail['country_id']);
                $tdata['user_state_id'] = $arr_user_detail['state_id'];
                $tdata['user_state_name'] = $obj->getStateName($arr_user_detail['state_id']);
                $tdata['user_city_id'] = $arr_user_detail['city_id'];
                $tdata['user_city_name'] = $obj->getCityName($arr_user_detail['city_id']);
                $tdata['user_area_id'] = $arr_user_detail['area_id'];
                $tdata['user_area_name'] = $obj->getAreaName($arr_user_detail['area_id']);
                $tdata['user_delivery_mobile_no'] = $arr_user_detail['mobile'];
                $tdata['user_pincode'] = $arr_user_detail['pincode'];
                $tdata['billing_building_name'] = $arr_user_detail['billing_building_name'];
                $tdata['billing_floor_no'] = $arr_user_detail['billing_floor_no'];
                $tdata['billing_landmark'] = $arr_user_detail['billing_landmark'];
                $tdata['billing_address'] = $arr_user_detail['billing_address'];
                $tdata['billing_country_id'] = $arr_user_detail['billing_country_id'];
                $tdata['billing_country_name'] = $obj->getCountryName($arr_user_detail['billing_country_id']);
                $tdata['billing_state_id'] = $arr_user_detail['billing_state_id'];
                $tdata['billing_state_name'] = $obj->getStateName($arr_user_detail['billing_state_id']);
                $tdata['billing_city_id'] = $arr_user_detail['billing_city_id'];
                $tdata['billing_city_name'] = $obj->getCityName($arr_user_detail['billing_city_id']);
                $tdata['billing_area_id'] = $arr_user_detail['billing_area_id'];
                $tdata['billing_area_name'] = $obj->getAreaName($arr_user_detail['billing_area_id']);
                $tdata['billing_mobile_no'] = $arr_user_detail['billing_mobile_no'];
                $tdata['billing_pincode'] = $arr_user_detail['billing_pincode'];
                $tdata['order_subtotal'] = $arr_cart_detail['order_subtotal'];
                $tdata['order_discount_coupon'] = $arr_cart_detail['order_discount_coupon'];
                $tdata['order_trade_discount'] = $arr_cart_detail['order_trade_discount'];
                $tdata['order_discount'] = $arr_cart_detail['order_discount'];
                $tdata['order_discount_vendor_id'] = $arr_cart_detail['order_discount_vendor_id'];
                $tdata['order_tax'] = $arr_cart_detail['order_tax'];
                $tdata['order_shipping_amt'] = $arr_cart_detail['order_shipping_amt'];
                $tdata['order_total_amt'] = $arr_cart_detail['order_total_amt'];
                if ($arr_user_detail['delivery_name'] == '') {
                    $arr_user_detail['delivery_name'] = $tdata['user_name'];
                }
                if ($arr_user_detail['billing_name'] == '') {
                    $arr_user_detail['billing_name'] = $arr_user_detail['delivery_name'];
                }
                $tdata['delivery_name'] = $arr_user_detail['delivery_name'];
                $tdata['billing_name'] = $arr_user_detail['billing_name'];
                $tdata['order_cgst_tax_amount'] = $arr_cart_detail['order_cgst_tax_amount'];
                $tdata['order_sgst_tax_amount'] = $arr_cart_detail['order_sgst_tax_amount'];
                $tdata['order_cess_tax_amount'] = $arr_cart_detail['order_cess_tax_amount'];
                $tdata['order_gst_tax_amount'] = $arr_cart_detail['order_gst_tax_amount'];
                $tdata['cart'] = $arr_cart_detail['cart'];
                // $obj = new frontclass();
                if ($obj->createOrder($tdata)) {
                    $error = 0;
                    $url = SITE_URL . '/pay.php?ref=' . $invoice;
                } else {
                    $error = 1;
                    $err_msg = 'Somthing went wrong. Please try again later';
                }
            } else {
                $error = 1;
                $err_msg = 'Invalid user.';
            }
        }
    } else {
        $error = 1;
        $err_msg = 'Please login to continue.';
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg . '::::' . $url;
    echo $ret_str;
} elseif ($action == 'getstateoption') {
    $country_id = trim($_REQUEST['country_id']);
    $state_id = trim($_REQUEST['state_id']);
    if (isset($_REQUEST['type'])) {
        $type = trim($_REQUEST['type']);
    } else {
        $type = '';
    }
    if (isset($_REQUEST['multiple'])) {
        $multiple = trim($_REQUEST['multiple']);
    } else {
        $multiple = '';
    }
    if ($multiple == '1') {
        $arr_country_id = explode(',', $country_id);
        $arr_state_id = explode(',', $state_id);
    } else {
        $arr_country_id = $country_id;
        $arr_state_id = $state_id;
    }
    $data = $obj->getStateOption($arr_country_id, $arr_state_id, $type, $multiple);
    echo $data;
} elseif ($action == 'getcityoption') {
    $country_id = trim($_REQUEST['country_id']);
    $state_id = trim($_REQUEST['state_id']);
    $city_id = trim($_REQUEST['city_id']);
    if (isset($_REQUEST['type'])) {
        $type = trim($_REQUEST['type']);
    } else {
        $type = '';
    }
    if (isset($_REQUEST['multiple'])) {
        $multiple = trim($_REQUEST['multiple']);
    } else {
        $multiple = '';
    }
    if ($multiple == '1') {
        $arr_country_id = explode(',', $country_id);
        $arr_state_id = explode(',', $state_id);
        $arr_city_id = explode(',', $city_id);
    } else {
        $arr_country_id = $country_id;
        $arr_state_id = $state_id;
        $arr_city_id = $city_id;
    }
    $data = $obj->getCityOption($arr_country_id, $arr_state_id, $arr_city_id, $type, $multiple);
    echo $data;
} elseif ($action == 'getareaoption') {
    $country_id = trim($_REQUEST['country_id']);
    $state_id = trim($_REQUEST['state_id']);
    $city_id = trim($_REQUEST['city_id']);
    $area_id = trim($_REQUEST['area_id']);
    if (isset($_REQUEST['type'])) {
        $type = trim($_REQUEST['type']);
    } else {
        $type = '';
    }
    if (isset($_REQUEST['multiple'])) {
        $multiple = trim($_REQUEST['multiple']);
    } else {
        $multiple = '';
    }
    if ($multiple == '1') {
        $arr_country_id = explode(',', $country_id);
        $arr_state_id = explode(',', $state_id);
        $arr_city_id = explode(',', $city_id);
        $arr_area_id = explode(',', $area_id);
    } else {
        $arr_country_id = $country_id;
        $arr_state_id = $state_id;
        $arr_city_id = $city_id;
        $arr_area_id = $area_id;
    }
    $data = $obj->getAreaOption($arr_country_id, $arr_state_id, $arr_city_id, $arr_area_id, $type, $multiple);
    echo $data;
} elseif ($action == 'getlocation') {
    $response = array();
    $signup_city = $_REQUEST['city'] != '' ? $_REQUEST['city'] : '';
    $city_id = $obj->getCityIdbyName($signup_city);
    if ($city_id != '') {
        $response['place_option'] = $obj->getPlaceOptions($city_id);
        $response['error'] = 0;
    }
    echo json_encode(array($response));
    exit(0);
} else if ($action == 'getbescomment') {
    $besname = $_REQUEST['bms_name'];
    $table = $_REQUEST['fetch_link'];
    $sub_cat3 = $_REQUEST['sub_cat3'];
    $tabl2 = $_REQUEST['fetch_link_2'];
    $sub_cat4 = $_REQUEST['sub_cat4'];
    $final_table = $table . ',' . $tabl2;
    $final_cat = $sub_cat3 . ',' . $sub_cat4;
    $final_table = trim($final_table, ',');
    $final_cat = trim($final_cat, ',');
    $final_table = explode(',', $final_table);
    $final_cat = explode(',', $final_cat);
    $comment = $obj->getCommentByBesnameDesign($besname, $final_table, $final_cat);
    //       echo '<pre>';
    //       print_r($final_table);
    //       echo '</pre>';
    //
    //        echo '<pre>';
    //       print_r($final_cat);
    //       echo '</pre>';
    echo $comment;
    exit(0);
}
if ($action == 'changtheammdt') {
    $theam_id = stripslashes($_REQUEST['theam_id']);
    $_SESSION['mdttheam_id'] = $theam_id;
    $response = array();
    list($image, $color_code) = $obj->getTheamDetailsMDT($theam_id);
    $output = $image . '::' . $color_code;
    $response['image'] = $image;
    $response['color_code'] = $color_code;
    $response['error'] = 0;
    echo json_encode(array($response));
    exit(0);
} else if ($action == 'ChangeTheMusic') {
    $obj2 = new frontclass2();
    $music_id1 = $_REQUEST['music_id1'];
    $music = $obj2->getMusicNameByid($music_id1);
    echo $option.= '<audio autoplay loop>

        <source src="uploads/' . $music . '" /> 

        <source src="uploads/' . $music . '" /> 

        </audio>';
    exit(0);
} else if ($action == 'ChangeTheAvatar') {
    $obj2 = new frontclass2();
    $avat_id = $_REQUEST['avat_id'];
    $image = $obj2->getAvatarNameByid($avat_id);
    echo $option.= '<img src="uploads/' . stripslashes($image) . '" height="50px;" width="50px;" title="My Today\'s Mascot">';
    exit(0);
} else if ($action == 'getmydesignlifedata') {
    $day_month_year = date("Y-m-d");
    $sub_cat_id = $_REQUEST['sub_cat_id'];
    // $ref_code= $_REQUEST['ref_code'];
    $get_design_data = $obj->GETDesignData($sub_cat_id, $day_month_year);
    $outputstr = '';
    $tr_days_of_month = 'none';
    $tr_single_date = 'none';
    $tr_date_range = 'none';
    $tr_month_date = 'none';
    $tr_days_of_week = 'none';
    //        echo '<pre>';
    //        print_r($get_design_data);
    //        echo '<pre>';
    //echo count($get_design_data);
    if (count($get_design_data) > 0) {
        for ($j = 0;$j < count($get_design_data);$j++) {
            //            echo $j;
            //            echo '<br>';
            //$ref_num = $obj->GetRefNumer($sub_cat_id);
            $_SESSION["ref_cde"] = $get_design_data[$j]['ref_code'];
            $design_my_life_data = $obj->GetDesignMyLifeDatabyRef($get_design_data[$j]['ref_code']);
            $header_data = $obj->GetHeaderDatabyPageKR($get_design_data[$j]['ref_code']);
            // echo "<pre>";print_r($header_data);echo "</pre>";
            // exit;
            $profile_category = $obj->GetProfilecatname($design_my_life_data['prof_cat_id']);
            $sub_cat_option = $obj->getSubCatOptions($design_my_life_data['prof_cat_id'], $design_my_life_data['sub_cat_id']);
            $narration = $design_my_life_data['narration'];
            $data_dropdown = $obj->GETDATADROPDOWNMYDAYTODAYOPTION($design_my_life_data['data_category'], '127');
            $show_cat = '';
            $fetch_cat1 = array();
            $fetch_cat2 = array();
            $fetch_cat3 = array();
            $fetch_cat4 = array();
            $fetch_cat5 = array();
            $fetch_cat6 = array();
            $fetch_cat7 = array();
            $fetch_cat8 = array();
            $fetch_cat9 = array();
            $fetch_cat10 = array();
            if ($data_dropdown[0]['sub_cat1'] != '') {
                if ($data_dropdown[0]['canv_sub_cat1_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat1'] . ',';
                } else {
                    $fetch_cat1 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat1_link'], $data_dropdown[0]['sub_cat1']);
                }
            }
            if ($data_dropdown[0]['sub_cat2'] != '') {
                if ($data_dropdown[0]['canv_sub_cat2_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat2'] . ',';
                } else {
                    $fetch_cat2 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat2_link'], $data_dropdown[0]['sub_cat2']);
                }
            }
            if ($data_dropdown[0]['sub_cat3'] != '') {
                if ($data_dropdown[0]['canv_sub_cat3_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat3'] . ',';
                } else {
                    $fetch_cat3 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat3_link'], $data_dropdown[0]['sub_cat3']);
                }
            }
            if ($data_dropdown[0]['sub_cat4'] != '') {
                if ($data_dropdown[0]['canv_sub_cat4_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat4'] . ',';
                } else {
                    $fetch_cat4 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat4_link'], $data_dropdown[0]['sub_cat4']);
                }
            }
            if ($data_dropdown[0]['sub_cat5'] != '') {
                if ($data_dropdown[0]['canv_sub_cat5_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat5'] . ',';
                } else {
                    $fetch_cat5 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat5_link'], $data_dropdown[0]['sub_cat5']);
                }
            }
            if ($data_dropdown[0]['sub_cat6'] != '') {
                if ($data_dropdown[0]['canv_sub_cat6_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat6'] . ',';
                } else {
                    $fetch_cat6 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat6_link'], $data_dropdown[0]['sub_cat6']);
                }
            }
            if ($data_dropdown[0]['sub_cat7'] != '') {
                if ($data_dropdown[0]['canv_sub_cat7_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat7'] . ',';
                } else {
                    $fetch_cat7 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat7_link'], $data_dropdown[0]['sub_cat7']);
                }
            }
            if ($data_dropdown[0]['sub_cat8'] != '') {
                if ($data_dropdown[0]['canv_sub_cat8_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat8'] . ',';
                } else {
                    $fetch_cat8 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat8_link'], $data_dropdown[0]['sub_cat8']);
                }
            }
            if ($data_dropdown[0]['sub_cat9'] != '') {
                if ($data_dropdown[0]['canv_sub_cat9_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat9'] . ',';
                } else {
                    $fetch_cat9 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat9_link'], $data_dropdown[0]['sub_cat9']);
                }
            }
            if ($data_dropdown[0]['sub_cat10'] != '') {
                if ($data_dropdown[0]['canv_sub_cat10_show_fetch'] == 1) {
                    $show_cat.= $data_dropdown[0]['sub_cat10'] . ',';
                } else {
                    $fetch_cat10 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat10_link'], $data_dropdown[0]['sub_cat10']);
                }
            }
            $show_cat = explode(',', $show_cat);
            $show_cat = array_filter($show_cat);
            $final_array = array_merge($fetch_cat1, $fetch_cat2, $fetch_cat3, $fetch_cat4, $fetch_cat5, $fetch_cat6, $fetch_cat7, $fetch_cat8, $fetch_cat9, $fetch_cat10);
            $final_dropdown = $obj->CreateDesignLifeDropdownEdit($show_cat, $final_array, $design_data['box_title']);
            $tr_days_of_month = 'none';
            $tr_single_date = 'none';
            $tr_date_range = 'none';
            $tr_month_date = 'none';
            $tr_days_of_week = 'none';
            //$outputstr='';
            $outputstr.= '<div class="col-md-12" style="">

                                       <form name="design_life_data" id="design_life_data" method="post">

                                      <input type="hidden" id="ref_c" value="' . $get_design_data[$j]['ref_code'] . '">

                            <div class="col-md-12">';
            if ($narration != '' && $design_my_life_data['narration_show'] == 1) {
                $outputstr.= '<br><br><span class="">' . $narration . '</span>

                             <br><br>';
            }
            if ($design_my_life_data['show_to_user'] == '1') {
                $outputstr.= '<span>

                                <input type="text" ' . $required . ' name="title_id" id="title_id" placeholder="Make your choice" list="capitals" class="input-text-box dlist" style="width:600px;" />

                               <datalist id="capitals" class="dlist" style="">

                                    ' . $final_dropdown . '  

                                </datalist>

                             </span>

                             <br>

                             <span id="message" style="color:blue; font-size: 10px;">(Type 4 letters and select keyword option)</span>';
            } else {
                $outputstr.= '<span class="">' . $design_my_life_data['box_title'] . '</span>';
            }
            $outputstr.= '<br>

                            <br>

                            ';
            if ($design_my_life_data['quick_response_show'] == 1) {
                $cat_cnt = 0;
                $cat_total_cnt = 1;
                $box_cnt = 0;
                $box_total_cnt = 1;
                $count = $design_my_life_data['box_count'];
                $input_box_count = $design_my_life_data['input_box_count'];
                $symtum_cat = $design_my_life_data['sub_cat2'];
                $sub_cat2_show_fetch = $design_my_life_data['sub_cat2_show_fetch'];
                $sub_cat2_link = $design_my_life_data['sub_cat2_link'];
                $data_dropdown = $obj->GetDesignMyLifeDrop($symtum_cat, $sub_cat2_show_fetch, $sub_cat2_link);
                $outputstr.= '<span><strong>' . $design_my_life_data['quick_response_heading'] . '</strong></span>  

                            <br>

                            <span>

                                <input type="hidden" name="sub_cat_id" id="sub_cat_id" value="' . $sub_cat_id . '"/>

                                <input type="hidden" name="fetch_link" id="fetch_link" value="' . $design_my_life_data['sub_cat3_link'] . '"/>

                                <input type="hidden" name="sub_cat3" id="sub_cat3" value="' . $design_my_life_data['sub_cat3'] . '"/>

                                

                                <input type="hidden" name="fetch_link_2" id="fetch_link_2" value="' . $design_my_life_data['sub_cat4_link'] . '"/>

                                <input type="hidden" name="sub_cat4" id="sub_cat4" value="' . $design_my_life_data['sub_cat4'] . '"/>

                                <input type="hidden" name="ref_code" id="ref_code" value="' . $design_my_life_data['ref_code'] . '"/>

                                <input type="hidden" name="icon_code" id="icon_code" value="' . $design_my_life_data['quick_tip_icon'] . '"/>

                            </span>';
                $outputstr.= ' <span id="message" style="color:blue; font-size: 10px;">(Type 4 letters and select keyword option)</span>

                                   <br>';
                for ($i = 0;$i <= $cat_cnt;$i++) {
                    $child = ($i == 0 ? 'first' : $i);
                    $outputstr.= '

                            <div id="row_loc_' . $child . '">

                                <input type="hidden" name="cat_cnt" id="cat_cnt" value="' . $cat_cnt . '">

                                <input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="' . $cat_total_cnt . '">    

                            <span>

                               <input type="text" ' . $required . ' name="fav_cat_2[]" id="fav_cat_2_' . $i . '" placeholder="Select Your inputs" list="capitals_' . $i . '" class="input-text-box dlist" style="width:600px;" onchange="Display_Solution(' . $i . ')"/>

                               <datalist id="capitals_' . $i . '" class="dlist" style="">

                                    ' . $data_dropdown . ' 

                                </datalist>

                             </span>

                                <span>';
                    if ($i == 0) {
                        $outputstr.= '<a href="javascript:void(0);" onclick="addMoreRowLocation();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>';
                        $outputstr.= '<a href="javascript:void(0);" onclick="erase_input(0);"><i class="fa fa-eraser" id="erase_icon0" aria-hidden="true" style="font-size: 15px;"></i></a><br>';
                        $outputstr.= '&nbsp;&nbsp;<a href="javascript:void(0);" onclick="Showloop(0);"><i class="fa fa-eye" style="cursor: pointer;" id="eyes0" title="Click here for user action"></i></a>';
                        // echo "<pre>";print_r($header_data);echo "</pre>";
                        for ($j = 0;$j < count($header_data);$j++) {
                            $keyworddata_implode_data = array();
                            $exclusion_name = $obj->getExclusionAllName();
                            if ($header_data[$j]['location_show'] != 0) {
                                $location_show_icon = $obj->getMyDayTodayIcon('location_show');
                            } else {
                                $location_show_icon = '';
                            }
                            if ($header_data[$j]['User_view'] != 0) {
                                $User_view_icon = $obj->getMyDayTodayIcon('User_view');
                            } else {
                                $User_view_icon = '';
                            }
                            if ($header_data[$j]['User_Interaction'] != 0) {
                                $User_Interaction_icon = $obj->getMyDayTodayIcon('User_Interaction');
                            } else {
                                $User_Interaction_icon = '';
                            }
                            if ($header_data[$j]['alert_show'] != 0) {
                                $alert_show_icon = $obj->getMyDayTodayIcon('alert_show');
                            } else {
                                $alert_show_icon = '';
                            }
                            if ($header_data[$j]['comment_show'] != 0) {
                                $comment_show_icon = $obj->getMyDayTodayIcon('comments_show');
                            } else {
                                $comment_show_icon = '';
                            }
                            if ($header_data[$j]['user_date_show'] != 0) {
                                $user_date_icon = $obj->getMyDayTodayIcon('date_show');
                            } else {
                                $user_date_icon = '';
                            }
                            if ($header_data[$j]['scale_show'] != 0) {
                                $scale_show_icon = $obj->getMyDayTodayIcon('scale_show');
                            } else {
                                $scale_show_icon = '';
                            }
                            if ($header_data[$j]['time_show'] != 0) {
                                $time_show_icon = $obj->getMyDayTodayIcon('time_show');
                            } else {
                                $time_show_icon = '';
                            }
                            if ($header_data[$j]['duration_show'] != 0) {
                                $duration_show_icon = $obj->getMyDayTodayIcon('duration_show');
                            } else {
                                $duration_show_icon = '';
                            }
                            // echo "<pre>";print_r($header_data);echo "</pre>";
                            if ($header_data[$j]['sub_cat2'] != '') {
                                $fetch_show = $header_data[$j]['sub_cat2_show_fetch'];
                                if ($comment_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $comment_show_icon . '"  name="comment_show_icon_0" id="comment_show_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['comments_heading'] . '" onclick="ShowComment(0);">';
                                }
                                if ($location_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $location_show_icon . '"  name="location_show_icon_0" id="location_show_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['location_heading'] . '" onclick="ShowLocation(0);">';
                                }
                                if ($User_view_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_view_icon . '"  name="User_view_icon_0" id="User_view_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['like_dislike_heading'] . '" onclick="ShowUserview(0);">';
                                }
                                if ($User_Interaction_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_Interaction_icon . '"  name="User_Interaction_icon_0" id="User_Interaction_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['set_goals_heading'] . '" onclick="ShowUserInteraction(0);">';
                                }
                                if ($alert_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $alert_show_icon . '"  name="alert_show_icon_0" id="alert_show_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['reminder_heading'] . '" onclick="ShowAlert(0);">';
                                }
                                if ($scale_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $scale_show_icon . '"  name="scale_show_icon_0" id="scale_show_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['scale_heading'] . '" onclick="ShowScale(0);">';
                                }
                                if ($time_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $time_show_icon . '" name="time_show_icon_0" id="time_show_icon_0" style="width:25px; height: 25px; display:none;" title="Select ' . $header_data[$j]['time_heading'] . '" onclick="Showtime(0);">';
                                }
                                if ($duration_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $duration_show_icon . '"  name="duration_show_icon_0" id="duration_show_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['duration_heading'] . '" onclick="DurationShow(0);">';
                                }
                                if ($user_date_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $user_date_icon . '"  name="user_date_show_icon_0" id="user_date_show_icon_0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['user_date_heading'] . '" onclick="ShowUserDate(0);">';
                                }
                                $outputstr.= '</p>';
                                $outputstr.= '<div class="md-col-12">

                                                <input type="hidden" name="sub_cat[]"  value="' . $header_data[$j]['sub_cat2'] . '">';
                                $outputstr.= '<input type="hidden" name="prof_cat[]"  value="' . $header_data[$j]['prof_cat2'] . '">';
                                $outputstr.= '<input type="hidden" name="canv_show_fetch[]"  value="' . $header_data[$j]['sub_cat2_show_fetch'] . '">';
                                $outputstr.= '<input type="hidden" name="canv_sub_cat_link[]"  value="' . $header_data[$j]['sub_cat2_link'] . '">';
                                $outputstr.= '<input  type="text" name="comment[]" id="comment_0"  placeholder="' . $header_data[$j]['comments_heading'] . '" title="' . $header_data[$j]['comments_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="location[]" id="location_0" style="display:none;" title="' . $header_data[$j]['location_heading'] . '">

                                                    <option value="">' . $header_data[$j]['location_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_0" style="display:none;" title="' . $header_data[$j]['like_dislike_heading'] . '">

                                                    <option value="">' . $header_data[$j]['like_dislike_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_0" style="display:none;" title="' . $header_data[$j]['set_goals_heading'] . '">

                                                    <option value="">' . $header_data[$j]['set_goals_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select class="input-text-box input-quarter-width" name="alert[]" id="alert_0" style="display:none;" title="' . $header_data[$j]['reminder_heading'] . '">

                                                    <option value="">' . $header_data[$j]['reminder_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="scale[]" id="scale_0" style="display:none;" title="' . $header_data[$j]['scale_heading'] . '">

                                                <option value="">' . $header_data[$j]['scale_heading'] . '</option>

                                                <option value="1">1</option>

                                                <option value="2">2</option>

                                                <option value="3">3</option>

                                                <option value="4">4</option>

                                                <option value="5">5</option>

                                                <option value="6">6</option>

                                                <option value="7">7</option>

                                                <option value="8">8</option>

                                                <option value="9">9</option>

                                                <option value="10">10</option>

                                            </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="bes_time[]" id="bes_time_0" style="display: none;">

                                                 <option value="">' . $design_my_life_data['time_heading'] . '</option>

                                                 ' . $obj->getTimeOptionsNew('0', '23', $bes_time) . '

                                             </select>';
                                $outputstr.= '<input type="text" name="duration[]" id="duration_0" onKeyPress="return isNumberKey(event);" placeholder="' . $design_my_life_data['duration_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">';
                                $outputstr.= '<span class="">

                                          <select name="userdate[]" id="userdate_0" onchange="toggleDateSelectionType_multiple(\'userdate_\',0)" style="width:200px;display:none;" class="input-text-box input-quarter-width">

                                              <option value="">Select Date Type</option>

                                              <option value="days_of_month"';
                                if ($listing_date_type == 'days_of_month') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Days of Month</option><option value="single_date"';
                                if ($listing_date_type == 'single_date') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Single Date</option><option value="date_range"';
                                if ($listing_date_type == 'date_range') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Date Range</option> <option value="month_wise"';
                                if ($listing_date_type == 'month_wise') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Month Wise</option><option value="days_of_week"';
                                if ($listing_date_type == 'days_of_week') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Days of Week</option>

                                             </select>

                                             </span>

                                            <span>



                                          <p>&nbsp;</p>

                                            <table>

                                            <tr id="tr_days_of_month_0" style="display:' . $tr_days_of_month . '">

                                                    <td align="right" valign="top"><strong>Select days of month</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="days_of_month" name="days_of_month[0][]" multiple="multiple" style="width:500px;" class="input-text-box input-quarter-width">';
                                for ($i = 1;$i <= 31;$i++) {
                                    $outputstr.= '<option value="' . $i . '"';
                                    if (in_array($i, $arr_days_of_month)) {
                                        $outputstr.= 'selected="selected"';
                                    }
                                    $outputstr.= '>' . $i . '</option>';
                                }
                                $outputstr.= '</select>&nbsp;*<br>

                                                   You can choose more than one option by using the ctrl key.

                                                  </td>

                                                 </tr>';
                                $outputstr.= '<tr id="tr_single_date_0" style="display:' . $tr_single_date . '">

                                                    <td align="right" valign="top"><strong>Select Date</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <input name="single_date[]" id="single_date0" type="text" value="' . $single_date . '" class="input-text-box" onmouseover="callDatecalender(0)">';
                                $outputstr.= '</td>

                                                </tr>



                                                <tr id="tr_date_range_0" style="display:' . $tr_date_range . '">

                                                    <td align="right" valign="top"><strong>Select Date Range</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <input name="start_date[]" id="start_date0" type="text" value="' . $start_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender(0)"/> - <input name="end_date[]" id="end_date0" type="text" value="' . $end_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender(0)" />';
                                $outputstr.= '</td>

                                                </tr>



                                                <tr id="tr_days_of_week_0" style="display:' . $tr_days_of_week . '">

                                                <td align="right" valign="top"><strong>Select days of week</strong></td>

                                                <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="days_of_week" name="days_of_week[0][]" multiple="multiple" class="input-text-box">';
                                $outputstr.= $obj->getDayOfWeekOptionsMultiple($arr_days_of_week);
                                $outputstr.= '</select>&nbsp;*<br>

                                                        You can choose more than one option by using the ctrl key.

                                                    </td>

                                                </tr>';
                                $outputstr.= '<tr id="tr_month_date_0" style="display:' . $tr_month_date . '">

                                                    <td align="right" valign="top"><strong>Select Month</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="months" name="months[0][]" multiple="multiple" class="input-text-box">';
                                $outputstr.= $obj->getMonthsOptionsMultiple($arr_month);
                                $outputstr.= '</select>&nbsp;*<br>

                                                        You can choose more than one option by using the ctrl key.

                                                    </td>

                                                </tr>

                                                </table>

                                        </span>

                                       <br>

                                    </div>';
                            }
                        }
                    } else {
                        $outputstr.= '<a href="javascript:void(0);" onclick="removeRowLocation(' . $i . ');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>';
                        $outputstr.= '<a href="javascript:void(0);" onclick="erase_input(' . $i . ');"><i class="fa fa-eraser" id="erase_icon' . $i . '" aria-hidden="true" style="font-size: 15px;"></i></a><br>';
                        $outputstr.= '&nbsp;&nbsp;<a href="javascript:void(0);" onclick="Showloop(' . $i . ');"><i class="fa fa-eye" style="cursor: pointer;" id="eyes' . $i . '" title="Click here for user action"></i></a>';
                        for ($j = 0;$j < count($header_data);$j++) {
                            $keyworddata_implode_data = array();
                            $exclusion_name = $obj->getExclusionAllName();
                            if ($header_data[$j]['location_show'] != 0) {
                                $location_show_icon = $obj->getMyDayTodayIcon('location_show');
                            } else {
                                $location_show_icon = '';
                            }
                            if ($header_data[$j]['User_view'] != 0) {
                                $User_view_icon = $obj->getMyDayTodayIcon('User_view');
                            } else {
                                $User_view_icon = '';
                            }
                            if ($header_data[$j]['User_Interaction'] != 0) {
                                $User_Interaction_icon = $obj->getMyDayTodayIcon('User_Interaction');
                            } else {
                                $User_Interaction_icon = '';
                            }
                            if ($header_data[$j]['alert_show'] != 0) {
                                $alert_show_icon = $obj->getMyDayTodayIcon('alert_show');
                            } else {
                                $alert_show_icon = '';
                            }
                            if ($header_data[$j]['comment_show'] != 0) {
                                $comment_show_icon = $obj->getMyDayTodayIcon('comments_show');
                            } else {
                                $comment_show_icon = '';
                            }
                            if ($header_data[$j]['user_date_show'] != 0) {
                                $user_date_icon = $obj->getMyDayTodayIcon('date_show');
                            } else {
                                $user_date_icon = '';
                            }
                            if ($header_data[$j]['scale_show'] != 0) {
                                $scale_show_icon = $obj->getMyDayTodayIcon('scale_show');
                            } else {
                                $scale_show_icon = '';
                            }
                            if ($header_data[$j]['time_show'] != 0) {
                                $time_show_icon = $obj->getMyDayTodayIcon('time_show');
                            } else {
                                $time_show_icon = '';
                            }
                            if ($header_data[$j]['duration_show'] != 0) {
                                $duration_show_icon = $obj->getMyDayTodayIcon('duration_show');
                            } else {
                                $duration_show_icon = '';
                            }
                            if ($header_data[$j]['sub_cat2'] != '') {
                                $fetch_show = $header_data[$j]['sub_cat2_show_fetch'];
                                if ($comment_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $comment_show_icon . '"  name="comment_show_icon_' . $i . '" id="comment_show_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['comments_heading'] . '" onclick="ShowComment(' . $i . ');">';
                                }
                                if ($location_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $location_show_icon . '"  name="location_show_icon_' . $i . '" id="location_show_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['location_heading'] . '" onclick="ShowLocation(' . $i . ');">';
                                }
                                if ($User_view_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_view_icon . '"  name="User_view_icon_' . $i . '" id="User_view_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['like_dislike_heading'] . '" onclick="ShowUserview(' . $i . ');">';
                                }
                                if ($User_Interaction_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_Interaction_icon . '"  name="User_Interaction_icon_' . $i . '" id="User_Interaction_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['set_goals_heading'] . '" onclick="ShowUserInteraction(' . $i . ');">';
                                }
                                if ($alert_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $alert_show_icon . '"  name="alert_show_icon_' . $i . '" id="alert_show_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['reminder_heading'] . '" onclick="ShowAlert(' . $i . ');">';
                                }
                                if ($scale_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $scale_show_icon . '"  name="scale_show_icon_' . $i . '" id="scale_show_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['scale_heading'] . '" onclick="ShowScale(' . $i . ');">';
                                }
                                if ($time_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $time_show_icon . '" name="time_show_icon_' . $i . '" id="time_show_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="Select ' . $header_data[$j]['time_heading'] . '" onclick="Showtime(' . $i . ');">';
                                }
                                if ($duration_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $duration_show_icon . '"  name="duration_show_icon_' . $i . '" id="duration_show_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['duration_heading'] . '" onclick="DurationShow(' . $i . ');">';
                                }
                                if ($user_date_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $user_date_icon . '"  name="user_date_show_icon_' . $i . '" id="user_date_show_icon_' . $i . '" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['user_date_heading'] . '" onclick="ShowUserDate(' . $i . ');">';
                                }
                                $outputstr.= '</p>';
                                $outputstr.= '<div class="md-col-12">

                                                <input type="hidden" name="sub_cat[]"  value="' . $header_data[$j]['sub_cat2'] . '">';
                                $outputstr.= '<input type="hidden" name="prof_cat[]"  value="' . $header_data[$j]['prof_cat2'] . '">';
                                $outputstr.= '<input type="hidden" name="canv_show_fetch[]"  value="' . $header_data[$j]['sub_cat2_show_fetch'] . '">';
                                $outputstr.= '<input type="hidden" name="canv_sub_cat_link[]"  value="' . $header_data[$j]['sub_cat2_link'] . '">';
                                $outputstr.= '<input  type="text" name="comment[]" id="comment_' . $i . '"  placeholder="' . $header_data[$j]['comments_heading'] . '" title="' . $header_data[$j]['comments_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="location[]" id="location_' . $i . '" style="display:none;" title="' . $header_data[$j]['location_heading'] . '">

                                                    <option value="">' . $header_data[$j]['location_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_' . $i . '" style="display:none;" title="' . $header_data[$j]['like_dislike_heading'] . '">

                                                    <option value="">' . $header_data[$j]['like_dislike_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_' . $i . '" style="display:none;" title="' . $header_data[$j]['set_goals_heading'] . '">

                                                    <option value="">' . $header_data[$j]['set_goals_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select class="input-text-box input-quarter-width" name="alert[]" id="alert_' . $i . '" style="display:none;" title="' . $header_data[$j]['reminder_heading'] . '">

                                                    <option value="">' . $header_data[$j]['reminder_heading'] . '</option>

                                                    ' . $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'], '') . '

                                                </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="scale[]" id="scale_' . $i . '" style="display:none;" title="' . $header_data[$j]['scale_heading'] . '">

                                                <option value="">' . $header_data[$j]['scale_heading'] . '</option>

                                                <option value="1">1</option>

                                                <option value="2">2</option>

                                                <option value="3">3</option>

                                                <option value="4">4</option>

                                                <option value="5">5</option>

                                                <option value="6">6</option>

                                                <option value="7">7</option>

                                                <option value="8">8</option>

                                                <option value="9">9</option>

                                                <option value="10">10</option>

                                            </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="bes_time[]" id="bes_time_' . $i . '" style="display: none;">

                                                 <option value="">' . $design_my_life_data['time_heading'] . '</option>

                                                 ' . $obj->getTimeOptionsNew('0', '23', $bes_time) . '

                                             </select>';
                                $outputstr.= '<input type="text" name="duration[]" id="duration_' . $i . '" onKeyPress="return isNumberKey(event);" placeholder="' . $design_my_life_data['duration_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">';
                                $outputstr.= '<span class="">

                                          <select name="userdate[]" id="userdate_' . $i . '" onchange="toggleDateSelectionType_multiple(\'userdate_\',' . $i . ')" style="width:200px;display:none;" class="input-text-box input-quarter-width">

                                              <option value="">Select Date Type</option>

                                              <option value="days_of_month"';
                                if ($listing_date_type == 'days_of_month') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Days of Month</option><option value="single_date"';
                                if ($listing_date_type == 'single_date') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Single Date</option><option value="date_range"';
                                if ($listing_date_type == 'date_range') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Date Range</option> <option value="month_wise"';
                                if ($listing_date_type == 'month_wise') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Month Wise</option><option value="days_of_week"';
                                if ($listing_date_type == 'days_of_week') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Days of Week</option>

                                             </select>

                                             </span>

                                            <span>



                                          <p>&nbsp;</p>

                                            <table>

                                            <tr id="tr_days_of_month_' . $i . '" style="display:' . $tr_days_of_month . '">

                                                    <td align="right" valign="top"><strong>Select days of month</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="days_of_month" name="days_of_month[0][]" multiple="multiple" style="width:500px;" class="input-text-box input-quarter-width">';
                                for ($i = 1;$i <= 31;$i++) {
                                    $outputstr.= '<option value="' . $i . '"';
                                    if (in_array($i, $arr_days_of_month)) {
                                        $outputstr.= 'selected="selected"';
                                    }
                                    $outputstr.= '>' . $i . '</option>';
                                }
                                $outputstr.= '</select>&nbsp;*<br>

                                                   You can choose more than one option by using the ctrl key.

                                                  </td>

                                                 </tr>';
                                $outputstr.= '<tr id="tr_single_date_' . $i . '" style="display:' . $tr_single_date . '">

                                                    <td align="right" valign="top"><strong>Select Date</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <input name="single_date[]" id="single_date0" type="text" value="' . $single_date . '" class="input-text-box" onmouseover="callDatecalender(0)">';
                                $outputstr.= '</td>

                                                </tr>



                                                <tr id="tr_date_range_' . $i . '" style="display:' . $tr_date_range . '">

                                                    <td align="right" valign="top"><strong>Select Date Range</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <input name="start_date[]" id="start_date0" type="text" value="' . $start_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender(0)"/> - <input name="end_date[]" id="end_date0" type="text" value="' . $end_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender(0)"/>';
                                $outputstr.= '</td>

                                                </tr>



                                                <tr id="tr_days_of_week_' . $i . '" style="display:' . $tr_days_of_week . '">

                                                    <td align="right" valign="top"><strong>Select days of week</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="days_of_week" name="days_of_week[0][]" multiple="multiple" class="input-text-box">';
                                $outputstr.= $obj->getDayOfWeekOptionsMultiple($arr_days_of_week);
                                $outputstr.= '</select>&nbsp;*<br>

                                                        You can choose more than one option by using the ctrl key.

                                                    </td>

                                                </tr>';
                                $outputstr.= '<tr id="tr_month_date_' . $i . '" style="display:' . $tr_month_date . '">

                                                    <td align="right" valign="top"><strong>Select Month</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="months" name="months[0][]" multiple="multiple" class="input-text-box">';
                                $outputstr.= $obj->getMonthsOptionsMultiple($arr_month);
                                $outputstr.= '</select>&nbsp;*<br>

                                                        You can choose more than one option by using the ctrl key.

                                                    </td>

                                                </tr>

                                                </table>

                                            </div>';
                                // }
                                
                            }
                        }
                    }
                    $outputstr.= '<span style="margin-left:100px;" id="comment_backend_' . $i . '"></span>';
                    $outputstr.= '</div>';
                }
            }
            if ($design_my_life_data['input_box_show'] == 1) {
                $box_cnt = 0;
                $box_total_cnt = 1;
                for ($i = 0;$i <= $box_cnt;$i++) {
                    $child = ($i == 0 ? 'first' : $i);
                    $outputstr.= '

                                <div id="row_inp_' . $child . '">

                                <input type="hidden" name="box_cnt" id="box_cnt" value="' . $box_cnt . '">

                               <input type="hidden" name="box_total_cnt" id="box_total_cnt" value="' . $box_total_cnt . '">

                                <span>

                                   <input type="text" name="user_input[]" id="user_input_' . $i . '" placeholder="Type Your inputs" class="input-text-box " style="width:600px;" />';
                    if ($i == 0) {
                        $outputstr.= '<a href="javascript:void(0);" onclick="addMoreRowLoc();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a><br>';
                        $outputstr.= '&nbsp;&nbsp;<a href="javascript:void(0);" onclick="ShowloopLoc(0);"><i class="fa fa-eye" style="cursor: pointer;" id="eyes0" title="Click here for user action"></i></a>';
                        // echo "<pre>";print_r($header_data);echo "</pre>";
                        for ($j = 0;$j < count($header_data);$j++) {
                            $keyworddata_implode_data = array();
                            $exclusion_name = $obj->getExclusionAllName();
                            // echo $header_data[$j]['location_show']."".$header_data[$j]['User_view'].''.$header_data[$j]['User_Interaction'].''.$header_data[$j]['alert_show'].''.$header_data[$j]['comment_show'].''.$header_data[$j]['user_date_show'];
                            if ($header_data[$j]['location_show'] != 0) {
                                $location_show_icon = $obj->getMyDayTodayIcon('location_show');
                            } else {
                                $location_show_icon = '';
                            }
                            if ($header_data[$j]['User_view'] != 0) {
                                $User_view_icon = $obj->getMyDayTodayIcon('User_view');
                            } else {
                                $User_view_icon = '';
                            }
                            if ($header_data[$j]['User_Interaction'] != 0) {
                                $User_Interaction_icon = $obj->getMyDayTodayIcon('User_Interaction');
                            } else {
                                $User_Interaction_icon = '';
                            }
                            if ($header_data[$j]['alert_show'] != 0) {
                                $alert_show_icon = $obj->getMyDayTodayIcon('alert_show');
                            } else {
                                $alert_show_icon = '';
                            }
                            if ($header_data[$j]['comment_show'] != 0) {
                                $comment_show_icon = $obj->getMyDayTodayIcon('comments_show');
                            } else {
                                $comment_show_icon = '';
                            }
                            if ($header_data[$j]['user_date_show'] != 0) {
                                $user_date_icon = $obj->getMyDayTodayIcon('date_show');
                            } else {
                                $user_date_icon = '';
                            }
                            if ($header_data[$j]['scale_show'] != 0) {
                                $scale_show_icon = $obj->getMyDayTodayIcon('scale_show');
                            } else {
                                $scale_show_icon = '';
                            }
                            if ($header_data[$j]['time_show'] != 0) {
                                $time_show_icon = $obj->getMyDayTodayIcon('time_show');
                            } else {
                                $time_show_icon = '';
                            }
                            if ($header_data[$j]['duration_show'] != 0) {
                                $duration_show_icon = $obj->getMyDayTodayIcon('duration_show');
                            } else {
                                $duration_show_icon = '';
                            }
                            // echo $header_data[$j]['sub_cat2']."hiiii";
                            if ($header_data[$j]['sub_cat2'] != '') {
                                $fetch_show = $header_data[$j]['sub_cat2_show_fetch'];
                                if ($comment_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $comment_show_icon . '"  name="comment_show_icon_0" id="comment_show_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['comments_heading'] . '" onclick="ShowComment_Lo(0);">';
                                }
                                if ($location_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $location_show_icon . '"  name="location_show_icon_0" id="location_show_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['location_heading'] . '" onclick="ShowLocation_Lo(0);">';
                                }
                                if ($User_view_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_view_icon . '"  name="User_view_icon_0" id="User_view_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['like_dislike_heading'] . '" onclick="ShowUserview_Lo(0);">';
                                }
                                if ($User_Interaction_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_Interaction_icon . '"  name="User_Interaction_icon_0" id="User_Interaction_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['set_goals_heading'] . '" onclick="ShowUserInteraction_Lo(0);">';
                                }
                                if ($alert_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $alert_show_icon . '"  name="alert_show_icon_0" id="alert_show_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['reminder_heading'] . '" onclick="ShowAlert_Lo(0);">';
                                }
                                if ($scale_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $scale_show_icon . '"  name="scale_show_icon_lo0" id="scale_show_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['scale_heading'] . '" onclick="ShowScale_Lo(0);">';
                                }
                                if ($time_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $time_show_icon . '" name="time_show_icon_lo0" id="time_show_icon_lo0" style="width:25px; height: 25px; display:none;" title="Select ' . $header_data[$j]['time_heading'] . '" onclick="Showtime_Lo(0);">';
                                }
                                if ($duration_show_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $duration_show_icon . '"  name="duration_show_icon_lo0" id="duration_show_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['duration_heading'] . '" onclick="DurationShow_Lo(0);">';
                                }
                                if ($user_date_icon != '') {
                                    $outputstr.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $user_date_icon . '"  name="user_date_show_icon_0" id="user_date_show_icon_lo0" style="width:25px; height: 25px; display:none;" title="' . $header_data[$j]['user_date_heading'] . '" onclick="ShowUserDate_Lo(0);">';
                                }
                                $outputstr.= '</p>';
                                $outputstr.= '<div class="md-col-12">

                                                      <input type="hidden" name="sub_cat_lo[]"  value="' . $header_data[$j]['sub_cat2'] . '">';
                                $outputstr.= '<input type="hidden" name="prof_cat_lo[]"  value="' . $header_data[$j]['prof_cat2'] . '">';
                                $outputstr.= '<input type="hidden" name="canv_show_fetch_lo[]"  value="' . $header_data[$j]['sub_cat2_show_fetch'] . '">';
                                $outputstr.= '<input type="hidden" name="canv_sub_cat_link_lo[]"  value="' . $header_data[$j]['sub_cat2_link'] . '">';
                                $outputstr.= '<input  type="text" name="comment_lo[]" id="comment_lo0"  placeholder="' . $header_data[$j]['comments_heading'] . '" title="' . $header_data[$j]['comments_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="location_lo[]" id="location_lo0" style="display:none;" title="' . $header_data[$j]['location_heading'] . '">

                                                          <option value="">' . $header_data[$j]['location_heading'] . '</option>

                                                          ' . $obj->getFavCategoryRamakant($header_data[$j]['location_fav_cat'], '') . '

                                                      </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_view_lo[]" id="User_view_lo0" style="display:none;" title="' . $header_data[$j]['like_dislike_heading'] . '">

                                                          <option value="">' . $header_data[$j]['like_dislike_heading'] . '</option>

                                                          ' . $obj->getFavCategoryRamakant($header_data[$j]['user_response_fav_cat'], '') . '

                                                      </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_Interaction_lo[]" id="User_Interaction_lo0" style="display:none;" title="' . $header_data[$j]['set_goals_heading'] . '">

                                                          <option value="">' . $header_data[$j]['set_goals_heading'] . '</option>

                                                          ' . $obj->getFavCategoryRamakant($header_data[$j]['user_what_fav_cat'], '') . '

                                                      </select>';
                                $outputstr.= '<select class="input-text-box input-quarter-width" name="alert_lo[]" id="alert_lo0" style="display:none;" title="' . $header_data[$j]['reminder_heading'] . '">

                                                          <option value="">' . $header_data[$j]['reminder_heading'] . '</option>

                                                          ' . $obj->getFavCategoryRamakant($header_data[$j]['alerts_fav_cat'], '') . '

                                                      </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="scale_lo[]" id="scale_lo0" style="display:none;" title="' . $header_data[$j]['scale_heading'] . '">

                                                <option value="">' . $header_data[$j]['scale_heading'] . '</option>

                                                <option value="1">1</option>

                                                <option value="2">2</option>

                                                <option value="3">3</option>

                                                <option value="4">4</option>

                                                <option value="5">5</option>

                                                <option value="6">6</option>

                                                <option value="7">7</option>

                                                <option value="8">8</option>

                                                <option value="9">9</option>

                                                <option value="10">10</option>

                                            </select>';
                                $outputstr.= '<select  class="input-text-box input-quarter-width" name="bes_time_lo[]" id="bes_time_lo0" style="display: none;">

                                                 <option value="">' . $design_my_life_data['time_heading'] . '</option>

                                                 ' . $obj->getTimeOptionsNew('0', '23', $bes_time) . '

                                             </select>';
                                $outputstr.= '<input type="text" name="duration_lo[]" id="duration_lo0" onKeyPress="return isNumberKey(event);" placeholder="' . $design_my_life_data['duration_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">';
                                $outputstr.= '<span class="">

                                          <select name="userdate_lo[]" id="userdate_lo0" onchange="toggleDateSelectionType_multiple_lo(\'userdate_lo\',0)" style="width:200px;display:none;" class="input-text-box input-quarter-width">

                                              <option value="">Select Date Type</option>

                                              <option value="days_of_month"';
                                if ($listing_date_type == 'days_of_month') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Days of Month</option><option value="single_date"';
                                if ($listing_date_type == 'single_date') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Single Date</option><option value="date_range"';
                                if ($listing_date_type == 'date_range') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Date Range</option> <option value="month_wise"';
                                if ($listing_date_type == 'month_wise') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Month Wise</option><option value="days_of_week"';
                                if ($listing_date_type == 'days_of_week') {
                                    $outputstr.= 'selected="selected"';
                                }
                                $outputstr.= '>Days of Week</option>

                                             </select>

                                             </span>

                                            <span>



                                          <p>&nbsp;</p>

                                            <table>

                                            <tr id="tr_days_of_month_lo0" style="display:' . $tr_days_of_month . '">

                                                    <td align="right" valign="top"><strong>Select days of month</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="days_of_month_lo0" name="days_of_month_lo[0][]" multiple="multiple" style="width:500px;" class="input-text-box input-quarter-width">';
                                for ($i = 1;$i <= 31;$i++) {
                                    $outputstr.= '<option value="' . $i . '"';
                                    if (in_array($i, $arr_days_of_month)) {
                                        $outputstr.= 'selected="selected"';
                                    }
                                    $outputstr.= '>' . $i . '</option>';
                                }
                                $outputstr.= '</select>&nbsp;*<br>

                                                   You can choose more than one option by using the ctrl key.

                                                  </td>

                                                 </tr>';
                                $outputstr.= '<tr id="tr_single_date_lo0" style="display:' . $tr_single_date . '">

                                                    <td align="right" valign="top"><strong>Select Date</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <input name="single_date_lo[]" id="single_date_lo0" type="text" value="' . $single_date . '" class="input-text-box" onmouseover="callDatecalender(0)">';
                                $outputstr.= '</td>

                                                </tr>



                                                <tr id="tr_date_range_lo0" style="display:' . $tr_date_range . '">

                                                    <td align="right" valign="top"><strong>Select Date Range</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <input name="start_date_lo[]" id="start_date_lo0" type="text" value="' . $start_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender(0)"/> - <input name="end_date_lo[]" id="end_date_lo0" type="text" value="' . $end_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender(0)"/>';
                                $outputstr.= '</td>

                                                </tr>



                                                <tr id="tr_days_of_week_lo0" style="display:' . $tr_days_of_week . '">

                                                    <td align="right" valign="top"><strong>Select days of week</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="days_of_week_lo0" name="days_of_week_lo[0][]" multiple="multiple" class="input-text-box">';
                                $outputstr.= $obj->getDayOfWeekOptionsMultiple($arr_days_of_week);
                                $outputstr.= '</select>&nbsp;*<br>

                                                        You can choose more than one option by using the ctrl key.

                                                    </td>

                                                </tr>';
                                $outputstr.= '<tr id="tr_month_date_lo0" style="display:' . $tr_month_date . '">

                                                    <td align="right" valign="top"><strong>Select Month</strong></td>

                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                    <td align="left">

                                                        <select id="months_lo0" name="months_lo[0][]" multiple="multiple" class="input-text-box">';
                                $outputstr.= $obj->getMonthsOptionsMultiple($arr_month);
                                $outputstr.= '</select>&nbsp;*<br>

                                                        You can choose more than one option by using the ctrl key.

                                                    </td>

                                                </tr>

                                                </table>

                                            </div>';
                                // }
                                
                            }
                        }
                    } else {
                        $outputstr.= '<a href="javascript:void(0);" onclick="removeRowLoc(' . $i . ');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>';
                        // $outputstr .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="ShowloopLoc('.$i.');"><i class="fa fa-eye" style="cursor: pointer;" id="eyes0" title="Click here for user action"></i></a>';
                        
                    }
                    $outputstr.= '</span><br><br></div>';
                }
            }
            for ($l = 1;$l <= 11;$l++) {
                if ($design_my_life_data['image1_order_show'] == $l && $design_my_life_data['image_1_show'] == 1) {
                    $outputstr.= '<span class="">';
                    if ($design_my_life_data['image_type_1'] == 'Image') {
                        $outputstr.= '<img src="uploads/' . $design_my_life_data['image_1'] . '" style="width:200px; height: 200px;">';
                    }
                    if ($design_my_life_data['image_type_1'] == 'Video') {
                        $outputstr.= '<iframe width="200" height="200" src="https://www.youtube.com/embed/' . $design_my_life_data['video_link_1'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="false"></iframe>';
                    }
                    $outputstr.= '<br>

                                ' . $design_my_life_data['image_credit_1'] . '

                                -

                                ' . $design_my_life_data['image_credit_url_1'] . '

                            </span>

                            <br><br>';
                }
                if ($design_my_life_data['image2_order_show'] == $l && $design_my_life_data['image_2_show'] == 1) {
                    $outputstr.= '<span class="">';
                    if ($design_my_life_data['image_type_2'] == 'Image') {
                        $outputstr.= '<img src="uploads/' . $design_my_life_data['image_2'] . '" style="width:200px; height: 200px;">';
                    }
                    if ($design_my_life_data['image_type_2'] == 'Video') {
                        $outputstr.= '<iframe width="200" height="200" src="https://www.youtube.com/embed/' . $design_my_life_data['video_link_2'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="false"></iframe>';
                    }
                    $outputstr.= '<br>

                                ' . $design_my_life_data['image_credit_2'] . '

                               -

                                ' . $design_my_life_data['image_credit_url_2'] . '

                            </span>

                           <br><br>';
                }
                //uncomment ramakant on 21-06-2019
                if ($design_my_life_data['user_date_order_show'] == $l && $design_my_life_data['user_date_show'] == 1 && $design_my_life_data['user_date_order_show'] != '') {
                    $outputstr.= '<span class="">

                                      <!--<b>Date Selection:</b>-->

                                     <select name="listing_date_type" id="listing_date_type" class="input-text-box input-quarter-width" onchange="toggleDateSelectionType(\'listing_date_type\')"  title="' . $design_my_life_data['user_date_heading'] . '">

                                        <option value="">Select Date Type</option>

                                         <option value="days_of_month">Days of Month</option>

                                         <option value="single_date">Single Date</option>

                                         <option value="date_range">Date Range</option>

                                         <option value="month_wise">Month Wise</option>

                                         <option value="days_of_week">Days of Week</option>



                                     </select>

                                  </span>

                             <span>

                                 <table>

                                 <tr id="tr_days_of_month" style="margin-top:10px; display:' . $tr_days_of_month . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="days_of_month" name="days_of_month[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">';
                    for ($i = 1;$i <= 31;$i++) {
                        $outputstr.= '<option value="' . $i . '"';
                        if (in_array($i, $arr_days_of_month)) {
                            $outputstr.= 'selected="selected"';
                        }
                        $outputstr.= '>' . $i . '</option>';
                    }
                    $outputstr.= '</select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>

                                    

                                     <tr id="tr_single_date" style="margin-top:10px; display:' . $tr_single_date . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <input name="single_date" id="single_date" type="text" value="' . $single_date . '" class="input-text-box input-full-width" style="margin-top:20px;" placeholder="Select Date" />



                                             <script>$("#single_date").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>



                                         </td>



                                     </tr>



                                     <tr id="tr_date_range" style="margin-top:10px; display:' . $tr_date_range . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <input name="start_date" id="start_date" type="text" value="' . $start_date . '" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="Start Date"  /> - <input name="end_date" id="end_date" type="text" value="' . $end_date . '" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="End Date" />



                                             <script>$("#start_date").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"});$("#end_date").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>



                                         </td>



                                     </tr>



                                     <tr id="tr_days_of_week" style="margin-top:10px; display:' . $tr_days_of_week . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="days_of_week" name="days_of_week[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">



                                             ' . $obj->getDayOfWeekOptionsMultiple($arr_days_of_week) . '



                                             </select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>



                                     <tr id="tr_month_date" style="margin-top:10px; display:' . $tr_month_date . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="months" name="months[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">



                                             ' . $obj->getMonthsOptionsMultiple($arr_month) . ' 



                                             </select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>

                                    </table>

                             </span>

                             <br><br>';
                }
                if ($design_my_life_data['time_order_show'] == $l && $design_my_life_data['time_show'] == 1 && $design_my_life_data['time_order_show'] != '') {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="bes_time" id="bes_time" title="' . $design_my_life_data['time_heading'] . '">

                                     <option value="">' . $design_my_life_data['time_heading'] . '</option>

                                     ' . $obj->getTimeOptionsNew('0', '23', $bes_time) . '

                                </select>

                                 <br><br>';
                }
                if ($design_my_life_data['duration_order_show'] == $l && $design_my_life_data['duration_show'] == 1 && $design_my_life_data['duration_order_show'] != '') {
                    $outputstr.= '<input type="text" title="' . $design_my_life_data['duration_heading'] . '" name="duration" id="duration" onKeyPress="return isNumberKey(event);" placeholder="' . $design_my_life_data['duration_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false">

                             <br><br>';
                }
                if ($design_my_life_data['location_order_show'] == $l && $design_my_life_data['location_show'] == 1 && $design_my_life_data['location_order_show'] != '') {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="location" id="location" title="' . $design_my_life_data['location_heading'] . '">

                                     <option value="">' . $design_my_life_data['location_heading'] . '</option>

                                     ' . $obj->getFavCategoryRamakant($design_my_life_data['location_fav_cat'], '') . '

                                 </select> 

                                 <br><br>';
                }
                if ($design_my_life_data['like_dislike_order_show'] == $l && $design_my_life_data['User_view'] == 1 && $design_my_life_data['like_dislike_order_show'] != '') {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_view" id="User_view" title="' . $design_my_life_data['like_dislike_heading'] . '">

                                     <option value="">' . $design_my_life_data['like_dislike_heading'] . '</option>

                                     ' . $obj->getFavCategoryRamakant($design_my_life_data['user_response_fav_cat'], '') . '

                                 </select>

                                 <br><br>';
                }
                if ($design_my_life_data['set_goals_order_show'] == $l && $design_my_life_data['User_Interaction'] == 1 && $design_my_life_data['set_goals_order_show'] != '') {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_Interaction" id="User_Interaction" title="' . $design_my_life_data['set_goals_heading'] . '">

                                         <option value="">' . $design_my_life_data['set_goals_heading'] . '</option>

                                         ' . $obj->getFavCategoryRamakant($design_my_life_data['user_what_fav_cat'], '') . '

                                     </select>

                                     <br><br>';
                }
                if ($design_my_life_data['scale_order_show'] == $l && $design_my_life_data['scale_show'] == 1 && $design_my_life_data['scale_order_show'] != '') {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="scale" id="scale" title="' . $design_my_life_data['scale_heading'] . '">

                                         <option value="">' . $design_my_life_data['scale_heading'] . '</option>

                                         <option value="1">1</option>

                                         <option value="2">2</option>

                                         <option value="3">3</option>

                                         <option value="4">4</option>

                                         <option value="5">5</option>

                                         <option value="6">6</option>

                                         <option value="7">7</option>

                                         <option value="8">8</option>

                                         <option value="9">9</option>

                                         <option value="10">10</option>

                                     </select>

                                     <br><br>';
                }
                if ($design_my_life_data['reminder_order_show'] == $l && $design_my_life_data['alert_show'] == 1 && $design_my_life_data['reminder_order_show'] != '') {
                    $outputstr.= '<select class="input-text-box input-half-width" name="alert" id="alert" title="' . $design_my_life_data['reminder_heading'] . '">

                                         <option value="">' . $design_my_life_data['reminder_heading'] . '</option>

                                         ' . $obj->getFavCategoryRamakant($design_my_life_data['alerts_fav_cat'], '') . '

                                     </select>

                                     <br><br>';
                }
                if ($design_my_life_data['comment_order_show'] == $l && $design_my_life_data['comment_show'] == 1 && $design_my_life_data['comment_order_show'] != '') {
                    $outputstr.= '<textarea name="comment" title="' . $design_my_life_data['comments_heading'] . '" id="comment" class="input-text-box input-half-width" autocomplete="false" placeholder="' . $design_my_life_data['comments_heading'] . '" ></textarea>

                                     <br><br>';
                    $outputstr.= '<script> $("#comment").Editor(); </script>';
                }
            }
            //                             if($design_my_life_data['user_upload_show'] == 1)
            //
            //                             {
            //
            //                                 $outputstr .=' <a href="user_uploads.php?ref_code='.$ref_num.'&box_title='.$design_my_life_data['box_title'].'&sub_cat_id='.$sub_cat_id.'" class="active" target="_blank" title="We would like to hear your innovative suggestions."><span style="background: #007fff;color: #fff; border: 2px solid #4e4e4e; border-radius: 15px; height: 50px; padding: 5px;">Share your inputs</span></a>
            //
            //                                 <br><br>';
            //
            //
            //
            //                             }
            $outputstr.= '

                                <div style="text-align:center;">

                                <button type="submit" name="btn_submit" class="active" style="background-color:orange;">Save</button>

                                </div>

                                </form>

                                </div>';
        }
    }
    echo $outputstr;
    exit(0);
} else if ($action == 'getmodulewisekeywordsoptions') {
    $page_id = $_REQUEST['page_id'];
    $user_id = $_SESSION['user_id'];
    $page_link = $obj->getPageLinkByid($page_id);
    $keyword_option = '';
    if ($page_link == 'design-my-life.php') {
        $keyword_option = $obj->GETMYDESIGNKEWORD($user_id);
    }
    if ($page_link == 'mycanvas.php') {
        $keyword_option = $obj->GETMYCANVASKEWORD($user_id);
    }
    if ($page_link == 'my_day_today.php') {
        $keyword_option = $obj->GETMYDAYTODAYKEWORD($user_id);
    }
    echo $keyword_option;
    exit(0);
} elseif ($action == 'showacceptinvitationpopup') {
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $puid = stripslashes($_REQUEST['puid']);
    $user_id = $_SESSION['user_id'];
    $error = '0';
    $err_msg = '';
    $output = '';
    $output = $obj->showAcceptInvitationPopup($user_id, $ar_id, $puid);
    echo $output;
} elseif ($action == 'showPatternsPopup') {
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $vid = stripslashes($_REQUEST['vid']);
    $user_id = $_SESSION['user_id'];
    $error = '0';
    $err_msg = '';
    $output = '';
    $output = $obj->showPatternsPopup($user_id, $ar_id, $vid);
    echo $output;
} elseif ($action == 'doacceptadviserinvitation') {
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $report_id = stripslashes($_REQUEST['report_id']);
    $permission_type = stripslashes($_REQUEST['permission_type']);
    $user_id = $_SESSION['user_id'];
    $puid = stripslashes($_REQUEST['puid']);
    $error = '0';
    $err_msg = '';
    $output = '';
    // echo "hiiii";
    // echo "<pre>";print_r($permission_type);echo "</pre>";
    // exit;
    $output = $obj->doAcceptAdviserInvitation($ar_id, $report_id, $user_id, $puid,$permission_type=""); //,$permission_type
    // exit;
    echo $output;
} elseif ($action == 'doDeclineAdviserInvitation') {
    $status_reason = "";
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $user_id = $_SESSION['user_id'];
    $puid = stripslashes($_REQUEST['puid']);
    $status_reason = stripslashes($_REQUEST['status_reason']);
    $error = '0';
    $err_msg = '';
    $output = '';
    $output = $obj->doDeclineAdviserInvitation($ar_id, $user_id, $puid, $status_reason);
    echo $output;
} elseif ($action == 'showdeactivateadviserinvitationpopup') {
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $puid = stripslashes($_REQUEST['puid']);
    $error = '0';
    $err_msg = '';
    $output = '';
    $vendor = stripslashes($_REQUEST['vid']);
    $output = $obj->showDeactivateAdviserInvitationPopup($ar_id, $puid, $vendor);
    echo $output;
} elseif ($action == 'deactivateadviserinvitation') {
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $puid = stripslashes($_REQUEST['puid']);
    $user_id = $_SESSION['user_id'];
    $status_reason = stripslashes($_REQUEST['status_reason']);
    $error = '0';
    $err_msg = '';
    $output = '';
    $vid = stripslashes($_REQUEST['vid']);
    $output = $obj->deactivateAdviserInvitation($ar_id, $user_id, $vid, $status_reason);
    echo $output;
} elseif ($action == 'showactivateadviserinvitationpopup') {
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $puid = stripslashes($_REQUEST['puid']);
    $error = '0';
    $err_msg = '';
    $output = '';
    $vendor_id = stripslashes($_REQUEST['vid']);
    // echo $vendor_id;
    // exit;
    $output = $obj->showActivateAdviserInvitationPopup($ar_id, $puid, $vendor_id);
    echo $output;
} elseif ($action == 'activateadviserinvitation') {
    $ar_id = stripslashes($_REQUEST['ar_id']);
    $puid = stripslashes($_REQUEST['puid']);
    $user_id = $_SESSION['user_id'];
    $status_reason = stripslashes($_REQUEST['status_reason']);
    $error = '0';
    $err_msg = '';
    $output = '';
    $vendor_id = stripslashes($_REQUEST['vid']);
    // echo $vendor_id;
    // exit;
    $output = $obj->activateAdviserInvitation($ar_id, $user_id, $vendor_id, $status_reason);
    echo $output;
} elseif ($action == 'showadviserquerypopup') {
    $parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
    $page_id = stripslashes($_REQUEST['page_id']);
    //add by ample 03-03-20
    $vendor_id = stripslashes($_REQUEST['vendor_id']);
    $output = '';
    if (!$obj->isLoggedIn()) {
        $ref = base64_encode('my_wellness_guidence.php');
        $output = '<span class="Header_brown">You must login before add query.Please <a href="login.php?ref=' . $ref . '">Click here</a> to Login.</span>';
    } else {
        $user_id = $_SESSION['user_id'];
        $user_upa_id = $obj->getupaid($page_id);
        $plan_flag = $obj->Checkifplanexist($user_upa_id);
        if ($plan_flag) {
            if ($obj->chkUserPlanFeaturePermission($user_id, $user_upa_id)) {
                $output = $obj->showAdviserQueryPopup($user_id, $parent_aq_id,$vendor_id);
            } else {
                $output = '<span class="Header_brown">' . $obj->getCommonSettingValue('3') . '</span>';
            }
        } else {
            $output = $obj->showAdviserQueryPopup($user_id, $parent_aq_id,$vendor_id);
        }
    }
    echo $output;
}
elseif ($action == 'showSelfQueryPopup') {
    $parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
     $output = '';
    $query_data = $obj->getAdviserQueryDetails($parent_aq_id);
    $temp_page_id = $query_data[0]['page_id'] . '|' . $query_data[0]['page_table'];
    $page_id = $query_data[0]['page_id'];
    $page_tbl = $query_data[0]['page_table'];

    $output.= '<form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" name="parent_aq_id" id="parent_aq_id" value="' . $parent_aq_id . '" />
                <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">';
    $output.= '<tr>
                    <td width="60%" height="40" align="left" valign="top">Adviser:</td>
                    <td width="40%" height="40" align="left" valign="top">' . $obj->getProUserFullNameById($query_data[0]["vendor_id"]) . '
                    </td>
                </tr>
                <tr>
                    <td width="60%" height="40" align="left" valign="top">Reference:</td>
                    <td width="40%" height="40" align="left" valign="top" id="idreference">' . $obj->getReferenceName($page_id,$page_tbl) . '
                     </td>
                </tr>';
    $output.= '<tr>

                    <td width="60%" height="110" align="left" valign="top">Last Query:</td>
                    <td width="40%" height="110" align="left" valign="top">' . $query_data[0]["query"] . '
                    </td>
                </tr>
                <tr>

                    <td width="60%" height="110" align="left" valign="top">Update Query:</td>
                    <td width="40%" height="110" align="left" valign="top">
                    <textarea id="feedback_text_new" name="feedback_text_new" style="width:200px;height:100px;"></textarea>
                    <textarea id="feedback_text_old" name="feedback_text_old" style="width:200px;height:100px;display:none;">' . $query_data[0]["query"] . '</textarea>
                    </td>
                </tr>
                <tr>
                    <td width="60%" height="40" align="left" valign="middle">&nbsp;</td>
                    <td width="40%" height="40" align="left" valign="middle">
                    <input name="submit" type="button" class="button" id="submit" value="Update"  onclick="updateAdviserQuery()"/>
                    </td>
                </tr>   
                </table>
                </form>';
    echo $output;
}
//add by ample 23-07-20
elseif ($action == 'redirectQueryPopup') {
  
     $output = '';
     $user_id = $_SESSION['user_id'];
     $title = stripslashes($_REQUEST['title']);

    $output.= '<form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data"><input type="hidden" name="parent_aq_id" id="parent_aq_id" value="0" /><table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">';
    $output.= '<tr> <td width="60%" height="40" align="left" valign="top">Adviser:</td><td width="40%" height="40" align="left" valign="top"><select id="temp_pro_user_id" name="temp_pro_user_id" style="width:150px;"><option value="">Select Adviser</option> ' . $obj->getUsersAcceptedAdviserOptionsNew($user_id, "") . '</select> </td></tr> <tr><td width="60%" height="40" align="left" valign="top">Reference:</td> <td width="40%" height="40" align="left" valign="top" id="idreference"><select id="temp_page_id" name="temp_page_id"  style="width:150px;"> <option value="">Select Reference</option> ' . $obj->getAdviserQueryReference($user_id,'') . ' </select> </td> </tr>';
    $output.= '<tr> <td width="60%" height="110" align="left" valign="top">Your Query:</td><td width="40%" height="110" align="left" valign="top"> <textarea id="feedback_text" name="feedback_text" style="width:200px;height:100px;">'.$title.'</textarea></td> </tr> <tr> <td width="60%" height="40" align="left" valign="middle">&nbsp;</td> <td width="40%" height="40" align="left" valign="middle"> <input name="submit" type="button" class="button" id="submit" value="Save"  onclick="addAdviserQueryNew()"/>  </td> </tr>    </table> </form>';
    echo $output;
}
 elseif ($action == 'addadviserquery') {
    $parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
    $temp_pro_user_id = stripslashes($_REQUEST['temp_pro_user_id']);
    $temp_page_id = stripslashes($_REQUEST['temp_page_id']);
    $name = stripslashes($_REQUEST['name']);
    $email = stripslashes($_REQUEST['email']);
    $query = stripslashes($_REQUEST['query']);
    if ($obj->isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '0';
    }
    $error = '0';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    //if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
    {
        $error = '1';
        $msg = 'Please enter valid email';
        $output = $error . '::' . $msg;
    } else {
        $from_user = '1';
        if ($obj->addAdviserQuery($parent_aq_id, $temp_page_id, $user_id, $name, $email, $temp_pro_user_id, $from_user, $query)) {
            $error = '2';
            $msg = 'Your Query has been forwarded to your Adviser (' . $obj->getProUserFullNameById($temp_pro_user_id) . ')\'s Message Box for his/her Guidance to you';
            $output = $error . '::' . $msg;
        }
    }
    echo $output;
} 
//add by ample 23-07-20
 elseif ($action == 'addadviserqueryNew') {
    $parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
    $temp_pro_user_id = stripslashes($_REQUEST['temp_pro_user_id']);
    $temp_page_id = stripslashes($_REQUEST['temp_page_id']);
    
    $query = stripslashes($_REQUEST['query']);
    if ($obj->isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '0';
    }

    $name = $obj->getUserFullNameById($user_id);
    $email = $obj->getUserEmailById($user_id);
    $from_user='1';
    $error = '1';
  
    $from_user = '1';
    if ($obj->addAdviserQuery($parent_aq_id, $temp_page_id, $user_id, $name, $email, $temp_pro_user_id, $from_user, $query)) {
        $error = '0';
        $msg = 'Your Query has been forwarded to your Adviser (' . $obj->getProUserFullNameById($temp_pro_user_id) . ')\'s Message Box for his/her Guidance to you';
        $output = $error . '::' . $msg;
    }
    else
    {   
        $msg='try later';
        $output = $error . '::' . $msg;
    }

    $_SESSION['adviser_query_pro_user_id']=$temp_pro_user_id;
    $_SESSION['adviser_query_start_date']=date('d-m-Y');
    $_SESSION['adviser_query_end_date']=date('d-m-Y');
    
    echo $output;
} 
//add by ample 06-04-20
elseif ($action == 'updateAdviserQuery') {
    $aq_id = stripslashes($_REQUEST['parent_aq_id']);
    $query_old = stripslashes($_REQUEST['query_old']);
    $query_new = stripslashes($_REQUEST['query_new']);

    $dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata')); 
    $current= $dateTime->format("d-M-y  h:i A"); 

    $query=$query_old.'<br>'.$current. ': '.$query_new;

    echo $obj->updateAdviserQuery($aq_id, $query);
}

elseif ($action == 'viewadviserpopup') {
    $output = '';
    $vendor_id = stripslashes($_REQUEST['vid']);

    $vendor = $obj2->getUserDetailsPro($vendor_id);

    $output.= '<div style="">

        <table cellpadding="0" cellspacing="0" width="100%" align="center" border="0">

          <tr>

            <td colspan="3" height="30" align="right" valign="top">&nbsp;</td>

          </tr>

           <tr>

            <td width="40%" height="40" align="right" valign="top"><strong>Adviser Name</strong></td>

            <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>

            <td width="55%" height="40" align="left" valign="top">' . $vendor["vendor_name"] . '</td>

          </tr>

          <tr>

            <td width="40%" height="40" align="right" valign="top"><strong>Adviser Email</strong></td>

            <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>

            <td width="55%" height="40" align="left" valign="top">' . $vendor["vendor_email"] . '</td>

          </tr>

          <tr>

            <td height="40" align="right" valign="top"><strong>Adviser Phone</strong></td>

            <td height="40" align="center" valign="top"><strong>:</strong></td>

            <td height="40" align="left" valign="top">' . $vendor["vendor_mobile"] . '</td>

          </tr>

        </table> </div>';

    echo $output;
    
} 
//update by ample
elseif ($action == 'feedback_form') {
    $page_id=$_POST['page_id'];
    $output = '';
    $output.= '<form id="frm_feedback" name="frm_feedback" method="post" action="#" enctype="multipart/form-data">
                
                <input type="hidden" name="hdn_p_id" id="hdn_p_id" value="0" />                    
                             <table cellpadding="0" cellspacing="0" width="80%" align="center" border="0" style="margin-top:-75%;">                  
                                 <tr>                            
                                     <td width="40%" height="40" align="left" valign="top">Subject:</td>                            
                                     <td width="60%" height="40" align="left" valign="top"><select class="form-control" id="temp_page_id" name="temp_page_id">  ' . $obj->getFeeadBackPagesNew($page_id) . ' </select> </td>                        
                                </tr>';
    if ($obj->isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $name = $obj->getUserFullNameById($user_id);
        $email = $obj->getUserEmailById($user_id);
        $readonly = ' readonly ';
    } else {
        $readonly = '';
    }
    $output.= '<tr> 
                                     <td width="40%" height="40" align="left" valign="top">Name:</td>                            
                                     <td width="60%" height="40" align="left" valign="top"><input class="form-control" type="text" id="name" name="name" ' . $readonly . ' value="' . $name . '" /></td>                        
                                 </tr>                        
                                 <tr>                         
                                     <td width="40%" height="40" align="left" valign="top">Email:</td>                            
                                     <td width="60%" height="40" align="left" valign="top"> <input class="form-control" type="email" id="email" name="email" ' . $readonly . ' value="' . $email . '" /></td>                        
                                 </tr>                        
                                 <tr>                         
                                     <td width="40%" height="110" align="left" valign="top">Feedback and Suggestions:</td>                            
                                     <td width="60%" height="110" align="left" valign="top"> <textarea class="form-control" cols="30" rows="5" type="text" id="feedback" name="feedback">' . $textarea . '</textarea> </td>                        
                                 </tr>                        
                                 <tr>                         
                                     <td width="40%" height="40" align="left" valign="middle">&nbsp;</td>                            
                                     <td width="60%" height="40" align="left" valign="middle"> <input name="submit" type="button" class="btn btn-primary" id="submit" value="Submit"  onclick="GetFeedback()" /></td>                        
                                 </tr>                       
                             </table>                
                         </form>';
    echo $output;
    // echo "<pre>";print_r($output);echo "</pre>";
    
} 
//add by ample
elseif ($action == 'feedback_form_reply') {
    $feedback_id=$_POST['feedback_id'];

    $data=$obj->get_feedback_data($feedback_id);

    // print_r($data); die();

    $output = '';
    $output.= '<form id="frm_feedback_reply" name="frm_feedback_reply" method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" name="page_id" id="page_id" value="'.$data["page_id"].'" /> 
                <input type="hidden" name="parent_id" id="parent_id" value="'.$data["parent_feedback_id"].'" />                    
                             <table cellpadding="0" cellspacing="0" width="80%" align="center" border="0" style="margin-top:-75%;">                  
                                 <tr>                            
                                     <td width="40%" height="40" align="left" valign="top">Subject:</td>                            
                                     <td width="60%" height="40" align="left" valign="top">';

                                     if(empty($data["page_id"]) || $data["page_id"]==0)
                                        {
                                            $output.= 'General';
                                        }
                                        else
                                        {
                                            $output.=$obj->getPageTitle($data["page_id"]);
                                        }
                                    $output.= '</td>   
                      
                                </tr>   
                                <tr>                         
                                     <td width="40%" height="40" align="left" valign="top">Admin Reply:</td>                            
                                     <td width="60%" height="40" align="left" valign="top"> '.$data["feedback"].'</textarea> </td>                        
                                 </tr>                     
                                 <tr>                         
                                     <td width="40%" height="110" align="left" valign="top">Your Reply:</td>                            
                                     <td width="60%" height="110" align="left" valign="top"> <textarea class="form-control" cols="30" rows="5" type="text" id="feedback" name="feedback" requird></textarea> </td>                        
                                 </tr>                        
                                 <tr>                         
                                     <td width="40%" height="40" align="left" valign="middle">&nbsp;</td>                            
                                     <td width="60%" height="40" align="left" valign="middle"> <input name="submit" type="button" class="btn btn-primary" id="submit" value="Submit"  onclick="feedback_reply()" /></td>                        
                                 </tr>                       
                             </table>                
                         </form>';
    echo $output;
    
} 
//add by ample
elseif ($action == 'feedback_form_update') {
    $feedback_id=$_POST['feedback_id'];

    $data=$obj->get_feedback_data($feedback_id);

    // print_r($data); die();

    $output = '';
    $output.= '<form id="frm_feedback_update" name="frm_feedback_update" method="post" action="#" enctype="multipart/form-data">

                <input type="hidden" name="feedback_id" id="feedback_id" value="'.$feedback_id.'" />                    
                             <table cellpadding="0" cellspacing="0" width="80%" align="center" border="0" style="margin-top:-70%;">                  
                                 <tr>                            
                                     <td width="40%" height="40" align="left" valign="top">Subject:</td>                            
                                     <td width="60%" height="40" align="left" valign="top"> ';
                                        
                                        if(empty($data["page_id"]) || $data["page_id"]==0)
                                        {
                                            $output.= 'General';
                                        }
                                        else
                                        {
                                            $output.=$obj->getPageTitle($data["page_id"]);
                                        }
                                    $output.= '</td>                        
                                </tr>   
                                <tr>                         
                                     <td width="40%" height="40" align="left" valign="top">Your Reply:</td>                            
                                     <td width="60%" height="40" align="left" valign="top"> '.$data["feedback"].'</textarea> </td>                        
                                 </tr>                     
                                 <tr>                         
                                     <td width="40%" height="110" align="left" valign="top">Your Reply Update:</td>                            
                                     <td width="60%" height="110" align="left" valign="top"> 
                                     <textarea class="form-control" cols="30" rows="5" type="text" id="feedback_new" name="feedback_new" requird></textarea> 
                                     <textarea class="form-control" cols="30" rows="5" type="feedback_old" id="feedback_old" name="feedback" style="display:none;" requird>'.$data["feedback"].'</textarea> 
                                     </td>                        
                                 </tr>                        
                                 <tr>                         
                                     <td width="40%" height="40" align="left" valign="middle">&nbsp;</td>                            
                                     <td width="60%" height="40" align="left" valign="middle"> <input name="submit" type="button" class="btn btn-primary" id="submit" value="Submit"  onclick="feedback_update()" /></td>                        
                                 </tr>                       
                             </table>                
                         </form>';
    echo $output;
    
} elseif ($action == 'getRecordNameDetailsKR') {
    $obj2 = new frontclass();
    $recored = $_REQUEST['recored_id'];
    $data = $obj2->getRecordData($recored);
    echo $data;
} elseif ($action == 'myLifepatternKR') {
    $DBH = new DatabaseHandler();
    $obj2 = new frontclass();
    $recored = $_REQUEST['arr'];
    $select_repoert_name = "SELECT * FROM `tbl_recordshow_dropdown` WHERE `uniqu_id`='" . $recored['report_name'] . "'";
    $STH1 = $DBH->query($select_repoert_name);
    $row1 = $STH1->fetch(PDO::FETCH_ASSOC);
    $arr = array('report' => $recored, 'report_name' => $row1['report_name']);
    echo json_encode($arr);
} elseif ($action == 'showrewardcatlog') {
    $obj2 = new frontclass();
    $module_id = stripslashes($_REQUEST['module_id']);
    $error = '0';
    $err_msg = '';
    $output = '';
    $output = $obj2->showRewardCatlog($module_id);
    echo $output;
} elseif ($action == 'viewallmoduleredeampopup') {
    $obj2 = new frontclass();
    $error = '0';
    $err_msg = '';
    $output = '';
    $summary_reward_module_id = stripslashes($_REQUEST['summary_reward_module_id']);
    $summary_reward_module_title = stripslashes($_REQUEST['summary_reward_module_title']);
    $summary_total_balance_points = stripslashes($_REQUEST['summary_total_balance_points']);
    $user_id = $_SESSION['user_id'];
    $summary_reward_module_id = substr($summary_reward_module_id, 0, -1);
    $summary_reward_module_title = substr($summary_reward_module_title, 0, -1);
    $summary_total_balance_points = substr($summary_total_balance_points, 0, -1);
    $arr_summary_reward_module_id = explode(',', $summary_reward_module_id);
    $arr_summary_reward_module_title = explode(',', $summary_reward_module_title);
    $arr_summary_total_balance_points = explode(',', $summary_total_balance_points);
    $output = $obj2->viewAllModuleRedeamPopup($user_id, $arr_summary_reward_module_id, $arr_summary_reward_module_title, $arr_summary_total_balance_points);
    echo $output;
} elseif ($action == 'viewentriesdetailslist') {
    $error = '0';
    $err_msg = '';
    $output = '';
    $start_date = stripslashes($_REQUEST['start_date']);
    $end_date = stripslashes($_REQUEST['end_date']);
    $reward_module_id = stripslashes($_REQUEST['reward_module_id']);
    $user_id = $_SESSION['user_id'];
    //$end_date = date('Y-m-t',strtotime($start_date));
    $output = $obj->viewEntriesDetailsList($user_id, $start_date, $end_date, $reward_module_id);
    echo $output;
} else if ($action == 'getdatadropdown') {
    $day_month_year = date("Y-m-d");
    $sub_cat_id = $_REQUEST['sub_cat_id'];
    $get_design_data = $obj->GETDesignData($sub_cat_id, $day_month_year);
    $outputstr = '';
    if (count($get_design_data) > 0) {
        for ($j = 0;$j < count($get_design_data);$j++) {
            $design_my_life_data = $obj->GetDesignMyLifeDatabyRef($get_design_data[$j]['ref_code']);
            $symtum_cat = $design_my_life_data['sub_cat2'];
            $sub_cat2_show_fetch = $design_my_life_data['sub_cat2_show_fetch'];
            $sub_cat2_link = $design_my_life_data['sub_cat2_link'];
            $data_dropdown = $obj->GetDesignMyLifeDrop($symtum_cat, $sub_cat2_show_fetch, $sub_cat2_link);
        }
    }
    echo $data_dropdown;
    exit(0);
} else if ($action == 'getRecordNameDetailscriteriakr') {
    $obj2 = new frontclass();
    $recored = $_REQUEST['recored_id'];
    $data = $obj2->getRecordDataCriteria($recored);
    echo $data;
} else if ($action == 'getRecordNameDetails_sub_criteriakr') {
    $obj2 = new frontclass();
    $recored = $_REQUEST['recored_id'];
    $data = $obj2->getRecordData_sub_Criteria($recored);
    // echo "<pre>";print_r($data);echo "</pre>";
    echo $data;
} else if ($action == 'getRecordNameDetails_parameter_kr') {
    $obj2 = new frontclass();
    $recored = $_REQUEST['recored_id'];
    $data = $obj2->getRecordData_parameters($recored);
    echo $data;
} elseif ($action == 'removefromcart') {
    $obj2 = new frontclass();
    $cart_id = '';
    if (isset($_POST['cart_id']) && trim($_POST['cart_id']) != '') {
        $cart_id = trim($_POST['cart_id']);
    }
    $error = 0;
    $err_msg = '';
    if ($cart_id != '') {
        if ($obj2->removeFromCart($cart_id)) {
            $error = 0;
            $err_msg = 'Item removed successfully';
        } else {
            $error = 1;
            $err_msg = 'Something went wrong, Please try again later.';
        }
    } else {
        $error = 1;
        $err_msg = 'Please select any item';
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg;
    echo $ret_str;
} elseif ($action == 'updatecartsingleitem') {
    $obj2 = new frontclass();
    $cusine_id = '';
    if (isset($_POST['cusine_id']) && trim($_POST['cusine_id']) != '') {
        $cusine_id = trim($_POST['cusine_id']);
    }
    $qty = '';
    if (isset($_POST['qty']) && trim($_POST['qty']) != '') {
        $qty = trim($_POST['qty']);
    }
    $delivery_date = '';
    if (isset($_POST['delivery_date']) && trim($_POST['delivery_date']) != '') {
        $delivery_date = trim($_POST['delivery_date']);
    }
    $typess = '';
    if (isset($_POST['typess']) && trim($_POST['typess']) != '') {
        $typess = trim($_POST['typess']);
    }
    $error = 0;
    $err_msg = '';
    if ($cusine_id != '') {
        if ($qty != '') {
            if ($obj2->chkIfCusineQtyAvailable($cusine_id, $qty)) {
                if ($obj2->updateCartSingleItem($cusine_id, $qty, $delivery_date, $typess)) {
                    $error = 0;
                    $err_msg = 'Item updated successfully';
                } else {
                    $error = 1;
                    $err_msg = 'Something went wrong, Please try again later.';
                }
            } else {
                $error = 1;
                $err_msg = 'Sorry currently this quantity not available';
            }
        } else {
            $error = 1;
            $err_msg = 'Invalid quantity';
        }
    } else {
        $error = 1;
        $err_msg = 'Please select any item';
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg;
    echo $ret_str;
    // echo 'htttttt44444';
    // exit;
    
} else if ($action == 'home_set_pop') {
    $valid = $_REQUEST['valid'];
    if (isset($_SESSION['home_pop']) == "") {
        $_SESSION['home_pop'] = $valid;
    } else {
        $_SESSION['home_pop'] = "0";
    }
    echo $_SESSION['home_pop'];
} elseif ($action == 'getsidecartbox') {
    $obj2 = new frontclass();
    $output = $obj2->getSideCartBox();
    $ret_str = $test . '::::' . $output;
    echo $ret_str;
    // echo "<pre>";print_r($output);echo "</pre>";
    // exit;
    
} elseif ($action == 'getsidecartboxcheckout') {
    $obj2 = new frontclass();
    $output = $obj2->getSideCartBoxCheckout();
    $ret_str = $test . '::::' . $output;
    echo $ret_str;
} elseif ($action == 'docheckoutsavedeliveryaddress') {
    $obj2 = new frontclass();
    $delivery_name = '';
    if (isset($_POST['delivery_name']) && trim($_POST['delivery_name']) != '') {
        $delivery_name = trim($_POST['delivery_name']);
    }
    $delivery_building_name = '';
    if (isset($_POST['delivery_building_name']) && trim($_POST['delivery_building_name']) != '') {
        $delivery_building_name = trim($_POST['delivery_building_name']);
    }
    $delivery_floor_no = '';
    if (isset($_POST['delivery_floor_no']) && trim($_POST['delivery_floor_no']) != '') {
        $delivery_floor_no = trim($_POST['delivery_floor_no']);
    }
    $delivery_address_line1 = '';
    if (isset($_POST['delivery_address_line1']) && trim($_POST['delivery_address_line1']) != '') {
        $delivery_address_line1 = trim($_POST['delivery_address_line1']);
    }
    $delivery_landmark = '';
    if (isset($_POST['delivery_landmark']) && trim($_POST['delivery_landmark']) != '') {
        $delivery_landmark = trim($_POST['delivery_landmark']);
    }
    $delivery_city_id = '';
    if (isset($_POST['delivery_city_id']) && trim($_POST['delivery_city_id']) != '') {
        $delivery_city_id = trim($_POST['delivery_city_id']);
    }
    $delivery_area_id = '';
    if (isset($_POST['delivery_area_id']) && trim($_POST['delivery_area_id']) != '') {
        $delivery_area_id = trim($_POST['delivery_area_id']);
    }
    $delivery_mobile_no = '';
    if (isset($_POST['delivery_mobile_no']) && trim($_POST['delivery_mobile_no']) != '') {
        $delivery_mobile_no = trim($_POST['delivery_mobile_no']);
    }
    $delivery_pincode = '';
    if (isset($_POST['delivery_pincode']) && trim($_POST['delivery_pincode']) != '') {
        $delivery_pincode = trim($_POST['delivery_pincode']);
    }
    $billing_name = '';
    if (isset($_POST['billing_name']) && trim($_POST['billing_name']) != '') {
        $billing_name = trim($_POST['billing_name']);
    }
    $billing_building_name = '';
    if (isset($_POST['billing_building_name']) && trim($_POST['billing_building_name']) != '') {
        $billing_building_name = trim($_POST['billing_building_name']);
    }
    $billing_floor_no = '';
    if (isset($_POST['billing_floor_no']) && trim($_POST['billing_floor_no']) != '') {
        $billing_floor_no = trim($_POST['billing_floor_no']);
    }
    $billing_address_line1 = '';
    if (isset($_POST['billing_address_line1']) && trim($_POST['billing_address_line1']) != '') {
        $billing_address_line1 = trim($_POST['billing_address_line1']);
    }
    $billing_landmark = '';
    if (isset($_POST['billing_landmark']) && trim($_POST['billing_landmark']) != '') {
        $billing_landmark = trim($_POST['billing_landmark']);
    }
    $billing_city_id = '';
    if (isset($_POST['billing_city_id']) && trim($_POST['billing_city_id']) != '') {
        $billing_city_id = trim($_POST['billing_city_id']);
    }
    $billing_area_id = '';
    if (isset($_POST['billing_area_id']) && trim($_POST['billing_area_id']) != '') {
        $billing_area_id = trim($_POST['billing_area_id']);
    }
    $billing_mobile_no = '';
    if (isset($_POST['billing_mobile_no']) && trim($_POST['billing_mobile_no']) != '') {
        $billing_mobile_no = trim($_POST['billing_mobile_no']);
    }
    $billing_pincode = '';
    if (isset($_POST['billing_pincode']) && trim($_POST['billing_pincode']) != '') {
        $billing_pincode = trim($_POST['billing_pincode']);
    }
    $error = 0;
    $err_msg = '';
    if ($delivery_name == '') {
        $error = 1;
        $err_msg = 'Please enter delivery name.';
    } elseif ($delivery_building_name == '') {
        $error = 1;
        $err_msg = 'Please enter flat number/house number, building name for delivery address.';
    } elseif ($delivery_address_line1 == '') {
        $error = 1;
        $err_msg = 'Please enter address line 1 for delivery address';
    } elseif ($delivery_city_id == '' || $delivery_city_id == '0' || $delivery_city_id == 'undefined') {
        $error = 1;
        $err_msg = 'Please enter delivery city/town';
    } elseif ($delivery_area_id == '' || $delivery_area_id == '0' || $delivery_area_id == 'undefined') {
        $error = 1;
        $err_msg = 'Please enter delivery area';
    } elseif ($delivery_mobile_no == '') {
        $error = 1;
        $err_msg = 'Please enter mobile no for delivery address';
    } elseif ((!is_numeric($delivery_mobile_no)) || (strlen($delivery_mobile_no) != 10)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only for delivery address';
    } elseif (!preg_match("/^[0-9]+$/", $delivery_mobile_no)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only for delivery address!';
    } elseif ($delivery_pincode == '') {
        //$error = 1;
        //$err_msg = 'Please enter pincode';
        
    } elseif ($billing_name == '') {
        $error = 1;
        $err_msg = 'Please enter billing name.';
    } elseif ($billing_building_name == '') {
        $error = 1;
        $err_msg = 'Please enter flat number/house number, building name for billing address.';
    } elseif ($billing_address_line1 == '') {
        $error = 1;
        $err_msg = 'Please enter address line 1 for billing address';
    } elseif ($billing_city_id == '' || $billing_city_id == '0' || $billing_city_id == 'undefined') {
        $error = 1;
        $err_msg = 'Please enter billing city/town';
    } elseif ($billing_area_id == '' || $billing_area_id == '0' || $billing_area_id == 'undefined') {
        $error = 1;
        $err_msg = 'Please enter billing area';
    } elseif ($billing_mobile_no == '') {
        $error = 1;
        $err_msg = 'Please enter mobile no for billing address';
    } elseif ((!is_numeric($billing_mobile_no)) || (strlen($billing_mobile_no) != 10)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only for billing address';
    } elseif (!preg_match("/^[0-9]+$/", $billing_mobile_no)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only for billing address!';
    } elseif ($billing_pincode == '') {
        //$error = 1;
        //$err_msg = 'Please enter pincode';
        
    } else {
        // echo $_SESSION['topcityid'];
        // exit;
        if (isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '') {
            $topcityid = $_SESSION['topcityid'];
        } else {
            $topcityid = '0';
        }
        if (isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '') {
            $topareaid = $_SESSION['topareaid'];
        } else {
            $topareaid = '0';
        }
        if ($delivery_city_id != $topcityid) {
            $error = 1;
            $err_msg = 'Sorry this item(s) currently not avilable in city/town which you selected for delivery';
        } else {
            /*
            
            if($topareaid != '' && $topareaid != '0' && $topareaid != '-1')
            
            {
            
                if($delivery_area_id != '' && $delivery_area_id != '0' && $delivery_area_id != $topareaid)
            
                {
            
                    $error = 1;
            
                    $err_msg = 'Sorry this item(s) currently not avilable in area of city/town which you selected for delivery';
            
                }
            
            }
            
            */
        }
    }
    // echo "<pre>";print_r($delivery_city_id);echo "</pre>";
    //         exit;
    if ($error == '0') {
        if ($obj2->isLoggedIn()) {
            $tdata = array();
            $tdata['user_id'] = $_SESSION['user_id'];
            $tdata['delivery_name'] = $delivery_name;
            $tdata['building_name'] = $delivery_building_name;
            $tdata['floor_no'] = $delivery_floor_no;
            $tdata['landmark'] = $delivery_landmark;
            $tdata['address'] = $delivery_address_line1;
            $tdata['country_id'] = $obj2->getCountryIdOfCityId($delivery_city_id);
            $tdata['state_id'] = $obj2->getStateIdOfCityId($delivery_city_id);
            $tdata['city_id'] = $delivery_city_id;
            $tdata['area_id'] = $delivery_area_id;
            $tdata['delivery_mobile_no'] = $delivery_mobile_no;
            $tdata['pincode'] = $delivery_pincode;
            $tdata['billing_name'] = $billing_name;
            $tdata['billing_building_name'] = $billing_building_name;
            $tdata['billing_floor_no'] = $billing_floor_no;
            $tdata['billing_landmark'] = $billing_landmark;
            $tdata['billing_address'] = $billing_address_line1;
            $tdata['billing_country_id'] = $obj2->getCountryIdOfCityId($billing_city_id);
            $tdata['billing_state_id'] = $obj2->getStateIdOfCityId($billing_city_id);
            $tdata['billing_city_id'] = $billing_city_id;
            $tdata['billing_area_id'] = $billing_area_id;
            $tdata['billing_mobile_no'] = $billing_mobile_no;
            $tdata['billing_pincode'] = $billing_pincode;
            if ($obj2->updateUserAddressDetails($tdata)) {
                $error = 0;
            } else {
                // echo "<pre>";print_r('hi');echo "</pre>";
                // exit;
                $error = 1;
                $err_msg = 'Something went wrong, Please try again later.';
            }
        } else {
            // echo "<pre>";print_r('hi2');echo "</pre>";
            // exit;
            $error = 1;
            $err_msg = 'Something went wrong, Please try again later!';
        }
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg;
    // echo "<pre>";print_r($ret_str);echo "</pre>";
    //         exit;
    echo $ret_str;
} elseif ($action == 'docheckoutlogin') {
    $obj2 = new frontclass();
    $email = '';
    if (isset($_POST['email']) && trim($_POST['email']) != '') {
        $email = trim($_POST['email']);
    }
    $password = '';
    if (isset($_POST['password']) && trim($_POST['password']) != '') {
        $password = trim($_POST['password']);
    }
    $ref_url = '';
    if (isset($_POST['ref_url']) && trim($_POST['ref_url']) != '') {
        $ref_url = trim($_POST['ref_url']);
    }
    $error = 0;
    $err_msg = '';
    if ($email == '') {
        $error = 1;
        $err_msg = 'Please enter email';
    } elseif ($password == '') {
        $error = 1;
        $err_msg = 'Please enter password';
    }
    $ref_url_go = '';
    if ($error == '0') {
        // $va=$obj2->chkValidUserLogin($email,$password);
        // echo "<pre>";print_r($va);echo "</pre>";
        // exit;
        if ($obj2->chkValidLogin($email, $password)) {
            //   echo "<pre>";print_r('ji');echo "<pre>";
            // exit;
            if ($obj2->doLogin($email)) {
                $error = 0;
                if (isset($ref_url) && $ref_url != '') {
                    $ref_url_go = urldecode(base64_decode($ref_url));
                } else {
                    $ref_url_go = SITE_URL . '/my_account.php';
                }
            } else {
                $error = 1;
                $err_msg = 'Something went wrong, Please try again later.';
            }
        } else {
            $error = 1;
            $err_msg = 'Invalid login details';
        }
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg . '::::' . $ref_url_go;
    echo $ret_str;
} elseif ($action == 'dochangepassword') {
    $obj2 = new frontclass();
    $opassword = '';
    if (isset($_POST['opassword']) && trim($_POST['opassword']) != '') {
        $opassword = trim($_POST['opassword']);
    }
    $npassword = '';
    if (isset($_POST['npassword']) && trim($_POST['npassword']) != '') {
        $npassword = trim($_POST['npassword']);
    }
    $cpassword = '';
    if (isset($_POST['cpassword']) && trim($_POST['cpassword']) != '') {
        $cpassword = trim($_POST['cpassword']);
    }
    $error = 0;
    $err_msg = '';
    $url = '';
    $user_id = $_SESSION['user_id'];
    if ($user_id > 0) {
        $arr_temp_user = $obj2->getUserDetails($user_id);
        $vpassword = $arr_temp_user['password'];
        // echo "<pre>";print_r($vpassword);echo "</pre>";
        if ($opassword == '') {
            $error = 1;
            $err_msg = 'Please enter current password';
        } elseif (md5($opassword) != $vpassword) {
            $error = 1;
            $err_msg = 'Wrong current password';
        } elseif ($npassword == '') {
            $error = 1;
            $err_msg = 'Please enter new password';
        } elseif ($cpassword == '') {
            $error = 1;
            $err_msg = 'Please enter confirm password';
        } elseif ($npassword != $cpassword) {
            $error = 1;
            $err_msg = 'Please enter same confirm password';
        }
        if ($error == '0') {
            $tdata = array();
            $tdata['password'] = $npassword;
            $tdata['user_id'] = $user_id;
            if ($obj2->changeUserPassword($tdata)) {
                $error = 0;
                $url = SITE_URL . '/messages.php?id=4';
            } else {
                $error = 1;
                $err_msg = 'Something went wrong, Please try again later!';
            }
        }
    } else {
        $error = 1;
        $err_msg = 'Invalid access';
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg . '::::' . $url;
    echo $ret_str;
} elseif ($action == 'docheckoutsignup') {
    $obj2 = new frontclass();
    $signup_first_name = '';
    if (isset($_POST['signup_first_name']) && trim($_POST['signup_first_name']) != '') {
        $signup_first_name = trim($_POST['signup_first_name']);
    }
    $signup_last_name = '';
    if (isset($_POST['signup_last_name']) && trim($_POST['signup_last_name']) != '') {
        $signup_last_name = trim($_POST['signup_last_name']);
    }
    $signup_middle_name = '';
    if (isset($_POST['signup_middle_name']) && trim($_POST['signup_middle_name']) != '') {
        $signup_middle_name = trim($_POST['signup_middle_name']);
    }
    $signup_email = '';
    if (isset($_POST['signup_email']) && trim($_POST['signup_email']) != '') {
        $signup_email = trim($_POST['signup_email']);
    }
    $signup_mobile_no = '';
    if (isset($_POST['signup_mobile_no']) && trim($_POST['signup_mobile_no']) != '') {
        $signup_mobile_no = trim($_POST['signup_mobile_no']);
    }
    $sex = '';
    if (isset($_POST['sex']) && trim($_POST['sex']) != '') {
        $sex = trim($_POST['sex']);
    }
    $signup_city = '';
    if (isset($_POST['signup_city']) && trim($_POST['signup_city']) != '') {
        $signup_city = trim($_POST['signup_city']);
    }
    $signup_location = '';
    if (isset($_POST['signup_location']) && trim($_POST['signup_location']) != '') {
        $signup_location = trim($_POST['signup_location']);
    }
    $signup_password = '';
    if (isset($_POST['signup_password']) && trim($_POST['signup_password']) != '') {
        $signup_password = trim($_POST['signup_password']);
    }
    $error = 0;
    $err_msg = '';
    if ($signup_first_name == '') {
        $error = 1;
        $err_msg = 'Please enter first name';
    } elseif ($signup_last_name == '') {
        $error = 1;
        $err_msg = 'Please enter last name';
    } elseif ($signup_middle_name == '') {
        $error = 1;
        $err_msg = 'Please enter middle name';
    } elseif ($signup_email == '') {
        $error = 1;
        $err_msg = 'Please enter email';
    } elseif (filter_var($signup_email, FILTER_VALIDATE_EMAIL) === false) {
        $error = 1;
        $err_msg = 'Please enter valid email';
    } elseif ($obj2->chkEmailExists($signup_email)) {
        $error = true;
        $err_msg = 'This email already registered. Please login with this account, If you forgot password <a href="' . SITE_URL . '/forgot_password.php' . '">Click here</a> to reset new password';
    } elseif ($signup_mobile_no == '') {
        $error = 1;
        $err_msg = 'Please enter mobile no';
    } elseif ($obj2->chkMobileNoExists($signup_mobile_no)) {
        $error = true;
        $err_msg = 'This mobile number already registered. Please login with this account, If you forgot password <a href="' . SITE_URL . '/forgot_password.php' . '">Click here</a> to reset new password';
    } elseif ($sex == '') {
        $error = 1;
        $err_msg = 'Please select gender';
    } elseif ((!is_numeric($signup_mobile_no)) || (strlen($signup_mobile_no) != 10)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only';
    } elseif (!preg_match("/^[0-9]+$/", $signup_mobile_no)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only!';
    } elseif ($signup_city == '') {
        $error = 1;
        $err_msg = 'Please select city';
    } elseif ($signup_location == '') {
        $error = 1;
        $err_msg = 'Please select location ';
    } elseif ($signup_password == '') {
        $error = 1;
        $err_msg = 'Please enter password';
    }
    $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string_shuffled = str_shuffle($string);
    $otp = substr($string_shuffled, 1, 6);
    if ($error == '0') {
        $tdata = array();
        $tdata['first_name'] = $signup_first_name;
        $tdata['middel_name'] = $signup_middle_name;
        $tdata['last_name'] = $signup_last_name;
        $tdata['email'] = $signup_email;
        $tdata['mobile_no'] = $signup_mobile_no;
        $tdata['sex'] = $sex;
        $tdata['signup_city'] = $signup_city;
        $tdata['signup_location'] = $signup_location;
        $tdata['password'] = $signup_password;
        $tdata['user_status'] = '0';
        $tdata['is_guest_user'] = '0';
        $tdata['user_otp'] = $otp;
        // $name,$middle_name,$last_name,$gender,$email,$mobile,$city_id,$place_id,$password,$otp
        // $user_id = $obj2->doCheckoutSignUp($tdata);
        $user_id = $obj2->signUpUser($tdata['first_name'], $tdata['middel_name'], $tdata['last_name'], $tdata['sex'], $tdata['email'], $tdata['mobile_no'], $tdata['signup_city'], $tdata['signup_location'], $tdata['password'], $tdata['user_otp']);
        // echo "<pre>";print_r($user_id);echo "</pre>";
        // exit;
        if ($user_id > 0) {
            $tdata_sms = array();
            $tdata_sms['mobile_no'] = $signup_mobile_no;
            $tdata_sms['sms_message'] = $obj2->getOTPSmsText($tdata);
            $obj2->sendSMS($tdata_sms);
            $error = 0;
        } else {
            $error = 1;
            $err_msg = 'Something went wrong, Please try again later!';
        }
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg;
    echo $ret_str;
} elseif ($action == 'doverifyotp') {
    $obj2 = new frontclass();
    $user_otp = '';
    if (isset($_POST['user_otp']) && trim($_POST['user_otp']) != '') {
        $user_otp = trim($_POST['user_otp']);
    }
    $signup_email = '';
    if (isset($_POST['email']) && trim($_POST['email']) != '') {
        $signup_email = trim($_POST['email']);
    }
    $signup_mobile_no = '';
    if (isset($_POST['mobile_no']) && trim($_POST['mobile_no']) != '') {
        $signup_mobile_no = trim($_POST['mobile_no']);
    }
    $error = 0;
    $err_msg = '';
    if ($user_otp == '') {
        $error = 1;
        $err_msg = 'Please enter 4 digits otp';
    } elseif ($signup_email == '') {
        $error = 1;
        $err_msg = 'Please enter email';
    } elseif (filter_var($signup_email, FILTER_VALIDATE_EMAIL) === false) {
        $error = 1;
        $err_msg = 'Please enter valid email';
    } elseif (!$obj2->chkEmailExists($signup_email)) {
        $error = true;
        $err_msg = 'This email not registered';
    } elseif ($signup_mobile_no == '') {
        $error = 1;
        $err_msg = 'Please enter mobile no';
    } elseif (!$obj2->chkMobileNoExists($signup_mobile_no)) {
        $error = true;
        $err_msg = 'This mobile number not registered';
    } elseif ((!is_numeric($signup_mobile_no)) || (strlen($signup_mobile_no) != 10)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only';
    } elseif (!preg_match("/^[0-9]+$/", $signup_mobile_no)) {
        $error = 1;
        $err_msg = 'Please enter valid 10 digits numbers only!';
    }
    if ($error == '0') {
        $tdata = array();
        $tdata['user_otp'] = $user_otp;
        $tdata['email'] = $signup_email;
        $tdata['mobile_no'] = $signup_mobile_no;
        $tdata['is_guest_user'] = '0';
        if ($obj2->doVerifyOTP($tdata)) {
            $obj2->sendSignUpEmailToCustomer($signup_email);
            if ($obj2->doLogin($signup_email)) {
                $error = 0;
            } else {
                $error = 1;
                $err_msg = 'Something went wrong, Please try again later.';
            }
        } else {
            $error = 1;
            $err_msg = 'Invalid otp entry!';
        }
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg;
    echo $ret_str;
} elseif ($action == 'getfeedback') {
    $obj2 = new frontclass();
    $page_id = stripslashes($_REQUEST['page_id']);
    $name = stripslashes($_REQUEST['name']);
    $email = stripslashes($_REQUEST['email']);
    $feedback = stripslashes($_REQUEST['feedback']);
    $parent_id = stripslashes($_REQUEST['parent_id']);
    if ($obj2->isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '0';
    }
    $error = '0';
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error = '1';
        $msg = 'Please enter valid email';
        $output = $error.'::'.$msg;
    }
    else
    if ($obj2->InsertFeedback($parent_id, $page_id, $name, $email, $feedback, $user_id)) {
        $error = '2';
        $msg = 'Thank You For Your Feedback/Suggestion';
        $output = $error . '::' . $msg;
    }
    // echo"<pre>";print_r($email);echo "<pre>";
    // exit;
    // }
    echo $output;
} 
//add by ample 15-04-20
elseif ($action == 'feedback_reply_save') {
    $obj2 = new frontclass();
    $page_id = stripslashes($_REQUEST['page_id']);
    $feedback = stripslashes($_REQUEST['feedback']);
    $parent_id = stripslashes($_REQUEST['parent_id']);

    $user_id=$_SESSION['user_id'];
    $name = $obj->getUserFullNameById($user_id);
    $email = $obj->getUserEmailById($user_id);

    echo $obj2->InsertFeedback($parent_id, $page_id, $name, $email, $feedback, $user_id);

    echo $output;
}
//add by ample 15-04-20
elseif ($action == 'feedback_update_save') {
    $feedback_id = stripslashes($_REQUEST['feedback_id']);
    $feedback_old = stripslashes($_REQUEST['feedback_old']);
    $feedback_new = stripslashes($_REQUEST['feedback_new']);

    $dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata')); 
    $current= $dateTime->format("d-M-y  h:i A"); 

    $feedback=$feedback_old.'<br><br>'.$current. ': '.$feedback_new;

    echo $obj->feedback_update($feedback_id, $feedback);
} elseif ($action == 'setdeliverylocation') {
    $obj2 = new frontclass();
    $deliverycityid = '';
    if (isset($_POST['deliverycityid']) && trim($_POST['deliverycityid']) != '') {
        $deliverycityid = trim($_POST['deliverycityid']);
    }
    $deliveryareaid = '';
    if (isset($_POST['deliveryareaid']) && trim($_POST['deliveryareaid']) != '') {
        $deliveryareaid = trim($_POST['deliveryareaid']);
    }
    $error = 0;
    $err_msg = '';
    $deliverylocationstr = '';
    $deliverypincode = '';
    if ($deliverycityid == '' || $deliverycityid == 'null') {
        $error = 1;
        $err_msg = 'Please enter delivery city/town';
    } elseif ($deliveryareaid == '' || $deliveryareaid == 'null') {
        $error = 1;
        $err_msg = 'Please enter delivery area';
    } else {
        if ($obj2->chkIfValidCityId($deliverycityid)) {
            if (isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '') {
                $topcityid = $_SESSION['topcityid'];
            } else {
                $topcityid = '0';
            }
            if (isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '') {
                $topareaid = $_SESSION['topareaid'];
            } else {
                $topareaid = '0';
            }
            // echo "<pre>";print_r($topareaid);echo "</pre>";
            if ($deliverycityid != $topcityid) {
                $error = 1;
                $err_msg = 'Sorry this item(s) currently not avilable in city/town which you selected for delivery';
            } else {
                if ($deliveryareaid == '') {
                    $deliverylocationstr = $obj2->getTopLocationStr($deliverycityid, $deliveryareaid);
                } else {
                    if ($obj2->chkIfValidAreaId($deliveryareaid)) {
                        $deliverylocationstr = $obj2->getTopLocationStr($deliverycityid, $deliveryareaid);
                        $deliverypincode = $obj2->getPincodeOfArea($deliveryareaid);
                        /*
                        
                        if($topareaid != '' && $topareaid != '0' && $topareaid != '-1')
                        
                        {
                        
                            if($deliveryareaid != '' && $deliveryareaid != '0' && $deliveryareaid != $topareaid)
                        
                            {
                        
                                $error = 1;
                        
                                $err_msg = 'Sorry this item(s) currently not avilable in area of city/town which you selected for delivery';
                        
                            }
                        
                        }
                        
                        */
                    } else {
                        $error = 1;
                        $err_msg = 'Invalid area';
                    }
                }
            }
        } else {
            $error = 1;
            $err_msg = 'Invalid city';
        }
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg . '::::' . $deliverylocationstr . '::::' . $deliverypincode;
    echo $ret_str;
} elseif ($action == 'setbillinglocation') {
    $obj2 = new frontclass();
    $deliverycityid = '';
    if (isset($_POST['deliverycityid']) && trim($_POST['deliverycityid']) != '') {
        $deliverycityid = trim($_POST['deliverycityid']);
    }
    $deliveryareaid = '';
    if (isset($_POST['deliveryareaid']) && trim($_POST['deliveryareaid']) != '') {
        $deliveryareaid = trim($_POST['deliveryareaid']);
    }
    $error = 0;
    $err_msg = '';
    $deliverylocationstr = '';
    $deliverypincode = '';
    if ($deliverycityid == '' || $deliverycityid == 'null') {
        $error = 1;
        $err_msg = 'Please enter billing city/town';
    } elseif ($deliveryareaid == '' || $deliveryareaid == 'null') {
        $error = 1;
        $err_msg = 'Please enter billing area';
    } else {
        if ($obj2->chkIfValidCityId($deliverycityid)) {
            if ($deliveryareaid == '') {
                $deliverylocationstr = $obj2->getTopLocationStr($deliverycityid, $deliveryareaid);
            } else {
                if ($obj2->chkIfValidAreaId($deliveryareaid)) {
                    $deliverylocationstr = $obj2->getTopLocationStr($deliverycityid, $deliveryareaid);
                    $deliverypincode = $obj2->getPincodeOfArea($deliveryareaid);
                } else {
                    $error = 1;
                    $err_msg = 'Invalid area';
                }
            }
        } else {
            $error = 1;
            $err_msg = 'Invalid city';
        }
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg . '::::' . $deliverylocationstr . '::::' . $deliverypincode;
    echo $ret_str;
} elseif ($action == 'doapplydiscountcoupon') {
    $discount_coupon = '';
    if (isset($_POST['discount_coupon']) && trim($_POST['discount_coupon']) != '') {
        $discount_coupon = trim($_POST['discount_coupon']);
    }
    $error = 0;
    $err_msg = '';
    if ($discount_coupon != '') {
        if ($obj->chkIfValidDiscountCoupon($discount_coupon)) {
            // echo "<pre>";print_r($r);echo "</pre>";
            if ($obj->doApplyDiscountCoupon($discount_coupon)) {
                // echo "<pre>";print_r($discount_coupon);echo "</pre>";
                // exit;
                $error = 0;
                $err_msg = 'coupon applied successfully';
            } else {
                $error = 1;
                $err_msg = 'Something went wrong, Please try again later.';
            }
        } else {
            $error = 1;
            $err_msg = 'This coupon is invalid';
        }
    } else {
        $error = 1;
        $err_msg = 'Please enter coupon';
    }
    $ret_str = $test . '::::' . $error . '::::' . $err_msg;
    echo $ret_str;
}
elseif($action == 'getactivitiesrows')
{   

    // print_r('expression');die;

    $today_wakeup_time = stripslashes($_REQUEST['today_wakeup_time']);
    
    $mins_id_arr = stripslashes($_REQUEST['mins_id_arr']);
    $mins_arr = explode(",",$mins_id_arr);
    
    $activity_id_arr = stripslashes($_REQUEST['activity_id_arr']);
    $activity_id_arr = explode(",",$activity_id_arr);
    
    $other_activity_arr = stripslashes($_REQUEST['other_activity_arr']);
    $other_activity_arr = explode(",",$other_activity_arr);
    
    $proper_guidance_arr = stripslashes($_REQUEST['proper_guidance_arr']);
    $proper_guidance_arr = explode(",",$proper_guidance_arr);
    
    $precaution_arr = stripslashes($_REQUEST['precaution_arr']);
    $precaution_arr = explode(",",$precaution_arr);
    
    $tr_err_activity = stripslashes($_REQUEST['tr_err_activity']);
    $tr_err_activity = explode(",",$tr_err_activity);
    
    $err_activity = stripslashes($_REQUEST['err_activity']);
    $err_activity = explode(",",$err_activity);
    
    $skip_time_arr = stripslashes($_REQUEST['skip_time_arr']);
    $skip_time_arr = explode(",",$skip_time_arr);
    
    $today_end_time = '24:00 PM';

    $ret_str = $obj->getActivitiesRows($today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$tr_err_activity,$err_activity,$skip_time_arr);

    //print_r($ret_str); die();

    $arr_activity_time = $obj->getActivityTimeList($today_wakeup_time,$today_end_time,15,$mins_arr,$skip_time_arr);
    $cnt = count($arr_activity_time);
    //debug_array($activity_id_arr);
    //debug_array($arr_activity_time);
    $activity_prefill_arr = array();
    // for($i=0;$i<count($activity_id_arr);$i++)
    // {
    //     if($activity_id_arr[$i] == '') 
    //     {
    //         $tmp_prefill_arr  = '{}';
    //     }
    //     else
    //     { 
    //         $json = array();
    //         $json['value'] = $activity_id_arr[$i];
    //         $json['name'] = $obj->getDailyActivityName($activity_id_arr[$i]);
    //         $tmp_prefill_arr = json_encode($json);
    //     }
        
    //     array_push($activity_prefill_arr ,getPreFillList($tmp_prefill_arr));
    // }   
    
    $activity_id_str = implode("***",$activity_prefill_arr);    
    
    //debug_array($activity_id_str);
    echo $ret_str.'::::'.$cnt.'::::'.$activity_id_str;
}

elseif($action == 'getactivitiesrowsnewdate')

{

    $day = stripslashes($_REQUEST['day']);

    $month = stripslashes($_REQUEST['month']);

    $year = stripslashes($_REQUEST['year']);

    $user_id = $_SESSION['user_id'];

    $activity_date = $year.'-'.$month.'-'.$day;

    $tr_err_activity = array();

    $tr_other_activity = array();

    $err_activity = array();

    $activity_prefill_arr = array();

    $skip_time_arr = array();

    

    list($yesterday_sleep_time,$today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$activity_time_arr) = $obj->getUsersDailyActivityDetails($user_id,$activity_date);

    

    if(count($mins_arr)> 0)

    {

        $flagnewdate = true;

        $cnt = count($mins_arr);

        $totalRow = count($mins_arr);

        

        for($i=0;$i<$cnt;$i++)

        {

            $skip_time_arr[$i] = $activity_time_arr[$i];

            $tr_err_activity[$i] = 'none';

            $err_activity[$i] = '';

            

            if($activity_id_arr[$i] == '9999999999')

            {

                $tr_other_activity[$i] = '';

                $json = array();

                $json['value'] = $activity_id_arr[$i];

                $json['name'] = $obj->getDailyActivityName($activity_id_arr[$i]);

                array_push($activity_prefill_arr ,json_encode($json));

            }

            elseif( ($activity_id_arr[$i] == '') || ($activity_id_arr[$i] == '0') )

            {

                $tr_other_activity[$i] = 'none';

                array_push($activity_prefill_arr ,'{}');

            }

            else

            {

                $tr_other_activity[$i] = 'none';

                $json = array();

                $json['value'] = $activity_id_arr[$i];

                $json['name'] = $obj->getDailyActivityName($activity_id_arr[$i]);

                array_push($activity_prefill_arr ,json_encode($json));

            }   

        }   

        array_push($activity_id_arr ,'0');

        array_push($mins_arr ,'');

        array_push($skip_time_arr ,'');

        array_push($activity_prefill_arr ,'{}');

        $cnt++;

        $totalRow++;

    }

    else

    {

        $cnt = '1';

        $totalRow = '1';

        $tr_err_activity[0] = 'none';

        $tr_other_activity[0] = 'none';

        $err_activity[0] = '';

        array_push($activity_prefill_arr ,'{}');

        $skip_time_arr[0] = $today_wakeup_time;

    }



    $today_end_time = '24:00 PM';

    $ret_str = $obj->getActivitiesRows($today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$tr_err_activity,$err_activity,$skip_time_arr);

    

    $arr_activity_time = $obj->getActivityTimeList($today_wakeup_time,$today_end_time,15,$mins_arr,$skip_time_arr);

    $cnt = count($arr_activity_time);

    

    $activity_prefill_arr = implode("***",$activity_prefill_arr);   

    

    echo $ret_str.'::::'.$cnt.'::::'.$activity_prefill_arr.'::::'.$yesterday_sleep_time.'::::'.$today_wakeup_time;

}
// add by ample 14-02-20
else if($action=='saveCanvasPreview')
{
    //print_r($_POST);

    $mdt_date=$_POST['mdt_date'];
    $sequence=$_POST['sequence'];
    $user_id=$_POST['user_id'];
    $html=$_POST['html'];

    $res=$obj->saveMycanvasPreviewData($user_id,$sequence,$mdt_date,$html);

    echo $res;


}
//add by ample 05-03-20 (find in old backup)
elseif($action == 'togglereadunreadquery')
{
    $tgaction = stripslashes($_REQUEST['tgaction']);
    $aq_id = stripslashes($_REQUEST['idval']);
    $user_id = $_SESSION['user_id'];
    
    if($tgaction == 'read')
    {
        $output=$obj->setUserQueryRead($aq_id,$user_id,'1');
    }
    elseif($tgaction == 'unread')
    {
        $output=$obj->setUserQueryRead($aq_id,$user_id,'0');
    }   

    echo $output;
}

// else if($action=='mycolumnname')
// {
//     $obj2 = new frontclass();
//     $module_criteria=$_REQUEST['module_criteria'];
//     $data=$obj2->getcolumns_detrails($module_criteria);
//      echo $data;
// }
// else if($action=='autodropdown_keyword')
// {
// }
// else if($action=='getcolums_name_value')
// {
//      $capitals = $_REQUEST['capitals'];
//     $obj2 = new frontclass();
//     $data=$obj2->getcolumsname($capitals);
//      echo $data;
// }

//add by ample 17-03-20 (find in old backup)
elseif($action == 'getActivitiesSection')
{
    //print_r($_POST); 

    // echo $dates= $obj->getTimeOptionsNew('4','24');

    // print_r($dates);

    $wake_up_time=$_POST['wake_up_time'];
    $total_row=$_POST['total_row'];

    $html="";

    $html.='<div class="row" id="row'.$total_row.'">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label class="label Header_brown">Activity</label>
                          <input name="activity[]" type="text" class="form-control" id="activity_'.$total_row.'"  list="capitals'.$total_row.'" autocomplete="off" onchange="activity_datalist('.$total_row.')"  />
                                    <datalist id="capitals'.$total_row.'" class="dlist" >
                                                   ' . $obj->get_activity_data() . '
                                        </datalist>
                            <input type="hidden" name="activity_id[]" id="activity_id_'.$total_row.'">
                            <a href="javascript:void(0);" onclick="erase_input('.$total_row.');"><i class="fa fa-eraser" aria-hidden="true" style="font-size: 15px; display:block;"></i></a>
                        </div>
                        <div class="col-md-6 row">
                           <label class="label Header_brown">Other Activity</label>
                           <input type="text" name="other_activity[]" class="form-control">
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-3">
                          <label class="label Header_brown">Activity Time Start</label>
                          <!--<select class="form-control" id="start_time_'.$total_row.'" name="start_time[]" onchange="calculate_time_duration('.$total_row.')" required>'.$obj->get_times('00:00','23:30').' </select>-->
                          <!-- change as per email 29-04-20 -->
                          <input type="time" class="form-control" id="start_time_'.$total_row.'" name="start_time[]" onchange="calculate_time_duration('.$total_row.')" required />
                        </div>
                        <div class="col-md-3">
                           <label class="label Header_brown">Activity Time End</label>
                           <!--<select class="form-control" id="end_time_'.$total_row.'" name="end_time[]" onchange="calculate_time_duration('.$total_row.')" required>'.$obj->get_times('00:15','23:45').' </select>-->
                           <!-- change as per email 29-04-20 -->
                          <input type="time" class="form-control" id="end_time_'.$total_row.'" name="end_time[]" onchange="calculate_time_duration('.$total_row.')" required />
                        </div>
                        <div class="col-md-6">
                            <label class="label Header_brown">Duration</label>
                           <input type="text" id="duration_text_'.$total_row.'" name="duration_text[]" class="form-control" disabled>
                           <input type="hidden" id="duration_'.$total_row.'" name="duration[]" class="form-control">
                        </div>
                        <div class="col-md-12">
                         <p class="text-danger" id="time_note_0" style="font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red;    text-decoration: underline;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></p>
                      </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="label Header_brown">My View</label>
                            <select class="form-control" name="user_response[]">'.$obj->getCategoryOptions('46').'</select>
                        </div>
                        <div class="col-md-4">
                          <label class="label Header_brown">Activity Location Type</label>
                          <select class="form-control" name="location_type[]">'.$obj->getCategoryOptions('40').'</select>
                        </div>
                        <div class="col-md-4">
                           <label class="label Header_brown">Activity Location</label>
                           <select class="form-control" name="location_id[]">'.$obj->getCategoryOptions('21').'</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group Header_brown">
                            <br>
                             <span class="Header_brown">Do you do under proper guidance?</span>
                            <label class="radio-inline Header_brown"><input type="radio" name="proper_guidance_'.$total_row.'" value="1">Yes</label>
                            <label class="radio-inline Header_brown"><input type="radio" name="proper_guidance_'.$total_row.'" value="0" checked>No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label Header_brown">(Including any Precaution taken)</label>
                                <textarea class="form-control" rows="3" name="precaution[]"></textarea>
                            </div>
                        </div>
                    </div>';
                    if($total_row==0)
                    {
                        $html.='<button type="button" class="btn btn-info btn-xs add_more_activity" onclick="add_more_activity()">Add More</button>';
                    }
                    else
                    {
                        $html.='<button type="button" class="btn btn-warning btn-xs remove_activity" onclick="remove_activity('.$total_row.')">Remove</button>';
                    }
                    $html.='<hr>
                </div>
                <div class="col-md-1">
                </div>
            </div>';

    echo $html;
}
elseif ($action == 'checkActivityData') {

    $date_set=date("Y-m-d", strtotime($_POST['date_set']));
    $user_id = $_SESSION['user_id'];
    //add by ample 11-06-20
    $title_set = base64_decode($_POST['title_set']);

    $act_data=$obj->check_already_fill_activity($user_id,$date_set);

    if (!empty($title_set)) {
        $html=$obj->get_other_activity_html_data($title_set,0);
        if(!empty($act_data))
        {
            $response = array('status' => true, 'message' => 'Fill this other activity data!','html'=>$html,'count'=>0,'redirect'=>1,'have_data'=>1,'yesterday_sleep_time'=>$act_data[0]['yesterday_sleep_time'],'today_wakeup_time'=>$act_data[0]['today_wakeup_time'],'sleep_duration'=>$act_data[0]['sleep_duration']);
        }
        else
        {
            $response = array('status' => true, 'message' => 'Fill this other activity data!','html'=>$html,'count'=>0,'redirect'=>1,'have_data'=>0);
        }
        
    }
    else if(!empty($act_data))
    {
        $html=$obj->get_activity_html_data($act_data);
        $row_count=count($act_data)-1;
        $response = array('status' => true, 'message' => 'You already added activity of this date!','html'=>$html,'count'=>$row_count,'yesterday_sleep_time'=>$act_data[0]['yesterday_sleep_time'],'today_wakeup_time'=>$act_data[0]['today_wakeup_time'],'sleep_duration'=>$act_data[0]['sleep_duration'],'redirect'=>0);
            
    }
    else
    {
         $response = array('status' => false, 'message' => 'No activity added by you!');
    }

    echo json_encode($response);

    //echo $act_data;
}
elseif ($action=='canvas_linkup') {

    $obj = new frontclass();
    $response=$url='';

    $data=$obj->getFavCategoryData($_POST['favCat']);
    
    if(!empty($data))
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
                // $title=base64_encode($_POST['activity']);
                // $url=$url.'&title='.$title;
            }
            //update by ample 03-06-20
            if(!empty($_POST['activity']))
            {
                $title=base64_encode($_POST['activity']);
                $url=$url.'&title='.$title;
            }
            if($data['link']=='design-my-life.php')
            {
                $url=$url.'&redirect_page='.$_POST['redirect_page'].'&redirect_id='.$_POST['redirect_id'].'&redirect='.$_POST['redirect'];
            }

            $response=array('status'=>true,'url'=>$url);
        }
        else
        {
            $response=array('status'=>false,'url'=>$url);
        }
    }
    else
    {
        $response=array('status'=>false,'url'=>$url);
    }

   echo json_encode($response);
}
//add by ample 10-04-20
elseif ($action == 'getkeywords_mycanvas') {
    $obj = new frontclass();
    $data=array();  
    $option_str='';
    $date_type = $_REQUEST['date_type'];
    $date_arr = $_REQUEST['arr'];
    $data = $obj->getkeywords_mycanvas($date_type,$date_arr);

    if($data)
    {
        foreach ($data as $key => $value) {
            $option_str.= '<option  value="' . $value . '">' . $value . '</option>';
        }
    }

    echo $option_str;
}
//add by ample 29-04-20
elseif($action == 'disable_activity_form')
{

    $html="";

    $html.='<div class="row" id="default_row">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label class="label Header_brown">Activity</label>
                          <input  type="text" class="form-control" disabled />
                        </div>
                        <div class="col-md-6 row">
                           <label class="label Header_brown">Other Activity</label>
                            <input  type="text" class="form-control" disabled />
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-3">
                          <label class="label Header_brown">Activity Time Start</label>
                          <input type="time" class="form-control"  disabled/>
                        </div>
                        <div class="col-md-3">
                           <label class="label Header_brown">Activity Time End</label>
                           <input type="time" class="form-control"  disabled/>
                        </div>
                        <div class="col-md-6">
                            <label class="label Header_brown">Duration</label>
                           <input type="text" class="form-control" disabled>
                        </div>
                        <div class="col-md-12">
                         <p class="text-danger" id="time_note_0" style="font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red;    text-decoration: underline;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></p>
                      </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="label Header_brown">My View</label>
                            <select class="form-control" disabled>'.$obj->getCategoryOptions('46').'</select>
                        </div>
                        <div class="col-md-4">
                          <label class="label Header_brown">Activity Location Type</label>
                          <select class="form-control" disabled>'.$obj->getCategoryOptions('40').'</select>
                        </div>
                        <div class="col-md-4">
                           <label class="label Header_brown">Activity Location</label>
                           <select class="form-control" disabled>'.$obj->getCategoryOptions('21').'</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group Header_brown">
                            <br>
                             <span class="Header_brown">Do you do under proper guidance?</span>
                            <label class="radio-inline Header_brown"><input type="radio"  value="1" disabled>Yes</label>
                            <label class="radio-inline Header_brown"><input type="radio"  value="0" checked disabled>No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label Header_brown">(Including any Precaution taken)</label>
                                <textarea class="form-control" rows="3" disabled></textarea>
                            </div>
                        </div>
                    </div>';
                    $html.='<hr>
                </div>
                <div class="col-md-1">
                </div>
            </div>';

    echo $html;
}
//add by ample 01-05-20(static calendar data)
// elseif($action == 'my_calendar_data')
// {   

//     $events = array();
//     $events[]=array(
//                      'title'=>'event 1',
//                      'start' =>'2020-05-01'
//                     );
//     $events[]=array(
//                      'title'=>'event 2',
//                      'start' =>'2020-05-05'
//                     );
//     $events[]=array(
//                      'title'=>'event 3',
//                      'start' =>'2020-05-11'
//                     );
//     $events[]=array(
//                      'title'=>'event 5',
//                      'start' =>'2020-05-25'
//                     );
//     echo json_encode($events); 
//}
//add by ample 01-05-20
elseif($action == 'my_calendar_data')
{   
    $sdate= date("Y-m-d", strtotime($_POST['start'])) ;
    $edate= date("Y-m-d", strtotime($_POST['end'])) ;

        $month_data=$obj->get_month_list($sdate,$edate);

        $data1=$obj->get_design_my_life_main_edata($sdate,$edate);

        $event1 = array();
            foreach ($data1 as $key => $value) {

                    $title='Event';
                    if(!empty($value['title']))
                    {
                        $title=$value['title'];
                    }
                    elseif(!empty($value['comment']))
                    {
                        $title=$value['comment'];
                    }

                    $url='design-my-life-data-view.php?data_id='.$value['id'];

               
                if($value['listing_date_type']=='single_date')
                {   

                    $event1[]=array('title' =>$title,
                                    'url' =>$url,
                                    'start'=>$value['single_date'].'T'.trim($value['bes_time']),
                                );

                }
                elseif($value['listing_date_type']=='date_range')
                {   

                     $event1[]=array('title' =>$title,
                                    'url' =>$url,
                                    'start'=>$value['start_date'].'T'.trim($value['bes_time']),
                                    'end'=>date('Y-m-d', strtotime('+1 day', strtotime($value['end_date']))),
                                );
                }
                elseif($value['listing_date_type']=='days_of_week' && !empty($value['days_of_week']))
                {   
                    $DOW=$obj->update_calendar_DOW($value['days_of_week']);
                    $event1[]=array('title' =>$title,
                                    'url' =>$url,
                                    'daysOfWeek'=>$DOW,
                                );
                }
                elseif($value['listing_date_type']=='month_wise' && !empty($value['months']))
                {   
                    $month=explode(',', $value['months']);
                    
                    foreach ($month as  $mo) 
                    {

                        foreach ($month_data as $mo_data) 
                        {

                            if($mo==$mo_data['mo'])
                            {
                                $event1[]=array('title' =>$title,
                                    'url' =>$url,
                                    'daysOfWeek'=>'',
                                    'startRecur'=>$mo_data['month'].'-01'.'T'.trim($value['bes_time']),
                                    'endRecur'=>$mo_data['month'].'-'.$mo_data['total'],
                                );
                            }
                        }

                    }
                    
                }
                elseif($value['listing_date_type']=='days_of_month' && !empty($value['days_of_month']))
                {   
                    $days=explode(',', $value['days_of_month']);
                    
                    foreach ($days as  $day) 
                    {

                        foreach ($month_data as $mo_data) 
                        {
                            $orgDate=$mo_data['month'].'-'.$day;
                            $event1[]=array('title' =>$title,
                                'url' =>$url,
                                'start'=> date("Y-m-d", strtotime($orgDate)).'T'.trim($value['bes_time']), 
                            );
                            
                        }

                    }
                    
                }
            }

        //comment by ample 01-06-20
        // $data2=$obj->get_design_my_life_favCat_event_data($sdate,$edate);
        // $event2 = array();
        //     foreach ($data2 as $key => $value) {
        //             $title='Event';
        //             if(!empty($value['title']))
        //             {
        //                 $title=$value['title'];
        //             }
        //             elseif(!empty($value['comment']))
        //             {
        //                 $title=$value['comment'];
        //             }
        //             $url='design-my-life-data-view.php?data_id='.$value['id'];
        //         if($value['listing_date_type']=='single_date')
        //         {   

        //             $event2[]=array('title' =>$title,
        //                             'url' =>$url,
        //                             'start'=>$value['single_date'],
        //                             'color'=>'yellow',
        //                             'textColor'=>'black',
        //                         );

        //         }
        //         elseif($value['listing_date_type']=='date_range')
        //         {   
        //              $event2[]=array('title' =>$title,
        //                             'url' =>$url,
        //                             'start'=>$value['start_date'],
        //                             'end'=>$value['end_date'],
        //                             'color'=>'yellow',
        //                             'textColor'=>'black',
        //                         );
        //         }
        //         elseif($value['listing_date_type']=='days_of_week' && !empty($value['days_of_week']))
        //         {   
        //             $event2[]=array('title' =>$title,
        //                             'url' =>$url,
        //                             'daysOfWeek'=>explode(',', $value['days_of_week']),
        //                             'color'=>'yellow',
        //                             'textColor'=>'black',
        //                         );
        //         }
        //         elseif($value['listing_date_type']=='month_wise' && !empty($value['months']))
        //         {   
        //             $month=explode(',', $value['months']);
        //             foreach ($month as  $mo) 
        //             {

        //                 foreach ($month_data as $mo_data) 
        //                 {

        //                     if($mo==$mo_data['mo'])
        //                     {   
        //                         $orgDate=$mo_data['month'].'-'.$day;
        //                         $event2[]=array('title' =>$title,
        //                             'url' =>$url,
        //                             'daysOfWeek'=>'',
        //                             'startRecur'=>$mo_data['month'].'-01',
        //                             'endRecur'=>$mo_data['month'].'-'.$mo_data['total'],
        //                             'color'=>'yellow',
        //                             'textColor'=>'black',
        //                         );
        //                     }
        //                 }
        //             }
        //         }
        //         elseif($value['listing_date_type']=='days_of_month' && !empty($value['days_of_month']))
        //         {   
        //             $days=explode(',', $value['days_of_month']);
        //             foreach ($days as  $day) 
        //             {
        //                 foreach ($month_data as $mo_data) 
        //                 {
        //                     $orgDate=$mo_data['month'].'-'.$day;
        //                     $event2[]=array('title' =>$title,
        //                         'url' =>$url,
        //                         'start'=> date("Y-m-d", strtotime($orgDate)), 
        //                         'color'=>'yellow',
        //                         'textColor'=>'black',
        //                     );
        //                 }
        //             }
        //         }
        //     }

            $data3=$obj->get_design_my_life_user_input_event_data($sdate,$edate);

            $event3 = array();
            foreach ($data3 as $key => $value) {

                $title='Event';
                    if(!empty($value['title']))
                    {
                        $title=$value['title'];
                    }
                    elseif(!empty($value['comment']))
                    {
                        $title=$value['comment'];
                    }

                    $url='design-my-life-data-view.php?data_id='.$value['id'];

               
                if($value['listing_date_type']=='single_date')
                {   

                    $event3[]=array('title' =>$title,
                                    'url' =>$url,
                                    'start'=>$value['single_date'].'T'.trim($value['bes_time']),
                                    'color'=>'yellow',
                                    'textColor'=>'black',
                                );

                }
                elseif($value['listing_date_type']=='date_range')
                {   

                     $event3[]=array('title' =>$title,
                                    'url' =>$url,
                                    'start'=>$value['start_date'].'T'.trim($value['bes_time']),
                                    'end'=>date('Y-m-d', strtotime('+1 day', strtotime($value['end_date']))),
                                    'color'=>'yellow',
                                    'textColor'=>'black',
                                );
                }
                elseif($value['listing_date_type']=='days_of_week' && !empty($value['days_of_week']))
                {  
                    $DOW=$obj->update_calendar_DOW($value['days_of_week']); 
                    $event3[]=array('title' =>$title,
                                    'url' =>$url,
                                    'daysOfWeek'=>$DOW,
                                    'color'=>'yellow',
                                    'textColor'=>'black',
                                );
                }
                elseif($value['listing_date_type']=='month_wise' && !empty($value['months']))
                {   
                    $month=explode(',', $value['months']);
                    
                    foreach ($month as  $mo) 
                    {

                        foreach ($month_data as $mo_data) 
                        {

                            if($mo==$mo_data['mo'])
                            {   
                                $orgDate=$mo_data['month'].'-'.$day;
                                $event3[]=array('title' =>$title,
                                    'url' =>$url,
                                    'daysOfWeek'=>'',
                                    'startRecur'=>$mo_data['month'].'-01'.'T'.trim($value['bes_time']),
                                    'endRecur'=>$mo_data['month'].'-'.$mo_data['total'],
                                    'color'=>'yellow',
                                    'textColor'=>'black',
                                );
                            }
                        }

                    }
                    
                }
                elseif($value['listing_date_type']=='days_of_month' && !empty($value['days_of_month']))
                {   
                    $days=explode(',', $value['days_of_month']);
                    
                    foreach ($days as  $day) 
                    {

                        foreach ($month_data as $mo_data) 
                        {
                            $orgDate=$mo_data['month'].'-'.$day;
                            $event3[]=array('title' =>$title,
                                'url' =>$url,
                                'start'=> date("Y-m-d", strtotime($orgDate)).'T'.trim($value['bes_time']), 
                                'color'=>'yellow',
                                'textColor'=>'black',
                            );
                            
                        }

                    }
                    
                }

            }

             $event4 = array();
        
            // $event4[0]['title'] = 'new event';
            // $event4[0]['daysOfWeek'] = '';
            // $event4[0]['startRecur'] = '2020-05-01';
            // $event4[0]['endRecur'] = '2020-05-30';

            $events=array();
            //update again by ample 01-06-20
            //$events = array_merge($event1,$event2,$event3,$event4);
            $events = array_merge($event1,$event3,$event4);


            echo json_encode($events);

}
//add by ample 10-04-20
elseif ($action == 'get_session_slots') {
    $obj = new frontclass();
    $data=array();  
    $html='';
    $date = $_REQUEST['date'];
    $contact_id = $_REQUEST['contact_id'];
    $user_id = $_REQUEST['user_id'];
    $vendor_id = $_REQUEST['vendor_id'];
    

    $dayofweek = date('l', strtotime($date));

    $appt_date = date('Y-m-d', strtotime($date));

    $week_status = $obj->get_week_status($dayofweek,$contact_id,$vendor_id);


    if(empty($week_status) || $week_status['status']==1)
    {   
        $holiday_status = $obj->get_holiday_status($appt_date,$contact_id,$vendor_id);

        if(empty($holiday_status))
        {
            $data = $obj->get_week_slots($dayofweek,$contact_id,$vendor_id);

            if($data)
            {   
                $html.='<input type="time" class="form-control" name="time" id="appt_time" data-id="'.$contact_id.'" required>';
                foreach ($data as $key => $value) {
                    $checked=''; 
                    if($key==0)
                    {
                        $checked='checked';
                    }
                    $start_time=date("g:iA", strtotime($value['start_time']));
                    $end_time=date("g:iA", strtotime($value['end_time']));
                    $html.= '<span class="appointmentSlot">'.$start_time.' - '.$end_time.'</span>';
                    $error=0;
                }
                $html.= '<p style="font-size:13px;">Choose time between available slots</p>';
            }
            else
            {
                $html.='<input type="time" class="form-control" name="time" id="appt_time" data-id="" required>';
                $error=0;
            }
        }
        else
        {
            $html.='Date is holiday Marked';
            $error=1;
        }
    }
    else
    {
        $html.='Week Off';
        $error=1;
    }
     $response = array('error' =>$error,'html'=>$html );
     echo json_encode($response);
}
elseif ($action == 'check_time_slot') {
    $contact_id = $_REQUEST['contact_id'];
    $time = $_REQUEST['time'];
    $date = $_REQUEST['date'];

    $dayofweek = date('l', strtotime($date));

    $appt_date = date('Y-m-d', strtotime($date));

    $data = $obj->check_time_slot($dayofweek,$contact_id,$time);

    echo $data;
}
elseif($action == 'my_appointment_calendar_data')
{   
    $sdate= date("Y-m-d", strtotime($_POST['start']));
    $edate= date("Y-m-d", strtotime($_POST['end']));

        $data=$obj->get_appointment_user_data($sdate,$edate);
        $event = array();
        
        foreach ($data as $key => $value) 
        {
            $url='appointment-detail-view.php?appt_id='.$value['id'];
            $title='Appointment of '.$value['contact_name'].','.$value['contact_address'];

            $event[]=array('title' =>$title,
                        'start'=>$value['appointment_date'].'T'.$value['appointment_time'],
                        'url' =>$url,
                        'color'=>'orange',
                        'textColor'=>'black',
                    );
                           
        }
        echo json_encode($event);

}
//add by ample 10-08-20
elseif($action == 'addscrollingcontenttofav')
{   
    $page_id = $_REQUEST['page_id'];
    $str_sc_id = $_REQUEST['str_sc_id'];
    $type_id = $_REQUEST['type_id'];
    $cat_id = $_REQUEST['cat_id'];
    
    $html='<form action="" id="scrollBarForm">
            <div class="form-group"><label>Priority:</label><select class="form-control" id="priority">'.$obj->getManageFavCatDropdownDataOption(37).'</select>
            </div>
            <div class="form-group"> <label for="comment">Note:</label><textarea class="form-control" rows="5" id="fav_note" name="note"></textarea></div>
            <input type="hidden" name="page_id" id="sb_page_id" value="'.$page_id.'"/><input type="hidden" id="sc_id" name="sc_id" value="'.$str_sc_id.'"/><input type="hidden" id="type_id" name="type_id" value="'.$type_id.'"/><input type="hidden" id="cat_id" name="cat_id" value="'.$cat_id.'"/>
            <button type="button" class="btn btn-default" onclick="saveScrollingContentToFav()">Submit</button>
            </form>';

    echo $html;

}
//add by ample 10-08-20
elseif($action == 'savescrollingcontenttofav')
{ 
    
    $page_id = $_REQUEST['page_id'];
    $sc_id = $_REQUEST['sc_id'];
    $note = $_REQUEST['note'];
    $priority = $_REQUEST['priority'];
    $type_id = $_REQUEST['type_id'];
    $cat_id = $_REQUEST['cat_id'];

    $res=$obj->saveScrollingContent_favlist($page_id,$sc_id,$note,$priority,$type_id,$cat_id);

    echo $res;

}
elseif($action == 'view_banners_solutionitems')
{   
    $sol_item_id = $_REQUEST['sol_item_id'];

    // echo $sol_item_id;

    $main_data=$obj->getSolutionItemDetailMain($sol_item_id);


    $sol_item_cat = array();
    $cat_ids=explode(',', $main_data['category_ids']);

    if(!empty($cat_ids))
    {
        foreach ($cat_ids as $key => $value) {
           $sol_item_cat[] = $obj->getSolutionCategoryName($value);
        }
    }
    $cat_id=implode(',', $sol_item_cat);

    $data=$obj->get_gallery_data_wellness_items($sol_item_id);

    $html="";

    if(!empty($data))
    {   
        $img=$file=$banner_data=$title=$desc=$credit=$credit_url="";
        $html.='<div class="col-md-12">';
        foreach ($data as $key => $value) {
            if($value['banner_type']=='Image')
            {
                $imgData=$obj->getImgData($value['banner']);
                if(!empty($imgData['image']))
                {
                    $banner_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'" style="width:300px; height: 175px;object-fit: contain;" class="img-responsive" alt="" />';
                }  
                else
                {
                     $banner_data='<img src="'.SITE_URL.'/images/no-image.png" style="width:300px; height: 175px;object-fit: contain;" class="img-responsive" alt="" />';
                }
                $url_file=$imgData['image'];
            }
            else
            {   
                $fileData=$obj->getFileData($value['banner']);
                if($value['banner_type']=='Video')
                {
                    $banner_data='<iframe width="275px" height="175px" src="'.$fileData["box_banner"].'" frameborder="0" allowfullscreen></iframe>';
                }
                else if($value['banner_type']=='Sound' || $value['banner_type']=='Audio')
                {
                    $banner_data='<embed src="'.SITE_URL.'/uploads/'.$fileData["box_banner"].'" autostart="true" loop="true" height="175px" width="275px"></embed>';
                }
                else if($value['banner_type']=='Pdf')
                {
                    $banner_data='<a href="'.SITE_URL.'/uploads/'.$fileData['box_banner'].'" target="_blank"><img src="'.SITE_URL.'/images/pdf-icon.png" style="width:300px; height: 175px;object-fit: contain;" class="img-responsive" alt="" /></a>';
                }
                else
                {
                    $banner_data='<img src="'.SITE_URL.'/images/no-image.png" style="width:300px; height: 175px;object-fit: contain;" class="img-responsive" alt="" />';
                }
                $url_file=$fileData['box_banner'];
            }

            $button_data=$obj->get_button_data_WSI($sol_item_id);

             if(!empty($button_data))
                {

                  foreach ($button_data as $b_key => $b_value) {
                        if($b_value['popup_type']==2)
                        {
                            $btn='<button class="btn" onclick="openLibraryBox(\''.$value["banner_type"].'\',\''.$url_file.'\',\''.$main_data['topic_subject'].'\',\''.$cat_id.'\')" style="color:#'.$b_value['font_color'].';background-color: #'.$b_value['bg_color'].'" title="'.$b_value['button_heading'].'"><i class="fa '.$b_value['icon_code'].'"></i> </button>';
                        }
                    }
                }

                $credit=$value['credit_line'];
                $credit_url=$value['credit_line_url']; 

            $html.='<div class="library-box text-center">'.$banner_data;

                    if($value['credit_line'] && $value['credit_line_url'] )
                    {
                        $html.='<p><a href="'.$value['credit_line_url'].'" target="_blank">'.$value['credit_line'].'</p></a>'; 
                    }

                    if($value['narration'])
                    {
                         $html.='<p>'.$value['narration'].'</p>';
                    }

                 $html.=' <br> '.$btn.'</div>';

        }
        $html.='</div>';
    }
    else
    {
        $html="No Banner Found!";
    }

    echo $html;
}
//add by ample 13-08-20
elseif($action == 'delete_myfavitem')
{ 
    
    $ufs_id = $_REQUEST['ufs_id'];

    $res=$obj->delete_fav_list_data($ufs_id);

     $response= "Record Deleted Successfully!";

     echo $response;

}
//add by ample 13-08-20
elseif($action == 'updateFevList')
{   
    $ufs_id = $_REQUEST['ufs_id'];
    $fav_data=$obj->get_short_fav_data($ufs_id);
    $html='<form action="" id="scrollBarForm">
             <div class="form-group"><label>Priority:</label><select class="form-control" id="priority">'.$obj->getManageFavCatDropdownDataOption(37,$fav_data["ufs_priority"]).'</select>
            </div>
            <div class="form-group"> <label for="comment">Note:</label><textarea class="form-control" rows="5" id="fav_note" name="note">'.$fav_data["ufs_note"].'</textarea></div>
            <button type="button" class="btn btn-default" onclick="updateFavListData('.$ufs_id.')">Submit</button>
            </form>';

    echo $html;

}
//add by ample 13-08-20
elseif($action == 'updateFevListNote')
{ 
    
    $ufs_id = $_REQUEST['ufs_id'];
    $ufs_note = $_REQUEST['fav_note'];
    $ufs_priority = $_REQUEST['priority'];

    $res=$obj->update_fav_list_note($ufs_id,$ufs_note,$ufs_priority);

    $response= "Record Updated Successfully!";

    echo $response;

}
//add by ample 14-08-20
elseif($action == 'openLibraryBox')
{   
    $type = $_REQUEST['type'];
    $file = $_REQUEST['file'];
    $title = $_REQUEST['title'];
    $category = $_REQUEST['category'];
    
    $html='<form action="" id="scrollBarForm">
            <div class="form-group"> <label for="comment">Note:</label><textarea class="form-control" rows="5" id="fav_note" name="note"></textarea></div>
            <input type="hidden" name="type" id="type" value="'.$type.'"/><input type="hidden" name="file" id="file" value="'.$file.'"/><input type="hidden" name="title" id="title" value="'.$title.'"/><input type="hidden" name="category" id="category" value="'.$category.'"/>
            <button type="button" class="btn btn-default" onclick="saveLibraryBoxData()">Submit</button>
            </form>';

    echo $html;

}
//add by ample 14-08-20
elseif($action == 'saveLibraryBox')
{ 
    
    $type = $_REQUEST['type'];
    $file = $_REQUEST['file'];
    $title = $_REQUEST['title'];
    $category = $_REQUEST['category'];
    $note = $_REQUEST['note'];
    

    $res=$obj->saveLibraryBoxData($title,$category,$note,$type,$file);

    echo $res;

}
//add by ample 14-08-20
elseif($action == 'delete_librarypdf')
{ 
    
    $library_id = $_REQUEST['library_id'];

    $res=$obj->delete_library_data($library_id);

     $response= "Record Deleted Successfully!";

     echo $response;

}
//add by ample 14-08-20
elseif($action == 'Update_libraryData_list')
{   
    $library_id = $_REQUEST['library_id'];
    $lib_data=$obj->get_short_library_data($library_id);
    $html='<form action="" id="scrollBarForm">
            <div class="form-group"> <label for="comment">Note:</label><textarea class="form-control" rows="5" id="fav_note" name="note">'.$lib_data["note"].'</textarea></div>
            <button type="button" class="btn btn-default" onclick="UpdateLibraryData('.$library_id.')">Submit</button>
            </form>';

    echo $html;

}
//add by ample 14-08-20
elseif($action == 'UpdateLibraryDataNote')
{ 
    
    $library_id = $_REQUEST['library_id'];
    $note = $_REQUEST['fav_note'];

    $res=$obj->update_library_list_note($library_id,$note);

    $response= "Record Updated Successfully!";

    echo $response;

}
//add by ample 21-08-20
elseif($action == 'view_reward_box_data')
{   
    $page_id = $_REQUEST['page_id'];
    $button_id = $_REQUEST['button_id'];

    $box_data=$obj->get_reward_list_box_data($page_id,$button_id);

    // print_r($box_data);

    // die();

    $html="";

    if(!empty($box_data))
    {   
        $banner_data="";
        $html.='<div class="col-md-12">';
        foreach ($box_data as $key => $value) {
            if($value['reward_list_file_type']=='Image')
            {
               $banner_data='<img src="'.SITE_URL.'/uploads/'.$value['reward_list_file'].'" style="width:300px; height: 175px;object-fit: contain;" class="img-responsive" alt="" />';
            }
            elseif ($value['reward_list_file_type']=='Pdf') {
                $banner_data='<a target="_blank" href="'.SITE_URL.'/uploads/'.$value['reward_list_file'].'"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>';
            }
            elseif ($value['reward_list_file_type']=='Video') {
                $src=$obj->getYoutubeString($value['reward_list_file']);
                $banner_data='<iframe width="200" height="200" src="'.$value['reward_list_file'].'" frameborder="0" allowfullscreen></iframe>';
            }
            else
            {   
               $banner_data="";
            }

            $html.='<div class="reward-box">'.$banner_data.' <p>'.$value['reward_list_name'].'</p> <p>'.$value['reward_title_remark'].'</p> <br></div>';

        }
        $html.='<br></div>';
    }
    else
    {
        $html="No Reward box Found!";
    }

    echo $html;
}
//add by ample 03-09-20
elseif($action == 'getFoodSectionForm')
{
    //print_r($_POST); 


    $total_row=$_POST['total_row'];

    $html="";

    $html.='<div class="row" id="row'.$total_row.'">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="label Header_brown">Time</label>
                            <input type="time" name="time[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label Header_brown">Meal Type</label>
                            <select class="form-control" name="meal_type[]" required>
                                <option value="">Select</option>
                                ' . $obj->getFavCategoryRamakant('94','') . '
                          </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="label Header_brown">Food Type</label>
                            <select class="form-control" name="food_type[]" onchange="getDailyFoodItems(this,'.$total_row.')" required>
                                <option value="">All</option>
                                ' . $obj->getFavCategoryRamakant('25','') . '
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="label Header_brown">Items</label>
                             <input name="meals[]" type="text" class="form-control" id="meals_'.$total_row.'"  list="capitals'.$total_row.'" autocomplete="off" onchange="meals_datalist('.$total_row.')"  />
                                    <datalist id="capitals'.$total_row.'" class="dlist" >
                                                   ' . $obj->get_daily_foods_meal_data() . '
                                        </datalist>
                            <input type="hidden" name="meal_id[]" id="meal_id_'.$total_row.'">
                            <a href="javascript:void(0);" onclick="erase_input('.$total_row.');" class="pull-left"><i class="fa fa-eraser" aria-hidden="true" style="font-size: 15px; display:block;"></i></a>
                            <a href="javascript:void(0)" style="text-decoration:underline" onclick="open_food_popup('.$total_row.')" class="pull-right"> View Food Composition </a>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="label Header_brown">Quantity</label>
                            <select class="form-control" name="qty[]" required>
                                <option value="">Select</option>
                                ' . $obj->getMealQuantityOptions('') . '
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="label Header_brown">Meal Measure</label>
                            <input type="text" name="size[]" id="meal_measure_'.$total_row.'" class="form-control" readonly="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="label Header_brown">My Desire</label>
                            <select class="form-control" name="desire[]" id="desire_'.$total_row.'" onchange="get_fev_icon(this,'.$total_row.')">
                                <option value="">Select</option>
                                ' . $obj->getFavCategoryRamakant('46','') . '
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="label Header_brown"></label>
                            <p id="icon_'.$total_row.'"></p>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="label Header_brown">Item Remark:</label>
                      <textarea class="form-control" name="remark[]" rows="3"></textarea>
                    </div>';
                    if($total_row==0)
                    {
                        $html.='<button type="button" class="btn btn-info btn-xs add_more_activity" onclick="add_more_activity()">Add More</button>';
                    }
                    else
                    {
                        $html.='<button type="button" class="btn btn-warning btn-xs remove_activity" onclick="remove_activity('.$total_row.')">Remove</button>';
                    }
                    $html.='<hr>
                </div>
                <div class="col-md-1">
                </div>
            </div>';

    echo $html;
}
//add by ample 03-09-20
elseif($action == 'getDailyFoodItems')
{
    $food_type_id=$_POST['food_type_id'];

    echo $obj->get_daily_foods_meal_data($food_type_id);
}
elseif ($action == 'checkDailyMealData') {

    $date_set=date("Y-m-d", strtotime($_POST['date_set']));
    $user_id = $_SESSION['user_id'];

    $html="";

    $items_data=$obj->check_already_fill_food($user_id,$date_set);

    if($items_data))
    {
        $html=$obj->get_food_meals_html_data($items_data);
        $row_count=count($items_data)-1;
        $response = array('status' => true,'message' => 'Alredy food data added by you!', 'html'=>$html,'count'=>$row_count);
            
    }
    else
    {
         $response = array('status' => false, 'message' => 'No food data added by you!');
    }

    echo json_encode($items_data);

}
elseif ($action == 'get_food_meal_info') {

    $meal_id=$_POST['meal_id'];

    $items_data=$obj->get_food_meal_info($meal_id);

    if(!empty($items_data))
    {
        $response = array('status' => true, 'data'=>$items_data);
    }
    else
    {
         $response = array('status' => false);
    }

    echo json_encode($response);

}
elseif($action=='get_fev_icon')
{
    $fav_id=$_POST['fav_id'];

    $img=$obj->get_icon_of_favcategory($fav_id);

    echo '<img src="uploads/'.$img.'" alt="fav-icon" style="height:25px;width:25px">';
}
elseif ($action == 'get_food_compositionInfo') {

    $meal_id=$_POST['meal_id'];

    $foods=$obj->compositionInfo($meal_id);

    $output="";

            if(!empty($foods))
                {   
                    $output .='<table class="table table-condensed"><thead><tr><th>Composition</th><th>Content</th><th>UOM</th></tr></thead><tbody>';
                    foreach ($foods as $key => $value) {
                        
                        $output .='<tr>';
                        $output .='<td>'.$obj->getFavCategoryNameRamakant($value['fav_cat_id']).'</td>';
                        $output .='<td>'.stripslashes($value['content']).'</td>';
                        $output .='<td>'.$obj->getFavCategoryNameRamakant($value['uom']).'</td>';
                        $output .='</tr>';
                    }
                    $output .='</tbody></thead></table>';
                }
                else
                {
                    $output="No Food Composition Found!";
                }

    echo $output;

}
?>
