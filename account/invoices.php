<?php
	require_once('router.php');
	$customer->page_protected();
	//view invoice
	if(isset($_REQUEST['invoiceid'])) {
		$filename = (int)$_REQUEST['invoiceid'];
		$inv = $order->readOrder($_REQUEST['invoiceid']);
		$invStatus = ($inv->order_status == 0) ? 'unpaid.png' : 'paid.png';
		/*if(is_dir('invoices')) {
			$files = scandir('invoices');
			foreach($files as $file) :
				if(is_file($file) && $file == $filename) {
					$jsondata = file_get_contents($file.'json');
					$invoice = json_decode($jsondata); 
				}
			endif;
		}*/
		$profile = $customer->getCustomer($_SESSION['customer']['uid']);
	} else {
		exit();
	}
?>

	<style type="text/css">
	body {
		font-family: helvetica, airal;
	}
	.table-info {
		width: 100%;
		/*border: thin solid #777;*/
	}
	.table-info tr td:nth-of-type(2) {
		text-align: right;
		vertical-align: text-top;
	}
	.table-payment {
		text-align: center;
		width: 100%;
		/*border: thin solid #777;*/
		padding: 5px;
	}
	.table-payment thead th {
		background-color: #fff;
		border-bottom: 2px solid #777;
		padding: 15px 0;
	}
	.table-payment tr td {
		padding: 10px 0;
	}
	.table-payment tr:last-child {
		font-size: 1.5em;
	}
	.table-payment tr:last-child td {
		border-top: 1px solid #777;
	}
	.lead {
		text-align: center;
		font-size: 2em;
	}
	.logo {
		width: 150px;
		max-width: 100%;
	}
	.header {
		font-size: 1.3em;
		font-weight: bold;
		padding: 8px 0;
	}
	.footer {
		text-align: center;
		padding: 10px;
		border-top: thin solid #ccc;
		margin-top: 50px;
	}
		
	.container-invoice {
		position: relative;
		top: 10px;
		width: 1024px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #fff;
		border-radius: 5px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		padding: 10px 15px;
		z-index: 6;
	}
	.close-item {
		font-size: 1.5em;
		font-weight: bold;
		color: #777;
		float: right;
	}
	.close-item:hover {
		color: #ff0000;
		cursor: pointer;
	}
	.close-item:ctive {
		color: #dd0000;
		cursor: pointer;
	}
	.invoce_status {
		position: absolute;
		top: 33px;
		left: -31px;
		width: 150px;
		transform: rotateZ(-46deg);
	}
	</style>
	<div class="container-invoice">
		<div><img src="<?php echo '../images/'.$invStatus; ?>" class="invoce_status"/>
		</div>
		<span class="close-item" title="Close popup" onclick="popupClose(this);">&times;</span>
		<table border="0" class="table-info">
				<tr>
					<!-- Company logo -->
					<td><img src="../images/logo.png" class="logo"></td>
					<td>
						<!-- Company details -->
						<div class="header">Healthy Moves</div>
						<div>Tel: 012 123 4567</div>
						<div>Cell: 082 123 4567</div>
						<div>123 Street, Pretoria, 0001</div>
					</td>
				</tr>
				<tr>
					<td>
						<!-- Customer details -->
						<div class="header">Invoice To:</div>
						<div><?php echo $profile->fullname; ?></div>
						<div>Email: <?php echo $profile->email ?></div>
						<div>Cell: <?php echo $profile->phone; ?></div>
						<div>&nbsp;</div>
						<div><?php echo $profile->address; ?></div>
					</td>
					<td align="right">
						<!-- Invoice Order details -->
						<div class="header">Invoice #<?php echo $inv->order_id; ?></div>
						<div>Invoice Date: <?php echo date('d/m/Y'); ?></div>
						<div>Account Name: FNB Bank <br/> Acc Number: (62270185583) <br/> Type: (Cheque)</div>
					</td>
				</tr>
			</table>

			<table border="0" class="table-payment">
				<h4 class="lead">Invoice Summary</h4>
				<thead>
					<th>Items</th>
					<th>Quantity</th>
					<th>Total Price</th>
				</thead>
				<tbody>
					<!-- Invoice body items details and amounts -->
					<?php  ?>
					<tr>
						<td align="left"><?php echo "Item(s)"; ?></td>
						<td><?php echo $inv->order_quantity; ?></td>
						<td colspan="1" align="right">R <?php echo number_format($inv->order_total,2); ?></td>
					</tr>
					<!-- Invoice body total amounts -->
					<tr style="background-color: #fff;">
						<td colspan="2" align="right">Total Amount Due</td>
						<td align="right">R <?php echo number_format($inv->order_total,2); ?></td>
					</tr>
				</tbody>
			</table>
			<div class="footer">
				<!-- Invoice footer -->
				<div class="lead">Thank You for shopping with us.</div>
				<div><small>Healthy Moves &copy; <?php echo date('Y'); ?></small></div>
			</div>
		</div>
		
	</div>