<?php
// $secret_key = "5edc86671de13466e50dfa089d99e941";
$hashData = EBS_SECRET_KEY; //Pass your Registered Secret Key
if(isset($_GET['DR'])) {
require('rc43.php');
$DR = preg_replace("/\s/","+",$_GET['DR']);
$rc4 = new Crypt_RC4($secret_key);
$QueryString = base64_decode($DR);
$rc4->decrypt($QueryString);
$QueryString = explode('&',$QueryString);
$response = array();
foreach($QueryString as $param){
$param = explode('=',$param);
$response[$param[0]] = urldecode($param[1]);
}
// check for payment success
if(($response['ResponseCode'] == 0)) {
foreach( $response as $key => $value) {
    exit;
echo $key;
echo $value;
}
}
// check for payment failed
if(($response['ResponseCode'] != 0)) {
foreach( $response as $key => $value) {
echo $key;
echo $value;
}
}
}
?>