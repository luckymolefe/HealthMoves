<?php
	//checkout page
	require_once('router.php');
	if(!empty($_SESSION['cart'])) {
		if(isset($_SESSION['customer']['token'])) {
			$mycards = $customer->getAllCards($_SESSION['customer']['uid']);
			$user = $customer->getCustomer($_SESSION['customer']['uid']);
			//generate new Order number if not exists, when customer opens checkout page 
			if(empty($_SESSION['customer']['orderNum'])) {
				$_SESSION['customer']['orderNum'] = $order->generateOrderNumber();
			}
			$orderNum = $_SESSION['customer']['orderNum']; //else return order number
		}
		else {
			$message = "<div class='message-popup'>Please <a href='account/login.php'>login</a> or <a href='account/register.php'>register</a> to checkout.<span class='closeMsg' title='Close' onclick='goShop()'>&times;</span></div>";
		}
	}
	else {
		header("Location: cart.php");
		exit();
	}
	
	$creditcards = array('visa'=>'Visa Card', 'mastercard'=>'Master Card', 'discover'=>'Discover Card');
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Healthy Moves | Customer Checkout</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewpoint" content="width=device-width, initital-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome/css/font-awesome.css">
	<style type="text/css">
	* {
		font-family: helvetica, arial;
	}
	.container {
		width: 1280px;
		max-width: 100%;
		margin: 0 auto;
		padding: 10px;
	}
	.container-item {
		position: relative;
		left: 0;
		width: 600px;
		border-radius: 5px;
		max-width: 100%;
		background-color: #fff;/*#0c8e7e;*/
		color: #777;
		padding: 10px;
		display: inline-block;
	}
	.cart-container {
		position: absolute;
		top: 20px;
		right: 250px;
		width: 400px;
		border-radius: 5px;
		max-width: 100%;
		background-color: #fff;
		color: #777;
		padding: 10px;
		display: inline-block;
	}
	.message-popup {
		position: absolute;
		top: -100px;
		left: 500px;
		z-index: 5;
		width: 300px;
		border: 4px solid #dd5555;
		background-color: #ff9999;
		color: #dd0000;
		border-radius: 0px;
		padding: 15px 8px 15px 8px;
		animation: drop 0.8s ease forwards;
		box-shadow: 1px 1px 6px rgba(0, 0, 0, 0.3);
		font-weight: bold;
	}
	.closeMsg {
		position: absolute;
		top: -15px;
		left: 300px;
		font-size: 1.5em;
		border: 2px solid #dd5555;
		padding: 0 7px 0 7px;
		border-radius: 50%;
		background-color: #f5f5f5; /*rgba(255, 255, 255, 0.9);*/
		box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.3);
	}
	.closeMsg:hover {
		cursor: pointer;
		background-color: #dd5555; /*rgba(0, 0, 0, 0.2);*/
		color: #fff;
		border-color: #fff;
	}
	@keyframes drop {
		0% {}
		70% { transform: translateY(170px) }
		100% { transform: translateY(150px) }
	}
	@media screen and (max-width: 800px) {
		.message-popup {
			left: 200px;
		}
	}
	@media screen and (max-width: 560px) {
		.message-popup {
			left: 40px;
		}
	}
	li {
		display: inline-block;
	}
	.card {
		background-color: #fff; /*rgb(231, 36, 53);*/
		border: thin solid #dd4444;
		border-radius: 3px;
		padding: 10px;
		box-shadow: inset -1px -2px 8px rgba(255, 255, 255, 0.5), 1px 2px 8px rgba(0, 0, 0, 0.5);
		display: none;
	}
	.input-group {
		margin-top: 5px;
	}
	label {
		font-size: .88em;
	}
	select, [type="password"], input[type="text"] {
		border: 1px solid #ccc;
		background-color: #dd5555;
		color: #fff;
		border-radius: 5px;
		padding: 5px 5px;
		font-size: 1em;
	}
	
	.head {
		font-size: 1.2em;
		font-weight: bold;
		border-bottom: thin solid #eee;
		margin-top: 19px;
	}
	table {
		width: 100%;
		border: none;
	}
	table tr td {
		padding: 5px 2px;
	}
	table tr:nth-of-type(4) td {
		border-bottom: 3px solid #fff;
	}
	.btn {
		width: 150px;
		border: none;
		background-color: rgb(231, 36, 53);
		color: #fff;
		padding: 15px 2px;
		cursor: pointer;
		font-weight: bold;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
	}
	.btn-edit {
		background-color: #0c8e7e;
		color: #fff;
	}
	.btn-update {
		background-color: #0c8e7e;
		color: #fff;
	}
	.btn-pay:hover,.btn-edit:hover, .btn-update:hover {
		background-color: #80b0a9;
	}
	.btn-pay:active {
		background-color: transparent;
		color: rgb(231, 36, 53);
		border: thin solid rgb(231, 36, 53);
		outline: 0 none;
	}
	#eft {
		display: block;
	}
	#ccard {
		display: none;
	}
	#deposit {
		display: none;
	}
	.totalpay {
		font-size: 1.3em;
		color: #0c8e7e;
	}
	.error-message {
		color: #ff5555;
		font-weight: bold;
		animation: pulse 1.8s linear infinite;
		-webkit-animation-delay: 2.5s;
	}
	@keyframes pulse {
		0%  { opacity: 0; }
		100%  { opacity: 1; }
	}
	.popup-message {
		position: relative;
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
		z-index: 2;
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
		function updateCart() {
			var update = confirm('Update shopping cart?');
			if(update==false) {
				return false;
			}
			window.location.href = "cart.php";
		}
		function continueCheckout() {
			var checkout = confirm('You want to checkout now?');
			if(checkout==false) {
				return false;
			}
		}
		function goedit() {
			var edit = confirm('You want to edit address?');
			if(edit==false) {
				return false;
			}
			window.location.href = "account/";
		}
		function goShop() {
			window.location.href = "shop.php";
		}
		function payMethod() {
			var payMethod = document.forms[0].payment.value;
			if(payMethod=="eft") {
				document.getElementById('eft').style.display = "block";
				document.getElementById('deposit').style.display = "none";
				document.getElementById('ccard').style.display = "none";
				document.getElementById('placeorder').innerHTML = "Place Order";
				document.forms[4].pay_method.value = "eft";
			}
			if(payMethod=="deposit") {
				document.getElementById('deposit').style.display = "block";
				document.getElementById('eft').style.display = "none";
				document.getElementById('ccard').style.display = "none";
				document.getElementById('placeorder').innerHTML = "Place Order";
				document.forms[4].pay_method.value = "bankdeposit";
			}
			if(payMethod=="creditcard") {
				document.getElementById('ccard').style.display = "block";
				document.getElementById('eft').style.display = "none";
				document.getElementById('deposit').style.display = "none";
				document.getElementById('placeorder').innerHTML = "Pay Now";
				document.forms[4].pay_method.value = "creditcard";
			}
		}
		function paySelect(event) {
			var selectedCardNum = event.value;
			// document.forms['cardselect'].payment_method
			var xhr;
			xhr = new XMLHttpRequest(); //create xmlhttprequest object
			xhr.open("GET", "router.php?selectedcard=true&card_number="+selectedCardNum, true); //open url, pass queryString to the requested url
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					var data = JSON.parse(xhr.responseText); //display results
					if(data.message == "success") {
						document.getElementById('cardNumber').value = data.cardnum;
						document.getElementById('cardExpiry').value = data.exp_date;
						document.getElementById('cardvalue').value = data.card_value;
						if(data.card_type=="visa") {
							logo = "visa_logo.jpg";
						}
						else {
							logo = "mastercard_logo.jpg";
						}
						document.getElementById('card_logo').src = "images/"+logo;
					} else {
						return alert(data.message);
					}
				}
				if(xhr.status == 404) {
					alert("Error 404: Url not found"); //display error message 404 page not found
				}
			}
			xhr.send(); //finally send query
		}

		function popupClose(event) {
			event.parentNode.classList.add('fadeOut');
			setTimeout(function() {
				event.parentNode.style.display = "none";
			}, 800);
		}
		
	</script>
</head>
<body>
	<?php
		if(isset($message)) {
			echo $message;
			exit();
		}
	?>
	<div class="container">
		<?php
			$action = (isset($_GET['action'])) ? $_GET['action'] : '';
			switch ($action) {
				case 'null':
					echo '<div class="popup-message error">Please check all required information<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
				case 'failed':
					echo '<div class="popup-message error">Failed to process order, please try again!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
				case 'agreeterms':
					echo '<div class="popup-message error">Please accept our terms and conditions!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
			}

		?>
		<div class="container-item">
			<h2>BILLING INFORMATION:</h2>
			<div>
				<h4>Choose Payment Method</h4>
				<form action="" method="POST" enctype="application/x-www-forms-urlencoded">
				<li><label><input type="radio" name="payment" onclick="payMethod(this.value);" value="eft" checked="checked">EFT</label></li>
				<li><label><input type="radio" name="payment" onclick="payMethod(this.value);" value="deposit">Bank Deposit</label></li>
				<li>
					<label><input type="radio" name="payment" onclick="payMethod(this.value);" value="creditcard">Credit Card
					<img src="images/payment_logo_1.jpg" alt="visa_logo" style="width:80px;position:relative; top:5px;"></label>
				</li>
				</form>
				<hr/>
			</div>
			<div>
				<h4>BILLING INFORMATION:</h4>
				<p><?php echo $user->fullname; ?></p>
				<p><?php echo $user->email; ?></p>
				<p><?php echo $user->phone; ?></p>
				<!-- <hr/> -->
				<h4>DELIVERY INFORMATION:</h4>
				<?php if(!empty($user->address)) : ?>
				<p><?php echo $user->address; ?></p>
				<?php else: ?>
				<p class="error-message">Please update your address!!</p>
				<?php endif; ?>
				<p><button type="button" name="edit_addr" class="btn btn-edit" onclick="return goedit()"><i class="fa fa-pencil"></i> Edit</button></p>
				<hr/>
			</div>
		</div>
		<div class="cart-container">
			<div class="payment-option" id="pay-option">
				<!-- Credit card -->
				<div class="card" id="ccard">
				<?php if($mycards != false) : ?>
					<form action="" method="POST" name="cardselect" enctype="application/x-www-forms-urlencoded">
					<div class="input-group">
						<div><label>Select Card:</label></div>
						<select name="payment_method" id="payment_method" onclick="paySelect(this)">
							<?php if($mycards != false) : ?>
							<?php foreach($mycards as $card) :
								$path = null;
								if($card->card_type=="mastercard") {
									$card->card_type = 'Master Card';
									$cardNum = str_repeat('*', strlen($card->card_number)-4).substr_replace($card->card_number, '', 0,strlen($card->card_number)-4);
									$cardValid = $card->exp_month.'/'.$card->exp_year;
									$cardValue = $card->card_value;
									$path = "images/mastercard_logo.jpg";
								}
								elseif($card->card_type=="visa") {
									$card->card_type = 'Visa';
									$cardNum = str_repeat('*', strlen($card->card_number)-4).substr_replace($card->card_number, '', 0,strlen($card->card_number)-4);
									$cardValid = $card->exp_month.'/'.$card->exp_year;
									$cardValue = $card->card_value;
									$path = "images/visa_logo.jpg";
								}
								else {
									$card->card_type = 'Discover';
								}
							?>
							<option value="<?php echo $card->card_number; ?>" ><?php echo $card->card_type; ?></option>
							<?php endforeach; ?>
							<?php else: ?>
							<option value="" style="color:red;"><?php echo "Please add credit card"; ?></option>
							<?php $cardNum = null; $cardValid = null; $cardValue = null; ?>
							<?php endif; ?>
						</select>
						<img src="<?php echo $path; ?>" id="card_logo" style="width:50px;position:relative; top:8px;">
					</div>
					<div class="input-group">
					<div><label>Card Number:</label></div>
					<input type="text" name="card_number" id="cardNumber" maxlenght="19" disabled value="<?php echo $cardNum; ?>" style="width:80%">
					</div>
					<div class="input-group">
						<div><label>Valid Thru:</label>
						&nbsp;&nbsp;&nbsp;
						<label>CVV/CVC:</label></div>
						<input type="text" name="card_exp_month" maxlength="5" id="cardExpiry" disabled value="<?php echo $cardValid; ?>" style="width:50px">
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="password" name="card_exp_year" maxlength="4" id="cardvalue" disabled value="<?php echo $cardValue; ?>" style="width:50px">
					</div>
					</form>
				<?php else: ?>
					<div>You Have No Credit Card</div>
				<?php endif; ?>
				</div>
				<!-- EFT -->
				<div class="card" id="eft">
					<h4>EFT:</h4>
					<form action="" method="POST" enctype="application/x-www-forms-urlencoded">
						<input type="hidden" name="payment_method" value="deposit">
					</form>
					<table>
						<tr>
							<td>Bank Name:</td>
							<td>FNB</td>
						</tr>
						<tr>
							<td>Account Number:</td>
							<td>926421005</td>
						</tr>
						<tr>
							<td>Account Name:</td>
							<td>Healthy Moves</td>
						</tr>
						<tr>
							<td>Reference Number:</td>
							<td><em><?php echo $orderNum; ?></em></td>
						</tr>
					</table>
				</div>
				<!-- EFT END -->
				<!-- DEPOSIT -->
				<div class="card" id="deposit">
					<h4>Bank Deposit To:</h4>
					<form action="" method="POST" enctype="application/x-www-forms-urlencoded">
						<input type="hidden" name="payment_method" value="deposit">
					</form>
					<table>
						<tr>
							<td>Bank Name:</td>
							<td>FNB</td>
						</tr>
						<tr>
							<td>Account Number:</td>
							<td>926421005</td>
						</tr>
						<tr>
							<td>Account Name:</td>
							<td>Healthy Moves</td>
						</tr>
						<tr>
							<td>Reference Number:</td>
							<td><em><?php echo $orderNum; ?></em></td>
						</tr>
					</table>
				</div>
				<!-- DEPOSIT END -->
			</div>

			<div class="head">Cart Total Checkout <button style="float:right" id="btn-print">Print <i class="fa fa-print"></i></button></div>
			<table border="0">
			<?php
				$total_qty = 0;
				$totalPrice = 0 ;
				for ($i=0; $i < count($_SESSION['cart']) ; $i++) { 
					$total_qty += $_SESSION['cart'][$i]['item_quantity'];
					$totalPrice += ($_SESSION['cart'][$i]['item_quantity'] * $_SESSION['cart'][$i]['item_price']);
				}
			?>
				<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
				<tr><td>Total Items:</td><td><?php echo $total_qty; ?></td>
				<tr><td>SubTotal:</td><td><?php echo number_format($totalPrice,2); ?></td>
				<tr><td>VAT(15%):</td><td><?php echo number_format(($totalPrice*.15),2); ?></td>
				<tr><td>Delivery:</td><td>Free</td>
				<tr class="totalpay">
					<td>Total Payable:</td>
					<td><?php echo number_format($totalPrice += ($totalPrice*.15), 2); ?></td>
				<!-- <tr>
					<td colspan="2"><center><a href=""><i class="fa fa-times"></i> Cancel Order</center></a></td>
				</tr> -->
				<tr>
					<td colspan="2"><label><input type="checkbox" id="terms" name="terms" value="agree">I agree to terms and conditions.</label></td>
				</tr>
				<tr>
					<input type="hidden" name="customer_id" value="<?php echo base64_encode($user->id); ?>">
					<input type="hidden" name="quantity" value="<?php echo $total_qty; ?>">
					<input type="hidden" name="totalpay" value="<?php echo $totalPrice; ?>">
					<input type="hidden" name="pay_method" value="eft">
					<input type="hidden" name="orderNum" value="<?php echo $orderNum; ?>">
					<td><button type="button" name="update_cart" class="btn btn-update" id="update" onclick="return updateCart()"><i class="fa fa-refresh"></i> Update Cart</button></td>
					<td><button type="submit" name="cart_checkout" class="btn btn-pay" id="placeorder" onclick="return continueCheckout()"><i class="fa fa-check"></i> Place Order</button></td>
				</form>
				</tr>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		function alertMessage() {
			return alert('Please update your address first');
		}
		function checkAddress() {
			var addr = "<?php echo $user->address; ?>"; //get address value
			if(addr.length <= 0 || addr=='') { //if address value is null/empty disable submit button
				document.getElementById('terms').setAttribute('disabled','true');
				document.getElementById('placeorder').setAttribute('disabled','true');
				document.getElementById('placeorder').style.backgroundColor = "#ddd";
				document.getElementById('placeorder').style.color = "#aaa";
			}
		}
		checkAddress();

		document.getElementById('btn-print').addEventListener('click', function() {
			location.href = "print.php";
		});
	</script>
</body>
</html>