<?php

error_reporting(E_ERROR | E_PARSE);

error_reporting(0);

//ini_set('display_errors', 1);

//ini_set('display_startup_errors', 1);

//error_reporting(E_ALL);



ini_set("memory_limit","200M");

if (ini_get("pcre.backtrack_limit") < 1000000000) 

	{ ini_set("pcre.backtrack_limit",1000000000); };

@set_time_limit(10000000);

session_start();



date_default_timezone_set('Asia/Calcutta');

define('DB_TYPE', 'mysql');



//Local 

// define('DB_HOST', 'localhost');

// define('DB_USERNAME', 'root');

// define('DB_PASSWORD', '');

// define('DB_NAME', 'wellness');







//Live

define('DB_HOST', 'mysql');

define('DB_USERNAME', 'dbuser');

define('DB_PASSWORD', 'Ww4u$Maruti');

define('DB_NAME', 'wellness');





define('SMS_URL', 'http://www.webpostservice.com/');

define('SMS_USERNAME', 'one9world');

define('SMS_PASSWORD', '679354');

//define('SMS_SENDERID', 'TESTIN');

define('SMS_SENDERID', 'TASTES');





define('SITE_PATH', substr(dirname(__FILE__),0,-8));

define('SITE_CLASS_PATH', SITE_PATH.'/classes');

define('ADMIN_PATH', SITE_PATH . '/admin');



define('SITE_NAME', 'Wellnessway4u');


//define('MAIN_URL', 'http://localhost/wellnessway4you/'); // add by ample 09-03-20
define('MAIN_URL', 'https://www.wellnessway4u.com/'); // add by ample 09-03-20

//define('SITE_URL', 'http://localhost/wellnessway4you/wa');

define('SITE_URL', 'https://www.wellnessway4u.com/wa');



define('ADMIN_URL', SITE_URL . '/admin');



define('MAX_RECORDS', 10);

putenv("TZ=Asia/Kolkata");



require_once (SITE_CLASS_PATH . '/db_connect.php');

require_once (SITE_CLASS_PATH . '/class.phpmailer.php');

require_once (SITE_CLASS_PATH . '/commonFunctions.php');

?>