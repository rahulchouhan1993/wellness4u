<?php
global $link;

define('DB_TYPE', 'mysql');
define('DB_HOST', 'mysql');

//Local 
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'tastesofstates');

//Live
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'TOS@dbpass2017');
define('DB_NAME', 'tastesofstates');

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
if(!$link) 
{
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db(DB_NAME, $link);
if (!$db_selected) 
{
    die ('Can\'t use DB : ' . mysql_error());
}

echo'Connected';