<?php
include('classes/config.php');
$obj = new frontclass();
if(!$obj->isLoggedIn())
{
    header("Location: login.php");
}
$obj->doLogout();
    header("Location: login.php");
?>
