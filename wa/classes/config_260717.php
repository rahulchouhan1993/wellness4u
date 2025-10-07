<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL);
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000000) { ini_set("pcre.backtrack_limit",1000000000); };
@set_time_limit(10000000);
ini_set('max_execution_time', '100000');
date_default_timezone_set('Asia/Calcutta');

define('DB_TYPE', 'mysql');

/*
//Local 
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tastesofstates');
*/

//Live
define('DB_HOST', 'mysql');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'TOS@dbpass2017');
define('DB_NAME', 'tastesofstates');


define('SITE_PATH', substr(dirname(__FILE__),0,-8));
define('SITE_CLASS_PATH', SITE_PATH.'/classes');
define('ADMIN_PATH', SITE_PATH . '/admin');

define('SITE_NAME', 'Tastes Of States');

//define('SITE_URL', 'http://localhost/tastesofstates');
define('SITE_URL', 'http://www.tastes-of-states.com');

define('ADMIN_URL', SITE_URL . '/admin');

define('EBS_SECRET_KEY', '5edc86671de13466e50dfa089d99e941');
define('EBS_ACCOUNT_ID', '24094');
//define('EBS_MODE', 'TEST');
define('EBS_MODE', 'LIVE');


define('SMS_URL', 'http://www.webpostservice.com/');
define('SMS_USERNAME', 'one9world');
define('SMS_PASSWORD', '679354');
//define('SMS_SENDERID', 'TESTIN');
define('SMS_SENDERID', 'TASTES');

define('MAX_RECORDS', 10);
putenv("TZ=Asia/Kolkata");
require_once (SITE_CLASS_PATH . '/db_connect.php');
require_once (SITE_CLASS_PATH . '/class.phpmailer.php');
require_once (SITE_CLASS_PATH . '/commonFunctions.php');
?>