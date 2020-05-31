<?php
	//Order Model
	require_once('product_model.php');
	/**
	 * 
	 */
	class Orders extends Products {
		private $conn = null;

		public function __construct() {
			global $conn;
			$this->conn = $conn;
		}

		public function createOrder($params) {
			try {
				$this->conn->beginTransaction();
				$stmt = $this->conn->prepare("INSERT INTO orders (customer_id, order_id, order_quantity, order_total, payment_type) VALUES (?, ?, ?, ?, ?)");
				$stmt->bindValue(1, $params['uid']);
				$stmt->bindValue(2, $params['orderId']);
				$stmt->bindValue(3, $params['quantity']);
				$stmt->bindValue(4, $params['total']);
				$stmt->bindValue(5, $params['paytype']);
				$response = $stmt->execute();
				if($response) {
					$this->conn->commit();
					//if customer used credit card for purchases, change orderStatus immediately after creating an order
					($params['paytype'] == "creditcard") ? $this->confirmOrder($params['orderId']) : '';
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

		public function retrieveOrders() {
			$stmt = $this->conn->prepare("SELECT * FROM orders ORDER BY created");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else  {
				return false;
			}
		}

		public function getAllOrders($uid) {
			$stmt = $this->conn->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY created DESC");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else  {
				return false;
			}
		}

		public function readOrder($orderId) {
			$stmt = $this->conn->prepare("SELECT * FROM orders WHERE order_id = ?");
			$stmt->bindValue(1, $orderId);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			} else {
				return false;
			}
		}

		public function confirmOrder($orderId) {
			$orderStatus = 1;
			$stmt = $this->conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
			$stmt->bindValue(1, $orderStatus);
			$stmt->bindValue(2, $orderId);
			if($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}

		public function generateOrderNumber() {
			return rand(1000, 99000);
		}

	}
	if(class_exists('Orders')) {
		$order = new Orders();
	}

	/*$params = array('uid'=>1,'orderId'=>12345,'quantity'=>3,'total'=>'110.50', 'paytype'=>'deposit');
	if($order->createOrder($params)) {
		echo "data saved";
	} else {
		echo "failed to save data";
	}*/
?>