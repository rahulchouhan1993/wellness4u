<?php
require_once('config/class.mysql.php');
require_once('classes/class.login.php');
$logoutSys = new LoginSystem();
$logoutSys->logout();
?>