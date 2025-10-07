<?php 
// require_once('classes/config.php');
// require_once('classes/commonFunctions.php');
include('classes/config.php');

// $obj = new commonFunctions();
$obj = new frontclass();
$page_id = 9;
$arr_page_details = $obj->getFrontPageDetails($page_id);

if($obj->isLoggedIn())
{
	$user_id = $_SESSION['user_id'];
	$obj->updateUserOnlineTimestamp($user_id);
}
else
{
	echo '<script>window.location.href="'.SITE_URL.'/login.php"</script>';
	exit(0);
}

$arr_orders_records = $obj->getUsersAllOrders($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php');?>
</head>
<body>
<?php include_once('header.php');?>
<section id="checkout">
	<div class="container">
		<div class="row">
			<div class="col-md-2 myaccount-box">
				<?php echo $obj->getSideLoggedinMenu($page_id);?>
			</div>
			<div class="col-md-10">
				<form name="frmcheckoutlogin" id="frmcheckoutlogin">
					<div>
						<h3>
							<p style="margin-top: 0px;">My Orders</p>
						</h3>
						<div>
							<div class="myorder-list">
								<table class="table table-border ">
								<tbody>
									<tr>
										<td class="myorder-list-heading">Srno</td>
										<td class="myorder-list-heading">Invoice</td>
										<td class="myorder-list-heading">Total Amount</td>
										<td class="myorder-list-heading">Order Status</td>
										<td class="myorder-list-heading">Order Date</td>
										<td class="myorder-list-heading"></td>
									</tr>
							<?php
							if(count($arr_orders_records) > 0)
							{
								$i = 1;
								foreach($arr_orders_records as $record)
								{
									$status = $obj->getOrderStatusString($record['order_status']);
									$order_date = date('d-M-Y',strtotime($record['order_add_date']));
									
									?>
									<tr>
										<td class="myorder-list-value"><?php echo $i?></td>
										<td class="myorder-list-value"><?php echo $record['invoice'];?></td>
										<td class="myorder-list-value">Rs <?php echo $record['order_total_amt'];?></td>
										<td class="myorder-list-value"><?php echo $status;?></td>
										<td class="myorder-list-value"><?php echo $order_date;?></td>
										<td class="myorder-list-value"><a class="btn-red-small" href="<?php echo SITE_URL.'/view_order.php?invoice='.$record['invoice'];?>">View</a></td>
									</tr>
								<?php	
									$i++;
								} 	
							}									
							else
							{ ?>
								<tr>
									<td colspan="6" class="err_msg">No Orders found</td>
								</tr>		
							<?php	
							} ?>
								</tbody>
								</table>
							</div>
						</div>
						
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php include_once('footer.php');?>	
</body>
</html>
