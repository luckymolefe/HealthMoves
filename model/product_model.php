<?php
	//Products Model
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/'.basename(dirname(__DIR__));
	if( array_search('connection.php', scandir($basepath.'/config/')) ) {
		require_once($basepath.'/config/connection.php');
		require_once('helper_model.php');
	} else { echo "Failed to load: <strong>/config/connection.php</strong>"; }
	
	/**
	 * 
	 */
	class Products extends Helper {
		private $conn = null;
		
		public function __construct() {
			global $conn;
			$this->conn = $conn;
		}
		//Create / Add new product
		public function createProduct($params) {
			try {
				$this->conn->beginTransaction();
				$stmt = $this->conn->prepare("INSERT INTO products (product_name, price, description, category_id) VALUES (?, ?, ?, ?) ");
				$stmt->bindValue(1, $params['productName']);
				$stmt->bindValue(2, $params['price']);
				$stmt->bindValue(3, $params['description']);
				$stmt->bindValue(4, $params['category']);
				$response = $stmt->execute();
				if($response) {
					$this->conn->commit();
					$this->addProductImage($params['urlpath']); //call method add product image to images table
					return true;
				}
				else {
					return false;
				}
			}
			catch(PDOException $e) {
				$this->conn->rollBack();
				echo "Error: ".$e->getMessage();
			}
		}
		//update single product 
		public function updateProduct($params) {
			$stmt = $this->conn->prepare("UPDATE products SET product_name = ?, price = ?, category_id = ? WHERE id = ?");
			$stmt->bindValue(1, $params['productName']);
			$stmt->bindValue(2, $params['price']);
			$stmt->bindValue(3, $params['category']);
			$stmt->bindValue(4, $params['pid']);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//get All available products from table
		public function getAllProducts() {
			$stmt = $this->conn->prepare('SELECT * FROM products');
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//get all products by matching categoryID
		public function getProductsByCategory($cat_id) {
			$stmt = $this->conn->prepare('SELECT id, product_name, price, category_id FROM products WHERE category_id = ?'); //LIMIT 0, 4
			$stmt->bindValue(1, $cat_id);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//get single product by its matching ProductID
		public function readProduct($pid) {
			$stmt = $this->conn->prepare('SELECT * FROM products WHERE id = ?');
			$stmt->bindValue(1, $pid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//Insert new product image, this method is call automatically when adding new product
		private function addProductImage($urlpath) {
			try {
				$this->conn->beginTransaction();
				$stmt = $this->conn->prepare('INSERT INTO images (image_url) VALUES (?)');
				$stmt->bindValue(1, $urlpath);
				$response = $stmt->execute();
				if($response) {
					$this->conn->commit();
					return true;
				}
				else {
					return false;
				}
			}
			catch(PDOException $e) {
				$this->conn->rollBack();
				echo "Error: ".$e->getMessage();
			}
		}
		//get product image from images table, matching productID provided
		public function getProductImage($pid) {
			$stmt = $this->conn->prepare('SELECT * FROM images WHERE product_id = ?');
			$stmt->bindValue(1, $pid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//Create/Add new category
		public function addCategory($params) {
			// try {
				// self::$conn->beginTransaction();
				$stmt = $this->conn->prepare("INSERT INTO categories (category_name) VALUES (:catName)");
				$stmt->bindValue('catName', $params['categoryName']);
				$response = $stmt->execute();
				if($response) {
					// self::$conn->commit();
					return true;
				}
				else {
					return false;
				}
			/*}
			catch(PDOException $e) {
				self::$conn->rollBack();
				echo "Error: ".$e->getMessage();
			}*/
		}
		//
		public function updateCategory($params) {
			$stmt = $this->conn->prepare("UPDATE categories SET category_name = ? WHERE id = ?");
			$stmt->bindValue(1, $params['category_name']);
			$stmt->bindValue(2, $params['category_id']);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//get All available categories
		public function readAllCategories() {
			$stmt = $this->conn->prepare("SELECT * FROM categories");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}

		//Get single Category Name by matching CategoryID
		public function getCategoryName($cat_id) {
			$stmt = $this->conn->prepare('SELECT id, category_name FROM categories WHERE id = ?');
			$stmt->bindValue(1, $cat_id);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//Customers seaching products avaliable
		public function searchProducts($params) {
			$searchTerm = "%".strtolower($params['search'])."%";
			$stmt = $this->conn->prepare("SELECT id, product_name, price, category_id FROM products WHERE product_name LIKE ?");
			$stmt->bindValue(1, $searchTerm);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
	}

	if (class_exists('Products')) {
		$product = new Products();
	}


?>