<?php

	//index page Healthy Moves

?>
<!DOCTYPE html>
<html>
<head>
	<title>Healthy Moves | Home page</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
		/*.navbar > li:nth-child(4),li:nth-child(5),li:nth-child(6),li:nth-child(7) {
			right: -50px;
		}*/
		.navbar > li > a {
			text-decoration: none;
			color: #0c8e7e;
		}
		.brand {
			position: absolute;
			top: -5px;
			font-weight: bold;
		}
		.welcome {
			width: 100%;
			text-align: center;
			background-color: #fff;
			margin-top: 50px;
		}
		.products {
			position: absolute;
			left: 0;
			width: 100%;
			height: auto;
			background-color: #e5e5e5;
			text-align: center;
			padding-bottom: 15px;
		}
		.logo {
			width: 550px;
		}
		.cat-item {
			position: relative;
			width: 250px;
			max-width: 100%;
			height: 300px;
			background-color: #f5f5f5;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			margin-top: 10px;
			margin-right: 15px;
			display: inline-block;
			text-align: center;
			padding: 10px;
			border-radius: 5px;
			visibility: hidden;
		}
		.cat-item > img {
			width: 200px;
			max-width: 100%;
			height: 200px; 
		}
		.cat-title {
			color: #80b0a9;
			font-weight: bold;
			font-size: 1.2em;
			text-decoration: none;
		}
		.cat-title:hover {
			color: #0c8e7e;
		}
		.heading {
			background-color: #0c8e7e;
			color: #fff;
			padding: 10px 0;
			margin-top: 0px;
		}
		.cat-item:nth-child(2) {
			animation: bounceIn .5s ease-in forwards, wave 1.5s ease-in-out forwards;
			-webkit-animation-delay: 1s, 6s;
		}
		.cat-item:nth-child(3) {
			animation: bounceIn .5s ease-in forwards, wave 1.5s ease-in-out forwards;;
			-webkit-animation-delay: 1.5s, 6.5s;
		}
		.cat-item:nth-child(4) {
			animation: bounceIn .5s ease-in forwards, wave 1.5s ease-in-out forwards;
			-webkit-animation-delay: 2s, 7s;
		}
		.cat-item:nth-child(5) {
			animation: bounceIn .5s ease-in forwards, wave 1.5s ease-in-out forwards;;
			-webkit-animation-delay: 2.5s, 7.5s;
		}
		@keyframes bounceIn {
			0% { 
				transform: translateX(-550px);
			}
			85% {
				transform: translateX(10px);
			}
			100% {
				transform: translateX(0px); visibility: visible;
			}
		}
		.search-bar {
			width: 250px;
			max-width: 100%;
			height: 33px;
			padding: 2px 5px;
			font-size: 16px;
			border-radius: 5px 0 0 5px;
			border: 1px solid #ccc;
			color: #777;
			text-indent: 2px;
		}
		.btn-search {
			position: relative;
			top: -1px;
			right: 5px;
			width: 60px;
			padding: 8px 0;
			background-color: #45a89a;
			color: #fff;
			border-radius: 0 5px 5px 0;
			font-weight: bold;
			border: none;
			cursor: pointer;
		}
		.btn-search:hover {
			background-color: #80b0a9;
			color: #fff;
		}
		.btn-search:active {
			background-color: #0c8e7e;
			color: #fff;
		}
	</style>
	<script type="text/javascript">
		/*function search() {
			var term = document.getElementById('search-bar').value;
				if(term=='' && term <= 2) {
					alert('Please type something to search');
					return false
				}
			var xhr;
			xhr = new XMLHttpRequest();
			document.getElementById('results').innerHTML = "<span class='loader'>Please wait...</span>";
			xhr.open("GET", "router.php?search="+term, true);
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById('results').innerHTML = xhr.responseText;
				}
			}
			xhr.send();
		}*/
		
	</script>
</head>
<body>
	<nav class="navbar">
		<li><a href="index.php" class="brand"><img src="images/logo.png" width="65px"></a></li> <!-- HEALTHY MOVES -->
		<li><a href="index.php">Healthy Moves Online Store</a></li>
		<li style="visibility: hidden;">
			<input type="search" name="seach" id="search-bar" class="search-bar" placeholder="type to search...">
			<button type="button" name="go" class="btn-search" onclick="search()">Go</button>
		</li>
		<li><a href="shop.php"><i class="fa fa-shopping-cart"></i> Shopping</a></li>
		<li><a href="aboutus.php"><i class="fa fa-info-circle"></i> About Us</a></li>
		<li><a href="contactus.php"><i class="fa fa-envelope"></i> Contact Us</a></li>
		<li><a href="account/login.php"><i class="fa fa-lock"></i> Login/Signup</a></li>
	</nav>

	<div class="welcome">
		<img src="images/logo.png" class="logo">
	</div>
	<div class="products" id="results">

		<h1 class="heading">Our Main Categorires</h1>
		<div class="cat-item">
			<img src="images/lifegain.jpg" />
			<a href="shop.php" class="cat-title">
				<p>Nutrition</p>
			</a>
		</div>
		<div class="cat-item">
			<img src="images/fatburntablets.jpg" />
			<a href="shop.php" class="cat-title">
				<p>All Supplements</p>
			</a>
		</div>
		<div class="cat-item">
			<img src="images/lavax.jpg" />
			<a href="shop.php" class="cat-title">
				<p>Vitamins</p>
			</a>
		</div>
		<div class="cat-item">
			<img src="images/GummyVitesVitaminC.jpg" />
			<a href="shop.php" class="cat-title">
				<p>Supplements</p>
			</a>
		</div>
		
	</div>
</body>
</html>