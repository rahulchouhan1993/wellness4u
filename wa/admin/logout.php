<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');

$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
$obj->doAdminLogout();
header("Location: login.php");
?>
