<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');

$obj = new Vendor();
if(!$obj->isVendorLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
$obj->doVendorLogout();
header("Location: login.php");
?>
