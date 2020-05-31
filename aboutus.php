
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>About Us</title>
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
				width: 1024px;
				max-width: 100%;
				margin: 0 auto;
				border-radius: 5px;
				background-color: #fff;
				box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.4);
				margin-top: 80px;
				padding: 10px;
				color: #555;
			}
			.header {
				text-align: center;
				color: #777;
				font-size: 2em;
				border-bottom: 1px solid #eee;
				padding: 5px 0 3px 0;
				margin-bottom: 15px;
			}
			.active {
				background-color: #ddd;
			}
		</style>
	</head>
	<body>
		<nav class="navbar">
			<li><a href="index.php" class="brand"><img src="images/logo.png" width="63px"></a></li> <!-- HEALTHY MOVES -->
			<li><a href="index.php">Healthy Moves Online Store</a></li>
			<li style="visibility: hidden;">
				<input type="search" name="seach" id="search-bar" class="search-bar" placeholder="type to search...">
				<button type="button" name="go" class="btn-search">Go</button>
			</li>
			<li><a href="shop.php"><i class="fa fa-shopping-cart"></i> Shopping</a></li>
			<li class="active"><a href="aboutus.php"><i class="fa fa-info-circle"></i> About Us</a></li>
			<li><a href="contactus.php"><i class="fa fa-envelope-o"></i> Contact Us</a></li>
			<!-- <li><a href="account/login.php">Login/Signup</a></li> -->
		</nav>

		<div class="container">
			<div class="header"><i class="fa fa-info-circle"></i> About Us</div>
			<p>
				Healthy Moves is a small company. That aims to promote a healthy lifestyle. We started originally in 2017. We live in a world where health comes first. So we as Healthy Moves we have partners with various pharmacies to sell health supplements. <p>We currently sell the following supplements:
			</p>
				<div>1) Weight-loss</div>
				<div>2) Weight-gain</div>
				<div>3) Nutrition</div>
				<div>4) Vitamins</div>
			<p>
				If you have any questions about our supplements or any health/food supplement related matter, please contact us on:
			</p>
				<div><i class="fa fa-mobile"></i> Cell:&nbsp;061 461 3379</div>
				<div><i class="fa fa-phone"></i> Tell:&nbsp;&nbsp;012 055 7823</div>
				<div><i class="fa fa-envelope"></i> Email:&nbsp;info@healthymoves.co.za</div>
			<p>
				And if we do not have information or supplements that you are looking for, we are happy to assist or direct you to where you might find it.<br>
				<center>Quickly drop us a message <a href="contactus.php">here</a> tell us more of what you were looking for.</center>
			</p>
			<hr/>
			<center>
				<em>We wish you good health and happiness</em><br/>
				<small>Healthy Moves Team</small>
			</center>
		</div>
	</body>
</html>