<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Healthy Moves | Contact Us</title>
		<link rel="stylesheet" type="text/css" href="styles/font-awesome/css/font-awesome.css">
		<style type="text/css">
			body {
			font-family: helvetica, arial;
			}
			.navbar {
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				background-color: rgba(255, 255, 255, 0.5);
				box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.2);
				z-index: 5;
			}
			.navbar > li {
				position: relative;
				list-style-type: none;
				display: inline-block;
				padding: 15px;
			}
			.navbar > li > a:hover {
				color: #80b0a9;
			}
			.navbar > li:nth-child(1),li:nth-child(2),li:nth-child(3) {
				margin-left: 50px;
			}
			.navbar > li:nth-child(4),li:nth-child(5),li:nth-child(6),li:nth-child(7) {
				right: -80px;
			}
			.navbar > li > a {
				text-decoration: none;
				color: #0c8e7e;
			}
			.brand {
				position: absolute;
				top: -5px;
				font-weight: bold;
			}
			.container {
				width: 500px;
				max-width: 100%;
				margin: 0 auto;
				border-radius: 5px;
				background-color: #fff;
				box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.4);
				margin-top: 80px;
				padding: 10px;
			}
			.btn {
				position: relative;
				width: 150px;
				padding: 15px 5px;
				background-color: #45a89a;
				color: #fff;
				border-radius: 5px;
				font-weight: bold;
				border: none;
				cursor: pointer;
				box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.4);
			}
			.btn:hover {
				background-color: #80b0a9;
				color: #fff;
			}
			.btn:active {
				background-color: #0c8e7e;
				color: #fff;
			}
			.form-group {
				margin-bottom: 15px;
			}
			.form-input {
				width: 480px;
				max-width: 100%;
				/*height: 33px;*/
				padding: 10px;
				font-size: 16px;
				border-radius: 5px;
				border: 1px solid #ccc;
				color: #777;
				text-indent: 2px;
			}
			textarea {
				resize: none;
			}
			.header {
				text-align: center;
				color: #777;
				font-size: 2em;
				border-bottom: 1px solid #eee;
				padding: 5px 0 3px 0;
				margin-bottom: 15px;
			}
			label {
				font-size: .85em;
				color: #777;
			}
			@media screen and (min-width: 480px) {
				label {
					display: none;
				}
			}
			.alert-message {
				width: 32%;
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
			.alert-message.error {
				background: #f2dede;
				color: #a94442;
				border: 1px solid #a94442;
			}
			.alert-message.success{
				background: #dff0d8;
				color: #3c763d;
				border: 1px solid #3c763d;
			}
			.active {
				background-color: #ddd;
			}
		</style>
	</head>
	<body>
		<nav class="navbar">
			<li><a href="index.php" class="brand"><img src="images/logo.png" width="62px"></a></li> <!-- HEALTHY MOVES -->
			<li><a href="index.php">Healthy Moves Online Store</a></li>
			<li style="visibility: hidden;">
				<input type="search" name="seach" id="search-bar" class="search-bar" placeholder="type to search...">
				<button type="button" name="go" class="btn-search">Go</button>
			</li>
			<li><a href="shop.php"><i class="fa fa-shopping-cart"></i> Shopping</a></li>
			<li><a href="aboutus.php"><i class="fa fa-info-circle"></i> About Us</a></li>
			<li class="active"><a href="contactus.php"><i class="fa fa-envelope-o"></i> Contact Us</a></li>
			<!-- <li><a href="account/login.php">Login/Signup</a></li> -->
		</nav>
		
		<div class="container">
			<div class="header"><i class="fa fa-envelope"></i> Contact Us</div>
			<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
				<div class="form-group">
					<div><label>Name:</label></div>
					<input type="text" name="name" class="form-input" placeholder="Enter your name">
				</div>
				<div class="form-group">
					<div><label>Email :</label></div>
					<input type="email" name="email" class="form-input" placeholder="Enter your email">
				</div>
				<div class="form-group">
					<div><label>Cellphone:</label></div>
					<input type="text" name="phone" class="form-input" placeholder="Enter your phone number">
				</div>
				<div class="form-group">
					<div><label>Subject:</label></div>
					<input type="text" name="subject" class="form-input" placeholder="Enter your subject">
				</div>
				<div class="form-group">
					<div><label>Message:</label></div>
					<textarea class="form-input" rows="4" name="message" placeholder="Type your message here..."></textarea>
				</div>
				<div class="form-group">
					<button type="submit" name="send" class="btn">Send Message</button>
				</div>
			</form>
		</div>
		<?php
			$action = (isset($_GET['action'])) ? $_GET['action'] : '';
			switch ($action) {
				case 'success':
					echo '<div class="alert-message success">Your message was sent successfully!</div>';
				break;
				case 'failed':
					echo '<div class="alert-message error">Sorry failed to send message, try again!</div>';
				break;
				case 'null':
					echo '<div class="alert-message error">Please fill all required fields!</div>';
				break;
			}
		?>
	</body>
</html>