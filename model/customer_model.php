<?php
	//Customer Model
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/'.basename(dirname(__DIR__));
	if( array_search('connection.php', scandir($basepath.'/config/')) ) {
		require_once($basepath.'/config/connection.php');
		require_once('helper_model.php');
	} else { echo "Failed to load: <strong>/config/connection.php</strong>"; }
	
	/**
	 * 
	 */
	class Customer extends Helper {
		private $conn = null;
		private $email = null;
		private $password = null;
		
		public function __construct() {
			global $conn;
			$this->conn = $conn;
		}

		public function page_protected() {
			if(!isset($_SESSION['customer']['token'])) {
				header("Location: login.php");
				exit();
			}
		}

		public function login($params) {
			$this->email = $params['email'];
			$this->password = $params['password'];
			$stmt = $this->conn->prepare("SELECT id, email, password FROM customers WHERE email = ? AND password = ?");
			$stmt->bindValue(1, $this->email, PDO::PARAM_STR);
			$stmt->bindValue(2, $this->hash_data($this->password), PDO::PARAM_STR);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_SESSION['customer']['token'] = $this->hash_data($this->email.rand(1000,10000)); //create a session token
				$_SESSION['customer']['uid'] = $row['id']; //hold customer id in a session to be used later
				return true;
			}
			else {
				return false;
			}
		}

		public function logout() {
			// $_SESSION['auth']['sessCustomerID'] = base64_decode($_SESSION['auth']['sessCustomerID']);
			unset($_SESSION['customer']['token']); //unset session token
			unset($_SESSION['customer']['uid']); //unset session userId
			unset($_SESSION['customer']['orderNum']); //unset session Order Number
			#session_destroy(); //destroy session
			return true;
		}

		public function register($params) {
			if($this->verifyCustomer($params['email'])) { //if customer account already exists, do not add a duplicate account
				return false;
			}
			$stmt = $this->conn->prepare("INSERT INTO customers (firstname, lastname, email, password) VALUES (?, ?, ?, ?) ");
			$stmt->bindValue(1, $params['firstname'], PDO::PARAM_STR);
			$stmt->bindValue(2, $params['lastname'], PDO::PARAM_STR);
			// $stmt->bindValue(3, $params['phone'], PDO::PARAM_STR);
			$stmt->bindValue(3, $params['email'], PDO::PARAM_STR);
			$stmt->bindValue(4, $this->hash_data($params['password']), PDO::PARAM_STR);
			try {
				$this->conn->beginTransaction();
				$registered = $stmt->execute();
				$this->conn->commit();
				if($registered) {
					return true;
				}
				 else {
				 	return false;
				 }
			}
			catch(PDOException $e) {
				$this->conn->rollBack();
				echo "ERROR: ".$e->getMessage();
			}
		}
		//
		public function getCustomer($uid) {
			$stmt = $this->conn->prepare("SELECT *, CONCAT(firstname,' ',lastname) AS fullname FROM customers WHERE id = ?");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}
		//check if customer has a registered account
		public function verifyCustomer($email) {
			$this->email = $email;
			$stmt = $this->conn->prepare("SELECT id, email FROM customers WHERE email = ?");
			$stmt->bindValue(1, $this->email);
			$stmt->execute();
			if($stmt->rowCount() > 0 ) {
				return true;
			}
			else {
				return false;
			}
		}
		//
		public function updateAccount($params) {
			$stmt = $this->conn->prepare("UPDATE customers SET firstname = ?, lastname = ?, phone = ?, email = ?, address = ? WHERE id = ?");
			$stmt->bindValue(1, $params['firstname'], PDO::PARAM_STR);
			$stmt->bindValue(2, $params['lastname'], PDO::PARAM_STR);
			$stmt->bindValue(3, $params['phone'], PDO::PARAM_STR);
			$stmt->bindValue(4, $params['email'], PDO::PARAM_STR);
			$stmt->bindValue(5, $params['address'], PDO::PARAM_STR);
			$stmt->bindValue(6, $params['uid'], PDO::PARAM_INT);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//
		public function updatePassword($params) {
			$stmt = $this->conn->prepare("UPDATE customers SET password = ? WHERE id = ?");
			$stmt->bindValue(1, $params['password'], PDO::PARAM_STR);
			$stmt->bindValue(7, $params['uid'], PDO::PARAM_INT);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//
		public function addCreditCard($params) {
			try{
				$this->conn->beginTransaction();
				$stmt = $this->conn->prepare("INSERT INTO payments (id, card_number, card_type, exp_month, exp_year, card_value, holder_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$stmt->bindValue(1, $params['uid']);
				$stmt->bindValue(2, $params['cardNumber']);//$this->data_encrypt(
				$stmt->bindValue(3, $params['cardtype']);
				$stmt->bindValue(4, $params['cardExpMonth']);
				$stmt->bindValue(5, $params['cardExpYear']);
				$stmt->bindValue(6, $params['cardValue']);
				$stmt->bindValue(7, $params['cardHolder']);
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
			}
		}

		public function getAllCards($uid) {
			$stmt = $this->conn->prepare("SELECT * FROM payments WHERE id = ?");
			$stmt->bindValue(1, $uid);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}

		public function readSingleCard($cardNum) {
			$stmt = $this->conn->prepare("SELECT * FROM payments WHERE card_number = ?");
			$stmt->bindValue(1, $cardNum); //$this->data_encrypt($cardNum)
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}

		public function updateCreditCard($params) {
			$stmt = $this->conn->prepare("UPDATE payments SET card_number = ?, card_type = ?, exp_month = ?, exp_year = ?, card_value = ?, holder_name = ? WHERE id = ? AND created = ?");
			$stmt->bindValue(1, $params['cardNumber']); //$this->data_encrypt(
			$stmt->bindValue(2, $params['cardtype']);
			$stmt->bindValue(3, $params['cardExpMonth']);
			$stmt->bindValue(4, $params['cardExpYear']);
			$stmt->bindValue(5, $params['cardValue']);
			$stmt->bindValue(6, $params['cardHolder']);
			$stmt->bindValue(7, $params['uid']);
			$stmt->bindValue(8, $params['timestamp']);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		public function removeCard($cardNum) {
			$stmt = $this->conn->prepare("DELETE FROM payments WHERE card_number = ?");
			$stmt->bindValue(1, $cardNum); //$this->data_encrypt($cardNum)
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		public function contactForm($params) {
			$stmt = $this->conn->prepare("INSERT INTO contact (name, email, cell_no, subject, message) VALUES (?, ?, ?, ?, ?)");
			$stmt->bindValue(1, $params['name']);
			$stmt->bindValue(2, $params['email']);
			$stmt->bindValue(3, $params['phone']);
			$stmt->bindValue(4, $params['subject']);
			$stmt->bindValue(5, nl2br($params['message']));
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

	}
	if(class_exists('Customer')) {
		$customer = new Customer();
	}
	
?>