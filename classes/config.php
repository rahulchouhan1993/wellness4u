<?php







error_reporting(E_ERROR | E_DEPRECATED);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);







ini_set("memory_limit","200M");



if (ini_get("pcre.backtrack_limit") < 1000000000) { ini_set("pcre.backtrack_limit",1000000000); };



@set_time_limit(10000000);



session_start();



$_SESSION['home_pop']=1;







date_default_timezone_set('Asia/Calcutta');



define('DB_TYPE', 'mysql');







//Local 



// define('DB_HOST', 'localhost');



// define('DB_USERNAME', 'root');



// define('DB_PASSWORD', '');



// define('DB_NAME', 'wellness');







//Live



define('DB_HOST', 'localhost');



define('DB_USERNAME', 'root');



define('DB_PASSWORD', '');



define('DB_NAME', 'wellness');











define('EBS_SECRET_KEY', '5edc86671de13466e50dfa089d99e941');



define('EBS_ACCOUNT_ID', '24094');



define('EBS_MODE', 'TEST');



// define('EBS_MODE', 'LIVE');







// SMS setup update by ample 02-06-20



define('SMS_URL', 'http://smpp.keepintouch.co.in/vendorsms/pushsms.aspx');



define('SMS_USERNAME', 'keepintouch');



define('SMS_PASSWORD', 'keep567829');



define('SMS_SENDERID', 'KEEPIT');











define('SITE_PATH', substr(dirname(__FILE__),0,-8));



define('SITE_CLASS_PATH', SITE_PATH.'/classes');



define('ADMIN_PATH', SITE_PATH . '/admin');











define('SITE_NAME', 'Wellnessway4u');







define('SITE_URL', 'http://localhost/welness');



//define('SITE_URL', 'https://www.wellnessway4u.com');







define('ADMIN_URL', SITE_URL . '/admin');



define('BA_URL',SITE_URL.'/wa/business-associate');







define('MAX_RECORDS', 10);



putenv("TZ=Asia/Kolkata");







// echo SITE_CLASS_PATH;



// exit;



require_once (SITE_CLASS_PATH . '/db_connect.php');



// require_once (SITE_CLASS_PATH . '/class.phpmailer.php');



require_once (SITE_CLASS_PATH . '/functions.php');



require_once (SITE_CLASS_PATH . '/functions_2.php');



require_once (SITE_CLASS_PATH . '/prof-function.php');



require_once (SITE_CLASS_PATH . '/common_functions.php'); //added by ample 08-12-20





// require_once (SITE_CLASS_PATH . '/PHPMailer_new/PHPMailerAutoload.php');



?>