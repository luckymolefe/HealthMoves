<?php
	//Orders
	require_once('router.php');

	$customer->page_protected();

	if(isset($_SESSION['customer']['uid'])) {
		$uid = (int)$_SESSION['customer']['uid'];
		$allOrder = $order->getAllOrders($uid);
	}
	else {
		exit();
	}
?>
<style type="text/css">
	.order-table {
		width: 100%;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
	}
	.order-table thead th {
		padding: 10px;
		background-color: #0c8e7e;
		color: #fff;
	}
	.order-table tbody tr {
		background-color: #eee;
		color: #777;
		text-align: center;
	}
	.order-table tbody tr:hover {
		background-color: #ddd;
	}
	.order-table tbody td {
		padding: 8px;
	}
	.pending {
		background-color: #a94442;
		color: #f2dede;
		font-weight: bold;
		padding: 2px 3px;
		border-radius: 3px;
	}
	.paid {
		background-color: #3c763d;
		color: #dff0d8;
		font-weight: bold;
		padding: 2px 3px;
		border-radius: 3px;
	}
	.page-heading {
		font-size: 2em;
		color: #777;
		border-bottom: thin solid #ccc;
		text-align: center;
		padding: 0 0 5px 0;
	}
</style>
<h1 class="page-heading">My Orders</h1>
<table class="order-table" border="0">
	<thead>
		<th>#Order Number</th>
		<th>Total Quantity</th>
		<th>Total Amount</th>
		<th>Order Status</th>
		<th>Payment Type</th>
		<th>Order Date</th>
	</thead>
	<tbody>
		<?php if($allOrder != false) : ?>
			<?php foreach($allOrder as $row) : 
				$row->order_status = ($row->order_status=="0") ? '<span class="pending">Not Paid</span>' : '<span class="paid">Paid</span>';
				switch($row->payment_type) :
					case 'creditcard':
						$row->payment_type = 'Credit Card';
					break;
					case 'eft':
						$row->payment_type = 'EFT';
					break;
					case 'deposti':
						$row->payment_type = 'Bank Deposit';
					break;
				endswitch;
			?>
			<tr>
				<td><a href="javascript:viewInvoice(<?php echo $row->order_id; ?>);">#<?php echo $row->order_id; ?></a></td>
				<td><?php echo $row->order_quantity; ?></td>
				<td>R<?php echo $row->order_total; ?></td>
				<td><?php echo $row->order_status; ?></td>
				<td><?php echo $row->payment_type; ?></td>
				<td><?php echo date('D d,M Y H:iA', strtotime($row->created)); ?></td>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr><td colspan="6"><span class="error-message">No orders available!</span></td></tr>
		<?php endif; ?>
	</tbody>
</table>
