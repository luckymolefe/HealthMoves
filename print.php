<?php
	//Print Invoice Page
	require_once('router.php'); //include router page, to access session and methods
	if(!empty($_SESSION['cart']) && !empty($_SESSION['customer']['uid'])) { //get cart session
		$uid = (int)$_SESSION['customer']['uid']; //get user session
		$user = $customer->getCustomer($uid); //get user details,pass userId as parameter
	}
	else {
		header("Location: shop.php");
		exit();
	}
	$subtotal = 0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewpoint" content="width=device-width, initital-scale=1.0">
		<title>Healthy Moves | Invoice#<?php echo $_SESSION['customer']['orderNum']; ?></title>
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
		</style>
	</head>
	<body>
		<div class="container">
			<table border="0" class="table-info">
				<tr>
					<!-- Company logo -->
					<td><img src="images/logo.png" class="logo"></td>
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
						<div><?php echo $user->fullname; ?></div>
						<div>Email: <?php echo $user->email; ?></div>
						<div>Cell: <?php echo $user->phone; ?></div>
						<div>&nbsp;</div>
						<div><?php echo $user->address; ?></div>
					</td>
					<td align="right">
						<!-- Invoice Order details -->
						<div class="header">Invoice #<?php echo $_SESSION['customer']['orderNum']; ?></div>
						<div>Invoice Date: <?php echo date('d/m/Y'); ?></div>
						<div>Account Name: FNB Bank <br/> Acc Number: (62270185583) <br/> Type: (Cheque)</div>
					</td>
				</tr>
			</table>

			<table border="0" class="table-payment">
				<h4 class="lead">Invoice Summary</h4>
				<thead>
					<th>Item Description</th>
					<th>Quantity</th>
					<th>Unit Price</th>
					<th>Total Price</th>
				</thead>
				<tbody>
					<!-- Invoice body items details and amounts -->
					<?php foreach ($_SESSION['cart'] as $key => $values) : ?>
					<tr>
						<td align="left"><?php echo $values['item_name']; ?></td>
						<td><?php echo $values['item_quantity']; ?></td>
						<td>R <?php echo $values['item_price']; ?></td>
						<td align="right">R <?php echo number_format(($values['item_quantity'] * $values['item_price']), 2); ?></td>
					</tr>
					<?php 
						$subtotal = $subtotal + ($values['item_quantity'] * $values['item_price']);
						$VAT = ($subtotal * .15);
						$totalSum = ($subtotal + $VAT);
					?>
					<?php endforeach; ?>
					<!-- Invoice body total amounts -->
					<tr style="background-color: #fff;">
						<td colspan="3" align="right"><strong>SubTotal</strong></td>
						<td align="right"><strong>R <?php echo number_format($subtotal,2); ?></strong></td>
					</tr>
					<tr style="background-color: #fff;">
						<td colspan="3" align="right"><strong>15% VAT</strong></td>
						<td align="right"><strong>R <?php echo  number_format($VAT,2); ?></strong></td>
					</tr>
					<tr style="background-color: #fff;">
						<td colspan="3" align="right">Total Amount Due</td>
						<td align="right">R <?php echo  number_format($totalSum,2); ?></td>
					</tr>
				</tbody>
			</table>
			<div class="footer">
				<!-- Invoice footer -->
				<div class="lead">Thank You for shopping with us.</div>
				<div><small>Healthy Moves &copy; <?php echo date('Y'); ?></small></div>
			</div>
		</div>
		<script type="text/javascript">
			function doPrint() { //run print function
				return window.print(); //run printer dialog
			}
			setTimeout(function() {
				doPrint(); //call print function
				window.open('checkout.php','_self'); //if cancel return to checkout page
			}, 1000); //delay 1000 miliseconds before run functions
		</script>
	</body>
</html>
