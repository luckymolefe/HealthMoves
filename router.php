<?php
	//site root controller
	require_once('model/order_model.php');
	require_once('model/customer_model.php');

	if(isset($_GET['search'])) {
		$sanitize = array('search' => $_GET['search']);
		$params = $product->sanitize($sanitize);
		$response = $product->searchProducts($params);
		?>
		<h1 class="term-head">Searched for: <span class="search-string"><?php echo $params['search']; ?></span></h1>
		<?php
		if($response != false) {
			foreach($response as $row) :
				$category = $product->getCategoryName($row->category_id);
			?>
				<div class="search-item">
					<span><a href="javascript:runQuery('filter', <?php echo $row->category_id; ?>)"  class="search-item-title"><?php echo $row->product_name; ?></a></span><br>
					<span class="search-item-cat"><?php echo $category->category_name; ?></span>
				</div>
			<?php
			endforeach;
		}
		else {
			?>
			<div class="search-item">
				<div class="search-message">Sorry no match found!</div>
			</div>
			<?php
		}
	}

	if(isset($_GET['filterby'])) {
		$sanitize = array('category_id' => $_GET['filterby']); //get parameter passed
		$params = $product->sanitize($sanitize); //clean data
		$rows = $product->getProductsByCategory($params['category_id']); //get products data from specific category
		$cat = $product->getCategoryName($params['category_id']); //get categoryName by matching categoryID
		?>
			<h2 class="cat-heading"><?php echo $cat->category_name; ?></h2>
		<?php
		if($rows != false) : //check to see if products available under specified category
			foreach($rows as $row) :
				$img = $product->getProductImage($row->id); //get image for each product by passing productID as parameter
		?>
				<div class="list-item">
					<div class="list-item-heading"><?php echo $product->wrapText($row->product_name); ?></div>
					<div><img src="images/products/<?php echo $img->image_url; ?>" class="list-item-image" onclick="itemView(this)"/></div>
					<div class="list-item-price">R<?php echo number_format($row->price, 2); ?></div>
					<form action="cart.php?action=addtocart&pid=<?php echo $row->id; ?>" method="POST" enctype="application/x-www-urlencoded">
						<input type="hidden" name="product_name" value="<?php echo $row->product_name; ?>">
						<input type="hidden" name="product_price" value="<?php echo $row->price; ?>">
						<div><input type="number" name="product_quantity" min="1" max="10" value="1"></div>
						<div><button type="submit" class="btn-add">AddToCart</button></div>
					</form>
				</div>
		<?php
			endforeach;
		else :
			echo "<p class='error-message'>No product available in the selected category!</p>"; //display message if no products under category
		endif;
	}

	//On customer final checkout making payment of items in Cart.
	if(isset($_REQUEST['cart_checkout'])) {

		$termsAgreement = (isset($_POST['terms'])) ? $_POST['terms'] : '';
		if(empty($termsAgreement)) {
			header("Location: checkout.php?action=agreeterms");
			exit();
		}
		$sanitize = array('uid' => (int)base64_decode($_POST['customer_id']),
						  'quantity' => (int)$_POST['quantity'],
						  'total' => (float)$_POST['totalpay'],
						  'paytype' => $_POST['pay_method'],
						  'orderId' => (int)$_POST['orderNum']
						);
		if(array_search(null, $sanitize)) { //check if array element has no empty values
			header("Location: checkout.php?action=null");
			exit();
		}
		$params = $customer->sanitize($sanitize);
		if($order->createOrder($params)) {
			//create customer invoice
			$dirpath = "account/invoices/";
			$arrItems = array('orderid'=>$_POST['orderNum']);
			if(!is_dir($dirpath)) {
				mkdir($dirpath); //create directory if not exists
			}
			//read cart items
			for ($i=0; $i < count($_SESSION['cart']); $i++) {
				$arrItems['description'] = $_SESSION['cart'][$i]['item_name'];
				$arrItems['quantity'] = $_SESSION['cart'][$i]['item_quantity'];
				$arrItems['price'] = $_SESSION['cart'][$i]['item_price'];
			}
			$json_invoice_data = json_encode($arrItems);
			$filename = SHA1(base64_decode($_POST['customer_id'])).'.json';
			try {
				$fp = fopen($dirpath.$filename, 'w+');
				fwrite($fp, $json_invoice_data);
				fclose($fp);
			}
			catch (Exception $e) {
				echo "Error: ".$e->getMessage();	
			}
			header('Content-type: application/json'); //set application header for JSON files
			//reset order number and empty cart
			unset($_SESSION['cart']);
			unset($_SESSION['customer']['orderNum']);
			header("Location: invoice.php");
			exit();
		}
		else {
			header("Location: checkout.php?action=failed");
			exit();
		}
	}
	//on customer selecting credit card from list
	if(isset($_GET['selectedcard'])) {
		$cardNum = $_GET['card_number'];
		$row = $customer->readSingleCard($cardNum);
		if($row != false) {
			$row->card_number = str_repeat('*', strlen($row->card_number)-4).substr_replace($row->card_number, '', 0,strlen($row->card_number)-4);
			$response['message'] = "success";
			$response['cardnum'] = $row->card_number;
			$response['exp_date'] = $row->exp_month.'/'.$row->exp_year;
			$response['card_value'] = $row->card_value;
			$response['card_type'] = $row->card_type;
			// $response['exp_year'] = $row->exp_year;
		}
		else {
			$response['message'] = "failed";
		}
		echo json_encode($response);
		exit();
	}
	//controls activated when users send Message using Contact Us Form
	if(isset($_POST['send']) && $_SERVER['REQUEST_METHOD'] == "POST") {
		array_pop($_POST); //remove the last array element, which is the event send button
		if(!array_search(null, $_POST)) {
			$params = $customer->sanitize($_POST);
			if($customer->contactForm($params)) {
				header("Location: contactus.php?action=success");
				exit();
			}
			else {
				header("Location: contactus.php?action=failed");
				exit();
			}
		}
		else {
			header("Location: contactus.php?action=null");
			exit();
		}
	}

?>