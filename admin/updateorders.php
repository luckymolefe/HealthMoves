<?php
	//Orders
	require_once('router.php');

	$admin->page_protected();
	$allOrder = $order->retrieveOrders();
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
	.btn-default {
		background-color: #bbb;
		color: #777;
	}
</style>
<h1 class="page-heading">Manage Orders</h1>
<table class="order-table" border="0">
	<thead>
		<th>#OrderID</th>
		<th>Quantity</th>
		<th>Amount</th>
		<th>Status</th>
		<th>Payment Type</th>
		<th>Order Date</th>
		<th>Action</th>
	</thead>
	<tbody>
		<?php if($allOrder != false) : ?>
			<?php foreach($allOrder as $row) : 
				$order_status = ($row->order_status=="0") ? '<span class="pending">Not Paid</span>' : '<span class="paid">Paid</span>';
				switch($row->payment_type) :
					case 'creditcard':
						$row->payment_type = 'Credit Card';
					break;
					case 'eft':
						$row->payment_type = 'EFT';
					break;
					case 'bankdeposit':
						$row->payment_type = 'Bank Deposit';
					break;
				endswitch;
			?>
			<tr>
				<td>#<?php echo $row->order_id; ?></td>
				<td><?php echo $row->order_quantity; ?></td>
				<td>R<?php echo $row->order_total; ?></td>
				<td><?php echo $order_status; ?></td>
				<td><?php echo $row->payment_type; ?></td>
				<td><?php echo date('D d,M Y H:iA', strtotime($row->created)); ?></td>
				<?php if($row->order_status=="0") : ?>
				<td>
					<a href="router.php?updateorder=true&orderNum=<?php echo base64_encode($row->order_id); ?>" class="btn" onclick="return confirmUpdate()">Update</a>
				</td>
				<?php else: ?>
				<td>
					<a href="javascript:void(0)" class="btn btn-default">Done</a>
				</td>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr><td colspan="6"><span class="error-message">No orders available!</span></td></tr>
		<?php endif; ?>
	</tbody>
</table>
