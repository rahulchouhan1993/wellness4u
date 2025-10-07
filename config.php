<?php
error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL);
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000000) { ini_set("pcre.backtrack_limit",1000000000); };
@set_time_limit(10000000);
session_start();
define('DB_TYPE', 'mysql');

//define('DB_HOST', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'wellness');

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'wellness');

define('SITE_PATH', dirname(__FILE__));

define('SITE_URL', 'http://localhost/welness');
//define('SITE_URL', 'https://www.wellnessway4u.com');

define('ADMIN_PATH', SITE_PATH.'/admin');

define('ADMIN_URL', SITE_URL.'/admin');


define('SMS_URL', 'http://www.webpostservice.com/');
define('SMS_USERNAME', 'one9world');
define('SMS_PASSWORD', '679354');
//define('SMS_SENDERID', 'TESTIN');
define('SMS_SENDERID', 'TASTES');


define('MAX_RECORDS',4);

require_once(SITE_PATH.'/dbconnect.php');
//date_default_timezone_set('Asia/Calcutta');
date_default_timezone_set('Asia/Kolkata');
require_once(SITE_PATH.'/functions.php');
require_once(SITE_PATH.'/class.phpmailer.php');
?>