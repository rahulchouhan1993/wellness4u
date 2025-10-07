<?php
global $link;

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
?>