<?php
	//Shopping cart
require_once('router.php');
//adding item to cart
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "addtocart") {
	$item = array();
	if(isset($_SESSION['cart'])) { //if cart not empty append to existing items
		$item_array_id = array_column($_SESSION['cart'], "item_id");

		if (!in_array($_REQUEST['product_id'], $item_array_id)) {
			$count = count($_SESSION['cart']); //count items in a shopping cart
			$item_array = array(
				'item_id'		=> $_REQUEST['product_id'],
				'item_name'		=> $_POST['product_name'],
				'item_price'	=> $_POST['product_price'],
				'item_quantity'	=> $_POST['product_quantity']
			);
			$_SESSION['cart'][$count] = $item_array;
			$item['appendItem'] = $_SESSION['cart'][$count];
			echo "<script>window.open('shop.php?action=added','_self')</script>";
		}
		else {
			echo "<script>window.open('shop.php?action=exists','_self')</script>";
		}
	}
	else { //else create a new item to cart
		$item_array = array(
			'item_id'		=> $_REQUEST['product_id'],
			'item_name'		=> $_POST['product_name'],
			'item_price'	=> $_POST['product_price'],
			'item_quantity'	=> $_POST['product_quantity']
		);
		$_SESSION['cart'][0] = $item_array;
		$item['newItem'] = $_SESSION['cart'][0];
		echo "<script>window.open('shop.php?action=added','_self')</script>";
	}
}

//remove item from cart
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "delete") {
	$_GET['product_id'] = base64_decode($_GET['product_id']);
	foreach($_SESSION['cart'] as $k => $v) {
		if($v['item_id'] == $_GET['product_id']) {
			unset($_SESSION['cart'][$k]);
			echo "<script>window.open('cart.php?action=removed','_self')</script>";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Healthy Moves | Shopping Cart</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome/css/font-awesome.css">
	<style type="text/css">
		* {
			font-family: helvetica, arial-light;
		}
		.shop-container {
			width: 80%;
			/*height: 200px;*/
			max-width: 100%;
			margin: 0 auto;
			background-color: #fff;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
			padding: 10px;
			margin-top: 50px;
		}
		.page-header {
			border-bottom: thin solid #eee;
			color: #45a89a;
			text-align: center;
			padding-bottom: 5px;
		}
		table {
			width: 100%;
			border: 1px solid #ccc;
			text-align: left !important;
		}
		thead th {
			/*border: 1px solid #ccc;*/
			background-color: #0c8e7e;
			color: #fff;
			padding: 8px;
		}
		tbody tr {
			background-color: #f5f5f5;
		}
		tbody tr:hover {
			background-color: #eee;
		}
		tbody td {
			/*border: 1px solid #ccc;*/
			padding: 10px;
			color: #555;
		}
		tbody tr:last-child td {
			font-size: 1.5em;
			font-weight: bold;
			color: #3e8f3e;
		}
		tbody tr:last-child td:first-child {
			text-align: right;
		}

		.btn {
			background: -webkit-linear-gradient(#ea4335, #dd0000);
			color: #fff;
			border: thin solid #dd0000;
			padding: 5px 15px;
			border-radius: 5px;
			text-decoration: none;
			font-weight: lighter;
		}
		.btn:hover {
			background: -webkit-linear-gradient(#dd0000, #ff1111);
		}
		.btn:active {
			background: -webkit-linear-gradient(#eea29a, #f7786b);
		}
		.btn-primary {
		    background-image: -webkit-linear-gradient(top, #5bc0de 0,#2aabd2 100%);
		    border: thin solid #28a4c9;
			font-size: .75em !important;
			padding: 10px 8px;
		}
		.btn-primary:hover {
			background: -webkit-linear-gradient(bottom, #5bc0de 0,#28a4c9 100%);
		}
		.btn-success {
			background-image: -webkit-linear-gradient(top,#5cb85c 0,#419641 100%);
		    border: thin solid #3e8f3e;
			font-size: .75em !important;
			padding: 10px 8px;
		}
		.btn-success:hover {
			background: -webkit-linear-gradient(bottom, #5cb85c 0,#3e8f3e 100%);
		}
		.btn-primary:active, .btn-success:active {
			background: #fff;
			color: inherit;
		}
		.message {
			font-size: 1.5em;
			font-weight: bold;
			color: #c94c4c !important;
			text-align: center !important;
		}
		.popup-message {
			width: 35%;
			max-width: 100%;
			margin: 0px auto;
			background: #f5f5f5;
			color: #777;
			border: 1px solid #ccc;
			border-radius: 5px;
			padding: 15px 10px;
			text-align: left;
			margin-top: 15px;
			margin-bottom: 15px;

		}
		.popup-message.error {
			background: #f2dede;
			color: #a94442;
			border: 1px solid #a94442;
		}
		.popup-message.success {
			background: #dff0d8;
			color:#3c763d;
			border: 1px solid #3c763d;
		}
		.popup-close {
			position: relative;
			top: -18px;
			right: -8px;
			float: right;
			font-size: 1.5em;
			font-weight: bold;
			cursor: pointer;
			color: #dd9999;
		}
		.popup-close:hover {
			color: #a94442;
		}
		.popup-close:active {
			color: #ff0000;
		}
		.fadeOut {
			animation: fadeout .55s forwards;
		}
		@keyframes fadeout {
			0%   { opacity: 1; }
			50%  { opacity: 0.55; }
			100% { opacity: 0; display: none;}
		}
	</style>
	<script type="text/javascript">
		function popupClose(event) {
			event.parentNode.classList.add('fadeOut');
			setTimeout(function() {
				event.parentNode.style.display = "none";
			}, 800);
		}

		function confirmAction(action) {
			switch(action) {
				case 'remove':
					var remove = confirm('Remove item form cart?');
					if(remove==false) {
						return false;
					}
				break;
				case 'checkout':
					var checkout = confirm('Continue to checkout?');
					if(checkout==false) {
						return false;
					}
				break;
			}
		}
	</script>
</head>
<body>
	<div class="shop-container">

		<?php
			$action = (isset($_GET['action'])) ? $_GET['action'] : '';
			switch ($action) {
				case 'removed':
					echo '<div class="popup-message success">Item removed from cart.<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
					break;
			}
		?>

		<h1 class="page-header">Shopping Cart</h1>

		<table border="0">
			<thead>
				<th>Item Name</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>SubTotal</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php
					if(!empty($_SESSION['cart'])) :
					  	$total = 0;
					  	$itemsCount = array();
					  	foreach ($_SESSION['cart'] as $key => $values) :
					  		$itemsCount[] = $values['item_quantity'];
					  		$total += ($values['item_quantity'] * $values['item_price']);
					?>
					  		<tr>
					  			<td><?php echo $values['item_name']; ?></td>
						  		<td><?php echo $values['item_quantity']; ?></td>
					  			<td>R<?php echo $values['item_price']; ?></td>
						  		<td style="background-color:#d9edf7;">R<?php echo number_format(($values['item_quantity'] * $values['item_price']), 2); ?></td>
						  		<!-- <td><button type="submit" name="action" value="delete">Remove</button></td> -->
						  		<td><a href="cart.php?action=delete&product_id=<?php echo base64_encode($values['item_id']); ?>" class="btn" onclick="return confirmAction('remove')"><i class="fa fa-trash"></i></a></td>
					  		</tr>
					<?php
					  	endforeach;
						  	$items['itemNum'] = count($itemsCount); //total items in cart
						  	$items['itemCost'] = number_format($total, 2);
					?>
						<tr>
							<td colspan="3">Total Due</td>
							<td style="background-color:#dff0d8;">R<?php echo number_format($total, 2); ?></td>
							<td>
								<a href="shop.php" class="btn btn-primary"><i class="fa fa-reply"></i> Shopping</a>
								<a href="checkout.php" class="btn btn-success" onclick="return confirmAction('checkout')"><i class="fa fa-check-square-o"></i> Checkout</a>
							</td>
						</tr>
						<!-- <tr>
							<td colspan="3"><a href="shop.php" class="btn btn-primary">Continue Shopping</a></td>
							<td colspan="2"><a href="checkout.php" class="btn btn-primary">Checkout</a></td>
						</tr> -->
					<?php
					else :
						?>
						<tr><td class='message' colspan='5'>Your shopping cart is empty</td></tr>
						<tr><td colspan="5"><a href="shop.php" class="btn btn-primary"><i class="fa fa-reply"></i> Shopping</a></td></tr>
						<?php
					endif;
				?>
			</tbody>
		</table>
	</div>
</body>
</html>