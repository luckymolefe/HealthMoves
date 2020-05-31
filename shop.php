<?php
	require_once('router.php');
	$categories = $product->readAllCategories();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Healthy Moves | Shopping</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
			margin-left: 30px;
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
		.container-menu {
			position: fixed;
			top: 65px;
			left: 2px;
			width: 300px;
			max-width: 100%;
			height: 700px;
			background-color: #0c8e7e;
			/*margin-left: -305px;*/
			display: inline-block;
			/*animation: showMenu 1.5s forwards;*/
		}
		.container-item {
			position: relative;
			top: 65px;
			left: 320px;
			width: 950px;
			max-width: 100%;
			height: 550px;
			overflow-y: auto;
			margin: 0 auto;
			background-color: #f5f5f5;
			padding: 5px 10px;
			display: inline-block;
		}
		@keyframes showMenu {
			/*0% {transform: translateX(-300px);}
			100% {transform: translateX(300px);}*/
			0% { margin-left: -305px; }
			100% { margin-left: 0px; }
		}
		.cat-heading {
			background-color: #0c8e7e;
			color: #fff;
			padding: 5px;
		}
		.menu-heading {
			background-color: #0c8e7e;
			color: #fff;
			font-size: 2em;
			padding: 10px 0;
			text-align: center;
		}
		.menu-item {
			margin-bottom: 2px;
			background: -webkit-linear-gradient(#45a89a, #78eddf);
			color: #fff;
			padding: 15px 2px;
			cursor: pointer;
			font-weight: bold;
			text-indent: 5px;
		}
		.menu-item:hover {
			background: -webkit-linear-gradient(#eee, #bbb);
		}
		.list-item {
			width: 200px;
			height: 250px;
			background-color: #ffffff;
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			padding: 10px;
			display: inline-block;
			margin-right: 8px;
			margin-bottom: 10px;
			text-align: center;
		}
		a {
			text-decoration: none;
		}
		.pointer {
			float: right;
			font-weight: bold;
		}
		.list-item-heading {
			font-size: 1.3em;
			font-weight: bold;
			color: #0c8e7e;
		}
		.list-item-price {
			font-size: 1.5em;
			font-weight: bold;
			color: #777;
			margin-top: 10px;
		}
		.list-item-image {
			width: 120px;
			height: 120px;
		}
		.btn-add {
			width: 150px;
			border: thin solid #ccc;
			border-radius: 5px;
			background-color: #45a89a;
			color: #fff;
			padding: 8px 0;
			font-weight: bold;
			cursor: pointer;
		}
		.btn-add:hover {
			background-color: #80b0a9;
		}
		.btn-add:active {
			background-color: #0c8e7e;
		}
		input[type='number'] {
			width: 35px;
			border-radius: 5px;
			border: none;
			color: #0c8e7e;
			padding: 5px 2px;
			font-size: 1.2em;
			font-weight: bold;
			background-color: transparent;
		}
		.term-head {
			color: #dd2000;
			font-size: 1.5em;
		}
		.search-string {
			font-size: 1em;
			color: blue;
			font-weight: lighter;
			font-style: italic;
		}
		.search-item {
			padding: 20px 0 5px 10px;
			background-color: #fff;
			color: #777;
			border-bottom: thin dashed #ccc;
		}
		.search-item-title {
			font-size: 1.2em;
			font-weight: bold;
			color: #0c8e7e;
		}
		.search-item-cat {
			font-size: .88em;
			font-style: italic;
		}
		.search-message {
			font-size: 1.2em;
			font-weight: bold;
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
		.featured-item {
			position: relative;
			background-color: #d9edf7;
			width: 100%;
			border-radius: 5px;
			padding: 5px;
			text-align: center;
		}
		.featured-item > h3 {
			color: #0c8e7e;
		}
		.cart-count {
			position: fixed;
			top: 10px;
			margin-left: 0px;
			background-color: #5bc0de;
			border-radius: 50px;
			padding: 3px 8px;
			color: #fff;
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
		#popup {
			position: fixed;
			top: 18%;
			left: 40%;
			width: auto;
			max-width: 100%;
			height: auto;
			padding: 10px;
			border-radius: 5px;
			background-color: #fff;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			z-index: 2;
			display: none;
			animation: popin .4s forwards;
		}
		@keyframes popin {
			0%   { transform: scale(0); opacity: 0; }
			90%  { transform: scale(1.1); opacity: 0.85; }
			100% { transform: scale(1); opacity: 1; }
		}
		.item-view {
			width: 400px;
			height: 400px;
			max-width: 100%;
		}
		.item-viewClose {
			position: absolute;
			top: -12px;
			right: -16px;
			font-size: 1.3em;
			font-weight: bold;
			background-color: #555;
			color: #fff;
			border: thin solid #fff;
			border-radius: 50%;
			cursor: pointer;
			padding: 2px 10px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		}
		.item-viewClose:hover {
			background-color: #999;
			color: #ff0000;
		}
		.item-viewClose:active {
			color: #dd0000;
		}
		.slider {
			transform: translateX(-600px);
			animation: slideIn .8s ease-in forwards, slideOut .6s ease-in forwards;
			-webkit-animation-delay: 0s, 4.5s;
		}
		@keyframes slideIn {
			0%   { opacity: 0; transform: translateX(500px);}
			50%  { opacity: .3; transform: translateX(0px);}
			100% { opacity: 1; transform: translateX(0px); }/*right: 40px;*/
		}
		@keyframes slideOut {
			0%   { opacity: 1; transform: translateX(0px);}
			50%  { opacity: .5; }
			100% { opacity: 0; transform: translateX(-600px); }
		}
		.slides {
			position: absolute;
			top: 40%;
			font-size: 1.8em;
			background-color: #0c8e7e;
			color: #fff;
			border: thin solid #fff;
			padding: 7px 12px;
			border-radius: 50%;
			cursor: pointer;
			-webkit-box-shadow: -1px 1px 6px rgba(0, 0, 0, 0.4);
			box-shadow: -1px 1px 6px rgba(0, 0, 0, 0.4);
			z-index: 1;
		}
		.left {
			left: 40px;
		}
		.right {
			right: 40px;
		}
		.left:hover, .right:hover {
			background-color: #4863A0;
			color: #fff;
		}
		.left:active, .right:active {
			background-color: #fff;
			color: #0c8e7e;
		}
		.featured-head {

		}
	</style>
	<script type="text/javascript">
		//close popps
		function popupClose(event) {
			event.parentNode.classList.add('fadeOut');
			setTimeout(function() {
				event.parentNode.style.display = "none";
			}, 800);
		}
		
		//switch to chosen request
		function runQuery(action, string) {
			switch(action) {
				case 'search':
					//process if user selected to search for products
					var term = document.getElementById('search-bar').value; //get value from search input
					if(term=='') { //if value empty, stop processing
						alert('Please type something to search');
						return false;
					}
					var param = "?search="+term; //prepare query string url
					doActionAjax(param); //call to Ajax function and pass query string as parameter
				break;
				case 'filter':
					//run process if user selected to filter products by categories
					var param = "?filterby="+string;
					doActionAjax(param);
				break
			}
		}
		//run Ajax call to fetch data
		function doActionAjax(param) {
			var queryString = param;
			var xhr;
			xhr = new XMLHttpRequest(); //create xmlhttprequest object
			document.getElementById('results').innerHTML = "<span class='loader'>Please wait...</span>";
			xhr.open("GET", "router.php"+queryString, true); //open url, pass queryString to the requested url
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById('results').innerHTML = xhr.responseText; //display results
				}
			}
			xhr.send(); //finally send query
		}

		//open popup with product image
		function itemView(event) {
			var source = event.getAttribute('src');
			var popWin = document.getElementById('popup');
			popWin.style.display = "block";
			popWin.innerHTML = "<div><img src='"+source+"' class='item-view'/><span class='item-viewClose' onclick='closeItemView(this)'>&times;</span></div>";
		}
		//close popup
		function closeItemView(event) {
			event.parentNode.parentNode.style.display = "none";
		}
	</script>
</head>
<body>
	<nav class="navbar">
		<li><a href="index.php" class="brand"><img src="images/logo.png" width="65px"></a></li> <!-- HEALTHY MOVES -->
		<li><a href="index.php">Healthy Moves Online Store</a></li>
		<li>
			<input type="search" name="seach" id="search-bar" class="search-bar" onkeyup="runQuery('search', null)" placeholder="type to search...">
			<button type="button" name="go" class="btn-search" onclick="runQuery('search', null)">Go</button>
		</li>
		<li><a href="cart.php"><i class="fa fa-cart-arrow-down"></i> Cart<span class="cart-count"><?php (isset($_SESSION['cart'])) ? print count($_SESSION['cart']) : print 0; ?></span></a>
		</li>
		<li><a href="aboutus.php"><i class="fa fa-info-circle"></i> About Us</a></li>
		<li><a href="contactus.php"><i class="fa fa-envelope-o"></i> Contact Us</a></li>
		<?php if(isset($_SESSION['customer']['token'])) : ?>
			<li><a href="account/"><i class="fa fa-user"></i> My Account</a></li>
		<?php else: ?>
			<li><a href="account/login.php"><i class="fa fa-lock"></i> Login/Signup</a></li>
		<?php endif; ?>
	</nav>

	<div class="container-menu">
		<div class="menu-heading">Categories</div>
		<?php if($categories != false) : ?>
			<a href="shop.php"><div class="menu-item">All Categories <span class="pointer">&gt;</span></div></a>
		<?php foreach($categories as $k => $v) : ?>
			<a href="javascript:runQuery('filter', <?php echo $v->id; ?>)"><div class="menu-item"><?php echo $v->category_name; ?> <span class="pointer">&gt;</span></div></a>
		<?php endforeach; ?>
		<?php else: ?>
			<div class="menu-item">Sorry No Cateogries Available</div>
		<?php endif; ?>
	</div>

	<div class="container-item" id="results">
		<div id="popup"></div>
		<?php
			$action = (isset($_GET['action'])) ? $_GET['action'] : '';
			switch ($action) {
				case 'added':
					echo '<div class="popup-message success">New Item added to cart!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
					break;
				case 'exists':
					echo '<div class="popup-message error">Item already added to cart!<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
					break;
				case 'removed':
					echo '<div class="popup-message success">Item removed from cart<span class="popup-close" onclick="popupClose(this)">&times;</span></div>';
					break;
			}
		?>

		<div class="featured-item">
			<h3 class="featured-head">Featured Items</h3>
			<?php
				//Featured Items
				$allfeatured = $product->getAllProducts();
				shuffle($allfeatured);
				
				if($allfeatured != false) : ?>
				 	<div class='slides left' onclick='getSlideIndex(-1)'><i class='fa fa-chevron-left'></i></div>
				 	<div class='slides right' onclick='getSlideIndex(+1)'><i class='fa fa-chevron-right'></i></div>
				 <?php
				for ($i = 0; $i < 10; $i++) : 
					$img = $product->getProductImage($allfeatured[$i]->id); //get image for each product by passing productID as parameter
			?>
				<center>
					<div class="list-item slider">
						<div class="list-item-heading"><?php echo $product->wrapText($allfeatured[$i]->product_name); ?></div>
						<div><img src="images/products/<?php echo $img->image_url; ?>" class="list-item-image" onclick="itemView(this)"/></div>
						<div class="list-item-price">R<?php echo number_format($allfeatured[$i]->price, 2); ?></div>
						<form action="cart.php" method="POST" enctype="application/x-www-urlencoded">
							<input type="hidden" name="product_id" value="<?php echo $allfeatured[$i]->id; ?>">
							<input type="hidden" name="product_name" value="<?php echo $allfeatured[$i]->product_name; ?>">
							<input type="hidden" name="product_price" value="<?php echo $allfeatured[$i]->price; ?>">
							<div><input type="number" name="product_quantity" min="1" max="10" value="1"></div>
							<div><button type="submit" name="action" value="addtocart" class="btn-add">AddToCart</button></div>
						</form>
					</div>
				</center>
			<?php
					endfor;
				else:
			?>
					<div class='popup-message error'><center><strong>No featured items today!</strong></center></div>
			<?php
				endif;
			?>
		</div>
		
		<?php
			if($categories != false) { //check if there are categories available
				foreach ($categories as $row) : //get all available categories
				$counter = 0; //initialize value of counter to zero(0)
			?>
					<h2 class="cat-heading"><?php echo $row->category_name; ?></h2>
			<?php
					$productbyCat = $product->getProductsByCategory($row->id); //get all products specified by category
					if($productbyCat != false) : //check if products listed under each category exists
						foreach($productbyCat as $data) : //call method to get all products
						$counter++; //increment counter by one(1) foreachLoop
						$img = $product->getProductImage($data->id); //get image for each product by passing productID as parameter
			?>
							<div class="list-item">
								<div class="list-item-heading"><?php echo $product->wrapText($data->product_name); ?></div>
								<div><img src="images/products/<?php echo $img->image_url; ?>" class="list-item-image" onclick="itemView(this)"/></div>
								<div class="list-item-price">R<?php echo number_format($data->price, 2); ?></div>

								<form action="cart.php" method="POST" enctype="application/x-www-urlencoded">
									<input type="hidden" name="product_id" value="<?php echo $data->id; ?>">
									<input type="hidden" name="product_name" value="<?php echo $data->product_name; ?>">
									<input type="hidden" name="product_price" value="<?php echo $data->price; ?>">
									<div><input type="number" name="product_quantity" min="1" max="10" value="1"></div>
									<div><button type="submit" name="action" value="addtocart" class="btn-add">AddToCart</button></div>
								</form>

							</div>
			<?php 		if($counter==4) { break; } //stop counter after displaying four(4) products per category
						endforeach;
					else :
						echo "<p class='error-message'>No product available in {$row->category_name} category!</p>"; //display message if no products under category
					endif;
				endforeach;
			}
			else {
				echo "<p class='error-message'>No categories available!</p>"; //display message if no categories
			}
		?>

	</div>
	<script type="text/javascript">
		/*
		* Slide controller JS script
		*/
		var slideIndex = 1;

		function $_(objName) {
			return document.getElementsByClassName(objName);
		}


		function getSlideIndex(n) {
			// slideIndex = slideIndex + n;
			showSlide(slideIndex += n);
		}

		function showSlide(n) {
			var slide = $_("slider");
			if(n > slide.length) {
				slideIndex = 1;
			}
			if(n < 1) {
				slideIndex = slide.length;
			}
			for(var i = 0; i < slide.length; i++) {
				slide[i].style.display = "none";
			}
			/*for(let i in slide) {
				slide[i].style.display = "none";
			}*/
			slide[slideIndex-1].style.display = "block";
		}
		showSlide(slideIndex);

		function autoSlide() {
			var slideObj = $_("slider");
			for (var i = 0; i < slideObj.length; i++) {
				slideObj[i].style.display = "none";
			}
			/*for(let i in slideObj) {
				slideObj[i].style.display = "none";
			}*/
			if(slideIndex > slideObj.length) { slideIndex = 1; }
			slideObj[slideIndex-1].style.display = "block";
			slideIndex++;
			setTimeout(autoSlide, 6000);
		}
		autoSlide(); //start auto slide
	</script>
</body>
</html>