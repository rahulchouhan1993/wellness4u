<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.contracts.php');
$obj = new Contracts();
if($obj->deleteContractsTransactionType($_GET['id']))
{
    $msg = "Record Deleted Successfully!";
}
else
{
    $msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=contracts_trans_type&msg='.urlencode($msg));	
?>
