<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');

$obj = new Vendor();
if(!$obj->isVendorLoggedIn())
{
	header("Location: ../../wa_register.php");
	exit(0);
}
$obj->doVendorLogout();
header("Location: ../../wa_register.php");
?>
