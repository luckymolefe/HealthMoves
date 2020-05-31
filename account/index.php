<?php

	require_once('router.php');
	$customer->page_protected();
	$profile = $customer->getCustomer($_SESSION['customer']['uid']);
	$allcards = $customer->getAllCards($_SESSION['customer']['uid']);

	$message_path = $basepath."/promotions/";
	$messages = scandir($message_path);
	array_shift($messages); //remove (.)
	array_shift($messages); //remove (..)
	$mgs_count = count($messages);
	$mgsCounter = ($mgs_count > 0) ? '<sup class="counter-alert">'.$mgs_count.'</sup>' : '';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Healthy Moves | Shopping</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../styles/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="../styles/animate.css">
	<style type="text/css">
		body {
			font-family: helvetica, arial;
		}
		.container-menu {
			position: fixed;
			top: 0px;
			left: 0px;
			width: 300px;
			max-width: 100%;
			height: 700px;
			overflow-y: auto;
			background-color: #0c8e7e;
			z-index: 5;
			display: inline-block;
		}
		.container-item {
			position: absolute;
			top: 5px;
			left: 320px;
			width: 950px;
			max-width: 100%;
			height: 580px;
			overflow-y: auto;
			margin: 0 auto;
			background-color:  #f5f5f5;/*rgba(255, 255, 255, 0.5);*/
			padding: 5px 10px;
			display: inline-block;
			box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
		}
		.menu-heading {
			background-color: #0c8e7e;
			color: #fff;
			font-size: 1.8em;
			padding: 10px 0;
			text-align: center;
		}
		.menu-item {
			margin-bottom: 2px;
			background-color: #005555;
			border-left: 5px solid #6666bb; /*#4444bb;*/
			/*background: -webkit-linear-gradient(#45a89a, #78eddf);*/
			color: #fff;
			padding: 15px 2px;
			cursor: pointer;
			font-weight: bold;
			text-indent: 5px;
		}
		.menu-item:hover {
			background-color: #034f99;
			/*background: -webkit-linear-gradient(#eee, #bbb);*/
			border-left: 5px solid #00ff00;/*#4444bb;*/
		}

		a {
			text-decoration: none;
		}
		
		.message {
			font-weight: bold;
			font-size: 1.2em;
			color: #dd0000;
		}
		.error-message {
			font-weight: bold;
			font-size: 1.2em;
			color: #dd0000;
			text-align: center;
		}
		
		.loader {
			position: relative;
			top: 150px;
			color: #777;
			font-size: 1.5em;
			margin-left: 40%;
		}
		.profile-avatar {
			text-align: center;
			border-bottom: 2px solid grey;
			padding-bottom: 10px;
			margin-bottom: 5px;
			color: #fff;
		}
		.profile-avatar > img {
			width: 120px;
			border-radius: 50%;
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
		.info-table {
			width: 100%;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		}
		.info-table tr {
			background-color: #fff;
			color: #777;
		}
		.info-table tr td {
			padding: 5px;
			font-size: 1.2em;
		}
		.info-table tr:first-child {
			background-color: green;
			color: #fff !important;
			text-align: center;
			font-size: 1.3em;
		}
		.card-list {
			width: 40%;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			padding: 15px 15px;
			margin-top: 20px;
			margin-right: 10px;
			border-radius: 5px;
			font-size: 1.2em;
			display: inline-block;
		}
		.card-list div:nth-child(1) {
			position: absolute;
			color: #dd6666;
			border-radius: 5px;
			padding: 5px;
			cursor: pointer;
			margin-top: -10px;
		}
		.card-list > .span {
			position: absolute;
			float: left;
			color: #dd6666;
			border-radius: 5px;
			padding: 5px;
			cursor: pointer;
			margin-top: -12px;
		}
		.card-list > img {
			position: relative;
			top: -5px;
			right: -310px;
			margin-bottom: 10px;
		}
		.card-list div:nth-child(3) {
			border: thin solid #777;
			border-radius: 5px;
			padding: 5px;
			margin-bottom: 10px;
		}
		.card-list div:nth-child(4) {
			width: 15%;
			border: thin solid #777;
			border-radius: 5px;
			padding: 5px;
			display: inline-block;
			margin-bottom: 10px;
		}
		.card-list div:nth-child(5) {
			width: 15%;
			border: thin solid #777;
			border-radius: 5px;
			padding: 5px;
			display: inline-block;
			margin-bottom: 10px;
		}
		.card-list div:nth-child(6) {
			border: thin solid #777;
			border-radius: 5px;
			padding: 5px;
			margin-bottom: 10px;
		}
		.counter-alert {
			position: relative;
			background-color: #dd6666; /*#5bc0de;*/
			border-radius: 50px;
			padding: 4px 8px;
			color: #fff;
		}
	</style>
	<script type="text/javascript">
		//switch to chosen request
		function runQuery(action) {
			switch(action) {
				case 'orders':
					doActionAjax(action);
				break;
				case 'messages':
					doActionAjax(action);
				break;
				case 'payment':
					doActionAjax(action);
				break;
				case 'editpayment':
					doActionAjax(action);
				break;
				case 'profileedit':
					doActionAjax(action);
				break;
				case 'settings':
					doActionAjax(action); //call to Ajax function and pass query string as parameter
				break;
				case 'account':
					doActionAjax(action); //call to Ajax function and pass query string as parameter
				break;
				case 'mycart':
					window.location.href = "../cart.php";
				break;
				case 'shop':
					window.location.href = "../shop.php";
				break;
			}
		}
		//run Ajax call to fetch data
		function doActionAjax(param, args) {
			var url = (args=='') ? param+'.php' : param+'.php?cardNumber='+args;
			var xhr;
			xhr = new XMLHttpRequest(); //create xmlhttprequest object
			document.getElementById('results').innerHTML = "<span class='loader'>Please wait...</span>";
			xhr.open("GET", url, true); //open url, pass queryString to the requested url
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById('results').innerHTML = xhr.responseText; //display results
				}
				if(xhr.status == 404) {
					document.getElementById('results').innerHTML = "Error 404: Url not found"; //display results
				}
			}
			xhr.send(); //finally send query
		}

		function cardValidation(event) {
			var card_data = event.value;
			if(card_data.length == 4) {
				card_data += '-';
			}
			else if(card_data.length == 9) {
				card_data += '-';
			}
			else if(card_data.length == 14) {
				card_data += '-';
			}
			return event.value = card_data;
		}

		function popupClose(event) {
			event.parentNode.classList.add('fadeOut');
			setTimeout(function() {
				event.parentNode.style.display = "none";
			}, 800);
		}

		function confirmRemove() {
			var remove = confirm('Remove card?');
			if(remove==false) {
				return false;
			}
		}

		function confirmLogoff() {
			var logout = confirm('You want to logout?');
			if(logout==false) {
				return false;
			}
		}
		function viewInvoice(invoiceID) {
			var xhr;
			xhr = new XMLHttpRequest(); //create xmlhttprequest object
			document.getElementById('layer').style.display = "block";
			document.getElementById('layer').innerHTML = "<span class='loader'>Please wait...</span>";
			xhr.open("GET", "invoices.php?invoiceid="+invoiceID, true); //open url, pass queryString to the requested url
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById('layer').innerHTML = xhr.responseText; //display results
				}
				if(xhr.status == 404) {
					document.getElementById('layer').innerHTML = "Error 404: Url not found"; //display results
				}
			}
			xhr.send(); //finally send query
		}

	</script>
</head>
<body>
	<div id="layer"></div>
	<nav class="container-menu">
		<div class="profile-avatar">
			<div class="menu-heading">My Profile</div>
			<img src="../images/avatar.png">
			<div><?php echo $profile->firstname.' ' .$profile->lastname; ?></div>
			<div><?php echo $profile->email; ?></div>
		</div>
		<a href="index.php"><div class="menu-item"><i class="fa fa-home"></i> Home</div></a>
		<?php if(!empty($_SESSION['cart'])) : ?>
			<div class="menu-item" onclick="runQuery('mycart')"><i class="fa fa-shopping-basket"></i> myCart<sup class="counter-alert"><?php (isset($_SESSION['cart'])) ? print count($_SESSION['cart']) : print 0; ?></sup></div>
		<?php else: ?>
			<div class="menu-item" onclick="runQuery('shop')"><i class="fa fa-shopping-cart"></i> Shop</div>
		<?php endif; ?>
		<div class="menu-item" onclick="runQuery('orders')"><i class="fa fa-cubes"></i> Orders</div>
		<div class="menu-item" onclick="runQuery('messages')"><i class="fa fa-bell-o"></i> Messages<?php echo $mgsCounter; ?></div>
		<!-- <div class="menu-item" onclick="runQuery('payment')"><i class="fa fa-credit-card"></i> Payment details</div> -->
		<!-- <div class="menu-item" onclick="runQuery('profileedit')"><i class="fa fa-user"></i> My Account</div> -->
		<div class="menu-item" onclick="runQuery('settings')"><i class="fa fa-cogs"></i> Settings</div>
		<a href="router.php?logout=true" onclick="return confirmLogoff()"><div class="menu-item"><i class="fa fa-power-off"></i> Logout</div></a>
	</nav>

	<div class="container-item" id="results">
		<?php
			$action = (isset($_GET['action'])) ? $_GET['action'] : '';
			switch ($action) {
				case 'null':
					echo '<div class="popup-message error">Please provide all required fields<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
				case 'failed':
					echo '<div class="popup-message error">Failed to process record!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
				case 'invalid':
					echo '<div class="popup-message error">Invalid credit card number!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
				case 'updated':
					echo '<div class="popup-message success">Record updated successfully!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
				case 'success':
					echo '<div class="popup-message success">Card added successfully!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
				break;
			}
		?>
		<table class="info-table">
			<tr>
				<td colspan="2">Personal Details</td>
			</tr>
			<tr>
				<td>Fullname:</td>
				<td colspan="2"><?php echo $profile->firstname.' '.$profile->lastname; ?></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><?php echo $profile->email; ?></td>
			</tr>
			<tr>
				<td>Phone:</td>
				<td><?php echo $profile->phone; ?></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><?php echo $profile->address; ?></td>
			</tr>
		</table>
		<?php if($allcards != false): ?>
			<?php foreach($allcards as $card): ?>
				<?php $logo = ($card->card_type == 'visa') ? 'visa_logo.jpg' : 'mastercard_logo.jpg'; ?>
			<div class="card-list">
				<div onclick="doActionAjax('editpayment','<?php echo $card->card_number; ?>')">Edit Card</div>
				<img src="../images/<?php echo $logo; ?>" width="70">
				<!-- <div><?php echo $card->card_type; ?></div> -->
				<div><?php echo $card->card_number; ?></div> <!-- $customer->data_decrypt( -->
				
				<div><?php echo $card->exp_month.'/'.$card->exp_year; ?></div>
				
				<div><?php echo $card->card_value; ?></div>
			
				<div><?php echo $card->holder_name; ?></div>
				<a href="router.php?removecard=true&cardnum=<?php echo $card->card_number; ?>" onclick="return confirmRemove();"><span class="span">Remove Card</span></a>
			</div>
			<?php endforeach ?>
		<?php endif; ?>
	</div>
	<script type="text/javascript">
		function alertMessage() {
			return alert('Please update your address first');
		}
		function checkAddress() {
			var addr = "<?php echo $profile->address; ?>"; //get address value
			if(addr.length <= 0 || addr=='') { //if address value is null/empty
				runQuery('profileedit'); //open profile edit to update address
				var elements = document.getElementsByClassName('menu-item');
				for (var i = 1; elements.length; i++) {
					elements[i].setAttribute('onclick',"alertMessage();"); //loop through all elements to disable navigation unitl address is updated
				}
				/*elms[0].setAttribute('onclick',"alertMessage();");*/
			}
		}
		checkAddress();
	</script>
</body>
</html>